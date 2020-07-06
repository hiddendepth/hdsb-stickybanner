<?php
add_action('admin_enqueue_scripts', 'hdsb_stickybanner_enqueue_admin_scripts');
function hdsb_stickybanner_enqueue_admin_scripts($hook_suffix)
{
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('hdsb-stickybanner', HDSB_PLUGIN_URL . 'assets/js/stickybanner-admin.min.js', array('wp-color-picker'), false, true);
    wp_register_style('hdsb-stickybanner-admin-style',  HDSB_PLUGIN_URL . 'assets/css/stickybanner-admin.css', '', HDSB_VERSION);
    wp_enqueue_style('hdsb-stickybanner-admin-style');
}

add_action('wp_enqueue_scripts', 'hdsb_stickybanner_scripts');
function hdsb_stickybanner_scripts()
{
    // Enqueue the style
    wp_register_style('hdsb-stickybanner-style',  HDSB_PLUGIN_URL . 'assets/css/stickybanner.css', '', HDSB_VERSION);
    wp_enqueue_style('hdsb-stickybanner-style');

    // Set Script parameters
    $script_params = array(
        // script specific parameters
        'id'                        => get_the_ID(),
        'hdsb_stickybanner_position'   => get_option('hdsb_stickybanner_position'),
    );

    // Enqueue the script
    wp_register_script('hdsb-stickybanner-script', HDSB_PLUGIN_URL . 'assets/js/stickybanner.min.js', array('jquery'), HDSB_VERSION);
    wp_localize_script('hdsb-stickybanner-script', 'scriptParams', $script_params);
    wp_enqueue_script('hdsb-stickybanner-script');

    if (is_user_logged_in()) :
    //wp_enqueue_script('hdsb-scripts-admin', HDSB_PLUGIN_URL . 'assets/js/hdsb-scripts.min.js', 'hdsb-stickybanner-script', HDSB_VERSION);
    else :
    // wp_enqueue_script('hdsb-scripts', HDSB_PLUGIN_URL . 'assets/js/hdsb-scripts.min.js', 'jquery', HDSB_VERSION, true);
    endif;
}
