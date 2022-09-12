<?php

// Load JS and CSS files on Frontend
add_action( 'wp_enqueue_scripts',   'DSCF7_load_script_style');
function DSCF7_load_script_style() {
 	wp_enqueue_script( 'DSCF7-front-js', DSCF7_PLUGIN_DIR . '/assets/js/front.js', array("jquery"), false, '1.0.0', true );
 	wp_enqueue_style( 'DSCF7-front-css',DSCF7_PLUGIN_DIR . '/assets/css/front.css', false, '1.0.0' );
  	wp_enqueue_script( 'DSCF7-jquery-sign-js', DSCF7_PLUGIN_DIR .'/assets/js/digital_signature_pad.js', false, '1.0.0' );
}


// Load JS and CSS files on Admin
add_action( 'admin_enqueue_scripts',  'DSCF7_load_script_style_admin');
function DSCF7_load_script_style_admin() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker-alpha', DSCF7_PLUGIN_DIR . '/assets/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0.0', true );
}
