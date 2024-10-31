<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.sales-suckers.com
 * @since             1.0.0
 * @package           Salessuckers
 *
 * @wordpress-plugin
 * Plugin Name:       Sales-Suckers Connector
 * Plugin URI:        https://www.sales-suckers.com/plugins/wordpress
 * Description:       Connector between Sales-Suckers and Wordpress, to easily integrate the tracking code
 * Version:           1.0.8
 * Author:            Sales-Suckers
 * Author URI:        https://www.sales-suckers.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       salessuckers
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SALES_SUCKERS_VERSION', '1.0.8' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-salessuckers-activator.php
 */
function activate_salessuckers() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-salessuckers-activator.php';
	Salessuckers_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-salessuckers-deactivator.php
 */
function deactivate_salessuckers() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-salessuckers-deactivator.php';
	Salessuckers_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_salessuckers' );
register_deactivation_hook( __FILE__, 'deactivate_salessuckers' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-salessuckers.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_salessuckers() {

	$plugin = new Salessuckers();
	$plugin->run();

}
run_salessuckers();
