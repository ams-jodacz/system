<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet box blue" style="margin-bottom:0px">
            <div class="portlet-title">
                <div class="caption">
                    Guest Tag Information
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>
                                <b>Guest Group Name</b>
                            </td>
                            <td>
                                {{$guest_tag_info->group->group_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Tag Name</b>
                            </td>
                            <td>
                                {{$guest_tag_info->tag_name}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>ID Number</b>
                            </td>
                            <td>
                                {{$guest_tag_info->id_number}} &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Tag</b>
                            </td>
                            <td>
                                {{($guest_tag_info->tag!=null)?$guest_tag_info->tag:'NA'}} &nbsp;
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
