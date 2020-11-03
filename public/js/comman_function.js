
function getDataTable2222(tableID, ajaxPath, extraOption) {
    // alert("emter");
    if (typeof extraOption === 'undefined') {
        extraOption = {};
    }
    var grid = new Datatable();
    var options = {
        src: $(tableID),
        onSuccess: function (grid, response) {
            // grid:  datatable      grid object
            // response:    json object of server side ajax response
            // execute some code after table records loaded
        },
        onError: function (grid) {
            // execute some code on network or other general error
        },
        onDataLoad: function (grid) {
            // execute some code on ajax data load
        },
        loadingMessage: 'Loading...',
        dataTable: {// here you can define a typical datatable settings from http://datatables.net/usage/options

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
            // So when dropdowns used the scrollable div should be removed.
            "dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'f<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [10, 20, 50, 100, 150, -1],
                [10, 20, 50, 100, 150, "All"] // change per page values here
            ],
            "pageLength": 10, // default record count per page
            //            "ajax": {
            //                "url": ajaxPath, // ajax source
            //            },
            "order": [
                [1, "asc"]
            ],
            fixedHeader: {
                header: false
            }
// set first column as a default sort by asc
//            "aoColumnDefs": [{// define columns sorting options(by default all columns are sortable extept the first checkbox column)
//                    'bSortable': false,
//                    'aTargets': [0, -1]
//                }]

        }
    };


    options = $.extend(true, options, extraOption);
    if ('ajax' in options.dataTable == false) {
        options.dataTable.ajax = {"url": ajaxPath};
    }
    grid.init(options);

    // setTimeout(function() {
    //     grid.getDataTable().ajax.reload();
    // }, 500);

    // handle group actionsubmit button click
    grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
        e.preventDefault();
        var action = $(".table-group-action-input", grid.getTableWrapper());
        if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
            grid.setAjaxParam("customActionType", "group_action");
            grid.setAjaxParam("customActionName", action.val());
            grid.setAjaxParam("id", grid.getSelectedRows());
            grid.getDataTable().ajax.reload();
            grid.clearAjaxParams();
        } else if (action.val() == "") {
            App.alert({
                type: 'danger',
                icon: 'warning',
                message: 'Please select an action',
                container: grid.getTableWrapper(),
                place: 'prepend'
            });
        } else if (grid.getSelectedRowsCount() === 0) {
            App.alert({
                type: 'danger',
                icon: 'warning',
                message: 'No record selected',
                container: grid.getTableWrapper(),
                place: 'prepend'
            });
        }
    });

    grid.setAjaxParam("customActionType", "group_action");

    grid.clearAjaxParams();
    return grid;
}

function getDataTableNoAjax(tableID, extraOption) {
    if (typeof extraOption === 'undefined') {
        extraOption = {};
    }
    var grid = new Datatable();
    var options = {
        src: $(tableID),
        loadingMessage: 'Loading...',
        dataTable: {
            "dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'f<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
//            "bStateSave": true,
            "lengthMenu": [
                [10, 20, 50, 100, 150, -1],
                [10, 20, 50, 100, 150, "All"]
            ],
            "pageLength": 50,
            "order": [
                [0, "asc"]
            ],
            "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [2, 3]
                }],
            "serverSide": false,
            "ajax": null
        }
    };
    options = $.extend(true, options, extraOption);
    grid.init(options);
    return grid;
}

