<?php do_action( 'bp_before_event_request_membership_content' ) ?>

<?php if ( !bp_event_has_requested_membership() ) : ?>
	<p><?php printf( __( "You are requesting to become a member of the event '%s'.", "jet-event-system" ), bp_get_event_name( false ) ); ?></p>

	<form action="<?php bp_event_form_action('request-membership') ?>" method="post" name="request-membership-form" id="request-membership-form" class="standard-form">
		<label for="event-request-membership-comments"><?php _e( 'Comments (optional)', 'jet-event-system' ); ?></label>
		<textarea name="event-request-membership-comments" id="event-request-membership-comments"></textarea>

		<?php do_action( 'bp_event_request_membership_content' ) ?>

		<p><input type="submit" name="event-request-send" id="event-request-send" value="<?php _e( 'Send Request', 'jet-event-system' ) ?> &rarr;" />

		<?php wp_nonce_field( 'events_request_membership' ) ?>
	</form><!-- #request-membership-form -->
<?php endif; ?>

<?php do_action( 'bp_after_event_request_membership_content' ) ?>
