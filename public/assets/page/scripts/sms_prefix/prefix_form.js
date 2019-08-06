var PrefixForm = function () {

    function initForm(actionType){
        var url = actionType;
        if (actionType == 'update'){
            var sms_prefix_id = $('#sms_prefix_id').val();
            url += '/'+sms_prefix_id;
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
                prefix: {
                    required: 'Enter a valid group name.',
                    remote: 'Name already in use!',
                },
            },
            rules: {
                sms_prefix_group_id:{
                    required: true,
                },
                prefix: {
                    required: true,
                    minlength: 3,
                    maxlength: 3,
                    remote:  {
                        url:BASE_URL+"/sms/prefix/"+url , 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'sms_prefix_group_id': function(){
                                return $('#sms_prefix_group_id').val();
                            },
                            'actionType':'checkName'
                        },
                        type: "post",
                    }
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
                    "/sms/prefix/"+url,
                    {
                        'actionType': actionType+'Prefix',
                        'prefix': JSON.stringify(new Prefix()),
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
        
        $('.select2').select2();
        $('#sms_prefix_group_id').change(function(){
            $('#prefix').val("");
        });
    }

    function Prefix() {
        this.sms_prefix_group_id;
        this.prefix;

        load = function(self){
            self.sms_prefix_group_id = $('#sms_prefix_group_id').val();
            self.prefix = $('#prefix').val();
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