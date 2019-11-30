@extends('main')

@section('title')
    Member
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
    Members
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <h4 class="card-title">
                        Member List
                    </h4>
                </div>
                <div class="col-md-3">
                    <div class="pull-right">
                        @include('common.button',array('base_url'=>'member','base_id'=>'member','buttons'=>array('add'),'action_value'=>$action_value))
                    </div>
                </div>
            </div>
            
            <table class="table table-striped table-bordered table-hover" id="member_list_table">
                <thead>
                    <tr>
                        <th>
                            Profile
                        </th>
                        <th>
                            ID Number
                        </th>
                        <th>
                            First Name
                        </th>
                        <th>
                            Middle Name
                        </th>
                        <th>
                            Last Name
                        </th>
                        <th>
                            Contact Number
                        </th>
                        <th>
                            CLassification
                        </th>
                        <th>
                            Group
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
            </table>

            <div id="action_tbl_filter_str" style="display:none">
                <div>
                    <?php
                        $filter = array(
                            '1' => 'Active',
                            '0' => 'In Active',
                        );
                    ?>
                    <label>
                        &nbsp;
                        <select id="active_status" class="input-medium input-inline form-control" tabindex="1">
                        <option value="">All</option>
                            @foreach($filter as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>  
                    </label>
                    <label>
                        &nbsp;
                        <input type="text" class="input-medium input-inline form-control" id="group_filter">
                    </label>
                </div>
            </div>
            <div id="action_str" style="display:none">
                <a class=" btn default btn-xs" href="{{URL::to('member/view/##NUM##')}}" data-target="#delivery_info_ajax" data-toggle="modal">
                    <i class="fa fa-eye"></i>
                    View
                </a>
                @if ($action_value&App\Models\ACL\Action::$Edit)
                <a data-id="##NUM##" href="{{URL::to('member/update/##NUM##')}}" class="btn default btn-xs green">
                    <i class="fa fa-edit"></i>
                    Update
                </a>
                @endif
                @if ($action_value&App\Models\ACL\Action::$Delete)
                <a data-id="##NUM##" class="remove_btn btn default btn-xs red">
                    <i class="fa fa-trash"></i>
                    Remove
                </a>
                @endif
            </div>
            <div id="action_str_2" style="display:none">
                @if ($action_value&App\Models\ACL\Action::$Edit)
                    <a data-id="##NUM##" class="purge_tag btn default btn-xs red">
                        <!-- <i class="fa fa-trash"></i> -->
                        Purge Tag
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!--Modal Start-->
    <div class="modal fade bs-modal-lg" id="delivery_info_ajax" role="basic" aria-hidden="true">
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
    <script src="{{URL::to('/')}}/assets/page/scripts/member/member.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
           Member.init();
        });
    </script>
@stop