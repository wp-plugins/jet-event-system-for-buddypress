<?php /* Querystring is set via AJAX in _inc/ajax.php - bp_dtheme_object_filter() */ ?>

<?php do_action( 'bp_before_events_loop' ) ?>

<?php if ( bp_jes_has_events( bp_ajax_querystring( 'events' ) ) ) : ?>

	<div class="pagination">

		<div class="pag-count" id="event-dir-count">
			<?php jes_bp_events_pagination_count() ?>
		</div>

		<div class="pagination-links" id="event-dir-pag">
			<?php jes_bp_events_pagination_links() ?>
		</div>

	</div>

	<ul id="events-list" class="item-list">
	<?php while ( jes_bp_events() ) : bp_jes_the_event(); ?>

		<li>
			<div class="item-avatar">
				<a href="<?php jes_bp_event_permalink() ?>"><?php jes_bp_event_avatar( 'type=thumb&width=50&height=50' ) ?></a>
			</div>
<?php if ( datetounix(date("j/m/Y H:i")) > datetounix(jes_bp_get_event_edted())) { ?>
				<div style="background-color : #FFFF66;">
<?php } else { ?>
				<div>
<?php } ?>
			<div class="item" style="width:80%;">
				<div class="item-title"><a href="<?php jes_bp_event_permalink() ?>"><?php jes_bp_event_name() ?></a></div>
				<div class="item-meta">
					<span class="meta"><em><?php jes_bp_event_type() ?></em></span><br>
					<?php _e('Short description:','jet-event-system') ?> <?php jes_bp_event_description_excerpt() ?>				
				</div>				
				<div class="item-desc">
					<span><?php _e('The event will be held in the city:','jet-event-system') ?> <?php jes_bp_event_placedcity() ?><?php if ( jes_bp_event_is_visible() ) { ?>, <?php _e('at ','jet-event-system') ?><?php jes_bp_event_placedaddress() ?><? } ?></span><br />				
					<?php _e('From: ','jet-event-system') ?><span class="meta"><?php jes_bp_event_edtsd() ?></span> <?php _e('to: ','jet-event-system') ?> <span><?php jes_bp_event_edted() ?></span>
				</div>

				<?php do_action( 'bp_directory_events_item' ) ?>
			</div>
</div>
			<div class="action">
				<?php bp_event_join_button() ?>

				<div class="meta">
					<?php _e('Classification:','jet-event-system') ?>: <br /><?php jes_bp_event_etype() ?><br />
					<?php jes_bp_event_member_count() ?><br />
					<span class="activity"><?php printf( __( 'Last activity:<br /> %s ago', 'jet-event-system' ), jes_bp_get_event_last_active() ) ?></span>
				</div>

				<?php do_action( 'bp_directory_events_actions' ) ?>
			</div>

			<div class="clear"></div>
		</li>

	<?php endwhile; ?>
	</ul>

	<?php do_action( 'bp_after_events_loop' ) ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no events found.', 'jet-event-system' ) ?></p>
	</div>

<?php endif; ?>