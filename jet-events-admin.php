<?php
function jes_event_admin() {
	global $bp, $wpdb;
	$jet_event = get_option( 'jet_event' );

	if ( isset($_POST['saveData']) ) {
		$jet_event = $_POST['jet_event_display'];
		$jet_event[ 'classifier' ] = $_POST[ 'jet_event_messages' ];
		update_option( 'jet_event', $jet_event );
		
		echo "<div id='message' class='updated fade'><p>" . __( 'All changes were saved. Go and check results!', 'jet-event-system' ) . "</p></div>";
	}
	
	?>
	<div class="wrap">
		<h2><?php _e( 'Jet Event System','jet-event-system') ?></h2>
		<form action="<?php echo site_url() . '/wp-admin/admin.php?page=jet-event-admin' ?>" id="jet-event-admin" method="post">


			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e( 'Use classifier to events?', 'jet-event-system' ) ?></th>
					<td>
						<input name="jet_event_messages" type="radio" value="yes"<?php echo( ( 'yes' == $jet_event[ 'classifier' ] ) ? ' checked="checked"' : '' ); ?> /> <?php _e( 'Yes', 'jet-event-system' ); ?><br>
						<input name="jet_event_messages" type="radio" value="no"<?php echo( ( 'no' == $jet_event[ 'classifier' ] ) ? ' checked="checked"' : '' ); ?> /> <?php _e( 'No', 'jet-event-system' ); ?><br>
					</td>
				</tr>
			</table>
			
			<p>
				<input class="button" type="submit" name="saveData" value="<?php _e( 'Save Selected Fields', 'jet-event-system' ) ?>"/>
			</p>
		</form>
	</div>
	<?php
}

?>