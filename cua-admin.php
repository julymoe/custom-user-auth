<?php

// Add plugin settings to the admin menu
function cua_add_admin_menu()
{
    add_menu_page('Custom User Auth Settings', 'User Auth Settings', 'manage_options', 'cua-settings', 'cua_settings_page');
    add_submenu_page('cua-settings', 'Welcome', 'Welcome', 'manage_options', 'cua-welcome', 'cua_welcome_page');
}
add_action('admin_menu', 'cua_add_admin_menu');

// Display the settings page
function cua_settings_page()
{
?>
    <div class="wrap">
        <h1>Custom User Auth Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('cua_settings_group');
            do_settings_sections('cua-settings');
            submit_button();
            ?>
        </form>
        <h2>Shortcodes</h2>
        <p>Use the following shortcodes to display the forms:</p>
        <ul>
            <li><code>[cua_registration]</code> - Displays the registration form.</li>
            <li><code>[cua_login]</code> - Displays the login form.</li>
        </ul>
    </div>
<?php
}

// Register plugin settings and fields
function cua_register_settings()
{
    register_setting('cua_settings_group', 'cua_form_button_color');
    add_settings_section('cua_settings_section', 'Settings', null, 'cua-settings');
    add_settings_field('cua_form_button_color', 'Form/Input Button Color', 'cua_form_button_color_callback', 'cua-settings', 'cua_settings_section');
}
add_action('admin_init', 'cua_register_settings');

// Callback function for the form/input button color setting
function cua_form_button_color_callback()
{
    $setting = get_option('cua_form_button_color', '#4CAF50'); // Default color
?>
    <input type="color" id="cua_form_button_color" name="cua_form_button_color" value="<?php echo esc_attr($setting); ?>">
    <button type="button" id="cua_reset_button" class="button">Reset to Default Color</button>
    <p class="description">Select the color for form and input buttons.</p>
    <script type="text/javascript">
        document.getElementById('cua_reset_button').addEventListener('click', function() {
            document.getElementById('cua_form_button_color').value = '#4CAF50';
        });
    </script>
<?php
}

// Display the welcome page
function cua_welcome_page()
{
?>
    <div class="wrap">
        <h1>Welcome to Custom User Authentication Plugin</h1>
        <p>Thank you for using the Custom User Authentication plugin! This plugin allows you to create custom registration and login forms with OTP verification.</p>
        <h2>Shortcodes</h2>
        <p>Use the following shortcodes to display the forms:</p>
        <ul>
            <li><code>[cua_registration]</code> - Displays the registration form.</li>
            <li><code>[cua_login]</code> - Displays the login form.</li>
        </ul>
        <h2>Features</h2>
        <ul>
            <li>Custom user registration form</li>
            <li>Custom user login form</li>
            <li>OTP verification via email</li>
            <li>Customizable button colors</li>
        </ul>
        <h2>Getting Started</h2>
        <p>To get started, use the shortcodes provided above to add the registration and login forms to your pages or posts.</p>
        <h2>Support</h2>
        <p>If you need support or have any questions, please contact us at [athelay.lwin@gmail.com].</p>
    </div>
<?php
}
?>