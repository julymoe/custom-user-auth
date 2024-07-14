<?php

// Enqueue scripts and styles
function cua_enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('cua-script', plugin_dir_url(__FILE__) . 'cua-script.js', array('jquery'), '1.0', true);
    wp_localize_script('cua-script', 'cua_ajax', array('ajax_url' => admin_url('admin-ajax.php'), 'dashboard_url' => admin_url('index.php')));
    wp_enqueue_style('cua-style', plugin_dir_url(__FILE__) . 'cua-style.css');

    // Add inline CSS for button color
    $button_color = get_option('cua_form_button_color', '#4CAF50');
    $button_hover_color = adjustBrightness($button_color, -10); // Function to darken color for hover effect
    $inline_css = "
    <style>
    .cua-button {
        background-color: {$button_color} !important;
    }
    .cua-button:hover {
        background-color: {$button_hover_color} !important;
    }
    </style>";
    wp_add_inline_style('cua-style', $inline_css);
}
add_action('wp_enqueue_scripts', 'cua_enqueue_scripts');
?>