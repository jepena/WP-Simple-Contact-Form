<?php 
/*
 * Plugin Name:       WP Simple Contact Form
 * Tags: 							contact, form, contact form, email, mail,  captcha, antispam
 * Plugin URI:        https://github.com/jepena/WP-Simple-Contact-Form
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
require_once plugin_dir_path( __FILE__ ) . 'includes/wp-scf-form.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/wp-scf-hooks.php';

function wp_scf_add_options_page() {
	global $wp_scf_plugin;
	add_options_page($wp_scf_plugin, esc_html__('WP Simple Contact Form', 'wp-scf'), 'manage_options', __FILE__, 'wp_scf_render_form');
}
add_action ('admin_menu', 'wp_scf_add_options_page');

