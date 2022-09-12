<?php
/**
* Plugin Name: Digital Signature For Contact Form 7
* Description: This plugin allows Digital Signature For Contact Form 7 plugin.
* Version: 1.0
* Copyright: 2022
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
