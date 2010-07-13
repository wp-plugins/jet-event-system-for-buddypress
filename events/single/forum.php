<?php do_action( 'bp_before_event_forum_content' ) ?>

<?php if ( jes_is_event_forum_topic_edit() ) : ?>
	<?php locate_template( array( 'events/single/forum/edit.php' ), true ) ?>

<?php elseif ( jes_is_event_forum_topic() ) : ?>
	<?php locate_template( array( 'events/single/forum/topic.php' ), true ) ?>

<?php else : ?>

	<div class="forums single-forum">
		<?php locate_template( array( 'forums/forums-loop.php' ), true ) ?>
	</div><!-- .forums.single-forum -->

<?php endif; ?>

<?php do_action( 'bp_after_event_forum_content' ) ?>

<?php if ( !jes_is_event_forum_topic_edit() && !jes_is_event_forum_topic() ) : ?>

	<?php if ( ( is_user_logged_in() && 'public' == bp_get_event_status() ) || bp_event_is_member() ) : ?>

		<form action="" method="post" id="forum-topic-form" class="standard-form">
			<div id="post-new-topic">

				<?php do_action( 'bp_before_event_forum_post_new' ) ?>

				<?php if ( !bp_event_is_member() ) : ?>
					<p><?php _e( 'You will auto join this event when you start a new topic.', 'jet-event-system' ) ?></p>
				<?php endif; ?>

				<p id="post-new"></p>
				<h4><?php _e( 'Post a New Topic:', 'jet-event-system' ) ?></h4>

				<label><?php _e( 'Title:', 'jet-event-system' ) ?></label>
				<input type="text" name="topic_title" id="topic_title" value="" />

				<label><?php _e( 'Content:', 'jet-event-system' ) ?></label>
				<textarea name="topic_text" id="topic_text"></textarea>

				<label><?php _e( 'Tags (comma separated):', 'jet-event-system' ) ?></label>
				<input type="text" name="topic_tags" id="topic_tags" value="" />

				<?php do_action( 'bp_after_event_forum_post_new' ) ?>

				<div class="submit">
					<input type="submit" name="submit_topic" id="submit" value="<?php _e( 'Post Topic', 'jet-event-system' ) ?>" />
				</div>

				<?php wp_nonce_field( 'bp_forums_new_topic' ) ?>
			</div><!-- #post-new-topic -->
		</form><!-- #forum-topic-form -->

	<?php endif; ?>

<?php endif; ?>

