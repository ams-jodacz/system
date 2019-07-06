var Superman;
var GroupForm = function () {
    
    var modulelist = [];

    var initForm = function () {
        var form1 = $('#group_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                group_name: {
                    remote: 'Group already exists!',
                }
            },
            rules: {
                group_name: {
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/users/group/add",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkGroupName'
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
                //success1.show();
                //error1.hide();
                
                var data = getModules();
                
                if (data.length == 0) {
                    bootbox.alert("Please Select Module and Pages");
                    return false;
                }
                
                var request = getRequest("/users/group/add",{
                    'actionType':'addGroup',
                    'group_name': $('#group_name').val(),
                    'data':JSON.stringify(data),
                });
                request.done(function(data){
                    if (data.status) {
                        location.reload();
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
        var form1 = $('#group_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                group_name: {
                    remote: 'Group already exists!',
                }
            },
            rules: {
                group_name: {
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/users/group/update/"+$('#group_id').val(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkGroupName'
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
                //success1.show();
                //error1.hide();
                
                var data = getModules();
                
                if (data.length == 0) {
                    bootbox.alert("Please Select Module and Pages");
                    return false;
                }
                var group_id = $('#group_id').val();
                var request = getRequest("/users/group/update/"+group_id,{
                    'actionType':'updateGroup',
                    'group_name': $('#group_name').val(),
                    'data':JSON.stringify(data),
                });
                request.done(function(data){
                    if (data.status) {
                        bootbox.alert(data.msg);
                    }
                    else{
                        bootbox.alert(data.msg);
                    }
                    location.reload();
                });
                return false;
            }
        });
    }
    
    var initButton = function(){
        $('input:checkbox.modules_btn').each(function () {
            if (this.checked) {
                modulelist.push($(this).val());
                $('#module_page_container_'+$(this).val()).show();
            }
        });
        $('.modules_btn').on('ifChecked', function(event){
            modulelist.push($(this).val());
            $('#module_page_container_'+$(this).val()).show();
            $('.page_module_'+$(this).val()).iCheck('uncheck');
            $('.module_page_action_'+$(this).val()).iCheck('uncheck').iCheck('disable'); 
        }).on('ifUnchecked', function(event){
            modulelist.splice(modulelist.indexOf("Apple"), 1);
            $('#module_page_container_'+$(this).val()).hide();
        });
        
        $('.module_pages').on('ifChecked', function(event){
            $('.module_page_'+$(this).val()).iCheck('uncheck').iCheck('enable');
        }).on('ifUnchecked', function(event){
            $('.module_page_'+$(this).val()).iCheck('uncheck').iCheck('disable');
        });
    }
    
    function getModules() {
        var data = [];
        for (var i=0;i<modulelist.length;i++) {
            $('input:checkbox.page_module_'+modulelist[i]).each(function () {
                if (this.checked) {
                    var page_id = $(this).val();
                    var action = 1;
                    $('input:checkbox.module_page_'+page_id).each(function () {
                        if (this.checked) {
                            action += parseInt($(this).val());
                        }
                    });
                    //var info = JSON.stringify({module_id:modulelist[i],page_id:page_id,page_action:action});
                    var info = {module_id:modulelist[i],page_id:page_id,action_value:action};
                    data.push(info);
                }
            });
        }
        return data;
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
            initForm();
            initButton();
        },
        initUpdate: function() {
            initUpdateForm();
            initButton();
        }
    };

}();