var Member = function () {

    var initTable = function () {
        var table = $('#member_list_table');
        var oTable = table.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": BASE_URL+'/member/data',
            "pagingType": "simple",
            "language": {
                "lengthMenu": "_MENU_",
                "search": "",
                "info": "Showing _START_ to _END_",
            },
            "deferRender": true,
            "columns": [
                { "data": 'profile_image', render: profileTemplate, "orderable": false,},
                { "data": 'id_number' },
                { "data": 'first_name' },
                { "data": 'middle_name' },
                { "data": 'last_name' },
                { "data": 'contact_number' },
                { "data": 'classification_name' },
                { "data": 'group_name' },
                { "render": function(data, type, full){
                        return (data == 1)?'Active':'Inactive';
                    }, 
                    "data": 'active_status' 
                },
                { "render": actionLinks, "data": 'member_id', },
            ],
        });
        var tableWrapper = $('#member_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

        oTable.delegate('.purge_tag', 'click', function (event) {
            var data_id = $(this).attr('data-id');
            bootbox.confirm("Are you sure to purge tag?", function (result) {
                if (result) {
                    GENERAL.request(
                        "/member/update/" + data_id + '?actionType=purgeData',
                        {},
                        true,
                        function (data) {
                            if (data.status) {
                                oTable.fnDraw();
                            }
                            else {
                                bootbox.alert("Unable to remove member,Please try again!");
                            }
                            lock_key = false;
                        },
                        function () {
                            bootbox.alert("Unexpected error encounter, Please try again later!");
                            lock_key = false;
                        }
                    );
                }
            });
        });
        
        oTable.delegate('.remove_btn','click',function(event){
            var data_id = $(this).attr('data-id');
            bootbox.confirm("Are you sure to remove this member?", function(result) {
                if (result) {
                    GENERAL.request(
                        "/member/delete/"+data_id,
                        {},
                        true,
                        function(data){
                            if (data.status){
                                oTable.fnDraw();
                            }
                            else{
                                bootbox.alert("Unable to remove member,Please try again!");
                            }
                            lock_key = false;
                        },
                        function(){
                            bootbox.alert("Unexpected error encounter, Please try again later!");
                            lock_key = false;
                        }
                    );
                }
            });
        });
    }

    function profileTemplate(data,type,full){
        var url = BASE_URL + "/images/" + data;
        return '<center><img src="' + url + '" height="50" width="50" /></center>';
    }

    function actionLinks(data, type, full) {
        var actionValue = $('#action_str').html();
        if (full.tag != undefined && full.tag != null && full.tag != ''){
            actionValue += $('#action_str_2').html();
        }

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