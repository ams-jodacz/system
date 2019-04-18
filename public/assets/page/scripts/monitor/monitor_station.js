var MonitorStation = function () {

    var lock_state = false;
    var interval = 3000;

    var initTable = function () {
        $('.select2').select2();

        $('#station_group_id').change(function(){
            checkGroupChange();
        });

        if ($('#station_group_id').val() != ""){
            checkGroupChange();
        }
    }

    function checkGroupChange(){
        var group = $('#station_group_id').val();
        if (group == '')
            return;
        GENERAL.requestType(
            '/monitor/station/data',
            {
                'type': 'station_count',
                'group_id': group,
            },
            'GET',
            false,
            function(data){
                $('#profile_container').html("");
                $('#profile_container').html(data.view);
            },
            function(){
                alert("ERROR");
            }
        );
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