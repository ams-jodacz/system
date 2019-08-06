GENERAL = function(){

    var lock_key = false;

    //reload Page
    function getPage(url,data){
        if (lock_key){
            return;
        }
        lock_key = true;
        var request = $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            data: data,
            // dataType: 'json',
            beforeSend : function() {
                $('#loading_indicator').show();
            },
            complete: function(){
                $('#loading_indicator').hide();
            },
        })
        .done(function(data){
            $('#page-content').html(data);
            lock_key = false;
        })
        .error(function(){
            bootbox.alert("Unexpected error encounter, Please try again later!");
            lock_key = false;
        });;
    }

    //get Request
    function getRequest(url,data,type,syncStatus,donefunction,errorfunction,afterDoneFunction){
        if (lock_key){
            return;
        }
        lock_key = true;
        var request = $.ajax({
            type: type,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                $('#loading_indicator').show();
            },
            complete: function(){
                $('#loading_indicator').hide();
            },
            url: BASE_URL+url,
            data: data,
            async: syncStatus,
            dataType: 'json'
        })
        .done(function(data){
            donefunction(data);
            lock_key = false;
            if (afterDoneFunction != null)
                afterDoneFunction();
        })
        .error(function(){
            errorfunction();
            lock_key = false;
        });
    }

    return {
        request: function (url,data,syncStatus,donefunction,errorfunction) {
            getRequest(url,data,'POST',syncStatus,donefunction,errorfunction,null);
        },
        requestType: function (url,data,type,syncStatus,donefunction,errorfunction) {
            getRequest(url,data,type,syncStatus,donefunction,errorfunction,null);
        },
        requestAfter: function (url,data,type,syncStatus,donefunction,errorfunction,afterDoneFunction) {
            getRequest(url,data,type,syncStatus,donefunction,errorfunction,afterDoneFunction);
        },
    };
}();