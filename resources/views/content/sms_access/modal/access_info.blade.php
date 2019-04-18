<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    SMS Access Information
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>
                                <b>Server Name</b>
                            </td>
                            <td>
                                {{$access_info->server->server_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Prefix Group Name</b>
                            </td>
                            <td>
                                {{$access_info->group->group_name}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
