<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    Member Information
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>
                                <b>Classification</b>
                            </td>
                            <td>
                                {{$member_info->classificationGroup->classification->classification_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Group Name</b>
                            </td>
                            <td>
                                {{$member_info->classificationGroup->group_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>ID Number</b>
                            </td>
                            <td>
                                {{$member_info->id_number}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>First Name</b>
                            </td>
                            <td>
                                {{$member_info->memberInformation->first_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Middle Name</b>
                            </td>
                            <td>
                                {{$member_info->memberInformation->middle_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Last Name</b>
                            </td>
                            <td>
                                {{$member_info->memberInformation->last_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Status</b>
                            </td>
                            <td>
                                {{($member_info->active_status)?'Active':'Inactive'}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Contact Number</b>
                            </td>
                            <td>
                                {{$member_info->memberInformation->contact_number}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Email</b>
                            </td>
                            <td>
                                {{$member_info->memberInformation->email}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Tag</b>
                            </td>
                            <td>
                                <?php echo (!empty($member_info->tag->tag))?$member_info->tag->tag:'None'; ?> &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
                @include('content.member.modal.member_recipient_info')
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
