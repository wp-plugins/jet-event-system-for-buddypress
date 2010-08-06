<?php

class JES_BP_Events_Widget extends WP_Widget {
	function jes_bp_events_widget() {
		parent::WP_Widget(false, $name = __( 'Events', 'jet-event-system' ) );
		if ( is_active_widget( false, false, $this->id_base ) )
			wp_enqueue_script( 'events_widget_events_list-js', WP_PLUGIN_URL . '/jet-event-system-for-buddypress/js/widget-events.js', array('jquery') );
	}

	function widget($args, $instance) {
		global $bp;
	    extract( $args );

		echo $before_widget;
		echo $before_title
		   . $widget_name
		   . $after_title; 
	$data = get_option( 'jes_events' );
	$show_navi = $instance['show_navi'];
	$showonlyadmin = $instance['showonlyadmin'];
	$archive_color = $instance['archive_color'];  ?>

<?php if (!$data[ 'jes_events_code_index' ]) { ?>
	<noindex>
<?php } ?>

		<?php if ( bp_jes_has_events( 'type=soon&per_page=' . $instance['max_events'] . '&max=' . $instance['max_events'] ) ) : ?>
<?php if ($show_navi) { ?>		
			<div class="item-options" id="events-list-options">
				<span class="ajax-loader" id="ajax-loader-events"></span>
				<a href="<?php echo site_url() . '/' . $bp->jes_events->slug ?>" id="soon-events"><?php _e("Soon", 'jet-event-system') ?></a> |
				<a href="<?php echo site_url() . '/' . $bp->jes_events->slug ?>" id="newest-events"><?php _e("Newest", 'jet-event-system') ?></a> |
				<a href="<?php echo site_url() . '/' . $bp->jes_events->slug ?>" id="recently-active-events"><?php _e("Active", 'jet-event-system') ?></a> |
				<a href="<?php echo site_url() . '/' . $bp->jes_events->slug ?>" id="popular-events" class="selected"><?php _e("Popular", 'jet-event-system') ?></a>
			</div>
<?php } ?>
<?php
		$kdate_now = 1 + datetounix(date("d/m/Y H:i"));
?>
			<ul id="events-list" class="item-list">
				<?php while ( jes_bp_events() ) : bp_jes_the_event(); ?>
<?php
		$kdate_end = 1 + datetounix(jes_bp_get_event_edted());
		if (  $kdate_now > $kdate_end )
			{
				$check_keydate = 1;
			}
			else
			{
				$check_keydate = 0;
			}
		$keyvisible = 1;
		if ($check_keydate and $showonlyadmin )
			{
			if ( current_user_can('manage_options') )
				{
				$keyvisible = 1;
				}
				else
				{
				$keyvisible = 0;
				}
			}
		if ($keyvisible)
			{ ?>
				<li>
					<div class="item-avatar">
							<a href="<?php jes_bp_event_permalink() ?>"><?php jes_bp_event_avatar_thumb() ?></a>
							<div class="item-title">
								<a href="<?php jes_bp_event_permalink() ?>" title="<?php jes_bp_event_name() ?>"><?php jes_bp_event_name() ?></a>
							</div>
<?php if ( $check_keydate ) { ?>
				<em><span style="color : #<?php echo $archive_color ?>;"><?php _e('Archive event','jet-event-system') ?></span></em>
<?php } else { ?>
				<em><span style="color : #33CC00;"><?php _e('Active event','jet-event-system') ?></span></em>
<?php } ?>				
						</div>

						<div class="item">

							<div style="font-size:85%;">
								<span><?php _e('In city:','jet-event-system') ?> <?php jes_bp_event_placedcity() ?>,<br /><?php _e('Start:','jet-event-system') ?> <?php jes_bp_event_edtsd() ?><br /><?php _e('End:','jet-event-system') ?> <?php jes_bp_event_edted() ?></span>
							</div>
						</div>
					</li>
			<?php } ?>
				<?php endwhile; ?>
			</ul>
			<?php wp_nonce_field( 'events_widget_events_list', '_wpnonce-events' ); ?>
			<input type="hidden" name="events_widget_max" id="events_widget_max" value="<?php echo attribute_escape( $instance['max_events'] ); ?>" />

		<?php else: ?>

			<div class="widget-error">
				<?php _e('There are no events to display.', 'jet-event-system') ?>
			</div>

		<?php endif; ?>
<?php if (!$data[ 'jes_events_code_index' ]) { ?>
</noindex>
<?php } ?>
		<?php echo $after_widget; ?>
	<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['max_events'] = strip_tags( $new_instance['max_events'] );
		$instance['show_navi'] = strip_tags( $new_instance['show_navi'] );
		$instance['showonlyadmin'] = strip_tags( $new_instance['showonlyadmin'] );		
		$instance['archive_color'] = strip_tags( $new_instance['archive_color'] );
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'max_events' => 5 ) );
		$max_events = strip_tags( $instance['max_events'] );
		$show_navi = $instance['show_navi'];
		$showonlyadmin = $instance['showonlyadmin'];
		$archive_color = strip_tags( $instance['archive_color'] );		
		?>

		<p><label for="<?php echo $this->get_field_id('max_events'); ?>"><?php _e('Max events to show:', 'jet-event-system'); ?> 
		<input id="<?php echo $this->get_field_id( 'max_events' ); ?>" name="<?php echo $this->get_field_name( 'max_events' ); ?>" type="text" value="<?php echo attribute_escape( $max_events ); ?>" style="width: 30%" /></label></p>
