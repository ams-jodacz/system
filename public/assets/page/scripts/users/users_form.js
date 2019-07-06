var UsersForm = function () {

    var initForm = function () {
        var form1 = $('#users_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                username: {
                    required: 'Enter a valid username.',
                    remote: 'Username already use!',
                }
            },
            rules: {
                username: {
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/users/add" , 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkUsername',
                        } ,
                        type: "post",
                    }
                },
                status: {
                    required: true,
                },
                group: {
                    required: true,
                },
                first_name: {
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
                //success1.show();
                //error1.hide();
                //form.submit();
                var request = getRequest("/users/add",{
                    'actionType':'addUser',
                    'user':JSON.stringify(new User()),
                    'userinfo':JSON.stringify(new UserInfo()),
                });
                request.done(function(data){
                    if (data.status) {
                        $('#users_form').trigger("reset");
                        bootbox.alert(data.msg);
                        //$('#users_form').trigger("reset");
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
    }
    
    var initUpdateForm = function () {
        var form1 = $('#users_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                status: {
                    required: true,
                },
                group: {
                    required: true,
                },
                first_name: {
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
                //success1.show();
                //error1.hide();
                //form.submit();
                var user_id = $('#user_id').val();
                var request = getRequest("/users/update/"+user_id,{
                    'actionType':'updateUser',
                    'user':JSON.stringify(new User()),
                    'userinfo':JSON.stringify(new UserInfo()),
                });
                request.done(function(data){
                    if (data.status) {
                        bootbox.alert(data.msg);
                    }
                    else{
                        $('#users_form').trigger("reset");
                        bootbox.alert(data.msg);
                    }
                }).error(function(){
                    bootbox.alert("Unexpected Error, Please Try Again Later!");
                });
                return false;
            }
        });
    }
    
    function User() {
        this.username;
        this.group_id;
        this.status;
        
        load = function(self){
            self.username = $('#username').val();
            self.group_id = $('#group_id').val();
            self.status = $('#status').val();
        }
        load(this);
    }
    
    function UserInfo() {
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
    
    function getRequest(url,data){
        var request = $.ajax({
            type: 'POST',
            url: BASE_URL+url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            dataType: 'json'
        });
        
        return request;
    }
    
    return {
        //main function to initiate the module
        init: function () {
            initForm();
        },
        initUpdate: function() {
            initUpdateForm();
        }
    };

}();