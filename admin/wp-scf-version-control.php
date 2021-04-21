<?php
/*
*
* WP SCF Version Control
*
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wp_scf_require_wp_version() {
	
	global $wp_scf_path, $wp_scf_plugin, $wp_scf_wp_vers;
	
	if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
		
		$wp_version = get_bloginfo('version');
		
		if (version_compare($wp_version, $wp_scf_wp_vers, '<')) {
			
			if (is_plugin_active($wp_scf_path)) {
				
				deactivate_plugins($wp_scf_path);
				
				$msg  = '<strong>'. $wp_scf_plugin .'</strong> ';
				$msg .= esc_html__('requires WordPress ', 'wp-scf') . $wp_scf_wp_vers;
				$msg .= esc_html__(' or higher, and has been deactivated! Please return to the', 'wp-scf');
				$msg .= ' <a href="'. admin_url() .'">'. esc_html__('WP Admin Area', 'wp-scf') .'</a> ';
				$msg .= esc_html__('to upgrade WordPress and try again.', 'wp-scf');
				
				wp_die($msg);
				
			}
			
		}
		
	}
	
}
add_action('admin_init', 'wp_scf_require_wp_version');