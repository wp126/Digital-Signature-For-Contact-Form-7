<?php 

// Load Plugin in admin init
add_action( 'admin_init',  'DSCF7_load_plugin', 11 );
function DSCF7_load_plugin() {
    if ( ! ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) ) {
        set_transient( get_current_user_id() . 'dscf7error', 'message' );
    }
}


// Error returns when Contact Form 7 is not installed
add_action( 'admin_notices', 'DSCF7_install_error');
function DSCF7_install_error() {
    if ( get_transient( get_current_user_id() . 'dscf7error' ) ) {

        deactivate_plugins( plugin_basename( __FILE__ ) );

        delete_transient( get_current_user_id() . 'dscf7error' );

        echo '<div class="error"><p> This plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=contact+form+7">Contact Form 7</a> plugin installed and activated.</p></div>';
    }
}