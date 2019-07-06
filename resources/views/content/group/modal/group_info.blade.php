<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    {{$group_info->group_name}} Group&nbsp;
                </div>
            </div>
            <div class="portlet-body">
                <div class="panel-group accordion">
                @foreach($group_info->permission->groupBy('module_id') as $modules)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" href="#module_{{$modules[0]->module_id}}">
                                    {{$modules[0]->module->module_name}} Module
                                </a>
                            </h4>
                        </div>
                        <div id="module_{{$modules[0]->module_id}}" class="panel-collapse collapse">
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
                                    @foreach($modules as $module)
                                        <tr>
                                            <td>
                                                <b>{{$module->page->page_name}}</b>
                                            </td>
                                            <td>
                                                @include('common.group.button_action_list',array('action_value' => $module->action_value))
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
        <!-- END PORTLET-->
    </div>
</div>
