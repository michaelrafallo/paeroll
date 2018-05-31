<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Redirect, Input, Auth, Hash, Session, URL, Mail, Config, PDF;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\UserMeta;
use App\Post;
use App\PostMeta;
use App\Setting;

class PayrollController extends Controller
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

        $from = Session::get('pay_period_from');
        $to   = Session::get('pay_period_to');

        $data['set_pay_period_from'] = $this->setting->get_setting('pay_period_from');
        $data['set_pay_period_to']   = $this->setting->get_setting('pay_period_to'); 

        if( ! $from && ! $to ) {
            $from = $data['set_pay_period_from'];
            $to   = $data['set_pay_period_to'];            
        }


        $from = Input::get('from', $from);
        $to   = Input::get('to', $to);

        Session::put('pay_period_from', $from);
        Session::put('pay_period_to', $to);

        $data['from']      = $from;
        $data['to']        = $to;
        $data['post_name'] = $from.'_'.$to;
        $data['pay_from']  = date_formatted(date_formatted_b($from));
        $data['pay_to']    = date_formatted(date_formatted_b($to));
        $data['cutoff']    = date('d-M-Y', strtotime('+1 day', strtotime(date_formatted_b($to))));


        $search['group'] = 'employee';

        $data['rows'] = $this->user
                             ->search($search, $selects, $queries)
                             ->orderBy(Input::get('sort', 'fullname'), Input::get('order', 'DESC'))
                             ->paginate(Input::get('rows', 15));

        $data['count'] = $this->user
                              ->search($search, $selects, $queries)
                              ->count();

        $data['post'] = $this->post;

        return view('app.payroll.index', $data);
    }

    //--------------------------------------------------------------------------

    public function view($id='')
    {

        $data['info'] = $info = $this->user->find( $id );
        foreach ($info->usermetas as $usermeta) {
            $data['info'][$usermeta->meta_key] = $usermeta->meta_value;
        }

        $data['post'] = $this->post;

        $data['payroll_period'] = $this->setting->get_setting('payroll_period');

        $from = Session::get('pay_period_from');
        $to   = Session::get('pay_period_to');

        if( ! $from ) {
            $from = $this->setting->get_setting('pay_period_from');
            $to   = $this->setting->get_setting('pay_period_to');            
        }

        $data['from'] = $from;
        $data['to']   = $to;

        $data['pay_from'] = date_formatted(date_formatted_b($from));
        $data['pay_to']   = date_formatted(date_formatted_b($to));
        $data['cutoff']   = date('d-M-Y', strtotime('+1 day', strtotime(date_formatted_b($to))));

        $data['post_name'] = $post_name = $from.'_'.$to;

        $data['payroll'] = $posts = $this->post->where('post_name', $post_name)->where('post_title', $id)->first();

        if($posts) {
            foreach ($posts->postmetas as $postmeta) {
                $data['payroll'][$postmeta->meta_key] = $postmeta->meta_value;
            }            
        }

        if( Input::get('_token') ) {

            $inputs = Input::all();

            $unsets = ['_token'];

            foreach ($unsets as $unset) {
                unset($inputs[$unset]);
            }

            $inputs['user_id']      = $id;
            $inputs['fullname']     = $info->fullname;
            $inputs['period_start'] = $from;
            $inputs['period_end']   = $to;

            $post = $this->post->where('post_name', $post_name)->where('post_title', $id)->first();

            $where = ['post_title' => $info->id, 'post_status' => 'processed', 'post_type' => 'payroll'];
            $inputs['pay_no'] = $this->post->where($where)->where('post_name', '<>', $post_name)->count() + 1;


            if( ! $post ) {
                $post = new Post();
            }

            $post->post_author  = $this->user_id;
            $post->post_name    = $post_name;
            $post->post_title   = $id;
            $post->post_content = json_encode($inputs);
            $post->post_status  = 'processed'; // ($inputs['total']['net_pay'] != '0.00') ? 'processed' : 'unprocessed';
            $post->post_type    = 'payroll';
            $post->updated_at   = date('Y-m-d H:i:s');

            if( $post->save() ) {

                foreach ($inputs as $meta_key => $meta_val) {
                    $this->postmeta->update_meta($post->id, $meta_key, array_to_json($meta_val) );
                }

                return Redirect::route('app.payroll.view', $id)
                               ->with('success','Changes saved!');
            } 
        }

        return view('app.payroll.view', $data);
    }

    //--------------------------------------------------------------------------

    public function payslip()
    {
        parse_str( query_vars(), $search );

        $queries = array();
        $selects = array();

        foreach(Input::all() as $input_k => $input_v) {            
            if($input_v) {
                if( in_array($input_k, $selects) ) {
                   $queries[] = $input_k;
                }                
            }
        }

        $data['rows'] = $this->post->search($search, $selects, $queries)
                                   ->where('post_status', 'processed')
                                   ->where('post_type', 'payroll')
                                   ->get();
        
        $data['company_name']   = $this->setting->get_setting('company_name');
        $data['address']        = $this->setting->get_setting('report_address');

        $data['limit_other_deductions'] = $this->setting->get_setting('limit_other_deductions');
        $data['limit_other_earnings']   = $this->setting->get_setting('limit_other_earnings');        

        $data['post'] = $this->post;
        $data['usermeta'] = $this->usermeta;

        $data['leaves'] = [
            'SL'  => 'sick_leave', 
            'VL'  => 'vacation_leave', 
            'SIL' => 'service_incentive_leave'
        ];

        // return view('app.reports.payslip', $data);

        $pdf = PDF::loadView('app.reports.payslip', $data);
        return $pdf->stream('invoice.pdf');

        return view('app.reports.payslip', $data);
    }

    //--------------------------------------------------------------------------

}
