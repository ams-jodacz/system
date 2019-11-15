@extends('main2')

@section('title')
    Group Form
@stop

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-datepicker/css/datepicker.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/icheck/skins/all.css"/>
@stop

@section('breadcrumb')
    
@stop

@section('page_header')
    Group
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            <!-- BEGIN FORM-->
            <form method="post" class="horizontal-form" id="group_form">
                <div class="form-body">
                        <h4 class="card-description">
                            Group Info
                        </h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Group Name</label>
                                    {!!
                                        Form::text('group_name',isset($group_data)?$group_data->group_name:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'group_name',
                                            'placeholder'=>'Group Name',
                                        ))
                                    !!}
                                    @if (isset($group_data))
                                        <input type="hidden" id="group_id" value="{{$group_data->group_id}}" />
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h4 class="card-description">
                            Module List
                        </h4>
                        <div class="row">
                            @foreach (App\Models\ACL\Module::all() as $module)
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>
                                        {!!
                                            Form::checkbox('module[]',$module->module_id,
                                            (isset($group_data)&&(count($group_data->permission()->where('module_id',$module->module_id)->get()) > 0))?true:false,
                                            array(
                                                'class'=>'modules_btn icheck',
                                                'data-checkbox' => 'icheckbox_square-grey'
                                            ));
                                        !!}
                                        {!!$module->module_name!!}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <h4 class="card-description">
                            Module Pages
                        </h4>
                        @include('content.group.form.group_form_pages')
                </div>
                <div class="form-actions right">
                        <a class=" btn default" href="{{URL::to('users/group')}}">
                            Back
                        </a>
                        @if (!isset($group_data))
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
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/icheck/icheck.min.js"></script>
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/groups/group_form.js"></script>
@stop

@section('init_js')
    @if (!isset($group_data))
    <script>
        jQuery(document).ready(function() {       
           GroupForm.init();
        });
    </script>
    @else
    <script>
        jQuery(document).ready(function() {       
           GroupForm.initUpdate();
        });
    </script>
    @endif
@stop
