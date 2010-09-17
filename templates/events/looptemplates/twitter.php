<?php
/**************************************/
/* Twitter Template for Event Loop    */
/*                                    */
/* Base Template					  */
/**************************************/
?>
<?php
$_eventstatus = eventstatus(jes_bp_get_event_edtsd(),jes_bp_get_event_edtsth(),jes_bp_get_event_edtstm(),jes_bp_get_event_edted(),jes_bp_get_event_edteth(),jes_bp_get_event_edtetm());
?>
	<li>
		<div class="item-avatar">
			<a href="<?php jes_bp_event_permalink() ?>"><?php jes_bp_event_avatar( 'type=thumb&width=50&height=50' ) ?></a>
		</div>

		<div class="item" style="width:80%;">
			<span style="font-size:80%;"><a href="<?php jes_bp_event_permalink() ?>"><?php jes_bp_event_name() ?></a> 
			<em><?php echo $_eventstatus; ?></em>				
			<em><?php jes_bp_event_type() ?></em>, <strong><?php jes_bp_event_etype() ?></strong>
				<br />
			<?php _e('From: ','jet-event-system') ?><span class="meta"><?php jes_bp_event_edtsd() ?>, <?php jes_bp_event_edtsth() ?>:<?php jes_bp_event_edtstm() ?></span> <?php _e('to: ','jet-event-system') ?> <?php jes_bp_event_edted() ?>, , <?php jes_bp_event_edteth() ?>:<?php jes_bp_event_edtetm() ?>
			<?php _e('The event will take place:','jet-event-system');
			if ( $jes_adata[ 'jes_events_countryopt_enable' ] )
				{
					jes_bp_event_placedcountry(); ?> ,
			<?php }
			if ( $jes_adata[ 'jes_events_stateopt_enable' ] )
				{
					jes_bp_event_placedstate(); ?> ,
			<?php }
			_e('in city:','jet-event-system') ?> <?php jes_bp_event_placedcity() ?><?php if ( jes_bp_event_is_visible() ) { ?>, <?php _e('at ','jet-event-system') ?><?php jes_bp_event_placedaddress() ?> <?php } ?><br />				
			<?php _e('Description:','jet-event-system') ?> <?php jes_bp_event_description() ?>	
	</span>					
<?php do_action( 'bp_directory_events_item' ) ?>
		</div>
	<div class="action">
			<?php 
				if (!strpos($_eventstatus,__('Past event','jet-event-system')))
					{
						bp_event_join_button();
					}
			?>
		<div class="meta">
			<?php if ( $shiftcan ) 
					{ ?>
						<span class="meta"><em><?php _e('Event requires approval!','jet-event-system'); ?></em></span>
			<?php }	?>
				<br />
			<?php jes_bp_event_member_count() ?>
				<span class="activity"><?php printf( __( 'Last activity:<br /> %s ago', 'jet-event-system' ), jes_bp_get_event_last_active() ) ?></span>
		</div>
<?php do_action( 'bp_directory_events_actions' ) ?>
	</div>
	<div class="clear"></div>
</li>
<?php
// End Template
?>