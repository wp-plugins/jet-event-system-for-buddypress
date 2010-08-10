<?php get_header() ?>

	<div id="content">
		<div class="padder">

		<form action="" method="post" id="events-directory-form" class="dir-form">
			<h3><?php _e( 'Events Directory', 'jet-event-system' ) ?></h3>

			<?php do_action( 'bp_before_directory_events_content' ) ?>

			<div id="event-dir-search" class="dir-search">
			<?php if ( is_user_logged_in() ) : ?><a class="button" href="<?php echo bp_get_root_domain() . '/' . JES_SLUG . '/create/' ?>"><?php _e( 'Create a Event', 'jet-event-system' ) ?></a><?php endif; ?>
				<?php bp_directory_events_search_form() ?>
			</div><!-- #event-dir-search -->

			<div class="item-list-tabs">
				<ul>
					<li class="selected" id="events-all"><a href="<?php echo bp_get_root_domain() . '/' . JES_SLUG ?>"><?php printf( __( 'All Events (%s)', 'jet-event-system' ), bp_jes_get_jes_total_event_count() ) ?></a></li>

					<?php if ( is_user_logged_in() && bp_jes_get_jes_total_event_count_for_user( bp_loggedin_user_id() ) ) : ?>
						<li id="events-personal"><a href="<?php echo bp_loggedin_user_domain() . JES_SLUG . '/my-events/' ?>"><?php printf( __( 'My Events (%s)', 'jet-event-system' ), bp_jes_get_jes_total_event_count_for_user( bp_loggedin_user_id() ) ) ?></a></li>
					<?php endif; ?>

					<?php do_action( 'jes_bp_events_directory_event_types' ) ?>

					<li id="events-order-select" class="last filter">

						<?php _e( 'Order By:', 'jet-event-system' ) ?>
						<select>
							<option value="soon"><?php _e( 'Soon', 'jet-event-system' ) ?></option>
							<option value="active"><?php _e( 'Last Active', 'jet-event-system' ) ?></option>
							<option value="popular"><?php _e( 'Most Members', 'jet-event-system' ) ?></option>
							<option value="newest"><?php _e( 'Newly Created', 'jet-event-system' ) ?></option>
							<option value="alphabetical"><?php _e( 'Alphabetical', 'jet-event-system' ) ?></option>
							<?php do_action( 'jes_bp_events_directory_order_options' ) ?>
						</select>
					</li>
				</ul>
			</div><!-- .item-list-tabs -->

			<div id="events-dir-list" class="events dir-list">
				<?php locate_template( array( 'events/events-loop.php' ), true ) ?>
			</div><!-- #events-dir-list -->
			<div>
				<span><a href="http://milordk.ru">Milordk Studio</a></span>
			</div>
			<?php do_action( 'bp_directory_events_content' ) ?>

			<?php wp_nonce_field( 'directory_events', '_wpnonce-events-filter' ) ?>

		</form><!-- #events-directory-form -->

		<?php do_action( 'bp_after_directory_events_content' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>