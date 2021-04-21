<?php

function wp_scf_i18n_init() {
	
	load_plugin_textdomain('wp-scf', false, dirname(plugin_basename(__FILE__)) .'/languages/');
	
}
add_action('plugins_loaded', 'wp_scf_i18n_init');
