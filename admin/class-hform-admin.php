<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       ca_hform
 * @since      1.0.0
 *
 * @package    Hform
 * @subpackage Hform/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Hform
 * @subpackage Hform/admin
 * @author     ca_developer <chatbhaturkar@gmail.com>
 */
class Hform_Admin {

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

		add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );
		add_action( 'admin_init', array( $this, 'setup_sections' ) );

		add_action( 'admin_init', array( $this, 'setup_fields' ) );

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
		 * defined in Hform_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hform_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hform-admin.css', array(), $this->version, 'all' );

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
		 * defined in Hform_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hform_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hform-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function create_plugin_settings_page() {
	    // Add the menu item and page
	    $page_title = 'My Awesome Settings Page';
	    $menu_title = 'HForm Plugin';
	    $capability = 'manage_options';
	    $slug = 'hform_fields';
	    $callback = array( $this, 'plugin_settings_page_content' );
	    $icon = 'dashicons-admin-plugins';
	    $position = 100;

	    add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
	}


	public function plugin_settings_page_content() {
	    ?>
	    	<div class="wrap">
		        <h2>HForm API Link and token Settings Page</h2>
		        <form method="post" action="options.php">
		            <?php
		                settings_fields( 'hform_fields' );
		                do_settings_sections( 'hform_fields' );
		                submit_button();

		            ?>
		        </form>
		        <?php echo "<strong class='description'>" . __( 'To show the HForm use this [ca_hform] shortcode in any page.', 'sc' ) . '</strong>';?>
		    </div>
	    <?php
	}

	public function setup_sections() {
	    add_settings_section( 'auth_token_section', 'Add Auth Token', array( $this, 'section_callback' ), 'hform_fields' );
	    add_settings_section( 'api_url_section', 'Add API URL', array( $this, 'section_callback' ), 'hform_fields' );
	}

	public function section_callback( $arguments ) {
	    switch( $arguments['id'] ){
	        case 'auth_token_section':
	            //echo 'Authentication token';
	            break;
	        case 'api_url_section':
	           // echo 'API URL';
	            break;
	    }
	}

	
	public function setup_fields() {
	    $fields = array(
	        array(
	            'uid' => 'auth_token_field',
	            'label' => 'Auth Token',
	            'section' => 'auth_token_section',
	            'type' => 'text',
	            'options' => false,
	            'placeholder' => 'Auth Token',
	            'helper' => 'Add Auth Token',
	            'default' => ''
	        ),
	        array(
	            'uid' => 'api_url_field',
	            'label' => 'API URL',
	            'section' => 'api_url_section',
	            'type' => 'url',
	            'options' => false,
	            'placeholder' => 'API URL',
	            'helper' => 'API URL Token',
	            'default' => ''
	        )
	    );
	    foreach( $fields as $field ){
	        add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), 'hform_fields', $field['section'], $field );
	        register_setting( 'hform_fields', $field['uid'] );
	    }
	}


	public function field_callback( $arguments ) {
	    $value = get_option( $arguments['uid'] ); // Get the current value, if there is one
	    if( ! $value ) { // If no value exists
	        $value = $arguments['default']; // Set to our default
	    }

	    // Check which type of field we want
	    switch( $arguments['type'] ){
	        case 'text': // If it is a text field
	            printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
	            break;

	        case 'url': // If it is a text field url
	            printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
	            break;
	    }

	    // If there is help text
	    if( $helper = $arguments['helper'] ){
	        printf( '<span class="helper"> %s</span>', $helper ); // Show it
	    }
	    
	}

}
