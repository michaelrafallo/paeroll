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

class DeductionController extends Controller
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

        $post_types = ['government-deduction', 'deduction'];

        $data['rows'] = $this->post
                             ->search($search)
                             ->whereIn('post_type', $post_types)
                             ->orderBy('id', 'DESC')
                             ->paginate(15);

        $data['count'] = $this->post
                              ->search($search)
                              ->whereIn('post_type', $post_types)
                              ->count();

        $data['all'] = $this->post->whereIn('post_type', $post_types)->count();

        $data['trashed'] = $this->post
                                ->withTrashed()
                                ->whereIn('post_type', $post_types)
                                ->where('deleted_at', '<>', '0000-00-00')
                                ->count();

        $data['post'] = $this->post;                                     

        return view('app.deductions.index', $data);
    }

    //--------------------------------------------------------------------------

    public function add()
    {

        if( Input::get('_token') )
        {
            $rules = [
                'name' => 'required',
            ];    

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.deductions.add')
                               ->withErrors($validator)
                               ->withInput(); 
            }

            $post = $this->post;

            $post->post_author  = $this->user_id;
            $post->post_title   = Input::get('name');
            
            if( $desc = Input::get('description') ) {
                $post->post_content = $desc;                
            }

            $post->post_type    = Input::get('government_deduction') ? 'government-deduction' : 'deduction';
            $post->post_status  = 'actived';

            if( $post->save() ) {

                $id = $post->id;

                $this->postmeta->update_meta($id, 'tax_table', Input::get('tax_table', 0));
                $this->postmeta->update_meta($id, 'percentage', Input::get('percentage', 0));

                return Redirect::route('app.deductions.edit', $id)
                               ->with('success','New deduction has been added!');
            } 
        }

        return view('app.deductions.add');
    }

    //--------------------------------------------------------------------------

    public function edit($id='')
    {

        $data['info'] = $info = $this->post->find($id);
        foreach ($info->postmetas as $postmeta) {
            $data['info'][$postmeta->meta_key] = $postmeta->meta_value;
        }

        if( Input::get('_token') )
        {
            $rules = [
                'name' => 'required',
            ];    

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.deductions.edit', $id)
                               ->withErrors($validator)
                               ->withInput(); 
            }

            $post = $this->post->find($id);

            $post->post_author  = $this->user_id;
            $post->post_title   = Input::get('name');
            $post->post_content = Input::get('description');
            $post->post_status  = Input::get('status', 'inactived');
            $post->updated_at   = date('Y-m-d H:i:s');
            $post->post_type    = Input::get('government_deduction') ? 'government-deduction' : 'deduction';

            if( $post->save() ) {

                $id = $post->id;

                $this->postmeta->update_meta($id, 'tax_table', Input::get('tax_table', 0));
                $this->postmeta->update_meta($id, 'percentage', Input::get('percentage', 0));

                return Redirect::route('app.deductions.edit', $id)
                               ->with('success','Deduction has been updated!');
            } 
        }

        return view('app.deductions.edit', $data);
    }

    //--------------------------------------------------------------------------

    public function table($id)
    {
        $data['info'] = $info = $this->post->find($id);

        $gid = Input::get('gid', 0);
        
        $data['table'] = $table = $this->post->find( $gid );
        
        $data['percentage'] = $this->postmeta->get_meta($id, 'percentage');

        if( $gid ) {
            foreach ($table->postmetas as $postmeta) {
                $data['table'][$postmeta->meta_key] = $postmeta->meta_value;
            }            
        }

        parse_str( query_vars(), $search );

        $data['rows'] = $this->post
                             ->where('parent', $id)
                             ->orderBy('id', 'ASC')
                             ->get();

        if( Input::get('_token') )
        {
            $rules = [
                'salary_range_from' => 'required|numeric',
                'employee_share'    => 'required|numeric',
                'employer_share'    => 'required|numeric',
            ];    

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.deductions.table', [$id, query_vars()])
                               ->withErrors($validator)
                               ->withInput(); 
            }

            $inputs = Input::all();

            unset($inputs['_token']);
            unset($inputs['order']);

            $post = $this->post->find( $gid );

            if( ! $post ) {
                $post = $this->post;
            }

            $post->post_author  = $this->user_id;
            $post->post_type    = 'deduction-table';
            $post->post_order   = Input::get('order');
            $post->post_content = json_encode($inputs);
            $post->post_status  = 'actived';
            $post->parent       = $id;
            $post->updated_at   = date('Y-m-d H:i:s');

            if( $post->save() ) {

                $inputs['total']      = $inputs['employee_share'] + $inputs['employer_share'];
                $inputs['percentage'] = Input::get('percentage', 0);

                foreach ($inputs as $meta_key => $meta_val) {
                    $this->postmeta->update_meta($post->id, $meta_key, array_to_json($meta_val) );
                }

                return Redirect::route('app.deductions.table', [$id, query_vars()])
                               ->with('success', $info->post_title.' table has been updated!');
            } 
        }

        return view('app.deductions.table', $data);
    }

    //--------------------------------------------------------------------------

    public function delete($id)
    {
        $this->post->findOrFail($id)->delete();
        return Redirect::route('app.deductions.index', query_vars())
                       ->with('success','Selected deduction has been move to trashed!');
    }

    //--------------------------------------------------------------------------

    public function restore($id)
    {   
        $post = $this->post->withTrashed()->findOrFail($id);
        $post->restore();
        return Redirect::route('app.deductions.index', ['type' => 'trash'])
                       ->with('success','Selected deduction has been restored!');
    }

    //--------------------------------------------------------------------------
  
    public function destroy($id)
    {   
        $this->postmeta->where('post_id', $id)->delete(); 
        $post = $this->post->withTrashed()->find($id);
        $post->forceDelete();

        return Redirect::back()->with('success','selected row has been deleted permanently!');
    }

    //--------------------------------------------------------------------------
    
    public function calculator()
    {
        $salary = (int)Input::get('salary');

        if( $salary <= 0) return;

        $data = array();

        $search  = ['tax_table' => '0'];
        $queries = ['tax_table'];

        $taxes = $this->post
                     ->search($search, [], $queries)
                     ->where('post_type', 'government-deduction')
                     ->get();

        foreach ($taxes as $tax) {
            
            // percentage 

        $d = $this->post
                ->select('posts.*', 
                    'm1.meta_value as salary_range_from',
                    'm2.meta_value as salary_range_to',
                    'm3.meta_value as employee_share',
                    'm4.meta_value as employer_share'
                )
                ->from('posts')
                ->join('postmeta AS m1', function ($join) use ($salary) {
                    $join->on('posts.id', '=', 'm1.post_id')
                         ->where('m1.meta_key', '=', 'salary_range_from')
                         ->whereRaw('CAST(meta_value AS SIGNED) <= '. $salary);
                })
                ->join('postmeta AS m2', function ($join) use ($salary) {
                    $join->on('posts.id', '=', 'm2.post_id')
                         ->where('m2.meta_key', '=', 'salary_range_to')
                         ->where('m2.meta_value', '>=', $salary);
                })
                ->join('postmeta AS m3', function ($join) use ($search) {
                    $join->on('posts.id', '=', 'm3.post_id')
                         ->where('m3.meta_key', '=', 'employee_share');
                })
                ->join('postmeta AS m4', function ($join) use ($search) {
                    $join->on('posts.id', '=', 'm4.post_id')
                         ->where('m4.meta_key', '=', 'employer_share');
                })
                ->where('posts.parent', $tax->id)
                ->where('post_type', 'deduction-table')
                ->first();

            $employee_share = @$d->employee_share;
            $employer_share = @$d->employer_share;

            $taxmeta = get_meta( $tax->postMetas()->get() );

            // PERCENTAGE OF MONTHLY COMPENSATION
            if( @$taxmeta->percentage ) {
                $employee_share = $salary * (@$d->employee_share / 100);
                $employer_share = $salary * (@$d->employer_share / 100);
            }

            $data[] = [
                'id'             => $tax->id,
                'name'           => $tax->post_title,
                'employee_share' => $employee_share ? $employee_share : '0.00',
                'employer_share' => $employer_share ? $employer_share : '0.00',
                'total'          => $employee_share + $employer_share
            ];
        }

        return json_encode($data);
    }

    //--------------------------------------------------------------------------

}
