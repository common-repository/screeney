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

    <h2><?php _e( sprintf( 'Settings for %s in %s', $project_name, $team_name ), 'screeney' ); ?></h2>

    <a href="<?php echo admin_url( 'tools.php?page=screeney' ); ?>" class="button screeney-settings-button"><?php _e( 'Screeney Issues', 'screeney' ); ?></a>

    <form method="post" action="<?php echo add_query_arg( 'screeney_page', 'settings', admin_url( 'tools.php?page=screeney' ) ); ?>" class="form-wrap" style="margin-top: 3em">
        <input type="hidden" name="screeney_action" value="role_select">

        <label style="margin-bottom: 2em" class="label"><strong><?php _e( 'Choose who can see Screeney (selecting none will show to everyone)', 'screeney' ); ?>:</strong></label>

        <?php foreach ( $roles as $role => $role_info ): ?>
            <label class="">
                <input type="checkbox" name="screeney_roles[]" value="<?php echo $role; ?>" <?php echo in_array( $role, $current_roles ) ? 'checked="checked"' : ''; ?>> <?php echo $role_info['name']; ?>
            </label>
        <?php endforeach; ?>

        <button type="submit" class="button button-primary" style="margin-top: 2em"><?php _e( 'Update', 'screeney' ); ?></button>
    </form>

</div>