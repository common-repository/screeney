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

    <p><?php _e( 'Choose which team you\'re connecting to:', 'screeney' ); ?></p>

    <form action="<?php echo get_admin_url( null, 'tools.php?page=screeney' ); ?>" method="post">
        <input type="hidden" name="screeney_action" value="team_select">
        <select name="team">
            <option value=""><?php _e( 'Select Team:', 'screeney' ); ?></option>
            <?php foreach ( $body as $team ): ?>
                <option value="<?php echo htmlspecialchars( json_encode( $team ) ); ?>"><?php echo $team->name; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="button button-primary"><?php _e( 'Choose Team', 'screeney' ); ?></button>

    </form>
</div>