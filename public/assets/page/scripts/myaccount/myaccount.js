var MyAccount = function () {

    var initUserInfoForm = function () {
        var form1 = $('#user_info_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                first_name: {
                    required: true,
                },
                middle_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
            },
            invalidHandler: function (event, validator) { //display error alert on form submit              
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form) {
                var request = getRequest("/myprofile/update",{
                    'userinfo':JSON.stringify(new UserInfo()),
                });
                request.done(function(data){
                    if (data.status) {
                        bootbox.alert(data.msg);
                        $('#user_info_submit_btn').hide();
                        $('#user_info_clear_btn').hide();
                        $('#user_info_update_btn').show();
                        $('.user_info_field').attr("readonly", true);
                        location.reload();
                    }
                    else{
                        bootbox.alert(data.msg);
                    }
                }).error(function(){
                    bootbox.alert("Unexpected error encounter, Please try again later!");
                });
                return false;
            }
        });

        $('#upload_btn').click(function(){
            var formData = new FormData($('#data')[0]);
            
            $.ajax({
                url: BASE_URL+'/myprofile/upload',
                type: 'POST',
                data: formData,
                async: false,
                // cache: false,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data == 'true'){
                        bootbox.alert("Successfully Updated");
                        location.reload();
                    }
                    else{
                        bootbox.alert("Unable to update!");
                    }
                },
            });
        });
    }
    
    var initPasswordForm = function(){
        var form1 = $('#password_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                old_password : {
                    required: true,
                },
                new_password : {
                    required: true,
                    minlength : 5
                },
                confirm_password : {
                    required: true,
                    minlength : 5,
                    equalTo : "#new_password"
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit              
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function (form) {
                var request = getRequest("/myprofile/update",{
                    'password':JSON.stringify(new Password()),
                });
                request.done(function(data){
                    if (data.status) {
                        bootbox.alert(data.msg);
                        $('#user_info_submit_btn').hide();
                        $('#user_info_clear_btn').hide();
                        $('#user_info_update_btn').show();
                        $('.user_info_field').attr("readonly", true);
                        location.reload();
                    }
                    else{
                        bootbox.alert(data.msg);
                    }
                });
                return false;
            }
        });
    }
    
    var initButton = function(){
        $('#user_info_clear_btn').click(function(){
            if ($('#user_info_submit_btn').is(":visible")) {
                $('#user_info_form').trigger("reset");
                
                $('#user_info_submit_btn').hide();
                $('#user_info_clear_btn').hide();
                $('#user_info_update_btn').show();
                $('.user_info_field').attr("readonly", true);
            }
        });
        $('#user_info_update_btn').click(function(event){
            $(this).hide();
            $('#user_info_submit_btn').show();
            $('#user_info_clear_btn').show();
            $('.user_info_field').removeAttr("readonly");
        });
    };
    
    function UserInfo(){
        this.first_name;
        this.middle_name;
        this.last_name;
        
        load = function(self){
            self.first_name = $('#first_name').val();
            self.middle_name = $('#middle_name').val();
            self.last_name = $('#last_name').val();
        }
        load(this);
    }
    
    function Password(){
        this.old_password;
        this.new_password;
        
        load = function(self){
            self.old_password = $('#old_password').val();
            self.new_password = $('#new_password').val();
        }
        load(this);
    }
    
    function getRequest(url,data){
        var request = $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: BASE_URL+url,
            data: data,
            dataType: 'json'
        });
        
        return request;
    }
    
    return {
        //main function to initiate the module
        init: function () {
            initUserInfoForm();
            initPasswordForm();
            initButton();
        },
    };

}();