/**
 * Validation object for the registration page
 * @package FusionCMS
 * @author Jesper Lindström
 */

var Validate = {
    submit: function() {
        // Reset previous states
        $('input').removeClass('is-invalid is-valid');
        $('.invalid-feedback').remove();

        // Submit form
        $.ajax({
            url: Config.URL + "register",
            type: "POST",
            dataType: "json",
            data: $('#register_form').serialize(),
            success: function(response) {
                Swal.close(); // Close any loading indicators
                if (response.status === 'success') {
                    if (response.email_activation) {
                        Swal.fire({
                            icon: 'success',
                            text: lang("the_account", "register") + ' ' + $('#register_username').val() + ' ' + lang("has_been_created", "register")
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            text: lang("the_account", "register") + ' ' + $('#register_username').val() + ' ' + lang("has_been_created_redirecting", "register") + ' ' + lang("user_panel", "register"),
                            timer: 2500
                        }).then(() => {
                            window.location = Config.URL + "ucp"; // Redirect the user
                        });
                    }
                } else if (response.errors) {
                    // Display field-specific errors
                    $.each(response.errors, function(field, error) {
                        if (error) {
                            $('#' + field).addClass('is-invalid');
                            // Ensure the error div is correctly appended
                            if (! $('#' + field).next('.invalid-feedback').length) {
                                $('#' + field).after(error);
                            }
                        }
                    });
                }
            },
            error: function(xhr) {
                Swal.close(); // Close loading indicators on error
                Swal.fire({
                    icon: 'error',
                    text: xhr.responseJSON?.message || 'An error occurred during registration.'
                });
            }
        });

        return false; // Prevent default form submission
    },

    checkUsername: function() {
        var field = $('#register_username');
        var value = field.val();

        // Reset previous states
        field.removeClass('is-invalid is-valid');
        field.next('.invalid-feedback').remove();

        if (value.length < 4 || value.length > 24) {
            this.invalid('#register_username', lang("username_limit_length", "register"));
        } else if (!/^[A-Za-z0-9]*$/.test(value)) {
            this.invalid('#register_username', lang("username_limit", "register"));
        } else {
            // Check availability
            $.get(Config.URL + "register/check/username/" + value, function(data) {
                if (data == "1") {
                    Validate.valid('#register_username');
                } else {
                    Validate.invalid('#register_username', lang("username_not_available", "register"));
                }
            });
        }
    },

    checkEmail: function() {
        var field = $('#register_email');
        var value = field.val();

        // Reset previous states
        field.removeClass('is-invalid is-valid');
        field.next('.invalid-feedback').remove();

        if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$/.test(value)) {
            this.invalid('#register_email', lang("email_invalid", "register"));
        } else {
            // Check availability
            $.post(Config.URL + "register/check/email", {email: value, csrf_token_name: Config.CSRF}, function(data) {
                if (data == "1") {
                    Validate.valid('#register_email');
                } else {
                    Validate.invalid('#register_email', lang("email_not_available", "register"));
                }
            });
        }
    },

    checkPassword: function() {
        var field = $('#register_password');
        var value = field.val();
        // Reset previous states
        field.removeClass('is-invalid is-valid');
        field.next('.invalid-feedback').remove();

        if (value.length < 6 || value.length > 16) {
            this.invalid('#register_password', lang("password_limit_length", "register"));
        } else {
            this.valid('#register_password');
        }

        // Also validate the confirmation field when password changes
        if ($('#register_password_confirm').val()) {
            this.checkPasswordConfirm();
        }
    },

    checkPasswordConfirm: function() {
        var field = $('#register_password_confirm');
        // Reset previous states
        field.removeClass('is-invalid is-valid');
        field.next('.invalid-feedback').remove();

        if (field.val() !== $('#register_password').val()) {
            this.invalid('#register_password_confirm', lang("pw_dont_match", "register"));
        } else {
            this.valid('#register_password_confirm');
        }
    },

    valid: function(field) {
        var fieldElement = $(field); // Use the full field name
        fieldElement.removeClass('is-invalid').addClass('is-valid');
        fieldElement.next('.invalid-feedback').remove();
    },

    invalid: function(field, error) {
        var fieldElement = $(field); // Use the full field name
        fieldElement.addClass('is-invalid');
        fieldElement.next('.invalid-feedback').remove(); // Remove existing feedback
        if (error.length > 0) {
            fieldElement.after('<div class="invalid-feedback">' + error + '</div>');
        }
    },

    showPassword: function(ele) {
        if($(ele).data("show") == true) {
            $(ele).html('<i class="fas fa-eye-slash"></i>');
            $(ele).data("show", false);

            $("input#"+ $(ele).data("input-id")).attr("type", "password");
        } else if($(ele).data("show") == false) {
            $(ele).html('<i class="fas fa-eye"></i>');
            $(ele).data("show", true);

            $("input#"+ $(ele).data("input-id")).attr("type", "text");
        }
        
    },

    refreshCaptcha: function(ele) {
        $(".captcha-input").val('');
        $(".captcha-input").focus();
        var captchaID = $(ele).data("captcha-id");
        var imgField = $("img#"+ captchaID);
        imgField.attr("src", imgField.attr("src") +"&d="+ new Date().getTime());
    }
};