function getDataTable2(tableID, ajaxPath) {
    var grid = new Datatable();

    grid.init({
        src: $(tableID),
        onSuccess: function (grid, response) {
            // grid:        grid object
            // response:    json object of server side ajax response
            // execute some code after table records loaded
        },
        onError: function (grid) {
            // execute some code on network or other general error
        },
        onDataLoad: function (grid) {
            // execute some code on ajax data load
        },
        loadingMessage: 'Loading...',
        dataTable: {// here you can define a typical datatable settings from http://datatables.net/usage/options

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
            // So when dropdowns used the scrollable div should be removed.
            //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            "bServerSide": true,
            "bProcessing": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "lengthMenu": [
                [10, 20, 50, 100, 150, -1],
                [10, 20, 50, 100, 150, "All"] // change per page values here
            ],
            "pageLength": 10, // default record count per page
            "ajax": {
                "url": ajaxPath, // ajax source
            },
            "order": [
                [1, "asc"]
            ]// set first column as a default sort by asc
        }
    });

    // handle group actionsubmit button click
    grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
        e.preventDefault();
        var action = $(".table-group-action-input", grid.getTableWrapper());
        if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
            grid.setAjaxParam("customActionType", "group_action");
            grid.setAjaxParam("customActionName", action.val());
            grid.setAjaxParam("id", grid.getSelectedRows());
            grid.getDataTable().ajax.reload();
            grid.clearAjaxParams();
        } else if (action.val() == "") {
            App.alert({
                type: 'danger',
                icon: 'warning',
                message: 'Please select an action',
                container: grid.getTableWrapper(),
                place: 'prepend'
            });
        } else if (grid.getSelectedRowsCount() === 0) {
            App.alert({
                type: 'danger',
                icon: 'warning',
                message: 'No record selected',
                container: grid.getTableWrapper(),
                place: 'prepend'
            });
        }
    });

    grid.setAjaxParam("customActionType", "group_action");
    //    grid.getDataTable().ajax.reload();
    grid.clearAjaxParams();

}

function getQueryString(field, url) {
    var href = url ? url : window.location.href;
    var reg = new RegExp('[?&]' + field + '=([^&#]*)', 'i');
    var string = reg.exec(href);
    return string ? string[1] : null;
}


function CKupdate() {
    for (instance in CKEDITOR.instances)
        CKEDITOR.instances[instance].updateElement();
}
if (typeof CKEDITOR !== 'undefined') {
    CKEDITOR.on('instanceCreated', function (ev) {
        CKEDITOR.dtd.$removeEmpty['a'] = 0;
    })
}

function ajaxcall(url, data, callback) {
    //  App.startPageLoading();

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: false,
        success: function (result) {
            //   App.stopPageLoading();
            callback(result);
        }
    })
}

function handleAjaxFormSubmit(form, type) {
    if (typeof type === 'undefined') {
        ajaxcall($(form).attr('action'), $(form).serialize(), function (output) {
            handleAjaxResponse(output);
        });
    } else if (type === true) {
        // App.startPageLoading();
        var options = {
            resetForm: false, // reset the form after successful submit
            success: function (output) {
                //   App.stopPageLoading();
                handleAjaxResponse(output);
            }
        };
        $(form).ajaxSubmit(options);
    }
    return false;
}

function showToster(status, message) {

    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 4000
    };
    if (status == 'success') {
        toastr.success(message, 'Success');
    }
    if (status == 'error') {
        toastr.error(message, 'Fail');
    }



}

function handleAjaxResponse(output) {

    output = JSON.parse(output);

    if (output.message != '') {

        showToster(output.status, output.message, '');
    }
    if (typeof output.redirect !== 'undefined' && output.redirect != '') {
        setTimeout(function () {
            window.location.href = output.redirect;
        }, 4000);
    }
    if (typeof output.jscode !== 'undefined' && output.jscode != '') {
        eval(output.jscode);
    }
}

