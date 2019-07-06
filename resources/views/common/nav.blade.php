<li>
    <a href="{{URL::to('/')}}">
        <i class="icon-home"></i>
        <span class="title">Dashboard</span>
        <span class="selected"></span>
    </a>
</li>
@foreach(App\Models\ACL\User::find(Auth::id())->group->permission->groupBy('module_id') as $permissions)
    <li class="classic-menu-dropdown">
        <a data-hover="dropdown" href="javascript:;">
            <i class="icon-puzzle"></i>
            <span class="title">
                {{$permissions[0]->module->module_name}}
            </span>
            <span class="arrow "></span>
        </a>
        <!--<ul class="sub-menu">-->
        <ul class="dropdown-menu pull-left">
            @foreach($permissions as $permission)
            <li>
                <a href="{{URL::to($permission->page->page_url)}}">
                    {{$permission->page->page_name}}
                </a>
            </li>
            @endforeach
        </ul>
    </li>
@endforeach