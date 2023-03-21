<?php
declare( strict_types=1 );

/**
 * An Whatever

 * @package An_Whatever
 * @author  Whatever Forever
 * @license GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       An Whatever
 * Description:       A plugin to show your skills.
 * Version:           1.0.0
 * Requires at least: 6.1
 * Requires PHP:      8.0
 * Author:            Whatever Forever
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       an-whatever
 *
 * @package An_Whatever
 */

/*
"An Whatever" is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

"An Whatever" is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with "An Whatever". If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

namespace An_Whatever;

// Exit if accessed directly.
if ( ! defined( '\WPINC' ) ) {
	die( 'Action denied.' );
}

/**
 * Load text domain.
 *
 * @since 1.0.0
 */
function load_plugin_textdomain() {
	\load_plugin_textdomain( 'an-whatever', false, \basename( \dirname( __FILE__ ) ) . '/languages/' );
}
\add_action( 'plugins_loaded', 'load_plugin_textdomain' );

// Require file with defined plugin constants.
require_once \plugin_dir_path( __FILE__ ) . 'an-whatever-constants.php';

/*
 * Load class file that responsible for defining all helper methods
 * and plugin wide variables.
 */
require_once \An_Whatever\PLUGIN_PATH . 'includes/An_Whatever_Helpers.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/An_Whatever_Activator.php
 *
 * @since 1.0.0
 */
function an_whatever_activate() {
	require_once \An_Whatever\PLUGIN_PATH . 'includes/An_Whatever_Activator.php';

	\An_Whatever\An_Whatever_Activator::activate();
}
\register_activation_hook( __FILE__, __NAMESPACE__ . '\\an_whatever_activate' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/An_Whatever_Deactivator.php
 *
 * @since 1.0.0
 */
function an_whatever_deactivate() {
	require_once \An_Whatever\PLUGIN_PATH . 'includes/An_Whatever_Deactivator.php';

	\An_Whatever\An_Whatever_Deactivator::deactivate();
}
\register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\an_whatever_deactivate' );

/*
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once \An_Whatever\PLUGIN_PATH . 'includes/An_Whatever.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function an_whatever_run() {
	$plugin = new \An_Whatever\An_Whatever();
	$plugin->run();
}

an_whatever_run();