function _fn_getQueryStringValue(name) {
    var regex = new RegExp("[\\?&]" + name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]") + "=([^&#]*)"), results = regex.exec(window.location.search);
    return results ? decodeURIComponent(results[1].replace(/\+/g, " ")) : '';
}

function handleFormValidate(form, rules, submitCallback, showToaster) {

    var error = $('.alert-danger', form);
    var success = $('.alert-success', form);
    form.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: ":hidden",
        rules: rules,
        invalidHandler: function (event, validator) { //display error alert on form submit
            success.hide();
            error.show();
//            App.scrollTo(error, -200);
            if (typeof showToaster !== 'undefined' && showToaster) {
                Toastr.init('warning', 'Some fields are missing!.', '');
            }
        },
        showErrors: function (errorMap, errorList) {
            if (typeof errorList[0] != "undefined") {
                var position = $(errorList[0].element).offset().top - 70;
                $('html, body').animate({
                    scrollTop: position
                }, 300);
            }
            this.defaultShowErrors(); // keep error messages next to each input element   
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                    .closest('.c-input, .form-control').addClass('has-error'); // set error class to the control group
            
            $(element).parent().parent().find('.select2').addClass('has-error');
            
        },
        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                    .closest('.c-input, .form-control').removeClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label
                    .closest('.c-input, .form-control').removeClass('has-error'); // set success class to the control group
        },
        errorPlacement: function (error, element) {
            return true;
        },

//        messages: {
//            firstname: "Enter your firstname",
//            lastname: "Enter your lastname",
//            username: {
//                required: "Enter a username",
//                minlength: jQuery.format("Enter at least {0} characters"),
//                remote: jQuery.format("{0} is already in use")
//            }
//        },
        submitHandler: function (form) {
            if (typeof submitCallback !== 'undefined' && typeof submitCallback == 'function') {
                submitCallback(form);
            } else {
                handleAjaxFormSubmit(form);
            }
            return false;
        }
    });

    $('.select2me', form).change(function () {
        form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
    });
    $('.date-picker .form-control').change(function () {
        form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
    })
}

function handleFormValidateWithMsg(form, rules, messages, submitCallback, showToaster) {

    var error = $('.alert-danger', form);
    var success = $('.alert-success', form);
    form.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: ":hidden",
        rules: rules,
        invalidHandler: function (event, validator) { //display error alert on form submit
            success.hide();
            error.show();

//            App.scrollTo(error, -200);
            if (typeof showToaster !== 'undefined' && showToaster) {
                Toastr.init('warning', 'Some fields are missing!.', '');
            }
//            Toastr.init('warning', 'Some fields are missing!.', '');
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
        },
        messages: messages,
        submitHandler: function (form) {
            if (typeof submitCallback !== 'undefined' && typeof submitCallback == 'function') {
                submitCallback(form);
            } else {
                handleAjaxFormSubmit(form);
            }
            return false;
        }
    });

    $('.select2me', form).change(function () {
        form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
    });
    $('.date-picker .form-control').change(function () {
        form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
    })
}

function gritter(title, text, sticky, time) {
    $.gritter.add({
        // (string | mandatory) the heading of the notification
        title: title,
        // (string | mandatory) the text inside the notification
        text: text,
        // (string | optional) the image to display on the left
        //                    image1: './assets/img/avatar1.jpg',
        // (bool | optional) if you want it to fade out on its own or just sit there
        sticky: sticky,
        // (int | optional) the time you want it to be alive for before fading out
        time: time,
        // (string | optional) the class name you want to apply to that specific message
        class_name: 'my-sticky-class'
    });

}

var Toastr = function () {

    return {
        //main function to initiate the module
        init: function (type, title, message) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-center",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"

            }
            toastr[type](message, title);
        }

    };

}();

function handleDelete() {

    $('body').on('click', '#btndelete', function () {
        var data = '';
        var thumb = $(this).attr('data-thumb');
        if (thumb) {
            data = {'id': $(this).attr('data-id'), 'thumb': thumb};
        } else {
            data = {'id': $(this).attr('data-id'), '_token': $("input[name=_token]").val()};
        }
        ajaxcall($(this).attr('data-url'), data, function (output) {
            $('#myModal_autocomplete').modal('hide');
            handleAjaxResponse(output);
        });
    });
}

