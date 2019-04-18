@foreach(App\Models\ACL\Action::getActionList() as $id => $name)
    @if ($id&$action_value)
        <a class=" btn default btn-xs blue">
            {{$name}}
        </a>
    @endif
@endforeach