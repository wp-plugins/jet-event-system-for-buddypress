<?php

/* Register widgets for events component */
function events_register_widgets() {
	add_action('widgets_init', create_function('', 'return register_widget("BP_Events_Widget");') );
}
add_action( 'bp_register_widgets', 'events_register_widgets' );

/*** EVENTS WIDGET *****************/

class BP_Events_Widget extends WP_Widget {
	function bp_events_widget() {
		parent::WP_Widget( false, $name = __( 'Events', 'jet-event-system' ) );

		if ( is_active_widget( false, false, $this->id_base ) )
			wp_enqueue_script( 'events_widget_events_list-js', WP_PLUGIN_URL . '/jet-event-system-for-buddypress/js/widget-events.js', array('jquery') );
	}

	function widget($args, $instance) {
		global $bp;

	    extract( $args );

		echo $before_widget;
		echo $before_title
		   . $widget_name
		   . $after_title; ?>

		<?php if ( bp_has_events( 'type=popular&per_page=' . $instance['max_events'] . '&max=' . $instance['max_events'] ) ) : ?>
			<div class="item-options" id="events-list-options">
				<span class="ajax-loader" id="ajax-loader-events"></span>
				<a href="<?php echo site_url() . '/' . $bp->events->slug ?>" id="soon-events"><?php _e("Soon", 'jet-event-system') ?></a> |
				<a href="<?php echo site_url() . '/' . $bp->events->slug ?>" id="newest-events"><?php _e("Newest", 'jet-event-system') ?></a> |
				<a href="<?php echo site_url() . '/' . $bp->events->slug ?>" id="recently-active-events"><?php _e("Active", 'jet-event-system') ?></a> |
				<a href="<?php echo site_url() . '/' . $bp->events->slug ?>" id="popular-events" class="selected"><?php _e("Popular", 'jet-event-system') ?></a>
			</div>

			<ul id="events-list" class="item-list">
				<?php while ( bp_events() ) : bp_the_event(); ?>
					<li>
						<div class="item-avatar">
							<a href="<?php bp_event_permalink() ?>"><?php bp_event_avatar_thumb() ?></a>
							<div class="item-title">
								<a href="<?php bp_event_permalink() ?>" title="<?php bp_event_name() ?>"><?php bp_event_name() ?></a>
							</div>							
						</div>

						<div class="item">

							<div class="item-meta">
								<span><?php _e('In city:','jet-event-system') ?> <?php bp_event_placedcity() ?>, <?php _e('Start:','jet-event-system') ?> <?php bp_event_edtsd() ?> <?php _e('End:','jet-event-system') ?> <?php bp_event_edted() ?></span>
							</div>
						</div>
					</li>

				<?php endwhile; ?>
			</ul>
			<?php wp_nonce_field( 'events_widget_events_list', '_wpnonce-events' ); ?>
			<input type="hidden" name="events_widget_max" id="events_widget_max" value="<?php echo attribute_escape( $instance['max_events'] ); ?>" />

		<?php else: ?>

			<div class="widget-error">
				<?php _e('There are no events to display.', 'jet-event-system') ?>
			</div>

		<?php endif; ?>

		<?php echo $after_widget; ?>
	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['max_events'] = strip_tags( $new_instance['max_events'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'max_events' => 5 ) );
		$max_events = strip_tags( $instance['max_events'] );
		?>

		<p><label for="bp-events-widget-events-max"><?php _e('Max events to show:', 'jet-event-system'); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'max_events' ); ?>" name="<?php echo $this->get_field_name( 'max_events' ); ?>" type="text" value="<?php echo attribute_escape( $max_events ); ?>" style="width: 30%" /></label></p>
	<?php
	}
}

function events_ajax_widget_events_list() {
	global $bp;

	check_ajax_referer('events_widget_events_list');

	switch ( $_POST['filter'] ) {
		case 'newest-events':
			$type = 'newest';
		break;
		case 'recently-active-events':
			$type = 'active';
		break;
		case 'popular-events':
			$type = 'popular';
		break;
		case 'soon-events':
			$type = 'soon';
		break;		
	}

	if ( bp_has_events( 'type=' . $type . '&per_page=' . $_POST['max_events'] . '&max=' . $_POST['max_events'] ) ) : ?>
		<?php echo "0[[SPLIT]]"; ?>

		<ul id="events-list" class="item-list">
			<?php while ( bp_events() ) : bp_the_event(); ?>
				<li>
					<div class="item-avatar">
						<a href="<?php bp_event_permalink() ?>"><?php bp_event_avatar_thumb() ?></a>
					</div>

					<div class="item">
						<div class="item-title"><a href="<?php bp_event_permalink() ?>" title="<?php bp_event_name() ?>"><?php bp_event_name() ?></a></div>
						<div class="item-meta">
							<span>
								<?php
								if ( 'newest-events' == $_POST['filter'] ) {
									printf( __( 'created %s ago', 'jet-event-system' ), bp_get_event_date_created() );
								} else if ( 'recently-active-events' == $_POST['filter'] ) {
									printf( __( 'active %s ago', 'jet-event-system' ), bp_get_event_last_active() );
								} else if ( 'popular-events' == $_POST['filter'] ) {
									bp_event_member_count();
								}
								 else if ( 'soon-events' == $_POST['filter'] ) {
								?><?php _e('In city:','jet-event-system') ?> <?php bp_event_placedcity() ?>, <?php _e('Start:','jet-event-system') ?> <?php bp_event_edtsd() ?> <?php _e('End:','jet-event-system') ?> <?php bp_event_edted() ?> <?
								}								
								?>
							</span>
						</div>
					</div>
				</li>

			<?php endwhile; ?>
		</ul>
		<?php wp_nonce_field( 'events_widget_events_list', '_wpnonce-events' ); ?>
		<input type="hidden" name="events_widget_max" id="events_widget_max" value="<?php echo attribute_escape( $_POST['max_events'] ); ?>" />

	<?php else: ?>

		<?php echo "-1[[SPLIT]]<li>" . __("No events matched the current filter.", 'jet-event-system'); ?>

	<?php endif;

}
add_action( 'wp_ajax_widget_events_list', 'events_ajax_widget_events_list' );
?>
