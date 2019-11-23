var Dashboard = function () {
        
    function initPage(){
        $('#print-dtr').click(function () {
            $('#print').printThis();
        });

        $('#date_start').datepicker({
            autoclose: true,
            defaultDate: new Date(),
        });

        $('#date_end').datepicker({
            autoclose: true,
            defaultDate: new Date(),
        });
    }
    
    return {
        //main function to initiate the module
        init: function () {
            initPage();
        }
    };

}();