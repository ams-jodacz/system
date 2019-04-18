@extends('main2')

@section('title')
    Groups
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
    Group
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        Group List
                    </div>
                    <div class="actions">
                        @include('common.button',array('base_url'=>'users/group','base_id'=>'group','buttons'=>array('add'),'action_value'=>$action_value))
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="group_list_table">
                        <thead>
                            <tr>
                                <th>
                                    Group Name
                                </th>
                                <th>
                                    Module Names
                                </th>
                                <th>
                                    Pages
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(App\Models\ACL\Group::where('group_id','<>',1)->get() as $group)
                        <!--foreach(Group::all() as $group)-->
                            <tr class="row_{{$group->group_id}}">
                                <td>
                                    {{$group->group_name}}
                                </td>
                                <td>
                                    @foreach($group->permission->groupBy('module_id') as $modules)
                                    <a class="btn default btn-xs purple">
                                        {{$modules[0]->module->module_name}}
                                    </a>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->permission->groupBy('module_id') as $modules)
                                        @foreach($modules as $pages)
                                        <a class="btn default btn-xs blue">
                                            {{$pages->page->page_name}}
                                        </a>
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    <a class=" btn default btn-xs" href="{{URL::to('users/group/view/'.$group->group_id)}}" data-target="#group_info_ajax" data-toggle="modal">
                                        <i class="fa fa-eye"></i>
                                        View
                                    </a>
                                    @include('common.button',array('data_id'=>$group->group_id,'base_url'=>'users/group','base_id'=>'group','buttons'=>array('edit'),'action_value'=>$action_value))
                                    @if ($action_value&App\Models\ACL\Action::$Delete)
                                    <a data_id="{{$group->group_id}}" class="remove_group btn default btn-xs red">
                                        <i class="fa fa-trash"></i>
                                        Remove
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--Modal Start-->
    <div class="modal fade" id="group_info_ajax" role="basic" aria-hidden="true">
        <div class="page-loading page-loading-boxed">
            <img src="{{URL::to('/')}}/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
            <span>
                &nbsp;&nbsp;Loading...
            </span>
        </div>
        <div class="modal-dialog">
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
    <script src="{{URL::to('/')}}/assets/page/scripts/groups/group.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
           Group.init();
        });
    </script>
@stop