<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://screeney.com/
 * @since             1.0.0
 * @package           Screeney
 *
 * @wordpress-plugin
 * Plugin Name:       Screeney
 * Plugin URI:        https://screeney.com/
 * Description:       Connects your website with the Screeney bug tracking application.
 * Version:           1.0.0
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       screeney
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
define( 'SCREENEY_VERSION', '1.0.0' );

/**
 * Plugin Directory Locations
 */
define( 'SCREENEY_PATH', plugin_dir_path( __FILE__ ) );
define( 'SCREENEY_URI', plugin_dir_url( __FILE__ ) );

/**
 * Plugin Directory Locations
 */
define( 'SCREENEY_URL', 'https://screeney.com' );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-screeney-activator.php
 */
function activate_screeney() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-screeney-activator.php';
	Screeney_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-screeney-deactivator.php
 */
function deactivate_screeney() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-screeney-deactivator.php';
	Screeney_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_screeney' );
register_deactivation_hook( __FILE__, 'deactivate_screeney' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-screeney.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_screeney() {

	$plugin = new Screeney();
	$plugin->run();

}
run_screeney();

/**
 * Wrapper for getting things from screeney api
 *
 * @param $url
 * @param $token
 *
 * @return array|WP_Error
 */
function screeney_get( $url, $token ) {
    return wp_remote_get( SCREENEY_URL . '/api' . $url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $token,
        ),
    ) );
}

/**
 * Wrapper for posting things to the screeney api
 *
 * @param       $url
 * @param       $token
 * @param array $body
 *
 * @return array|WP_Error
 */
function screeney_post( $url, $token, $body = array() ) {
    return wp_remote_post( SCREENEY_URL . '/api' . $url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $token,
        ),
        'body' => $body
    ) );
}