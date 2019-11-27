@extends('main')

@section('title')
    My Profile
@stop

@section('page_level_styles')
    <link href="{{URL::to('/')}}/assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
@stop

@section('breadcrumb') 
@stop

@section('page_header')
@stop

@section('content')
    <div class="row margin-top-20">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <!-- PORTLET MAIN -->
                <div class="portlet light profile-sidebar-portlet">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <!-- <img src="{{URL::to('/')}}/assets/admin/pages/media/profile/avatar.png" class="img-responsive" alt=""> -->
                        <img src="{{URL::to('/')}}/images/{{App\Models\ACL\User::getPicName()}}" class="img-responsive" alt="">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                            {{App\Models\ACL\User::getName()}}
                        </div>
                        <div class="profile-usertitle-job">
                            <!--Developer-->
                        </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <div class="profile-userbuttons">
                        <a href="#change_profile_pic_modal" class="btn btn-circle green-haze btn-sm" data-toggle="modal" type="button">Change Profile Pic</a>
                    </div>
                </div>
                <!-- END PORTLET MAIN -->
                <!-- PORTLET MAIN -->
                <div class="portlet light">
                        <!-- STAT -->
                        <div class="row list-separated profile-stat">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                        <div class="uppercase profile-stat-title">
                                                 <!--37-->
                                        </div>
                                        <div class="uppercase profile-stat-text">
                                                 <!--Projects-->
                                        </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                        <div class="uppercase profile-stat-title">
                                                 <!--51-->
                                        </div>
                                        <div class="uppercase profile-stat-text">
                                                 <!--Tasks-->
                                        </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                        <div class="uppercase profile-stat-title">
                                                 <!--61-->
                                        </div>
                                        <div class="uppercase profile-stat-text">
                                                 <!--Uploads-->
                                        </div>
                                </div>
                        </div>
                        <!-- END STAT -->
                </div>
                <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PORTLET -->
                        <!--<div class="portlet light ">-->
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="icon-bar-chart theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold">
                                        My Profile
                                    </span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <ul class="nav nav-pills">
                                    <li class="active">
                                        <a href="#account_info" data-toggle="tab">
                                            Account Info
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#setting" data-toggle="tab">
                                            Setting
                                        </a>
                                    </li>
<!--                                     <li>
                                        <a href="#profile_pic" data-toggle="tab">
                                            Profile Pic
                                        </a>
                                    </li> -->
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="account_info">
                                        @include('common.myaccount.form.account_info_form')
                                    </div>
                                    <div class="tab-pane fade" id="setting">
                                        @include('common.myaccount.form.password_form')
                                    </div>
<!--                                     <div class="tab-pane fade" id="profile_pic">
                                        Profile Pic
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET -->
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
    <!--Modal Start-->
    <div class="modal fade" id="change_profile_pic_modal" role="basic" aria-hidden="true">
        <div class="page-loading page-loading-boxed">
            <img src="{{URL::to('/')}}/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
            <span>
                &nbsp;&nbsp;Loading...
            </span>
        </div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h3 id="reboot_modal_header"></h3>
                </div>
                <div class="modal-body">
<!--                     <div class="row">
                        <div class="col-md-6">
                            <span class="btn green fileinput-button">
                                <input type="file" name="profile_pic" id="profile_pic">
                            </span>
                        </div>
                    </div> -->
                    <form id="data" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="btn green fileinput-button">
                                        <input type="file" name="profile_pic" id="profile_pic">
                                    </span>
                                </div>
                            </div>
                        </div>
                    <form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" id="upload-close-btn" class="btn">Close</button>
                    <button type="button" id="upload_btn" class="btn blue">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal End-->
@stop

@section('page_js_plugins')
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-markdown/lib/markdown.js"></script>
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/myaccount/myaccount.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
           MyAccount.init();
        });
    </script>
@stop