var Stations = function () {

    var initTable = function () {
        var table = $('#stations_list_table');
        var oTable = table.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": BASE_URL+'/stations/data',
            "deferRender": true,
            "pagingType": "simple",
            "language": {
                "lengthMenu": "_MENU_",
                "search": "",
                "info": "Showing _START_ to _END_",
            },
            "columns": [
                { "data": 'name' },
                { "data": 'ip' },
                { "data": 'group_name' },
                { "data": 'description' },
                { "data": 'status' },
                { "render": function(data, type, full){
                        return (data==1)?'Enabled':'Disabled';
                    }, 
                    "data": 'enable_status' 
                },
                { "render": actionLinks, "data": 'station_id', },
            ],
        });
        var tableWrapper = $('#stations_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
        
        oTable.delegate('.remove_btn','click',function(event){
            var data_id = $(this).attr('data-id');
            bootbox.confirm("Are you sure to remove this station?", function(result) {
                if (result) {
                    GENERAL.request(
                        "/stations/delete/"+data_id,
                        {},
                        true,
                        function(data){
                            if (data.status){
                                oTable.fnDraw();
                            }
                            else{
                                bootbox.alert("Unable to remove station,Please try again!");
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