<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Redirect, Input, Auth, Hash, Session, URL, Mail, Config, DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\UserMeta;
use App\Post;
use App\PostMeta;
use App\Setting;

class TaxController extends Controller
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

        $this->type   = 'tax';
        $this->single = 'Tax';
        $this->label  = 'Taxes';

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

        $queries = array('payroll_period');
        $selects = array();
        foreach(Input::all() as $input_k => $input_v) {            
            if($input_v) {
                if( in_array($input_k, $selects) ) {
                   $queries[] = $input_k;
                }                
            }
        }

        $data['rows'] = $this->post
                             ->search($search, $selects, $queries)
                             ->where('post_type', $type)
                             ->orderBy(Input::get('sort', 'post_order'), Input::get('order', 'ASC'))
                             ->paginate(Input::get('rows', 15));

        $data['count'] = $this->post
                              ->search($search, $selects, $queries)
                              ->where('post_type', $type)
                              ->count();

        $data['all'] = $this->post->where('post_type', $type)->count();

        $data['trashed'] = $this->post->withTrashed()
                                      ->where('post_type', $type)
                                      ->where('deleted_at', '<>', '0000-00-00')
                                      ->count();

        $data['post'] = $this->post;

        return view('app.taxes.index', $data);
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
                'name'              => 'required',
                'column'            => 'required',
                'code'              => 'required',
                'payroll_period'    => 'required',
                'exemption_amount'  => 'required',
                'exemption_percent' => 'required',
                'exemption_rate'    => 'required',
                'excess'            => 'required',
            ];    


            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.taxes.add')
                               ->withErrors($validator)
                               ->withInput(); 
            }

            $inputs = Input::all();
            
            $post = $this->post;

            $post->post_author  = $this->user_id;
            $post->post_title   = Input::get('name');

            if( $code = Input::get('code') )
                $post->post_name = $code;
            
            $post->post_type    = $type;
            $post->post_status  = 'actived';
            $post->post_order   = Input::get('column');                

            unset($inputs['_token']);
            unset($inputs['post_type']);
            unset($inputs['column']);

            $post->post_content = json_encode($inputs);                

            if( $post->save() ) {

                foreach ($inputs as $meta_key => $meta_val) {
                    $this->postmeta->update_meta($post->id, $meta_key, array_to_json($meta_val) );
                }

                return Redirect::route('app.taxes.edit', $post->id)
                               ->with('success',"New ".strtolower($single)." has been added!");
            } 
        }

        return view('app.taxes.add', $data);
    }

    //--------------------------------------------------------------------------

    public function edit($id='')
    {

        $data['type']   = $type = $this->type;
        $data['single'] = $single = $this->single;
        $data['label']  = $this->label;

        $data['info'] = $info = $this->post->find($id);
        foreach ($info->postmetas as $postmeta) {
            $data['info'][$postmeta->meta_key] = $postmeta->meta_value;
        }

        if( Input::get('_token') )
        {
            $rules = [
                'name'              => 'required',
                'column'            => 'required',
                'code'              => 'required',
                'payroll_period'    => 'required',
                'exemption_amount'  => 'required',
                'exemption_percent' => 'required',
                'exemption_rate'    => 'required',
                'excess'            => 'required',
            ];   

            $validator = Validator::make(Input::all(), $rules);

            if( ! $validator->passes() ) {
                return Redirect::route('app.taxes.edit', $id)
                               ->withErrors($validator)
                               ->withInput(); 
            }

            $inputs = Input::all();

            $post = $this->post->find($id);

            $post->post_title   = Input::get('name');

            if( $code = Input::get('code') )
                $post->post_name = $code;
            
            $post->post_status  = Input::get('post_status', 'inactived');
            $post->post_order   = Input::get('column');                

            unset($inputs['_token']);
            unset($inputs['post_type']);
            unset($inputs['post_status']);
            unset($inputs['column']);

            $post->post_content = json_encode($inputs);                
            $post->updated_at    = date('Y-m-d H:i:s');

            if( $post->save() ) {
                foreach ($inputs as $meta_key => $meta_val) {
                    $this->postmeta->update_meta($id, $meta_key, array_to_json($meta_val) );
                }

                return Redirect::route('app.taxes.edit', $id)
                               ->with('success', ucwords($single)." has been updated!");
            } 
        }

        return view('app.taxes.edit', $data);
    }

    //--------------------------------------------------------------------------

    public function delete($id)
    {
        $single = strtolower($this->single);

        $this->post->findOrFail($id)->delete();
        return Redirect::route('app.taxes.index', query_vars())
                       ->with('success', "Selected $single has been move to trashed!");
    }

    //--------------------------------------------------------------------------

    public function restore($id)
    {   
        $single = strtolower($this->single);

        $post = $this->post->withTrashed()->findOrFail($id);
        $post->restore();
        return Redirect::route('app.taxes.index', query_vars())
                       ->with('success', "Selected $single has been restored!");
    }

    //--------------------------------------------------------------------------
  
    public function destroy($id)
    {   
        $single = strtolower($this->single);

        $this->postmeta->where('post_id', $id)->delete(); 
        $post = $this->post->withTrashed()->find($id);
        $post->forceDelete();

        return Redirect::route('app.taxes.index', query_vars())
                       ->with('success', "Selected $single has been deleted permanently!");
    }

    //--------------------------------------------------------------------------
   
    public function tables()
    {   
        $data['type']   = $type = $this->type;
        $data['single'] = $this->single;
        $data['label']  = $this->label;

        $data['post'] = $this->post;

        return view('app.taxes.tables', $data);
    }

    //--------------------------------------------------------------------------

    public function tables_update() {

        $id = Input::get('id');
        $all = Input::all();        

        $rules = [
            'excess'            => 'required',
            'exemption_amount'  => 'required',
            'exemption_percent' => 'required',
            'exemption_rate'    => 'required',
        ];

        $validator = Validator::make(Input::all(), $rules);

        if( ! $validator->passes() ) {
            $response = array('error' => true, 'details' => $validator->errors());

            return json_encode( $response );
        }

        $inputs = ['exemption_amount', 'exemption_percent', 'exemption_rate', 'excess'];
        foreach ($inputs as $input) {
            $this->postmeta->update_meta($id, $input, $all[$input]);
        }

        $data['type']   = $type = $this->type;
        $data['single'] = $this->single;
        $data['label']  = $this->label;

        $data['post'] = $this->post;

        return view('app.taxes.temp.tables', $data);
    }

    //--------------------------------------------------------------------------

    public function calculator()
    {
        $gp = Input::get('gross_pay');

        $income_tax = $ex = $er = $ea = 0;

        parse_str( query_vars(), $search );

        $taxes = $this->post
                    ->select('posts.*', 
                        'm1.meta_value as excess',
                        'm2.meta_value as code',
                        'm4.meta_value as payroll_period',
                        'm5.meta_value as exemption_rate',
                        'm6.meta_value as exemption_amount'
                    )
                    ->from('posts')
                    ->join('postmeta AS m1', function ($join) use ($gp) {
                        $join->on('posts.id', '=', 'm1.post_id')
                             ->where('m1.meta_key', '=', 'excess');
                    })
                    ->join('postmeta AS m2', function ($join) use ($search) {
                        $join->on('posts.id', '=', 'm2.post_id')
                             ->where('m2.meta_key', '=', 'code')
                             ->where('m2.meta_value', $search['code']);
                    })
                    ->join('postmeta AS m4', function ($join) use ($search) {
                        $join->on('posts.id', '=', 'm4.post_id')
                             ->where('m4.meta_key', '=', 'payroll_period')
                             ->where('m4.meta_value', $search['payroll_period']);
                    })
                    ->join('postmeta AS m5', function ($join) use ($search) {
                        $join->on('posts.id', '=', 'm5.post_id')
                             ->where('m5.meta_key', '=', 'exemption_rate');
                    })
                    ->join('postmeta AS m6', function ($join) use ($search) {
                        $join->on('posts.id', '=', 'm6.post_id')
                             ->where('m6.meta_key', '=', 'exemption_amount');
                    })
                    ->where('posts.post_type', 'tax')
                    ->get();

        foreach ($taxes as $tax) {
            $excess = $gp - $tax->excess;
            if( $excess >= 0 ) {
                $er = $tax->exemption_rate;
                $ea = $tax->exemption_amount;
                $ex = $tax->excess;
    
            }
        }

        if( $taxes ) {
            $income_tax = (($gp - $ex) * $er) + $ea;          
        }


        $data = [
            'amount'    => $income_tax, 
            'formatted' => number_format($income_tax, 2)
        ];

        return json_encode($data);
    }

    //--------------------------------------------------------------------------

}
