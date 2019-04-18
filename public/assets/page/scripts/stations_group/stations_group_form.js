var StationGroupForm = function () {

    function initForm(actionType){
        var url = actionType;
        if (actionType == 'update'){
            var station_id = $('#station_group_id').val();
            url += '/'+station_id;
        }
        var form1 = $('#stations_group_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                group_name: {
                    required: 'Enter a valid station group name.',
                    remote: 'Name already in use!',
                },
            },
            rules: {
                group_name: {
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/stations/group/"+url , 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkName',
                        } ,
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
                    "/stations/group/"+url,
                    {
                        'actionType': actionType+'StationGroup',
                        'stationGroup': JSON.stringify(new StationGroup()),
                    },
                    true,
                    function(data){
                        if (data.status) {
                            bootbox.alert(data.msg);
                            if (actionType=='update')
                                location.reload();
                            else
                                $('#stations_group_form').trigger("reset");
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
    }

    function StationGroup() {
        this.group_name;
        
        load = function(self){
            self.group_name = $('#group_name').val();
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