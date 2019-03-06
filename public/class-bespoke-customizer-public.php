<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Bespoke_Customizer
 * @subpackage Bespoke_Customizer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bespoke_Customizer
 * @subpackage Bespoke_Customizer/public
 * @author     Kolawole Abobade <kolawole.abobade@gmail.com>
 */
class Bespoke_Customizer_Public {

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
		 * defined in Bespoke_Customizer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bespoke_Customizer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bespoke-customizer-public.css', array(), $this->version, 'all' );

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
		 * defined in Bespoke_Customizer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bespoke_Customizer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bespoke-customizer-public.js', array( 'jquery' ), $this->version, false );

	}


	public function process_request(){
		
		if(isset($_GET['api_request'])){
			$request = $_GET['api_request'];
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json; charset=UTF-8");
			$plugin = new Bespoke_Customizer();
			if($request === "fetchItems"){
				$myresponse = json_encode($plugin->fetchItems());
				http_response_code(200);
				echo $myresponse;
			}

			if($request === "fetchCategories"){
				$myresponse = json_encode($plugin->getCategoriesByItemId($_GET['itemId']));
				if($myresponse){
					http_response_code(200);
					echo $myresponse;				
				}
			}

			if($request === "fetchLabels"){
				$catId = $_GET['catId'];
			//echo $catId;
				$myresponse = json_encode($plugin->getLabelByCategoryId($catId));
				if($myresponse){
					http_response_code(200);
					echo $myresponse;				
				}
			}
			if($request === "getProduct"){
				$prodId = $_GET['prodId'];
				$product = $plugin->loadProduct($prodId);
				$json_response = array();
				$json_response['image'] = get_the_post_thumbnail_url( $product->get_id(), 'full' );
				$json_response['title'] = $product->get_name();
				$json_response['id'] = $product->get_id();
				$myresponse = json_encode($json_response, true);
				$this->sendResponse($myresponse);
			}
			exit;
		}
	}

	private function sendResponse($myresponse){
		if($myresponse){
			http_response_code(200);
			echo $myresponse;				
		}
	}

	public function show_customizer_button() {
		$productID = get_the_ID();
		$product = wc_get_product($productID);
		$yourCustomLinkValue =  get_post_meta($productID,'custom_link_meta',true);
		echo '<button class="customize_button" type="button" data-product="'.$productID.'">Customize Product</button>'; 
		include 'partials/bespoke-customizer-public-display.php';   
	}

	function woocommerce_ajax_add_to_cart() {
			if(isset($_GET['api_request']) && $_GET['api_request'] === "saveCustomData"){
			echo("here"); exit();
            $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
            $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
            $variation_id = absint($_POST['variation_id']);
            $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
            $product_status = get_post_status($product_id);
 
            if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {
 
                do_action('woocommerce_ajax_added_to_cart', $product_id);
 
                if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
                    wc_add_to_cart_message(array($product_id => $quantity), true);
                }
 
                WC_AJAX :: get_refreshed_fragments();
            } else {
 
                $data = array(
                    'error' => true,
                    'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));
 
                echo wp_send_json($data);
            }
 
            wp_die();
        }


	}

	public function hook_modal_display(){
		
		echo '<div class="modal-backdrop"></div>';
	}

	public function custom_add_item_data($cart_item_data, $product_id)
	{
		if(isset($_POST['bespoke_customization']))
		{
			$cart_item_data['customization'] = sanitize_text_field($_POST['bespoke_customization']);
		}
    	return $cart_item_data;
	}

	public function custom_add_item_meta($item_data, $cart_item)
	{

		if(array_key_exists('bespoke_customization', $cart_item))
		{
			$custom_details = $cart_item['bespoke_customization'];

			$custom_details = $custom_details? $custom_details : "None";
			$item_data[] = array(
				'key'   => 'Customization',
				'value' => $custom_details
			);
		}

		return $item_data;
	}

}
