<div class="portlet box blue-hoki">
    <div class="portlet-title">
        <div class="caption">
            Recipient List
        </div>
        <div class="actions">
            <a class=" btn default green btn-xs" href="{{URL::to('member/view/0?actionType=recipient&id=0')}}" data-target="#recipient_info_ajax" data-toggle="modal">
                <i class="fa fa-plus"></i>
                Add
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover" id="member_rf_list_table">
            <thead>
                <tr>
                    <th>
                        First Name
                    </th>
                    <th>
                        Middle Name
                    </th>
                    <th>
                        Last Name
                    </th>
                    <th>
                        Contact Number
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="rf_action_str" style="display:none">
            <a class="update_recipient_btn btn default btn-xs" data-id="##NUM##" href="{{URL::to('member/view/0?actionType=recipient&id=##NUM##')}}" data-target="#recipient_info_ajax" data-toggle="modal">
                <i class="fa fa-edit"></i>
                Update
            </a>
            <a data-id="##NUM##" class="remove_recipient_btn btn default btn-xs red">
                <i class="fa fa-trash"></i>
                Remove
            </a>
        </div>
    </div>
</div>
<!--Modal Start-->
<div class="modal fade" id="recipient_info_ajax" role="basic" aria-hidden="true">
    <div class="page-loading page-loading-boxed">
        <img src="{{URL::to('/')}}/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
        <span>
            &nbsp;&nbsp;Loading...
        </span>
    </div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!--Modal End-->