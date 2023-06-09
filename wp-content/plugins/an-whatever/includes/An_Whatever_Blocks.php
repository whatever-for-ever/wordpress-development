<?php
declare( strict_types=1 );

/**
 * The file that defines the An_Whatever_Blocks class file
 *
 * @since 1.0.0
 *
 * @package An_Whatever
 */

namespace An_Whatever;

/**
 * Define the WordPress Gutenberg Blocks functionality.
 *
 * @since   1.0.0
 * @package An_Whatever
 * @author  Whatever Forever
 */
class An_Whatever_Blocks {

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
	 * Initialize the class.
	 */
	public function __construct() {
		$this->helpers = \An_Whatever\An_Whatever_Helpers::get_instance();
	}

	/**
	 * Registers the block using the metadata loaded from the `block.json` file.
	 * Behind the scenes, it registers also all assets so they can be enqueued
	 * through the block editor in the corresponding context.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	public function action_register_block_types() {
		// @link https://youtu.be/ZjYgdf6RKPU
		\register_block_type( $this->helpers::get_file_path( '/blocks/accordion/' ) );

		// @link https://youtu.be/ZjYgdf6RKPU
		\register_block_type( $this->helpers::get_file_path( '/blocks/accordion-item/' ) );

		// @link https://youtu.be/fW3W1eZorHg?t=2561
		// @link https://www.twitch.tv/videos/1773289338?t=1h10m53s
		\register_block_type( $this->helpers::get_file_path( '/blocks/post-picker/' ) );

		// @link https://www.twitch.tv/videos/1773289338?t=1h10m53s
		\register_block_type( $this->helpers::get_file_path( '/blocks/post-picker-placeholder/' ) );
	}

}
