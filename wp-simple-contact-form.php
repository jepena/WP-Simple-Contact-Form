<?php 
/*
 * Plugin Name:       WP Simple Contact Form
 * Tags: contact, form, contact form, email, mail,  captcha, spam, anti spam, anti-spam, antispam
 * Plugin URI:        https://jepena.github.io/
 * Description:       WP Simple Contact Form the Simple but flexible form.
 * Version:           1.0.0
 * Author:            Jacinto Pena Jr
 * Author URI:        https://jepena.github.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 			wp-scf
 * Domain Path: 			/languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


$wp_scf_wp_vers = '4.1';
$wp_scf_version = '1.0.0';
$wp_scf_plugin  = esc_html__('WP Simple Contact Form', 'wp-scf');
$wp_scf_options = get_option('wp_scf_options');
$wp_scf_path    = plugin_basename(__FILE__); 
$wp_scf_homeurl = 'https://jepena.github.io/';

// Admin area
if( is_admin() ) {
	
	require_once plugin_dir_path( __FILE__ ) . 'admin/wp-scf-init.php'; // init
	require_once plugin_dir_path( __FILE__ ) . 'admin/wp-scf-language.php'; // Language
	require_once plugin_dir_path( __FILE__ ) . 'admin/wp-scf-version-control.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/wp-scf-admin-page.php';

	require_once plugin_dir_path( __FILE__ ) . 'admin/wp-scf-enqueue.php';

}

// Public Area
require_once plugin_dir_path( __FILE__ ) . 'public/wp-scf-shortcode.php';

// Includes
require_once plugin_dir_path( __FILE__ ) . 'includes/wp-scf-methods.php';


if ( ! isset( $wp_scf_options['wp_scf_input_confirm_email'] ) ) {
    $wp_scf_options['wp_scf_input_confirm_email'] = '';
}

if ( ! isset( $wp_scf_options['wp_scf_confirm_mailtext'] ) ) {
    $wp_scf_options['wp_scf_confirm_mailtext'] = '';
}

if ( ! isset( $wp_scf_options['wp_scf_input_name'] ) ) {
    $wp_scf_options['wp_scf_input_name'] = '';
}

if ( ! isset( $wp_scf_options['wp_scf_input_email'] ) ) {
    $wp_scf_options['wp_scf_input_email'] = '';
}

if ( ! isset( $wp_scf_options['wp_scf_input_phone'] ) ) {
	$wp_scf_options['wp_scf_input_phone'] = '';
}

if ( ! isset( $wp_scf_options['wp_scf_input_subject'] ) ) {
    $wp_scf_options['wp_scf_input_subject'] = '';
}

if ( ! isset( $wp_scf_options['wp_scf_input_captcha'] ) ) {
    $wp_scf_options['wp_scf_input_captcha'] = '';
}

if ( ! isset( $wp_scf_options['wp_scf_input_message'] ) ) {
    $wp_scf_options['wp_scf_input_message'] = '';
}

if ( ! isset( $wp_scf_options['default_options'] ) ) {
    $wp_scf_options['default_options'] = '';
}


$wp_scf_value_name     = isset($_POST['wp_scf_name'])     ? esc_attr($_POST['wp_scf_name'])        : '';
$wp_scf_value_email    = isset($_POST['wp_scf_email'])    ? sanitize_text_field($_POST['wp_scf_email']) : '';
$wp_scf_value_confirm_email = isset($_POST['wp_scf_confirm_email']) ? sanitize_text_field($_POST['wp_scf_confirm_email']) : '';
$wp_scf_value_subject  = isset($_POST['wp_scf_subject'])  ? esc_attr($_POST['wp_scf_subject'])     : '';
$wp_scf_value_phone  = isset($_POST['wp_scf_phone'])  ? esc_attr($_POST['wp_scf_phone'])     : '';
$wp_scf_value_response = isset($_POST['wp_scf_response']) ? esc_attr($_POST['wp_scf_response'])    : '';
$wp_scf_value_message  = isset($_POST['wp_scf_message'])  ? esc_textarea($_POST['wp_scf_message']) : '';

$wp_scf_strings = array(
	'name' 	   			=> '<input name="wp_scf_name" id="wp_scf_name" type="text" size="33" maxlength="99" value="'. $wp_scf_value_name .'" placeholder="' . $wp_scf_options['wp_scf_input_name'] . '" />', 
	'email'    			=> '<input name="wp_scf_email" id="wp_scf_email" type="text" size="33" maxlength="99" value="'. $wp_scf_value_email .'" placeholder="' . $wp_scf_options['wp_scf_input_email'] . '" />', 
	'confirm_email' => '<input name="wp_scf_confirm_email" id="wp_scf_confirm_email" type="text" size="33" maxlength="99" value="'. $wp_scf_value_confirm_email .'" placeholder="' . $wp_scf_options['wp_scf_input_confirm_email'] . '" />', 
	'subject'  			=> '<input name="wp_scf_subject" id="wp_scf_subject" type="text" size="33" maxlength="99" value="'. $wp_scf_value_subject .'" placeholder="' . $wp_scf_options['wp_scf_input_subject'] . '" />', 
	'phone'  				=> '<input name="wp_scf_phone" id="wp_scf_phone" type="text" size="33" maxlength="99" value="'. $wp_scf_value_phone .'" placeholder="' . $wp_scf_options['wp_scf_input_phone'] . '" />', 
	'response' 			=> '<input name="wp_scf_response" id="wp_scf_response" type="text" size="33" maxlength="99" value="'. $wp_scf_value_response .'" placeholder="' . $wp_scf_options['wp_scf_input_captcha'] . '" />',	
	'message'  			=> '<textarea name="wp_scf_message" id="wp_scf_message" cols="33" rows="7" placeholder="' . $wp_scf_options['wp_scf_input_message'] . '">'. $wp_scf_value_message .'</textarea>', 
	'error'    			=> ''
);

function wp_scf_plugin_action_links($links, $file) {
	global $wp_scf_path;
	
	if ($file == $wp_scf_path) {
		
		$wp_scf_links = '<a href="'. get_admin_url() .'options-general.php?page='. $wp_scf_path .'">'. esc_html__('Settings', 'wp-scf') .'</a>';
		
		array_unshift($links, $wp_scf_links);
		
	}
	
	return $links;
	
}
add_filter ('plugin_action_links', 'wp_scf_plugin_action_links', 10, 2);

function wp_scf_delete_plugin_options() {	
	delete_option('wp_scf_options');
}

if ($wp_scf_options['default_options'] == 1) {
	register_uninstall_hook (__FILE__, 'wp_scf_delete_plugin_options');
}

function wp_scf_add_options_page() {
	global $wp_scf_plugin;
	
	add_options_page($wp_scf_plugin, esc_html__('WP Simple Contact Form', 'wp-scf'), 'manage_options', __FILE__, 'wp_scf_render_form');
	
}
add_action ('admin_menu', 'wp_scf_add_options_page');

function wp_scf_confirm_checkbox() {

	global $wp_scf_options;

	if ( ! isset ( $wp_scf_options['wp_scf_gdpr_message'] ) ) {
		$wp_scf_options['wp_scf_gdpr_message'] = __('I consent to having this website store my submitted information so they can respond to my inquiry. See our privacy policy to learn more how we use data.', 'wp-scf');
	}

	if ( empty( $wp_scf_options['wp_scf_gdpr_message'] ) ) {
		return '';
	}

	ob_start();
	?>
	<div class="wp-scf-confirm-checkbox">
		<label><input type="checkbox"> <?php echo $wp_scf_options['wp_scf_gdpr_message']; ?></label>
	</div>
	<?php
	$output = ob_get_contents();
	ob_end_clean();

	return $output;

} 
add_action( 'wp_scf_before_form_close', 'wp_scf_confirm_checkbox' );

function wp_scf_get_field_value( $name ) {

	$message = isset($_POST[$name]) ? stripslashes(trim($_POST[$name])) : '';
	return $message;

}