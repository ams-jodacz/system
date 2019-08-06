var StationForm = function () {

    function initForm(actionType){
        var url = actionType;
        if (actionType == 'update'){
            var station_id = $('#station_id').val();
            url += '/'+station_id;
        }
        var form1 = $('#stations_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            messages: {
                station_name: {
                    required: 'Enter a valid station name.',
                    remote: 'Name already in use!',
                },
                station_ip: {
                    required: 'Enter a valid IP.',
                    remote: 'Invalid or already exists IP!',
                },
            },
            rules: {
                station_name: {
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/stations/"+url , 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkName',
                            'station_group_id': function(){
                                return $('#station_group_id').val();
                            }
                        } ,
                        type: "post",
                    }
                },
                station_ip: {
                    required: true,
                    remote:  { 
                        url:BASE_URL+"/stations/"+url , 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            'actionType':'checkIP',
                        } ,
                        type: "post",
                    }
                },
                status: {
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
                    "/stations/"+url,
                    {
                        'actionType': actionType+'Station',
                        'station': JSON.stringify(new Station()),
                    },
                    true,
                    function(data){
                        if (data.status) {
                            bootbox.alert(data.msg);
                            if (actionType=='update')
                                location.reload();
                            else
                                $('#stations_form').trigger("reset");
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

    function Station() {
        this.name;
        this.station_group_id;
        this.ip;
        this.status;
        this.description;
        this.enable_status;
        
        load = function(self){
            self.name = $('#station_name').val();
            self.station_group_id = $('#station_group_id').val();
            self.ip = $('#station_ip').val();
            self.status = $('#status').val();
            self.description = $('#description').val();
            self.enable_status = $('#enable_status').val();
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