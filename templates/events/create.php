<?php get_header() ?>

	<div id="content">
		<div class="padder">
<?php $edata = get_option( 'jes_events' ); ?>
	<?php 	$edata = get_option( 'jes_events' );
			$createa = $edata[ 'jes_events_createnonadmin_disable' ];
	?>

		<form action="<?php bp_event_creation_form_action() ?>" method="post" id="create-event-form" class="standard-form" enctype="multipart/form-data">
			<h3><?php _e( 'Create a Event', 'jet-event-system' ) ?> &nbsp;<a class="button" href="<?php echo bp_get_root_domain() . '/' . JES_SLUG . '/' ?>"><?php _e( 'Events Directory', 'jet-event-system' ) ?></a></h3>

			<?php do_action( 'bp_before_create_event' ) ?>

			<div class="item-list-tabs no-ajax" id="event-create-tabs">
				<ul>
					<?php bp_event_creation_tabs(); ?>
				</ul>
			</div>

			<?php do_action( 'template_notices' ) ?>

		
			
			<div class="item-body" id="event-create-body">

				<?php /* Event creation step 1: Basic event details */ ?>
				<?php if ( bp_is_event_creation_step( 'event-details' ) ) : ?>

					<?php do_action( 'bp_before_event_details_creation_step' ); ?>
