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

class GeneralController extends Controller
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
    }

    //--------------------------------------------------------------------------

    public function dashboard()
    {
        return view('app.general.dashboard');
    }

    //--------------------------------------------------------------------------

    public function settings()
    {
        $data = array();
                        
        $data['info'] = (object)$this->setting->get()->pluck('value', 'key')->toArray();

        if ( Input::get('op') ) 
        {   
            $inputs = Input::all();

            if( Input::hasFile('logo') ) {
                $pic = upload_image(Input::file('logo'), 'uploads/images', @$data['info']->logo, false);
                $inputs['logo'] = $pic;
            }         

            unset($inputs['_token']);
            unset($inputs['op']);

            foreach($inputs as $key => $val) {

                $setting = Setting::where('key', $key)->first();

                if( ! $setting ) {
                    $setting = new Setting();
                }

                $setting->key   = $key;
                $setting->value = $val;

                $setting->save();
            }   

            if( Session::get('pay_period_from') ) {
                Session::forget('pay_period_from');
                Session::forget('pay_period_to');
            }

            return Redirect::route('app.general.settings', query_vars())
                           ->with('success','Changes saved.');
        }

        return view('app.general.settings', $data);
    }

    //--------------------------------------------------------------------------

}
