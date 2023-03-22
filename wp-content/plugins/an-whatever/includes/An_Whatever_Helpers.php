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
			static::maybe_display_error(
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
			static::maybe_display_error(
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
			static::maybe_display_error(
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
			static::maybe_display_error(
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
			static::maybe_display_error(
				__(
					'The \An_Whatever\PLUGIN_PATH constant must be set. Please set the required constant in the an-whatever-constants.php file.',
					'an-whatever'
				)
			);
		}

		$full_path = \An_Whatever\PLUGIN_PATH . \ltrim( $relative_path, \DIRECTORY_SEPARATOR );

		if ( ! \file_exists( $full_path ) ) {
			static::maybe_display_error(
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
			static::maybe_display_error(
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
	 * Get the Custom Taxonomies array of arguments.
	 *
	 * @return array Associative array. The key of the array is the CPT name
	 *               to which the taxonomy is assigned. The value of the array
	 *               is an associative array, where the key is the name of the taxonomy
	 *               and the value is an array of taxonomy registration arguments.
	 */
	public static function get_ctx_args(): array {
		$ctxs = array();

		// Every taxonomy array is described separately,
		// as the same taxonomy can be assigned to several CPTs.
		$an_forever_tax = array(
			'labels'              => array(
				'name'          => _x( 'Forevers', 'custom taxonomy plural name', 'an-whatever' ),
				'singular_name' => _x( 'Forever', 'custom taxonomy singular name', 'an-whatever' ),
			),
			'public'              => true,
			'hierarchical'        => true,
			'show_in_rest'        => true,
			'rewrite'             => array(
				'slug' => _x( 'forever', 'custom taxonomy slug', 'an-whatever' ),
			),
			'show_in_quick_edit'  => true,
			'show_admin_column'   => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
		);

		/*
		 * If we want to add the CPT archive URL in front of the taxonomy URL, we change the 'rewrite' array.
		 * A CPT archive url can only be assigned to one taxonomy once.
		 * If a taxonomy is linked to multiple CPTs, then the URL of the taxonomy must be in addition to the URL part of the CPT archive.
		 */
		$an_forever_tax['rewrite']['slug'] = static::get_an_whatever_cpt_archive_url() . '/' . _x( 'forever', 'custom taxonomy slug', 'an-whatever' );

		$ctxs['an_whatever'] = array(
			'an_forever' => $an_forever_tax,
		);

		return $ctxs;
	}

	/**
	 * Get the Custom Post Types array of arguments.
	 *
	 * @return array Associated array. The keys of the array are the CPT type
	 *                                 and the values are the array of CPT registration arguments.
	 */
	public static function get_cpt_args(): array {
		$ctx_args = static::get_ctx_args();

		return array(
			'an_whatever' => array(
				'description'         => __( 'Custom post type for WordPress testing', 'an-whatever' ),
				'labels'              => array(
					'name'                  => _x( 'Whatevers', 'Post type general name', 'an-whatever' ),
					'singular_name'         => _x( 'Whatever', 'Post type singular name', 'an-whatever' ),
					'menu_name'             => _x( 'Whatevers', 'Admin Menu text', 'an-whatever' ),
					'name_admin_bar'        => _x( 'Whatever', 'Add New on Toolbar', 'an-whatever' ),
					'add_new'               => __( 'Add New', 'an-whatever' ),
					'add_new_item'          => __( 'Add New Whatever', 'an-whatever' ),
					'new_item'              => __( 'New Whatever', 'an-whatever' ),
					'edit_item'             => __( 'Edit Whatever', 'an-whatever' ),
					'view_item'             => __( 'View Whatever', 'an-whatever' ),
					'all_items'             => __( 'All Whatevers', 'an-whatever' ),
					'search_items'          => __( 'Search Whatevers', 'an-whatever' ),
					'parent_item_colon'     => __( 'Parent Whatevers:', 'an-whatever' ),
					'not_found'             => __( 'No Whatevers found.', 'an-whatever' ),
					'not_found_in_trash'    => __( 'No Whatevers found in Trash.', 'an-whatever' ),
					'featured_image'        => _x( 'Whatever Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'an-whatever' ),
					'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'an-whatever' ),
					'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'an-whatever' ),
					'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'an-whatever' ),
					'archives'              => _x( 'Whatever archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'an-whatever' ),
					'insert_into_item'      => _x( 'Insert into Whatever', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'an-whatever' ),
					'uploaded_to_this_item' => _x( 'Uploaded to this Whatever', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'an-whatever' ),
					'filter_items_list'     => _x( 'Filter Whatevers list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'an-whatever' ),
					'items_list_navigation' => _x( 'Whatevers list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'an-whatever' ),
					'items_list'            => _x( 'Whatevers list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'an-whatever' ),
				),
				'public'              => true,
				'hierarchical'        => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_rest'        => true,
				'menu_icon'           => 'dashicons-welcome-learn-more',
				'supports'            => array(
					'title',
					'editor',
					'thumbnail',
					'custom-fields',
					'author',
					'page-attributes',
					'excerpt',
				),
				'taxonomies'          => \array_keys( $ctx_args['an_whatever'] ),
				'has_archive'         => static::get_an_whatever_cpt_archive_url(),
				'rewrite'             => array(
					'slug' => static::get_an_whatever_cpt_archive_url(),
				),
				'template'            => array(
					array(
						'core/paragraph',
						array(
							'placeholder' => esc_html__( 'Start creating amazing content', 'an-whatever' ),
						),
					),
				),
			),
		);
	}

	/**
	 * Get the URL path of the an_whatever CPT archive.
	 *
	 * @return string A URL path without a website domain and without leading and trailing slashes.
	 */
	public static function get_an_whatever_cpt_archive_url(): string {
		return _x( 'whatever', 'Post type archive slug', 'an-whatever' );
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

		\printf(
			'<div class="error">%s</div>',
			esc_html__( 'Error. Please try again later or contact the site administrator.', 'an-whatever' )
		);
	}

}
