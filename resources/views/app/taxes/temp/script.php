<?php 

/*        foreach (range(130, 147) as $id) {
            $p = $this->post->find($id);
            if( $p ) {
                $p->delete();                
                $this->postmeta->where('post_id', $id)->delete();
            }
        }*/



    /* START Exemption */

    /* NOT CHANGE */
    $ep_0 = '0';
    $ep_1 = '0';
    $ep_2 = '0';
    $ep_3 = '10';
    $ep_4 = '15';
    $ep_5 = '20';
    $ep_6 = '25';
    $ep_7 = '30';
    $ep_8 = '32';
    /* NOT CHANGE */

    $ea_0 = '0';
    $ea_1 = '0';
    $ea_2 = '0';
    $ea_3 = '41.67';
    $ea_4 = '208.33';
    $ea_5 = '708.33';
    $ea_6 = '1875.00';
    $ea_7 = '4166.67';
    $ea_8 = '10416.67';
        /* END Exemption */


    // -- Z 

    $ex_0 = '150';
    $ex_1 = '1';
    $ex_2 = '12500';
    $ex_3 = '13333';
    $ex_4 = '15000';
    $ex_5 = '18333';
    $ex_6 = '24167';
    $ex_7 = '33333';
    $ex_8 = '54167';

   foreach (['single', 'married'] as $ms) {

   // foreach (['0'] as $ms) {

        // Single / Married
        $dependent = 4;

        $name      = ucwords($ms).' w/ '+$dependent+' Dependent';
        $period    = 30;
        $status    = $ms;

        $code      = ($ms == 'single') ? 'S' : 'ME';

        if($dependent) {
            $code      = ($ms == 'single') ? 'S'.$dependent : 'ME'.$dependent;
        }

        // Z
/*        $dependent = 0;
        $name      = 'Zero Exemption';
        $status    = $ms;
        $code      = 'Z';*/

  
        $taxes[] = array(
            'payroll_period'    => $period,
            'name'              => $name,
            'code'              => $code,
            'exemption_amount'  => $ea_0,
            'exemption_percent' => $ep_0,
            'exemption_rate'    => number_format($ep_0 / 100, 2),
            'excess'            => $ex_0,
            'status'            => $status,
            'dependent'         => $dependent,
        );
        $taxes[] = array(
            'payroll_period'    => $period,
            'name'              => $name,
            'code'              => $code,
            'exemption_amount'  => $ea_1,
            'exemption_percent' => $ep_1,
            'exemption_rate'    => number_format($ep_1 / 100, 2),
            'excess'            => $ex_1,
            'status'            => $status,
            'dependent'         => $dependent,
        );
        $taxes[] = array(
            'payroll_period'    => $period,
            'name'              => $name,
            'code'              => $code,
            'exemption_amount'  => $ea_2,
            'exemption_percent' => $ep_2,
            'exemption_rate'    => number_format($ep_2 / 100, 2),
            'excess'            => $ex_2,
            'status'            => $status,
            'dependent'         => $dependent,
        );
        $taxes[] = array(
            'payroll_period'    => $period,
            'name'              => $name,
            'code'              => $code,
            'exemption_amount'  => $ea_3,
            'exemption_percent' => $ep_3,
            'exemption_rate'    => number_format($ep_3 / 100, 2),
            'excess'            => $ex_3,
            'status'            => $status,
            'dependent'         => $dependent,
        );
        $taxes[] = array(
            'payroll_period'    => $period,
            'name'              => $name,
            'code'              => $code,
            'exemption_amount'  => $ea_4,
            'exemption_percent' => $ep_4,
            'exemption_rate'    => number_format($ep_4 / 100, 2),
            'excess'            => $ex_4,
            'status'            => $status,
            'dependent'         => $dependent,
        );
        $taxes[] = array(
            'payroll_period'    => $period,
            'name'              => $name,
            'code'              => $code,
            'exemption_amount'  => $ea_5,
            'exemption_percent' => $ep_5,
            'exemption_rate'    => number_format($ep_5 / 100, 2),
            'excess'            => $ex_5,
            'status'            => $status,
            'dependent'         => $dependent,
        );
        $taxes[] = array(
            'payroll_period'    => $period,
            'name'              => $name,
            'code'              => $code,
            'exemption_amount'  => $ea_6,
            'exemption_percent' => $ep_6,
            'exemption_rate'    => number_format($ep_6 / 100, 2),
            'excess'            => $ex_6,
            'status'            => $status,
            'dependent'         => $dependent,
        );
        $taxes[] = array(
            'payroll_period'    => $period,
            'name'              => $name,
            'code'              => $code,
            'exemption_amount'  => $ea_7,
            'exemption_percent' => $ep_7,
            'exemption_rate'    => number_format($ep_7 / 100, 2),
            'excess'            => $ex_7,
            'status'            => $status,
            'dependent'         => $dependent,
        );
        $taxes[] = array(
            'payroll_period'    => $period,
            'name'              => $name,
            'code'              => $code,
            'exemption_amount'  => $ea_8,
            'exemption_percent' => $ep_8,
            'exemption_rate'    => number_format($ep_8 / 100, 2),
            'excess'            => $ex_8,
            'status'            => $status,
            'dependent'         => $dependent,
        );

    }



$i=1;
foreach ( $taxes as $tax) {

    $post_content = json_encode($tax);

    $post = $this->post->where( 'post_content', $post_content )->first();    

    if(  ! $post ) {
        $post = new Post();    
    }

    $post->post_author  = $this->user_id;
    $post->post_title   = $tax['name'];
    $post->post_name    = $tax['code'];
    $post->post_type    = 'tax';
    $post->post_status  = 'actived';
    $post->post_order   = $i++;

    $post->post_content = $post_content;                

    if( $post->save() ) {

        foreach ($tax as $meta_key => $meta_val) {
            $this->postmeta->update_meta($post->id, $meta_key, array_to_json($meta_val) );
        }

    }

}