@extends('main2')

@section('title')
    Station Controller
@stop

@section('page_level_styles')
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
@stop

@section('breadcrumb')
    
@stop

@section('page_header')
    Station Controller
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        Station List
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="station_controller_list_table">
                        <thead>
                            <tr>
                                <th>
                                    Station Group
                                </th>
                                <th>
                                    Station Name
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Restart Status
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <div id="action_str" style="display:none">
                        <a class=" btn default btn-xs" href="{{URL::to('monitor/controller/view/##NUM##')}}" data-target="#info_ajax" data-toggle="modal">
                            <i class="fa fa-eye"></i>
                            View
                        </a>
                    </div>
                    <div id="action_str2" style="display:none">
                        <a data-id="##NUM##" class="restart_btn btn default btn-xs green">
                            <i class="fa fa-edit"></i>
                            Restart
                        </a>
                    </div>
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
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/monitor/monitor_controller.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
           MonitorController.init();
        });
    </script>
@stop