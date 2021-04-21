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

function wp_scf_render_form() {
	
	global $wp_scf_plugin, $wp_scf_options, $wp_scf_path, $wp_scf_homeurl, $wp_scf_version; ?>
		
	<?php 
		if ( ! isset( $wp_scf_options['wp_scf_gdpr_message'] ) ) {
			$wp_scf_options['wp_scf_gdpr_message'] = __('I consent to having this website store my submitted information so they can respond to my inquiry. See our privacy policy to learn more how we use data.', 'wp-scf');
		}

		if ( ! isset( $wp_scf_options['wp_scf_gdpr_position'] ) ) {
			$wp_scf_options['wp_scf_gdpr_position'] = 'after_submit';
		}

		if ( ! isset( $wp_scf_options['wp_scf_submittext'] ) ) {
			$wp_scf_options['wp_scf_submittext'] = esc_attr__('Send email', 'wp-scf');
		}

		if ( ! isset( $wp_scf_options['wp_scf_include_additional_information'] ) ) {
			$wp_scf_options['wp_scf_include_additional_information'] = false;
    }
        
    if ( ! isset( $wp_scf_options['wp_scf_before_button'] ) ) {
			$wp_scf_options['wp_scf_before_button'] = '';
    }

		if ( ! isset( $wp_scf_options['wp_scf_recaptcha_version'] ) ) {
			$wp_scf_options['wp_scf_recaptcha_version'] = 'v2';
		}
		
		if ( ! isset( $wp_scf_options['wp_scf_recaptcha_site_key'] ) ) {
			$wp_scf_options['wp_scf_recaptcha_site_key'] = false;
		}
		
		if ( ! isset( $wp_scf_options['wp_scf_recaptcha_secret_key'] ) ) {
			$wp_scf_options['wp_scf_recaptcha_secret_key'] = false;
		}

	?>

	<div id="wp-scf-plugin-options" class="wrap">
		
		<h1><?php echo $wp_scf_plugin; ?> <small><?php echo 'v'. $wp_scf_version; ?></small></h1>

		<form method="post" action="options.php">
			<?php settings_fields('wp_scf_plugin_options'); ?>

      <ul id="tabs" class="tabs">
        <li class="active-tab">General Settings</li>
        <li>Restore Defaults</li>
        <li>Shortcode and Template Tag</li>
        <li>WP-SCF Database</li>
      </ul>
			<div class="metabox-holder">
				<div class="meta-box-sortables ui-sortable tabs-content">

          <!-- 1st Tab -->
					<div id="wp-scf-panel-primary" class="postbox">
						<h2><?php esc_html_e('Plugin Options', 'wp-scf'); ?></h2>
						<div class="toggle<?php if (!isset($_GET["settings-updated"])) { echo ''; } ?>">
							<p><?php esc_html_e('Configure and customize the contact form.', 'wp-scf'); ?></p>
							
							<h3><?php esc_html_e('General Options', 'wp-scf'); ?></h3>
							<div class="wp-scf-table-wrap">
								<table class="widefat wp-scf-table">
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_name]"><?php esc_html_e('Your Name', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_name]" value="<?php echo $wp_scf_options['wp_scf_name']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Name of person that will receive messages', 'wp-scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_email]"><?php esc_html_e('Your Email', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_email]" value="<?php echo $wp_scf_options['wp_scf_email']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Email of person that will receive messages', 'wp-scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_from]"><?php esc_html_e('From Address', 'wp-scf'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="wp_scf_options[wp_scf_from]" value="<?php echo $wp_scf_options['wp_scf_from']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Here you may customize the address used for the &ldquo;From&rdquo; header (see plugin FAQs for info)', 'wp-scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_website]"><?php esc_html_e('Your Website', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_website]" value="<?php echo $wp_scf_options['wp_scf_website']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('The name of your website', 'wp-scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_subject]"><?php esc_html_e('Default Subject', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_subject]" value="<?php echo $wp_scf_options['wp_scf_subject']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Default subject (or leave blank to display the subject field). {name} will be dynamically replaced by the value of the name field.', 'wp-scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_gdpr_message]"><?php esc_html_e('GDPR Message', 'wp-scf'); ?></label></th>
										<td>
											<textarea class="large-text code" rows="3" cols="50" name="wp_scf_options[wp_scf_gdpr_message]"><?php echo esc_textarea($wp_scf_options['wp_scf_gdpr_message']); ?></textarea>
										<div class="wp-scf-item-caption"><?php esc_html_e('GDPR message ( or leave blank not to display it )', 'wp-scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_gdpr_position]"><?php esc_html_e('GDPR Message - Position', 'wp-scf'); ?></label></th>
										<td>
											<select name="wp_scf_options[wp_scf_gdpr_position]">
												<option value="before_submit" <?php selected( 'before_submit', sanitize_text_field( $wp_scf_options['wp_scf_gdpr_position'] ), true ); ?>><?php esc_html_e('Before Submit Button', 'wp-scf'); ?></option>
												<option value="after_submit" <?php selected( 'after_submit', sanitize_text_field( $wp_scf_options['wp_scf_gdpr_position'] ), true ); ?>><?php esc_html_e('After Submit Button', 'wp-scf'); ?></option>
											</select>
										<div class="wp-scf-item-caption"><?php esc_html_e('The location/position of the GDPR message.', 'wp-scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_enable_message]"><?php esc_html_e('Show Message Field', 'wp-scf'); ?></label></th>
										<td><input type="checkbox" name="wp_scf_options[wp_scf_enable_message]" value="1" <?php if (isset($wp_scf_options['wp_scf_enable_message'])) { checked('1', $wp_scf_options['wp_scf_enable_message']); } ?> /> 
										<span class="wp-scf-item-caption"><?php esc_html_e('Enable/display the message field', 'wp-scf'); ?></span></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_carbon]"><?php esc_html_e('Enable Carbon Copies', 'wp-scf'); ?></label></th>
										<td><input type="checkbox" name="wp_scf_options[wp_scf_carbon]" value="1" <?php if (isset($wp_scf_options['wp_scf_carbon'])) { checked('1', $wp_scf_options['wp_scf_carbon']); } ?> /> 
										<span class="wp-scf-item-caption"><?php esc_html_e('Send a carbon copy to the sender', 'wp-scf'); ?></span></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_success_details]"><?php esc_html_e('Success Message', 'wp-scf'); ?></label></th>
										<td><input type="checkbox" name="wp_scf_options[wp_scf_success_details]" value="1" <?php if (isset($wp_scf_options['wp_scf_success_details'])) { checked('1', $wp_scf_options['wp_scf_success_details']); } ?> /> 
										<span class="wp-scf-item-caption"><?php esc_html_e('Display verbose success message', 'wp-scf'); ?></span></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_mail_function]"><?php esc_html_e('PHP Mail Function', 'wp-scf'); ?></label></th>
										<td><input type="checkbox" name="wp_scf_options[wp_scf_mail_function]" value="1" <?php if (isset($wp_scf_options['wp_scf_mail_function'])) { checked('1', $wp_scf_options['wp_scf_mail_function']); } ?> /> 
										<span class="wp-scf-item-caption"><?php esc_html_e('Use PHP&rsquo;s', 'wp-scf'); ?> <code>mail()</code> <?php esc_html_e('instead of WP&rsquo;s', 'wp-scf'); ?> <code>wp_mail()</code></span></td>
									</tr>

                  <tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_smtp_function]"><?php esc_html_e('SMTP Mail Function', 'wp-scf'); ?></label></th>
										<td><input type="checkbox" name="wp_scf_options[wp_scf_smtp_function]" value="1" <?php if (isset($wp_scf_options['wp_scf_smtp_function'])) { checked('1', $wp_scf_options['wp_scf_mail_function']); } ?> /> 
										<span class="wp-scf-item-caption"><?php esc_html_e('Use SMTP', 'wp-scf'); ?> <?php esc_html_e('instead of WP&rsquo;s', 'wp-scf'); ?> <code>wp_mail()</code></span></td>
									</tr>

								</table>
							</div>
							
							<h3><?php esc_html_e('Antispam', 'wp-scf'); ?></h3>
							<div class="wp-scf-table-wrap">
								<table class="widefat wp-scf-table">
									<!-- reCAPTCHA start -->
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_recaptcha]"><?php esc_html_e('Enable reCAPTCHA', 'wp-scf'); ?></label></th>
										<td><input type="checkbox" name="wp_scf_options[wp_scf_recaptcha]" value="1" <?php if (isset($wp_scf_options['wp_scf_recaptcha'])) { checked('1', $wp_scf_options['wp_scf_recaptcha']); } ?> /> 
										<span class="wp-scf-item-caption"><?php esc_html_e('Enable reCAPTCHA', 'wp-scf'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_recaptcha_version]"><?php esc_html_e('reCAPTCHA Version', 'wp-scf'); ?></label></th>
										<td>
											<select name="wp_scf_options[wp_scf_recaptcha_version]">
												<option value="v2" <?php selected( 'v2', sanitize_text_field( $wp_scf_options['wp_scf_recaptcha_version'] ), true ); ?>><?php esc_html_e('V2', 'wp-scf'); ?></option>
												<option value="v3" <?php selected( 'v3', sanitize_text_field( $wp_scf_options['wp_scf_recaptcha_version'] ), true ); ?>><?php esc_html_e('V3', 'wp-scf'); ?></option>
											</select>
										<div class="wp-scf-item-caption"><?php esc_html_e('reCAPTCHA version', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_recaptcha_site_key]"><?php esc_html_e('reCAPTCHA site key', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_recaptcha_site_key]" value="<?php echo $wp_scf_options['wp_scf_recaptcha_site_key']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('reCAPTCHA site key', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_recaptcha_secret_key]"><?php esc_html_e('reCAPTCHA secret key', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_recaptcha_secret_key]" value="<?php echo $wp_scf_options['wp_scf_recaptcha_secret_key']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('reCAPTCHA secret key', 'wp-scf'); ?></div></td>
									</tr>
									<!-- reCAPTCHA end -->
								</table>
							</div>
							
							<h3><?php esc_html_e('Field Labels &amp; Placeholders', 'wp-scf'); ?></h3>
              <p><?php esc_html_e('If the input placeholder field is empty then it will not show on frontpage the input even the label field has a value.', 'wp-scf'); ?></p>
							<div class="wp-scf-table-wrap">
								<table class="widefat wp-scf-table">
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_nametext]"><?php esc_html_e('Name Label', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_nametext]" value="<?php echo $wp_scf_options['wp_scf_nametext']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Label for the Name field', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_input_name]"><?php esc_html_e('Name Placeholder', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_input_name]" value="<?php echo $wp_scf_options['wp_scf_input_name']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Placeholder for the Name field', 'wp-scf'); ?></div></td>
									</tr>
									
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_mailtext]"><?php esc_html_e('Email Label', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_mailtext]" value="<?php echo $wp_scf_options['wp_scf_mailtext']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Label for the Email field', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_input_email]"><?php esc_html_e('Email Placeholder', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_input_email]" value="<?php echo $wp_scf_options['wp_scf_input_email']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Placeholder for the Email field', 'wp-scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_confirm_mailtext]"><?php esc_html_e('Confirm Email Label', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_confirm_mailtext]" value="<?php echo $wp_scf_options['wp_scf_confirm_mailtext']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Label for the Confirm Email field. Leave empty to not display the field.', 'wp-scf'); ?></div></td>
									</tr>
                                    <tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_input_confirm_email]"><?php esc_html_e('Confirm Email Placeholder', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_input_confirm_email]" value="<?php echo $wp_scf_options['wp_scf_input_confirm_email']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Placeholder for the Confirm Email field. Leave empty to not display the field.', 'wp-scf'); ?></div></td>
									</tr>
									
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_phonetext]"><?php esc_html_e('Phone Label', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_phonetext]" value="<?php echo $wp_scf_options['wp_scf_phonetext']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Label for the Phone field', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_input_phone]"><?php esc_html_e('Phone Placeholder', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_input_phone]" value="<?php echo $wp_scf_options['wp_scf_input_phone']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Placeholder for the Phone field', 'wp-scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_subjtext]"><?php esc_html_e('Subject Label', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_subjtext]" value="<?php echo $wp_scf_options['wp_scf_subjtext']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Label for the Subject field', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_input_subject]"><?php esc_html_e('Subject Placeholder', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_input_subject]" value="<?php echo $wp_scf_options['wp_scf_input_subject']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Placeholder for the Subject field', 'wp-scf'); ?></div></td>
									</tr>
									
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_messtext]"><?php esc_html_e('Message Label', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_messtext]" value="<?php echo $wp_scf_options['wp_scf_messtext']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Label for the Message field', 'wp-scf'); ?></div></td>
									</tr>

									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_input_message]"><?php esc_html_e('Message Placeholder', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_input_message]" value="<?php echo $wp_scf_options['wp_scf_input_message']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Placeholder for the Message field', 'wp-scf'); ?></div></td>
									</tr>
									
                  <tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_submittext]"><?php esc_html_e('Submit Label', 'wp-scf'); ?></label></th>
										<td><input type="text" class="regular-text" size="50" maxlength="200" name="wp_scf_options[wp_scf_submittext]" value="<?php echo $wp_scf_options['wp_scf_submittext']; ?>" />
										<div class="wp-scf-item-caption"><?php esc_html_e('Label for the submit button', 'wp-scf'); ?></div></td>
									</tr>

								</table>
							</div>
							
							<h3><?php esc_html_e('Success &amp; Error Messages', 'wp-scf'); ?></h3>
							<div class="wp-scf-table-wrap">
								<table class="widefat wp-scf-table">
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_success]"><?php esc_html_e('Success Message', 'wp-scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="wp_scf_options[wp_scf_success]"><?php echo esc_textarea($wp_scf_options['wp_scf_success']); ?></textarea>
										<div class="wp-scf-item-caption"><?php esc_html_e('Message displayed when the form is submitted successfully', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_error]"><?php esc_html_e('Error Message', 'wp-scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="wp_scf_options[wp_scf_error]"><?php echo esc_textarea($wp_scf_options['wp_scf_error']); ?></textarea>
										<div class="wp-scf-item-caption"><?php esc_html_e('Message displayed when a required field is empty', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_spam]"><?php esc_html_e('Incorrect Response', 'wp-scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="wp_scf_options[wp_scf_spam]"><?php echo esc_textarea($wp_scf_options['wp_scf_spam']); ?></textarea>
										<div class="wp-scf-item-caption"><?php esc_html_e('Message displayed when the challenge question is answered incorrectly', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_style]"><?php esc_html_e('Error Field Attributes', 'wp-scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="wp_scf_options[wp_scf_style]"><?php echo esc_textarea($wp_scf_options['wp_scf_style']); ?></textarea>
										<div class="wp-scf-item-caption"><?php esc_html_e('Optional custom attributes for any field that returns an error', 'wp-scf'); ?></div></td>
									</tr>
								</table>
							</div>
							
							<h3><?php esc_html_e('Custom Content', 'wp-scf'); ?></h3>
							<div class="wp-scf-table-wrap">
								<table class="widefat wp-scf-table">
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_preform]"><?php esc_html_e('Before Form', 'wp-scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="wp_scf_options[wp_scf_preform]"><?php echo esc_textarea($wp_scf_options['wp_scf_preform']); ?></textarea>
										<div class="wp-scf-item-caption"><?php esc_html_e('Optional markup to appear *before* the contact form', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_appform]"><?php esc_html_e('After Form', 'wp-scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="wp_scf_options[wp_scf_appform]"><?php echo esc_textarea($wp_scf_options['wp_scf_appform']); ?></textarea>
										<div class="wp-scf-item-caption"><?php esc_html_e('Optional markup to appear *after* the contact form', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_prepend]"><?php esc_html_e('Before Results', 'wp-scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="wp_scf_options[wp_scf_prepend]"><?php echo esc_textarea($wp_scf_options['wp_scf_prepend']); ?></textarea>
										<div class="wp-scf-item-caption"><?php esc_html_e('Optional markup to appear *before* the success message', 'wp-scf'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_append]"><?php esc_html_e('After Results', 'wp-scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="wp_scf_options[wp_scf_append]"><?php echo esc_textarea($wp_scf_options['wp_scf_append']); ?></textarea>
										<div class="wp-scf-item-caption"><?php esc_html_e('Optional markup to appear *after* the success message', 'wp-scf'); ?></div></td>
									</tr>
                                    <tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_before_button]"><?php esc_html_e('Before Submit Button', 'wp-scf'); ?></label></th>
										<td><textarea class="large-text code" rows="3" cols="55" name="wp_scf_options[wp_scf_before_button]"><?php echo esc_textarea($wp_scf_options['wp_scf_before_button']); ?></textarea>
										<div class="wp-scf-item-caption"><?php esc_html_e('Optional markup to appear *before* the submit button', 'wp-scf'); ?></div></td>
									</tr>
								</table>
							</div>

              <h3><?php esc_html_e('Custom Styles', 'wp-scf'); ?></h3>
							<div class="wp-scf-table-wrap">
								<table class="widefat wp-scf-table">
									<tr>
										<th scope="row"><label class="description" for="wp_scf_options[wp_scf_css]"><?php esc_html_e('Custom CSS', 'wp-scf'); ?></label></th>
										<td>
											<textarea class="large-text code" rows="8" cols="50" name="wp_scf_options[wp_scf_css]"><?php echo esc_textarea($wp_scf_options['wp_scf_css']); ?></textarea>
											<div class="wp-scf-item-caption">
												<?php esc_html_e('Optional CSS to style the contact form. Do not include any', 'wp-scf'); ?> <code>&lt;style&gt;</code> <?php esc_html_e('tags.', 'wp-scf'); ?> 
											</div>
										</td>
									</tr>
								</table>
							</div>
							
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'wp-scf'); ?>" />
						</div>
					</div>

					<!-- 2nd Tab -->
					<div id="wp-scf-restore-settings" class="postbox">
						<h2><?php esc_html_e('Restore Defaults', 'wp-scf'); ?></h2>
						<div class="toggle<?php if (!isset($_GET["settings-updated"])) { echo ''; } ?>">
							<p>
								<input name="wp_scf_options[default_options]" type="checkbox" value="1" id="wp-scf_restore_defaults" <?php if (isset($wp_scf_options['default_options'])) { checked('1', $wp_scf_options['default_options']); } ?> /> 
								<label class="description" for="wp_scf_options[default_options]"><?php esc_html_e('Restore default options upon plugin deactivation/reactivation.', 'wp-scf'); ?></label>
							</p>
							<p>
								<small>
									<strong><?php esc_html_e('Tip:', 'wp-scf'); ?></strong> 
									<?php esc_html_e('leave this option unchecked to remember your settings.', 'wp-scf'); ?> 
									<?php esc_html_e('Or, to go ahead and restore all default options, check the box, save your settings, and then deactivate/reactivate the plugin.', 'wp-scf'); ?>
								</small>
							</p>
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'wp-scf'); ?>" />
						</div>
					</div>

					<!-- 3rd Tab -->
					<div id="wp-scf-panel-secondary" class="postbox">
						<h2><?php esc_html_e('Shortcode &amp; Template Tag', 'wp-scf'); ?></h2>
						<div class="toggle">
							
							<h3><?php esc_html_e('Shortcode', 'wp-scf'); ?></h3>
							<p><?php esc_html_e('Use this shortcode to display the contact form on any WP Post or Page:', 'wp-scf'); ?></p>
							<p><code class="wp-scf-code">[simple_contact_form]</code></p>
							
							<h3><?php esc_html_e('Template tag', 'wp-scf'); ?></h3>
							<p><?php esc_html_e('Use this template tag to display the form anywhere in your theme template:', 'wp-scf'); ?></p>
							<p><code class="wp-scf-code">&lt;?php if (function_exists('wp_simple_contact_form')) wp_simple_contact_form(); ?&gt;</code></p>
							
						</div>
					</div>

          <!-- 4th Tab -->
					<div id="wp-scf-panel-secondary" class="postbox">
            <h2><?php esc_html_e('WP Simple Contact From - Database', 'wp-scf'); ?></h2>
            <div class="toggle">
              <h3>Coming Soon...</h3>
            </div>
          </div>
					
				</div>
			</div>
			
		</form>
	</div>
	

<?php }