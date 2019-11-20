<?php $sequence = array(7,4,5,6,3,2,10,9,8,1) ?>
<?php 
    $data = App\Models\ACL\User::find(Auth::id())->group->permission->groupBy('module_id');
?>
<li>
    <a href="{{URL::to('/')}}">
        <i class="icon-home"></i>
        <span class="title">Dashboard</span>
    </a>
</li>
@foreach($sequence as $sequence_num)
    @foreach($data as $permissions)
        <?php if ($permissions[0]->module_id == $sequence_num){ ?>
            @if (count($permissions) > 1)
                <li>
                    <a href="javascript:;">
                        <i class="icon-folder"></i>
                        <span class="title">
                            {{$permissions[0]->module->module_name}}
                        </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        @foreach($permissions as $permission)
                        <li>
                            <a href="{{URL::to($permission->page->page_url)}}">
                                <i class="icon-folder-alt"></i>
                                {{$permission->page->page_name}}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            @else
                @foreach($permissions as $permission)
                <li>
                    <a href="{{URL::to($permission->page->page_url)}}">
                        <i class="icon-folder"></i>
                        <span class="title">
                            {{$permission->module->module_name.'-'.$permission->page->page_name}}
                        </span>
                    </a>
                </li>
                @endforeach
            @endif
        <?php } ?>
    @endforeach
@endforeach