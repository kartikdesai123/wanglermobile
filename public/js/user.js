var User = function () {
    
    var list = function(){
        
         $('body').on('click', '.deleteicon', function() {
            // $('#deleteModel').modal('show');
            var id = $(this).data('id');
            var profileimage = $(this).data('profileimage');
            
            setTimeout(function() {
                $('.yes-sure:visible').attr('data-id', id);
                $('.yes-sure:visible').attr('data-profileimage', profileimage);
            }, 500);
        })

        $('body').on('click', '.yes-sure', function() {
            var id = $(this).attr('data-id');
            var profileimage = $(this).attr('data-profileimage');
            
            var data = {profileimage:profileimage,id: id, _token: $('#_token').val()};
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "userList-ajaxAction",
                data: {'action': 'deleteUser', 'data': data},
                success: function(data) {
                    handleAjaxResponse(data);
                }
            });
        });
      
      
        var dataArr = {};
       var columnWidth = {"width": "10%", "targets": 0};
       
        var arrList = {
            'tableID': '#userList',
            'ajaxURL': baseurl + "userList-ajaxAction",
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
    
    var adduser = function(){
        var form = $('#addUser');
        var rules = {
            firstname: {required: true},
            lastname: {required: true},
            password: {required: true},
            email: {required: true,email:true},
        };

        handleFormValidate(form, rules, function (form) {
            handleAjaxFormSubmit(form, true);
        }); 
    }
    var edituser = function(){
       var form = $('#editUser');
        var rules = {
            firstname: {required: true},
            lastname: {required: true},
            email: {required: true,email:true},
        };

        handleFormValidate(form, rules, function (form) {
            handleAjaxFormSubmit(form, true);
        }); 
    }

    return {
        init: function () {
            list();
        },
        add: function () {
            adduser();
        },
        edit: function () {
            edituser();
        }
    }
}();