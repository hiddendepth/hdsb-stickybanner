<?php
/**
 * Plugin Name: Sticky Banner
 * Plugin URI: https://github.com/hiddendepth/hd-stickybanner
 * Description: Display a sticky banner at the top or bottom of your website.
 * Version: 1.0.0
 * Author: Hidden Depth
 * Author URI: https://github.com/hiddendepth/
 * License: GPL3
 *
 * @package Sticky banner
 * @version 1.0.0
 * @author Hidden Depth <info@hd.ie>
 */
define ('VERSION', '1.0.0');

add_action( 'admin_enqueue_scripts', 'hd_stickybanner_enqueue_admin_scripts' );
function hd_stickybanner_enqueue_admin_scripts( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'hd-stickybanner', plugins_url('js/hd-stickybanner-admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	
	// Enqueue the style
	wp_register_style('hd-stickybanner-admin-style',  plugin_dir_url( __FILE__ ) .'css/hd-stickybanner-admin.css', '', VERSION);
    wp_enqueue_style('hd-stickybanner-admin-style');
}

add_action( 'wp_enqueue_scripts', 'hd_stickybanner_scripts' );
function hd_stickybanner_scripts() {
	// Enqueue the style
	wp_register_style('hd-stickybanner-style',  plugin_dir_url( __FILE__ ) .'css/hd-stickybanner.css', '', VERSION);
	wp_enqueue_style('hd-stickybanner-style');
	
	// Set Script parameters
	$script_params = array(
		// script specific parameters
		'id'                        => get_the_ID(),
		'hd_stickybanner_colour'      => get_option('hd_stickybanner_colour'),
		'hd_stickybanner_text_colour' => get_option('hd_stickybanner_text_colour'),
		'hd_stickybanner_text'       => get_option('hd_stickybanner_text'),
		'hd_stickybanner_position'   => get_option('hd_stickybanner_position'),
		'hd_stickybanner_btn_text'   => get_option('hd_stickybanner_btn_text'),
		'hd_stickybanner_btn_link'   => get_option('hd_stickybanner_btn_link')
	);
	// Enqueue the script
    wp_register_script('hd-stickybanner-script', plugin_dir_url( __FILE__ ) . 'js/hd-stickybanner.js', array( 'jquery' ), VERSION);
	wp_localize_script('hd-stickybanner-script', 'scriptParams', $script_params);
	wp_enqueue_script('hd-stickybanner-script');
}

//add custom CSS colors
add_action( 'wp_head', 'hd_stickybanner_custom_colour');
function hd_stickybanner_custom_colour()
{
	if (get_option('hd_stickybanner_colour') != ""){
		?> 
		<style type="text/css" media="screen">
			.hd-stickybanner {background:<?php echo get_option('hd_stickybanner_colour'); ?> !important;}
			.hd-stickybanner-btn {color: <?php echo get_option('hd_stickybanner_colour'); ?> !important;}
			.hd-stickybanner-btn:hover {color: <?php echo get_option('hd_stickybanner_colour'); ?> !important;}
		</style>
		<?php
	}

	if (get_option('hd_stickybanner_text_colour') != ""){
		?>
			<style type="text/css" media="screen">
				.hd-stickybanner-text{color:<?php echo get_option('hd_stickybanner_text_colour'); ?> !important;}
				.hd-stickybanner-btn {background:<?php echo get_option('hd_stickybanner_text_colour'); ?> !important;}
			</style>
		<?php
	}
}

add_action('admin_menu', 'hd_stickybanner_menu');
function hd_stickybanner_menu() {
	add_menu_page('Sticky Banner Settings', 'Sticky Banner', 'administrator', 'hd-stickybanner-settings', 'hd_stickybanner_settings_page', 'dashicons-admin-generic');
}

add_action( 'admin_init', 'hd_stickybanner_settings' );
function hd_stickybanner_settings() {
	register_setting( 'hd-stickybanner-settings-group', 'hd_stickybanner_colour' );
	register_setting( 'hd-stickybanner-settings-group', 'hd_stickybanner_text_colour' );
	register_setting( 'hd-stickybanner-settings-group', 'hd_stickybanner_text' );
	register_setting( 'hd-stickybanner-settings-group', 'hd_stickybanner_position' );
	register_setting( 'hd-stickybanner-settings-group', 'hd_stickybanner_btn_text' );
	register_setting( 'hd-stickybanner-settings-group', 'hd_stickybanner_btn_link' );
}

function hd_stickybanner_settings_page() {
	?>

	<div class="wrap">
		<div style="display: flex;justify-content: space-between; align-items: center;">
			<h2>Sticky Banner Settings</h2>
			<a href="https://hiddendepth.ie" target="_blank" style="padding: 10px 20px 6px; margin-bottom: 10px; border-radius: 6px;">
				<img height="50" src="<?php echo plugin_dir_url( __FILE__ ) . '/img/hd-logo.svg'; ?>" alt="By Hidden Depth">
			</a>
		</div>

		<!-- Preview Banner -->
		<div id="preview_banner" class="hd-stickybanner">
			<span id="preview_banner_inner_text" class="hd-stickybanner-text">This is what your banner will look like.</span>
			<a id="preview_btn" class="hd-stickybanner-btn" href="/">Button text</a>
		</div>

		<!-- Settings Form -->
		<form method="post" action="options.php">
			<?php settings_fields( 'hd-stickybanner-settings-group' ); ?>
			<?php do_settings_sections( 'hd-stickybanner-settings-group' ); ?>
			<table class="form-table hd-stickybanner-admin-table">
				<!-- Background Colour -->
				<tr valign="top">
					<th scope="row">Background Colour<br><span style="font-weight:400;">(Also button text colour)</span></th>
					<td style="vertical-align:top;">
						<input type="text" class="hd-stickybanner-bg-colour-picker" id="hd_stickybanner_colour" name="hd_stickybanner_colour" value="<?php echo ((get_option('hd_stickybanner_colour') == '') ? '#910A06' : esc_attr( get_option('hd_stickybanner_colour') )); ?>" data-default-color="#910A06" />
					</td>
				</tr>
				<!-- Text Colour -->
				<tr valign="top">
					<th scope="row">Text Colour<br><span style="font-weight:400;">(Also button background colour)</span></th>
					<td style="vertical-align:top;">
						<input type="text" class="hd-stickybanner-text-colour-picker" id="hd_stickybanner_text_colour" name="hd_stickybanner_text_colour" value="<?php echo ((get_option('hd_stickybanner_text_colour') == '') ? '#ffffff' : esc_attr( get_option('hd_stickybanner_text_colour') )); ?>" data-default-color="#ffffff" />
					</td>
				</tr>
				
				<!-- Positioning -->
				<tr valign="top" class="hd-stickybanner-position">
					<th scope="row">
						Position
					</th>
					<td>
						<div class="hd-stickybanner-position-radios">
							<label><input type="radio" name="hd_stickybanner_position" value="top" required <?php checked('top', get_option('hd_stickybanner_position'), true); ?>>Top</label><br />
							<label><input type="radio" name="hd_stickybanner_position" value="bottom" <?php checked('bottom', get_option('hd_stickybanner_position'), true); ?>>Bottom</label>
						</div>
					</td>
				</tr>

				<!-- Text Contents -->
				<tr valign="top">
					<th scope="row">
						Announcement
						<br><span style="font-weight:400;">(Empty removes the banner)</span>
					</th>
					<td>
						<input type="text" id="hd_stickybanner_text" name="hd_stickybanner_text" value="<?php echo esc_attr( get_option('hd_stickybanner_text') ); ?>" />
					</td>
				</tr>

				<!-- Button Text -->
				<tr valign="top" class="hd-stickybanner-btn-text">
					<th scope="row">Button Text</th>
					<td style="vertical-align:top;">
						<input type="text" id="hd_stickybanner_btn_text" name="hd_stickybanner_btn_text" placeholder="Learn more"
							value="<?php echo esc_attr( get_option('hd_stickybanner_btn_text') ); ?>" />
					</td>
				</tr>

				<!-- Button Link -->
				<tr valign="top">
					<th scope="row">Button Link<br><span style="font-weight:400;">E.G. https://hiddendepth.ie</span></th>
					<td style="vertical-align:top;">
						<input type="url" id="hd_stickybanner_btn_link" name="hd_stickybanner_btn_link" placeholder="https://hiddendepth.ie"
							value="<?php echo esc_attr( get_option('hd_stickybanner_btn_link') ); ?>" />
					</td>
				</tr>
			</table>

			<!-- Save Changes Button -->
			<?php submit_button(); ?>
		</form>
	</div>

	<!-- Script to apply styles to Preview Banner -->
	<script type="text/javascript">
		var style_background_colour = document.createElement('style');
		var style_text_colour = document.createElement('style');

		// Banner Text
		document.getElementById('preview_banner_inner_text').innerHTML = document.getElementById('hd_stickybanner_text').value != "" ? document.getElementById('hd_stickybanner_text').value : 'This is what your banner will look like';
		document.getElementById('hd_stickybanner_text').onchange=function(e){
			document.getElementById('preview_banner_inner_text').innerHTML = e.target.value != "" ? e.target.value : 'This is what your banner will look like';
		};

		// Banner Button Text
		document.getElementById('preview_btn').innerHTML = document.getElementById('hd_stickybanner_btn_text').value != "" ? document.getElementById('hd_stickybanner_btn_text').value : 'Button text';
		document.getElementById('hd_stickybanner_btn_text').onchange=function(e){
			document.getElementById('preview_btn').innerHTML = e.target.value != "" ? e.target.value : 'Button text';
		};

		// Background Colour
		style_background_colour.type = 'text/css';
		style_background_colour.id = 'preview_banner_background_colour'
		style_background_colour.appendChild(document.createTextNode('.hd-stickybanner {background:' + (document.getElementById('hd_stickybanner_colour').value || '#910A06') + '} .hd-stickybanner .hd-stickybanner-btn {text-decoration: none; color:' + (document.getElementById('hd_stickybanner_colour').value || '#910A06') + ';}'));
		document.getElementsByTagName('head')[0].appendChild(style_background_colour);

		// Text Colour
		style_text_colour.type = 'text/css';
		style_text_colour.id = 'preview_banner_text_colour'
		style_text_colour.appendChild(document.createTextNode('.hd-stickybanner .hd-stickybanner-text{color:' + (document.getElementById('hd_stickybanner_text_colour').value || '#ffffff') + ';} .hd-stickybanner .hd-stickybanner-btn {padding: 4px 8px; margin: 0 10px; background:' + (document.getElementById('hd_stickybanner_text_colour').value || '#ffffff') + ';}'));
		document.getElementsByTagName('head')[0].appendChild(style_text_colour);
	</script>
	<?php
}
?>