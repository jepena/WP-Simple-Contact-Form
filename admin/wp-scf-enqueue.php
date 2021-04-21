<?php

function enqueue_assets() {
  wp_enqueue_style( 'wp-scf-style', plugin_dir_url( __FILE__ ) . 'styles/index.css', array(), '1.0.0', 'all' );

  wp_enqueue_script( 'wp-scf-script', plugin_dir_url( __FILE__ ) . 'scripts/index.js', array('jquery'), false, true );

}

add_action( 'admin_enqueue_scripts', 'enqueue_assets' );
