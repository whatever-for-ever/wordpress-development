<?php
declare( strict_types=1 );

/**
 * The file that defines the An_Whatever_Deactivator class file
 *
 * @since 1.0.0
 *
 * @package An_Whatever
 */

namespace An_Whatever;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since   1.0.0
 * @package An_Whatever
 * @author  Whatever Forever
 */
class An_Whatever_Deactivator {

	/**
	 * Plugin deactivation.
	 *
	 * @since 1.0.0
	 */
	public static function deactivate() {

		// $h stands as $helpers.
		$h = \An_Whatever\An_Whatever_Helpers::get_instance();

		// Deactivation is NOT uninstall!
		if ( ! \current_user_can( 'activate_plugins' ) || ! \current_user_can( $h::get_plugin_required_cap() ) ) {
			return;
		}
	}

}
