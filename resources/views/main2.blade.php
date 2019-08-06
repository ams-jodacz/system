<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js">
<![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>
            {{Config::get('app.title')}} | @yield('title','Hone Page')
        </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <meta content="{{ csrf_token() }}" name="csrf-token"/>
        
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/> -->
        <link href="{{URL::to('/')}}/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{URL::to('/')}}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{URL::to('/')}}/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{URL::to('/')}}/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <link href="{{URL::to('/')}}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        
        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        @yield('page_level_styles')
        <!-- END PAGE LEVEL PLUGIN STYLES -->
        
        <!-- BEGIN THEME STYLES -->
        <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
        <link href="{{URL::to('/')}}/assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="{{URL::to('/')}}/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="{{URL::to('/')}}/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="{{URL::to('/')}}/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="{{URL::to('/')}}/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->
        
        <link rel="shortcut icon" href="favicon.ico"/>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="page-header-fixed page-quick-sidebar-over-content page-style-square page-footer-fixed"> 
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner">
                        <!-- BEGIN LOGO -->
                        <div class="page-logo">
                                <a href="{{URL::to('/')}}">
                                    <!--<img src="{{URL::to('/')}}/assets/admin/layout/img/logo.png" alt="logo" class="logo-default"/>-->
                                </a>
                        </div>
                        <!-- END LOGO -->
                        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        </a>
                        <!-- END RESPONSIVE MENU TOGGLER -->
                        <!-- BEGIN TOP NAVIGATION MENU -->
                        <div class="top-menu">
                                <ul class="nav navbar-nav pull-right">
                                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                    <!-- include('common.nav_tools.notification') -->
                                    <!-- END NOTIFICATION DROPDOWN -->
                                    
                                    <!-- BEGIN INBOX DROPDOWN -->
                                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                    <!-- include('common.nav_tools.message') -->
                                    <!-- END INBOX DROPDOWN -->
                                    
                                    <!-- BEGIN TODO DROPDOWN -->
                                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                    <!-- include('common.nav_tools.task') -->
                                    <!-- END TODO DROPDOWN -->
                                    
                                    <!-- BEGIN USER LOGIN DROPDOWN -->
                                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                                    @include('common.nav_tools.settings')
                                    <!-- END USER LOGIN DROPDOWN -->
                                </ul>
                        </div>
                        <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <div class="clearfix">
        </div>
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                    <div class="page-sidebar navbar-collapse collapse">
                            <!-- BEGIN SIDEBAR MENU -->
                            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                            <ul class="page-sidebar-menu" data-slide-speed="200" data-auto-scroll="true" data-keep-expanded="false">
                                    <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                                    <li class="sidebar-toggler-wrapper">
                                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                                            <div class="sidebar-toggler">
                                            </div>
                                            <!-- END SIDEBAR TOGGLER BUTTON -->
                                    </li>
                                    <br/>
                                    @include('common.nav3')
                            </ul>
                            <!-- END SIDEBAR MENU -->
                    </div>
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                    <div class="page-content">
                            <!-- BEGIN PAGE HEADER-->
                            <h3 class="page-title">
                                @yield('page_header')
                            </h3>
                            <div class="page-bar">
                                    <ul class="page-breadcrumb">
                                            <li>
                                                    <i class="fa fa-home"></i>
                                                    <a href="{{URL::to('/')}}">Home</a>
                                                    <i class="fa fa-angle-right"></i>
                                            </li>
                                            @yield('breadcrumb')
                                    </ul>
                            </div>
                            <!-- END PAGE HEADER-->
                            @yield('content')
                            <!--Modal Start-->
                            <div id="loading_indicator" style="display:none">
                                <div class="page-loading page-loading-boxed">
                                    <img src="{{URL::to('/')}}/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                                    <span>
                                        &nbsp;&nbsp;Loading...
                                    </span>
                                </div>
                            </div>
                            <!--Modal End-->
                    </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
                <div class="page-footer-inner">
                    2014 &copy; Agent 5.
                </div>
                <div class="scroll-to-top">
                        <i class="icon-arrow-up"></i>
                </div>
        </div>
        <!-- END FOOTER -->
        <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
        
        <!-- BEGIN CORE PLUGINS -->
        <!--[if lt IE 9]>
        <script src="{{URL::to('/')}}/assets/global/plugins/respond.min.js"></script>
        <script src="{{URL::to('/')}}/assets/global/plugins/excanvas.min.js"></script> 
        <![endif]-->
        <script src="{{URL::to('/')}}/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
        <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
        <script src="{{URL::to('/')}}/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
    
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        @yield('page_js_plugins')
        <!-- END PAGE LEVEL PLUGINS -->
    
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{URL::to('/')}}/assets/global/scripts/metronic.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
        <script src="{{URL::to('/')}}/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
        <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootbox/bootbox.min.js"></script>
        <script src="{{URL::to('/')}}/assets/page/scripts/common/notification.js"></script>
        <script src="{{URL::to('/')}}/assets/page/scripts/common/general.js"></script>
        @yield('page_scripts')
        <!-- END PAGE LEVEL SCRIPTS -->
        
        <script>
        var BASE_URL = '{{URL::to('/')}}';
        var GENERAL;
        jQuery(document).ready(function() {    
           Metronic.init(); // init metronic core componets
           Layout.init(); // init layout
           QuickSidebar.init(); // init quick sidebar
           // Notification.init();
        });
        </script>
        
        @yield('init_js')
        <!-- END JAVASCRIPTS -->
    </body>
    <!-- END BODY -->
</html>