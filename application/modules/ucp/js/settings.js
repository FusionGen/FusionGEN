/**
 * @package FusionCMS
 * @version 6.X
 * @author Jesper Lindström
 * @author Xavier Geerinck
 * @link http://fusion-hub.com
 */

var Settings = {
    submit: function() {
        // Reset previous states
        $('input').removeClass('is-invalid is-valid');
        $('.invalid-feedback').remove();

        // Submit form
        $.ajax({
            url: Config.URL + "ucp/settings/submit",
            type: "POST",
            dataType: "json",
            data: {
                old_password: $('#old_password').val(),
                new_password: $('#new_password').val(),
                new_password_confirm: $('#new_password_confirm').val(),
                csrf_token_name: Config.CSRF
            },
            success: function(response) {
                Swal.close();
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        text: lang("changes_saved", "ucp"),
                        timer: 1500
                    });
                    $('input[type="password"]').val('').removeClass('is-valid');
                } else if (response.errors) {
                    // Display field-specific errors
                    $.each(response.errors, function(field, error) {
                        if (error) {
                            $('#' + field).addClass('is-invalid');
                            $('#' + field).after(error);
                        }
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    text: xhr.responseJSON?.message || 'An error occurred'
                });
            }
        });

        return false;
    },

    // Info form handling
    submitInfo: function() {
        // Reset previous states
        $('input').removeClass('is-invalid is-valid');
        $('.invalid-feedback').remove();

        // SubmitInfo form
        $.ajax({
            url: Config.URL + "ucp/settings/submitInfo",
            type: "POST",
            dataType: "json",
            data: {
                nickname: $('#nickname_field').val(),
                location: $('#location_field').val(),
                language: $('#language_field').val(),
                csrf_token_name: Config.CSRF
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        text: lang("changes_saved", "ucp"),
                        timer: 1500
                    });
                } else if (response.errors) {
                    // Display field-specific errors
                    $.each(response.errors, function(field, error) {
                        if (error) {
                            var fieldElement = $('#' + field + '_field');
                            fieldElement.addClass('is-invalid');
                            fieldElement.after(error);
                        }
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    text: xhr.responseJSON?.message || 'An error occurred'
                });
            }
        });

        return false;
    },

    // Real-time client-side form validation
    validateNickname: function() {
        var field = $('#nickname_field');
        var value = field.val();

        if (value.length < 4 || value.length > 24 || !/^[A-Za-z0-9]*$/.test(value)) {
            field.addClass('is-invalid');
            field.next('.invalid-feedback').remove();
            field.after('<div class="invalid-feedback">' + lang("nickname_error", "ucp") + '</div>');
        } else {
            field.removeClass('is-invalid').addClass('is-valid');
            field.next('.invalid-feedback').remove();
        }
    },

    validateLocation: function() {
        var field = $('#location_field');
        var value = field.val();

        if (value.length > 32 || (value.length > 0 && !/^[A-Za-z\s]*$/.test(value))) {
            field.addClass('is-invalid');
            field.next('.invalid-feedback').remove();
            field.after('<div class="invalid-feedback">' + lang("location_error", "ucp") + '</div>');
        } else {
            field.removeClass('is-invalid').addClass('is-valid');
            field.next('.invalid-feedback').remove();
        }
    },

    validateNewPassword: function() {
        var field = $('#new_password');
        var value = field.val();
        if (value.length < 6 || value.length > 16) {
            field.addClass('is-invalid');
            field.next('.invalid-feedback').remove();
            field.after('<div class="invalid-feedback">' + lang("password_limit_length", "ucp") + '</div>');
        } else {
            field.removeClass('is-invalid').addClass('is-valid');
            field.next('.invalid-feedback').remove();
        }
        
        // Also validate the confirmation field when password changes
        if ($('#new_password_confirm').val()) {
            this.validatePasswordConfirm();
        }
    },

    validatePasswordConfirm: function() {
        var field = $('#new_password_confirm');
        if (field.val() !== $('#new_password').val()) {
            field.addClass('is-invalid');
            field.next('.invalid-feedback').remove();
            field.after('<div class="invalid-feedback">' + lang("pw_dont_match", "ucp") + '</div>');
        } else {
            field.removeClass('is-invalid').addClass('is-valid');
            field.next('.invalid-feedback').remove();
        }
    }
};
