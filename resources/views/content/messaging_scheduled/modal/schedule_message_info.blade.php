<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    Schedule Message Detail
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
                                <b>Sending Details</b>
                            </td>
                            <td>
                                {{$send_details}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Message</b>
                            </td>
                            <td>
                                {{$blast_info->message}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
