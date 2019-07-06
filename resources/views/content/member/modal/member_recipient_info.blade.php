<div class="portlet box blue-hoki">
    <div class="portlet-title">
        <div class="caption">
            Recipient List
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
                </tr>
            </thead>
            <tbody>
                @foreach($member_info->recipients as $recipient)
                    <tr>
                        <th>
                            {{$recipient->first_name}}
                        </th>
                        <th>
                            {{$recipient->middle_name}}
                        </th>
                        <th>
                            {{$recipient->last_name}}
                        </th>
                        <th>
                            {{$recipient->contact_number}}
                        </th>
                        <th>
                            {{$recipient->email}}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
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