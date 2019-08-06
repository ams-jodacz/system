<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    User Information
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>
                                <b>First Name</b>
                            </td>
                            <td>
                                {{$user_info->userinfo->first_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Middle Name</b>
                            </td>
                            <td>
                                {{$user_info->userinfo->middle_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Last Name</b>
                            </td>
                            <td>
                                {{$user_info->userinfo->last_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Group Name</b>
                            </td>
                            <td>
                                {{$user_info->group->group_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Status</b>
                            </td>
                            <td>
                                {{$user_info->status}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
