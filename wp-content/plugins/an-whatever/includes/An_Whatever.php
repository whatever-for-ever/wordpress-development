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

		$this->helpers = \An_Whatever\An_Whatever_Helpers::get_instance();

		$this->version = $this->helpers::get_version();

		$this->plugin_name   = $this->helpers::get_plugin_name();
		$this->plugin_prefix = $this->helpers::get_plugin_prefix();
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

		\add_action( 'plugins_loaded', array( $plugin_i18n, 'load_plugin_textdomain' ) );
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
	private function define_admin_hooks() {}

	/**
	 * Register all of the hooks related only to the public-facing functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_public_hooks() {}

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

}
