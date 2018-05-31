<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Redirect, Input, Auth, Hash, Session, URL, Mail, Config;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\UserMeta;
use App\Post;
use App\PostMeta;
use App\Setting;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    protected $user;
    protected $usermeta;
    protected $post;
    protected $postmeta;
    protected $setting;


  public function __construct(User $user, UserMeta $usermeta, Post $post, PostMeta $postmeta, Setting $setting)
    {
        $this->user     = $user;
        $this->usermeta = $usermeta;
        $this->post     = $post;
        $this->postmeta = $postmeta;
        $this->setting  = $setting;

        $this->middleware(function ($request, $next) {
            $this->user_id = Auth::user()->id;
            return $next($request);
        });
    }

    //--------------------------------------------------------------------------

    public function index()
    {
        parse_str( query_vars(), $search );

        $queries = array('job_type', 'position', 'department', 'gender', 'civil_status');
        $selects = array();
        foreach(Input::all() as $input_k => $input_v) {            
            if($input_v) {
                if( in_array($input_k, $selects) ) {
                   $queries[] = $input_k;
                }                
            }
        }

        $search['group'] = 'employee';

        $data['rows'] = $this->user
                             ->search($search, $selects, $queries)
                             ->orderBy(Input::get('sort', 'fullname'), Input::get('order', 'DESC'))
                             ->paginate(Input::get('rows', 15));

        $data['count'] = $this->user
                              ->search($search)
                              ->count();

        $data['all'] = $this->user->where('group', 'employee')->count();

        $data['trashed'] = $this->user->withTrashed()
                                      ->where('group', 'employee')
                                      ->where('deleted_at', '<>', '0000-00-00')
                                      ->count();

        $data['post'] = $this->post;

        return view('app.employees.index', $data);
    }

    //--------------------------------------------------------------------------

    public function add()
    {
        if( Input::get('_token') ) {
            $rules = [
                'firstname'    => 'required|max:25',
                'lastname'     => 'required|max:25',
                'gender'       => 'required',
                'birth_date'   => 'required',
                'civil_status' => 'required',
                'department'   => 'required',
                'position'     => 'required',
                'lastname'     => 'required',
                'job_type'     => 'required',
                'monthly_rate' => 'required',
                'daily_rate'   => 'required',
                'hourly_rate'  => 'required',
            ];    

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.employees.add')
                               ->withErrors($validator)
                               ->withInput(); 
            }
            
            $inputs = Input::all();

            $user = $this->user;

            $user->fill( $inputs );   

            $user->group    = 'employee';  
            $user->status   = 'actived';
            $user->fullname = Input::get('firstname').' '.Input::get('lastname');

            if( $user->save() ) {
                
                $id = $user->id;

                $unsets = User::$unsets;

                foreach ($unsets as $unset) {
                    unset($inputs[$unset]);
                }

                if( Input::hasFile('file') ) {
                    $pic = upload_image(Input::file('file'), 'uploads/images/employees/'.$id, '');
                    $inputs['profile_picture'] = $pic;
                }   

                $dep =  count($inputs['dependents']);
                $inputs['tax_name'] = tax_exemption($inputs['civil_status'], $dep);
                $inputs['tax_code'] = tax_exemption($inputs['civil_status'], $dep, true);

                foreach ($inputs as $meta_key => $meta_val) {
                    $this->usermeta->update_meta($id, $meta_key, array_to_json($meta_val));
                }
       

                return Redirect::route('app.employees.edit', $id)
                               ->with('success','New employee has been added!');
            } 
        }


        $data['post'] = $this->post;

        return view('app.employees.add', $data);
    }

    //--------------------------------------------------------------------------

    public function edit($id='')
    {

        $data['info'] = $info = $this->user->find( $id);
        foreach ($info->usermetas as $usermeta) {
            $data['info'][$usermeta->meta_key] = $usermeta->meta_value;
        }

        $data['post'] = $this->post;

        if( Input::get('_token') )
        {
            $rules = [
                // 'email'        => 'required|email|max:64|unique:users,email,'.$id.',id',
                'firstname'    => 'required|max:25',
                'lastname'     => 'required|max:25',
            ];   

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.employees.edit', $id)
                               ->withErrors($validator)
                               ->withInput(); 
            }

            $user = $this->user->find( $id );

            $inputs = Input::all();

            $user->fill( $inputs );   

            $user->updated_at = date('Y-m-d H:i:s');
            $user->status     = Input::get('status', 'inactived');
            $user->fullname   = Input::get('firstname').' '.Input::get('lastname');

            if( Input::hasFile('file') ) {
                $pic = upload_image(Input::file('file'), 'uploads/images/employees/'.$id, $data['info']->profile_picture);
                $inputs['profile_picture'] = $pic;
            }            
                                
            if( $user->save() ) {

                $unsets = User::$unsets;

                foreach ($unsets as $unset) {
                    unset($inputs[$unset]);
                }

                foreach ($inputs as $meta_key => $meta_val) {
                    $this->usermeta->update_meta($id, $meta_key, array_to_json($meta_val) );
                }

                return Redirect::route('app.employees.edit', $id)
                               ->with('success','Employee has been updated!');
            } 
        }

        return view('app.employees.edit', $data);
    }

    //--------------------------------------------------------------------------
  
    public function delete($id)
    {
        $this->user->findOrFail($id)->delete();
        return Redirect::route('app.employees.index', query_vars())
                       ->with('success','Selected employee has been move to trashed!');
    }

    //--------------------------------------------------------------------------

    public function restore($id)
    {   
        $user = $this->user->withTrashed()->findOrFail($id);
        $user->restore();
        return Redirect::route('app.employees.index', ['type' => 'trash'])
                       ->with('success','Selected employee has been restored!');
    }

    //--------------------------------------------------------------------------

  
    public function destroy($id)
    {   
        $this->usermeta->where('user_id', $id)->delete();
        $user = $this->user->withTrashed()->find($id);
        $user->forceDelete();

        /* Remove directory and files */
        $dirname = 'uploads/images/employees/'.$id;
        array_map('unlink', glob("$dirname/*.*"));
        rmdir($dirname);

        return Redirect::route('app.employees.index', ['type' => 'trash'])
                       ->with('success','Selected employee has been deleted permanently!');
    }

    //--------------------------------------------------------------------------

    public function ajax_update() 
    {
        $inputs = Input::all();

        $id = Input::get('id');

        if( Input::get('_token') )
        {

            $data['info'] = $info = $this->user->find( $id );
            foreach ($info->usermetas as $usermeta) {
                $data['info'][$usermeta->meta_key] = $usermeta->meta_value;
            }

            $user = $this->user->find( $id );

            $user->fill( $inputs );   

            $user->updated_at = date('Y-m-d H:i:s');
            $user->status     = Input::get('status', 'inactived');
            $user->fullname   = Input::get('firstname').' '.Input::get('lastname');

            if( Input::hasFile('file') ) {
                $pic = upload_image(Input::file('file'), 'uploads/images/employees/'.$id, $data['info']->profile_picture);
                $inputs['profile_picture'] = $pic;
            }         

            if( $user->save() ) {

                $unsets = User::$unsets;

                foreach ($unsets as $unset) {
                    unset($inputs[$unset]);
                }

                foreach ($inputs as $meta_key => $meta_val) {
                    $this->usermeta->update_meta($id, $meta_key, array_to_json($meta_val) );
                }
            } 
        }

        $data['info'] = $info = $this->user->find( $id );
        foreach ($info->usermetas as $usermeta) {
            $data['info'][$usermeta->meta_key] = $usermeta->meta_value;
        }

        $data['post'] = $this->post;

        return view('app.employees.tabs.details', $data);
    }

    //--------------------------------------------------------------------------

}
