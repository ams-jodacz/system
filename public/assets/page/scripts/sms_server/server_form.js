var ServerForm = function () {

    function initForm(actionType){
        var url = actionType;
        if (actionType == 'update'){
            var sms_server_id = $('#sms_server_id').val();
            url += '/'+sms_server_id;
        }
        var form1 = $('#sms_server_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                server_name: {
                    required: 'Enter a valid server name.',
                    remote: 'Name already in use!',
                },
                ip: {
                    required: 'Enter a valid IP.',
                    remote: 'Invalid or already exists IP!',
                },
            },
            rules: {
                server_name: {
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/sms/server/"+url , 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkName'
                        },
                        type: "post",
                    }
                },
                ip: {
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/sms/server/"+url , 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkIP',
                        } ,
                        type: "post",
                    }
                },
                username: {
                    required: true,
                },
                password: {
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
                GENERAL.request(
                    "/sms/server/"+url,
                    {
                        'actionType': actionType+'Server',
                        'server': JSON.stringify(new Server()),
                    },
                    true,
                    function(data){
                        if (data.status) {
                            bootbox.alert(data.msg);
                            if (actionType=='update')
                                location.reload();
                            else
                                $('#sms_server_form').trigger("reset");
                        }
                        else{
                            bootbox.alert(data.msg);
                        }
                    },
                    function(){
                        bootbox.alert("Unexpected error encounter, Please try again later!");
                    }
                );
                return false;
            }
        });
    }

    function Server() {
        this.server_name;
        this.ip;
        this.username;
        this.password;
        
        load = function(self){
            self.server_name = $('#server_name').val();
            self.ip = $('#ip').val();
            self.username = $('#username').val();
            self.password = $('#password').val();
        }
        load(this);
    }
    
    return {
        //main function to initiate the module
        init: function (type) {
            initForm(type);
        }
    };

}();