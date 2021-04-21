<?php
/*
*
* WP SCF Admin Page Settings
*
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wp_scf_validate_options($input) {
	
	if (!isset($input['default_options'])) $input['default_options'] = null;
	$input['default_options'] = ($input['default_options'] == 1 ? 1 : 0);
	
	// General
	$input['wp_scf_name']     = esc_attr($input['wp_scf_name']);
	$input['wp_scf_email']    = sanitize_text_field($input['wp_scf_email']);
	$input['wp_scf_website']  = esc_attr($input['wp_scf_website']);
	$input['wp_scf_subject']  = esc_attr($input['wp_scf_subject']);
	
	if (!isset($input['wp_scf_enable_message'])) $input['wp_scf_enable_message'] = null;
	$input['wp_scf_enable_message'] = ($input['wp_scf_enable_message'] == 1 ? 1 : 0);
	
	if (!isset($input['wp_scf_carbon'])) $input['wp_scf_carbon'] = null;
	$input['wp_scf_carbon'] = ($input['wp_scf_carbon'] == 1 ? 1 : 0);
	
	if (!isset($input['wp_scf_success_details'])) $input['wp_scf_success_details'] = null;
	$input['wp_scf_success_details'] = ($input['wp_scf_success_details'] == 1 ? 1 : 0);
	
	if (!isset($input['wp_scf_mail_function'])) $input['wp_scf_mail_function'] = null;
	$input['wp_scf_mail_function'] = ($input['wp_scf_mail_function'] == 1 ? 1 : 0);
	
	// Captcha
	if (!isset($input['wp_scf_captcha'])) $input['wp_scf_captcha'] = null;
	$input['wp_scf_captcha'] = ($input['wp_scf_captcha'] == 1 ? 1 : 0);

	// recaptcha
	$input['wp_scf_recaptcha'] = esc_attr($input['wp_scf_recaptcha']);
	$input['wp_scf_recaptcha_version'] = esc_attr($input['wp_scf_recaptcha_version']);
	$input['wp_scf_recaptcha_site_key'] = esc_attr($input['wp_scf_recaptcha_site_key']);
	$input['wp_scf_recaptcha_secret_key'] = esc_attr($input['wp_scf_recaptcha_secret_key']);
	
	if (!isset($input['wp_scf_casing'])) $input['wp_scf_casing'] = null;
	$input['wp_scf_casing'] = ($input['wp_scf_casing'] == 1 ? 1 : 0);
	
	// Styles
	$input['wp_scf_css'] = sanitize_text_field($input['wp_scf_css']);

	// Labels
	$input['wp_scf_nametext']      = esc_attr($input['wp_scf_nametext']);
	$input['wp_scf_input_name']    = esc_attr($input['wp_scf_input_name']);
	$input['wp_scf_mailtext']      = esc_attr($input['wp_scf_mailtext']);
	$input['wp_scf_confirm_mailtext'] = esc_attr($input['wp_scf_confirm_mailtext']);
	$input['wp_scf_input_email']   = esc_attr($input['wp_scf_input_email']);
	$input['wp_scf_input_confirm_email'] = esc_attr($input['wp_scf_input_confirm_email']);
	$input['wp_scf_subjtext']      = esc_attr($input['wp_scf_subjtext']);
	$input['wp_scf_input_phone'] = esc_attr($input['wp_scf_input_phone']);
	$input['wp_scf_input_subject'] = esc_attr($input['wp_scf_input_subject']);
	$input['wp_scf_messtext']      = esc_attr($input['wp_scf_messtext']);
	$input['wp_scf_submittext']    = esc_attr($input['wp_scf_submittext']);
	$input['wp_scf_input_message'] = esc_attr($input['wp_scf_input_message']);
	$input['wp_scf_input_captcha'] = esc_attr($input['wp_scf_input_captcha']);
	
	// Errors
	$input['wp_scf_success'] = wp_kses_post($input['wp_scf_success']);
	$input['wp_scf_error']   = wp_kses_post($input['wp_scf_error']);
	$input['wp_scf_style']   = wp_kses_post($input['wp_scf_style']);
	$input['wp_scf_spam']    = wp_kses_post($input['wp_scf_spam']);
	
	// Custom
	$input['wp_scf_preform'] = wp_kses_post($input['wp_scf_preform']);
	$input['wp_scf_appform'] = wp_kses_post($input['wp_scf_appform']);
	$input['wp_scf_prepend'] = wp_kses_post($input['wp_scf_prepend']);
	$input['wp_scf_append']  = wp_kses_post($input['wp_scf_append']);
	$input['wp_scf_before_button']  = wp_kses_post($input['wp_scf_before_button']);
	
	return $input;
	
}


function wp_scf_malicious_input($input) {
	
	$maliciousness = false;
	
	$denied_inputs = array("\r", "\n", "mime-version", "content-type", "cc:", "to:");
	
	foreach($denied_inputs as $denied_input) {
		
		if (strpos(strtolower($input), strtolower($denied_input)) !== false) {
			
			$maliciousness = true;
			
			break;
			
		}
		
	}
	
	return $maliciousness;
	
}

function wp_scf_spam_question($input) {
	
	global $wp_scf_options;
	
	$casing   = $wp_scf_options['wp_scf_casing'];
	$response = $wp_scf_options['wp_scf_response'];
	$response = sanitize_text_field($response);
	
	if ($casing == false) return (strtoupper($input) == strtoupper($response));
	
	else return ($input == $response);
	
}

function wp_scf_get_ip_address() {
	
	if (isset($_SERVER)) {
		
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
			
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
			
		}
		
	} else {
		
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_X_FORWARDED_FOR');
			
		} elseif (getenv('HTTP_CLIENT_IP')) {
			$ip_address = getenv('HTTP_CLIENT_IP');
			
		} else {
			$ip_address = getenv('REMOTE_ADDR');
			
		}
		
	}
	
	return $ip_address;
	
}

function wp_scf_default_styles() {
	
	return '#wp-simple-contact-form form { max-width: 700px; padding: 5px; } 
  #wp-simple-contact-form .wp-scf-row { width: 100%; overflow: hidden; margin: 5px 0; padding: 5px 0; border: 0; } 
  #wp-simple-contact-form .wp-scf-row input { box-sizing: border-box; float: left; clear: none; width: 100%; margin: 0; } 
  #wp-simple-contact-form .wp-scf-row.label-present input { box-sizing: border-box; float: left; clear: none; width: 75%; margin: 0; } 
  #wp-simple-contact-form .wp-scf-row label { box-sizing: border-box; float: left; clear: both; width: 25%; margin-top: 5px; font-size: 90%; } 
  #wp-simple-contact-form .wp-scf-row textarea { box-sizing: border-box; float: left; clear: both; width: 100%; margin-top: 2px; } 
  #wp-scf_success pre { white-space: pre-wrap; } p.wp-scf_error, p.wp-scf_spam { color: #cc0000; } 
  div.wp-scf-submit { margin-top: 10px; } p.wp-scf_success { color: #669966; } 
  .wp-scf-confirm-checkbox { margin-top: 15px; } 
  .wp-scf-website3dhhsy3 { display: none; }';

}


function wp_scf_get_field_value( $name ) {

	$message = isset($_POST[$name]) ? stripslashes(trim($_POST[$name])) : '';
	return $message;

}