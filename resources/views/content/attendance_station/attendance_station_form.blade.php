@extends('main2')

@section('title')
    Attendance Station
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
    Attendance Station
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-description">
                Attendance Station Form
            </h4>
            <!-- BEGIN FORM-->
            <form method="post" class="horizontal-form" id="attendance_station_form">
                <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Station Name</label>
                                    {!!
                                        Form::text('name',isset($station_data)?$station_data->name:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'name',
                                            'placeholder'=>'Station Name',
                                        ))
                                    !!}
                                    @if (isset($station_data))
                                        <input type="hidden" id="attendance_station_id" value="{{$station_data->attendance_station_id}}" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Group Name</label>
                                    <select id="attendance_group_id" name="attendance_group_id" class="select2 form-control" data-placeholder="Choose a Group" tabindex="1">
                                        @foreach(App\Models\Attendance\AttendanceGroup::all() as $attendance_group)
                                            @if (isset($station_data) && ($attendance_group->attendance_group_id == $station_data->attendance_group_id))
                                            <option selected="selected" value="{{$attendance_group->attendance_group_id}}">{{$attendance_group->group_name}}</option>
                                            @else
                                            <option value="{{$attendance_group->attendance_group_id}}">{{$attendance_group->group_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">IP</label>
                                    {!!
                                        Form::text('ip',isset($station_data)?$station_data->ip:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'ip',
                                            'placeholder'=>'Station IP',
                                        ))
                                    !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    {!!
                                        Form::text('description',isset($station_data)?$station_data->description:null,
                                        array(
                                            'class'=>'form-control',
                                            'id'=>'description',
                                            'placeholder'=>'Station Description',
                                        ))
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Enable Status</label>
                                    {!!
                                        Form::select('enable_status',
                                            array(
                                                true => 'Enable',
                                                false =>'Disable'
                                            ),
                                            isset($station_data)?$station_data->enable_status:'In',
                                            array(
                                                'class'=>'select2 form-control',
                                                'id'=>'enable_status',
                                                'data-placeholder'=>'Choose a Status',
                                                'tabindex' => '1'
                                            )
                                        )
                                    !!}
                                </div>
                            </div>
                        </div>
                </div>
                <div class="form-actions right">
                        <a class=" btn default" href="{{URL::to('attendance/station')}}">
                            Back
                        </a>
                        @if (!isset($station_data))
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
    <script src="{{URL::to('/')}}/assets/page/scripts/attendance_station/attendance_station_form.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
            AttendanceStationForm.init(
                '<?php echo isset($station_data)?'update':'add'; ?>'
            );
        });
    </script>
@stop