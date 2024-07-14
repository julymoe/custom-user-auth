jQuery(document).ready(function($) {

    // Handle registration form submission
    $('#cua-registration-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();
        
        $.ajax({
            type: 'POST',
            url: cua_ajax.ajax_url,
            data: formData + '&action=cua_register',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#cua-message').html('<div class="success">' + response.data + '</div>');
                    $('#cua-registration-form').hide();
                    $('#cua-otp-section').show();
                } else {
                    $('#cua-message').html('<div class="error">' + response.data + '</div>');
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    // Handle OTP verification form submission
    $('#cua-otp-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();
        
        $.ajax({
            type: 'POST',
            url: cua_ajax.ajax_url,
            data: formData + '&action=cua_verify_otp',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#cua-message').html('<div class="success">' + response.data + '</div>');
                    $('#cua-otp-section').hide();
                } else {
                    $('#cua-message').html('<div class="error">' + response.data + '</div>');
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    // Handle login form submission
    $('#cua-login-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();
        
        $.ajax({
            type: 'POST',
            url: cua_ajax.ajax_url,
            data: formData + '&action=cua_login',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#cua-login-message').html('<div class="success">' + response.data.message + '</div>').show();
                    setTimeout(function() {
                        window.location.href = response.data.redirect_url; // Redirect to dashboard after 2 seconds
                    }, 2000);
                } else {
                    $('#cua-login-message').html('<div class="error">' + response.data + '</div>').show();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

});