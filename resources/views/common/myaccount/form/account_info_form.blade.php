<form class="form" id="user_info_form">
    <div class="form-body">
        <div class="form-group">
            <label>First Name</label>
            <div class="input-group col-md-8">
                {!!
                    Form::text('first_name',App\Models\ACL\User::find(Auth::id())->userinfo->first_name,
                    array(
                        'class'=>'form-control user_info_field',
                        'id'=>'first_name',
                        'placeholder'=>'First Name',
                        'readonly' => ''
                    ))
                !!}
            </div>
        </div>
        <div class="form-group">
            <label>Middle Name</label>
            <div class="input-group col-md-8">
                {!!
                    Form::text('middle_name',App\Models\ACL\User::find(Auth::id())->userinfo->middle_name,
                    array(
                        'class'=>'form-control user_info_field',
                        'id'=>'middle_name',
                        'placeholder'=>'Middle Name',
                        'readonly' => ''
                    ))
                !!}
            </div>
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <div class="input-group col-md-8">
                {!!
                    Form::text('last_name',App\Models\ACL\User::find(Auth::id())->userinfo->last_name,
                    array(
                        'class'=>'form-control user_info_field',
                        'id'=>'last_name',
                        'placeholder'=>'Last Name',
                        'readonly' => ''
                    ))
                !!}
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="button" id="user_info_update_btn" class="btn green">Update</button>
        <button type="button" style="display:none" id="user_info_clear_btn" class="btn default">Cancel</button>
        <button type="submit" style="display:none" id="user_info_submit_btn" class="btn green">Submit</button>
    </div>
</form>