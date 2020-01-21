<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://booksshelf.com
 * @since      1.0.0
 *
 * @package    Rocket_Books
 * @subpackage Rocket_Books/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Rocket_Books
 * @subpackage Rocket_Books/includes
 * @author     Patrick Kongawi  <hello@patrickkongawi.com>
 */
class Rocket_Books_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        
        //Un-register CPT
        
        unregister_post_type('book');
        
        //Flush re-write rules
        flush_rewrite_rules();

	}

}
