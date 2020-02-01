@extends('main')

@section('title')
    Station Time Logs
@stop

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css"/>
@stop

@section('breadcrumb')
    
@stop

@section('page_header')
    Station Time Logs
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="card-title">History</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Gate:</label>
                        <select id="station_group_id" name="station_group_id" class="form-control" data-placeholder="Choose a Station" tabindex="1">
                            <option></option>
                            @foreach(App\Models\Stations\StationGroup::all() as $station_group)
                                <option value="{{$station_group->station_group_id}}">{{$station_group->group_name}}</option>
                            @endforeach
                        </select>
                    </div>       
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Date Time Start:</label>
                        <input readonly="readonly" class="form-control" id="date_time_start" type="text" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Date Time End:</label>
                        <input readonly="readonly" class="form-control" id="date_time_end" type="text" />
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <button type="button" class="form-control btn btn-success pull-right" id="filter_data">Filter</button>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <button type="button" class="form-control btn btn-success pull-right" id="generate_report_data">Report</button>
                    </div>
                </div>
            </div>

            <div id="report_area">
            </div>   

            <table class="table table-striped table-bordered table-hover" id="station_log_list_table">
                <thead>
                    <tr>
                        <th>
                            Station Group
                        </th>
                        <th>
                            Station Name
                        </th>
                        <th>
                            ID Number
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Date Time
                        </th>
                        <th>
                            Image
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
            </table>
            <div id="action_str" style="display:none">
                <a class=" btn default btn-xs" href="{{URL::to('monitor/station/view/##NUM##')}}" data-target="#info_ajax" data-toggle="modal">
                    <i class="fa fa-eye"></i>
                    View
                </a>
            </div>
            </div>
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
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>    
    <script type="text/javascript" src="{{URL::to('/')}}/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/assets/admin/layout/scripts/printThis.js"></script>
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/monitor/monitor_history.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
           MonitorHistory.init();
        });
    </script>
@stop