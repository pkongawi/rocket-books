<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://booksshelf.com
 * @since      1.0.0
 *
 * @package    Rocket_Books
 * @subpackage Rocket_Books/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rocket_Books
 * @subpackage Rocket_Books/admin
 * @author     Patrick Kongawi  <hello@patrickkongawi.com>
 */
class Rocket_Books_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rocket-books-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rocket-books-admin.js', array( 'jquery' ), $this->version, false );

	}
    
    /**
	 * Add admin menu for our plugin
	 *
	 * 
	 */
    public function add_admin_menu(){
        
        //Top Level Menu
        //add_menu_page(
        
        //'Rocket Books Settings',
        //'Rocket Books',
        //'manage_options',
        //'rocket-books',
        //array($this, 'admin_page_display'),
        //'dashicons-chart-pie',
        //60   
        //);
        
        //Sub Menu 
        //add_options_page(
        
        //'Rocket Books Settings',
        //'Rocket Books',
        //'manage_options',
        //'rocket-books',
        //array($this, 'admin_page_display')  
        //);
        
        add_submenu_page(
        'edit.php?post_type=book',
        'Rocket Books Settings',
        'Rocket Books',
        'manage_options',
        'rocket-books',
         array($this, 'admin_page_display')  
        );
    }
    
     /**
	 * Admin page display
	 *
	 */
    
   public function admin_page_display(){
  //Old method of saving
  //   include 'partials/rocket-books-admin-display-form-method.php';
       
  // Settings api
       
       include 'partials/rocket-books-admin-display.php';
   }
    
  //All the hooks for admin_init
  public function admin_init(){
    
      //Add settings section
      
      $this->add_settings_section();
      
      //Add settings fields
      
      $this->add_settings_field();
      
      //Save settings
      
      $this->save_fields();
  }
     //Add setting section for plugin options
  public function add_settings_section(){
      
      add_settings_section(
      'rbr-general-section',
      'General Settings',
       function(){
           echo '<p>These are general setting for plugin</p>';
       },
      'rbr-settings-page'
      );
      
      //Advance Section
      add_settings_section(
      'rbr-advance-section',
      'Advance Settings',
       function(){
           echo '<p>These are advance setting for plugin</p>';
       },
      'rbr-settings-page'
      );
      
  }
    // add settings fileds
  public function add_settings_field(){
      
      //advanced fields
      add_settings_field(
      'rbr_test_field',
      'Test Field',
       array( $this, 'markup_text_fields_cb' ),
      'rbr-settings-page',
      'rbr-general-section',
       array(
       'name' => 'rbr_test_field',
       'value' => get_option('rbr_test_field')
       )
      );
      
       //advanced fields
      add_settings_field(
      'rbr_archive_column',
      'Archive Columns',
       array( $this, 'markup_select_fields_cb' ),
      'rbr-settings-page',
      'rbr-general-section',
       array(
       'name' => 'rbr_archive_column',
       'value' => get_option('rbr_archive_column'),
       'options' =>array(
           'column-two'=> __('Two Columns', 'rocket-books'),
           'column-three'=> __('Three Columns', 'rocket-books'),
           'column-four'=> __('Four Columns', 'rocket-books'),
           'column-five'=> __('Five Columns', 'rocket-books'),
       )
       )
      );
      
      //advanced fields
      add_settings_field(
      'rbr_advance_field1',
      'Advance Field 1',
       array( $this, 'markup_text_fields_cb' ),
      'rbr-settings-page',
      'rbr-advance-section',
       array(
       'name' => 'rbr_advance_field1',
       'value' => get_option('rbr_advance_field1')
       )
      );
      
      //advanced fields
      add_settings_field(
      'rbr_advance_field2',
      'Advance Field 2',
       array( $this, 'markup_text_fields_cb' ),
      'rbr-settings-page',
      'rbr-advance-section',
       array(
       'name' => 'rbr_advance_field2',
       'value' => get_option('rbr_advance_field2')
       )
      );
      
      //advanced fields example
      //add_settings_field(
      //'rbr_advance_field1',
      //'Advance Field 1',
      //function() {
//  echo '<input type="text" name="rbr_advance_field1" value=" '.  esc_html(get_option('rbr_advance_field1'))  .' " />';
      //},
      //'rbr-settings-page',
      //'rbr-advance-section'
      //);
      
      //advanced fields
      //add_settings_field(
      //'rbr_advance_field2',
      //'Advance Field 2',
      //function() {
// echo '<input type="text" name="rbr_advance_field2" value=" '.  esc_html(get_option('rbr_advance_field2'))  .' " />';
      // },
      //'rbr-settings-page',
      //'rbr-advance-section'
      //);
      
  }
    // save settings fields
  public function save_fields(){
      register_setting(
      'rbr-settings-page-options-group',
      'rbr_test_field',
      array (
       'sanitize_callback' => 'sanitize_text_field'
      )
      );
      
       register_setting(
      'rbr-settings-page-options-group',
      'rbr_advance_field1',
       array (
       'sanitize_callback' => 'sanitize_text_field'
      )
      );
      
       register_setting(
      'rbr-settings-page-options-group',
      'rbr_advance_field2',
        array (
       'sanitize_callback' => 'absint'
      )
      );
      
       register_setting(
      'rbr-settings-page-options-group',
      'rbr_archive_column'
      );
  }

    public function markup_text_fields_cb($args) {
        
        if(! is_array($args)) {
            return null;
        }
        $name = (isset($args['name'])) ? esc_html($args['name'] ) : '';
        $value = (isset($args['value'])) ? esc_html($args['value']) : '';
        ?>
        <input type="text" name="<?php echo $name ?>" value="<?php echo $value ?>" class="field-<?php echo $name ?>" />
        <?php 
    }
    
    public function markup_select_fields_cb($args){
        
            if(! is_array($args)) {
            return null;
        }
        $name = (isset($args['name'])) ? esc_html($args['name'] ) : '';
        $value = (isset($args['value'])) ? esc_html($args['value']) : '';
        $options = ( isset($args['options']) && is_array($args['options']) ) ? $args['options'] : array()
        ?>
        <select name="<?php echo $name ?>" class="field-<?php echo $name ?>">
        
        <?php  
        foreach ($options as $option_key => $option_label){
        echo "<option value='{$option_key}' ". selected($option_key, $value) ." >{$option_label}</option>";    
        }      
            ?>
        
        </select>
        <?php 
        
    }
    
    //add plugin links
    public function add_plugin_action_links($links){
        
        $links[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=book&page=rocket-books') ) .'">Settings</a>';
        
       // $links[] = '<a href="http://wp-buddy.com" target="_blank">More plugins by WP-Buddy</a>';
        
        return $links;
    }
    
}



