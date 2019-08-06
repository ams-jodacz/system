<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    Attendance Station Information
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
                                {{$attendance_station_info->name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>IP</b>
                            </td>
                            <td>
                                {{$attendance_station_info->ip}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Group Name</b>
                            </td>
                            <td>
                                {{$attendance_station_info->group->group_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Enable Status</b>
                            </td>
                            <td>
                                {{$attendance_station_info->enable_status?'Enabled':'Disabled'}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Description</b>
                            </td>
                            <td>
                                {{$attendance_station_info->description}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
