@extends('main2')

@section('title')
    User Form
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
    User
@stop

@section('content')
    @if(Session::has('success'))
        <div id="prefix_326109465929" class="Metronic-alerts alert alert-warning fade in">
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button"></button>
            {{ Session::get('success') }}
        </div>
    @endif
    @if(Session::has('warning'))
        <div id="prefix_326109465929" class="Metronic-alerts alert alert-warning fade in">
            <button class="close" aria-hidden="true" data-dismiss="alert" type="button"></button>
            {{ Session::get('warning') }}
        </div>
    @endif
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                User Form
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form method="post" class="horizontal-form" id="users_form">
                <div class="form-body">
                        <h3 class="form-section">Login Info</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    {!!
                                        Form::text('username',isset($user_data)?$user_data->username:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'username',
                                            'placeholder'=>'Username',
                                            (isset($user_data)?'readonly':'') => ''
                                        ))
                                    !!}
                                    @if (isset($user_data))
                                        <input type="hidden" id="user_id" value="{{$user_data->user_id}}" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Status</label>
                                    {!!
                                        Form::select('status',
                                            array(
                                                'Active'=>'Active',
                                                'Inactive'=>'Inactive'
                                            ),
                                            isset($user_data)?$user_data->status:null,
                                            array(
                                                'class'=>'select2_category form-control',
                                                'id'=>'status',
                                                'data-placeholder'=>'Choose a Status',
                                                'tabindex' => '1'
                                            )
                                        )
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Group</label>
                                    <select id="group_id" name="group_id" class="select2_category form-control" data-placeholder="Choose a Category" tabindex="1">
                                        @foreach(App\Models\ACL\Group::all() as $group)
                                            @if (isset($user_data) && ($group->group_id == $user_data->group_id))
                                            <option selected="selected" value="{{$group->group_id}}">{{$group->group_name}}</option>
                                            @else
                                            <option value="{{$group->group_id}}">{{$group->group_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <h3 class="form-section">Personal Info</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    {!!
                                        Form::text('first_name',isset($user_data)?$user_data->userinfo->first_name:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'first_name',
                                            'placeholder'=>'First Name'
                                        ))
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Middle Name</label>
                                    {!!
                                        Form::text('middle_name',isset($user_data)?$user_data->userinfo->middle_name:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'middle_name',
                                            'placeholder'=>'Middle Name'
                                        ))
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    {!!
                                        Form::text('last_name',isset($user_data)?$user_data->userinfo->last_name:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'last_name',
                                            'placeholder'=>'Last Name'
                                        ))
                                    !!}
                                </div>
                            </div>
                        </div>
                </div>
                <div class="form-actions right">
                        <a class=" btn default" href="{{URL::to('users')}}">
                            Back
                        </a>
                        @if (!isset($user_data))
                        <button type="submit" class="btn blue"><i class="fa fa-check"></i>Save</button>
                        @else
                        <button type="submit" class="btn blue"><i class="fa fa-check"></i>Update</button>
                        @endif
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
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
    <script src="{{URL::to('/')}}/assets/page/scripts/users/users_form.js"></script>

@stop

@section('init_js')
    @if (!isset($user_data))
    <script>
        jQuery(document).ready(function() {       
           UsersForm.init();
        });
    </script>
    @else
    <script>
        jQuery(document).ready(function() {       
           UsersForm.initUpdate();
        });
    </script>
    @endif
@stop
