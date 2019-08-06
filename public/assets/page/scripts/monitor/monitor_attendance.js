var MonitorAttendance = function () {

    var lock_state = false;
    var interval = 3000;

    var initTable = function () {
        var table = $('#attendance_log_list_table');
        var oTable = table.dataTable({
            // "processing": true,
            "serverSide": true,
            "ajax": BASE_URL+'/monitor/attendance/data',
            "deferRender": true,
            "order": [],
            "pagingType": "simple",
            "language": {
                "lengthMenu": "_MENU_",
                "search": "",
                "info": "Showing _START_ to _END_",
            },
            "columns": [
                { "data": 'group_name', 'bSortable': false},
                { "data": 'name', 'bSortable': false},
                { "data": 'id_number', 'bSortable': false},
                { "data": 'full_name', 'bSortable': false},
                { "data": 'status', 'bSortable': false},
                { "data": 'date_time', 'bSortable': false},
                { "data": 'image', 'bSortable': false,
                    "render": function(data, type, full){
                        var url = BASE_URL + "/images/"+data;
                        return '<img src="'+url+'" height="50" width="50" />';
                    }
                },
                { "render": actionLinks, "data": 'member_id', 'bSortable': false},
            ],
            "fnDrawCallback": function(){
                lock_state = false;
            },
        });
        var tableWrapper = $('#attendance_log_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

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