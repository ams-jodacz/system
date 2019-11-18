<div style="margin-bottom: 0px" class="portlet box blue-hoki">
    <div class="portlet-title">
        <div class="caption">
            Recipient Form
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form method="post" class="horizontal-form" id="member_recipient_form">
            <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">First Name</label>
                                {!!
                                    Form::text('rf_first_name',isset($recipient_data)?$recipient_data->first_name:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'rf_first_name',
                                        'placeholder'=>'First Name',
                                    ))
                                !!}
                            </div>
                            @if (isset($recipient_data))
                                <input type="hidden" id="recipient_id" value="{{$recipient_data->recipient_id}}" />
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Middle Name</label>
                                {!!
                                    Form::text('rf_middle_name',isset($recipient_data)?$recipient_data->middle_name:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'rf_middle_name',
                                        'placeholder'=>'Middle Name',
                                    ))
                                !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Last Name</label>
                                {!!
                                    Form::text('rf_last_name',isset($recipient_data)?$recipient_data->last_name:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'rf_last_name',
                                        'placeholder'=>'Last Name',
                                    ))
                                !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Contact Number</label>
                                {!!
                                    Form::text('rf_contact_number',isset($recipient_data)?$recipient_data->contact_number:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'rf_contact_number',
                                        'placeholder'=>'Contact Number',
                                    ))
                                !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                {!!
                                    Form::text('rf_email',isset($recipient_data)?$recipient_data->email:null,
                                    array(
                                        'class'=>'form-control',
                                        'id'=>'rf_email',
                                        'placeholder'=>'Email',
                                    ))
                                !!}
                            </div>
                        </div>
                    </div>
            </div>
            <div class="form-actions right">
                    <button type="button" id="rf_close_btn" class="btn default" data-dismiss="modal">Close</button>
                    @if (!isset($recipient_data))
                    <button type="submit" data-type="Add" class="action_submit_btn btn blue"><i class="fa fa-check"></i>Save</button>
                    @else
                    <button type="submit" data-type="Update" class="action_submit_btn btn blue"><i class="fa fa-check"></i>Update</button>
                    @endif
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>
<script>
    jQuery(document).ready(function() {       
        MemberForm.initRF();
    });
</script>