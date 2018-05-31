<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Redirect, Input, Auth, Hash, Session, URL, Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\UserMeta;
use App\Setting;
use App\Post;
use App\PostMeta;



class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    protected $user;
    protected $usermeta;
    protected $setting;
    protected $post;
    protected $postmeta;


    public function __construct(User $user, UserMeta $usermeta, Setting $setting, Post $post, PostMeta $postmeta)
    {
        $this->user     = $user;
        $this->usermeta = $usermeta;
        $this->setting  = $setting;
        $this->post     = $post;
        $this->postmeta = $postmeta;
    }

    //--------------------------------------------------------------------------

    public function login()
    {
        if( Auth::check() ) {
            $auth = Auth::user();
            return Redirect::route('app.general.dashboard');
        }

        if(Input::get('op')) {

            $insertRules = [
                'email'    => 'required',
                'password' => 'required',
            ];

            $validator = Validator::make(Input::all(), $insertRules);

            if($validator->passes()) {

                $field = filter_var(Input::get('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
                $remember = (Input::has('remember')) ? true : false;
                
                $credentials = [
                    'email'     => Input::get('email'),
                    'password'  => Input::get('password'),                
                ];

                if(Auth::attempt($credentials, $remember)) {               
                    $auth = Auth::user();

                    Session::put('user_id', $auth->id);
                    $this->usermeta->update_meta($auth->id, 'last_login', date('Y-m-d H:i:s'));                
                    
                    return Redirect::route('app.general.dashboard');

                } 

                return Redirect::route('auth.login')
                               ->with('error','Invalid email or password')
                               ->withInput();
            }

            return Redirect::route('auth.login', query_vars())
                           ->withErrors($validator)
                           ->withInput(); 
        }

        return view('auth.login');
    }

    //--------------------------------------------------------------------------


    public function logout()
    {
        Auth::logout();
        Session::flash('success','You are now logged out!');
        return Redirect::route('auth.login');
    }
    
    //--------------------------------------------------------------------------

    public function lock()
    {
        Session::flash('success','System is locked!');
        return Redirect::route('auth.lock');
    }
    
    //--------------------------------------------------------------------------

    public function unlock()
    {
        return view('auth.lock');
    }
    
    //--------------------------------------------------------------------------

    public function forgotPassword($token ='')
    {

        $data['token'] = $token;
        
        if($token) {

            $u = $this->user->where('forgot_password_token', $token)->first();

            if(!$u) return Redirect::route('auth.login');

            if(Input::get('op') ) {

                $validator = Validator::make(Input::all(), User::$newPassword);
    
                if($validator->passes()) {

                    $u->password = Hash::make(Input::get('new_password'));
                    $u->forgot_password_token = NULL;

                    if( $u->save() ) {              
                        $user_id = $u->id;
                        
                        Auth::loginUsingId($u->id);
                        Session::put('user_id', $user_id);

                        return Redirect::route($u->group.'.dashboard')
                                       ->with('success','You have successfully changed your password.');

                    } 
                } else {
                        
                    return Redirect::route('auth.forgot-password')
                                   ->withErrors($validator)
                                   ->withInput();
                }
            }

        } else {

            if(Input::get('op') ) {

                $validator = Validator::make(Input::all(), User::$forgotPassword);
    
                if($validator->passes()) {

                    $token = str_random(64);
                    $email = Input::get('email');

                    $u = $this->user->where('email', $email)->first();
                    $u->forgot_password_token = $token;

                    if( $u->save() ) {              
                        $data['name']      = ucwords( $u->firstname );
                        $data['email']     = $u->email;
                        $data['token_url'] = URL::route('auth.forgot-password', $u->forgot_password_token);
                        $data['base_url']  = URL::route('auth.login');
                        $data['site_name'] = $site_name = ucwords($this->setting->get_setting('site_title'));

                        $data['email_support'] = $this->setting->get_setting('admin_email');
                        $data['email_title']   = $site_name.' Support';
                        $data['email_subject'] = $site_name.' Forgotten Password!';

                        Mail::send('emails.forgot-password', $data, function($message) use ($data)
                        {
                            $message->from($data['email_support'], $data['email_title']);
                            $message->to($data['email'], $data['name'])->subject($data['email_subject']);
                        });

                        return Redirect::route('auth.forgot-password')
                                       ->with('success','Forgot password link has been sent to your email address. Please check your inbox or spam folder.');

                    } 
                } else {
                        
                    return Redirect::route('auth.forgot-password')
                                   ->withErrors($validator)
                                   ->withInput();
                }
            }



        }

        return view('auth.forgot-password', $data);
    }

    //--------------------------------------------------------------------------
}
