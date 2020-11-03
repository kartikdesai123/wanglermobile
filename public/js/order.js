var Order = function() {
    var handleList = function() {
        var form = $('#order');
        var rules = {
            company_name: {required: true},
            subcription: {required: true},
            request_type: {required: true},
            payment_type: {required: true},
            company_email: {required: true},
        };
        handleFormValidate(form, rules, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }
    return {
        init: function() {
            handleList();
        }
    }
}();