<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://screeney.com/
 * @since      1.0.0
 *
 * @package    Screeney
 * @subpackage Screeney/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Screeney
 * @subpackage Screeney/includes
 * @author     Screeney <daryll@screeney.com>
 */
class Screeney_Deactivator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate() {
        delete_option( 'screeney_access_token' );
        delete_option( 'screeney_team' );
        delete_option( 'screeney_project' );
        delete_option( 'screeney_roles' );
    }

}
