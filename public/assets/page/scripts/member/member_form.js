var MemberForm = function () {

    var recipients = [];

    function initForm(actionType){
        var url = actionType;
        if (actionType == 'update'){
            var station_id = $('#member_id').val();
            url += '/'+station_id;
        }
        else{
            initClassGroup();
        }
        var form1 = $('#member_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                id_number: {
                    required: 'Enter a valid id number.',
                    remote: 'ID Number already exists!',
                },
            },
            rules: {
                class_group_id:{
                    required: true,
                },
                id_number: {
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/member/"+url , 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkID',
                        } ,
                        type: "post",
                    }
                },
                active_status: {
                    required: true,
                },
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                // contact_number: {
                //     required: true,
                // },
                email: {
                    email: true,
                },
            },
            invalidHandler: function (event, validator) { //display error alert on form submit              
                success1.hide();
                error1.show();
                Metronic.scrollTo(error1, -200);
                console.log(event);
                console.log(validator);
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
                GENERAL.requestType(
                    "/member/"+url,
                    {
                        'actionType': actionType+'Member',
                        'member': JSON.stringify(new Member()),
                        'recipients': JSON.stringify(recipients),
                    },
                    'Post',
                    true,
                    function(data){
                        if (data.status) {
                            bootbox.alert(data.msg);
                            if (actionType=='update')
                                location.reload();
                            else
                                $('#member_form').trigger("reset");
                        }
                        else{
                            bootbox.alert(data.msg);
                        }
                        lock_key = false;
                    },
                    function(){
                        bootbox.alert("Unexpected error encounter, Please try again later!");
                        lock_key = false;
                    }
                );
                return false;
            }
        });

        $('#class_id').change(function(){
            initClassGroup();
        });

        $('.select2').select2();

        initButtons();

        $('#recipient_info_ajax').on('hidden.bs.modal', function () {
            removeRecipientRules();
        })
    }

    function initButtons(){
        $('#member_rf_list_table').delegate('.update_recipient_btn','click',function(){
            var id = $(this).attr('data-id');
            var url = $(this).attr('href');
            $(this).attr('href',url+'&recipient_info='+recipients[id]);
        });

        $('#member_rf_list_table').delegate('.remove_recipient_btn','click',function(){
            var id = $(this).attr('data-id');
            bootbox.confirm("Are you sure to remove this recipient?", function(result) {
                if (result) {
                    recipients.splice(id,1);
                    showRecipients();
                }
            });
        });
    }

    function initRecipientForm(){
        var form1 = $('#member_recipient_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                rf_first_name: {
                    required: true,
                },
                rf_last_name: {
                    required: true,
                },
                rf_contact_number: {
                    required: true,
                },
                rf_email: {
                    email: true,
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
                var type = $('.action_submit_btn').attr('data-type');
                addRecipient(type,JSON.stringify(new Recipient()));
                return false;
            }
        });

        $('#rf_close_btn').click(function(){
            removeRecipientRules();
        });
    }

    function removeRecipientRules(){
        $("#rf_first_name").rules("remove", "required");
        $("#rf_last_name").rules("remove", "required");
        $("#rf_contact_number").rules("remove", "required");
    }

    function initRecipients(data){
        for(var index in data){
            recipients.push(JSON.stringify(data[index]));
        };
        showRecipients();
    }

    function addRecipient(type,data){
        var isUpdate = false;
        if (type == 'Update'){
            isUpdate = true;
            var id = $('#recipient_id').val();
        }
        var status = true;
        obj = JSON.parse(data);
        for(var index in recipients){
            if (isUpdate){
                if (id == index)
                    continue;
            }
            info = JSON.parse(recipients[index]);
            if (info.contact_number == obj.contact_number){
                bootbox.alert("Contact Number Already Exists!");
                status = false;
            }
        }
        if (status){
            if (isUpdate){
                recipients[id] = data;
            }
            else{
                recipients.push(data);
            }
            $('#rf_close_btn').click();
        }
        showRecipients();
    }

    function showRecipients(){
        $('#member_rf_list_table tbody').html('');
        var elem = '';
        for(var index in recipients){
            elem += getTable(index,JSON.parse(recipients[index]));
        }
        $('#member_rf_list_table tbody').html(elem);
    }

    function getTable(index,data){
        return '<tr>'+
            '<td>'+
                data.first_name+
            '</td>'+
            '<td>'+
                data.middle_name+
            '</td>'+
            '<td>'+
                data.last_name+
            '</td>'+
            '<td>'+
                data.contact_number+
            '</td>'+
            '<td>'+
                data.email+
            '</td>'+
            '<td>'+
                getActionButton(index)+
            '</td>'+
        '</tr>';
    }

    function getActionButton(id){
        var actionValue = $('#rf_action_str').html();
        actionValue = actionValue.replace(/##NUM##/g, id);
        return actionValue;
    }

    function initClassGroup(){
        var class_id = $('#class_id').val();
        GENERAL.requestType(
            "/member/view/0",
            {
                'actionType': 'class',
                'class_id': class_id,
            },
            'Get',
            true,
            function(data){
                initSelect('class_group_id',data)
                lock_key = false;
            },
            function(){
                bootbox.alert("Unexpected error encounter, Please try again later!");
                lock_key = false;
            }
        );
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

    function Member() {
        this.class_group_id;
        this.id_number;
        this.active_status;
        this.first_name;
        this.middle_name;
        this.last_name;
        this.contact_number;
        this.email;

        load = function(self){
            self.class_group_id = $('#class_group_id').val();
            self.id_number = $('#id_number').val();
            self.active_status = $('#active_status').val();
            self.first_name = $('#first_name').val();
            self.middle_name = $('#middle_name').val();
            self.last_name = $('#last_name').val();
            self.contact_number = $('#contact_number').val();
            self.email = $('#email').val();
        }
        load(this);
    }

    function Recipient() {        
        this.first_name;
        this.middle_name;
        this.last_name;
        this.contact_number;
        this.email;

        load = function(self){
            self.first_name = $('#rf_first_name').val();
            self.middle_name = $('#rf_middle_name').val();
            self.last_name = $('#rf_last_name').val();
            self.contact_number = $('#rf_contact_number').val();
            self.email = $('#rf_email').val();
        }
        load(this);
    }
    
    return {
        //main function to initiate the module
        init: function (type) {
            initForm(type);
        },
        initRF: function(){
            initRecipientForm();
        },
        initRecipients: function(data){
            initRecipients(data);
        }
    };

}();