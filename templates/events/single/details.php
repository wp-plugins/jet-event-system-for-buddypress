<?php do_action( 'bp_before_event_details_admin' ); ?>

<?php $edata = get_option( 'jes_events' ); ?>

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
				<h5><strong><?php _e('Event Location:', 'jet-event-system') ?></strong></h5>
				<span><strong><?php _e('The event will take place:','jet-event-system'); ?></strong><br />
						<?php
							if ( $edata[ 'jes_events_countryopt_enable' ] )
								{
									jes_bp_event_placedcountry(); ?> ,
							<?php } ?>
					<?php	if ( $edata[ 'jes_events_stateopt_enable' ] )
								{
									jes_bp_event_placedstate(); ?> ,
							<?php } ?>
					<strong> <?php _e('in city:','jet-event-system') ?></strong> <?php jes_bp_event_placedcity() ?></span>
		<?php if ( jes_bp_event_is_visible() ) { ?>
					<br /><strong><?php _e('Event address', 'jet-event-system') ?>:</strong> <?php jes_bp_event_placedaddress() ?>
		<?php } ?>
		</td>
		<td width="50%" style="vertical-align:top;">
	<?php	if ( $edata[ 'jes_events_specialconditions_enable' ] )
				{ ?>
					<?php if ( jes_bp_get_event_eventterms() != null ) { ?>
							<h4><?php _e('Special Conditions', 'jet-event-system') ?>:</h4>
							<?php jes_bp_event_eventterms() ?>
					<?php } ?>
			<?php } ?>
	<?php if ( $edata[ 'jes_events_publicnews_enable' ] || $edata[ 'jes_events_privatenews_enable' ] )
				{ ?>
					<h4><?php _e('News for event','jet-event-system') ?></h4>
		<?php if ( $edata[ 'jes_events_publicnews_enable' ] )
					{ ?>			
						<?php if ( jes_bp_get_event_newspublic() != null ) { ?>
								<h5><strong><?php _e('Public Event News', 'jet-event-system') ?>:</strong></h5>
								<p><?php jes_bp_event_newspublic() ?></p>
						<?php } ?>
				<?php } ?>
		<?php if ( $edata[ 'jes_events_privatenews_enable' ] )
					{ ?>			
						<?php if (bp_is_user_events()) { ?>
								<?php if ( jes_bp_get_event_newsprivate() != null ) { ?>
											<h5><strong><?php _e('Private Event News', 'jet-event-system') ?>:</strong></h5>
											<p><?php jes_bp_event_newsprivate() ?></p>
								<?php } ?>
						<?php } ?>
				<?php } ?>
			<?php } ?>			
		</td>
	</tr>
	<tr>
		<td width="50%" style="vertical-align:bottom;">
			<h4><?php _e('Event Date','jet-event-system') ?></h4>
				<p><strong><?php _e('Event Start date', 'jet-event-system') ?>:</strong> <?php jes_bp_event_edtsd() ?></p>
		</td>
		<td width="50%" style="vertical-align:bottom;">
			<p><strong><?php _e('Event End date', 'jet-event-system') ?>:</strong> <?php jes_bp_event_edted() ?></p>
		</td>
	</tr>
</table>

	<?php do_action( 'bp_after_event_details_admin' ); ?>