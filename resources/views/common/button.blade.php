@if (isset($buttons))
    @if (($action_value&App\Models\ACL\Action::$View) && in_array('view',$buttons))
        <a id="{{$base_id}}_view" class="btn default btn-xs grey" href="{{URL::to($base_url.'/update/'.$data_id)}}">
            <i class="fa fa-edit"></i>
            View
        </a>
    @endif
    @if (($action_value&App\Models\ACL\Action::$Add) && in_array('add',$buttons))
        <a id="{{$base_id}}_add" class="btn default btn-xs green" href="{{URL::to($base_url.'/add')}}">
            <i class="fa fa-edit"></i>
            Add
        </a>
    @endif
    @if (($action_value&App\Models\ACL\Action::$Edit) && in_array('edit',$buttons))
        <a id="{{$base_id}}_edit" class="btn default btn-xs yellow" href="{{URL::to($base_url.'/update/'.$data_id)}}">
            <i class="fa fa-edit"></i>
            Edit
        </a>
    @endif
    @if (($action_value&App\Models\ACL\Action::$Delete) && in_array('delete',$buttons))
        <a id="{{$base_id}}_delete" class="btn default btn-xs red">
            <i class="fa fa-edit"></i>
            Delete
        </a>
    @endif
@endif