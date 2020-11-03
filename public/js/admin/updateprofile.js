var Updateprofile = function () {

    var handleEditUser = function () {
        var form = $('#updateProfile');
        var rules = {
            firstname: {required: true},
            lastname: {required: true},
        };
        handleFormValidate(form, rules, function (form) {
            handleAjaxFormSubmit(form,true);
        });
    };

    var handleChangePassword = function () {

        var form = $('#changePassword');
        var rules = {
            new_password: {required: true},
            confirm_new_password: {required: true,}
        };

        $('.new_password').on('change', function() {
            var pwd = this.value;
            checkPwd(pwd);
        });

        function checkPwd(str) {
            if (str.length < 6) {
                alert("Password is too short.");
                $('#changePwd').prop('disabled', true);
            } else if (str.length > 15) {
                alert("Password is too long.");
                $('#changePwd').prop('disabled', true);
            } else if (str.search(/\d/) == -1) {
                alert("Please add minimum one number in password.");
                $('#changePwd').prop('disabled', true);
            } else if (str.search(/[a-zA-Z]/) == -1) {
                alert("Please add one letter in password.");
                $('#changePwd').prop('disabled', true);
            } else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
                alert("Password has bad character.");
                $('#changePwd').prop('disabled', true);
            }
            $('#changePwd').prop('disabled', false);
            return true;
        }

        $('#changePwd').click(function() {
            if($('.new_password').val() !== $('.confirm_new_password').val()) {
                alert('Confirm password must be same as new password');
                return false;
            }
            return true;
        });

        handleFormValidate(form, rules, function (form) {
            handleAjaxFormSubmit(form,true);
        });
    };

    return{
        edit_init: function () {
            handleEditUser();
        },

        change_password_init: function () {
            handleChangePassword();
        }
    };
}();