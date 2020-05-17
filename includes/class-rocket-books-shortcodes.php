<?php

/**
 *
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://booksshelf.com
 * @since      1.0.0
 *
 * @package    Rocket_Books
 * @subpackage Rocket_Books/includes
 */

if( ! class_exists( 'Rocket_Books_Shortcodes' ) ) {

class Rocket_Books_Shortcodes {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {
	
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
        
	}
    
    /**
     * Shortcode for books list
     * */

    public function book_list($atts, $content){
        
        $loop_args = array(
            
            'post_type'      => 'book',
            'posts_per_page' => 4,
            
            );
            
            $loop = new WP_Query($loop_args);
        
             /*When using template loader*/
           // $template_loader = rbr_get_template_loader();
        
        ob_start();
        ?>
         <div class="cpt-cards three-column" >
            
			<?php
			// Start the Loop.
			while ( $loop->have_posts() ) :
				$loop->the_post();
                
                /*When using template loader*/
                //$template_loader->get_template_part('archive/content', 'book');
                include ROCKET_BOOKS_BASE_DIR . 'templates/archive/content-book.php';

				// End the loop.
			endwhile;
            /* Restore original post */
            wp_reset_postdata();
		?>
        </div>
        
        <?php
        return ob_get_clean();
    }


}

}
