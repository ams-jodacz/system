var Member = function () {

    var initTable = function () {
        var table = $('#member_list_table');
        var oTable = table.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                'url': BASE_URL + '/member/data',
                'data': {
                    'status_filter': function () {
                        return $('#active_status').val();
                    },
                    'group_filter': function () {
                        return $('#group_filter').val();
                    },
                },
            },
            "pagingType": "simple",
            "language": {
                "lengthMenu": "_MENU_",
                "search": "",
                "info": "Showing _START_ to _END_",
            },
            "deferRender": true,
            "columns": [
                { "data": 'profile_image', render: profileTemplate, "orderable": false,},
                { "data": 'id_number' },
                { "data": 'first_name' },
                { "data": 'middle_name' },
                { "data": 'last_name' },
                { "data": 'contact_number' },
                { "data": 'classification_name' },
                { "data": 'group_name' },
                { "render": function(data, type, full){
                        return (data == 1)?'Active':'Inactive';
                    }, 
                    "data": 'active_status' 
                },
                { "render": actionLinks, "data": 'member_id', },
            ],
            // "dom": '<"row"<"col-md-6 col-sm-12"<"pull-left"f>><"col-md-6 col-sm-12"<"pull-right"l>>r><"table-scrollable"t><"row"<"col-md-5 col-sm-12"i><"col-md-7 col-sm-12"p>>',
            "dom": '<"row"<"col-md-8 col-sm-12"<"pull-left"<"toolbar pull-right"><"pull-left"f>>><"col-md-4 col-sm-12"<"pull-right"l>>r><"table-scrollable"t><"row"<"col-md-5 col-sm-12"i><"col-md-7 col-sm-12"p>>',
            // "dom": '<"row"<"col-md-12 col-sm-12"<"pull-left"<"toolbar pull-right"><"pull-left"f>>>r><"table-scrollable"t><"row table_footer"<"col-md-4 col-sm-12"i><"col-md-8 col-sm-12"p>>',
            // "dom": '<"row"<"col-md-12 col-sm-12"<"pull-left"<"toolbar pull-right"><"pull-left"f>>>r><"table-scrollable"t><"row table_footer"<"col-md-4 col-sm-12"><"col-md-8 col-sm-12"<"pull-right"i>>>',
        });
        var tableWrapper = $('#member_list_table_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

        tableWrapper.find('.toolbar').html($('#action_tbl_filter_str').html());

        $('#active_status').select2().change(function(){
            oTable.fnDraw();
        });

        $('#group_filter').select2({
            allowClear: true,
            placeholder: 'Select Group..',
            ajax: {
                url: BASE_URL + '/member/data?type=group_list',
                dataType: 'json',
                data: function (term, page) {
                    var query = {
                        search: term,
                        page: page || 1,
                    }
                    return query;
                },
                results: function (data) {
                    return data;
                },
            },
        }).change(function(){
            oTable.fnDraw();
        });

        oTable.delegate('.purge_tag', 'click', function (event) {
            var data_id = $(this).attr('data-id');
            bootbox.confirm("Are you sure to purge tag?", function (result) {
                if (result) {
                    GENERAL.request(
                        "/member/update/" + data_id + '?actionType=purgeData',
                        {},
                        true,
                        function (data) {
                            if (data.status) {
                                oTable.fnDraw();
                            }
                            else {
                                bootbox.alert("Unable to remove member,Please try again!");
                            }
                            lock_key = false;
                        },
                        function () {
                            bootbox.alert("Unexpected error encounter, Please try again later!");
                            lock_key = false;
                        }
                    );
                }
            });
        });
        
        oTable.delegate('.remove_btn','click',function(event){
            var data_id = $(this).attr('data-id');
            bootbox.confirm("Are you sure to remove this member?", function(result) {
                if (result) {
                    GENERAL.request(
                        "/member/delete/"+data_id,
                        {},
                        true,
                        function(data){
                            if (data.status){
                                oTable.fnDraw();
                            }
                            else{
                                bootbox.alert("Unable to remove member,Please try again!");
                            }
                            lock_key = false;
                        },
                        function(){
                            bootbox.alert("Unexpected error encounter, Please try again later!");
                            lock_key = false;
                        }
                    );
                }
            });
        });
    }

    function profileTemplate(data,type,full){
        var url = BASE_URL + "/images/" + data;
        return '<center><img src="' + url + '" height="50" width="50" /></center>';
    }

    function actionLinks(data, type, full) {
        var actionValue = $('#action_str').html();
        if (full.tag != undefined && full.tag != null && full.tag != ''){
            actionValue += $('#action_str_2').html();
        }

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