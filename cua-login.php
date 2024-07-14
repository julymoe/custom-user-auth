<?php

// Create a login form
function cua_login_form()
{
    ob_start();
?>
    <form id="cua-login-form" action="" method="POST" class="form">
        <h2 class="form-title">Login</h2>
        <p class="smallFont">Login with your registered phone number</p>
        <div class="column">
            <div class="select-box">
                <?php echo cua_get_country_codes(); ?>
            </div>
            <div class="input-box">
                <input type="tel" id="phone" name="phone" placeholder="Phone" required>
            </div>
        </div>
        <button type="submit" class="cua-button">Login</button>
    </form>
    <div id="cua-login-message"></div>
<?php
    return ob_get_clean();
}
add_shortcode('cua_login', 'cua_login_form');

// Handle the login form submission
function cua_handle_login()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['phone'])) {
        $phone = sanitize_text_field($_POST['country-code'] . $_POST['phone']); // Combine country code and phone number

        // Find user by phone number
        $user_query = new WP_User_Query(array(
            'meta_key' => 'cua_phone',
            'meta_value' => $phone,
            'meta_compare' => '='
        ));

        if (!empty($user_query->get_results())) {
            $user = $user_query->get_results()[0];

            // Log user in
            wp_set_current_user($user->ID, $user->user_login);
            wp_set_auth_cookie($user->ID);
            do_action('wp_login', $user->user_login);

            // Send JSON response with redirect URL
            wp_send_json_success(array('message' => 'Login successful. Redirecting...', 'redirect_url' => admin_url('index.php')));
        } else {
            wp_send_json_error('Phone number not found.');
        }
    }
}
add_action('wp_ajax_nopriv_cua_login', 'cua_handle_login');
add_action('wp_ajax_cua_login', 'cua_handle_login');
?>