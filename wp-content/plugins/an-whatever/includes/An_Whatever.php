<?php
declare( strict_types=1 );

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since 1.0.0
 *
 * @package An_Whatever
 */

namespace An_Whatever;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since   1.0.0
 * @package An_Whatever
 * @author  Whatever Forever
 */
final class An_Whatever {

	/**
	 * The unique prefix of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @var string $plugin_prefix The string used to uniquely prefix technical functions of this plugin.
	 */
	private string $plugin_prefix;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @var string $plugin_name The string used to uniquely identify this plugin.
	 */
	private string $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @var string $version The current version of the plugin.
	 */
	private string $version;

	/**
	 * Custom taxonomies registration args.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array $ctx_args Associative array. The key of the array is the CPT name
	 *                         to which the taxonomy is assigned. The value of the array
	 *                         is an associative array, where the key is the name of the taxonomy
	 *                         and the value is an array of taxonomy registration arguments.
	 */
	private array $ctx_args;

	/**
	 * Custom post types registration args.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array $cpt_args The keys of the array are the CPT type
	 *                         and the values are the array of CPT registration arguments.
	 */
	private array $cpt_args;

	/**
	 * Singleton class instance with collection of helpers methods.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @var \An_Whatever\An_Whatever_Helpers $helpers Singleton class instance with collection of helpers methods.
	 */
	private \An_Whatever\An_Whatever_Helpers $helpers;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin prefix, name and the plugin version that can be used throughout this class.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Manualy load only if not using autoloader.
		$this->load_dependencies();

		// Variables must be initialized after the loaded textdomain.
		// The text domain is loaded using the plugins_loaded action hook with -1 priority.
		\add_action( 'plugins_loaded', array( $this, 'setup_class_vars' ), 0 );
	}

	/**
	 * Load the required dependencies for this plugin only if not using autoloader.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - \An_Whatever\An_Whatever_i18n. Defines internationalization functionality.
	 * - \An_Whatever\An_Whatever_Helpers. Defines all all helper methods and plugin wide variables.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once \An_Whatever\PLUGIN_PATH . 'includes/An_Whatever_i18n.php';

		/**
		 * The class responsible for defining all helper methods and plugin wide variables.
		 */
		require_once \An_Whatever\PLUGIN_PATH . 'includes/An_Whatever_Helpers.php';

		/**
		 * The class responsible for the WordPress Gutenberg Blocks functionality.
		 */
		require_once \An_Whatever\PLUGIN_PATH . 'includes/An_Whatever_Blocks.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the An_Whatever_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function set_locale() {
		$plugin_i18n = new \An_Whatever\An_Whatever_i18n();

		// The text domain must be loaded before any other action is taken.
		\add_action( 'plugins_loaded', array( $plugin_i18n, 'load_plugin_textdomain' ), -1 );
	}

	/**
	 * Variables in this class are set.
	 *
	 * Variables are initialized with plugins_loaded action hook.
	 * Variables must be initialized after loading textdomain is done.
	 *
	 * @return void
	 */
	public function setup_class_vars(): void {
		$this->helpers = \An_Whatever\An_Whatever_Helpers::get_instance();

		$this->version = $this->helpers::get_version();

		$this->plugin_name   = $this->helpers::get_plugin_name();
		$this->plugin_prefix = $this->helpers::get_plugin_prefix();

		$this->ctx_args = $this->helpers::get_ctx_args();
		$this->cpt_args = $this->helpers::get_cpt_args();
	}

	/**
	 * Register all of the hooks related to the public-facing and admin area
	 * functionality of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_shared_hooks() {}

	/**
	 * Register all of the hooks related only to the admin area functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_admin_hooks() {
		$plugin_blocks = new \An_Whatever\An_Whatever_Blocks();

		/*
		 * In order to have a taxonomy appear in the URL hierarchy of the relevant CPT,
		 * you can rewrite the taxonomy slug to contain the CPT’s slug.
		 * But you must register the CPT after registering the taxonomy,
		 * otherwise the rewrite will not work.
		 */
		\add_action( 'init', array( $this, 'action_register_custom_taxonomies' ), 0 );
		\add_action( 'init', array( $this, 'action_register_custom_post_types' ), 10 );

		\add_action( 'init', array( $plugin_blocks, 'action_register_block_types' ) );
	}

	/**
	 * Register all of the hooks related only to the public-facing functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_public_hooks() {
		\add_filter( 'wp_kses_allowed_html', array( $this, 'filter_wp_kses_allowed_html' ), 10, 2 );
	}

	/**
	 * Execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		$this->set_locale();
		$this->define_shared_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}



	/**
	 * All taxonomies are registered and linked to the CPT.
	 *
	 * @return void
	 */
	public function action_register_custom_taxonomies(): void {
		$already_registered_taxonomies = array();

		foreach ( $this->ctx_args as $cpt_type => $ctx_args ) {
			foreach ( $ctx_args as $ctx_key => $ctx_register_args ) {
				/*
				 * If a taxonomy is assigned to multiple CPTs, we do not register
				 * the taxonomy a second time, but only link it to another CPT
				 * and start the loop again.
				 */
				if ( \in_array( $ctx_key, $already_registered_taxonomies, true ) ) {
					\register_taxonomy_for_object_type( $ctx_key, $cpt_type );
					continue;
				}

				\register_taxonomy( $ctx_key, $cpt_type, $ctx_register_args );

				// @link https://developer.wordpress.org/reference/functions/register_taxonomy/#more-information
				// Better be safe than sorry when registering custom taxonomies for custom post types.
				// Use register_taxonomy_for_object_type() right after the function to interconnect them.
				// Else you could run into minetraps where the post type isn’t attached inside filter callback
				// that run during parse_request or pre_get_posts.
				\register_taxonomy_for_object_type( $ctx_key, $cpt_type );

				$already_registered_taxonomies[] = $ctx_key;
			}
		}
	}

	/**
	 * All CPTs are registered.
	 *
	 * @return void
	 */
	public function action_register_custom_post_types(): void {
		foreach ( $this->cpt_args as $cpt_key => $cpt_register_args ) {
			\register_post_type( $cpt_key, $cpt_register_args );
		}
	}

	/**
	 * Filter `wp_kses_allowed_html` attributes.
	 *
	 * Allow `hidden` attribute on div HTML element and `aria-controls` and `aria-expanded` attributes on button HTML element.
	 * Because `wp_kses_post()` by default removing these attributes.
	 *
	 * @param array  $html HTML tags are allowed.
	 * @param string $context Context name.
	 *
	 * @return array
	 */
	public function filter_wp_kses_allowed_html( array $html, string $context ): array {
		if ( ! in_array( $context, array( 'an_whatever', 'post', 'page' ), true ) ) {
			return $html;
		}

		$html['button']['aria-controls'] = true;
		$html['button']['aria-expanded'] = true;
		$html['div']['hidden']           = true;

		return $html;
	}

}
