<?php

function sidebar_menu($type = '') {

    $attendance = App\Setting::get_setting('attendance');
    $leave      = App\Setting::get_setting('leave_management');

    foreach(get_types() as $k_type => $v_type) {
        $types[] = array(
            'title'    => $v_type['label'],
            'icon'     => '',
            'class'    => '',
            'url'      => URL::route('app.posts.index', ['post_type' =>  $k_type]),
            'sub_menu' => array()
        );  
    }
    foreach(get_earning_types() as $k_type => $v_type) {
        $types[] = array(
            'title'    => $v_type['label'],
            'icon'     => '',
            'class'    => '',
            'url'      => URL::route('app.earnings.index', ['post_type' =>  $k_type]),
            'sub_menu' => array()
        );  
    }

    $types[] = array(
          'title'    => 'Tax Table',
          'icon'     => '',
          'class'    => '',
          'url'      => URL::route('app.taxes.index'),
          'sub_menu' => array()
    );

    $types[] = array(
          'title'    => 'Allowances',
          'icon'     => '',
          'class'    => '',
          'url'      => URL::route('app.allowances.index'),
          'sub_menu' => array()
    );

    $types[] = array(
          'title'    => 'Deductions',
          'icon'     => '',
          'class'    => '',
          'url'      => URL::route('app.deductions.index'),
          'sub_menu' => array()
    );

    $types[] = array(
        'title'    => 'Events',
        'icon'     => '',
        'class'    => 'menu-attendance '. ($attendance ? '' : 'hide'),
        'url'      => URL::route('app.events.index'),
        'sub_menu' => array()
    );


    $menu = array(
        array(
            'title'    => 'Dashboard',
            'icon'     => 'home',
            'class'    => '',
            'url'      =>  URL::route('app.general.dashboard'),
            'sub_menu' => array()
        ),
        array(
            'title'    => 'Payroll',
            'icon'     => 'calculator',
            'class'    => '',
            'url'      =>  URL::route('app.payroll.index'),
            'sub_menu' => array()
        ),
        array(
            'title'    => 'Users',
            'icon'     => 'users',
            'class'    => '',
            'url'      => '',
            'sub_menu' => array(
                    array(
                        'title'    => 'All Users',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.users.index'),
                        'sub_menu' => array()
                    ),
                    array(
                        'title'    => 'Add User',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.users.add'),
                        'sub_menu' => array()
                    ),

            )
        ),
        array(
            'title'    => 'Groups',
            'icon'     => 'users',
            'class'    => '',
            'url'      => '',
            'sub_menu' => array(
                    array(
                        'title'    => 'All Groups',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.groups.index'),
                        'sub_menu' => array()
                    ),
                    array(
                        'title'    => 'Add Group',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.groups.add'),
                        'sub_menu' => array()
                    )
            )
        ),
        array(
            'title'    => 'Post Types',
            'icon'     => 'docs',
            'class'    => '',
            'url'      => '',
            'sub_menu' => $types
        ),
        array(
            'title'    => 'Employees',
            'icon'     => 'users',
            'class'    => '',
            'url'      => '',
            'sub_menu' => array(
                    array(
                        'title'    => 'All Employees',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.employees.index'),
                        'sub_menu' => array()
                    ),
                    array(
                        'title'    => 'Add Employee',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.employees.add'),
                        'sub_menu' => array()
                    ),

            )
        )
    );  
  
    $menu[] = array(
            'title'    => 'Leave Management',
            'icon'     => 'plane',
            'class'    => 'menu-leave '. ($leave ? '' : 'hide'),
            'url'      => '',
            'sub_menu' => array(
                    array(
                          'title'    => 'Leaves',
                          'icon'     => '',
                          'class'    => '',
                          'url'      => URL::route('app.leaves.index'),
                          'sub_menu' => array()
                    ),
                    array(
                        'title'    => 'Leave Requests',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.leaves.manager.index'),
                        'sub_menu' => array()
                    ),
                    array(
                        'title'    => 'File a leave',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.leaves.manager.file'),
                        'sub_menu' => array()
                    ),

            )
        );


    $menu[] = array(
        'title'    => 'Attendance',
        'icon'     => 'clock',
        'class'    => 'menu-attendance '. ($attendance ? '' : 'hide'),
        'url'      => '',
        'sub_menu' => array(
                array(
                    'title'    => 'Tracker',
                    'icon'     => '',
                    'class'    => '',
                    'url'      => URL::route('app.attendance.index'),
                    'sub_menu' => array()
                ),
                array(
                    'title' => 'Manual Punch',
                    'icon' => '',
                    'class' => '',
                    'url'   => URL::route('app.attendance.manual'),
                    'sub_menu' => array()
                ),
        )
    );


  $menu[] = array(
            'title'    => 'Reports',
            'icon'     => 'pie-chart',
            'class'    => '',
            'url'      => '',
            'sub_menu' => array(
                    array(
                        'title'    => 'Payslips',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.users.index'),
                        'sub_menu' => array()
                    ),
                    array(
                        'title'    => 'Payroll History',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.users.index'),
                        'sub_menu' => array()
                    ),
                    array(
                        'title'    => 'Payroll Register',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.users.index'),
                        'sub_menu' => array()
                    ),
                    array(
                        'title'    => 'Payroll Sumarry',
                        'icon'     => '',
                        'class'    => '',
                        'url'      => URL::route('app.users.index'),
                        'sub_menu' => array()
                    ),

            )
        );

  $menu[] = array(
    'title'    => 'Settings',
    'icon'     => 'settings',
    'class'    => '',
    'url'      => URL::route('app.general.settings'),
    'sub_menu' => array()
  );

  return $menu;
}

//----------------------------------------------------------------

function top_nav_menu() {
    
  $menu = array(
    array(
      'title' => 'My Profile',
      'icon' => 'user',
      'class' => '',
      'url'   => URL::route('app.users.profile'),
      'sub_menu' => array()
    ),
  );

  return $menu;
}

//----------------------------------------------------------------