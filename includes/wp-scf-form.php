<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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