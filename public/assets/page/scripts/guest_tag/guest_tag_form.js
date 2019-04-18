var GuestTagForm = function () {

    function initForm(actionType){
        var url = actionType;
        if (actionType == 'update'){
            var id = $('#tag_id').val();
            url += '/'+id;
        }
        var form1 = $('#guest_tag_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                tag_name: {
                    required: 'Enter a valid tag name.',
                    remote: 'Name already in use!',
                },
                id_number: {
                    required: 'Enter a valid id number.',
                    remote: 'ID Number already in use!',
                },
            },
            rules: {
                tag_name: {
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/guest/"+url , 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkName',
                            'guest_group_id': function(){
                                return $('#guest_group_id').val();
                            }
                        } ,
                        type: "post",
                    }
                },
                guest_group_id:{
                    required: true,
                },
                id_number:{
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/guest/"+url , 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkIDNumber',
                            'guest_group_id': function(){
                                return $('#guest_group_id').val();
                            }
                        } ,
                        type: "post",
                    }
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
                GENERAL.request(
                    "/guest/"+url,
                    {
                        'actionType': actionType+'GuestTag',
                        'guestTag': JSON.stringify(new GuestTag()),
                    },
                    true,
                    function(data){
                        if (data.status) {
                            bootbox.alert(data.msg);
                            if (actionType=='update')
                                location.reload();
                            else
                                $('#guest_tag_form').trigger("reset");
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
        $('#guest_group_id').change(function(){
            $('#tag_name').val("");
            $('#id_number').val("");
        });
    }

    function GuestTag() {
        this.tag_name;
        this.guest_group_id;
        this.id_number;

        load = function(self){
            self.tag_name = $('#tag_name').val();
            self.guest_group_id = $('#guest_group_id').val();
            self.id_number = $('#id_number').val();
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