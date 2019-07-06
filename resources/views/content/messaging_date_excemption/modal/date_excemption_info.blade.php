<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    Late Absent Notification Information
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>
                                <b>Recipients</b>
                            </td>
                            <td>
                                {{$recipients}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Start Date Time</b>
                            </td>
                            <td>
                                {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date_excemption_info->start_date_time)->format('M d,y h:i A')}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>End Date Time</b>
                            </td>
                            <td>
                                {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date_excemption_info->end_date_time)->format('M d,y h:i A')}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
