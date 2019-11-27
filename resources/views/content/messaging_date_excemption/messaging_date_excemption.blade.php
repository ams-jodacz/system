@extends('main')

@section('title')
    Messaging | Date Exemption 
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
    Date Exemption
@stop

@section('content')
    <div class="card">
        <div class="portlet-title">


        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <h4 class="card-description">
                        Date Exemption Messaging
                    </h4>
                </div>
                <div class="col-md-3">
                    <div class="pull-right">
                        @include('common.button',array('base_url'=>'blast/excemption','base_id'=>'excemption','buttons'=>array('add'),'action_value'=>$action_value))
                    </div>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover" id="scheduled_messaging_table">
                <thead>
                    <tr>
                        <th>
                            Recipients
                        </th>
                        <th>
                            Start Date
                        </th>
                        <th>
                            End Date
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
            </table>
            <div id="action_str" style="display:none">
                <a class=" btn default btn-xs" href="{{URL::to('blast/excemption/view/##NUM##')}}" data-target="#info_ajax" data-toggle="modal">
                    <i class="fa fa-eye"></i>
                    View
                </a>
                @if ($action_value&App\Models\ACL\Action::$Delete)
                <a data-id="##NUM##" class="remove_btn btn default btn-xs red">
                    <i class="fa fa-trash"></i>
                    Remove
                </a>
                @endif
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
    <script src="{{URL::to('/')}}/assets/page/scripts/messaging_date_excemption/date_excemption.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
           DateExcemption.init();
        });
    </script>
@stop