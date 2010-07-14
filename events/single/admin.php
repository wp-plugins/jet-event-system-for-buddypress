<div class="item-list-tabs no-ajax" id="subnav">
	<ul>
		<?php bp_event_admin_tabs(); ?>
	</ul>
</div><!-- .item-list-tabs -->

<form action="<?php bp_event_admin_form_action() ?>" name="event-settings-form" id="event-settings-form" class="standard-form" method="post" enctype="multipart/form-data">

<?php do_action( 'bp_before_event_admin_content' ) ?>

<?php /* Edit Event Details */ ?>
<?php if ( bp_is_event_admin_screen( 'edit-details' ) ) : ?>

	<?php do_action( 'bp_before_event_details_admin' ); ?>

<table valign="top">
<tr>
<td width="50%" style="vertical-align:top;">
<h4><?php _e('Base event details','jet-event-system') ?></h4>
					<label for="event-name"><?php _e('* Event Name', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<input type="text" name="event-name" id="event-name" value="<?php jes_bp_event_name() ?>" />

					<label for="event-etype"><?php _e('* Event classification', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<input type="text" name="event-etype" id="event-etype" value="<?php jes_bp_event_etype() ?>" />					
					
					<label for="event-desc"><?php _e('* Event Description', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<textarea name="event-desc" id="event-desc"><?php jes_bp_event_description() ?></textarea>

					<label for="event-placedcity"><?php _e('* Event Placed City', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<input type="text" name="event-placedcity" id="event-placedcity" value="<?php jes_bp_event_placedcity() ?>" />					

					<label for="event-placedaddress"><?php _e('Event Placed address', 'jet-event-system') ?></label>
					<input type="text" name="event-placedaddress" id="event-placedaddress" value="<?php jes_bp_event_placedaddress() ?>" />						
</td>
<td width="50%" style="vertical-align:top;">
					<label for="event-eventterms"><h4><?php _e('Special Conditions', 'jet-event-system') ?></h4></label>
					<textarea name="event-eventterms" id="event-eventterms"><?php jes_bp_event_eventterms() ?></textarea>
<h4><?php _e('News for event','jet-event-system') ?></h4>					
					<label for="event-newspublic"><?php _e('Event Public news', 'jet-event-system') ?></label>
					<textarea name="event-newspublic" id="event-newspublic"><?php jes_bp_event_newspublic() ?></textarea>
					<label for="event-newsprivate"><?php _e('Event Private news', 'jet-event-system') ?></label>
					<textarea name="event-newsprivate" id="event-newsprivate"><?php jes_bp_event_newsprivate() ?></textarea>					
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
					<input type="text" name="event-edtsd" id="event-edtsd" value="<?php jes_bp_event_edtsd() ?>" />
					<br /><span class="small">dd/mm/yyyy HH:mm</span>
</td>
<td width="50%" style="vertical-align:bottom;">
					<label for="event-edtsd"><?php _e('* Event End date', 'jet-event-system') ?> <?php _e( '(required)', 'jet-event-system' )?></label>
					<input type="text" name="event-edted" id="event-edted" value="<?php jes_bp_event_edted() ?>" />	
					<br /><span class="small">dd/mm/yyyy HH:mm</span>
</td>
</tr>
</table>		

	<?php do_action( 'bp_after_event_details_admin' ); ?>

	<p><input type="submit" value="<?php _e( 'Save Changes', 'jet-event-system' ) ?> &rarr;" id="save" name="save" /></p>
	<?php wp_nonce_field( 'events_edit_event_details' ) ?>

<?php endif; ?>

<?php /* Manage Event Settings */ ?>
<?php if ( bp_is_event_admin_screen( 'event-settings' ) ) : ?>

	<?php do_action( 'bp_before_event_settings_admin' ); ?>

	<?php if ( function_exists('bp_wire_install') ) : ?>

		<div class="checkbox">
			<label><input type="checkbox" name="event-show-wire" id="event-show-wire" value="1"<?php bp_event_show_wire_setting() ?>/> <?php _e( 'Enable comment wire', 'jet-event-system' ) ?></label>
		</div>

	<?php endif; ?>
<?php /*
	<?php if ( function_exists('bp_forums_is_installed_correctly') ) : ?>

		<?php if ( bp_forums_is_installed_correctly() ) : ?>

			<div class="checkbox">
				<label><input type="checkbox" name="event-show-forum" id="event-show-forum" value="1"<?php jet_bp_event_show_forum_setting() ?> /> <?php _e( 'Enable discussion forum', 'jet-event-system' ) ?></label>
			</div>

		<?php endif; ?>

	<?php endif; ?>

	<hr />
*/ ?>
	<h4><?php _e( 'Privacy Options', 'jet-event-system' ); ?></h4>

	<div class="radio">
		<label>
			<input type="radio" name="event-status" value="public"<?php jet_bp_event_show_status_setting('public') ?> />
			<strong><?php _e( 'This is a public event', 'jet-event-system' ) ?></strong>
			<ul>
				<li><?php _e( 'Any site member can join this event.', 'jet-event-system' ) ?></li>
				<li><?php _e( 'This event will be listed in the events directory and in search results.', 'jet-event-system' ) ?></li>
				<li><?php _e( 'Event content and activity will be visible to any site member.', 'jet-event-system' ) ?></li>
			</ul>
		</label>

		<label>
			<input type="radio" name="event-status" value="private"<?php jet_bp_event_show_status_setting('private') ?> />
			<strong><?php _e( 'This is a private event', 'jet-event-system' ) ?></strong>
			<ul>
				<li><?php _e( 'Only users who request membership and are accepted can join the event.', 'jet-event-system' ) ?></li>
				<li><?php _e( 'This event will be listed in the events directory and in search results.', 'jet-event-system' ) ?></li>
				<li><?php _e( 'Event content and activity will only be visible to members of the event.', 'jet-event-system' ) ?></li>
			</ul>
		</label>

		<label>
			<input type="radio" name="event-status" value="hidden"<?php jet_bp_event_show_status_setting('hidden') ?> />
			<strong><?php _e( 'This is a hidden event', 'jet-event-system' ) ?></strong>
			<ul>
				<li><?php _e( 'Only users who are invited can join the event.', 'jet-event-system' ) ?></li>
				<li><?php _e( 'This event will not be listed in the events directory or search results.', 'jet-event-system' ) ?></li>
				<li><?php _e( 'Event content and activity will only be visible to members of the event.', 'jet-event-system' ) ?></li>
			</ul>
		</label>
	</div>

	<?php do_action( 'bp_after_event_settings_admin' ); ?>

	<p><input type="submit" value="<?php _e( 'Save Changes', 'jet-event-system' ) ?> &rarr;" id="save" name="save" /></p>
	<?php wp_nonce_field( 'events_edit_event_settings' ) ?>

<?php endif; ?>

<?php /* Event Avatar Settings */ ?>
<?php if ( bp_is_event_admin_screen( 'event-avatar' ) ) : ?>

	<?php if ( 'upload-image' == bp_get_avatar_admin_step() ) : ?>

			<p><?php _e("Upload an image to use as an avatar for this event. The image will be shown on the main event page, and in search results.", 'jet-event-system') ?></p>

			<p>
				<input type="file" name="file" id="file" />
				<input type="submit" name="upload" id="upload" value="<?php _e( 'Upload Image', 'jet-event-system' ) ?>" />
				<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
			</p>

			<?php if ( bp_get_event_has_avatar() ) : ?>
				<p><?php _e( "If you'd like to remove the existing avatar but not upload a new one, please use the delete avatar button.", 'jet-event-system' ) ?></p>

				<div class="generic-button" id="delete-event-avatar-button">
					<a class="edit" href="<?php jes_bp_event_avatar_delete_link() ?>" title="<?php _e( 'Delete Avatar', 'jet-event-system' ) ?>"><?php _e( 'Delete Avatar', 'jet-event-system' ) ?></a>
				</div>
			<?php endif; ?>

			<?php wp_nonce_field( 'bp_avatar_upload' ) ?>

	<?php endif; ?>

	<?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

		<h3><?php _e( 'Crop Avatar', 'jet-event-system' ) ?></h3>

		<img src="<?php bp_avatar_to_crop() ?>" id="avatar-to-crop" class="avatar" alt="<?php _e( 'Avatar to crop', 'jet-event-system' ) ?>" />

		<div id="avatar-crop-pane">
			<img src="<?php bp_avatar_to_crop() ?>" id="avatar-crop-preview" class="avatar" alt="<?php _e( 'Avatar preview', 'jet-event-system' ) ?>" />
		</div>

		<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php _e( 'Crop Image', 'jet-event-system' ) ?>" />

		<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src() ?>" />
		<input type="hidden" id="x" name="x" />
		<input type="hidden" id="y" name="y" />
		<input type="hidden" id="w" name="w" />
		<input type="hidden" id="h" name="h" />

		<?php wp_nonce_field( 'bp_avatar_cropstore' ) ?>

	<?php endif; ?>

<?php endif; ?>

<?php /* Manage Event Members */ ?>
<?php if ( bp_is_event_admin_screen( 'manage-members' ) ) : ?>

	<?php do_action( 'bp_before_event_manage_members_admin' ); ?>

	<div class="bp-widget">
		<h4><?php _e( 'Administrators', 'jet-event-system' ); ?></h4>
		<?php jes_bp_event_admin_memberlist( true ) ?>
	</div>

	<?php if ( jes_bp_event_has_moderators() ) : ?>

		<div class="bp-widget">
			<h4><?php _e( 'Moderators', 'jet-event-system' ) ?></h4>
			<?php jes_bp_event_mod_memberlist( true ) ?>
		</div>

	<?php endif; ?>

	<div class="bp-widget">
		<h4><?php _e("Members", "jet-event-system"); ?></h4>

		<?php if ( bp_event_jes_has_members( 'per_page=15&exclude_banned=false' ) ) : ?>

			<?php if ( bp_event_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_event_member_pagination_count() ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_event_member_admin_pagination() ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="members-list" class="item-list single-line">
				<?php while ( bp_event_members() ) : bp_event_the_member(); ?>

					<?php if ( bp_get_event_member_is_banned() ) : ?>

						<li class="banned-user">
							<?php bp_event_member_avatar_mini() ?>

							<h5><?php bp_event_member_link() ?> <?php _e( '(banned)', 'jet-event-system') ?> <span class="small"> - <a href="<?php bp_event_member_unban_link() ?>" class="confirm" title="<?php _e( 'Kick and ban this member', 'jet-event-system' ) ?>"><?php _e( 'Remove Ban', 'jet-event-system' ); ?></a> </h5>

					<?php else : ?>

						<li>
							<?php bp_event_member_avatar_mini() ?>
							<h5><?php bp_event_member_link() ?>  <span class="small"> - <a href="<?php bp_event_member_ban_link() ?>" class="confirm" title="<?php _e( 'Kick and ban this member', 'jet-event-system' ); ?>"><?php _e( 'Kick &amp; Ban', 'jet-event-system' ); ?></a> | <a href="<?php bp_event_member_promote_mod_link() ?>" class="confirm" title="<?php _e( 'Promote to Mod', 'jet-event-system' ); ?>"><?php _e( 'Promote to Mod', 'jet-event-system' ); ?></a> | <a href="<?php bp_event_member_promote_admin_link() ?>" class="confirm" title="<?php _e( 'Promote to Admin', 'jet-event-system' ); ?>"><?php _e( 'Promote to Admin', 'jet-event-system' ); ?></a></span></h5>

					<?php endif; ?>

							<?php do_action( 'bp_event_manage_members_admin_item' ); ?>
						</li>

				<?php endwhile; ?>
			</ul>

		<?php else: ?>

			<div id="message" class="info">
				<p><?php _e( 'This event has no members.', 'jet-event-system' ); ?></p>
			</div>

		<?php endif; ?>

	</div>

	<?php do_action( 'bp_after_event_manage_members_admin' ); ?>

<?php endif; ?>

<?php /* Manage Membership Requests */ ?>
<?php if ( bp_is_event_admin_screen( 'membership-requests' ) ) : ?>

	<?php do_action( 'bp_before_event_membership_requests_admin' ); ?>

	<?php if ( bp_event_jes_has_membership_requests() ) : ?>

		<ul id="request-list" class="item-list">
			<?php while ( bp_event_membership_requests() ) : bp_event_the_membership_request(); ?>

				<li>
					<?php bp_event_request_user_avatar_thumb() ?>
					<h4><?php bp_event_request_user_link() ?> <span class="comments"><?php bp_event_request_comment() ?></span></h4>
					<span class="activity"><?php bp_event_request_time_since_requested() ?></span>

					<?php do_action( 'bp_event_membership_requests_admin_item' ); ?>

					<div class="action">

						<div class="generic-button accept">
							<a href="<?php bp_event_request_accept_link() ?>"><?php _e( 'Accept', 'jet-event-system' ); ?></a>
						</div>

					 &nbsp;

						<div class="generic-button reject">
							<a href="<?php bp_event_request_reject_link() ?>"><?php _e( 'Reject', 'jet-event-system' ); ?></a>
						</div>

						<?php do_action( 'bp_event_membership_requests_admin_item_action' ); ?>

					</div>
				</li>

			<?php endwhile; ?>
		</ul>

	<?php else: ?>

		<div id="message" class="info">
			<p><?php _e( 'There are no pending membership requests.', 'jet-event-system' ); ?></p>
		</div>

	<?php endif; ?>

	<?php do_action( 'bp_after_event_membership_requests_admin' ); ?>

<?php endif; ?>

<?php do_action( 'events_custom_edit_steps' ) // Allow plugins to add custom event edit screens ?>

<?php /* Delete Event Option */ ?>
<?php if ( bp_is_event_admin_screen( 'delete-event' ) ) : ?>

	<?php do_action( 'bp_before_event_delete_admin' ); ?>

	<div id="message" class="info">
		<p><?php _e( 'WARNING: Deleting this event will completely remove ALL content associated with it. There is no way back, please be careful with this option.', 'jet-event-system' ); ?></p>
	</div>

	<input type="checkbox" name="delete-event-understand" id="delete-event-understand" value="1" onclick="if(this.checked) { document.getElementById('delete-event-button').disabled = ''; } else { document.getElementById('delete-event-button').disabled = 'disabled'; }" /> <?php _e( 'I understand the consequences of deleting this event.', 'jet-event-system' ); ?>

	<?php do_action( 'bp_after_event_delete_admin' ); ?>

	<div class="submit">
		<input type="submit" disabled="disabled" value="<?php _e( 'Delete Event', 'jet-event-system' ) ?> &rarr;" id="delete-event-button" name="delete-event-button" />
	</div>

	<input type="hidden" name="event-id" id="event-id" value="<?php jes_bp_event_id() ?>" />

	<?php wp_nonce_field( 'events_delete_event' ) ?>

<?php endif; ?>

<?php /* This is important, don't forget it */ ?>
	<input type="hidden" name="event-id" id="event-id" value="<?php jes_bp_event_id() ?>" />

<?php do_action( 'bp_after_event_admin_content' ) ?>

</form><!-- #event-settings-form -->

