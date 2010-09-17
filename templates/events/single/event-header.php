<?php do_action( 'bp_before_event_header' ) ?>
<?php
	$_eventstatus = eventstatus(jes_bp_get_event_edtsd(),jes_bp_get_event_edtsth(),jes_bp_get_event_edtstm(),jes_bp_get_event_edted(),jes_bp_get_event_edteth(),jes_bp_get_event_edtetm());
?>
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
	<p><strong><?php _e('Event classification', 'jet-event-system') ?>:</strong> <?php jes_bp_event_etype() ?></p>
<?php
/*	if (jes_bp_event_forumlink())
		{
if ( bp_has_groups( 'user_id=' . bp_loggedin_user_id() . '&type=alphabetical&max=100&per_page=1&populate_extras=0' ) ) : while ( bp_groups() ) : bp_the_group();		
		?>
	   		<option value="<?php bp_group_id() ?>" <?php if ( $grp_id == bp_get_group_id() ) { echo "selected"; } ?>><?php bp_group_name()?></option>
<?php		endwhile; endif; ?>
 }*/ ?>

	<?php do_action( 'bp_before_event_header_meta' ) ?>

	<div id="item-meta">
			<?php 
				if (!strpos($_eventstatus,__('Past event','jet-event-system')))
					{
						bp_event_join_button();
					}
					else
					{ ?>
						<div id="message" class="info">
							<p><?php __('You can not join or refuse to participate in an event as this - %s','jet-event-system',$_eventstatus); ?></p>
						</div>
			<?php	}
			?>

		<?php do_action( 'bp_event_header_meta' ) ?>
	</div>
</div><!-- #item-header-content -->

<?php do_action( 'bp_after_event_header' ) ?>

<?php do_action( 'template_notices' ) ?>