<p><label for="<?php echo $this->get_field_id('show_navi'); ?>"><?php _e('Show navigation:', 'jet-event-system'); ?>
		<input class="checkbox" type="checkbox" <?php if ($show_navi) {echo 'checked="checked"';} ?> id="<?php echo $this->get_field_id('show_navi'); ?>" name="<?php echo $this->get_field_name('show_navi'); ?>" value="1" /></label></p>	
		
<p><label for="<?php echo $this->get_field_id('showonlyadmin'); ?>"><?php _e('Show archived events only for administrator:', 'jet-event-system'); ?>
		<input type="checkbox" <?php if ($showonlyadmin) {echo 'checked="checked"';} ?> id="<?php echo $this->get_field_id('showonlyadmin'); ?>" name="<?php echo $this->get_field_name('showonlyadmin'); ?>" value="1" /></label></p>	
		
		<p><label for="<?php echo $this->get_field_id('archive_color'); ?>"><?php _e('Color to archive events:', 'jet-event-system'); ?> <input id="<?php echo $this->get_field_id( 'archive_color' ); ?>" name="<?php echo $this->get_field_name( 'archive_color' ); ?>" type="text" value="<?php echo attribute_escape( $archive_color ); ?>" style="width: 30%" /></label></p>		

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

	if ( bp_jes_has_events( 'type=' . $type . '&per_page=' . $_POST['max_events'] . '&max=' . $_POST['max_events'] ) ) : ?>
		<?php echo "0[[SPLIT]]"; ?>

		<ul id="events-list" class="item-list">
			<?php while ( jes_bp_events() ) : bp_jes_the_event(); ?>
				<li>
					<div class="item-avatar">
						<a href="<?php jes_bp_event_permalink() ?>"><?php jes_bp_event_avatar_thumb() ?></a>
					</div>

					<div class="item">
						<div class="item-title"><a href="<?php jes_bp_event_permalink() ?>" title="<?php jes_bp_event_name() ?>"><?php jes_bp_event_name() ?></a></div>
						<div class="item-meta">
							<span>
								<?php
								if ( 'newest-events' == $_POST['filter'] ) {
									printf( __( 'created %s ago', 'jet-event-system' ), jes_bp_get_event_date_created() );
								} else if ( 'recently-active-events' == $_POST['filter'] ) {
									printf( __( 'active %s ago', 'jet-event-system' ), jes_bp_get_event_last_active() );
								} else if ( 'popular-events' == $_POST['filter'] ) {
									jes_bp_event_member_count();
								}
								 else if ( 'soon-events' == $_POST['filter'] ) {
								?><?php _e('In city:','jet-event-system') ?> <?php jes_bp_event_placedcity() ?>, <?php _e('Start:','jet-event-system') ?> <?php jes_bp_event_edtsd() ?> <?php _e('End:','jet-event-system') ?> <?php jes_bp_event_edted() ?> <?
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
	add_action('widgets_init', create_function('', 'return register_widget("JES_BP_Events_Widget");') );
	add_action( 'wp_ajax_widget_events_list', 'events_ajax_widget_events_list' );
?>
