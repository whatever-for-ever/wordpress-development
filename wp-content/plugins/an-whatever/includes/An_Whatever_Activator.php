<?php
declare( strict_types=1 );

/**
 * The file that defines the An_Whatever_Activator class file
 *
 * @since 1.0.0
 *
 * @package An_Whatever
 */

namespace An_Whatever;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since   1.0.0
 * @package An_Whatever
 * @author  Whatever Forever
 */
class An_Whatever_Activator {

	/**
	 * Plugin activation.
	 *
	 * During plugin activation for `administrator` and `editor` roles
	 * are assigned the management capabilities of the plugin.
	 * The rewrite rules are removed and re-created.
	 *
	 * @since 1.0.0
	 */
	public static function activate() {
		if ( ! \current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// $h stands as $helpers.
		$h = \An_Whatever\An_Whatever_Helpers::get_instance();

		$admin_role = \get_role( 'administrator' );

		if ( ! empty( $admin_role ) ) {
			$admin_role->add_cap( $h::get_plugin_required_cap() );
		}

		$editor_role = get_role( 'editor' );

		if ( ! empty( $editor_role ) ) {
			$editor_role->add_cap( $h::get_plugin_required_cap() );
		}

		\flush_rewrite_rules();
	}

}
