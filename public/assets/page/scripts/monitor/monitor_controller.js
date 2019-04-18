var MonitorController = function () {

    var lock_state = false;
    var interval = 3000;

    var initTable = function () {
        var table = $('#station_controller_list_table');
        var oTable = table.dataTable({
            // "processing": true,
            "serverSide": true,
            "ajax": BASE_URL+'/monitor/controller/data',
            "deferRender": true,
            "pagingType": "simple",
            "language": {
                "lengthMenu": "_MENU_",
                "search": "",
                "info": "Showing _START_ to _END_",
            },
            "columns": [
                { "data": 'group_name'},
                { "data": 'name'},
                { "render": function(data, type, full){
                    return (data==0)?'Down':'Up';
                  },
                  "data": 'station_status'
                },
                { "render": function(data, type, full){
                    return (data==0)?'':'Restarting';
                  },
                  "data": 'restart_status'
                },
                { "render": actionLinks, "data": 'station_id'},
            ],
            "fnDrawCallback": function(){
                lock_state = false;
            },
        });
        var tableWrapper = $('#station_controller_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

        oTable.delegate('.restart_btn','click',function(event){
            var data_id = $(this).attr('data-id');
            bootbox.confirm("Are you sure to restart this station?", function(result) {
                if (result) {
                    GENERAL.request(
                        "/monitor/controller/update/"+data_id,
                        {},
                        true,
                        function(data){
                            if (data.status){
                                oTable.fnDraw();
                            }
                            else{
                                bootbox.alert("Unable to restart station,Please try again!");
                            }
                        },
                        function(){
                            bootbox.alert("Unexpected error encounter, Please try again later!");
                        }
                    );
                }
            });
        });

        setInterval(
            function(){ 
                if (!lock_state){
                    oTable.api().ajax.reload(null,false);
                    // oTable.fnDraw(false);
                    lock_state = true;
                }
            }, 
            interval
        );
    }

    function actionLinks(data, type, full) {
        var actionValue = $('#action_str').html();
        actionValue = actionValue.replace(/##NUM##/g, data);
        if (full.station_status == 1 && full.restart_status == 0){
            var actionValue2 = $('#action_str2').html();
            actionValue2 = actionValue2.replace(/##NUM##/g, data);
            actionValue = actionValue + actionValue2;
        }
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