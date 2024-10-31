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

    <h2><?php _e( sprintf( 'Issues for %s in %s', $project_name, $team_name ), 'screeney' ); ?></h2>

    <a href="<?php echo add_query_arg( 'screeney_page', 'settings', admin_url( 'tools.php?page=screeney' ) ); ?>" class="button screeney-settings-button"><?php _e( 'Screeney Settings', 'screeney' ); ?></a>

    <?php $issueTable->display(); ?>

</div>