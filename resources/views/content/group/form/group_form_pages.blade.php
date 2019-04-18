<div class="row">
    <div class="col-md-12">
        <div class="panel-group accordion">
            @foreach(App\Models\ACL\Module::all() as $module)
                <div id="module_page_container_{{$module->module_id}}" class="panel panel-default" style="display:none">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" href="#module_{{$module->module_id}}">
                                {{$module->module_name}} Module
                            </a>
                        </h4>
                    </div>
                    <div id="module_{{$module->module_id}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            Page Name
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($module->page as $page)
                                    <tr>
                                        <td>
                                            {!!
                                                Form::checkbox('page_'.$page->page_id.'[]',$page->page_id,
                                                (isset($group_data)&&count($group_data->permission()->where('page_id',$page->page_id)->get()))?true:false,
                                                array(
                                                    'class'=>'icheck module_pages page_module_'.$module->module_id,
                                                    'data-checkbox' => 'icheckbox_square-grey'
                                                ));
                                            !!}
                                            <b>{{$page->page_name}}</b>
                                        </td>
                                        <td>
                                            @foreach(App\Models\ACL\Action::getActionList() as $id => $name)
                                                @if (($id & $page->page_max_action) && $id != App\Models\ACL\Action::$View)
                                                    <label>
                                                    {!!
                                                        Form::checkbox('page_'.$page->page_id.'_'.$module->module_id.'[]',$id,
                                                        (isset($group_data)&&
                                                        count($group_data->permission()->where('page_id',$page->page_id)->get())&&
                                                        (App\Models\ACL\Permission::where(
                                                            array(
                                                                'group_id'=>$group_data->group_id,
                                                                'module_id'=>$module->module_id,
                                                                'page_id'=>$page->page_id,
                                                            )
                                                        )->first()->action_value&$id))?true:false,
                                                        array(
                                                            'class'=>'icheck module_page_'.$page->page_id.' module_page_action_'.$module->module_id,
                                                            'data-checkbox' => 'icheckbox_square-grey',
                                                            (isset($group_data)&&count($group_data->permission()->where('page_id',$page->page_id)->get())==0)?'disabled':'' => ''
                                                        ));
                                                    !!}
                                                    {{$name}}
                                                    </label>
                                                    &nbsp;
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
    </div>
</div>
