<?php
/*
*
* WP SCF Admin init
*
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wp_scf_init() {
	
	register_setting('wp_scf_plugin_options', 'wp_scf_options', 'wp_scf_validate_options');
	
}
add_action ('admin_init', 'wp_scf_init');

function wp_scf_delete_plugin_options() {	
	delete_option('wp_scf_options');
}

if ($wp_scf_options['default_options'] == 1) {
	register_uninstall_hook (__FILE__, 'wp_scf_delete_plugin_options');
}


function wp_scf_add_defaults() {
	
	$user_info = get_userdata(1);
	
	$admin_name = $user_info->user_login;
	
	if (!$admin_name) $admin_name = 'Awesome Person';
	
	$site_title = get_bloginfo('name');
	$admin_mail = get_bloginfo('admin_email');
	$tmp        = get_option('wp_scf_options');
	
	if ( ! is_array( $tmp ) || $tmp['default_options'] == '1' ) {
		
		$arr = array(
			
			'default_options'     => 0,
			
			// General
			'wp_scf_name'            => $admin_name,
			'wp_scf_email'           => $admin_mail,
			'wp_scf_from'            => $admin_mail,
			'wp_scf_website'         => $site_title,
			'wp_scf_subject'         => esc_html__('Message sent from your contact form.', 'wp-scf'),
			'wp_scf_enable_message'  => 1,
			'wp_scf_carbon'          => 1,
			'wp_scf_success_details' => 1,
			'wp_scf_gdpr_message'    => __('I have read and accept the Privacy Policy and Terms & Conditions. I consent to having this website store my submitted information so they can respond to my inquiry.', 'wp-scf'),
			'wp_scf_gdpr_position'   => 'after_submit',
			'wp_scf_mail_function'   => 0,
			
			// Captcha
			'wp_scf_recaptcha'       => 0,
			'wp_scf_recaptcha_site_key' => '',
			'wp_scf_recaptcha_secret_key' => '',
			
			// Styles
			'wp_scf_css'             => wp_scf_default_styles(),
			
			// Labels
			'wp_scf_nametext'        => esc_html__('Your Name', 'wp-scf'),
			'wp_scf_input_name'      => esc_attr__('Your Name', 'wp-scf'),
			'wp_scf_mailtext'        => esc_html__('Your Email', 'wp-scf'),
			'wp_scf_input_phone'        => esc_html__('Your Phone', 'wp-scf'),
			'wp_scf_confirm_mailtext'=> esc_html__('Confirm Your Email', 'wp-scf'),
			'wp_scf_input_email'     => esc_attr__('Your Email', 'wp-scf'),
			'wp_scf_input_confirm_email' => esc_attr__('Confirm Your Email', 'wp-scf'),
			'wp_scf_subjtext'        => esc_html__('Email Subject', 'wp-scf'),
			'wp_scf_input_subject'   => esc_attr__('Email Subject', 'wp-scf'),
			'wp_scf_messtext'        => esc_html__('Your Message', 'wp-scf'),
			'wp_scf_submittext'      => esc_attr__('Send email', 'wp-scf'),
			'wp_scf_input_message'   => esc_attr__('Your Message', 'wp-scf'),
			'wp_scf_input_captcha'   => esc_attr__('Correct Response', 'wp-scf'),
			
			// Errors
			'wp_scf_success'         => '<p class="wp_scf_success"><strong>'. esc_html__('Success!', 'wp-scf') .'</strong> '. esc_html__('Your message has been sent.', 'wp-scf') .'</p>',
			'wp_scf_error'           => '<p class="wp_scf_error">'. esc_html__('Please complete the required fields.', 'wp-scf') .'</p>',
			'wp_scf_style'           => 'style="border: 2px solid #cc0000;"',
			'wp_scf_spam'            => '<p class="wp_scf_spam">'. esc_html__('Incorrect response for challenge question. Please try again.', 'wp-scf') .'</p>',
			
			// Custom
			'wp_scf_preform'         => '',
			'wp_scf_appform'         => '<div style="clear:both;">&nbsp;</div>',
			'wp_scf_prepend'         => '',
			'wp_scf_append'          => '',
			'wp_scf_before_button'   => '',

			// blacklist
			'wp_scf_blacklist'       => '',
			
		);
		
		update_option('wp_scf_options', $arr);
		
	}
	
}
register_activation_hook(__FILE__, 'wp_scf_add_defaults');

