var DateExcemption = function () {

    function initForm(){
        var form1 = $('#date_excemption_message_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                start_date: {
                    required: true,
                },
                start_time: {
                    required: true,
                },
                end_date: {
                    required: true,
                },
                end_time: {
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
                if (!checkTime()){
                    bootbox.alert("Please check time intervals!");
                    return false;
                }
                GENERAL.request(
                    "/blast/excemption/add",
                    {
                        'actionType': 'addDateExcemption',
                        'info': JSON.stringify(new Info()),
                    },
                    true,
                    function(data){
                        if (data.status) {
                            bootbox.alert(data.msg);
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

        $('#all').change(function(){
            checkForAll();
        });

        $('.send_to').change(function(){
            var type = $(this).attr('id');
            initFields(type);
        });

        checkForAll();

        initFields('class_id');

        $('#start_time, #end_time').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: false,
        });

        $('#start_date, #end_date').datepicker({
            autoclose: true,
            format: 'MM dd,yyyy',
        });


        $('.select2').select2();
    }

    function checkTime(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        var start_date_time = new Date(start_date);
        var end_date_time = new Date(end_date);

        var start_data = timeSpliter('start_time');
        if (start_data.length != 2){
            return false;
        }
        start_date_time.setHours(start_data[0]);
        start_date_time.setMinutes(start_data[1]);

        var end_data = timeSpliter('end_time');
        if (end_data.length != 2){
            return false;
        }
        end_date_time.setHours(end_data[0]);
        end_date_time.setMinutes(end_data[1]);

        if (end_date_time > start_date_time){
            return true;
        }

        return false;
    }

    function timeSpliter(time){
        var time = $('#'+time).val();
        var time_str = time.split(' ');
        var time_array = time_str[0].split(':');
        var minute = time_array[1];
        var hour = time_array[0];
        if (time_str[1] == 'PM'){
            hour = parseInt(hour)+12;
            if (hour == 24){
                hour = '12';
            }
        }
        else if (time_str[1] == 'AM' && hour == '12'){
            hour = '0';
        }

        return [hour,minute];
    }

    function checkForAll(){
        var status = $('#all').is(':checked');
        if (status){
            $('.send_to').prop('disabled', 'disabled');
        }
        else{
            $('.send_to').prop('disabled', false);
        }
    }

    function initFields(type){
        var class_id = $('#class_id').val();
        var class_group_id = $('#class_group_id').val();
        if (type == 'class_group_id'){
            GENERAL.requestType(
                "/blast/excemption/view/0?classType=member",
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
                "/blast/excemption/view/0?classType=group",
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
        this.start_date_time;
        this.end_date_time;

        load = function(self){
            var all_status = $('#all').is(':checked');

            if (!all_status){
                if ($('#class_id').val() != '')
                    self.class_id = $('#class_id').val();
                if ($('#class_group_id').val() != '')
                    self.class_group_id = $('#class_group_id').val();
                if ($('#member_id').val() != '')
                    self.member_id = $('#member_id').val();
            }
            self.start_date_time = $('#start_date').val()+' '+$('#start_time').val();
            self.end_date_time = $('#end_date').val()+' '+$('#end_time').val();
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