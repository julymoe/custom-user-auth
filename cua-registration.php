<?php

// Create a registration form
function cua_registration_form()
{
    ob_start();
?>
    <form id="cua-registration-form" action="" method="POST" class="form">
        <h2 class="form-title">Register</h2>
        <div class="input-box">
            <!-- <label for="email">Email:</label> -->
            <input type="email" id="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-box">
            <!-- <label for="name">Name:</label> -->
            <input type="text" id="name" name="name" placeholder="Name" required>
        </div>
        
        <div>            
            <div class="column">            
                <div class="select-box">
                    <?php echo cua_get_country_codes(); ?>
                </div>
                <div class="input-box">
                    <input type="tel" id="phone" name="phone" placeholder="Phone" required>
                </div>
            </div>
        </div>        

        <div class="input-box">
            <textarea id="address" name="address" placeholder="Address" required></textarea>
        </div>

        <button type="submit" class="cua-button">Register</button>
    </form>

    <div id="cua-otp-section" style="display:none;">        
        <form id="cua-otp-form" action="" method="POST" class="form">
            <p class="smallFont">An OTP has been sent to your email. Please enter it below to verify your email address. OTP is valid for 10 minutes.</p>
            <div class="input-box">                
                <input type="text" id="otp" name="otp" placeholder="OTP" required>
            </div>
            <button type="submit" class="cua-button">Verify OTP</button>
        </form>        
    </div>
    <div id="cua-message"></div>
    
<?php
    return ob_get_clean();
}
add_shortcode('cua_registration', 'cua_registration_form');

// Handle the registration form submission
function cua_handle_registration()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
        $email = sanitize_email($_POST['email']);
        $name = sanitize_text_field($_POST['name']);
        $phone = sanitize_text_field($_POST['country-code'] . $_POST['phone']); // Combine country code and phone number
        $address = sanitize_text_field($_POST['address']);

        // Check if email or phone already exists
        if (email_exists($email) || username_exists($email)) {
            wp_send_json_error('Email already exists.');
        }

        // Check if phone number already exists
        $existing_user = get_users(array(
            'meta_key' => 'cua_phone',
            'meta_value' => $phone,
            'number' => 1,
            'count_total' => false,
            'fields' => 'ID'
        ));

        if (!empty($existing_user)) {
            wp_send_json_error('Phone number already registered.');
        }

        // Save user data
        $user_id = wp_create_user($email, wp_generate_password(), $email);
        if (!is_wp_error($user_id)) {
            update_user_meta($user_id, 'cua_name', $name);
            update_user_meta($user_id, 'cua_phone', $phone);
            update_user_meta($user_id, 'cua_address', $address);
            update_user_meta($user_id, 'cua_verified', false);

            // Generate and send OTP
            $otp = rand(100000, 999999);
            update_user_meta($user_id, 'cua_otp', $otp);
            update_user_meta($user_id, 'cua_otp_timestamp', time());
            wp_mail($email, 'Your OTP Code', 'Your OTP code is ' . $otp);

            // Store user ID in session for OTP verification
            if (!session_id()) {
                session_start();
            }
            $_SESSION['cua_user_id'] = $user_id;

            wp_send_json_success('OTP sent to your email.');
        } else {
            wp_send_json_error('Failed to create user.');
        }
    }
}
add_action('wp_ajax_nopriv_cua_register', 'cua_handle_registration');
add_action('wp_ajax_cua_register', 'cua_handle_registration');

// Handle the OTP form submission
function cua_handle_otp_verification()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp'])) {
        $otp = sanitize_text_field($_POST['otp']);

        if (!session_id()) {
            session_start();
        }

        if (isset($_SESSION['cua_user_id'])) {
            $user_id = $_SESSION['cua_user_id'];
            $saved_otp = get_user_meta($user_id, 'cua_otp', true);
            $otp_timestamp = get_user_meta($user_id, 'cua_otp_timestamp', true);

            // Verify OTP and expiration
            if ($otp == $saved_otp && (time() - $otp_timestamp) < 600) {
                update_user_meta($user_id, 'cua_verified', true);
                delete_user_meta($user_id, 'cua_otp');
                delete_user_meta($user_id, 'cua_otp_timestamp');
                unset($_SESSION['cua_user_id']);
                wp_send_json_success('Email verified successfully.');
            } else {
                wp_send_json_error('Invalid OTP or OTP has expired.');
            }
        } else {
            wp_send_json_error('User session not found.');
        }
    }
}
add_action('wp_ajax_nopriv_cua_verify_otp', 'cua_handle_otp_verification');
add_action('wp_ajax_cua_verify_otp', 'cua_handle_otp_verification');
?>