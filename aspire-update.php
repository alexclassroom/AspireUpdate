<?php
/**
 * AspireUpdate - Update plugins and themes for WordPress.
 *
 * @package     aspire-update
 * @author      AspireUpdate
 * @copyright   AspireUpdate
 * @license     GPL-3.0-or-later
 *
 * Plugin Name:       AspireUpdate
 * Plugin URI:        https://aspirepress.org/
 * Description:       Update plugins and themes for WordPress.
 * Version:           0.5
 * Author:            AspirePress
 * Author URI:        https://docs.aspirepress.org/aspireupdate/
 * Requires at least: 5.3
 * Requires PHP:      7.4
 * Tested up to:      6.7
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       AspireUpdate
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! defined( 'AP_VERSION' ) ) {
	define( 'AP_VERSION', '0.5' );
}


add_action( 'plugins_loaded', 'define_constant' );
function define_constant() {
	if ( ! defined( 'AP_PATH' ) ) {
		define( 'AP_PATH', dirname( plugin_basename( __FILE__ ) ) );
	}
}

require_once __DIR__ . '/includes/autoload.php';

add_action( 'plugins_loaded', 'aspire_update' );
function aspire_update() {
	if ( ! defined( 'AP_RUN_TESTS' ) ) {
		new AspireUpdate\Controller();
	}
}

register_activation_hook( __FILE__, 'aspire_update_activation_hook' );
function aspire_update_activation_hook() {
	register_uninstall_hook( __FILE__, 'aspire_update_uninstall_hook' );
}

function aspire_update_uninstall_hook() {
	$admin_settings = AspireUpdate\Admin_Settings::get_instance();
	$admin_settings->delete_all_settings();
}
