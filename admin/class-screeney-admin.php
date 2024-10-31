<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://screeney.com/
 * @since      1.0.0
 *
 * @package    Screeney
 * @subpackage Screeney/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Screeney
 * @subpackage Screeney/admin
 * @author     Screeney <daryll@screeney.com>
 */
class Screeney_Admin {

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
     * Screeney Access Token
     *
     * @since   1.0.0
     * @access  private
     * @var     mixed|void
     */
    private $access_token;

    /**
     * Screeney Team
     *
     * @since   1.0.0
     * @access  private
     * @var     mixed|void
     */
    private $team;

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
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version     The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name  = $plugin_name;
        $this->version      = $version;
        $this->access_token = get_option( 'screeney_access_token', false );
        $this->team         = json_decode( wp_unslash( get_option( 'screeney_team', false ) ) );
        $this->project      = json_decode( wp_unslash( get_option( 'screeney_project', false ) ) );
        $this->roles        = get_option( 'screeney_roles', array() );
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

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

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/screeney-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/screeney-admin.js', array(
            'jquery',
            'wp-util',
        ), $this->version, false );

    }

    /**
     * Add the screeney tools page
     */
    public function add_screeney_page() {
        add_management_page( __( 'Screeney', 'screeney' ), __( 'Screeney', 'screeney' ), 'manage_options', 'screeney', function () {
            if ( ! $this->access_token ) {
                $this->authorise_screeney();
            } else {

                if ( ! $this->team ) {
                    $this->choose_team();
                } elseif ( ! $this->project ) {
                    $this->choose_project();
                } else {
                    $page = isset( $_GET['screeney_page'] ) ? $_GET['screeney_page'] : 'issues';

                    if ( 'issues' === $page ) {
                        $this->get_issues();
                    } else {
                        $this->get_settings();
                    }
                }

            }
        } );
    }

    /**
     * Auth screeney to get an access token
     */
    public function authorise_screeney() {
        $auth_url = SCREENEY_URL . '/wp-plugin/auth?site=' . urlencode( get_admin_url( null, 'tools.php?page=screeney' ) );

        include( SCREENEY_PATH . '/admin/partials/register.php' );
    }

    /**
     * Save the posted variables
     */
    public function save_variables() {
        if ( isset( $_GET['screeney_access_token'] ) ) {
            add_option( 'screeney_access_token', $_GET['screeney_access_token'] );
            wp_redirect( get_admin_url( null, 'tools.php?page=screeney' ) );
            exit;
        }

        if ( isset( $_POST['screeney_action'] ) ) {
            switch ( $_POST['screeney_action'] ) {

                case 'team_select':
                    if ( $_POST['team'] != '' ) {
                        add_option( 'screeney_team', $_POST['team'] );
                        wp_redirect( get_admin_url( null, 'tools.php?page=screeney' ) );
                        exit;
                    }
                    break;

                case 'project_select':
                    if ( $_POST['project'] !== '' ) {
                        add_option( 'screeney_project', $_POST['project'] );
                        wp_redirect( get_admin_url( null, 'tools.php?page=screeney' ) );
                        exit;
                    }
                    break;

                case 'role_select':
                    if ( isset( $_POST['screeney_roles'] ) ) {
                        update_option( 'screeney_roles', $_POST['screeney_roles'] );
                        wp_redirect( add_query_arg( 'screeney_page', 'settings', admin_url( 'tools.php?page=screeney' ) ) );
                        exit;
                    } else {
                        update_option( 'screeney_roles', array() );
                        wp_redirect( add_query_arg( 'screeney_page', 'settings', admin_url( 'tools.php?page=screeney' ) ) );
                        exit;
                    }
                    break;

            }
        }
    }

    /**
     * Choose the team
     */
    public function choose_team() {
        // This gets the teams
        $response = screeney_get( '/teams', $this->access_token );

        if ( is_array( $response ) ) {
            $header = $response['headers']; // array of http header lines
            $body   = json_decode( $response['body'] ); // use the content

            include( SCREENEY_PATH . '/admin/partials/team.php' );
        }
    }

    /**
     * Choose the project
     */
    public function choose_project() {
        $response = screeney_get( '/team/' . $this->team->id . '/projects', $this->access_token );

        if ( is_array( $response ) ) {
            $header = $response['headers']; // array of http header lines
            $body   = json_decode( $response['body'] ); // use the content

            include( SCREENEY_PATH . '/admin/partials/project.php' );
        }
    }

    /**
     * Get the issue list
     */
    public function get_issues() {
        $response = screeney_get( '/team/' . $this->team->id . '/project/' . $this->project->uuid . '/issues', $this->access_token );

        if ( is_array( $response ) ) {
            $header = $response['headers']; // array of http header lines
            $body   = json_decode( $response['body'] ); // use the content

            $issueTable = new Screeney_Issue_Table();
            $issueTable->add_data( $body );
            $issueTable->set_project_id( $this->project->uuid );
            $issueTable->prepare_items();

            $team_name    = $this->team->name;
            $project_name = $this->project->name;

            include( SCREENEY_PATH . '/admin/partials/issues.php' );
            include( SCREENEY_PATH . '/admin/partials/modal-issue.php' );
        }
    }

    /**
     * Used by an AJAX call. Marks an issue as completed.
     */
    public function ajax_mark_completed() {
        $issue_id = (int) $_POST['issue'];
        $body     = array(
            'success' => false,
        );

        $response = screeney_post( '/issue/' . $issue_id . '/complete', $this->access_token );

        if ( is_array( $response ) ) {
            $body = json_decode( $response['body'] ); // use the content
        }

        header( 'Content-Type: application/json' );
        echo json_encode( $body );
        exit;
    }

    /**
     * Add custom query vars
     *
     * @param $vars
     *
     * @return array
     */
    public function screeney_query_vars( $vars ) {
        $vars[] = 'screeney_page';

        return $vars;
    }

    /**
     * Show settings page
     */
    public function get_settings() {
        global $wp_roles;

        $team_name    = $this->team->name;
        $project_name = $this->project->name;
        $all_roles    = $wp_roles->roles;

        $roles         = apply_filters( 'editable_roles', $all_roles );
        $current_roles = $this->roles;

        include( SCREENEY_PATH . '/admin/partials/settings.php' );

    }
}
