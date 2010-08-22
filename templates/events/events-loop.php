<?php /* Querystring is set via AJAX in _inc/ajax.php - bp_dtheme_object_filter() */ ?>

<?php do_action( 'bp_before_events_loop' ) ?>

<?php	$showevent = 1;
		$edata = get_option( 'jes_events' );
		$eshowevent = $edata[ 'jes_events_addnavicatalog_disable' ];
		$sortby = $edata[ 'jes_events_sort_by' ]; ?>

<?php if ( bp_jes_has_events( bp_ajax_querystring( 'events' )) ) : ?>

	<div class="pagination">

		<div class="pag-count" id="event-dir-count">
			<?php jes_bp_events_pagination_count() ?>
		</div>

		<div class="pagination-links" id="event-dir-pag">
			<?php jes_bp_events_pagination_links() ?>
			<?php _e('Style:','jet-event-system'); ?> <?php _e($edata['jes_events_style'],'jet-event-system'); ?>
		</div>

	</div>
<?php 

		if ( !is_user_logged_in() and !$eshowevent )
				{ ?>
			<div id="message" class="info">
				<p><?php _e('Private events are not shown, register to view','jet-event-system'); ?></p>
			</div>
		<?php	} ?>	
	<ul id="events-list" class="item-list">
<?php
// Standart style Event Catalog 
?>
<?php if ( ($edata['jes_events_style'] == 'Standart') or ($edata['jes_events_style'] == 'Standart with Full Description') ) 
			{ ?>
	
	<?php while ( jes_bp_events() ) : bp_jes_the_event(); ?>
	
	<?php 
		$er = jes_bp_get_event_type();
	// Admin Approve
	$shiftcan = 0;
	$showeventnona = $edata[ 'jes_events_adminapprove_enable' ];
		if ( !is_user_logged_in() and !$eshowevent and $er == 'Private Event' ) { $showevent = 0; } else { $showevent = 1; }
		if ( !jes_bp_get_event_eventapproved() and $showeventnona ) {
		if ( current_user_can('manage_options') )
			{ 
				$showevent = 1;
				$shiftcan = 1;
			}
				else
			{
				$showevent = 0;
				$shiftcan = 0;
			} 
		} ?>
	<?php if ( $showevent )
				{ ?>
		<li>
			<div class="item-avatar">
				<a href="<?php jes_bp_event_permalink() ?>"><?php jes_bp_event_avatar( 'type=thumb&width=50&height=50' ) ?></a>
			</div>

			<div class="item" style="width:80%;">
				<div class="item-title"><a href="<?php jes_bp_event_permalink() ?>"><?php jes_bp_event_name() ?></a></div>			
				<div class="item-meta">
	<?php	if ( datetounix(date("d/m/Y H:i")) > datetounix(jes_bp_get_event_edted())) { ?>
				<em><span style="color : #CCFF00;"><?php _e('Archive event','jet-event-system') ?></span></em> , 
	<?php } else { ?>
				<em><span style="color : #33CC00;"><?php _e('Active event','jet-event-system') ?></span></em> , 
	<?php } ?>				
					<span class="meta"><em><?php jes_bp_event_type() ?></em></span><br />
				<?php if ($edata['jes_events_style'] == 'Standart') { ?>
					<?php _e('Short description:','jet-event-system') ?> <?php jes_bp_event_description_excerpt() ?>
				<?php } else { ?>
					<?php _e('Description:','jet-event-system') ?> <?php jes_bp_event_description() ?>
				<?php } ?>
				</div>				
				<div class="item-desc">
					<span><?php _e('The event will take place:','jet-event-system'); ?>
							<?php
								if ( $edata[ 'jes_events_countryopt_enable' ] )
									{
										jes_bp_event_placedcountry(); ?> ,
								<?php } ?>
						<?php	if ( $edata[ 'jes_events_stateopt_enable' ] )
									{
										jes_bp_event_placedstate(); ?> ,
								<?php } ?></span>
											
					<span><?php _e('in city:','jet-event-system') ?> <?php jes_bp_event_placedcity() ?><?php if ( jes_bp_event_is_visible() ) { ?>, <?php _e('at ','jet-event-system') ?><?php jes_bp_event_placedaddress() ?><? } ?></span><br />				
					<?php _e('From: ','jet-event-system') ?><span class="meta"><?php jes_bp_event_edtsd() ?></span> <?php _e('to: ','jet-event-system') ?> <span><?php jes_bp_event_edted() ?></span>
				</div>

				<?php do_action( 'bp_directory_events_item' ) ?>
			</div>
	<div class="action">
				<?php bp_event_join_button() ?>

				<div class="meta">
					<?php if ( $shiftcan ) 
								{ ?>
									<span class="meta"><em><?php _e('Need aprrove event!','jet-event-system'); ?></em></span>
								<?php }
					?>
					<strong><?php jes_bp_event_etype() ?></strong><br />
					<?php jes_bp_event_member_count() ?><br />
					<span class="activity"><?php printf( __( 'Last activity:<br /> %s ago', 'jet-event-system' ), jes_bp_get_event_last_active() ) ?></span>
				</div>

				<?php do_action( 'bp_directory_events_actions' ) ?>
			</div>

			<div class="clear"></div>
		</li>
<?php } ?>
	<?php  endwhile; ?>

<?php } ?>	


