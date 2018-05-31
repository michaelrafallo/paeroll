<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>{{ App\Setting::get_setting('site_title') }}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}"  rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}"  rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}"  rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}"  rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}"  rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}"  rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ asset('assets/global/css/components-md.min.css') }}"  rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ asset('assets/global/css/plugins-md.min.css') }}"  rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ asset('assets/pages/css/login-4.min.css') }}"  rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->

        <link href="{{ asset('assets/customs/style.css') }}"  rel="stylesheet" type="text/css" />

        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->


    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
                <img src="{{ asset(App\Setting::get_setting('logo')) }}" width="200"/>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="" method="post">
                @include('notification')
                {!! csrf_field() !!}
                <input type="hidden" name="op" value="1">   

                <h3 class="form-title">Login to your account</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any username and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input type="text" class="form-control" name="email" placeholder="Email" value="{{ Input::old('email') }}"> 
                    </div>
                    <!-- START error message -->
                    {!! $errors->first('email','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                    <!-- END error message -->
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input type="password" class="form-control" name="password" placeholder="Password" value="{{ Input::old('password') }}">
                    </div>
                    <!-- START error message -->
                    {!! $errors->first('password','<span class="help-block"><p class="text-danger">:message</p></span>') !!}
                    <!-- END error message -->
                </div>
                <div class="form-actions">
                    <label class="rememberme mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" /> Remember me
                        <span></span>
                    </label>
                    <button type="submit" class="btn green pull-right"> Login </button>
                </div>

                <div class="forget-password">
                    <h4>Forgot your password ?</h4>
                    <p> no worries, click
                        <a href="javascript:;" id="forget-password" class="text-success"> here </a> to reset your password. </p>
                </div>
            </form>
            <!-- END LOGIN FORM -->

            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="index.html" method="post">
                <h3>Forget Password ?</h3>
                <p> Enter your e-mail address below to reset your password. </p>
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn red btn-outline">Back </button>
                    <button type="submit" class="btn green pull-right"> Submit </button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->

        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright">{{ date('Y') }} &copy; {{ App\Setting::get_setting('copy_right') }}</div>
        <!-- END COPYRIGHT -->
        <!--[if lt IE 9]>
        <script src="{{ asset('assets/global/plugins/respond.min.js') }}" ></script>
        <script src="{{ asset('assets/global/plugins/excanvas.min.js') }}" ></script> 
        <script src="{{ asset('assets/global/plugins/ie8.fix.min.js') }}" ></script> 
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ asset('assets/global/plugins/jquery.min.js') }}"  type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}"  type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/js.cookie.min.js') }}"  type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"  type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}"  type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"  type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"  type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"  type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}"  type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/backstretch/jquery.backstretch.min.js') }}"  type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ asset('assets/global/scripts/app.min.js') }}"  type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script>
        var Login = function () {

            var handleLogin = function() {
                $('.login-form').validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        rules: {
                            username: {
                                required: true
                            },
                            password: {
                                required: true
                            },
                            remember: {
                                required: false
                            }
                        },

                        messages: {
                            username: {
                                required: "Username is required."
                            },
                            password: {
                                required: "Password is required."
                            }
                        },

                        invalidHandler: function (event, validator) { //display error alert on form submit   
                            $('.alert-danger', $('.login-form')).show();
                        },

                        highlight: function (element) { // hightlight error inputs
                            $(element)
                                .closest('.form-group').addClass('has-error'); // set error class to the control group
                        },

                        success: function (label) {
                            label.closest('.form-group').removeClass('has-error');
                            label.remove();
                        },

                        errorPlacement: function (error, element) {
                            error.insertAfter(element.closest('.input-icon'));
                        },

                        submitHandler: function (form) {
                            form.submit();
                        }
                    });

                    $('.login-form input').keypress(function (e) {
                        if (e.which == 13) {
                            if ($('.login-form').validate().form()) {
                                $('.login-form').submit();
                            }
                            return false;
                        }
                    });
            }

            var handleForgetPassword = function () {
                $('.forget-form').validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        ignore: "",
                        rules: {
                            email: {
                                required: true,
                                email: true
                            }
                        },

                        messages: {
                            email: {
                                required: "Email is required."
                            }
                        },

                        invalidHandler: function (event, validator) { //display error alert on form submit   

                        },

                        highlight: function (element) { // hightlight error inputs
                            $(element)
                                .closest('.form-group').addClass('has-error'); // set error class to the control group
                        },

                        success: function (label) {
                            label.closest('.form-group').removeClass('has-error');
                            label.remove();
                        },

                        errorPlacement: function (error, element) {
                            error.insertAfter(element.closest('.input-icon'));
                        },

                        submitHandler: function (form) {
                            form.submit();
                        }
                    });

                    $('.forget-form input').keypress(function (e) {
                        if (e.which == 13) {
                            if ($('.forget-form').validate().form()) {
                                $('.forget-form').submit();
                            }
                            return false;
                        }
                    });

                    jQuery('#forget-password').click(function () {
                        jQuery('.login-form').hide();
                        jQuery('.forget-form').show();
                    });

                    jQuery('#back-btn').click(function () {
                        jQuery('.login-form').show();
                        jQuery('.forget-form').hide();
                    });

            }

            
            return {
                //main function to initiate the module
                init: function () {
                    
                    handleLogin();
                    handleForgetPassword();

                    // init background slide images
                    $.backstretch([
                        "{{ asset('assets/pages/media/bg/1.jpg') }}",
                        "{{ asset('assets/pages/media/bg/2.jpg') }}",
                        "{{ asset('assets/pages/media/bg/3.jpg') }}",
                        "{{ asset('assets/pages/media/bg/4.jpg') }}"
                        ], {
                          fade: 1000,
                          duration: 8000
                        }
                    );
                }
            };

        }();

        jQuery(document).ready(function() {
            Login.init();
        });            
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>