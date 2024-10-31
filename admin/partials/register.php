<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://screeney.com/
 * @since      1.0.0
 *
 * @package    Screeney
 * @subpackage Screeney/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1><img src="<?php echo SCREENEY_URI; ?>admin/img/screeney.svg" alt="<?php _e( 'Screeney', 'screeney' ); ?>"></h1>

    <p><?php _e( 'To start using this plugin you\'ll need to authenticate with Screeney.', 'screeney' ); ?></p>

    <a href="<?php echo esc_url( $auth_url ); ?>" class="button button-primary button-hero">
        <?php _e( 'Authenticate', 'screeney' ); ?>
    </a>
</div>