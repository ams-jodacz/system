var Access = function () {

    var initTable = function () {
        var table = $('#access_list_table');
        var oTable = table.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": BASE_URL+'/stations/access/data',
            "deferRender": true,
            "pagingType": "simple",
            "language": {
                "lengthMenu": "_MENU_",
                "search": "",
                "info": "Showing _START_ to _END_",
            },
            "columns": [
                { "data": 'station_group_name' },
                { "data": 'classification_name' },
                { "data": 'group_name' },
                { "render": actionLinks, "data": 'access_id', },
            ],
        });
        var tableWrapper = $('#access_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
        
        oTable.delegate('.remove_btn','click',function(event){
            var data_id = $(this).attr('data-id');
            bootbox.confirm("Are you sure to remove this access?", function(result) {
                if (result) {
                    GENERAL.requestAfter(
                        "/stations/access/delete/"+data_id,
                        {},
                        'POST',
                        true,
                        function(data){
                            if (data.status){
                                oTable.fnDraw();
                            }
                            else{
                                bootbox.alert("Unable to remove access,Please try again!");
                            }
                        },
                        function(){
                            bootbox.alert("Unexpected error encounter, Please try again later!");
                        },
                        function(){
                            initFields();
                        }
                    );
                }
            });
        });
        
        var form1 = $('#access_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                station_group_id: {
                    required: true,
                },
                class_id: {
                    required: true,
                },
                class_group_id: {
                    required: true,
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
                GENERAL.requestAfter(
                    "/stations/access/add",
                    {
                        'actionType': 'addAccess',
                        'access': JSON.stringify(new Access()),
                    },
                    'POST',
                    true,
                    function(data){
                        if (data.status) {
                            bootbox.alert(data.msg);
                            oTable.fnDraw();
                        }
                        else{
                            bootbox.alert(data.msg);
                        }
                    },
                    function(){
                        bootbox.alert("Unexpected error encounter, Please try again later!");
                    },
                    function(){
                        initFields();
                    }
                );
                return false;
            }
        });

        $('#station_group_id, #class_id').change(function(){
            initFields();
        });

        form1.delegate('.station_id','change',function(){
            initFields();
        });

        initFields();
        $('.select2').select2();
    }

    function initFields(){
        var station_group_id = $('#station_group_id').val();
        var class_id = $('#class_id').val();
        if (station_group_id != '' && class_id != ''){
            GENERAL.requestType(
                "/stations/access/view/0?classType=classification",
                {
                    'station_group_id': function(){
                        return $('#station_group_id').val();
                    },
                    'class_id': function(){
                        return $('#class_id').val();
                    },
                },
                'GET',
                true,
                function(data){
                    initSelect('class_group_id',data);
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

    function Access() {
        this.station_group_id;
        this.class_id;
        this.class_group_id;

        load = function(self){
            self.station_group_id = $('#station_group_id').val();
            self.class_id = $('#class_id').val();
            self.class_group_id = $('#class_group_id').val();
        }
        load(this);
    }

    function actionLinks(data, type, full) {
        var actionValue = $('#action_str').html();
        actionValue = actionValue.replace(/##NUM##/g, data);
        return actionValue;
    }
    
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable();
        }
    };

}();