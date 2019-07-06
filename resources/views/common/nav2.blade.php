@foreach(App\Models\ACL\User::find(Auth::id())->group->permission->groupBy('module_id') as $permissions)
    <?php if ($permissions[0]->module_id == 2){ ?>
        @foreach($permissions as $permission)
        <li>
            <a href="{{URL::to($permission->page->page_url)}}">
                <i class="icon-puzzle"></i>
                <span class="title">
                    {{$permission->page->page_name}}
                </span>
            </a>
        </li>
        @endforeach
    <?php } ?>
@endforeach
@foreach(App\Models\ACL\User::find(Auth::id())->group->permission->groupBy('module_id') as $permissions)
    <?php if ($permissions[0]->module_id == 1){ ?>
        <li>
            <a href="javascript:;">
                <i class="icon-puzzle"></i>
                <span class="title">
                    {{$permissions[0]->module->module_name}}
                </span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                @foreach($permissions as $permission)
                <li>
                    <a href="{{URL::to($permission->page->page_url)}}">
                        {{$permission->page->page_name}}
                    </a>
                </li>
                @endforeach
            </ul>
        </li>
    <?php } ?>
@endforeach