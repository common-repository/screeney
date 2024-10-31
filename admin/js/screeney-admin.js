(function( $ ) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
	 *
	 * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
	 *
	 * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $( window ).load( function() {
        var listings_buttons = $( '.js-screeney-view-issue' );

        if ( listings_buttons.length > 0 ) {

            var screeney_modal = $( '.js-screeney-single-issue' );
            var screeney_template = wp.template( 'screeney-single-issue' );

            /**
             * Open single issue modal
             */
            listings_buttons.on( 'click', function() {
                var data = $( this ).data( 'issue' );
                data.data = screeneyTestJSON( data.data ) ? JSON.parse( data.data ) : data.data;
                data.data.plugins = Array.isArray( data.data.plugins ) ? data.data.plugins.join( '<br>' ) : data.data.plugins;
                screeney_modal.html( screeney_template( data ) );

                screeney_modal.addClass( 'screeney-single-issue--open' );
            } );

            /**
             * Close modal
             */
            screeney_modal.on( 'click', '.js-screeney-single-issue-close', function() {
                screeney_modal.removeClass( 'screeney-single-issue--open' );
            } );

            /**
             * AJAX request to complete an issue
             */
            screeney_modal.on( 'click', '.js-screeney-mark-completed', function() {
                var id = $( this ).data( 'screeneyid' );
                var project = $( this ).data( 'screeneyproject' );

                var data = {
                    'action': 'screeney_mark_complete',
                    'issue': id
                };

                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                jQuery.post( ajaxurl, data, function( response ) {
                    if ( response.success ) {
                        location.reload();
                    }
                } );
            } );

            /**
             * Bond escape to close the modal
             */
            $( document ).keyup( function( e ) {
                if ( e.keyCode === 27 ) {
                    screeney_modal.removeClass( 'screeney-single-issue--open' );
                }
            } );
        }
    } );

})( jQuery );

/**
 * Check if string is JSON before parsing
 *
 * @param text
 * @returns {boolean}
 */
function screeneyTestJSON( text ) {
    try {
        JSON.parse( text );
        return true;
    }
    catch ( error ) {
        return false;
    }
}