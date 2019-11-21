var Dashboard = function () {
        
    function initPage(){
        $('#print-dtr').click(function () {
            $('#print').printThis();
        });
    }
    
    return {
        //main function to initiate the module
        init: function () {
            initPage();
        }
    };

}();