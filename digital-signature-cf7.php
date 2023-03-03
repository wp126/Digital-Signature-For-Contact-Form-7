<?php
/**
* Plugin Name: Digital Signature For Contact Form 7
* Description: This plugin allows Digital Signature For Contact Form 7 plugin.
* Version: 1.0
* Copyright: 2023
* Text Domain: digital-signature-for-contact-form-7
* Domain Path: /languages 
*/


if (!defined('ABSPATH')) {
    die('-1');
}


// define for base name
define('DSCF7_BASE_NAME', plugin_basename(__FILE__));


// define for plugin file
define('DSCF7_PLUGIN_FILE', __FILE__);


// define for plugin dir path
define('DSCF7_PLUGIN_DIR',plugins_url('', __FILE__));



// Include function files
include_once('main/backend/digital-signature-backend-cf7.php');
include_once('main/resources/digital-signature-installation-require.php');
include_once('main/resources/digital-signature-language.php');
include_once('main/resources/digital-signature-load-js-css.php');

function DSCF7_support_and_rating_links( $links_array, $plugin_file_name, $plugin_data, $status ) {
    if ($plugin_file_name !== plugin_basename(__FILE__)) {
      return $links_array;
    }

    $links_array[] = '<a href="https://www.plugin999.com/support/">'. __('Support', 'digital-signature-for-contact-form-7') .'</a>';
    $links_array[] = '<a href="https://wordpress.org/support/plugin/digital-signature-for-contact-form-7/reviews/?filter=5">'. __('Rate the plugin ★★★★★', 'digital-signature-for-contact-form-7') .'</a>';

    return $links_array;

}
add_filter( 'plugin_row_meta', 'DSCF7_support_and_rating_links', 10, 4 );