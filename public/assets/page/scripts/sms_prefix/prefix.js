var Prefix = function () {

    var initTable = function () {
        var table = $('#prefix_list_table');
        var oTable = table.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": BASE_URL+'/sms/prefix/data',
            "deferRender": true,
            "pagingType": "simple",
            "language": {
                "lengthMenu": "_MENU_",
                "search": "",
                "info": "Showing _START_ to _END_",
            },
            "columns": [
                { "data": 'group_name' },
                { "data": 'prefix' },
                { "render": actionLinks, "data": 'sms_prefix_id', },
            ],
        });
        var tableWrapper = $('#prefix_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
        
        oTable.delegate('.remove_btn','click',function(event){
            var data_id = $(this).attr('data-id');
            bootbox.confirm("Are you sure to remove this prefix?", function(result) {
                if (result) {
                    GENERAL.request(
                        "/sms/prefix/delete/"+data_id,
                        {},
                        true,
                        function(data){
                            if (data.status){
                                oTable.fnDraw();
                            }
                            else{
                                bootbox.alert("Unable to remove prefix,Please try again!");
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