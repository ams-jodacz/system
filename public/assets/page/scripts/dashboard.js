var Dashboard = function () {
        
    function initPage(){
        $('#print-dtr').click(function () {
            $('.report_container').printThis();
        });

        $('#date_start').datepicker({
            autoclose: true,
            defaultDate: new Date(),
        });

        $('#date_end').datepicker({
            autoclose: true,
            defaultDate: new Date(),
        });

        $('#member_filter').select2({
            allowClear: true,
            placeholder: 'Select a member..',
            ajax: {
                url: BASE_URL + '/data?type=member_list',
                dataType: 'json',
                type: 'post',
                data: function(term, page) {
                    var query = {
                        search: term,
                        page: page || 1,
                    }
                    return query;
                },
                results: function (data) {
                    return data;
                },
                params: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
            },
        });

        $('#get-report').click(function(){
            if ($('#member_filter').val() == null || $('#member_filter').val() == ''){
                bootbox.alert("Select a member first!");
                return false;
            }
            if ($('#date_start').val() == '' || $('#date_end').val() == '') {
                bootbox.alert("Select a date first!");
                return false;
            }
            var request = getRequest("/data?type=report", {
                'member_id': function(){
                    return $('#member_filter').val();
                },
                'date_start': function () {
                    return $('#date_start').val();
                },
                'date_end': function () {
                    return $('#date_end').val();
                },
            });
            request.done(function (data) {
                if (data.status){
                    $('#report_area').html(data.content);
                }
                else{
                    bootbox.alert(data.message);
                }
            }).error(function () {
                bootbox.alert("Unexpected error encounter, Please try again later!");
            });
        });
    }

    function getRequest(url, data) {
        var request = $.ajax({
            type: 'POST',
            url: BASE_URL + url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            dataType: 'json'
        });

        return request;
    }
    
    return {
        //main function to initiate the module
        init: function () {
            initPage();
        }
    };

}();