<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       ca_hform
 * @since      1.0.0
 *
 * @package    Hform
 * @subpackage Hform/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Hform
 * @subpackage Hform/includes
 * @author     ca_developer <chatbhaturkar@gmail.com>
 */
class Hform {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Hform_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

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
	public function __construct() {
		if ( defined( 'HFORM_VERSION' ) ) {
			$this->version = HFORM_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'hform';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Hform_Loader. Orchestrates the hooks of the plugin.
	 * - Hform_i18n. Defines internationalization functionality.
	 * - Hform_Admin. Defines all hooks for the admin area.
	 * - Hform_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-hform-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-hform-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/hForm-us-states-drop-array.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/hform_action.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-hform-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-hform-public.php';

		$this->loader = new Hform_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Hform_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Hform_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Hform_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Hform_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Hform_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

function hForm(){
	$html = '';
    $html .='<div class="wrapper">
			    <div class="box-wrapper">
			     <div class="hbox-form">
			      <h2>My H-FORM Page</h2>
			        <form id="Hform-horizontal" action="hform_action.php" target="_blank" method="post">
			          <div>
			            <input type="text" name="first_name" id="first_name" required placeholder=" ">
			            <label>FIRST NAME* </label>
			          </div>
			          <div>
			            <input type="text" name="middle_name" id="middle_name" placeholder=" " required>
			            <label>MIDDLE NAME </label>
			          </div>
			          <div>
			            <input type="text" name="last_name" id="last_name" required placeholder=" ">
			            <label>LAST NAME* </label>
			          </div>
			          <div>
			            <textarea id="street" name="street" placeholder=" " required></textarea>
			            <label>STREET ADDRESS* </label>
			          </div>
			          <div>
			            <input id="unit" name="unit" type="text" placeholder="" required>
			            <label>UNIT # </label>
			          </div>
			          <div>
			            <input id="city" name="city" type="text" placeholder="" required>
			            <label>CITY* </label>
			          </div>
			          <div>'.states_select().'<label>STATE* </label>
			          </div>
			          <div>
			            <input id="zip" name="zip" type="text" placeholder="" required>
			            <label>ZIP CODE* </label>
			          </div>
			          <div>
			            <input type="date" id="date_of_birth" name="date_of_birth" placeholder="" required>
			            <label>DATE OF BIRTH* </label>
			          </div>
			          <div>
			            <input type="tel" id="phone" name="phone" placeholder="" pattern="[1-9]{1}[0-9]{9}" required>
			            <label>PHONE NUMBER* </label>
			          </div>
			          <div>
			            <input type="email" name="email" required placeholder=" " pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"/>
			            <label>Email </label>
			          </div>

			          <div class="group-radio">
			            <div class="radio">
			            <div class="left-sec">
			              <b>House</b>
			              <p>This may be a sinlge-family home, townhouse or duplex you own and live in</p>
			            </div>
			              <input type="radio" name="hch" value="House" required>
			            </div>
			            <br>
			            <div class="radio">
			            <div class="left-sec">
			            <b>Condo</b>
			            <p>This is like multi-family building or complex in which you own a unit.</p></div>
			             <input type="radio" name="hch" value="Condo"></div>
			            <br>
			            <div class="radio">
			              <div class="left-sec">
			                <b>HO5</b>
			                <p>The HO5 is an open perils insurance policy for a single family home or duplex.</p></div>
			              <input type="radio" name="hch" value="HO5">
			             </div>
			             <label>IS THIS A HOUSE, Condo or HO5? </label>
			          </div>
			          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
			        </form>  
			  </div>
			    </div>
			</div>';
    return $html;

	}
	add_shortcode('ca_hform','hForm');