@extends('main2')

@section('title')
    SMS Prefix
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
    SMS Prefix Form
@stop

@section('content')
    <div class="portlet box blue-hoki">
        <div class="portlet-title">
            <div class="caption">
                SMS Prefix Form
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form method="post" class="horizontal-form" id="sms_server_form">
                <div class="form-body">
                        <h3 class="form-section">SMS Prefix Form</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Group Name</label>
                                    <select id="sms_prefix_group_id" name="sms_prefix_group_id" class="select2 form-control" data-placeholder="Choose a Prefix Group" tabindex="1">
                                        @foreach(App\Models\SMS\Group::all() as $group)
                                            @if (isset($prefix_data) && ($group->sms_prefix_group_id == $prefix_data->sms_prefix_group_id))
                                            <option selected="selected" value="{{$group->sms_prefix_group_id}}">{{$group->group_name}}</option>
                                            @else
                                            <option value="{{$group->sms_prefix_group_id}}">{{$group->group_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if (isset($prefix_data))
                                        <input type="hidden" id="sms_prefix_id" value="{{$prefix_data->sms_prefix_id}}" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Prefix</label>
                                    {!!
                                        Form::text('prefix',isset($prefix_data)?$prefix_data->prefix:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'prefix',
                                            'placeholder'=>'Prefix',
                                            'maxlength' => '3',
                                            'minlength' => '3',
                                        ))
                                    !!}
                                    <p class="help-block">
                                        Please enter 3 digit prefix. E.g: 915, 935
                                    </p>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="form-actions right">
                        <a class=" btn default" href="{{URL::to('sms/prefix')}}">
                            Back
                        </a>
                        @if (!isset($prefix_data))
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
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/sms_prefix/prefix_form.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
            PrefixForm.init(
                '<?php echo isset($prefix_data)?'update':'add'; ?>'
            );
        });
    </script>
@stop