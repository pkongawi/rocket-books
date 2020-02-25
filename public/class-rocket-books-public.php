<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://booksshelf.com
 * @since      1.0.0
 *
 * @package    Rocket_Books
 * @subpackage Rocket_Books/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rocket_Books
 * @subpackage Rocket_Books/public
 * @author     Patrick Kongawi  <hello@patrickkongawi.com>
 */
class Rocket_Books_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rocket_Books_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rocket_Books_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rocket-books-public.css', array(), $this->version, 'all' );
        
        if(is_singular( 'book' ) || is_post_type_archive( 'book' ) || is_tax( 'genre' ) ){wp_enqueue_style( $this->plugin_name .'-single-book' , plugin_dir_url( __FILE__ ) . 'css/rocket-books-book-single.css', array(), $this->version, 'all' );
        }
        
           
        if(is_singular( 'book' )){wp_enqueue_style( $this->plugin_name .'-fontawesome' , ROCKET_BOOKS_PLUGIN_URL . 'vendor/fontawesome/css/all.css', array(), $this->version, 'all' );
        }
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rocket_Books_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rocket_Books_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rocket-books-public.js', array( 'jquery' ), $this->version, false );

	}
    
    	/**
		 * Register custom post type and documentation
		 *
		 */
    public function register_book_post_type(){
        
        register_post_type('book', array(
        'description'        => __( 'Books', 'rocket-books' ),
        'labels'             => array(
		'name'               => _x( 'Books', 'post type general name', 'rocket-books' ),
		'singular_name'      => _x( 'Book', 'post type singular name', 'rocket-books' ),
		'menu_name'          => _x( 'Books', 'admin menu', 'rocket-books' ),
		'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'rocket-books' ),
		'add_new'            => _x( 'Add New', 'book', 'rocket-books' ),
		'add_new_item'       => __( 'Add New Book', 'rocket-books' ),
        'edit_item'          => __( 'Edit Book', 'rocket-books' ),
		'new_item'           => __( 'New Book', 'rocket-books' ),
		'view_item'          => __( 'View Book', 'rocket-books' ),
        'search_items'       => __( 'Search Books', 'rocket-books' ),
        'not_found'          => __( 'No books found.', 'rocket-books' ),
        'not_found_in_trash' => __( 'No books found in Trash.', 'rocket-books' ),
        'parent_item_colon'  => __( 'Parent Books:', 'rocket-books' ),
		'all_items'          => __( 'All Books', 'rocket-books' ),
	
	),
		'public'                => true,
        'hierarchical'          => false,
        'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'show_in_nav_menus'     => true,
        'show_in_admin_bar'     => true,
        'menu_position'         => 20,  
        'menu_icon'             => 'dashicons-book',
        'capability_type'       => 'post',
        'capabilities'          => array(),
        'map_meta_cap'          => null,
        'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'register_meta_box_cb'  => array(),
        'taxonomies'            => array(),
		'has_archive'           => true,
        'rewrite'               => array( 'slug' => 'book', 'with_front' =>true, 'feeds' => false, 'pages' =>true, ),
        'query_var'             => true,
        'can_export'            => true,
        'show_in_rest'          => true,
	
	));

    }
	/**
		 * Register custom taxonomy 
		 *
		 */
    
    public function register_taxonomy_genre(){
        register_taxonomy( 'genre', array('book'), array(
        'description'                   => 'Genre',
        'labels'                        => array(
        'name'                          => _x( 'Genres', 'post type general name', 'rocket-books' ),
		'singular_name'                 => _x( 'Genre','post type singular name', 'rocket-books' ),
        'search_items'                  => __( 'Search Genres', 'rocket-books' ),
        'popular_items'                 => __( 'Popular Genres', 'rocket-books'),    
        'all_items'                     => __( 'All Genres', 'rocket-books' ),
        'parent_item'                   => __( 'Parent Genres:', 'rocket-books' ),
        'parent_item_colon'             => __( 'Parent Genres:', 'rocket-books' ),
        'edit_item'                     => __( 'Edit Genre', 'rocket-books' ),
		'view_item'                     => __( 'View Genre', 'rocket-books' ),
        'update_item'                   => __( 'Update Genre', 'rocket-books')        
        ),
        
        'public'                => true,
        'show_ui'               => true,
        'show_in_nav_menus'     => true,
        'show_tagcloud'         => true,
        'meta_box_cb'           => null,
        'show_in_admin_column'  => true,
        'hierarchical'          => true,
        'query_var'             => 'genre',
        'rewrite'               => array( 'slug' => 'genre', 'with_front' => true, 'hierarchical'  => true, ),
        'capabilities'          => array(),
        ));
}
    
    
}
