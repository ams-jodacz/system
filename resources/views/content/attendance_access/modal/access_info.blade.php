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
                                <b>Classification Name</b>
                            </td>
                            <td>
                                {{$attendance_access_info->classificationGroup->classification->classification_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Classification Group Name</b>
                            </td>
                            <td>
                                {{$attendance_access_info->classificationGroup->group_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Attendance Station Group</b>
                            </td>
                            <td>
                                {{$attendance_access_info->group->group_name}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
