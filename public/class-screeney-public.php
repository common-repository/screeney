<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://screeney.com/
 * @since      1.0.0
 *
 * @package    Screeney
 * @subpackage Screeney/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Screeney
 * @subpackage Screeney/public
 * @author     Screeney <daryll@screeney.com>
 */
class Screeney_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Screeney Project
     *
     * @since   1.0.0
     * @access  private
     * @var     mixed|void
     */
    private $project;

    /**
     * Roles that can see Screeney on the front end
     *
     * @since   1.0.0
     * @access  private
     * @var     mixed|void
     */
    private $roles;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version     The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->project     = json_decode( wp_unslash( get_option( 'screeney_project', false ) ) );
        $this->roles       = get_option( 'screeney_roles', array() );
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
         * defined in Screeney_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Screeney_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        if ( $this->project && $this->show_screeney() ) {

            wp_enqueue_script( $this->plugin_name, sprintf( '%s/load/%s.js', SCREENEY_URL, $this->project->uuid ), array(), $this->version, true );
        }

    }

    /**
     * Can the user see screeney?
     *
     * @return bool
     */
    public function show_screeney() {

        // If not defined then show for all
        if ( empty( $this->roles ) ) {
            return true;
        }

        // If roles are defined, don't show for logged out users
        if ( ! is_user_logged_in() ) {
            return false;
        }

        // Get logged in user roles
        $current_user_roles = wp_get_current_user()->roles;

        // Does the current user have a role that allows them to see Screeney?
        $result = array_intersect( $this->roles, $current_user_roles );
        if ( count( $result ) > 0 ) {
            return true;
        }

        return false;
    }

}
