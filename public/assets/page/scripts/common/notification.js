var Notification = function () {
    var POLLING_TIME = 1000*60*5;
    var POOLING_STATUS = false;
    var grabNotification = function(){
        startServerPolling(function(){
            requestData();
        },POLLING_TIME);
        requestData();
    }

    function requestData(){
        if (!POOLING_STATUS){
            POOLING_STATUS = true;
            var request = getRequest('/common/notification',[]);
            request.done(function(data){
                $('.common_notification_number').text(data.count);
                if (data.count != 0){
                    $('#common_notification_handler').html(data.msg);
                    $('#common_notification_cont').show();
                }
                else{
                    $('#common_notification_handler').html("");
                    $('#common_notification_cont').hide();
                }
                POOLING_STATUS = false;
            }).error(function(){
                POOLING_STATUS = false;
            });
        }
    }

    function startServerPolling(handler,time){
        // serverlist_interval = setInterval(function(){
        //     // oTable.api().ajax.reload();
        //     handler();
        // },POLLING_TIME);
        serverlist_interval = setInterval(function(){
            handler();
        },time);
    }
    
    function getRequest(url,data){
        var request = $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: BASE_URL+url,
            data: data,
            dataType: 'json'
        });
        
        return request;
    }
    
    return {
        //main function to initiate the module
        init: function () {
            grabNotification();
        }
    };

}();