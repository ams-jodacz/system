var Group = function () {

    var initGroups = function () {
        var table = $('#group_list_table');
        var oTable = table.dataTable({
            "deferRender": true,
        });
        var tableWrapper = $('#group_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
        
        $('.remove_group').click(function(event){
            var data_id = $(this).attr('data_id');
            bootbox.confirm("Are you sure to permanently remove this Group?", function(result) {
                if (result) {
                    var request = getRequest("/users/group/delete/"+data_id);
                    request.done(function(data){
                        if (data.status){
                            var row = $('.row_'+data_id).closest('tr');
                            oTable.fnDeleteRow(row[0]);
                        }
                        else{
                            bootbox.alert("Unable to remove Group,Please try again!");
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
            initGroups();
        }
    };

}();