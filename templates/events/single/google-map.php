<?php do_action( 'bp_before_event_googlemap' ); ?>

<?php if (jes_bp_get_event_placedgooglemap() != null ) { ?>

<span><strong><?php _e('The event will take place:','jet-event-system'); ?></strong>
					<?php
						if ( $edata[ 'jes_events_countryopt_enable' ] )
							{
								jes_bp_event_placedcountry(); ?> ,
						<?php } ?>
					<?php
						if ( $edata[ 'jes_events_stateopt_enable' ] )
							{
								jes_bp_event_placedstate(); ?> ,
					<?php } ?>
		<strong> <?php _e('in city:','jet-event-system') ?></strong> <?php jes_bp_event_placedcity() ?></span>
	
	<?php if ( jes_bp_event_is_visible() ) { ?>
			<p><strong><?php _e('Event address', 'jet-event-system') ?>:</strong> <?php jes_bp_event_placedaddress() ?>
			<?php if ( $edata[ 'jes_events_placednoteopt_enable' ] )
							{	?>
			<br />
			<strong><?php _e('Event note', 'jet-event-system') ?>:</strong> <?php jes_bp_event_placednote() ?>
			<?php } ?></p>
	<?php } ?>

<h4><?php _e('Google Map','jet-event-system'); ?></h4>

<img src="<?php jes_bp_event_placedgooglemap() ?>">

<?php } else { ?>
	<?php _e('Currently unavailable','jet-event-system'); ?>
<?php } ?>

<?php do_action( 'bp_after_event_googlemap' ); ?>