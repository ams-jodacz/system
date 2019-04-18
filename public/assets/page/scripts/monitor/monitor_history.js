var MonitorHistory = function () {

    var initTable = function () {
        var table = $('#station_log_list_table');
        var oTable = table.dataTable({
            // "processing": true,
            "serverSide": true,
            "ajax": BASE_URL + '/monitor/station/data',
            "deferRender": true,
            "order": [],
            "pagingType": "simple",
            "language": {
                "lengthMenu": "_MENU_",
                "search": "",
                "info": "Showing _START_ to _END_",
            },
            "columns": [
                { "data": 'group_name', 'bSortable': false },
                { "data": 'name', 'bSortable': false },
                { "data": 'id_number', 'bSortable': false },
                { "data": 'full_name', 'bSortable': false },
                { "data": 'status', 'bSortable': false },
                { "data": 'date_time', 'bSortable': false },
                {
                    "data": 'image', 'bSortable': false,
                    "render": function (data, type, full) {
                        var url = BASE_URL + "/images/" + data;
                        return '<img src="' + url + '" height="50" width="50" />';
                    }
                },
                { "render": actionLinks, "data": 'id', 'bSortable': false },
            ]
        });
        var tableWrapper = $('#station_log_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

        $('.select2').select2();
    }

    function actionLinks(data, type, full) {
        var actionValue = $('#action_str').html();
        actionValue = actionValue.replace(/##NUM##/g, data);
        actionValue = actionValue.replace(/##DATE##/g, full.date_time);
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