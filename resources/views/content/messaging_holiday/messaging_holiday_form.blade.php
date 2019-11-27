@extends('main')

@section('title')
    Messaging | Holiday
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
    Holiday
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-description">Holiday Form</h4>
            <!-- BEGIN FORM-->
            <form method="post" class="horizontal-form" id="holiday_form">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                {!!
                                    Form::text('name',isset($holiday_data)?$holiday_data->name:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'name',
                                        'placeholder'=>'Name',
                                    ))
                                !!}
                                @if (isset($holiday_data))
                                    <input type="hidden" id="sms_prefix_id" value="{{$holiday_data->sms_prefix_id}}" />
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Date</label>
                                {!!
                                    Form::text('date',isset($holiday_data)?$holiday_data->date:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'date',
                                        'placeholder'=>'Date',
                                        'readonly' => 'readonly',
                                    ))
                                !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                {!!
                                    Form::text('description',isset($holiday_data)?$holiday_data->description:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'description',
                                        'placeholder'=>'Description',
                                    ))
                                !!}
                            </div>                                
                        </div>
                    </div>
                </div>
                <div class="form-actions right">
                        <a class=" btn default" href="{{URL::to('blast/holiday')}}">
                            Back
                        </a>
                        @if (!isset($holiday_data))
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
    <script src="{{URL::to('/')}}/assets/page/scripts/messaging_holiday/holiday_form.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
            HolidayForm.init();
        });
    </script>
@stop