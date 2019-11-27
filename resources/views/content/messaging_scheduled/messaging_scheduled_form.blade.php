@extends('main')

@section('title')
    Messaging | Scheduled Form
@stop

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.css" />
@stop

@section('breadcrumb')
    
@stop

@section('page_header')
    Scheduled Messaging
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-description">Scheduled messaging form</h4>
            <!-- BEGIN FORM-->
            <form method="post" class="horizontal-form" id="direct_message_form">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    {!!
                                        Form::checkbox('all',1,true,
                                        array(
                                            'id' => 'all',
                                            'class'=>'modules_btn icheck',
                                            'data-checkbox' => 'icheckbox_square-grey'
                                        ));
                                    !!}
                                    Send To All
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Classification</label>
                                <select id="class_id" name="class_id" class="select2 form-control send_to" data-placeholder="Choose a Station Group" tabindex="1">
                                    @foreach(App\Models\Classification\Classification::all() as $classification)
                                        <option value="{{$classification->class_id}}">{{$classification->classification_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Classfication Group</label>
                                <select id="class_group_id" name="class_group_id" class="select2 form-control send_to" data-placeholder="Choose a Group" tabindex="1">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Members</label>
                                <select id="member_id" name="member_id" class="select2 form-control send_to" data-placeholder="Choose a Member" tabindex="1">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>
                                    {!!
                                        Form::checkbox('occurance',1,false,
                                        array(
                                            'id' => 'occurance',
                                            'class'=>'modules_btn icheck',
                                            'data-checkbox' => 'icheckbox_square-grey'
                                        ));
                                    !!}
                                    Occurence
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 non_occurance_fields">
                            <div class="form-group">
                                <label class="control-label">Send Date</label>
                                {!!
                                    Form::text('send_date',null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'send_date',
                                        'placeholder'=>'Send Date Time',
                                    ))
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3 occurance_fields">
                            <div class="form-group">
                                <label class="control-label">Occurance Type</label>
                                {!!
                                    Form::select('occurance_type',
                                    array(
                                        'Everyday' => 'Everyday',
                                        'Weekly' => 'Weekly',
                                        'Monthly' => 'Monthly',
                                        'Yearly' => 'Yearly',
                                    ),
                                    '',
                                    array(
                                        'id' => 'occurance_type',
                                        'class'=>'select2 form-control',
                                    ));
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Time</label>
                                {!!
                                    Form::text('time',null,
                                    array(
                                        'class'=>'form-control  timepicker timepicker-default',
                                        'id'=>'time',
                                        'placeholder'=>'Time',
                                    ))
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="occurance_type_fields" id="Weekly">
                                <div class="form-group">
                                    <label class="control-label">Day of the week</label>
                                    {!!
                                        Form::select('day_of_the_week',
                                        array(
                                            'Sunday',
                                            'Monday',
                                            'Tuesday',
                                            'Wednesday',
                                            'Thursday',
                                            'Friday',
                                            'Saturday',
                                        ),
                                        '',
                                        array(
                                            'id' => 'day_of_the_week',
                                            'class'=>'select2 form-control',
                                        ));
                                    !!}
                                </div>
                            </div>
                            <div class="occurance_type_fields" id="Monthly">
                                <div class="form-group">
                                    <label class="control-label">Day of the month</label>
                                    {!!
                                        Form::text('day_of_month',null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'day_of_month',
                                            'placeholder'=>'Day of the month',
                                        ))
                                    !!}
                                </div>
                            </div>
                            <div class="occurance_type_fields" id="Yearly">
                                <div class="form-group">
                                    <label class="control-label">Date</label>
                                    {!!
                                        Form::text('date',null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'date',
                                            'placeholder'=>'Date',
                                        ))
                                    !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Message</label>
                                {!!
                                    Form::textarea('message','',
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'message',
                                        'placeholder'=>'Message',
                                        'rows' => 5,
                                        'maxlength' => '255',
                                    ))
                                !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions right">
                        <a class=" btn default" href="{{URL::to('blast/occurance')}}">
                            Back
                        </a>
                        <button type="submit" class="btn blue"><i class="fa fa-check"></i>Save</button>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
  
    
    <!--Modal Start-->
    <div class="modal fade bs-modal-lg" id="info_ajax" role="basic" aria-hidden="true">
        <div class="page-loading page-loading-boxed">
            <img src="{{URL::to('/')}}/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
            <span>
                &nbsp;&nbsp;Loading...
            </span>
        </div>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
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
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/messaging_scheduled/scheduled_form.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
            ScheduledForm.init();
        });
    </script>
@stop