function handleDeleteData() {

    var delete_records_value = '';
    var delete_model_name = '';
    $('body').on('click', '.delete_confirmation_btn', function () {

        var checked_value = $('input[type="checkbox"].delete_checkbox_id:checked');
        if (checked_value.length > 0) {
            delete_model_name = $(this).attr('data-model-open');
            $(delete_model_name).modal('show');
            for (var i = 0; i < checked_value.length; i++) {
                delete_records_value += $(checked_value[i]).attr('data-id');
                if (i != checked_value.length - 1) {
                    delete_records_value += ",";
                }
            }
        } else {
            Toastr.init('warning', 'Please select atleast one record', '');
        }
    });
    $('body').on('click', '#multiple_delete_btn', function () {
        var data = {'id': delete_records_value};
        ajaxcall($(this).attr('data-url'), data, function (output) {
            $(delete_model_name).modal('hide');
            var temp_array = delete_records_value.split(',');
            for (var i = 0; i < temp_array.length; i++) {
                $('input[type="checkbox"].delete_checkbox_id[data-id="' + temp_array[i] + '"]').parents('tr').hide();
            }
            handleAjaxResponse(output);
        });
    });
}

function handleTimePickers() {

    if (jQuery().timepicker) {
        $('.timepicker-default').timepicker({
            autoclose: true,
            //showSeconds: true,
            minuteStep: 1
        });

        $('.timepicker-no-seconds').timepicker({
            autoclose: true,
            minuteStep: 5
        });

        $('.timepicker-24').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: true,
            showMeridian: false
        });

        // handle input group button click
        $('.timepicker').parent('.input-group').on('click', '.input-group-btn', function (e) {
            e.preventDefault();
            $(this).parent('.input-group').find('.timepicker').timepicker('showWidget');
        });
    }
}

var check_checkbox = function () {

    return {
        init: function () {
            var checked_length = $(".checkboxes:checked").length;
            var id_array = new Array();
            $('.checkboxes:checked').each(function () {
                id_array.push($(this).attr('value'));
            });
            if (checked_length != 0)
            {
                return id_array;
            } else
            {
                Toastr.init('warning', 'Opps..', 'Please Select Atleast One Checkbox');
                return false;
            }
        }
    }
}();

// Handle Sidebar toggling
$('.page-sidebar-menu li').on('click', function () {
    $('.page-sidebar-menu li:not(.open)').each(function (i) {
        $(this).find('a .arrow').removeClass('open');
        $(this).find('ul.sub-menu').hide();
    });
});
// Handle Sidebar toggling

if (getQueryString('status') != null && getQueryString('message') != null) {
    Toastr.init(getQueryString('status'), '', decodeURIComponent(getQueryString('message')));
}
if (getQueryString('redirect') != null) {
    setTimeout(function () {
        window.location.href = getQueryString('redirect');
    }, 500);
}

// Handle Checkall Table
$('body').on('click', '.checkall', function () {
    if ($(this).prop('checked')) {
        $(this).closest('.groupcheckboxes').find('.checkallone').prop('checked', true);
        $.uniform.update(".checkallone");
    } else {
        $(this).closest('.groupcheckboxes').find('.checkallone').prop('checked', false);
        $.uniform.update(".checkallone");
    }
});
// Handle Checkall Table

function fileExists(url) {
    if (url) {
        var req = new XMLHttpRequest();
        req.open('GET', url, false);
        req.send();
        return req.status == 200;
    } else {
        return false;
    }
}

//jQuery.validator.addMethod("account_no", function (value, element) {
//    return this.optional(element) || /[0-9]{2}-[0-9]{4}-[0-9]{7}-[0-9]{2}/.test(value);
//}, "Enter valid account number");


function ordinal(number) {
    number = Number(number)
    if (!number || (Math.round(number) !== number)) {
        return number
    }
    var signal = (number < 20) ? number : Number(('' + number).slice(-1))
    switch (signal) {
        case 1:
            return number + 'st'
        case 2:
            return number + 'nd'
        case 3:
            return number + 'rd'
        default:
            return number + 'th'
    }
}

