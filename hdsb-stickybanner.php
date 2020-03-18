<?php
/**
 * Plugin Name: Sticky Banner
 * Plugin URI: https://github.com/hiddendepth/hdsb-stickybanner
 * Description: Display a sticky banner at the top or bottom of your website.
 * Version: 1.0.0
 * Author: Hidden Depth
 * Author URI: https://hiddendepth.ie
 * License: GPL3
 *
 * @package Sticky banner
 * @version 1.0.0
 * @author Hidden Depth <info@hd.ie>
 */
define ('HDSB_VERSION', '1.0.0');

add_action( 'admin_enqueue_scripts', 'hdsb_stickybanner_enqueue_admin_scripts' );
function hdsb_stickybanner_enqueue_admin_scripts( $hook_suffix ) {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'hdsb-stickybanner', plugins_url('js/hdsb-stickybanner-admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
	wp_register_style('hdsb-stickybanner-admin-style',  plugin_dir_url( __FILE__ ) .'css/hdsb-stickybanner-admin.css', '', HDSB_VERSION);
    wp_enqueue_style('hdsb-stickybanner-admin-style');
}

add_action( 'wp_enqueue_scripts', 'hdsb_stickybanner_scripts' );
function hdsb_stickybanner_scripts() {
	// Enqueue the style
	wp_register_style('hdsb-stickybanner-style',  plugin_dir_url( __FILE__ ) .'css/hdsb-stickybanner.css', '', HDSB_VERSION);
	wp_enqueue_style('hdsb-stickybanner-style');

	// Set Script parameters
	$script_params = array(
		// script specific parameters
		'id'                        => get_the_ID(),
		'hdsb_stickybanner_colour'      => get_option('hdsb_stickybanner_colour'),
		'hdsb_stickybanner_text_colour' => get_option('hdsb_stickybanner_text_colour'),
		'hdsb_stickybanner_text'       => get_option('hdsb_stickybanner_text'),
		'hdsb_stickybanner_position'   => get_option('hdsb_stickybanner_position'),
		'hdsb_stickybanner_btn_text'   => get_option('hdsb_stickybanner_btn_text'),
		'hdsb_stickybanner_btn_link'   => get_option('hdsb_stickybanner_btn_link')
	);
	// Enqueue the script
    wp_register_script('hdsb-stickybanner-script', plugin_dir_url( __FILE__ ) . 'js/hdsb-stickybanner.js', array( 'jquery' ), HDSB_VERSION);
	wp_localize_script('hdsb-stickybanner-script', 'scriptParams', $script_params);
	wp_enqueue_script('hdsb-stickybanner-script');
}

//add custom CSS colors
add_action( 'wp_head', 'hdsb_stickybanner_custom_colour');
function hdsb_stickybanner_custom_colour()
{
	if (get_option('hdsb_stickybanner_colour') != ""){
		?> 
		<style type="text/css" media="screen">
			.hdsb-stickybanner {background:<?php echo get_option('hdsb_stickybanner_colour'); ?> !important;}
			.hdsb-stickybanner-btn {color: <?php echo get_option('hdsb_stickybanner_colour'); ?> !important;}
			.hdsb-stickybanner-btn:hover {color: <?php echo get_option('hdsb_stickybanner_colour'); ?> !important;}
		</style>
		<?php
	}

	if (get_option('hdsb_stickybanner_text_colour') != ""){
		?>
			<style type="text/css" media="screen">
				.hdsb-stickybanner-text{color:<?php echo get_option('hdsb_stickybanner_text_colour'); ?> !important;}
				.hdsb-stickybanner-btn {background:<?php echo get_option('hdsb_stickybanner_text_colour'); ?> !important;}
			</style>
		<?php
	}
}

add_action('admin_menu', 'hdsb_stickybanner_menu');
function hdsb_stickybanner_menu() {
	add_menu_page('Sticky Banner Settings', 'Sticky Banner', 'administrator', 'hdsb-stickybanner-settings', 'hdsb_stickybanner_settings_page', 'dashicons-admin-generic');
}

add_action( 'admin_init', 'hdsb_stickybanner_settings' );
function hdsb_stickybanner_settings() {
	register_setting( 'hdsb-stickybanner-settings-group', 'hdsb_stickybanner_colour' );
	register_setting( 'hdsb-stickybanner-settings-group', 'hdsb_stickybanner_text_colour' );
	register_setting( 'hdsb-stickybanner-settings-group', 'hdsb_stickybanner_text' );
	register_setting( 'hdsb-stickybanner-settings-group', 'hdsb_stickybanner_position' );
	register_setting( 'hdsb-stickybanner-settings-group', 'hdsb_stickybanner_btn_text' );
	register_setting( 'hdsb-stickybanner-settings-group', 'hdsb_stickybanner_btn_link' );
}

function hdsb_stickybanner_settings_page() {
?>
	<div class="wrap">
		<div style="display: flex;justify-content: space-between; align-items: center;">
			<h2>Sticky Banner Settings</h2>
			<a href="https://hiddendepth.ie/?utm_source=wp_plugin&utm_medium=website&utm_campaign=sticky_banner target="_blank" style="padding: 10px 20px 6px; margin-bottom: 10px; border-radius: 6px;">
				<img height="50" src="<?php echo plugin_dir_url( __FILE__ ) . '/img/hd-logo.svg'; ?>" alt="By Hidden Depth">
			</a>
		</div>

		<!-- Preview Banner -->
		<div id="preview_banner" class="hdsb-stickybanner">
			<span id="preview_banner_inner_text" class="hdsb-stickybanner-text">This is what your banner will look like.</span>
			<a id="preview_btn" class="hdsb-stickybanner-btn" href="/">Button text</a>
		</div>

		<!-- Settings Form -->
		<form method="post" action="options.php">
			<?php settings_fields( 'hdsb-stickybanner-settings-group' ); ?>
			<?php do_settings_sections( 'hdsb-stickybanner-settings-group' ); ?>
			<table class="form-table hdsb-stickybanner-admin-table">
				<!-- Background Colour -->
				<tr valign="top">
					<th scope="row">Background Colour<br><span style="font-weight:400;">(Also button text colour)</span></th>
					<td style="vertical-align:top;">
						<input type="text" class="hdsb-stickybanner-bg-colour-picker" id="hdsb_stickybanner_colour" name="hdsb_stickybanner_colour" value="<?php echo ((get_option('hdsb_stickybanner_colour') == '') ? '#910A06' : esc_attr( get_option('hdsb_stickybanner_colour') )); ?>" data-default-color="#910A06" />
					</td>
				</tr>
				<!-- Text Colour -->
				<tr valign="top">
					<th scope="row">Text Colour<br><span style="font-weight:400;">(Also button background colour)</span></th>
					<td style="vertical-align:top;">
						<input type="text" class="hdsb-stickybanner-text-colour-picker" id="hdsb_stickybanner_text_colour" name="hdsb_stickybanner_text_colour" value="<?php echo ((get_option('hdsb_stickybanner_text_colour') == '') ? '#ffffff' : esc_attr( get_option('hdsb_stickybanner_text_colour') )); ?>" data-default-color="#ffffff" />
					</td>
				</tr>
				
				<!-- Positioning -->
				<tr valign="top" class="hdsb-stickybanner-position">
					<th scope="row">
						Position
					</th>
					<td>
						<div class="hdsb-stickybanner-position-radios">
							<label><input type="radio" name="hdsb_stickybanner_position" value="top" required <?php checked('top', get_option('hdsb_stickybanner_position'), true); ?>>Top</label><br />
							<label><input type="radio" name="hdsb_stickybanner_position" value="bottom" <?php checked('bottom', get_option('hdsb_stickybanner_position'), true); ?>>Bottom</label>
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
						<input type="text" id="hdsb_stickybanner_text" name="hdsb_stickybanner_text" value="<?php echo esc_attr( get_option('hdsb_stickybanner_text') ); ?>" />
					</td>
				</tr>

				<!-- Button Text -->
				<tr valign="top" class="hdsb-stickybanner-btn-text">
					<th scope="row">Button Text</th>
					<td style="vertical-align:top;">
						<input type="text" id="hdsb_stickybanner_btn_text" name="hdsb_stickybanner_btn_text" placeholder="Learn more"
							value="<?php echo esc_attr( get_option('hdsb_stickybanner_btn_text') ); ?>" />
					</td>
				</tr>

				<!-- Button Link -->
				<tr valign="top">
					<th scope="row">Button Link<br><span style="font-weight:400;">E.G. https://hiddendepth.ie</span></th>
					<td style="vertical-align:top;">
						<input type="url" id="hdsb_stickybanner_btn_link" name="hdsb_stickybanner_btn_link" placeholder="https://hiddendepth.ie"
							value="<?php echo esc_attr( get_option('hdsb_stickybanner_btn_link') ); ?>" />
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
		document.getElementById('preview_banner_inner_text').innerHTML = document.getElementById('hdsb_stickybanner_text').value != "" ? document.getElementById('hdsb_stickybanner_text').value : 'This is what your banner will look like';
		document.getElementById('hdsb_stickybanner_text').onchange=function(e){
			document.getElementById('preview_banner_inner_text').innerHTML = e.target.value != "" ? e.target.value : 'This is what your banner will look like';
		};

		// Banner Button Text
		document.getElementById('preview_btn').innerHTML = document.getElementById('hdsb_stickybanner_btn_text').value != "" ? document.getElementById('hdsb_stickybanner_btn_text').value : 'Button text';
		document.getElementById('hdsb_stickybanner_btn_text').onchange=function(e){
			document.getElementById('preview_btn').innerHTML = e.target.value != "" ? e.target.value : 'Button text';
		};

		// Background Colour
		style_background_colour.type = 'text/css';
		style_background_colour.id = 'preview_banner_background_colour'
		style_background_colour.appendChild(document.createTextNode('.hdsb-stickybanner {background:' + (document.getElementById('hdsb_stickybanner_colour').value || '#910A06') + '} .hdsb-stickybanner .hdsb-stickybanner-btn {text-decoration: none; color:' + (document.getElementById('hdsb_stickybanner_colour').value || '#910A06') + ';}'));
		document.getElementsByTagName('head')[0].appendChild(style_background_colour);

		// Text Colour
		style_text_colour.type = 'text/css';
		style_text_colour.id = 'preview_banner_text_colour'
		style_text_colour.appendChild(document.createTextNode('.hdsb-stickybanner .hdsb-stickybanner-text{color:' + (document.getElementById('hdsb_stickybanner_text_colour').value || '#ffffff') + ';} .hdsb-stickybanner .hdsb-stickybanner-btn {padding: 4px 8px; margin: 0 10px; background:' + (document.getElementById('hdsb_stickybanner_text_colour').value || '#ffffff') + ';}'));
		document.getElementsByTagName('head')[0].appendChild(style_text_colour);
	</script>
<?php
}
?>