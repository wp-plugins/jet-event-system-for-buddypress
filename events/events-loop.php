<?php /* Querystring is set via AJAX in _inc/ajax.php - bp_dtheme_object_filter() */ ?>

<?php do_action( 'bp_before_events_loop' ) ?>

<?php if ( bp_has_events( bp_ajax_querystring( 'events' ) ) ) : ?>

	<div class="pagination">

		<div class="pag-count" id="event-dir-count">
			<?php bp_events_pagination_count() ?>
		</div>

		<div class="pagination-links" id="event-dir-pag">
			<?php bp_events_pagination_links() ?>
		</div>

	</div>

	<ul id="events-list" class="item-list">
	<?php while ( bp_events() ) : bp_the_event(); ?>

		<li>
			<div class="item-avatar">
				<a href="<?php bp_event_permalink() ?>"><?php bp_event_avatar( 'type=thumb&width=50&height=50' ) ?></a>
			</div>

			<div class="item">
				<div class="item-title"><a href="<?php bp_event_permalink() ?>"><?php bp_event_name() ?></a></div>
				<div class="item-meta">
					<?php _e('Short description:','jet-event-system') ?> <?php bp_event_description_excerpt() ?>				
				</div>				
				<div class="item-desc">
					<span><?php _e('The event will be held in the city:','jet-event-system') ?> <?php bp_event_placedcity() ?><?php if ( bp_event_is_visible() ) { ?>, <?php _e('at ','jet-event-system') ?><?php bp_event_placedaddress() ?><? } ?></span><br />				
					<?php _e('From: ','jet-event-system') ?><span class="meta"><?php bp_event_edtsd() ?></span> <?php _e('to: ','jet-event-system') ?> <span class="activity"><?php bp_event_edted() ?></span>
				</div>

				<?php do_action( 'bp_directory_events_item' ) ?>
			</div>

			<div class="action">
				<?php bp_event_join_button() ?>

				<div class="meta">
					<?php bp_event_type() ?> / <?php bp_event_member_count() ?><br />
					<span class="activity"><?php printf( __( 'Last activity: %s ago', 'jet-event-system' ), bp_get_event_last_active() ) ?></span>
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