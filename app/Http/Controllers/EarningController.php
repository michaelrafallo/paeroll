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

class EarningController extends Controller
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

        $this->type   = $type = Input::get('post_type');
        $this->single = get_earning_types($type, 'single');
        $this->label  = get_earning_types($type, 'label');

        $this->middleware(function ($request, $next) {
            $this->user_id = Auth::user()->id;
            return $next($request);
        });
    }

    //--------------------------------------------------------------------------

    public function index()
    {
        $data['type']   = $type = $this->type;
        $data['single'] = $this->single;
        $data['label']  = $this->label;

        parse_str( query_vars(), $search );

        $data['rows'] = $this->post
                             ->search($search)
                             ->where('post_type', $type)
                             ->orderBy('id', 'DESC')
                             ->paginate(15);

        $data['count'] = $this->post
                              ->search($search)
                              ->where('post_type', $type)
                              ->count();

        $data['all'] = $this->post->where('post_type', $type)->count();

        $data['trashed'] = $this->post->withTrashed()
                                      ->where('post_type', $type)
                                      ->where('deleted_at', '<>', '0000-00-00')
                                      ->count();

        return view('app.earnings.index', $data);
    }

    //--------------------------------------------------------------------------

    public function add()
    {
        $data['type']   = $type = $this->type;
        $data['single'] = $single = $this->single;
        $data['label']  = $this->label;

        if( Input::get('_token') )
        {
            $rules = [
                'name'       => 'required',
                'code'       => 'required',
                'multiplier' => 'required',
            ];    

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.earnings.add', ['post_type' => $type])
                               ->withErrors($validator)
                               ->withInput(); 
            }

            $post = $this->post;

            $post->post_author  = $this->user_id;
            $post->post_title   = Input::get('name');

            if( $code = Input::get('code') )
                $post->post_name = $code;

            if( $desc = Input::get('multiplier') )
                $post->post_content = $desc;                

            
            $post->post_type    = $type;
            $post->post_status  = 'actived';

            if( $post->save() ) {
                return Redirect::route('app.earnings.edit', [$post->id, 'post_type' => $type])
                               ->with('success',"New ".strtolower($single)." has been added!");
            } 
        }

        return view('app.earnings.add', $data);
    }

    //--------------------------------------------------------------------------

    public function edit($id='')
    {

        $data['type']   = $type = $this->type;
        $data['single'] = $single = $this->single;
        $data['label']  = $this->label;

        $data['info'] = $post = $this->post->find($id);

        if( Input::get('_token') )
        {
            $rules = [
                'name'       => 'required',
                'code'       => 'required',
                'multiplier' => 'required',
            ];    

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.earnings.edit', [$id, 'post_type' => $type])
                               ->withErrors($validator)
                               ->withInput(); 
            }

            $post->post_author  = $this->user_id;
            $post->post_name    = Input::get('code');
            $post->post_title   = Input::get('name');
            $post->post_content = Input::get('multiplier');
            $post->post_status  = Input::get('status', 'inactived');
            $post->updated_at    = date('Y-m-d H:i:s');

            if( $post->save() ) {
                return Redirect::route('app.earnings.edit', [$id, 'post_type' => $type])
                               ->with('success', ucwords($single)." has been updated!");
            } 
        }

        return view('app.earnings.edit', $data);
    }

    //--------------------------------------------------------------------------

    public function delete($id)
    {
        $single = strtolower($this->single);

        $this->post->findOrFail($id)->delete();
        return Redirect::route('app.earnings.index', query_vars())
                       ->with('success', "Selected $single has been move to trashed!");
    }

    //--------------------------------------------------------------------------

    public function restore($id)
    {   
        $single = strtolower($this->single);

        $post = $this->post->withTrashed()->findOrFail($id);
        $post->restore();
        return Redirect::route('app.earnings.index', query_vars())
                       ->with('success', "Selected $single has been restored!");
    }

    //--------------------------------------------------------------------------

  
    public function destroy($id)
    {   
        $single = strtolower($this->single);
        
        $this->postmeta->where('post_id', $id)->delete(); 
        $post = $this->post->withTrashed()->find($id);
        $post->forceDelete();

        return Redirect::route('app.earnings.index', query_vars())
                       ->with('success', "Selected $single has been deleted permanently!");
    }

    //--------------------------------------------------------------------------

}