<?php
// Twitter style Event Catalog 
?>
<?php if ($edata['jes_events_style'] == 'Twitter' ) 
			{ ?>
	
	<?php while ( jes_bp_events() ) : bp_jes_the_event(); ?>
	
	<?php 
		$er = jes_bp_get_event_type();
	// Admin Approve
	$shiftcan = 0;
	$showeventnona = $edata[ 'jes_events_adminapprove_enable' ];
		if ( !is_user_logged_in() and !$eshowevent and $er == 'Private Event' ) { $showevent = 0; } else { $showevent = 1; }
		if ( !jes_bp_get_event_eventapproved() and $showeventnona ) {
		if ( current_user_can('manage_options') )
			{ 
				$showevent = 1;
				$shiftcan = 1;
			}
				else
			{
				$showevent = 0;
				$shiftcan = 0;
			} 
		} ?>
	<?php if ( $showevent )
				{ ?>
		<li>
			<div class="item-avatar">
				<a href="<?php jes_bp_event_permalink() ?>"><?php jes_bp_event_avatar( 'type=thumb&width=50&height=50' ) ?></a>
			</div>

			<div class="item" style="width:80%;">
					<span style="font-size:80%;"><a href="<?php jes_bp_event_permalink() ?>"><?php jes_bp_event_name() ?></a> 
					<?php	if ( datetounix(date("d/m/Y H:i")) > datetounix(jes_bp_get_event_edted())) { ?>
									<em><span style="color : #CCFF00;"><?php _e('Archive event','jet-event-system') ?></span></em> , 
					<?php } else { ?>
									<em><span style="color : #33CC00;"><?php _e('Active event','jet-event-system') ?></span></em> , 
					<?php } ?>				
					<em><?php jes_bp_event_type() ?></em>, <strong><?php jes_bp_event_etype() ?></strong>
					<br />
					<?php _e('From: ','jet-event-system') ?><span class="meta"><?php jes_bp_event_edtsd() ?></span> <?php _e('to: ','jet-event-system') ?> <?php jes_bp_event_edted() ?>
					<?php _e('The event will take place:','jet-event-system'); ?>
							<?php
								if ( $edata[ 'jes_events_countryopt_enable' ] )
									{
										jes_bp_event_placedcountry(); ?> ,
								<?php } ?>
						<?php	if ( $edata[ 'jes_events_stateopt_enable' ] )
									{
										jes_bp_event_placedstate(); ?> ,
								<?php } ?>
					<?php _e('in city:','jet-event-system') ?> <?php jes_bp_event_placedcity() ?><?php if ( jes_bp_event_is_visible() ) { ?>, <?php _e('at ','jet-event-system') ?><?php jes_bp_event_placedaddress() ?><? } ?><br />				
					<?php _e('Description:','jet-event-system') ?> <?php jes_bp_event_description() ?>	
	</span>					
				<?php do_action( 'bp_directory_events_item' ) ?>
			</div>
	<div class="action">
				<?php bp_event_join_button() ?>

				<div class="meta">
					<?php if ( $shiftcan ) 
								{ ?>
									<span class="meta"><em><?php _e('Need aprrove event!','jet-event-system'); ?></em></span>
								<?php }
					?>
					<br />
					<?php jes_bp_event_member_count() ?>
					<span class="activity"><?php printf( __( 'Last activity:<br /> %s ago', 'jet-event-system' ), jes_bp_get_event_last_active() ) ?></span>
				</div>

				<?php do_action( 'bp_directory_events_actions' ) ?>
			</div>

			<div class="clear"></div>
		</li>
<?php } ?>
	<?php  endwhile; ?>

<?php } ?>	
	
	</ul>

	<?php do_action( 'bp_after_events_loop' ) ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no events found.', 'jet-event-system' ) ?></p>
	</div>

<?php endif; ?>