var Direct = function () {

    function initForm(){
        var form1 = $('#direct_message_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                message: {
                    required: true,
                    maxlength: 255,
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
                    "/blast/add",
                    {
                        'actionType': 'send',
                        'info': JSON.stringify(new Info()),
                    },
                    true,
                    function(data){
                        if (data.status) {
                            bootbox.alert(data.msg);
                            // $('#direct_message_form').trigger("reset");
                            // checkForAll();
                            location.reload();
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

        $('#message').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true
        });

        $('#all').change(function(){
            checkForAll();
        });
        $('.select2').change(function(){
            var type = $(this).attr('id');
            initFields(type);
        });
        checkForAll();
        initFields('class_id');

        $('.select2').select2();
    }

    function checkForAll(){
        var status = $('#all').is(':checked');
        if (status){
            $('.select2').prop('disabled', 'disabled');
        }
        else{
            $('.select2').prop('disabled', false);
        }
    }

    function initFields(type){
        var class_id = $('#class_id').val();
        var class_group_id = $('#class_group_id').val();
        if (type == 'class_group_id'){
            GENERAL.requestType(
                "/blast/view/0?classType=member",
                {
                    'class_id': function(){
                        return $('#class_id').val();
                    },
                    'class_group_id': function(){
                        return $('#class_group_id').val();
                    },
                },
                'GET',
                true,
                function(data){
                    initSelect('member_id',data);
                },
                function(){
                }
            );
        }
        else if (type == "class_id"){
            GENERAL.requestType(
                "/blast/view/0?classType=group",
                {
                    'class_id': function(){
                        return $('#class_id').val();
                    },
                },
                'GET',
                true,
                function(data){
                    initSelect('class_group_id',data);
                    initSelect('member_id',{});
                },
                function(){
                }
            );
        }
    }

    function initSelect(name,data){
        $('#'+name).html("");
        $('#'+name).append('<option value=""></option>');
        if (data.length > 0){
            data.forEach(function(entry){
                $('#'+name).append('<option value="'+entry.id+'">'+entry.text+'</option>');
            });
        }
        $('#'+name).select2();
    }

    function Info() {
        this.class_id;
        this.class_group_id;
        this.member_id;
        this.all;
        this.message;

        load = function(self){
            self.class_id = $('#class_id').val();
            self.class_group_id = $('#class_group_id').val();
            self.member_id = $('#member_id').val();
            self.all = $('#all').is(':checked');
            self.message = $('#message').val();
        }
        load(this);
    }
    
    return {
        //main function to initiate the module
        init: function () {
            initForm();
        }
    };

}();