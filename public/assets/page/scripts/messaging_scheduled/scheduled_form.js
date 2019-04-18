var ScheduledForm = function () {

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
                if (!fieldChecker()){
                    return false;
                }
                GENERAL.request(
                    "/blast/occurance/add",
                    {
                        'actionType': 'addSchedule',
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

        $('#message').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true
        });

        $('#all').change(function(){
            checkForAll();
        });
        $('.send_to').change(function(){
            var type = $(this).attr('id');
            initFields(type);
        });
        $('#occurance').change(function(){
            checkOccurance();
        });
        $('#occurance_type').change(function(){
            checkOccuranceType();
        });
        $('.occurance_type_fields').hide();
        checkForAll();

        initFields('class_id');

        checkOccurance();

        $('#time').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: false,
            // showMeridian: false
        });

        $('#day_of_month').datepicker({
            autoclose: true,
            format: 'dd',
        });

        $('#date').datepicker({
            autoclose: true,
            format: 'M dd',
            startDate: new Date(),
        });

        $('#send_date').datepicker({
            autoclose: true,
            startDate: new Date(),
        });

        $('.select2').select2();
    }

    function checkOccurance(){
        var status = $('#occurance').is(':checked');
        if (status){
            $('.non_occurance_fields').hide();
            $('.occurance_fields').show();
            checkOccuranceType();
        }
        else{
            $('.non_occurance_fields').show();
            $('.occurance_fields').hide();
            $('.occurance_type_fields').hide();
        }
    }

    function checkOccuranceType(){
        var val = $('#occurance_type').val();
        $('.occurance_type_fields').hide();
        if (val != 'Everyday'){
            $('#'+val).show();
        }
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
                "/blast/occurance/view/0?classType=member",
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
                "/blast/occurance/view/0?classType=group",
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

    function fieldChecker(){
        var occurance = $('#occurance').is(':checked')?true:false;
        var time = $('#time').val();
        var send_date = $('#send_date').val();
        var status = false;
        if (!occurance && (send_date == '' || time == '')){
            status = true
        }
        else{
            var occurance_type = $('#occurance_type').val();
            switch(occurance_type){
                case 'Everyday':
                    if (time == '')
                        status = true;
                    break;
                case 'Weekly':
                    var day_of_the_week = $('#day_of_the_week').val();
                    if (time == '' || day_of_the_week == '')
                        status = true;
                    break;
                case 'Monthly':
                    var day_of_month = $('#day_of_month').val();
                    if (time == '' || day_of_month == '')
                        status = true;
                    break;
                case 'Yearly':
                    var date = $('#date').val();
                    if (time == '' || date == '')
                        status = true;
                    break;
            }
        }

        if (status){
            bootbox.alert("Some fields are missing!");
        }

        return !status;
    }

    function Info() {
        this.class_id;
        this.class_group_id;
        this.member_id;
        this.occurance;
        this.message;
        this.send_date_time;
        this.occurance_info;

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
            self.message = $('#message').val();
            self.occurance = $('#occurance').is(':checked')?true:false;

            if (self.occurance){
                self.occurance_info = new OccuranceInfo();
            }
            else{
                self.send_date_time = $('#send_date').val() + ' ' + $('#time').val();
            }
            console.log(self);
        }
        load(this);
    }

    function OccuranceInfo() {
        this.minute;
        this.hour;
        this.day_of_month;
        this.month;
        this.day_of_week;

        load = function(self){
            var occurance_type = $('#occurance_type').val();
            var time = $('#time').val();
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
            switch(occurance_type){
                case 'Everyday':
                    self.minute         = minute;
                    self.hour           = hour;
                    self.day_of_month   = '*';
                    self.month          = '*';
                    self.day_of_week    = '*';
                    break;
                case 'Weekly':
                    self.minute         = minute;
                    self.hour           = hour;
                    self.day_of_month   = '*';
                    self.month          = '*';
                    self.day_of_week    = $('#day_of_the_week').val();
                    break;
                case 'Monthly':
                    self.minute         = minute;
                    self.hour           = hour;
                    self.day_of_month   = $('#day_of_month').val();
                    self.month          = '*';
                    self.day_of_week    = '*';
                    break;
                case 'Yearly':
                    var date = $('#date').val();
                    var date_array = date.split(' ');
                    var month = date_array[0];
                    
                    switch(month){
                        case 'Jan': month = '1'; break;
                        case 'Feb': month = '2'; break;
                        case 'Mar': month = '3'; break;
                        case 'Apr': month = '4'; break;
                        case 'May': month = '5'; break;
                        case 'Jun': month = '6'; break;
                        case 'Jul': month = '7'; break;
                        case 'Aug': month = '8'; break;
                        case 'Sep': month = '9'; break;
                        case 'Oct': month = '10'; break;
                        case 'Nov': month = '11'; break;
                        case 'Dec': month = '12'; break;
                    }

                    var dom = date_array[1];
                    self.minute         = minute;
                    self.hour           = hour;
                    self.day_of_month   = dom;
                    self.month          = month;
                    self.day_of_week    = '*';
                    break;
            }
            console.log(self);
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