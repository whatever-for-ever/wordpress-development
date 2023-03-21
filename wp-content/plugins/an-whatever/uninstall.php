<?php
declare( strict_types=1 );

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @since 1.0.0
 *
 * @package An_Whatever
 */

// Require file with defined plugin constants.
require_once \plugin_dir_path( __FILE__ ) . 'an-whatever-constants.php';

/*
 * Load class file that responsible for defining all helper methods
 * and plugin wide variables.
 */
require_once \An_Whatever\PLUGIN_PATH . 'includes/An_Whatever_Helpers.php';

$h = \An_Whatever\An_Whatever_Helpers::get_instance();

$plugin_prefix = $h::get_plugin_prefix();
$required_cap  = $h::get_plugin_required_cap();

// If uninstall not called from WordPress,
// if no uninstall action,
// if not this plugin,
// if no caps,
// then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' )
		|| empty( $_REQUEST )
		|| ! isset( $_REQUEST['plugin'] )
		|| ! isset( $_REQUEST['action'] )
		|| 'an-whatever/an-whatever.php' !== $_REQUEST['plugin']
		|| 'delete-plugin' !== $_REQUEST['action']
		|| ! check_ajax_referer( 'updates', '_ajax_nonce' )
		|| ! current_user_can( 'activate_plugins' )
		|| ! current_user_can( $required_cap )
) {
	die( 'Action denied.' );
}

// delete_option( $plugin_prefix . '_plugin_options' ); // If set, remove saved options from the database.

$admin_role = get_role( 'administrator' );

if ( ! empty( $admin_role ) ) {
	$admin_role->remove_cap( $required_cap );
}

$editor_role = get_role( 'editor' );

if ( ! empty( $editor_role ) ) {
	$editor_role->remove_cap( $required_cap );
}
