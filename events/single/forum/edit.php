<?php do_action( 'bp_before_event_forum_edit_form' ) ?>

<?php if ( bp_has_forum_topic_posts() ) : ?>

	<form action="<?php bp_forum_topic_action() ?>" method="post" id="forum-topic-form" class="standard-form">

		<div id="topic-meta">
			<h3><?php bp_the_topic_title() ?> (<?php bp_the_topic_total_post_count() ?>)</h3>
			<a class="button" href="<?php bp_forum_permalink() ?>/">&larr; <?php _e( 'Event Forum', 'jet-event-system' ) ?></a> &nbsp; <a class="button" href="<?php bp_forum_directory_permalink() ?>/"><?php _e( 'Event Forum Directory', 'jet-event-system') ?></a>

			<?php if ( bp_event_is_admin() || bp_event_is_mod() || bp_get_the_topic_is_mine() ) : ?>
				<div class="admin-links"><?php bp_the_topic_admin_links() ?></div>
			<?php endif; ?>
		</div>

		<?php if ( bp_event_is_member() ) : ?>

			<?php if ( bp_is_edit_topic() ) : ?>

				<div id="edit-topic">

					<?php do_action( 'bp_event_before_edit_forum_topic' ) ?>

					<p><strong><?php _e( 'Edit Topic:', 'jet-event-system' ) ?></strong></p>

					<label for="topic_title"><?php _e( 'Title:', 'jet-event-system' ) ?></label>
					<input type="text" name="topic_title" id="topic_title" value="<?php bp_the_topic_title() ?>" />

					<label for="topic_text"><?php _e( 'Content:', 'jet-event-system' ) ?></label>
					<textarea name="topic_text" id="topic_text"><?php bp_the_topic_text() ?></textarea>

					<?php do_action( 'bp_event_after_edit_forum_topic' ) ?>

					<p class="submit"><input type="submit" name="save_changes" id="save_changes" value="<?php _e( 'Save Changes', 'jet-event-system' ) ?>" /></p>

					<?php wp_nonce_field( 'bp_forums_edit_topic' ) ?>

				</div>

			<?php else : ?>

				<div id="edit-post">

					<?php do_action( 'bp_event_before_edit_forum_post' ) ?>

					<p><strong><?php _e( 'Edit Post:', 'jet-event-system' ) ?></strong></p>

					<textarea name="post_text" id="post_text"><?php bp_the_topic_post_edit_text() ?></textarea>

					<?php do_action( 'bp_event_after_edit_forum_post' ) ?>

					<p class="submit"><input type="submit" name="save_changes" id="save_changes" value="<?php _e( 'Save Changes', 'jet-event-system' ) ?>" /></p>

					<?php wp_nonce_field( 'bp_forums_edit_post' ) ?>

				</div>

			<?php endif; ?>

		<?php endif; ?>

	</form><!-- #forum-topic-form -->

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'This topic does not exist.', 'jet-event-system' ) ?></p>
	</div>

<?php endif;?>

<?php do_action( 'bp_after_event_forum_edit_form' ) ?>
