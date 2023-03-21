<?php
declare( strict_types=1 );

/**
 * The file that defines the An_Whatever_i18n class file
 *
 * @since 1.0.0
 *
 * @package An_Whatever
 */

namespace An_Whatever;

// phpcs:disable PEAR.NamingConventions.ValidClassName.Invalid

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since   1.0.0
 * @package An_Whatever
 * @author  Whatever Forever
 */
class An_Whatever_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {
		\load_plugin_textdomain(
			'an-whatever',
			false,
			\dirname( \dirname( \plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

}
