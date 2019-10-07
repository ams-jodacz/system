var MonitorPublic = function () {

    var lock_state = false;
    var interval = 2000;

    var port = 0;
    var host = 0;

    var initTable = function () {
        $('.select2').select2({
            allowClear: true,
            placeHolder: 'Select Station Group',
        });

        $('#station_group_id').change(function(){
            checkGroupChange();
        });

        if ($('#station_group_id').val() != ""){
            checkGroupChange();
        }

        initWebSocket();
    }

    function initAjax(){
        setInterval(getStationData, interval);
    }

    function checkGroupChange(){
        var group = $('#station_group_id').val();
        if (group == ''){
            $('#profile_container').html("");
            return;
        }
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

    function getStationData(){
        var group = $('#station_group_id').val();
        if (group == '') {
            return;
        }
        GENERAL.requestType(
            '/monitor/station/data',
            {
                'type': 'station_profile',
                'group_id': group,
            },
            'GET',
            false,
            function (data) {
                if (data.station_data != undefined && data.station_data != null && data.station_data.length > 0){
                    data.station_data.forEach(function(info){
                        renderData(info);
                    });
                }
            },
            function () {
                alert("ERROR");
            }
        );
    }

    function initWebSocket(){
        // var path = 'ws://' + window.location.host + ':9000';
        var path = 'ws://'+host+':'+port;
        // console.log(path);
        // return;
        var socket = new WebSocket(path);

        socket.onerror = function (event) {
            initAjax();
        }

        // Open the socket
        socket.onopen = function (event) {
            // Send an initial message
            // socket.send(msg);

            // Listen for messages
            socket.onmessage = function (event) {
                var info = JSON.parse(event.data);
                renderData(info);
            };

            // Listen for socket closes
            socket.onclose = function (event) {
                console.log('Client notified socket has closed', event);
            };
        };
    }

    function renderData(info){
        if (info.station_id != undefined && info.station_id != null){
            $('#station_' + info.station_id).attr('src', BASE_URL + '/images/' + info.image);
            $('#station_number_' + info.station_id).text("");
            $('#station_number_' + info.station_id).text(info.id_number);
            $('#station_name_' + info.station_id).text("");
            $('#station_name_' + info.station_id).text(info.full_name);
            $('#station_time_' + info.station_id).text("");
            $('#station_time_' + info.station_id).text(info.date_time);
        }
    }
    
    return {
        //main function to initiate the module
        init: function () {
            initTable();
        },
        setPort: function(ws_port){
            port = ws_port;
        },
        setHost: function(ws_host){
            host = ws_host;
        }
    };

}();