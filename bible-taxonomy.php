<?php
/**
 * @package   Bible Taxonomy
 * @author    Júlio Reis <webmaster@arocha.org>
 * @license   GPL-3.0
 * @link      http://arocha.org
 * @copyright 2014 A Rocha International
 *
 * @wordpress-plugin
 * Plugin Name:       Bible Taxonomy
 * Plugin URI:        https://github.com/Tintazul/bible-taxonomy
 * Description:       A hierarchical taxonomy for associating a WordPress post with a Bible reference
 * Version:           0.0.1
 * Author:            Júlio Reis / A Rocha International
 * Author URI:        http://www.tintazul.com.pt/julio.reis/
 * Text Domain:       bible-taxonomy
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/Tintazul/bible-taxonomy
 * Requires at least: 3.0.0
 */

// If this file is called directly, abort
if ( !defined('DB_NAME') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

define( 'BT_MAINFILE', __FILE__ );                    // absolute path to this file
define( 'BT_BASENAME', plugin_basename( __FILE__ ) ); // relative path to this file
define( 'BT_PATH', plugin_dir_path( __FILE__ ) );     // absolute path to plugin dir
define( 'BT_URL', plugin_dir_url( __FILE__ ) );       // URL to plugin dir
define( 'BT_VERSION', '0.0.1' );                      // plugin version
define( 'BT_MIN_WP_VERSION', '3.0.0');                // required minimum WP version

// load textdomain
load_plugin_textdomain( 'bible-taxonomy', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

// hook into the init action and call create_book_taxonomies when it fires
if ( is_admin() ) {
	if ( defined('DOING_AJAX') && DOING_AJAX ) {  // if we had ajax, we’d load it here
	}
	else add_action( 'admin-init', 'bt_requires_wordpress_version', 0 );
}
add_action( 'init', 'bt_create_taxonomy', 0 );

/**
 * Checks if the current WP install is newer than $wp_version
 * Must test every time it's run, not just upon activation,
 * because we don't know if the plugin code has been upgraded
 * @return void
 */
function bt_requires_wordpress_version() {
	global $wp_version;
	$plugin = BT_BASENAME;
	$plugin_data = get_plugin_data( BT_MAINFILE, false );

	if ( version_compare($wp_version, BT_MIN_WP_VERSION, "<" ) ) {
		if( is_plugin_active( $plugin ) ) {
			// deactivate plugin, print error message
			deactivate_plugins( $plugin );
			// Translators: first placeholder for plugin name, second for version number
			$msg_title = sprintf( __( '%1$s %2$s not activated', 'bible-taxonomy' ), $plugin_data['Name'], $plugin_data['Version'] );
			// Translators: first placeholder for current WordPress version, second for required version
			$msg_para = sprintf( __( 'You are running WordPress version %1$s. This plugin requires version %2$s or higher, and has been deactivated! Please upgrade WordPress and try again.', 'bible-taxonomy' ), $wp_version, BT_MIN_WP_VERSION );
			$msg_back = __( 'Back to WordPress admin', 'bible-taxonomy' );
			wp_die(  sprintf( '<h1>%s</h1><p>%s</p><p><a href="%s">%s</a></p>' , $msg_title, $msg_para, admin_url(), $msg_back ) );
		}
	}
}

/* create the custom taxonomy
 * kudos to http://www.wpbeginner.com/wp-tutorials/create-custom-taxonomies-wordpress/
 * @return bool True if the taxonomy was created, false if not
 */
function bt_create_taxonomy() {
	// do nothing if taxonomy already exists
	if( taxonomy_exists( 'bible' ) )
		return false;
	// Add new taxonomy, make it hierarchical like categories
	// first do the translations part for GUI
	$labels = array(
		'name' => _x( 'Bible taxonomy', 'taxonomy general name', 'bible-taxonomy'),
		'singular_name' => _x( 'Bible taxonomy', 'taxonomy singular name', 'bible-taxonomy'),
		'search_items' =>  __( 'Search Bible references', 'bible-taxonomy'),
		'all_items' => __( 'All Bible references', 'bible-taxonomy'),
		'parent_item' => __( 'Parent Bible reference', 'bible-taxonomy'),
		'parent_item_colon' => __( 'Parent Bible reference:', 'bible-taxonomy'),
		'edit_item' => __( 'Edit Bible reference', 'bible-taxonomy'),
		'update_item' => __( 'Update Bible reference', 'bible-taxonomy'),
		'add_new_item' => __( 'Add New Bible reference', 'bible-taxonomy'),
		'new_item_name' => __( 'New Bible reference', 'bible-taxonomy'),
		'menu_name' => __( 'Bible Taxonomy', 'bible-taxonomy'),
	);
	// Register the taxonomy
	register_taxonomy( 'bible', array('post'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'bible' ),
	));
	// taxonomy was created
	return true;
}
