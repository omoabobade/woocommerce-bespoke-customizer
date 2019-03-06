<?php

/**
 * Fired during plugin activation
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Bespoke_Customizer
 * @subpackage Bespoke_Customizer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Bespoke_Customizer
 * @subpackage Bespoke_Customizer/includes
 * @author     Kolawole Abobade <kolawole.abobade@gmail.com>
 */
class Bespoke_Customizer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		global $wpdb;
		$table_name = $wpdb->prefix . "bespoke_customizer_labels"; 

		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		title tinytext NOT NULL,
		picture text NOT NULL,
		price  float NOT NULL,
		category_id bigint NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		$table_name = $wpdb->prefix . "bespoke_customizer_categories"; 
		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		title tinytext NOT NULL,
		details text ,
		item_id  bigint NOT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		$table_name = $wpdb->prefix . "bespoke_customizer_items"; 
		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		created datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		title tinytext NOT NULL,
		details text ,
		PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

	 }

	 

	 
}
