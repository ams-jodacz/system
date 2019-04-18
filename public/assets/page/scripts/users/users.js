var Users = function () {

    var initUsers = function () {
        var table = $('#user_list_table');
        var oTable = table.dataTable({
            "deferRender": true,
        });
        var tableWrapper = $('#user_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
        
        $('.reset_pwd').click(function(event){
            var data_id = $(this).attr('data_id');
            var request = getRequest("/users/update/"+data_id,{
                'actionType':'resetPwd'
            });
            request.done(function(data){
                bootbox.alert(data.msg);
            }).error(function(){
                bootbox.alert("Unexpected error encounter, Please try again later!");
            });
        });
        
        $('.users_change_status').click(function(event){
            var data_id = $(this).attr('data_id');
            var request = getRequest("/users/update/"+data_id,{
                'actionType':'status'
            });
            request.done(function(data){
                if (data.status){
                    var statusHndle = $('#status_field_'+data_id);
                    var statusMsg = statusHndle.html();
                    statusHndle.html(statusMsg=='Active'?'Inactive':'Active');
                    statusHndle.removeClass(statusMsg=='Active'?'label-success':'label-danger');
                    statusHndle.addClass(statusMsg=='Active'?'label-danger':'label-success');
                }
                else{
                    bootbox.alert('Unable to Update Status, Please try again later!');
                }
            }).error(function(){
                bootbox.alert("Unexpected error encounter, Please try again later!");
            });
        });
        
        $('.remove_user').click(function(event){
            var data_id = $(this).attr('data_id');
            bootbox.confirm("Are you sure to permanently remove this user?", function(result) {
                if (result) {
                    var request = getRequest("/users/delete/"+data_id);
                    request.done(function(data){
                        if (data.status){
                            var row = $('.row_'+data_id).closest('tr');
                            oTable.fnDeleteRow(row[0]);
                        }
                        else{
                            bootbox.alert("Unable to remove user,Please try again!");
                        }
                    }).error(function(){
                        bootbox.alert("Unexpected error encounter, Please try again later!");
                    });
                }
            });
        });
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
            if (!jQuery().dataTable) {
                return;
            }
            initUsers();
        }
    };

}();