var MonitorPublic = function () {    
    var interval = 2000;
    var clear_interval_in_min = 5;
    var clear_interval = 1000 * 60 * clear_interval_in_min;

    var port = 0;
    var host = 0;
    var station_ids = [];

    var clear_interval_handler = {};

    //init Page JS
    function initPage(){
        jQuery(".main-title").fitText(4, { minFontSize: '30px', maxFontSize: '80px' });
        jQuery(".usercard__description-title").fitText(0.8);
        jQuery(".usercard__description-subtitle").fitText(1);
        jQuery(".usercard__description-label").fitText(1);
        jQuery(".usercard__footer").fitText(2.5, { minFontSize: '20px' });
        
        // // ParticlesJS Config.
        // particlesJS("particles-js", {
        //     "particles": {
        //         "number": {
        //             "value": 80,
        //             "density": {
        //                 "enable": true,
        //                 "value_area": 700
        //             }
        //         },
        //         "color": {
        //             "value": "#ffffff"
        //         },
        //         "shape": {
        //             "type": "circle",
        //             "stroke": {
        //                 "width": 0,
        //                 "color": "#000000"
        //             },
        //             "polygon": {
        //                 "nb_sides": 5
        //             },
        //         },
        //         "opacity": {
        //             "value": 0.5,
        //             "random": false,
        //             "anim": {
        //                 "enable": false,
        //                 "speed": 1,
        //                 "opacity_min": 0.1,
        //                 "sync": false
        //             }
        //         },
        //         "size": {
        //             "value": 3,
        //             "random": true,
        //             "anim": {
        //                 "enable": false,
        //                 "speed": 40,
        //                 "size_min": 0.1,
        //                 "sync": false
        //             }
        //         },
        //         "line_linked": {
        //             "enable": true,
        //             "distance": 150,
        //             "color": "#ffffff",
        //             "opacity": 0.4,
        //             "width": 1
        //         },
        //         "move": {
        //             "enable": true,
        //             "speed": 6,
        //             "direction": "none",
        //             "random": false,
        //             "straight": false,
        //             "out_mode": "out",
        //             "bounce": false,
        //             "attract": {
        //                 "enable": false,
        //                 "rotateX": 600,
        //                 "rotateY": 1200
        //             }
        //         }
        //     },
        //     "interactivity": {
        //         "detect_on": "canvas",
        //         "events": {
        //             "onhover": {
        //                 "enable": true,
        //                 "mode": "grab"
        //             },
        //             "onclick": {
        //                 "enable": true,
        //                 "mode": "push"
        //             },
        //             "resize": true
        //         },
        //         "modes": {
        //             "grab": {
        //                 "distance": 140,
        //                 "line_linked": {
        //                     "opacity": 1
        //                 }
        //             },
        //             "bubble": {
        //                 "distance": 400,
        //                 "size": 40,
        //                 "duration": 2,
        //                 "opacity": 8,
        //                 "speed": 3
        //             },
        //             "repulse": {
        //                 "distance": 200,
        //                 "duration": 0.4
        //             },
        //             "push": {
        //                 "particles_nb": 4
        //             },
        //             "remove": {
        //                 "particles_nb": 2
        //             }
        //         }
        //     },
        //     "retina_detect": true
        // });
    }

    var initTable = function () {
        initWebSocket();
    }

    function initAjax(){
        for (interval_key in clear_interval_handler){
            clearInterval(clear_interval_handler[interval_key]);
            delete clear_interval_handler[interval_key];
            console.log(clear_interval_handler);
        }
        setInterval(getStationData, interval);
    }

    function getStationData(){
        var group = $('#station_group_id').val();
        if (group == '') {
            return;
        }

        $.ajax({
            url: BASE_URL+'/monitor/public_station/data',
            data: {
                'type': 'station_profile',
                'group_id': group,
            }
        })
        .done(function(data) {
            data = JSON.parse(data);
            if (data.station_data != undefined && data.station_data != null && data.station_data.length > 0){
                data.station_data.forEach(function(info){
                    renderData(info);
                });
            }
        });
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
                if (info.station_id != undefined && info.station_id != null && station_ids.indexOf(info.station_id.toString()) >= 0){
                    if (clear_interval_handler[info.station_id] != undefined){
                        clearInterval(clear_interval_handler[info.station_id]);
                    }
                    clear_interval_handler[info.station_id] = setInterval(function(){
                        clearRenderData(info.station_id);
                        clearInterval(clear_interval_handler[info.station_id]);
                        delete clear_interval_handler[info.station_id];
                    },clear_interval);
                }
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
            if (info.time_diff != undefined && info.time_diff >= clear_interval_in_min){ //exclude data five_min_interval
                clearRenderData(info.station_id);
            }
            else{
                // $('.station_' + info.station_id).attr('src', BASE_URL + '/images/' + info.image);
                $('.station_' + info.station_id).css('background-image', 'url(' + BASE_URL + '/images/' + info.image + ')');
                $('.station_number_' + info.station_id).text("");
                $('.station_number_' + info.station_id).text(info.id_number);
                $('.station_name_' + info.station_id).text("");
                $('.station_name_' + info.station_id).text(info.full_name);
                $('.station_time_' + info.station_id).text("");
                $('.station_time_' + info.station_id).text(info.date_time);
            }
        }
    }

    function clearRenderData(station_id){
        console.log('clear interval '+station_id);
        // $('.station_' + station_id).attr('src', BASE_URL + '/images/avatar.png');
        $('.station_' + station_id).css('background-image', 'url('+BASE_URL + '/images/avatar.png'+')');
        $('.station_number_' + station_id).text("");
        $('.station_name_' + station_id).text("");
        $('.station_time_' + station_id).text("");
    }
    
    return {
        //main function to initiate the module
        init: function () {
            initPage();
            initTable();
        },
        setStationsIDs(id_list){
            station_ids = id_list.toString().split(',');
        },
        setPort: function(ws_port){
            port = ws_port;
        },
        setHost: function(ws_host){
            host = ws_host;
        }
    };

}();