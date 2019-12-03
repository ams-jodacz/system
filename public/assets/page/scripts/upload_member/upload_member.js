var UploadMember = function () {

    var load_status = true;

    var initForm = function () {
        var form1 = $('#upload_member_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                class_id: {
                    required: true,
                },
                class_group_id: {
                    required: true,
                },
                uploaded_file: {
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
                var formData = new FormData($('#upload_member_form')[0]);
                var ext = $('#uploaded_file').val().split('.').pop().toLowerCase();
                if($.inArray(ext, ['csv']) == -1) {
                    bootbox.alert("Invalid filename extension, CSV files are only allowed!");
                    return false;
                }
                
                $.ajax({
                    url: BASE_URL+'/upload/member/add',
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
                    beforeSend : function() {
                        $('#loading_indicator').show();
                    },
                    complete: function(){
                        $('#loading_indicator').hide();
                    },
                    success: function (data) {
                        if (data == 'true'){
                            bootbox.alert("Successfully Updated");
                            // location.reload();
                        }
                        else{
                            bootbox.alert("Unable to add data!");
                        }
                    },
                });
                // var request = getRequest("/myprofile/update",{
                //     'userinfo':JSON.stringify(new UserInfo()),
                // });
                // request.done(function(data){
                //     if (data.status) {
                //         bootbox.alert(data.msg);
                //         $('#user_info_submit_btn').hide();
                //         $('#user_info_clear_btn').hide();
                //         $('#user_info_update_btn').show();
                //         $('.user_info_field').attr("readonly", true);
                //         location.reload();
                //     }
                //     else{
                //         bootbox.alert(data.msg);
                //     }
                // }).error(function(){
                //     bootbox.alert("Unexpected error encounter, Please try again later!");
                // });
                return false;
            }
        });
        $('#class_id').change(function(){
            initFields();
        });
        $('.select2').select2();
    }

    var initVerifyForm = function () {
        var form1 = $('#verify_member_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                verify_file: {
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
                var formData = new FormData($('#verify_member_form')[0]);
                var ext = $('#verify_file').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['csv']) == -1) {
                    bootbox.alert("Invalid filename extension, CSV files are only allowed!");
                    return false;
                }

                $.ajax({
                    url: BASE_URL + '/upload/member/verify',
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
                    beforeSend: function () {
                        $('#loading_indicator').show();
                    },
                    complete: function () {
                        $('#loading_indicator').hide();
                    },
                    success: function (data) {
                        if (data == 'true') {
                            bootbox.alert("Successfully Updated");
                            // location.reload();
                        }
                        else {
                            bootbox.alert("Unable to add data!");
                        }
                    },
                });
                // var request = getRequest("/myprofile/update",{
                //     'userinfo':JSON.stringify(new UserInfo()),
                // });
                // request.done(function(data){
                //     if (data.status) {
                //         bootbox.alert(data.msg);
                //         $('#user_info_submit_btn').hide();
                //         $('#user_info_clear_btn').hide();
                //         $('#user_info_update_btn').show();
                //         $('.user_info_field').attr("readonly", true);
                //         location.reload();
                //     }
                //     else{
                //         bootbox.alert(data.msg);
                //     }
                // }).error(function(){
                //     bootbox.alert("Unexpected error encounter, Please try again later!");
                // });
                return false;
            }
        });
        $('#class_id').change(function () {
            initFields();
        });
        $('.select2').select2();
    }

    var initSyncForm = function(){
        var form2 = $('#sync_member_form');
        var error1 = $('.alert-danger', form2);
        var success1 = $('.alert-success', form2);
        form2.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                grad_term_id: {
                    required: true,
                },
                dest_upper_class_id: {
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
                $.ajax({
                    url: BASE_URL+'/upload/member/sync',
                    type: 'POST',
                    data: {
                        'grad_term_id': function(){
                            return $('#grad_term_id').val();
                        },
                        'dest_class_id': function () {
                            return $('#dest_upper_class_id').val();
                        },
                    },
                    async: false,
                    // cache: false,
                    // contentType: false,
                    // processData: false,
                    // enctype: 'multipart/form-data',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend : function() {
                        $('#loading_indicator').show();
                    },
                    complete: function(){
                        $('#loading_indicator').hide();
                    },
                    success: function (data) {
                        if (data == 'true'){
                            bootbox.alert("Successfully Updated");
                            // location.reload();
                        }
                        else{
                            bootbox.alert("Unable to add data!");
                        }
                    },
                });
                // var request = getRequest("/myprofile/update",{
                //     'userinfo':JSON.stringify(new UserInfo()),
                // });
                // request.done(function(data){
                //     if (data.status) {
                //         bootbox.alert(data.msg);
                //         $('#user_info_submit_btn').hide();
                //         $('#user_info_clear_btn').hide();
                //         $('#user_info_update_btn').show();
                //         $('.user_info_field').attr("readonly", true);
                //         location.reload();
                //     }
                //     else{
                //         bootbox.alert(data.msg);
                //     }
                // }).error(function(){
                //     bootbox.alert("Unexpected error encounter, Please try again later!");
                // });
                return false;
            }
        });

        $('#academic_year').datepicker({
            autoclose: true,
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years", 
            minViewMode: "years",
            defaultDate: new Date(),
        });
    }

    var initK12SyncForm = function () {
        var form4 = $('#k12_sync_member_form');
        var error1 = $('.alert-danger', form4);
        var success1 = $('.alert-success', form4);
        form4.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                k12_term_id: {
                    required: true,
                },
                dest_k12_class_id: {
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
                $.ajax({
                    url: BASE_URL + '/upload/member/sync',
                    type: 'POST',
                    data: {
                        'term_id': function () {
                            return $('#k12_term_id').val();
                        },
                        'dest_class_id': function () {
                            return $('#dest_k12_class_id').val();
                        },
                    },
                    async: false,
                    // cache: false,
                    // contentType: false,
                    // processData: false,
                    // enctype: 'multipart/form-data',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('#loading_indicator').show();
                    },
                    complete: function () {
                        $('#loading_indicator').hide();
                    },
                    success: function (data) {
                        if (data == 'true') {
                            bootbox.alert("Successfully Updated");
                            // location.reload();
                        }
                        else {
                            bootbox.alert("Unable to add data!");
                        }
                    },
                });
                // var request = getRequest("/myprofile/update",{
                //     'userinfo':JSON.stringify(new UserInfo()),
                // });
                // request.done(function(data){
                //     if (data.status) {
                //         bootbox.alert(data.msg);
                //         $('#user_info_submit_btn').hide();
                //         $('#user_info_clear_btn').hide();
                //         $('#user_info_update_btn').show();
                //         $('.user_info_field').attr("readonly", true);
                //         location.reload();
                //     }
                //     else{
                //         bootbox.alert(data.msg);
                //     }
                // }).error(function(){
                //     bootbox.alert("Unexpected error encounter, Please try again later!");
                // });
                return false;
            }
        });

        $('#academic_year').datepicker({
            autoclose: true,
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years",
            defaultDate: new Date(),
        });
    }

    var initTransferForm = function(){
        var form3 = $('#transfer_member_form');
        var error1 = $('.alert-danger', form3);
        var success1 = $('.alert-success', form3);
        form3.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                from_class_group_id: {
                    required: true,
                },
                to_class_group_id: {
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
                $.ajax({
                    url: BASE_URL+'/upload/member/transfer',
                    type: 'POST',
                    data: {
                        'from_group_id': function(){
                            return $('#from_class_group_id').val();
                        },
                        'to_group_id': function(){
                            return $('#to_class_group_id').val();
                        },
                        'members': function(){
                            return $('#from_member_id').val();
                        }
                    },
                    async: false,
                    // cache: false,
                    // contentType: false,
                    // processData: false,
                    // enctype: 'multipart/form-data',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend : function() {
                        $('#loading_indicator').show();
                    },
                    complete: function(){
                        $('#loading_indicator').hide();
                    },
                    success: function (data) {
                        if (data == 'true'){
                            bootbox.alert("Successfully Updated");
                            location.reload();
                        }
                        else{
                            bootbox.alert("Unable to add data!");
                        }
                    },
                });
                // var request = getRequest("/myprofile/update",{
                //     'userinfo':JSON.stringify(new UserInfo()),
                // });
                // request.done(function(data){
                //     if (data.status) {
                //         bootbox.alert(data.msg);
                //         $('#user_info_submit_btn').hide();
                //         $('#user_info_clear_btn').hide();
                //         $('#user_info_update_btn').show();
                //         $('.user_info_field').attr("readonly", true);
                //         location.reload();
                //     }
                //     else{
                //         bootbox.alert(data.msg);
                //     }
                // }).error(function(){
                //     bootbox.alert("Unexpected error encounter, Please try again later!");
                // });
                return false;
            }
        });

        $('.transfer_options').change(function(){
            console.log('superman');
            // var type = $(this).attr('id');
            var type = $(this).attr('data-type');
            var name = $(this).attr('data-name');
            initDiffinedFields(name,type);
        });
    }

    function initDiffinedFields(name,type){
        var class_id = $('#'+name+'class_id').val();
        var class_group_id = $('#'+name+'class_group_id').val();
        if (type == 'class_group_id'){
            GENERAL.requestAfter(
                "/upload/member/view/0?classType=member",
                {
                    'class_id': function(){
                        return $('#'+name+'_class_id').val();
                    },
                    'class_group_id': function(){
                        return $('#'+name+'_class_group_id').val();
                    },
                },
                'GET',
                true,
                function(data){
                    initSelect(name+'_member_id',data);
                },
                function(){
                },
                function(){
                    if (load_status){
                        initDiffinedFields('to','class_id');
                        load_status = false;
                    }
                }
            );
        }
        else if (type == "class_id"){
            GENERAL.requestAfter(
                "/upload/member/view/0?classType=group",
                {
                    'class_id': function(){
                        return $('#'+name+'_class_id').val();
                    },
                },
                'GET',
                true,
                function(data){
                    initSelect(''+name+'_class_group_id',data);
                    initSelect(name+'_member_id',{});
                },
                function(){
                },
                function(){
                    if (load_status){
                        initDiffinedFields('to','class_id');
                        load_status = false;
                    }
                }
            );
        }
    }

    function initFields(){
        var class_id = $('#class_id').val();
        if (class_id != ''){
            GENERAL.requestAfter(
                "/upload/member/view/0?classType=group",
                {
                    'class_id': function(){
                        return $('#class_id').val();
                    }
                },
                'GET',
                true,
                function(data){
                    initSelect('class_group_id',data);
                },
                function(){
                },
                function(){
                    if (load_status){
                        initDiffinedFields('from','class_id');
                    }
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

    return {
        //main function to initiate the module
        init: function () {
            initTransferForm();
            initForm();
            initVerifyForm();
            initSyncForm();
            initK12SyncForm();
            initFields();
        },
    };

}();