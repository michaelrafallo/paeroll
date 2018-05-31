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

class LeaveController extends Controller
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
                             ->where('post_type', 'leave')
                             ->orderBy('id', 'DESC')
                             ->paginate(15);

        $data['count'] = $this->post
                              ->search($search)
                              ->where('post_type', 'leave')
                              ->count();

        $data['all'] = $this->post->where('post_type', 'leave')->count();

        $data['trashed'] = $this->post->withTrashed()
                                      ->where('post_type', 'leave')
                                      ->where('deleted_at', '<>', '0000-00-00')
                                      ->count();

        return view('app.leaves.index', $data);
    }

    //--------------------------------------------------------------------------

    public function add()
    {
        if( Input::get('_token') ) {
            $rules = [
                'name'    => 'required',
                'code'    => 'required',
                'balance' => 'required',
            ];    

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.leaves.add')
                               ->withErrors($validator)
                               ->withInput(); 
            }

            $post = $this->post;

            $post->post_author  = $this->user_id;
            $post->post_name    = Input::get('code');
            $post->post_title   = Input::get('name');
            
            if( $desc = Input::get('description') ) {
                $post->post_content = $desc;                
            }

            $post->post_type    = 'leave';
            $post->post_status  = 'actived';

            if( $post->save() ) {

                $postmetas = [
                    'balance' => Input::get('balance'),
                ];

                foreach ($postmetas as $meta_key => $meta_val) {
                    $this->postmeta->update_meta($post->id, $meta_key, $meta_val);
                }

                return Redirect::route('app.leaves.edit', $post->id)
                               ->with('success','New leave has been added!');
            } 
        }

        return view('app.leaves.add');
    }

    //--------------------------------------------------------------------------

    public function edit($id='')
    {

        $data['info'] = $info = $this->post->find( $id );
        foreach ($info->postmetas as $postmeta) {
            $data['info'][$postmeta->meta_key] = $postmeta->meta_value;
        }

        if( Input::get('_token') ) {
            $rules = [
                'name'    => 'required',
                'code'    => 'required',
                'balance' => 'required',
            ];    

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.leaves.edit', $id)
                               ->withErrors($validator)
                               ->withInput(); 
            }
            
            $post = $this->post->find( $id );

            $post->post_author  = $this->user_id;
            $post->post_title   = Input::get('name');
            $post->post_name    = Input::get('code');
            $post->post_content = Input::get('description');
            $post->post_status  = Input::get('status', 'inactived');
            $post->updated_at   = date('Y-m-d H:i:s');

            if( $post->save() ) {

                $postmetas = [
                    'balance' => Input::get('balance'),
                ];

                foreach ($postmetas as $meta_key => $meta_val) {
                    $this->postmeta->update_meta($id, $meta_key, $meta_val);
                }

                return Redirect::route('app.leaves.edit', $id)
                               ->with('success','Leave has been updated!');
            } 
        }

        return view('app.leaves.edit', $data);
    }

    //--------------------------------------------------------------------------

    public function delete($id)
    {
        $this->post->findOrFail($id)->delete();
        return Redirect::route('app.leaves.index', query_vars())
                       ->with('success','Selected leave has been move to trashed!');
    }

    //--------------------------------------------------------------------------

    public function restore($id)
    {   
        $post = $this->post->withTrashed()->findOrFail($id);
        $post->restore();
        return Redirect::route('app.leaves.index', ['type' => 'trash'])
                       ->with('success','Selected leave has been restored!');
    }

    //--------------------------------------------------------------------------

  
    public function destroy($id)
    {   
        $this->postmeta->where('post_id', $id)->delete(); 
        $post = $this->post->withTrashed()->find($id);
        $post->forceDelete();

        return Redirect::route('app.leaves.index', ['type' => 'trash'])
                       ->with('success','Selected leave has been deleted permanently!');
    }

    //--------------------------------------------------------------------------
    
}
