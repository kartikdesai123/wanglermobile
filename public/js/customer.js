var Customer = function () {
    
   var list = function(){
      $('body').on('click', '.updateCustomer', function() {
          $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "get-customer-list",
                data: {},
                success: function(data) {
                    handleAjaxResponse(data);
                }
            });
      });
      
      var dataArr = {};
       var columnWidth = {"width": "10%", "targets": 0};
       
        var arrList = {
            'tableID': '#customerLIst',
            'ajaxURL': baseurl + "customer-ajaxAction",
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