<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    Access Information
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>
                                <b>Station Group</b>
                            </td>
                            <td>
                                {{$guest_access_info->station->group_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Guest Group Name</b>
                            </td>
                            <td>
                                {{$guest_access_info->guestGroup->group_name}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
