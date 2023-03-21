<?php
declare( strict_types=1 );

/**
 * 'An Whatever' plugin constants file.
 *
 * @package An_Whatever
 */

namespace An_Whatever;

// Exit if accessed directly.
if ( ! defined( '\WPINC' ) ) {
	die( 'Action denied.' );
}

if ( ! \defined( '\An_Whatever\PLUGIN_VERSION' ) ) {
	/**
	 * Currently plugin version.
	 *
	 * Start at version 1.0.0 and use SemVer - https://semver.org
	 * RUpdate it as you release new versions.
	 *
	 * The getter is set in the 'includes/An_Whatever_Helpers.php' file.
	 */
	\define( 'An_Whatever\PLUGIN_VERSION', '1.0.0' );
}

if ( ! \defined( '\An_Whatever\PLUGIN_NAME' ) ) {
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * The name is also used for the translation text domain.
	 * The getter is set in the 'includes/An_Whatever_Helpers.php' file.
	 */
	\define( 'An_Whatever\PLUGIN_NAME', 'an-whatever' );
}

if ( ! \defined( '\An_Whatever\PLUGIN_PREFIX' ) ) {
	/**
	 * The unique prefix of this plugin.
	 *
	 * The getter is set in the 'includes/An_Whatever_Helpers.php' file.
	 */
	\define( 'An_Whatever\PLUGIN_PREFIX', 'an_whatever' );
}

if ( ! \defined( '\An_Whatever\REQUIRED_CAP' ) ) {
	/**
	 * The name of the management capability of this plugin.
	 *
	 * The getter is set in the 'includes/An_Whatever_Helpers.php' file.
	 */
	\define( 'An_Whatever\REQUIRED_CAP', \An_Whatever\PLUGIN_PREFIX . '_plugin_manage' );
}

if ( ! \defined( '\An_Whatever\PLUGIN_URL' ) ) {
	/**
	 * The URL path of the directory that contains the plugin (with trailing slash).
	 */
	\define( 'An_Whatever\PLUGIN_URL', \plugin_dir_url( __FILE__ ) );
}

if ( ! \defined( '\An_Whatever\PLUGIN_PATH' ) ) {
	/**
	 * The filesystem PATH of the directory that contains the plugin (with trailing slash).
	 */
	\define( 'An_Whatever\PLUGIN_PATH', \plugin_dir_path( __FILE__ ) );
}
