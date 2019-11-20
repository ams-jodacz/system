@extends('main2')

@section('title')
    Guest | Tag
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
    Guest Tag Form
@stop

@section('content')
    <div class="card">
        <div class="card-body"> 
            <p class="card-description">Guest Tag Form</p>
            <!-- BEGIN FORM-->
            <form method="post" class="horizontal-form" id="guest_tag_form">
                <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Guest Group</label>
                                    <select id="guest_group_id" name="guest_group_id" class="select2 form-control" data-placeholder="Choose a Guest Group" tabindex="1">
                                        @foreach(App\Models\Guests\GuestGroup::all() as $guest_group)
                                            @if (isset($guest_tag_data) && ($guest_tag_data->guest_group_id == $guest_group->guest_group_id))
                                                <option selected="selected" value="{{$guest_group->guest_group_id}}">{{$guest_group->group_name}}</option>
                                            @else
                                                <option value="{{$guest_group->guest_group_id}}">{{$guest_group->group_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Tag Name</label>
                                    {!!
                                        Form::text('tag_name',isset($guest_tag_data)?$guest_tag_data->tag_name:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'tag_name',
                                            'placeholder'=>'Tag Name',
                                        ))
                                    !!}
                                    @if (isset($guest_tag_data))
                                        <input type="hidden" id="tag_id" value="{{$guest_tag_data->tag_id}}" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">ID Number</label>
                                    {!!
                                        Form::text('id_number',isset($guest_tag_data)?$guest_tag_data->id_number:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'id_number',
                                            'placeholder'=>'ID Number',
                                        ))
                                    !!}
                                </div>
                            </div>
                        </div>
                </div>
                <div class="form-actions pull-right">
                        <a class=" btn default" href="{{URL::to('guest')}}">
                            Back
                        </a>
                        @if (!isset($guest_tag_data))
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
    <script src="{{URL::to('/')}}/assets/page/scripts/guest_tag/guest_tag_form.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
            GuestTagForm.init(
                '<?php echo isset($guest_tag_data)?'update':'add'; ?>'
            );
        });
    </script>
@stop