$("body").on('click', '.restoreWaiting', function () {
    var bookId = $(this).attr('data-id');

    var permit = $(this).attr("data-permit");
    var reason = $("#restoreWaitingPopupReason").val();
    if (permit == "N") {
        $("#restoreWaitingPopup").modal("hide");
        return false;
    }

    ajaxcall(tutorurl + 'booking/restoreWaiting', {id: bookId, is_accept: permit, reason: reason}, function (output) {
        var res = JSON.parse(output);
        $("#restoreWaitingPopupReason").val("");
        $(".booking_restored_success").attr("data-id", bookId);

        if (res.status == "deleteDay") {
            $("#restoreWaitingPopupReason").val("day");
            $("#restoreWaitingPopup").modal("show");
        } else if (res.status == "priceChange") {
            $("#restoreWaitingPopup").modal("show");
        } else {
            handleAjaxResponse(output);
        }
    });
});


$('body').on('click', '.booking_restored', function () {
    var orderId = $(this).attr("data-id");
    var dataurlid = $(this).attr("data-url-id");

    var permit = $(this).attr("data-permit");
    var reason = $("#popupreason").val();
    if (permit == "N") {
        $("#booking_restore_popup").modal("hide");
        return false;
    }

    $("#booking_restore_popup").modal("hide");
    ajaxcall(tutorurl + 'booking/restoreBooking', {orderId: orderId, is_accept: permit, reason: reason}, function (output) {
        var res = JSON.parse(output);
        $("#popupreason").val("");
        if (res.status == "deleteDay") {
            $("#booking_restore_popup").modal("show");
            $("#popupreason").val("day");
            $(".restoreConfMsg").text("The current class had some days or fees modified, you need to make sure the fee is correct on the restored booking. You can adjust the total invoice for this booking in the order details page or make a new booking instead for this student.");

            $(".booking_restored_success").attr("data-id", orderId);
            $(".booking_restored_success").attr("data-url-id", dataurlid);

        } else if (res.status == "priceChange") {
            $("#booking_restore_popup").modal("show");
            $(".restoreConfMsg").text("The current class had some days or fees modified, you need to make sure the fee is correct on the restored booking. You can adjust the total invoice for this booking in the order details page or make a new booking instead for this student.");

            $(".booking_restored_success").attr("data-id", orderId);
            $(".booking_restored_success").attr("data-url-id", dataurlid);

        } else {
            handleAjaxResponse(output);
        }
    });
});

$('body').on('click', '.camp_restore', function () {
    var orderId = $(this).attr("data-id");
    var dataurlid = $(this).attr("data-url-id");

    ajaxcall(tutorurl + 'holiday_programme/restoreBooking', {orderId: orderId}, function (output) {
        handleAjaxResponse(output);
    });
});

$('body').on('click', '.checkContactcookie', function () {
    Cookies.set('currentLoginType', $(this).attr('data-userType'));
});

var isValidTutor = true;
var isGettingSide = false;
var notifiSecs = 1;

$('body').on('click', '.notifOpen', function () {
    if (!isGettingSide) {
        isGettingSide = true;
        ajaxcall(baseurl + 'Notification/getSideNotification', {a: 'a'}, function (output) {
            isGettingSide = false;
            output = JSON.parse(output);
            $(".sideNotifDiv").html(output.htm);
            $('body').removeClass('page-quick-sidebar-open');
            $('body').addClass('page-quick-sidebar-open');
            getNotificationCount(true);
        });
    }
});

$('body').on('click', '.notifClose', function () {
    isGettingSide = false;
    $(".sideNotifDiv").html('');
    $('body').removeClass('page-quick-sidebar-open');
});


$('#show_notification').on('hidden.bs.modal', function () {
    $(".sideNotifDiv").html('');
    $(".allNotifDiv").html('');
    $('body').removeClass('page-quick-sidebar-open');
});

