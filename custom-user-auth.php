<?php
/*
Plugin Name: Custom User Authentication
Description: Custom user registration and login plugin with OTP verification.
Version: 1.0.0
Author: The The Lwin
*/

// Ensure WordPress context
if (!defined('ABSPATH')) {
    exit;
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'country-codes.php';
require_once plugin_dir_path(__FILE__) . 'cua-scripts.php';
require_once plugin_dir_path(__FILE__) . 'cua-helpers.php';
require_once plugin_dir_path(__FILE__) . 'cua-registration.php';
require_once plugin_dir_path(__FILE__) . 'cua-login.php';
require_once plugin_dir_path(__FILE__) . 'cua-admin.php';

// Add a settings link to the plugins page
function cua_add_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=cua-settings">' . __('Settings', 'cua') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

// Replace {plugin_file} with the actual main plugin file name
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'cua_add_settings_link');
?>
