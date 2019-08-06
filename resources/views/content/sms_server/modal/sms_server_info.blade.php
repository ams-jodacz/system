<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    SMS Server Information
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
                                {{$sms_server_info->server_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>IP</b>
                            </td>
                            <td>
                                {{$sms_server_info->ip}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Username</b>
                            </td>
                            <td>
                                {{$sms_server_info->username}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Password</b>
                            </td>
                            <td>
                                {{$sms_server_info->password}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