function dateFormate(field) {
    $(field).datepicker({
        autoclose: true,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        todayHighlight: true,
        format: 'dd-mm-yyyy'
    });
}
function checkNonWorkingDate(field) {
    var send=true;
   $(field).datepicker({
        format: 'dd-mm-yyyy',
        calendarWeeks: true,
        autoclose: true,
        todayHighlight:true
    }).on("changeDate", function(e) {
        if(send){
        var  date = $(this).val();
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
            },
            url: baseurl + "company/task-ajaxAction",
            data: {'action': 'checkDate', 'date': date},
                success: function(output) {
                    handleAjaxResponse(output);
                    var  output = JSON.parse(output);
                    if (typeof  output.counts != 'undefined' && output.counts != null && output.counts > 0) {
                        $(field).val('');
                        $(field).focus();
                    }
                }
            });
            send=false;
        }
         setTimeout(function(){send=true;},200);
     });
}

/* START FOR LANGUAGE SET USING COOKIE */

//console.log(getCookie('language'));
$("body").on("change", "#languageSelection", function () {
    var lang = $(this).val();
    if (lang != '') {
        setCookie('language', lang, 365);
        window.location.reload();
    } else {
        lang = 'en';
        setCookie('language', lang, 365);
        window.location.reload();
    }
});
//    $("body").on("click", ".language",function(){
//        var lang = ($(this).attr('data-lang') !== '') ? $(this).attr('data-lang') : 'en';
//        if(lang){
//            setCookie('language', lang, 365);
//            window.location.reload();
//        }
//    });

