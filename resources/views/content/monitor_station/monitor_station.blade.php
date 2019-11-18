@extends('main2')

@section('title')
    Station Time Logs
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
    Station
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <h4 class="card-description">Station list</h4>
            <form method="post" class="horizontal-form">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="station_group_id" name="station_group_id" class="select2 form-control" data-placeholder="Choose a Station Group" tabindex="1">
                                    <option value=""></option>
                                    @foreach(App\Models\Stations\StationGroup::all() as $station_group)
                                        <option value="{{$station_group->station_group_id}}">{{$station_group->group_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div id="profile_container">
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
@stop

@section('page_scripts')
    <script src="{{URL::to('/')}}/assets/page/scripts/monitor/monitor_station.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {
            MonitorStation.setPort({{$port}});
            MonitorStation.setHost('{{$host}}');
            MonitorStation.init();
        });
    </script>
@stop