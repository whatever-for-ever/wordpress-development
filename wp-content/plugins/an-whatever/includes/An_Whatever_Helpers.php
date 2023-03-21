<?php
declare( strict_types=1 );

/**
 * The file that defines the An_Whatever_Helpers class file
 *
 * @since 1.0.0
 *
 * @package An_Whatever
 */

namespace An_Whatever;

// Require file with defined plugin constants.
require_once \dirname( \plugin_dir_path( __FILE__ ) ) . '/an-whatever-constants.php';

/**
 * Singleton class with collection of helper methods.
 *
 * @since   1.0.0
 * @package An_Whatever
 * @author  Whatever Forever
 */
final class An_Whatever_Helpers {

	/**
	 * A reference to an instance of the \An_Whatever\An_Whatever_Helpers class.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @var \An_Whatever\An_Whatever_Helpers $instance A reference to an instance of the \An_Whatever\An_Whatever_Helpers class.
	 */
	private static $instance;

	/**
	 * Returns an instance of the An_Whatever_Helpers class.
	 *
	 * @return \An_Whatever\An_Whatever_Helpers An instance of the An_Whatever_Helpers class.
	 */
	public static function get_instance(): \An_Whatever\An_Whatever_Helpers {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Protected constructor blocks the creation of new class instances
	 * via the new keyword outside this class.
	 */
	private function __construct() {}

	/**
	 * The private _clone method blocks the cloning of class instances.
	 */
	private function __clone() {}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @throws \Exception If \An_Whatever\PLUGIN_NAME constant not set.
	 *
	 * @since 1.0.0
	 *
	 * @return string The string used to uniquely identify this plugin.
	 */
	public static function get_plugin_name(): string {
		if ( ! defined( '\An_Whatever\PLUGIN_NAME' ) ) {
			maybe_display_error(
				__(
					'The \An_Whatever\PLUGIN_NAME constant must be set. Please set the required constant in the an-whatever-constants.php file.',
					'an-whatever'
				)
			);
		}

		return \An_Whatever\PLUGIN_NAME;
	}

	/**
	 * The unique prefix of the plugin used to uniquely prefix technical functions.
	 *
	 * @throws \Exception If \An_Whatever\PLUGIN_PREFIX constant not set.
	 *
	 * @since 1.0.0
	 *
	 * @return string The string used to uniquely prefix technical functions of this plugin.
	 */
	public static function get_plugin_prefix(): string {
		if ( ! defined( '\An_Whatever\PLUGIN_PREFIX' ) ) {
			maybe_display_error(
				__(
					'The \An_Whatever\PLUGIN_PREFIX constant must be set. Please set the required constant in the an-whatever-constants.php file.',
					'an-whatever'
				)
			);
		}

		return \An_Whatever\PLUGIN_PREFIX;
	}

	/**
	 * The name of the management capability of this plugin.
	 *
	 * @throws \Exception If \An_Whatever\REQUIRED_CAP constant not set.
	 *
	 * @since 1.0.0
	 *
	 * @return string The name of the management capability of this plugin.
	 */
	public static function get_plugin_required_cap(): string {
		if ( ! defined( '\An_Whatever\REQUIRED_CAP' ) ) {
			maybe_display_error(
				__(
					'The \An_Whatever\REQUIRED_CAP constant must be set. Please set the required constant in the an-whatever-constants.php file.',
					'an-whatever'
				)
			);
		}

		return \An_Whatever\REQUIRED_CAP;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @throws \Exception If \An_Whatever\PLUGIN_VERSION constant not set.
	 *
	 * @since 1.0.0
	 *
	 * @return string The current version of the plugin.
	 */
	public static function get_version(): string {
		if ( ! defined( '\An_Whatever\PLUGIN_VERSION' ) ) {
			maybe_display_error(
				__(
					'The \An_Whatever\PLUGIN_VERSION constant must be set. Please set the required constant in the an-whatever-constants.php file.',
					'an-whatever'
				)
			);
		}

		return \An_Whatever\PLUGIN_VERSION;
	}

	/**
	 * Get the full filesystem path to the file in plugin folder.
	 *
	 * @param string $relative_path Relative file path for the plugin folder.
	 *
	 * @throws \Exception If \An_Whatever\PLUGIN_PATH constant not set.
	 * @throws \Exception If file not exists.
	 *
	 * @since 1.0.0
	 *
	 * @return string The full filesystem path to the file in plugin folder.
	 */
	public static function get_file_path( string $relative_path ): string {
		if ( ! defined( '\An_Whatever\PLUGIN_PATH' ) ) {
			maybe_display_error(
				__(
					'The \An_Whatever\PLUGIN_PATH constant must be set. Please set the required constant in the an-whatever-constants.php file.',
					'an-whatever'
				)
			);
		}

		$full_path = \An_Whatever\PLUGIN_PATH . \ltrim( $relative_path, \DIRECTORY_SEPARATOR );

		if ( ! \file_exists( $full_path ) ) {
			maybe_display_error(
				\sprintf(
					// translators: %s file path string.
					\__( 'The %s file does not exist.', 'an-whatever' ),
					$full_path
				)
			);
		}

		return $full_path;
	}

	/**
	 * Get the version number of the asset file.
	 *
	 * @param string $relative_path Relative file path for the plugin folder.
	 *
	 * @throws \Exception If \An_Whatever\PLUGIN_VERSION constant not set.
	 * @throws \Exception If \An_Whatever\PLUGIN_PATH constant not set.
	 * @throws \Exception If file not exists.
	 *
	 * @since 1.0.0
	 *
	 * @return string The asset version string.
	 */
	public static function get_asset_version( string $relative_path ): string {
		if ( ! defined( '\WP_DEBUG' ) || false === \WP_DEBUG ) {
			return static::get_version();
		}

		// Get the full filesystem path.
		// Helper method throws an Exception if file not exists or
		// \An_Whatever\PLUGIN_PATH constant not isset.
		$full_path = static::get_file_path( \str_replace( '/', \DIRECTORY_SEPARATOR, $relative_path ) );

		return (string) \filemtime( $full_path );
	}

	/**
	 * Get the URL path to the file in plugin folder.
	 *
	 * @param string $relative_url Relative file path for the plugin folder.
	 *
	 * @throws \Exception If \An_Whatever\PLUGIN_PATH constant not set.
	 * @throws \Exception If \An_Whatever\PLUGIN_URL constant not set.
	 * @throws \Exception If file not exists.
	 *
	 * @since 1.0.0
	 *
	 * @return string The URL path to the file in plugin folder.
	 */
	public static function get_file_url( string $relative_url ): string {
		if ( ! defined( '\An_Whatever\PLUGIN_URL' ) ) {
			maybe_display_error(
				__(
					'The \An_Whatever\PLUGIN_URL constant must be set. Please set the required constant in the an-whatever-constants.php file.',
					'an-whatever'
				)
			);
		}

		// Try to get full filesystem path to check if file exists.
		// Helper method throws an Exception if file not exists or
		// \An_Whatever\PLUGIN_PATH constant not isset.
		$full_path = static::get_file_path( \str_replace( '/', \DIRECTORY_SEPARATOR, $relative_url ) );

		return \An_Whatever\PLUGIN_URL . \ltrim( $relative_url, '/' );
	}

	/**
	 * Date validator.
	 *
	 * @param string $date Date and time string. E.g.: '2034-01-01' or '2025-12-31 23:59:59'.
	 * @param string $format In which format the date is passed. Default 'Y-m-d H:i:s'.
	 *
	 * @return bool True if date valid, othervise false.
	 */
	public static function is_valid_date( string $date, string $format = 'Y-m-d H:i:s' ): bool {
		$d = \DateTime::createFromFormat( $format, $date );

		return ( $d && $d->format( $format ) === $date );
	}

	/**
	 * Shows error message or throws Exception depending on whether the 'WP_DEBUG' constant is set and current user can manage options.
	 *
	 * @throws \Exception If 'WP_DEBUG' constant is set to true.
	 *
	 * @param string $error_message Error message.
	 * @param int    $error_code Exception Error code. Default 1.
	 *
	 * @return void
	 */
	public static function maybe_display_error( string $error_message, int $error_code = 1 ): void {
		if ( \defined( '\WP_DEBUG' ) && true === \WP_DEBUG && \current_user_can( 'manage_options' ) ) {
			throw new \Exception( \esc_html( $error_message ), $error_code );
		}

		printf(
			'<div class="error">%s</div>',
			esc_html__( 'Error. Please try again later or contact the site administrator.', 'an-whatever' )
		);
	}

}
