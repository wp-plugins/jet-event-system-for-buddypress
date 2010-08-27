<?php do_action( 'bp_before_event_header' ) ?>

<div id="item-actions">
	<?php if ( jes_bp_event_is_visible() ) : ?>

		<h3><?php _e( 'Event Admins', 'jet-event-system' ) ?></h3>
		<?php jes_bp_event_list_admins() ?>

		<?php do_action( 'bp_after_event_menu_admins' ) ?>

		<?php if ( jes_bp_event_has_moderators() ) : ?>
			<?php do_action( 'bp_before_event_menu_mods' ) ?>

			<h3><?php _e( 'Event Mods' , 'jet-event-system' ) ?></h3>
			<?php jes_bp_event_list_mods() ?>

			<?php do_action( 'bp_after_event_menu_mods' ) ?>
		<?php endif; ?>

	<?php endif; ?>
</div><!-- #item-actions -->

<div id="item-header-avatar">
	<a href="<?php jes_bp_event_permalink() ?>" title="<?php jes_bp_event_name() ?>">
	<?php $adata = get_option( 'jes_events' ); ?>
		<?php jes_bp_event_avatar('height='.$adata['jes_events_show_avatar_main_size'].'&width='.$adata['jes_events_show_avatar_main_size']) ?>
	</a><br />
</div><!-- #item-header-avatar -->

<div id="item-header-content">
	<h2><a href="<?php jes_bp_event_permalink() ?>" title="<?php jes_bp_event_name() ?>"><?php jes_bp_event_name() ?></a></h2>
	<span class="highlight"><?php jes_bp_event_type() ?></span> <span class="activity"><?php printf( __( 'active %s ago', 'jet-event-system' ), jes_bp_get_event_last_active() ) ?></span>
	<?php do_action( 'bp_before_event_header_meta' ) ?>

	<div id="item-meta">

		<?php bp_event_join_button() ?>

		<?php do_action( 'bp_event_header_meta' ) ?>
	</div>
</div><!-- #item-header-content -->

<?php do_action( 'bp_after_event_header' ) ?>

<?php do_action( 'template_notices' ) ?>