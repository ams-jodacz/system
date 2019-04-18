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
                                <b>Description</b>
                            </td>
                            <td>
                                {{$late_absent_info->description}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Late Time</b>
                            </td>
                            <td>
                                {{Carbon\Carbon::createFromFormat('H:i:s',$late_absent_info->late_time)->format('h:i A')}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Late Message</b>
                            </td>
                            <td>
                                {{$late_absent_info->late_message}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Absent Time</b>
                            </td>
                            <td>
                                {{Carbon\Carbon::createFromFormat('H:i:s',$late_absent_info->absent_time)->format('h:i A')}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Absent Message</b>
                            </td>
                            <td>
                                {{$late_absent_info->absent_message}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
