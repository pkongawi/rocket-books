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

    ?/**
    * Hold all the css for all the shortcodes
     */
    
    protected $shortcode_css;

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
		
        $this->setup_hooks();
	}
    
    /**
     * Setup action/filter books  
     */
    
    public function setup_hooks() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_style' ) );

        add_action('get_footer', array($this, 'maybe_enqueue_scripts'));
    }
    
    /**
     * Register Placeholder  
     */
    
    public function register_style() {
      
      wp_register_style(
          
        $this->plugin_name . '-shortcodes',
        ROCKET_BOOKS_PLUGIN_URL . 'public/css/rocket-books-shortcodes.css'
      
        );
      
    }
    
    /**
     * Shortcode for books list
     * */

    public function book_list($atts, $content){
        
        $atts = shortcode_atts(
				array(
					'limit'  => get_option( 'posts_per_page' ),
					'column' => 3,
					'bgcolor' => '#f6f6f6',
					'color' => '#ff0000'
				),
				$atts,
				'book_list'
			);
        
        $loop_args = array(
            
            'post_type'      => 'book',
            'posts_per_page' => $atts['limit'],
            
            );
            
            $loop = new WP_Query($loop_args);
            
            $grid_column = rbr_get_column_class( $atts['column'] );
            
            //Step 1 : Register a placeholder stylesheet
            //Step 2 : Build upo CSS 
            //Step 3 : Add css to placeholder style 
            //Step 4 : Enqueue Style 

            $this->add_css_books_list($atts);
            
            /**
            *When using template loader
            */
           // $template_loader = rbr_get_template_loader();
        
        ob_start();
        ?>
        
         <div class="cpt-cards cpt-shortcodes <?php echo sanitize_html_class($grid_column); ?>" >
            
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

    /**
     * Add CSS for books list shortcodes
     */

     public function add_css_books_list($atts){
        $css = ".cpt-cards.cpt-shortcodes .cpt-card{background-color:{$atts['bgcolor']};}";
        $css .= ".cpt-cards.cpt-shortcodes .cpt-card{color:{$atts['color']};}";

        $this->shortcode_css = $this-shortcode_css . $css;
     }

     /**
      * Enqueue only when required
      */
    public function maybe_enqueue_scripts() {
        if(!empty($this->shortcode_css)){

            wp_add_inline_style(
                
                $this->plugin_name . '-shortcodes',
                $this->shortcode_css
                );
            
            wp_enqueue_style(
                $this->plugin_name . '-shortcodes'    
            );

        }
    }
}

}
