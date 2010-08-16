
	<?php do_action( 'bp_before_event_details_admin' ); ?>

<table valign="top">
<tr>
<td width="50%" style="vertical-align:top;">
<h4><?php _e('Base event details','jet-event-system') ?></h4>
			<h5><strong><?php _e('Event Name', 'jet-event-system') ?>:</strong></h5>
				<p><?php jes_bp_event_name() ?></p>
			<h5><strong><?php _e('Event classification', 'jet-event-system') ?>:</strong></h5>
				<p><?php jes_bp_event_etype() ?></p>				
			<h5><strong><?php _e('Event Description', 'jet-event-system') ?>:</strong></h5>
				<?php jes_bp_event_description() ?>
			<h5><strong><?php _e('Event Placed City', 'jet-event-system') ?>:</strong></h5>
				<p><?php jes_bp_event_placedcity() ?></p>
<?php if ( jes_bp_event_is_visible() ) { ?>
			<h5><strong><?php _e('Event Placed address', 'jet-event-system') ?>:</strong></h5>
				<p><?php jes_bp_event_placedaddress() ?></p>
<?php } ?>
					
</td>
<td width="50%" style="vertical-align:top;">
			<h4><?php _e('Special Conditions', 'jet-event-system') ?>:</h4>
				<?php jes_bp_event_eventterms() ?>
			<h4><?php _e('News for event','jet-event-system') ?></h4>	
			<h5><strong><?php _e('Event Public news', 'jet-event-system') ?>:</strong></h5>
				<p><?php jes_bp_event_newspublic() ?></p>
			<?php if (bp_is_user_events()) { ?>
			<h5><strong><?php _e('Event Private news', 'jet-event-system') ?>:</strong></h5>
				<p><?php jes_bp_event_newsprivate() ?></p>
			<?php } ?>					
</td>
</tr>
<tr>
<td width="50%" style="vertical-align:bottom;">
<h4><?php _e('Date event','jet-event-system') ?></h4>
					<p><strong><?php _e('Event Start date', 'jet-event-system') ?>:</strong> <?php jes_bp_event_edtsd() ?></p>
</td>
<td width="50%" style="vertical-align:bottom;">
					<p><strong><?php _e('Event End date', 'jet-event-system') ?>:</strong> <?php jes_bp_event_edted() ?></p>
</td>
</tr>
</table>		

	<?php do_action( 'bp_after_event_details_admin' ); ?>
