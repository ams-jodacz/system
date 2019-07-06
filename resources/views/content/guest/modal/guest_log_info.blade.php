<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    Guest Information
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>
                                <b>Guest Group</b>
                            </td>
                            <td>
                                {{$guest_log_info->tag->group->group_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>ID Number</b>
                            </td>
                            <td>
                                {{$guest_log_info->tag->id_number}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Tag Name</b>
                            </td>
                            <td>
                                {{$guest_log_info->tag->tag_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Users</b>
                            </td>
                            <td>
                                {{$guest_log_info->users}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Reason</b>
                            </td>
                            <td>
                                {{$guest_log_info->reason}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Items</b>
                            </td>
                            <td>
                                {{$guest_log_info->items}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Time In</b>
                            </td>
                            <td>
                                {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$guest_log_info->borrow_date_time)->format('m-d-Y h:i:s A')}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Time Out</b>
                            </td>
                            <td>
                                {{($guest_log_info->return_date_time == null)?'Not Returned Yet':Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$guest_log_info->return_date_time)->format('m-d-Y h:i:s A')}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