<table valign="top">
<tr>
<td width="50%" style="vertical-align:top;">
<h4><?php _e('Base event details','jet-event-system') ?></h4>
					<label for="event-name"><?php _e('* Event Name', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<input type="text" name="event-name" id="event-name" value="<?php bp_new_event_name() ?>" />

<?php 
		$shifta = $edata[ 'jes_events_adminapprove_enable' ];
		if ($shifta)
			{
				if ( current_user_can('manage_options') )
					{ ?>
						<input type="hidden" name="event-eventapproved" value="1">
					<?php }
						else
					{ ?>
						<input type="hidden" name="event-eventapproved" value="0">
					<?php }
					
			} 
				else
			{ ?>
				<input type="hidden" name="event-eventapproved" value="1">
			<?php } ?>
			
					<label for="event-etype"><?php _e('* Event classification', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					
<?php if (!$edata[ 'jes_events_class_enable' ])  { ?>					
					<input type="text" name="event-etype" id="event-etype" value="<?php bp_new_event_etype() ?>" />	
<?php } else { ?>
<select name="event-etype" id="event-etype" size = "1">
<option value="<?php echo $edata['jes_events_text_one' ] ?>"><?php echo $edata['jes_events_text_one' ] ?></option> 
<?php if ($edata['jes_events_text_two' ] != null) { ?>
<option value="<?php echo $edata['jes_events_text_two' ] ?>"><?php echo $edata['jes_events_text_two' ] ?></option>
<?php } ?>
<?php if ($edata['jes_events_text_three' ] != null) { ?>
<option value="<?php echo $edata['jes_events_text_three' ] ?>"><?php echo $edata['jes_events_text_three' ] ?></option>
<?php } ?>
<?php if ($edata['jes_events_text_four' ] != null) { ?>
<option value="<?php echo $edata['jes_events_text_four' ] ?>"><?php echo $edata['jes_events_text_four' ] ?></option>
<?php } ?>
<?php if ($edata['jes_events_text_five' ] != null) { ?>
<option value="<?php echo $edata['jes_events_text_five' ] ?>"><?php echo $edata['jes_events_text_five' ] ?></option>
</select>
<?php } ?>
<?php } ?>					
					
					<label for="event-desc"><?php _e('* Event Description', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<textarea name="event-desc" id="event-desc"><?php bp_new_event_description() ?></textarea>

<?php if ($edata[ 'jes_events_countryopt_enable' ])
		{ ?>
					<label for="event-placedcountry"><?php _e('* Event Placed Country', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<input type="text" name="event-placedcountry" id="event-placedcountry" value="<?php bp_new_event_placedcountry() ?>" />
		<?php } else { ?>
					<input type="hidden" name="event-placedcountry" id="event-placedcountry" value="<?php $edata[ 'jes_events_countryopt_def' ] ?>" />		
		<?php } ?>

<?php if ($edata[ 'jes_events_stateopt_enable' ])
		{ ?>
					<label for="event-placedstate"><?php _e('* Event Placed State', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<input type="text" name="event-placedstate" id="event-placedstate" value="<?php bp_new_event_placedstate() ?>" />
		<?php } else { ?>
					<input type="hidden" name="event-placedstate" id="event-placedstate" value="<?php $edata[ 'jes_events_stateopt_def' ] ?>" />		
		<?php } ?>		
					
					<label for="event-placedcity"><?php _e('* Event Placed City', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<input type="text" name="event-placedcity" id="event-placedcity" value="<?php bp_new_event_placedcity() ?>" />					

					<label for="event-placedaddress"><?php _e('Event Placed address', 'jet-event-system') ?></label>
					<input type="text" name="event-placedaddress" id="event-placedaddress" value="<?php bp_new_event_placedaddress() ?>" />						
</td>
<td width="50%" style="vertical-align:top;">					
					<label for="event-eventterms"><h4><?php _e('Special Conditions', 'jet-event-system') ?></h4></label>
					<textarea name="event-eventterms" id="event-eventterms"><?php bp_new_event_eventterms() ?></textarea>
<h4><?php _e('News for event','jet-event-system') ?></h4>					
					<label for="event-newspublic"><?php _e('Event Public news', 'jet-event-system') ?></label>
					<textarea name="event-newspublic" id="event-newspublic"><?php bp_new_event_newspublic() ?></textarea>

					<label for="event-newsprivate"><?php _e('Event Private news', 'jet-event-system') ?></label>
					<textarea name="event-newsprivate" id="event-newsprivate"><?php bp_new_event_newsprivate() ?></textarea>					
</td>
</tr>
<tr>
<td width="50%" style="vertical-align:bottom;">
<script type="text/javascript">
		jQuery(function($) {
			$.mask.definitions['~']='[+-]';
			$('#event-edtsd').mask('99/99/9999 99:99');
			$('#event-edted').mask('99/99/9999 99:99');
});</script>
<h4><?php _e('Date event','jet-event-system') ?></h4>
					<label for="event-edtsd"><?php _e('* Event Start date', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<input type="text" name="event-edtsd" id="event-edtsd" value="<?php bp_new_event_edtsd() ?>" />
					<br /><span class="small"><?php _e('dd/mm/yyyy HH:mm','jet-event-system'); ?></span>
</td>
<td width="50%" style="vertical-align:bottom;">
					<label for="event-edtsd"><?php _e('* Event End date', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<input type="text" name="event-edted" id="event-edted" value="<?php bp_new_event_edted() ?>" />	
					<br /><span class="small"><?php _e('dd/mm/yyyy HH:mm','jet-event-system'); ?></span>
</td>
</tr>
</table>					
<?php /* <div class="checkbox">
<label><input type="checkbox" name="event-allday" value="1"<?php if (bp_get_new_event_allday() ) { ?> checked="checked"<?php } ?> /> <?php _e('This is an all day event','bp-events') ?></label>
<label><input type="checkbox" name="event-weekly" value="1"<?php if (bp_get_new_event_weekly() ) { ?> checked="checked"<?php } ?> /> <?php _e('This is an repeat weekly event','bp-events') ?></label>
</div> */ ?>
					
					<?php do_action( 'bp_after_event_details_creation_step' ); ?>

					<?php wp_nonce_field( 'events_create_save_event-details' ) ?>

				<?php endif; ?>

				<?php /* Event creation step 2: Event settings */ ?>
				<?php if ( bp_is_event_creation_step( 'event-settings' ) ) : ?>

					<?php do_action( 'bp_before_event_settings_creation_step' ); ?>

					<?php if ( function_exists('bp_wire_install') ) : ?>
					<div class="checkbox">
						<label><input type="checkbox" name="event-show-wire" id="event-show-wire" value="1"<?php if ( jet_get_new_event_enable_wire() ) { ?> checked="checked"<?php } ?> /> <?php _e('Enable comment wire', 'jet-event-system') ?></label>
					</div>
					<?php endif; ?>
<?php /*
					<?php if ( function_exists('bp_forums_is_installed_correctly') ) : ?>
						<?php if ( bp_forums_is_installed_correctly() ) : ?>
							<div class="checkbox">
								<label><input type="checkbox" name="event-show-forum" id="event-show-forum" value="1"<?php if ( jet_get_new_event_enable_forum() ) { ?> checked="checked"<?php } ?> /> <?php _e('Enable discussion forum', 'jet-event-system') ?></label>
							</div>
						<?php else : ?>
							<?php if ( is_site_admin() ) : ?>
								<div class="checkbox">
									<label><input type="checkbox" disabled="disabled" name="disabled" id="disabled" value="0" /> <?php printf( __('<strong>Attention Site Admin:</strong> Event forums require the <a href="%s">correct setup and configuration</a> of a bbPress installation.', 'jet-event-system' ), bp_get_root_domain() . '/wp-admin/admin.php?page=bb-forums-setup' ) ?></label>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>

					<hr />
*/ ?>
					<h4><?php _e( 'Privacy Options', 'jet-event-system' ); ?></h4>

					<div class="radio">
						<label><input type="radio" name="event-status" value="public"<?php if ( 'public' == bp_get_new_event_status() || !bp_get_new_event_status() ) { ?> checked="checked"<?php } ?> />
							<strong><?php _e( 'This is a public event', 'jet-event-system' ) ?></strong>
							<ul>
								<li><?php _e( 'Any site member can join this event.', 'jet-event-system' ) ?></li>
								<li><?php _e( 'This event will be listed in the events directory and in search results.', 'jet-event-system' ) ?></li>
								<li><?php _e( 'Event content and activity will be visible to any site member.', 'jet-event-system' ) ?></li>
							</ul>
						</label>

						<label><input type="radio" name="event-status" value="private"<?php if ( 'private' == bp_get_new_event_status() ) { ?> checked="checked"<?php } ?> />
							<strong><?php _e( 'This is a private event', 'jet-event-system' ) ?></strong>
							<ul>
								<li><?php _e( 'Just send a request to join, users can join the event.', 'jet-event-system' ) ?></li>
								<li><?php _e( 'This event will be listed in the events directory and in search results.', 'jet-event-system' ) ?></li>
								<li><?php _e( 'Event content and activity will only be visible to members of the event.', 'jet-event-system' ) ?></li>
							</ul>
						</label>

						<label><input type="radio" name="event-status" value="hidden"<?php if ( 'hidden' == bp_get_new_event_status() ) { ?> checked="checked"<?php } ?> />
							<strong><?php _e('This is a hidden event', 'jet-event-system') ?></strong>
							<ul>
								<li><?php _e( 'Only users who are invited can join the event.', 'jet-event-system' ) ?></li>
								<li><?php _e( 'This event will not be listed in the events directory or search results.', 'jet-event-system' ) ?></li>
								<li><?php _e( 'Event content and activity will only be visible to members of the event.', 'jet-event-system' ) ?></li>
							</ul>
						</label>
					</div>

					<?php do_action( 'bp_after_event_settings_creation_step' ); ?>

					<?php wp_nonce_field( 'events_create_save_event-settings' ) ?>

				<?php endif; ?>

				<?php /* Event creation step 3: Avatar Uploads */ ?>
				<?php if ( bp_is_event_creation_step( 'event-avatar' ) ) : ?>

					<?php do_action( 'bp_before_event_avatar_creation_step' ); ?>

					<?php if ( !bp_get_avatar_admin_step() ) : ?>

						<div class="left-menu">
							<?php bp_new_event_avatar() ?>
						</div><!-- .left-menu -->

						<div class="main-column">
							<p><?php _e("Upload an image to use as an avatar for this event. The image will be shown on the main event page, and in search results.", 'jet-event-system') ?></p>

							<p>
								<input type="file" name="file" id="file" />
								<input type="submit" name="upload" id="upload" value="<?php _e( 'Upload Image', 'jet-event-system' ) ?>" />
								<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
							</p>

							<p><?php _e( 'To skip the avatar upload process, hit the "Next Step" button.', 'jet-event-system' ) ?></p>
						</div><!-- .main-column -->

					<?php endif; ?>

					<?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

						<h3><?php _e( 'Crop Event Avatar', 'jet-event-system' ) ?></h3>

						<img src="<?php bp_avatar_to_crop() ?>" id="avatar-to-crop" class="avatar" alt="<?php _e( 'Avatar to crop', 'jet-event-system' ) ?>" />

						<div id="avatar-crop-pane">
							<img src="<?php bp_avatar_to_crop() ?>" id="avatar-crop-preview" class="avatar" alt="<?php _e( 'Avatar preview', 'jet-event-system' ) ?>" />
						</div>

						<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php _e( 'Crop Image', 'jet-event-system' ) ?>" />

						<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src() ?>" />
						<input type="hidden" name="upload" id="upload" />
						<input type="hidden" id="x" name="x" />
						<input type="hidden" id="y" name="y" />
						<input type="hidden" id="w" name="w" />
						<input type="hidden" id="h" name="h" />

					<?php endif; ?>

					<?php do_action( 'bp_after_event_avatar_creation_step' ); ?>

					<?php wp_nonce_field( 'events_create_save_event-avatar' ) ?>

				<?php endif; ?>

				<?php /* Event creation step 4: Invite friends to event */ ?>
				<?php if ( bp_is_event_creation_step( 'event-invites' ) ) : ?>

					<?php do_action( 'bp_before_jes_event_invites_creation_step' ); ?>

					<?php if ( function_exists( 'bp_get_total_friend_count' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
						<div class="left-menu">

							<div id="invite-list">
								<ul>
									<?php bp_new_jes_event_invite_friend_list() ?>
								</ul>

								<?php wp_nonce_field( 'events_invite_uninvite_user', '_wpnonce_invite_uninvite_user' ) ?>
							</div>

						</div><!-- .left-menu -->

						<div class="main-column">

							<div id="message" class="info">
								<p><?php _e('Select people to invite from your friends list.', 'jet-event-system'); ?></p>
							</div>

							<?php /* The ID 'friend-list' is important for AJAX support. */ ?>
							<ul id="friend-list" class="item-list">
							<?php if ( bp_event_has_invite_jes() ) : ?>

								<?php while ( bp_jes_event_invite_jes() ) : bp_event_the_invite(); ?>

									<li id="<?php bp_jes_event_invite_item_id() ?>">
										<?php bp_jes_event_invite_user_avatar() ?>

										<h4><?php bp_jes_event_invite_user_link() ?></h4>
										<span class="activity"><?php bp_jes_event_invite_user_last_active() ?></span>

										<div class="action">
											<a class="remove" href="<?php bp_jes_event_invite_user_remove_invite_url() ?>" id="<?php bp_jes_event_invite_item_id() ?>"><?php _e( 'Remove Invite', 'jet-event-system' ) ?></a>
										</div>
									</li>

								<?php endwhile; ?>

								<?php wp_nonce_field( 'events_send_invites', '_wpnonce_send_invites' ) ?>
							<?php endif; ?>
							</ul>

						</div><!-- .main-column -->

					<?php else : ?>

						<div id="message" class="info">
							<p><?php _e( 'Once you have built up friend connections you will be able to invite others to your event. You can send invites any time in the future by selecting the "Send Invites" option when viewing your new event.', 'jet-event-system' ); ?></p>
						</div>

					<?php endif; ?>

					<?php wp_nonce_field( 'events_create_save_event-invites' ) ?>
					<?php do_action( 'bp_after_jes_event_invites_creation_step' ); ?>

				<?php endif; ?>

				<?php do_action( 'events_custom_create_steps' ) // Allow plugins to add custom event creation steps ?>

				<?php do_action( 'bp_before_event_creation_step_buttons' ); ?>

				<?php if ( 'crop-image' != bp_get_avatar_admin_step() ) : ?>
					<div class="submit" id="previous-next">
						<?php /* Previous Button */ ?>
						<?php if ( !bp_is_first_event_creation_step() ) : ?>
							<input type="button" value="&larr; <?php _e('Previous Step', 'jet-event-system') ?>" id="event-creation-previous" name="previous" onclick="location.href='<?php bp_event_creation_previous_link() ?>'" />
						<?php endif; ?>

						<?php /* Next Button */ ?>
						<?php if ( !bp_is_last_event_creation_step() && !bp_is_first_event_creation_step() ) : ?>
							<input type="submit" value="<?php _e('Next Step', 'jet-event-system') ?> &rarr;" id="event-creation-next" name="save" />
						<?php endif;?>

						<?php /* Create Button */ ?>
						<?php if ( bp_is_first_event_creation_step() ) : ?>
							<input type="submit" value="<?php _e('Create Event and Continue', 'jet-event-system') ?> &rarr;" id="event-creation-create" name="save" />
						<?php endif; ?>

						<?php /* Finish Button */ ?>
						<?php if ( bp_is_last_event_creation_step() ) : ?>
							<input type="submit" value="<?php _e('Finish', 'jet-event-system') ?> &rarr;" id="event-creation-finish" name="save" />
						<?php endif; ?>
					</div>
				<?php endif;?>

				<?php do_action( 'bp_after_event_creation_step_buttons' ); ?>

				<?php /* Don't leave out this hidden field */ ?>
				<input type="hidden" name="event_id" id="event_id" value="<?php bp_new_event_id() ?>" />

				<?php do_action( 'bp_directory_events_content' ) ?>

			</div><!-- .item-body -->

			<?php do_action( 'bp_after_create_event' ) ?>

		</form>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>
