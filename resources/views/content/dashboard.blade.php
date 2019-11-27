@extends('main')

@section('title')
    Dashboard
@stop

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
@stop

@section('breadcrumb')
    
@stop

@section('page_header')
    Dashboard
@stop

@section('content')
 <div class="card">
     <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                    <h4 class="card-title">DTR records</h4>
                    <p class="card-description">Use this module to view DTR records</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Member:</label>
                    <input type="text" class="form-control" id="member_filter" class="form-control">
                </div>       
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Date Start:</label>
                    <input readonly="readonly" class="form-control" id="date_start" type="text" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Date End:</label>
                    <input readonly="readonly" class="form-control" id="date_end" type="text" />
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">&nbsp;</label>
                    <button type="button" class="form-control btn btn-success pull-right" id="get-report">Report</button>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">&nbsp;</label>
                    <button type="button" class="form-control btn btn-success pull-right" id="print-dtr">Print Record</button>
                </div>
            </div>
        </div>

        <div class="card" id="report_area">
        </div>   
    </div>
</div>
@stop

@section('page_js_plugins')
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/admin/layout/scripts/printThis.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/dashboard.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
           Dashboard.init();
        });
    </script>
@stop