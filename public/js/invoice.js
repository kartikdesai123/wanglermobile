var Invoice = function () {
    
   var list = function(){
      $('body').on('click', '.createInvoice', function() {
          $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "create-invoice",
                data: {},
                success: function(data) {
                    handleAjaxResponse(data);
                }
            });
      });
      
      $('body').on('click', '.updateInvoice', function() {
          $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "get-invoice-list",
                data: {},
                success: function(data) {
                    handleAjaxResponse(data);
                }
            });
      });
      
      var dataArr = {};
       var columnWidth = {"width": "10%", "targets": 0};
       
        var arrList = {
            'tableID': '#invoiceList',
            'ajaxURL': baseurl + "invoice-ajaxAction",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSearchApply': [0],
            'noSortingApply': [3,5],
            'defaultSortColumn': 0,
            'defaultSortOrder': 'desc',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);
   };

    return {
        init: function () {
            list();
        },
      
    }
}();