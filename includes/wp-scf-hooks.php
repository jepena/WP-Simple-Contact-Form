<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function wp_scf_plugin_action_links($links, $file) {
	global $wp_scf_path;
	
	if ($file == $wp_scf_path) {
		
		$wp_scf_links = '<a href="'. get_admin_url() .'options-general.php?page='. $wp_scf_path .'">'. esc_html__('Settings', 'wp-scf') .'</a>';
		
		array_unshift($links, $wp_scf_links);
		
	}
	
	return $links;
	
}
add_filter ('plugin_action_links', 'wp_scf_plugin_action_links', 10, 2);


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