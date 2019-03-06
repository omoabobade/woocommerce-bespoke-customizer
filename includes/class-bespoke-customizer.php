<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Bespoke_Customizer
 * @subpackage Bespoke_Customizer/includes
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
 * @package    Bespoke_Customizer
 * @subpackage Bespoke_Customizer/includes
 * @author     Kolawole Abobade <kolawole.abobade@gmail.com>
 */
class Bespoke_Customizer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Bespoke_Customizer_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'bespoke-customizer';

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
	 * - Bespoke_Customizer_Loader. Orchestrates the hooks of the plugin.
	 * - Bespoke_Customizer_i18n. Defines internationalization functionality.
	 * - Bespoke_Customizer_Admin. Defines all hooks for the admin area.
	 * - Bespoke_Customizer_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bespoke-customizer-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bespoke-customizer-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bespoke-customizer-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-bespoke-customizer-public.php';

		$this->loader = new Bespoke_Customizer_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Bespoke_Customizer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Bespoke_Customizer_i18n();

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

		$plugin_admin = new Bespoke_Customizer_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_my_menu');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Bespoke_Customizer_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, "process_request");
		$this->loader->add_action( 'woocommerce_after_add_to_cart_button', $plugin_public, "show_customizer_button");
		$this->loader->add_action('wp_footer', $plugin_public, "hook_modal_display");
		$this->loader->add_filter('woocommerce_add_cart_item_data', $plugin_public, "custom_add_item_data", 10, 2);
		$this->loader->add_action('wp_ajax_woocommerce_ajax_add_to_cart', $plugin_public, 'woocommerce_ajax_add_to_cart');
		$this->loader->add_action('wp', $plugin_public, 'woocommerce_ajax_add_to_cart');

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
	 * @return    Bespoke_Customizer_Loader    Orchestrates the hooks of the plugin.
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

	public function fetchItems(){
		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix ."bespoke_customizer_items");
		//var_dump($results);
		if(!empty($results)) {
			return $results;
		} 
		return [];
	}

	public function getItemById($itemId){
		global $wpdb;
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix ."bespoke_customizer_items WHERE id ='%d'", $itemId ) );
	}

	public function saveItem(){
		$title  = $_POST['title']; //Item title
		$details  = $_POST['details'];  
  
		global $wpdb; //removed $name and $description there is no need to assign them to a global variable
		$table_name = $wpdb->prefix . "bespoke_customizer_items"; //set table name
  
		$wpdb->insert($table_name, array(
								  'title' => $title, 
								  'details' => $details
								  ),array(
								  '%s',
								  '%s') // format details accordingly
		  );
		  return $wpdb->insert_id;
	}

	public function getCategoryById($categoryId){
		global $wpdb;
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix ."bespoke_customizer_categories WHERE id ='%d'", $categoryId ) );
	}

	public function getCategoriesByItemId($itemId){
		global $wpdb;
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix ."bespoke_customizer_categories where item_id='%d'", $itemId));
		//var_dump($results);exit();
		if(!empty($results)) {
			return $results;
		} 
		return [];
	}

	public function saveCategory(){  
		global $wpdb; 
		$title   = $_POST['title']; //Item title
		$details = $_POST['details'];  
		$itemId = $_POST['item_id'];

		$table_name = $wpdb->prefix . "bespoke_customizer_categories"; //set table name
  
		$wpdb->insert($table_name, array(
								  'title' => $title, 
								  'details' => $details,
								  'item_id'=> $itemId
								  ),array(
								  '%s',
								  '%s',
								  '%d') // format details accordingly
		  );
		  return $wpdb->insert_id;
	}

	public function getLabelByCategoryId($categoryId){
		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix ."bespoke_customizer_labels where category_id=".$categoryId);
		if(!empty($results)) {
			return $results;
		} 
		return [];
	}

	public function fetchLabels(){
		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix ."bespoke_customizer_labels");
		if(!empty($results)) {
			return $results;
		} 	
		return [];	
	}

	public function loadProduct($productID){
		if(get_the_ID()){
			$productID = get_the_ID();
		}
		$product = wc_get_product($productID);
		return $product;
	}
	
	public function saveLabel(){
		global $wpdb; 
		$title   = $_POST['title']; //Item title
		$price = $_POST['price'];  
		$categoryId = $_POST['category_id'];

		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		$uploadedfile = $_FILES['picture'];
		$upload_overrides = array( 'test_form' => false );
		$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
		if ( !$movefile && isset( $movefile['error'] ) ) {
			return;
		}
		$picture = $movefile['url'];
		$table_name = $wpdb->prefix . "bespoke_customizer_labels"; //set table name
  
		$wpdb->insert($table_name, array(
								  'title' => $title, 
								  'price' => $price,
								  'category_id'=> $categoryId,
								  'picture' => $picture
								  ),array(
								  '%s',
								  '%s',
								  '%d', '%s') // format details accordingly
		  );
		  return $wpdb->insert_id;
	}

}
