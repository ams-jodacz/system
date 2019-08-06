@extends('main2')

@section('title')
    Users
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
    Users
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        User List
                    </div>
                    <div class="actions">
                        @include('common.button',array('base_url'=>'users','base_id'=>'users','buttons'=>array('add'),'action_value'=>$action_value))
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="user_list_table">
                        <thead>
                            <tr>
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
                        <tbody>
                        @foreach(App\Models\ACL\User::where('user_id','<>',Auth::id())->where('remove_status','<>','Active')->get() as $user)
                            <tr class="row_{{$user->user_id}}">
                                <td>
                                    {{$user->userinfo->first_name}}
                                </td>
                                <td>
                                    {{$user->userinfo->middle_name}}
                                </td>
                                <td>
                                    {{$user->userinfo->last_name}}
                                </td>
                                <td>
                                    {{$user->group->group_name}}
                                </td>
                                <td>
                                    <span id="status_field_{{$user->user_id}}" class="label label-sm {{($user->status=='Active'?'label-success':'label-danger')}}">{{$user->status}}</span>
                                </td>
                                <td>
                                    @if ($action_value&App\Models\ACL\Action::$Edit)
                                    <a data_id="{{$user->user_id}}" class="reset_pwd btn default btn-xs purple">
                                        <!--<i class="fa fa-edit"></i>-->
                                        Reset Password
                                    </a>
                                    <a data_id="{{$user->user_id}}" class="users_change_status btn default btn-xs purple">
                                        <!--<i class="fa fa-edit"></i>-->
                                        Change Status
                                    </a>
                                    @endif
                                    <a class=" btn default btn-xs" href="{{URL::to('users/view/'.$user->user_id)}}" data-target="#user_info_ajax" data-toggle="modal">
                                        <i class="fa fa-eye"></i>
                                        View
                                    </a>
                                    @include('common.button',array('data_id'=>$user->user_id,'base_url'=>'users','base_id'=>'users','buttons'=>array('edit'),'action_value'=>$action_value))
                                    @if ($action_value&App\Models\ACL\Action::$Delete)
                                    <a data_id="{{$user->user_id}}" class="remove_user btn default btn-xs red">
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
    <div class="modal fade" id="user_info_ajax" role="basic" aria-hidden="true">
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
    <script src="{{URL::to('/')}}/assets/page/scripts/users/users.js"></script>
@stop

@section('init_js')
    <script>
        jQuery(document).ready(function() {       
           Users.init();
        });
    </script>
@stop