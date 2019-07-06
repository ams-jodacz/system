<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    Station Information
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>
                                <b>Name</b>
                            </td>
                            <td>
                                {{$station_info->name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>IP</b>
                            </td>
                            <td>
                                {{$station_info->ip}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Group Name</b>
                            </td>
                            <td>
                                {{$station_info->stationGroup->group_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Status</b>
                            </td>
                            <td>
                                {{$station_info->status}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Enable Status</b>
                            </td>
                            <td>
                                {{$station_info->enable_status?'Enabled':'Disabled'}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Description</b>
                            </td>
                            <td>
                                {{$station_info->description}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Status</b>
                            </td>
                            <td>
                                {{$station_info->station_status?'Up':'Down'}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
