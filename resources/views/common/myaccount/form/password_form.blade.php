<form class="form" id="password_form">
    <div class="form-body">
        <div class="form-group">
            <label>Old Password</label>
            <div class="input-group col-md-8">
                {!!
                    Form::password('old_password',
                    array(
                        'class'=>'form-control',
                        'id'=>'old_password',
                        'placeholder'=>'Old Password',
                    ))
                !!}
            </div>
        </div>
        <div class="form-group">
            <label>New Password</label>
            <div class="input-group col-md-8">
                {!!
                    Form::password('new_password',
                    array(
                        'class'=>'form-control',
                        'id'=>'new_password',
                        'placeholder'=>'New Password',
                    ))
                !!}
            </div>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <div class="input-group col-md-8">
                {!!
                    Form::password('confirm_password',
                    array(
                        'class'=>'form-control',
                        'id'=>'confirm_password',
                        'placeholder'=>'Confirm Password',
                    ))
                !!}
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn green">Submit</button>
    </div>
</form>