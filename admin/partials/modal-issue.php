<div class="js-screeney-single-issue screeney-single-issue">

</div>

<script type="text/html" id="tmpl-screeney-single-issue">

    <button class="screeney-single-issue__close js-screeney-single-issue-close" type="button">
        <span class="dashicons dashicons-no"></span>
    </button>

    <div class="screeney-single-issue__wrap">

        <div class="screeney-single-issue__info-wrap">
            <table class="screeney-single-issue__table">
                <tbody>
                <tr>
                    <th><?php _e( 'Issue', 'screeney' ); ?></th>
                    <td>{{ data.issue }}</td>
                </tr>
                <tr>
                    <th><?php _e( 'URL', 'screeney' ); ?></th>
                    <td>
                        <a href="{{ data.url }}" target="_blank">{{ data.url }}</a>
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Date Reported', 'screeney' ); ?></th>
                    <td>{{ data.created_at }}</td>
                </tr>
                <tr>
                    <th colspan="2">&nbsp;</th>
                </tr>
                <tr>
                    <th><?php _e( 'Reporter Name', 'screeney' ); ?></th>
                    <td>{{ data.name }}</td>
                </tr>
                <tr>
                    <th><?php _e( 'Reporter Email', 'screeney' ); ?></th>
                    <td>{{ data.email }}</td>
                </tr>
                </tbody>
            </table>

            <div class="screeney-single-issue__buttons">
                <a href="{{ data.issue_url }}" target="_blank" class="button button-primary">
                    <?php _e( 'View on Screeney', 'screeney' ); ?>
                </a>
                <# if ( ! data.completed ) { #>
                    <a href="javascript:;" class="button button-primary js-screeney-mark-completed" style="margin-left: 2em" data-screeneyid="{{ data.id }}" data-screeneyproject="{{ data.project }}">
                        <?php _e( 'Mark issue completed', 'screeney' ); ?>
                    </a>
                <# } #>
            </div>

            <table class="screeney-single-issue__table screeney-single-issue__table--browser-info" style="margin-top: 2em;">
                <thead>
                <tr>
                    <th colspan="2" style="font-size: 1.5em;"><?php _e( 'Browser Info', 'screeney' ); ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th><?php _e( 'App Code Name', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.appCodeName }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'App Name', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.appName }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'App Version', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.appVersion }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Cookie Enabled', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.cookieEnabled }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'On Line', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.onLine }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Platform', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.platform }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'User Agent', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.userAgent }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Language', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.language }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Inner Height', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.innerHeight }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Inner Width', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.innerWidth }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Outer Height', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.outerHeight }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Outer Width', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.outerWidth }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Scroll X', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.scrollX }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Scroll Y', 'screeney' ); ?></th>
                    <td>
                        {{ data.data.scrollY }}
                    </td>
                </tr>
                <tr>
                    <th><?php _e( 'Plugins', 'screeney' ); ?></th>
                    <td>
                        {{{ data.data.plugins }}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="screeney-single-issue__image-wrap">
            <a href="{{ data.screenshot }}" target="_blank">
                <img src="{{ data.screenshot }}">
            </a>
        </div>

    </div>
</script>