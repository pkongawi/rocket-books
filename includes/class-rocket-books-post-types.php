<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://booksshelf.com
 * @since      1.0.0
 *
 */

/**
 * Functionality for our custom post types
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rocket_Books
 * @subpackage Rocket_Books/public
 * @author     Patrick Kongawi  <hello@patrickkongawi.com>
 */
class Rocket_Books_Post_Types {

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
    
    private $template_loader;

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
        
        $this->template_loader = $this->get_template_loader();
    /**
	 *Hooked into the init action hook
	 *
	 */
    }
        
    public function init(){
        
        $this->register_cpt_book();
        $this->register_taxonomy_genre();
    }
    /**
	 *Register custom post type
	 *
	 */
        
    public function register_cpt_book(){
        
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
        'register_meta_box_cb'  => array($this, 'register_metabox_book'),
        'taxonomies'            => array('genre'),
		'has_archive'           => true,
        'rewrite'               => array( 'slug' => 'book', 'with_front' =>true, 'feeds' => false, 'pages' =>true, ),
        'query_var'             => true,
        'can_export'            => true,
        'show_in_rest'          => true,
	
	));
        
    }
    
    /**
	 *Register Taxonomy
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
        'show_in_rest'          => true,
        ));
        
    }
    
      /**
	 *The content of the custom post type
	 *
	 */
    
    public function content_single_book($the_content){
        
        //filter contens for just Books
        
        if ( in_the_loop() && is_singular( 'book' )) {
            
        //  return "<pre>" . $the_content . "</pre>";
        ob_start();
        include ROCKET_BOOKS_BASE_DIR . 'templates/book-content.php';
        return ob_get_clean();
            
        }
        
        return $the_content;
        
    }
    
    /***Single Template for CPT: book */
    public function single_template_book($template) {
       if ( is_singular( 'book' )) {
        // Template for CPT book
         
        return $this->template_loader->get_template_part( 'single', 'book', false );
       } 
         return $template;
    }
    
        /***Single Template for archive template */
    public function archive_template_book($template) {
       if ( is_post_type_archive('book')  ||  is_tax( 'genre' )) {
           
        // Template for Archive book
           
        return $this->template_loader->get_template_part( 'archive', 'book', false );
       } 
         return $template;
    }
      
    public function get_template_loader(){
        
        require_once ROCKET_BOOKS_BASE_DIR . 'public/class-rocket-books-template-loader.php';
        return new Rocket_Books_Template_Loader();
        
    }
    
      /**
	 *Register metaboxes for CPT
	 *
	 */
    
    public function register_metabox_book($post){
        
        $is_gutenberge_active = (
        function_exists('use_block_editor_for_post_type') &&
        use_block_editor_for_post_type(get_post_type())
        );
        
        add_meta_box(
        'book-details',
        __('Book Details', 'rocket-books'),
         array($this, 'book_metabox_display_cb'),
        'book',
        ($is_gutenberge_active) ? 'side' : 'normal',
        'default'
            
        );
        
    }
    
       /**
	 *Display Metabox for custom post types.  
	 *
	 */
    public function book_metabox_display_cb($post) {
        
      //  echo "hello";
    ?>
    <label for="rbr-book-pages"><?php _e( 'Number of Pages', 'rocket-books' ) ?></label>
    <input type="text" name="rbr-book-pages" class="widefat">
    <?php
        
    }
    
    /**
	 *Saving custom fields for CPT  
	 *
	 */
    
    public function metabox_save_book($post_id, $post, $update){
        
   // var_export($_POST); die();
    var_export($_POST['rbr-book-pages']); die();
    update_post_meta(get_the_ID(), 'rbr_book_page');
        
    }
    
	}    
    

