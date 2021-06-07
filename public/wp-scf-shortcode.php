<?php
/*
*
* WP SCF Shortcodes
*
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wp_simple_contact_form() {
	
	if (wp_scf_input_filter()) {
		
		echo wp_scf_process_contact_form();
		
	} else {
		
		echo wp_scf_display_contact_form();
		
	}
	
}

function wp_scf_shortcode() {
	
	if(wp_scf_input_filter()) return wp_scf_process_contact_form();

	return wp_scf_display_contact_form();
	
}
add_shortcode('wp_simple_contact_form','wp_scf_shortcode');


function wp_scf_display_contact_form() {

	global $wp_scf_options, $wp_scf_strings;
	
	$nametext 		= $wp_scf_options['wp_scf_nametext'];
	$subjtext 		= $wp_scf_options['wp_scf_subjtext'];
	$phonetext 		= $wp_scf_options['wp_scf_phonetext'];
	$mailtext 		= $wp_scf_options['wp_scf_mailtext'];
	$messtext 		= $wp_scf_options['wp_scf_messtext'];
	$submittext 	= $wp_scf_options['wp_scf_submittext'];
	$captcha  		= $wp_scf_options['wp_scf_captcha'];
	$preform  		= $wp_scf_options['wp_scf_preform'];
	$appform  		= $wp_scf_options['wp_scf_appform'];
	$custom   		= $wp_scf_options['wp_scf_css'];
	$error    		= $wp_scf_strings['error'];
	$subject  		= $wp_scf_options['wp_scf_subject'];


	if ( ! empty( $wp_scf_options['wp_scf_include_additional_information'] ) ) {
		$include_additional_information = $wp_scf_options['wp_scf_include_additional_information'];
	} else {
		$include_additional_information = false;
  }
    
  if ( ! empty( $wp_scf_options['wp_scf_before_button'] ) ) {
      $before_button = $wp_scf_options['wp_scf_before_button'];
  } else {
      $before_button = '';
  }

	if ( ! empty( $wp_scf_options['wp_scf_gdpr_position'] ) ) {
		$gdpr_position = $wp_scf_options['wp_scf_gdpr_position'];
	} else {
		$gdpr_position = 'after_submit';
	}

	if ( ! empty( $wp_scf_options['wp_scf_recaptcha'] ) ) {
        $recaptcha = $wp_scf_options['wp_scf_recaptcha'];
  } else {
        $recaptcha = false;
	}

	if ( ! empty( $wp_scf_options['wp_scf_recaptcha_version'] ) ) {
        $recaptcha_version = $wp_scf_options['wp_scf_recaptcha_version'];
  } else {
        $recaptcha_version = 'v2';
	}
	
	if ( ! empty( $wp_scf_options['wp_scf_recaptcha_site_key'] ) ) {
        $recaptcha_site_key = $wp_scf_options['wp_scf_recaptcha_site_key'];
  } else {
        $recaptcha_site_key = '';
	}
	
	if ( ! empty( $wp_scf_options['wp_scf_recaptcha_secret_key'] ) ) {
        $recaptcha_secret_key = $wp_scf_options['wp_scf_recaptcha_secret_key'];
  } else {
        $recaptcha_secret_key = '';
	}		

	$styles = !empty($custom) ? '<style>.wp-scf-confirm-checkbox { margin-top: 15px; } .wp-scf-website3dhhsy3 { display: none; } #wp-simple-contact-form .wp-scf-row { width: 100%; overflow: hidden; margin: 5px 0; padding: 5px 0; border: 0; } #wp-simple-contact-form .wp-scf-row input { box-sizing: border-box; float: left; clear: none; width: 100%; margin: 0; } #wp-simple-contact-form .wp-scf-row label { box-sizing: border-box; float: left; clear: both; width: 25%; margin-top: 5px; font-size: 90%; } #wp-simple-contact-form .wp-scf-row textarea { box-sizing: border-box; float: left; clear: both; width: 100%; margin-top: 2px; }' . $custom . '</style>' : '';
	
	$wp_scf_subject = '';
	$wp_scf_captcha = '';
	$wp_scf_honeypot = '';
	$wp_scf_message = '';
	$wp_scf_recaptcha = '';
	
	if (!empty($wp_scf_options['wp_scf_input_subject']) && isset($wp_scf_options['wp_scf_input_subject'])) {
		$subjtext = !empty($subjtext) ? '<label for="wp_scf_subject">'. $subjtext .'</label>' : "";
		$subjtext_label_class = !empty($subjtext) ? 'label-present' : "";

		$wp_scf_subject = '
				<div class="wp-scf-row '.$subjtext_label_class.' wp-scf-subject">
					'.$subjtext.'
					'. $wp_scf_strings['subject'] .'
				</div>';
	}

  if ((!isset($wp_scf_options['wp_scf_enable_message'])) || (isset($wp_scf_options['wp_scf_enable_message']) && $wp_scf_options['wp_scf_enable_message'])) {
    $messtext = !empty($messtext) ? '<label for="wp_scf_message">'. $messtext .'</label>' : "";
    $messtext_label_class = !empty($messtext) ? 'label-present' : "";
		$wp_scf_message = '
				<div class="wp-scf-row  '.$messtext_label_class.' wp-scf-message">
					'. $messtext .'
					'. $wp_scf_strings['message'] .'
				</div>';
	}

	//
	if ( $recaptcha ) {
		if ( $recaptcha_version == 'v2' ) {
			$wp_scf_recaptcha = '
			<div class="wp-scf-recaptcha">
				<script src="https://www.google.com/recaptcha/api.js"></script>
				<div class="g-recaptcha" data-sitekey="' . $recaptcha_site_key . '"></div>
			</div>';
		} elseif ( $recaptcha_version == 'v3' ) {
			ob_start();
			?>
				<div class="wp-scf-recaptcha">
					<script src="https://www.google.com/recaptcha/api.js?render=<?php echo esc_attr( $recaptcha_site_key ); ?>"></script>
					<script>
						jQuery(document).ready(function(){
							jQuery('.wp-scf form').on( 'submit', function(event) {
								
								event.preventDefault();
								var scfForm = jQuery(this);
								var scfEmail = jQuery(this).find('#wp-scf_email').val();
						
								grecaptcha.ready(function() {
									grecaptcha.execute('<?php echo esc_attr( $recaptcha_site_key ); ?>', {action: 'contact'}).then(function(token) {
										scfForm.prepend('<input type="hidden" name="token" value="' + token + '">');
										scfForm.prepend('<input type="hidden" name="action" value="contact">');
										scfForm.unbind('submit').submit();
									});
								});
								
							});
						});
					</script>
				</div>
			<?php
			$wp_scf_recaptcha = ob_get_contents();
			ob_end_clean();
		}
	}
	//
	
	$wp_scf_custom_fields = apply_filters( 'wp_scf_custom_fields', '' );
	if ( empty( $wp_scf_custom_fields ) ) {
		$wp_scf_custom_fields = '';
	}
    
	$wp_scf_confirm_email = '';
	$mailtext = 	!empty($mailtext) ? "<label for='wp_scf_email'> $mailtext </label>" : "";
	$nametext = 	!empty($nametext) ? "<label for='wp_scf_name'> $nametext </label>" : "";
	$phonetext = 	!empty($phonetext) ? "<label for='wp_scf_phone'> $phonetext </label>" : "";
	$confirm_mailtext = $wp_scf_options['wp_scf_confirm_mailtext'];
	$confirm_mailtext = 	!empty($confirm_mailtext ) ? "<label for='wp_scf_phone'> $confirm_mailtext </label>" : "";

	$mailtext_label_class = !empty($mailtext) ? 'label-present' : "";
	$nametext_label_class = !empty($nametext) ? 'label-present' : "";
	$phonetext_label_class = !empty($phonetext) ? 'label-present' : "";
	$confirm_mailtext_label_class = !empty($confirm_mailtext) ? 'label-present' : "";

	if ( ! empty( $wp_scf_options['wp_scf_input_confirm_email'] ) && ! empty( $wp_scf_options['wp_scf_confirm_mailtext'] ) ) {
        $wp_scf_confirm_email = '
		<div class="wp-scf-row '.$confirm_mailtext_label_class.' wp-scf-confirm-email">
			'.$confirm_mailtext.'
			' . $wp_scf_strings['confirm_email'] . '
		</div>';
	}
	
	$wp_scf_form = '<div id="wp-simple-contact-form-wrap">' . do_shortcode( $preform ) . '
		<div id="wp-simple-contact-form" class="wp-scf">
			<form action="#wp-simple-contact-form-wrap" method="post">
				<div class="wp-scf-row '.$nametext_label_class.' wp-scf-name">
					'.$nametext.'
					'. $wp_scf_strings['name'] .'
				</div>
				<div class="wp-scf-row '.$mailtext_label_class.' wp-scf-email">
					'.$mailtext.'
					'. $wp_scf_strings['email'] .'
				</div>
				<div class="wp-scf-row '.$phonetext_label_class.' wp-scf-phone">
				'.$phonetext.'
				'. $wp_scf_strings['phone'] .'
				</div>';
					
				$wp_scf_form .= $wp_scf_confirm_email;
				$wp_scf_form .= $wp_scf_subject;
				$wp_scf_form .= $wp_scf_custom_fields;
				$wp_scf_form .= $wp_scf_captcha;
				$wp_scf_form .= $wp_scf_honeypot;
				$wp_scf_form .= $wp_scf_message;
				$wp_scf_form .= $wp_scf_recaptcha;
				$wp_scf_form .= do_shortcode( $before_button );

				if ( $gdpr_position == 'before_submit' ) {
					$wp_scf_form .= wp_scf_confirm_checkbox();
				}
				
				$wp_scf_form .= '<div class="wp-scf-submit">
					<input type="submit" id="wp-scf-button" value="'. $submittext .'">
					<input type="hidden" id="scf-key" name="scf-key" value="process">
					'. wp_nonce_field('wp-scf-nonce', 'wp-scf-nonce', false, false) .'
				</div>';
				
				if ( $gdpr_position == 'after_submit' ) {
					$wp_scf_form .= wp_scf_confirm_checkbox();
				}

			$wp_scf_form .= '</form>
			'.$error.'
		</div>
		'. $styles . do_shortcode( $appform ) . '</div>';
	
	return apply_filters('wp_scf_filter_contact_form', $wp_scf_form);
	
}


function wp_scf_process_contact_form() {
	
	global $wp_scf_options;
	global $wp_scf_processed;	
	
	$recipient 	= $wp_scf_options['wp_scf_email'];
	$recipfrom 	= $wp_scf_options['wp_scf_from'];
	$recipname 	= $wp_scf_options['wp_scf_name'];
	$recipsite 	= $wp_scf_options['wp_scf_website'];
	$success   	= $wp_scf_options['wp_scf_success'];
	$phone   	= $wp_scf_options['wp_scf_phone'];
	$subject   	= $wp_scf_options['wp_scf_subject'];
	$prepend   	= $wp_scf_options['wp_scf_prepend'];
	$append    	= $wp_scf_options['wp_scf_append'];
	$carbon    	= $wp_scf_options['wp_scf_carbon'];
	$custom    	= $wp_scf_options['wp_scf_css'];
	$messdisp  	= $wp_scf_options['wp_scf_enable_message'];
	$mailfunc  	= $wp_scf_options['wp_scf_mail_function'];
	$verbose   	= $wp_scf_options['wp_scf_success_details'];
	
	if ( ! empty( $wp_scf_options['wp_scf_include_additional_information'] ) ) {
		$include_additional_information = $wp_scf_options['wp_scf_include_additional_information'];
	} else {
		$include_additional_information = false;
  }
    
  if ( ! empty( $wp_scf_options['wp_scf_blacklist'] ) ) {
		$blacklist = explode( ',', $wp_scf_options['wp_scf_blacklist'] );
	} else {
		$blacklist = false;
	}

	if ( ! empty( $wp_scf_options['wp_scf_recaptcha'] ) ) {
		$recaptcha = $wp_scf_options['wp_scf_recaptcha'];
	} else {
		$recaptcha = false;
	}

	if ( ! empty( $wp_scf_options['wp_scf_recaptcha_version'] ) ) {
		$recaptcha_version = $wp_scf_options['wp_scf_recaptcha_version'];
	} else {
		$recaptcha_version = 'v2';
	}
	
	if ( ! empty( $wp_scf_options['wp_scf_recaptcha_site_key'] ) ) {
		$recaptcha_site_key = $wp_scf_options['wp_scf_recaptcha_site_key'];
	} else {
		$recaptcha_site_key = '';
	}
	
	if ( ! empty( $wp_scf_options['wp_scf_recaptcha_secrey_key'] ) ) {
		$recaptcha_secret_key = $wp_scf_options['wp_scf_recaptcha_secrey_key'];
	} else {
		$recaptcha_secret_key = '';
  }
	
	$charset = get_option('blog_charset', 'UTF-8');
	
	$date    = date_i18n(get_option('date_format'), current_time('timestamp')) .' @ '. date_i18n(get_option('time_format'), current_time('timestamp'));
	
  $topic   = (isset($_POST['wp_scf_subject']) && !empty($_POST['wp_scf_subject'])) ? stripslashes(strip_tags(trim($_POST['wp_scf_subject']))) : $subject;
  $topic   = do_shortcode( $topic );
	
	$name    = isset($_POST['wp_scf_name']) ? stripslashes(strip_tags(trim($_POST['wp_scf_name']))) : '';
	$topic = str_replace( '{name}', $name, $topic );
	
	$message = isset($_POST['wp_scf_message']) ? stripslashes(trim($_POST['wp_scf_message'])) : '';
	
	$email   = isset($_POST['wp_scf_email']) ? sanitize_text_field($_POST['wp_scf_email']) : '';
	
	$agent   = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : esc_html__('[ undefined ]', 'wp-scf');
	
	$form    = isset($_SERVER['HTTP_REFERER']) ? sanitize_text_field($_SERVER['HTTP_REFERER']) : esc_html__('[ undefined ]', 'wp-scf');
	
	$host    = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(gethostbyaddr($_SERVER['REMOTE_ADDR'])) : esc_html__('[ undefined ]', 'wp-scf');
	
	$from    = !empty($recipfrom) ? $recipfrom : $email;
	
	$ip      = sanitize_text_field(wp_scf_get_ip_address());
	
	$style   = !empty($custom) ? '<style type="text/css">'. $custom .'</style>' : '';
	
	$copy    = ($carbon) ? '<p class="wp_scf_carbon">'. esc_html__('A copy of this message was sent to your email address.', 'wp-scf') .'</p>' : '';
	
	$headers  = 'X-Mailer: Simple Basic Contact Form'. "\n";
	$headers .= 'From: '. $name .' <'. $from .'>'. "\n";
	$headers .= 'Reply-To: '. $name .' <'. $email .'>'. "\n";
	$headers .= 'Content-Type: text/plain; charset='. $charset . "\n";
	
	$message_encode = htmlentities($message, ENT_QUOTES, $charset);
	
	$message_plain = ($messdisp) ? "\n" . esc_html__('Message: ', 'wp-scf') . "\n\n" . $message : '';
	$message_front = ($messdisp) ? "\n" . esc_html__('Message: ', 'wp-scf') . "\n\n" . $message_encode : '';
	
	$custom_content = apply_filters( 'wp_scf_custom_email_content', '' );
	if ( empty( $custom_content ) ) {
		$custom_content = '';
	}

	$message_send = esc_html__('Hello ', 'wp-scf') . $recipname .', '. "\n\n" . 
					esc_html__('You are being contacted via ', 'wp-scf') . $recipsite .': '. "\n\n" . 
					
					esc_html__('Name:     ', 'wp-scf') . $name  . "\n" . 
					esc_html__('Email:    ', 'wp-scf') . $email . "\n" . 
					esc_html__('Subject:  ', 'wp-scf') . $topic . "\n" . 
					esc_html__('Date:     ', 'wp-scf') . $date  . "\n" .
					
					$custom_content . $message_plain . "\n\n";

	// additional information
	if ( $include_additional_information ) {

		$message_send .= esc_html__('-----------------------', 'wp-scf') . "\n\n"; 
		$message_send .= esc_html__('Additional Information:', 'wp-scf') . "\n\n"; 
		$message_send .= esc_html__('Site:     ', 'wp-scf') . $recipsite . "\n";
		$message_send .= esc_html__('URL:      ', 'wp-scf') . $form      . "\n"; 
		$message_send .= esc_html__('IP:       ', 'wp-scf') . $ip        . "\n"; 
		$message_send .= esc_html__('Host:     ', 'wp-scf') . $host      . "\n"; 
		$message_send .= esc_html__('Agent:    ', 'wp-scf') . $agent     . "\n\n";
	
	}
	
	$message_send = apply_filters('wp_scf_full_message', $message_send);

    // check if message contains blacklisted words
    $valid_submission = true;
    if ( is_array( $blacklist ) ) {
        foreach ( $blacklist as $blacklist_item ) {
            if (strpos( $message_plain, trim( $blacklist_item ) ) !== false) {
                $valid_submission = false;
            }
        }
    }

    if ( $valid_submission && ! $wp_scf_processed ) {

			if ($mailfunc) {
					
					if ($carbon) mail($email,     $topic, $message_send, $headers);
											mail($recipient, $topic, $message_send, $headers);
					
			} else {
					
					if ($carbon) wp_mail($email,     $topic, $message_send, $headers);
											wp_mail($recipient, $topic, $message_send, $headers);
					
			}

    }
	
	do_action('wp_scf_send_email', $recipient, $topic, $message_send, $headers, $email);
	
	$reset_link  = '<p class="wp_scf_reset">'. esc_html__('[ ', 'wp-scf');
	$reset_link .= '<a href="'. $form .'">'. esc_html__('Click here to reset the form', 'wp-scf') .'</a>';
	$reset_link .= esc_html__(' ]', 'wp-scf') .'</p></div>'. $style . do_shortcode( $append );
	
	$short_results  = do_shortcode( $prepend ) .'<div id="wp_scf_success" class="scf">'. $success;
	$short_results .= ($messdisp) ? '<pre><code>'. esc_html__('Message: ', 'wp-scf') . "\n\n" . $message_encode .'</code></pre>' : '';
	$short_results .= $copy . $reset_link;
	
	$full_results = do_shortcode( $prepend ) .'<div id="wp_scf_success" class="scf">'. $success .'<pre><code>'. 
								esc_html__('Name:     ', 'wp-scf') . $name  . "\n" . 
								esc_html__('Email:    ', 'wp-scf') . $email . "\n" . 
								esc_html__('Subject:  ', 'wp-scf') . $topic . "\n" . 
								esc_html__('Date:     ', 'wp-scf') . $date  . $message_front .'</code></pre>'. $copy . $reset_link;
	
	$full_results = '<div id="wp-simple-contact-form-wrap">' . $full_results . '</div>';
	$short_results = '<div id="wp-simple-contact-form-wrap">' . $short_results . '</div>';

	$short_results = apply_filters('wp_scf_short_results', $short_results);
	$full_results  = apply_filters('wp_scf_full_results',  $full_results);

	$wp_scf_processed = true;
	
	if ($verbose) return $full_results;
	
	return $short_results;
	
}


function wp_scf_input_filter() {
	
	global $wp_scf_options, $wp_scf_strings, $wp_scf_value_name, $wp_scf_value_email, $wp_scf_value_confirm_email, $wp_scf_value_phone, $wp_scf_value_subject, $wp_scf_value_message, $wp_scf_value_response;

	global $wp_scf_processed;
	
	$input_name     			= $wp_scf_value_name;
	$input_email    			= $wp_scf_value_email;
	$input_confirm_email 		= $wp_scf_value_confirm_email;
	$input_subject  			= $wp_scf_value_subject;
	$input_phone  				= $wp_scf_value_phone;
	$input_message  			= $wp_scf_value_message;
	$input_response 			= $wp_scf_value_response;
	
	$name    					= isset($wp_scf_options['wp_scf_input_name'])    ? $wp_scf_options['wp_scf_input_name']    : '';
	$email   					= isset($wp_scf_options['wp_scf_input_email'])   ? $wp_scf_options['wp_scf_input_email']   : '';
	$confirm_email   			= isset($wp_scf_options['wp_scf_input_confirm_email']) ? $wp_scf_options['wp_scf_input_confirm_email']   : '';
	$subject 					= isset($wp_scf_options['wp_scf_input_subject']) ? $wp_scf_options['wp_scf_input_subject'] : '';
	$phone 						= isset($wp_scf_options['wp_scf_input_phone']) ? $wp_scf_options['wp_scf_input_phone'] : '';
	$message 					= isset($wp_scf_options['wp_scf_input_message']) ? $wp_scf_options['wp_scf_input_message'] : '';
	$captcha 					= isset($wp_scf_options['wp_scf_input_captcha']) ? $wp_scf_options['wp_scf_input_captcha'] : '';
	$style   					= isset($wp_scf_options['wp_scf_style'])         ? $wp_scf_options['wp_scf_style']         : '';
	$error   					= isset($wp_scf_options['wp_scf_error'])         ? $wp_scf_options['wp_scf_error']         : '';
	$spam    					= isset($wp_scf_options['wp_scf_spam'])          ? $wp_scf_options['wp_scf_spam']          : '';
	
	$show_subject 		= isset($wp_scf_options['wp_scf_subject'])        ? $wp_scf_options['wp_scf_subject']        : false;
	$show_message 		= isset($wp_scf_options['wp_scf_enable_message']) ? $wp_scf_options['wp_scf_enable_message'] : true;
	$show_captcha 		= isset($wp_scf_options['wp_scf_captcha'])        ? $wp_scf_options['wp_scf_captcha']        : true;
	$show_honeypot 		= isset($wp_scf_options['wp_scf_honeypot'])      ? $wp_scf_options['wp_scf_honeypot']       : true;

	// recaptcha
	$recaptcha 						= isset($wp_scf_options['wp_scf_recaptcha']) ? $wp_scf_options['wp_scf_recaptcha'] : false;
	$recaptcha_version 		= isset($wp_scf_options['wp_scf_recaptcha_version']) ? $wp_scf_options['wp_scf_recaptcha_version'] : 'v2';
	$recaptcha_site_key 	= isset($wp_scf_options['wp_scf_recaptcha_site_key']) ? $wp_scf_options['wp_scf_recaptcha_site_key'] : '';
	$recaptcha_secret_key = isset($wp_scf_options['wp_scf_recaptcha_secret_key']) ? $wp_scf_options['wp_scf_recaptcha_secret_key'] : '';

	$include_additional_information = isset($wp_scf_options['wp_scf_include_additional_information']) ? $wp_scf_options['wp_scf_include_additional_information'] : true;
	
	$nonce = isset($_POST['wp-scf-nonce']) ? sanitize_text_field($_POST['wp-scf-nonce']) : false;
	$key   = isset($_POST['wp-scf-key'])   ? sanitize_text_field($_POST['wp-scf-key'])   : false;

	$pass = true;
	
	if (empty($key)) return false;

	if ( ! empty( $_POST['website3dhhsy3'] ) ) {

		$pass = false;
		$notice = esc_html__( 'Invalid submission.', 'wp-scf' );
		$wp_scf_strings['error'] = '<p class="wp_scf_error">'. $notice .'</p>';

	}
	
	if (!wp_verify_nonce($nonce, 'wp-scf-nonce')) {
		
		$pass = false;
		$notice = esc_html__('Invalid nonce value! Please try again or contact the administrator for help.', 'wp-scf');
		$wp_scf_strings['error'] = '<p class="wp_scf_error">'. $notice .'</p>';
		
	}
	
	if (wp_scf_malicious_input($input_name) || wp_scf_malicious_input($input_email) || wp_scf_malicious_input($input_subject)) {
		
		$pass = false; 
		$notice  = esc_html__('Please do not include any of the following in the Name, Email, or Subject fields: ', 'wp-scf');
		$notice .= esc_html__('line breaks, &ldquo;mime-version&rdquo;, &ldquo;content-type&rdquo;, &ldquo;cc:&rdquo; &ldquo;to:&rdquo;', 'wp-scf');
		$wp_scf_strings['error'] = '<p class="wp_scf_error">'. $notice .'</p>';
		
	}
	
	if (empty($input_name)) {
		
		$pass = false;
		$wp_scf_strings['error'] = $error;
		$wp_scf_strings['name']  = '<input class="wp_scf_error" name="wp_scf_name" id="wp_scf_name" type="text" size="33" maxlength="99" ';
		$wp_scf_strings['name'] .= 'value="'. $input_name .'" '. $style .' placeholder="'. $name .'" />';
	}
	
	if (!is_email($input_email)) {
		
		$pass = false; 
		$wp_scf_strings['error'] = $error;
		$wp_scf_strings['email']  = '<input class="wp_scf_error" name="wp_scf_email" id="wp_scf_email" type="text" size="33" maxlength="99" ';
		$wp_scf_strings['email'] .= 'value="'. $input_email .'" '. $style .' placeholder="'. $email .'" />';
		
  }
    
  if ( ! empty( $wp_scf_options['wp_scf_input_confirm_email'] ) && ! empty( $wp_scf_options['wp_scf_confirm_mailtext'] ) && $input_email != $input_confirm_email ) {

    $pass = false;
    $wp_scf_strings['error'] = '<p class="wp_scf_error">' . esc_html__('Confirmation email needs to match email. ', 'wp-scf') . '</p>';
    $wp_scf_strings['confirm_email']  = '<input class="wp_scf_error" name="wp_scf_confirm_email" id="wp_scf_confirm_email" type="text" size="33" maxlength="99" ';
    $wp_scf_strings['confirm_email'] .= 'value="'. $input_confirm_email .'" '. $style .' placeholder="'. $confirm_email .'" />';
      
  }
	
	if (empty($show_subject) && empty($input_subject)) {
		
		$pass = false;
		$wp_scf_strings['error'] = $error;
		$wp_scf_strings['subject']  = '<input class="wp_scf_error" name="wp_scf_subject" id="wp_scf_subject" type="text" size="33" maxlength="99" ';
		$wp_scf_strings['subject'] .= 'value="'. $input_subject .'" '. $style .' placeholder="'. $subject .'" />';
		
	}

	if (empty($phone)) {
		
		$pass = false;
		$wp_scf_strings['error'] = $error;
		$wp_scf_strings['phone']  = '<input class="wp_scf_error" name="wp_scf_phone" id="wp_scf_phone" type="text" size="33" maxlength="99" ';
		$wp_scf_strings['phone'] .= 'value="'. $input_phone .'" '. $style .' placeholder="'. $phone .'" />';
	}
	
	if ($show_message && empty($input_message)) {
		
		$pass = false; 
		$wp_scf_strings['error'] = $error;
		$wp_scf_strings['message']  = '<textarea class="wp_scf_error" name="wp_scf_message" id="wp_scf_message" cols="33" rows="7" ';
		$wp_scf_strings['message'] .= $style .' placeholder="' . $message .'">'. $input_message .'</textarea>';
		
	}
	
	if ($show_captcha && (empty($input_response) || !wp_scf_spam_question($input_response))) {
		
		$pass = false;
		$wp_scf_strings['error'] = $spam;
		$wp_scf_strings['response']  = '<input class="wp_scf_error" name="wp_scf_response" id="wp_scf_response" type="text" size="33" maxlength="99" ';
		$wp_scf_strings['response'] .= 'value="'. $input_response .'" '. $style .' placeholder="'. $captcha .'" />';
		
	}
	
	if ( $recaptcha && ! $wp_scf_processed ) {

		// recaptcha v2
		if ( $recaptcha_version == 'v2' ) {

			if ( isset( $_POST['g-recaptcha-response'] ) ) {

				$captcha = $_POST['g-recaptcha-response'];
				$captcha_result = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
					'method' => 'POST',
					'body' => array(
						'secret' => $recaptcha_secret_key,
						'response' => $captcha,
					)
				));
				if ( is_wp_error( $captcha_result ) ) {
					$pass = false;
					$wp_scf_strings['error'] = '<p class="wp_scf_error">' . esc_html__('reCAPTCHA not filled in. ', 'wp-scf') . '</p>';
				} else {
					$captcha_response = json_decode( $captcha_result['body'], true );
					if ( ! $captcha_response['success'] ) {
						$pass = false;
						$wp_scf_strings['error'] = '<p class="wp_scf_error">' . esc_html__('reCAPTCHA not filled in. ', 'wp-scf') . '</p>';
					}
				}
	
			} else {
	
				$pass = false;
				$wp_scf_strings['error'] = '<p class="wp_scf_error">' . esc_html__('reCAPTCHA not filled in. ', 'wp-scf') . '</p>';
	
			}

		} elseif ( $recaptcha_version == 'v3' ) {

			if ( isset( $_POST['token'] ) ) {

				$captcha = $_POST['token'];
				$action = $_POST['action'];

				$captcha_result = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
					'method' => 'POST',
					'body' => array(
						'secret' => $recaptcha_secret_key,
						'response' => $captcha,
					)
				));
				if ( is_wp_error( $captcha_result ) ) {
					$pass = false;
					$wp_scf_strings['error'] = '<p class="wp_scf_error">' . esc_html__('reCAPTCHA not passed [error 1]. ', 'wp-scf') . '</p>';
				} else {
					$captcha_response = json_decode( $captcha_result['body'], true );
					if ( ! $captcha_response['success'] || ! $captcha_response['action'] == $action || $captcha_response['score'] < 0.5 ) {
						$pass = false;
						$wp_scf_strings['error'] = '<p class="wp_scf_error">' . esc_html__('reCAPTCHA not passed [error 2]. ', 'wp-scf') . '</p>';
					}
				}
	
			} else {
	
				$pass = false;
				$wp_scf_strings['error'] = '<p class="wp_scf_error">' . esc_html__('reCAPTCHA not filled in. ', 'wp-scf') . '</p>';
	
			}

		}

	}
	
	if ($pass == true) return true;
	
	return false;
	
}


/**
 * 
 * Shortcode for inputs
 */
function wp_scf_input_shortcode( $atts = array(), $content ) {

  $settings = shortcode_atts( array(
      'type' => 'text',
      'name' => '',
      'value' => '',
      'required' => '',
      'checked' => '',
  ), $atts );

  $extra_atts = '';
  
  if ( ! empty( $settings['required'] ) ) {
      $extra_atts .= ' required';
  }

  if ( ! empty( $settings['checked'] ) ) {
      $extra_atts .= ' checked';
  }

return '<input type="' . esc_attr( $settings['type'] ) . '" name="' . esc_attr( $settings['name'] ) . '" value="' . esc_attr( $settings['value'] ) . '"' . $extra_atts .' />';

} 
add_shortcode('wp_simple_contact_form_input', 'wp_scf_input_shortcode');


/**
* 
* Shortcode for date
*/
function wp_scf_date_shortcode( $atts = array(), $content = '' ) {

  if ( empty( $content ) ) {
      $content = get_option( 'date_format' );
  }

return current_time( $content );

} 
add_shortcode('wp_simple_contact_form_date', 'wp_scf_date_shortcode');

