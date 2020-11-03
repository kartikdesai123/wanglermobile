var Product = function () {
    
    var list = function(){
       
       $('body').on('click', '.updateProductList', function() {
          $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "get-product-list",
                data: {},
                success: function(data) {
                    handleAjaxResponse(data);
                }
            });
      });
      
      var dataArr = {};
       var columnWidth = {"width": "10%", "targets": 0};
       
        var arrList = {
            'tableID': '#productLIst',
            'ajaxURL': baseurl + "product-ajaxAction",
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
    }
    
    return {
        init: function () {
            list();
        },
        
    }
}();