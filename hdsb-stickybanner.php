<?php

/**
 * Plugin Name: Sticky Banner
 * Plugin URI: https://github.com/hiddendepth/hdsb-stickybanner
 * Description: Display a sticky banner at the top or bottom of your website.
 * Version: 1.1.0
 * Author: Hidden Depth
 * Author URI: https://hiddendepth.ie
 * License: GPL3
 *
 * @package Sticky banner
 * @version 1.1.0
 * @author Hidden Depth <info@hd.ie>
 */
define('HDSB_VERSION', '1.1.0');
define('HDSB_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('HDSB_PLUGIN_URL', plugin_dir_url(__FILE__));

add_action('wp_footer', 'hdsb_stickybanner_output');
function hdsb_stickybanner_output()
{
    require_once('inc/stickybanner.php');
}

require_once(HDSB_PLUGIN_PATH . 'inc/enqueues.php');
require_once(HDSB_PLUGIN_PATH . 'inc/admin/colours.php');
require_once(HDSB_PLUGIN_PATH . 'inc/admin/settings.php');
