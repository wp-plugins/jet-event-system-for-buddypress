<?php do_action( 'bp_before_events_loop' ) ?>

<?php
	$showevent = 1;
	$jes_adata = get_option( 'jes_events' );
	$eshowevent = $jes_adata[ 'jes_events_addnavicatalog_disable' ];
	$sortby = $jes_adata[ 'jes_events_sort_by' ]; ?>

<?php if ( bp_jes_has_events( bp_ajax_querystring( 'events' )) ) : ?>

	<div class="pagination">
		<div class="pag-count" id="group-dir-count">
			<?php jes_bp_events_pagination_count() ?>
		</div>
		<div class="pagination-links" id="group-dir-pag">
			<?php jes_bp_events_pagination_links() ?>
			<?php _e('Style:','jet-event-system'); ?> <?php _e($jes_adata['jes_events_style'],'jet-event-system'); ?>
		</div>
	</div>

<?php 
	if ( !is_user_logged_in() and !$eshowevent )
		{ ?>
			<div id="message" class="info">
				<p><?php _e('Private events are not shown, register to view','jet-event-system'); ?></p>
			</div>
	<?php } ?>
<ul id="group-list" class="item-list">
<?php while ( jes_bp_events() ) : bp_jes_the_event();

	$er = jes_bp_get_event_type();

// Admin Approve
	$shiftcan = 0;
	$showeventnona = $jes_adata[ 'jes_events_adminapprove_enable' ];

// Not Private Event?
	if ( !is_user_logged_in() and !$eshowevent and $er == 'Private Event' )
		{
			$showevent = 0;
		}
			else
		{
			$showevent = 1;
		}
// Check Approved Event?
		if ( !jes_bp_get_event_eventapproved() and $showeventnona )
			{
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
			}
		
if ( $showevent )
	{
// Loop Templates
	// Standart style Event Catalog 
		if ($jes_adata['jes_events_style'] == 'Standart') 
			{
				include('looptemplates/standart.php');
		}

	// Standard will full description
		if ($jes_adata['jes_events_style'] == 'Standard will full description') 
			{
				include('looptemplates/standartfull.php');
		}

	// Twitter style Event Catalog
		if ($jes_adata['jes_events_style'] == 'Twitter' )
			{
				include('looptemplates/twitter.php');
		}

	// Custom style Event Catalog
		if ($jes_adata['jes_events_style'] == 'Custom' ) 
			{
				if (file_exists(STYLESHEETPATH . '/events/looptemplates/custom.php'))
					{
						include('looptemplates/custom.php');
					}
						else
					{
						include('looptemplates/standart.php');
					}
		}
	}
endwhile; ?>	
</ul>

	<?php do_action( 'bp_after_events_loop' ) ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no events found.', 'jet-event-system' ) ?></p>
	</div>

<?php
endif;
?>