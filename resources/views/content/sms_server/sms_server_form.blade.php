@extends('main2')

@section('title')
    SMS Server
@stop

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-datepicker/css/datepicker.css"/>
@stop

@section('breadcrumb')
    
@stop

@section('page_header')
    SMS Server
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-description">SMS Server Form</h4>
            <!-- BEGIN FORM-->
            <form method="post" class="horizontal-form" id="sms_server_form">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Server Name</label>
                                {!!
                                    Form::text('server_name',isset($server_data)?$server_data->server_name:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'server_name',
                                        'placeholder'=>'Server Name',
                                    ))
                                !!}
                                @if (isset($server_data))
                                    <input type="hidden" id="sms_server_id" value="{{$server_data->sms_server_id}}" />
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">IP</label>
                                {!!
                                    Form::text('ip',isset($server_data)?$server_data->ip:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'ip',
                                        'placeholder'=>'IP',
                                    ))
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Username</label>
                                {!!
                                    Form::text('username',isset($server_data)?$server_data->username:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'username',
                                        'placeholder'=>'Username',
                                    ))
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Password</label>
                                {!!
                                    Form::text('password',isset($server_data)?$server_data->password:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'password',
                                        'placeholder'=>'Password',
                                    ))
                                !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions right">
                        <a class=" btn default" href="{{URL::to('sms/server')}}">
                            Back
                        </a>
                        @if (!isset($server_data))
                        <button type="submit" class="btn blue"><i class="fa fa-check"></i>Save</button>
                        @else
                        <button type="submit" class="btn blue"><i class="fa fa-check"></i>Update</button>
                        @endif
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
    <!--Modal Start-->
    <div class="modal fade" id="loading_image" role="basic" aria-hidden="true">
        <div class="page-loading page-loading-boxed">
            <img src="{{URL::to('/')}}/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
            <span>
                &nbsp;&nbsp;Loading...
            </span>
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
    <script src="{{URL::to('/')}}/assets/page/scripts/sms_server/server_form.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
            ServerForm.init(
                '<?php echo isset($server_data)?'update':'add'; ?>'
            );
        });
    </script>
@stop