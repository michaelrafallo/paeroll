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

class LeaveManagerController extends Controller
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

        $data['rows'] = $this->post
                             ->search($search)
                             ->where('post_type', 'leave-history')
                             ->orderBy('id', 'DESC')
                             ->paginate(15);

        $data['count'] = $this->post
                              ->search($search)
                              ->where('post_type', 'leave-history')
                              ->count();

        $data['all'] = $this->post->where('post_type', 'leave-history')->count();

        $data['trashed'] = $this->post->withTrashed()
                                      ->where('post_type', 'leave-history')
                                      ->where('deleted_at', '<>', '0000-00-00')
                                      ->count();

        return view('app.leaves-manager.index', $data);
    }

    //--------------------------------------------------------------------------

    public function file()
    {
        if( Input::get('_token') )
        {
            $requests = Input::get('requests');

            foreach ($requests as $request) {

                $post = new Post();

                $post->post_author  = $this->user_id;
                $post->post_name    = $request['employee'];
                $post->post_title   = $this->post->find($request['leave'])->post_title;
                $post->post_content = json_encode( $request );                
                $post->post_type    = 'leave-history';
                $post->post_status  = 'requested';
                $post->updated_at   = date('Y-m-d H:i:s');

                if( $post->save() ) {
                    $leave_days = get_days_diff($request['date_start'], $request['date_end']);
                    $request['days'] = $leave_days;

                    foreach ($request as $meta_key => $meta_val) {
                        $this->postmeta->update_meta($post->id, $meta_key, $meta_val);
                    }
                }             
            }

            return Redirect::route('app.leaves.manager.index')
                           ->with('success','New leave request has been added!');

        }

        $data['post'] = $this->post;
        $data['employees'] = $this->user->select_employees();

        return view('app.leaves-manager.add', $data);
    }

    //--------------------------------------------------------------------------

    public function edit($id='')
    {
        $data['info'] = $info = $this->post->find( $id );
        foreach ($info->postmetas as $postmeta) {
            $data['info'][$postmeta->meta_key] = $postmeta->meta_value;
        }

        if( Input::get('_token') )
        {
            $rules = [
                'employee'    => 'required',
                'leave'       => 'required',
                'status'      => 'required',
                'date_start'  => 'required',
                'date_end'    => 'required',
            ];    

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.leaves.manager.edit', $id)
                               ->withErrors($validator)
                               ->withInput(); 
            }

            $inputs = Input::all();
            
            $status = Input::get('status');

            unset($inputs['_token']);
            unset($inputs['status']);

            $leave_days = get_days_diff($inputs['date_start'], $inputs['date_end']);

            $post = $this->post->find( $id );

            $current_status = $post->post_status;

            $post->post_author  = $this->user_id;
            $post->post_name    = $employee    = $inputs['employee'];
            $post->post_title   = $leave_title = $this->post->find($inputs['leave'])->post_title;
            $post->post_content = json_encode( $inputs );                
            $post->post_type    = 'leave-history';
            $post->post_status  = $status;
            $post->updated_at   = date('Y-m-d H:i:s');

            if( $post->save() ) {

                $inputs['days'] = $leave_days;

                /* START Manage Leave */
                $leave_name = str_replace(' ', '_', strtolower($leave_title));
                $balance = $this->usermeta->get_meta($employee, $leave_name);

                // Deduct leave balance
                if( $current_status != 'approved' && $status == 'approved' ) {
                    $leave_balance = $balance - $leave_days;
                    $this->usermeta->update_meta($employee, $leave_name, $leave_balance);                
                }

                // Return Leave Balance
                if( $current_status == 'approved' && $status != 'approved' ) {
                    $leave_balance = $balance + $leave_days;
                    $this->usermeta->update_meta($employee, $leave_name, $leave_balance);                
                }
                /* LEAVE Manage Leave */

                $inputs['leave_code'] = $this->post->find($inputs['leave'])->post_name;
                $inputs['balance']    = $this->usermeta->get_meta($employee, $leave_name);

                foreach ($inputs as $meta_key => $meta_val) {
                    $this->postmeta->update_meta($id, $meta_key, $meta_val);
                }

                return Redirect::route('app.leaves.manager.edit', $id)
                               ->with('success','Leave has been updated!');
            } 
        }

        $data['post'] = $this->post;
        $data['employees'] = $this->user->select_employees();

        return view('app.leaves-manager.edit', $data);
    }

    //--------------------------------------------------------------------------

    public function delete($id)
    {
        $this->post->findOrFail($id)->delete();
        return Redirect::route('app.leaves.manager.index', query_vars())
                       ->with('success','Selected leave has been move to trashed!');
    }

    //--------------------------------------------------------------------------

    public function restore($id)
    {   
        $post = $this->post->withTrashed()->findOrFail($id);
        $post->restore();
        return Redirect::route('app.leaves.manager.index', ['type' => 'trash'])
                       ->with('success','Selected leave has been restored!');
    }

    //--------------------------------------------------------------------------

  
    public function destroy($id)
    {   
        $this->postmeta->where('post_id', $id)->delete();
        $post = $this->post->withTrashed()->find($id);
        $post->forceDelete();

        return Redirect::route('app.leaves.manager.index', ['type' => 'trash'])
                       ->with('success','Selected leave has been deleted permanently!');
    }

    //--------------------------------------------------------------------------
    
}
