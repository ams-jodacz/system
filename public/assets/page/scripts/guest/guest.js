var Guest = function () {

    var initTable = function () {
        var table = $('#guest_log_list_table');
        var oTable = table.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": BASE_URL+'/guest/add_guest/data',
            "deferRender": true,
            "pagingType": "simple",
            "language": {
                "lengthMenu": "_MENU_",
                "search": "",
                "info": "Showing _START_ to _END_",
            },
            "columns": [
                { "data": 'id_number' },
                { "data": 'tag_name' },
                { "data": 'users' },
                { "data": 'reason' },
                { "data": 'items' },
                { "render": actionLinks, "data": 'id', },
            ],
        });
        var tableWrapper = $('#access_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
        
        oTable.delegate('.remove_btn','click',function(event){
            var data_id = $(this).attr('data-id');
            bootbox.confirm("Are you sure that tag is already return?", function(result) {
                if (result) {
                    GENERAL.requestAfter(
                        "/guest/add_guest/delete/"+data_id,
                        {},
                        'POST',
                        true,
                        function(data){
                            if (data.status){
                                oTable.fnDraw();
                            }
                            else{
                                bootbox.alert("Unable to update guest,Please try again!");
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
        
        var form1 = $('#guest_form');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                guest_group_id: {
                    required: true,
                },
                tag_id: {
                    required: true,
                },
                users: {
                    required: true,
                },
                reason: {
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
                GENERAL.requestAfter(
                    "/guest/add_guest/add",
                    {
                        'actionType': 'addGuest',
                        'guest': JSON.stringify(new Guest()),
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

        $('#guest_group_id').change(function(){
            initFields();
        });

        initFields();
        $('.select2').select2();
    }

    function initFields(name){
        var guest_group_id = $('#guest_group_id').val();
        if (guest_group_id != '' && guest_group_id != null){
            GENERAL.requestType(
                "/guest/add_guest/view/0?classType=tags",
                {
                    'guest_group_id': function(){
                        return $('#guest_group_id').val();
                    }
                },
                'GET',
                true,
                function(data){
                    initSelect('tag_id',data);
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

    function Guest() {
        this.guest_group_id;
        this.tag_id;
        this.users;
        this.reason;
        this.items;

        load = function(self){
            self.guest_group_id = $('#guest_group_id').val();
            self.tag_id = $('#tag_id').val();
            self.users = $('#users').val();
            self.reason = $('#reason').val();
            self.items = $('#items').val();
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