$("body").on("change", ".language", function () {
    var lang = ($(this).val() !== '') ? $(this).val() : 'en';
    if (lang) {
        setCookie('language', lang, 365);
        window.location.reload();
    }
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/* END FOR LANGUAGE SET USING COOKIE */



/* Start manage datatable with Ajax & hide/show column dynamic */

function getDataTable(arr) {

    var dataTable = $(arr.tableID).DataTable({
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "bAutoWidth": false,
        "bLengthChange": false,
        "bInfo": true,
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search..."
        },
        "order": [[(arr.defaultSortColumn) ? arr.defaultSortColumn : '0', (arr.defaultSortOrder) ? arr.defaultSortOrder : 'desc']],
        "columnDefs": [
            {
                "targets": arr.hideColumnList,
                "visible": false
            },
            {
                "targets": arr.noSortingApply,
                "orderable": false
            },
            {
                "targets": arr.noSearchApply,
                "searchable": false
            },
            (arr.setColumnWidth) ? arr.setColumnWidth : ''
        ],
        "ajax": {
            url: arr.ajaxURL,
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data: {'action': arr.ajaxAction, 'data': arr.postData},
            error: function () {  // error handling
                $(".row-list-error").html("");
                $(arr.tableID).append('<tbody class="row-list-error"><tr><td colspan="4" style="text-align: center;"><p style="color:red;">Sorry, No Record Found</p></td></tr></tbody>');
                $(arr.tableID + "processing").css("display", "none");
            }
        }
    });

//    onLoadDefaultColumnSet(dataTable);
//    hideShowDatatableColumn(dataTable);
}

function onLoadDefaultColumnSet(dataTable) {
    $('.custom-column').each(function () {
        var column = dataTable.column($(this).attr('data-column'));
        var status = $(this).attr('data-default-status');

        if ($(this).is(":checked")) {
            column.visible(!column.visible());
        } else {
            column.visible(column.visible());
        }
        if (status == 'true') {
            column.visible(!column.visible());
        }
    });
}

function hideShowDatatableColumn(dataTable) {
    $('body').on('click', '.custom-column', function () {
        // Get the column API object
        var column = dataTable.column($(this).attr('data-column'));
        // Toggle the visibility
        column.visible(!column.visible());
    });
}

setInterval(get_order, 5000);
function get_order() {

    var loginusertype = $('#loginusertype').val();
    if (loginusertype == 'ADMIN') {
        var currentCount = $('#totalOrderNotification').val();
        // console.log(currentCount)
        var token = $('.orderCountToken').val();
        var data = {currentCount: currentCount, _token: token};
        var url = baseurl + 'get-order-count';
        ajaxcall(url, data, function (output) {
            var data = JSON.parse(output);
//             console.log(data.totalOrder);

//             console.log(currentCount);
            if (data.totalOrder != parseInt(currentCount)) {
//                 console.log('in');
                handleAjaxResponse(output);
                $('.totalOrderCount').text(data.orderCount);
            }
        });
    }
}

function checkDateRange(classOrID, startDateID, endDateID, msg) {
    $(classOrID).change(function() {

        var today = new Date();
        if (endDateID === 'today') {
            var startDate = reverseDate(startDateID);
            if ((Date.parse(startDate) >= Date.parse(today))) {
                if (msg) {
                    alert(msg);
                } else {
                    alert("Date Must be Less from Today");
                }
                $(startDate).val('');
            }
        } else if (startDateID === 'today') {
            var endDate = reverseDate(endDateID);
            if ((Date.parse(endDate) <= Date.parse(today))) {
                if (msg) {
                    alert(msg);
                } else {
                    alert("Date Must be Greater from Today");
                }
                $(endDateID).val('');
            }
        } else {
            var startDate = reverseDate(startDateID);
            var endDate = reverseDate(endDateID);
            if (startDate != '' && endDate != '') {
                if ((Date.parse(startDate) >= Date.parse(endDate))) {
                    if (msg) {
                        alert(msg);
                    } else {
                        alert("Date Finish Must be after Date Start");
                    }
                    $(endDateID).val('');
                }
            }
        }
    });
}

function reverseDate(field) {
    var OldFormateOfDate = $(field).val();
    var splitDate = OldFormateOfDate.split(/\D/);
    var newDate = splitDate.reverse().join('-');
    return newDate;
}
function reverseDateV2(FormateOfDate) {
    if (FormateOfDate == '' || FormateOfDate == null || typeof FormateOfDate === 'undefined') {
        var newDate = 'NA';
    } else {
        var splitDate = FormateOfDate.split(/\D/);
        var newDate = splitDate.reverse().join('-');
    }
    return newDate;
}

$(function() 
{
     $( "#payment_date" ).datepicker({ format: 'dd/MM',autoclose: true });
     $( "#date" ).datepicker({ format: 'dd-mm-yyyy',autoclose: true });
     $( "#from_date" ).datepicker({ format: 'dd-mm-yyyy',autoclose: true });
     $( "#to_date" ).datepicker({ format: 'dd-mm-yyyy',autoclose: true });
    // $('#date').datepicker('setDate', new Date());
    // $( "#startdate" ).datepicker({ format: 'dd.MM.yyyy',autoclose: true });
    // $('#startdate').datepicker('setDate', new Date());
    // $( "#enddate" ).datepicker({ format: 'dd.MM.yyyy',autoclose: true });
    // $('#enddate').datepicker('setDate', new Date());
    //  $( "#date1" ).datepicker({ format: 'dd.MM.yyyy',autoclose: true });
    // $( "#startdate1" ).datepicker({ format: 'dd.MM.yyyy',autoclose: true });
    // $( "#enddate1" ).datepicker({ format: 'dd.MM.yyyy',autoclose: true });
    
});
/* End manage datatable with Ajax & hide/show column dynamic */

$('body').on('click', 'li .notification-count', function () {
    var user_id = $(this).attr('data-id');
    var notification_id = $(this).attr('notification-id');
    console.log(notification_id);
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('input[name="_tokenNotification"]').val(),
        },
        url: baseurl + "zero-notification-count",
        data: {'user_id': user_id,'notification_id':notification_id},
        success: function (data) {
            $('#countNotification').html(data);
        }
    });
});
