var HolidayForm = function () {

    function initForm(){
        var form1 = $('#holiday_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                name: {
                    required: true,
                },
                date: {
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
                    "/blast/holiday/add",
                    {
                        'actionType': 'addHoliday',
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

        $('#date').datepicker({
            autoclose: true,
            format: 'M dd',
        });
    }

    function Info() {
        this.name;
        this.date;
        this.description;

        load = function(self){
            self.name = $('#name').val();
            self.date = $('#date').val();
            self.description = $('#description').val();
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