<?php
function jes_event_admin() {
	$jes_events = get_option( 'jes_events' );
	$hidden_field_name = 'hidden_field_name';
	
	if ( $_POST[ $hidden_field_name ] == 'Y' ) {
		// save all inputed data
		$jes_events[ 'jes_events_class_enable' ] = 0;
		$jes_events[ 'jes_events_code_index' ] = 0;
		$jes_events[ 'jes_events_costumslug_enable' ] = 0;
		
		if ( $_POST[ 'jes_events_class_enable' ] == 1 ) 
			$jes_events[ 'jes_events_class_enable' ] = 1;
			
		if ( $_POST[ 'jes_events_code_index' ] == 1 ) 
			$jes_events[ 'jes_events_code_index' ] = 1;		

		if ( $_POST[ 'jes_events_costumslug_enable' ] == 1 ) 
			$jes_events[ 'jes_events_costumslug_enable' ] = 1;	

			
		if ( $_POST[ 'jes_events_costumslug' ] != null ) {
			$jes_events[ 'jes_events_costumslug' ] = stripslashes($_POST[ 'jes_events_costumslug' ]);
		}else{
			$jes_events[ 'jes_events_costumslug' ] = 'events';
		}
			
		if ( $_POST[ 'jes_events_text_one' ] != null ) {
			$jes_events[ 'jes_events_text_one' ] = stripslashes($_POST[ 'jes_events_text_one' ]);
		}else{
			$jes_events[ 'jes_events_text_one' ] = _('Public','jet-event-system');
		}
		if ( $_POST[ 'jes_events_text_two' ] != null ) {
			$jes_events[ 'jes_events_text_two' ] = stripslashes($_POST[ 'jes_events_text_two' ]);
		}else{
			$jes_events[ 'jes_events_text_two' ] = _('Private','jet-event-system');
		}		
		if ( $_POST[ 'jes_events_text_three' ] != null ) {
			$jes_events[ 'jes_events_text_three' ] = stripslashes($_POST[ 'jes_events_text_three' ]);
		}else{
			$jes_events[ 'jes_events_text_three' ] = _('Home','jet-event-system');
		}
		if ( $_POST[ 'jes_events_text_four' ] != null ) {
			$jes_events[ 'jes_events_text_four' ] = stripslashes($_POST[ 'jes_events_text_four' ]);
		}else{
			$jes_events[ 'jes_events_text_four' ] = _('Club','jet-event-system');
		}
		
if (stripos($blogversion, 'MU') > 0) {			
		$blogs_ids = get_blog_list( 0, 'all' );
		foreach ($blogs_ids as $blog) {
			update_blog_option( $blog['blog_id'], 'jes_events', $jes_events );
		}
	} else {
		update_option( 'jes_events', $jes_events );
	}
		echo "<div id='message' class='updated fade'><p>" . __( 'Options updated.', 'jet-event-system' ) . "</p></div>";
	}
?>
<div class="wrap">
	<h2><?php _e('JES. Jet Event System', 'jet-event-system' ) ?></h2>

	<form action="<?php echo site_url() . '/wp-admin/admin.php?page=jes-event-admin' ?>" name="jes_events_form" id="jes_events_form" method="post">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y" />

		<h3><?php _e( "Let's make some changes:", 'jet-event-system' ) ?></h3>
		<table class="form-table">

			<tr valign="top">
				<th scope="row"><label for="jes_events_code_index"><?php _e( 'Allow indexing of events search engines', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_code_index" type="checkbox" id="jes_events_code_index" value="1"<?php echo( '1' == $jes_events[ 'jes_events_code_index' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><label for="jes_events_costumslug_enable"><?php _e( 'Allow costum slug', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_costumslug_enable" type="checkbox" id="jes_events_costumslug_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_costumslug_enable' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><label for="jes_events_costumslug"><?php _e( 'Slug:', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_costumslug" type="text" id="jes_events_costumslug" value="<?php echo $jes_events[ 'jes_events_costumslug' ]; ?>" />
				</td>
			</tr>				

		
			<tr valign="top">
				<th scope="row"><label for="jes_events_class_enable"><?php _e( 'Allow the use of classifiers through an administrative panel', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_class_enable" type="checkbox" id="jes_events_class_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_class_enable' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>			
			
			<tr valign="top">
				<th scope="row"><label for="jes_events_text_one"><?php _e( 'Classification - 1', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_text_one" type="text" id="jes_events_text_one" value="<?php echo $jes_events[ 'jes_events_text_one' ]; ?>" />
				</td>
			</tr>					
			<tr valign="top">
				<th scope="row"><label for="jes_events_text_two"><?php _e( 'Classification - 2', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_text_two" type="text" id="jes_events_text_two" value="<?php echo $jes_events[ 'jes_events_text_two' ]; ?>" />
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row"><label for="jes_events_text_three"><?php _e( 'Classification - 3', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_text_three" type="text" id="jes_events_text_three" value="<?php echo $jes_events[ 'jes_events_text_three' ]; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="jes_events_text_four"><?php _e( 'Classification - 4', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_text_four" type="text" id="jes_events_text_four" value="<?php echo $jes_events[ 'jes_events_text_four' ]; ?>" />
				</td>
			</tr>
			
		</table>
	<p class="submit"><input type="submit" name="submit" value="<?php _e( 'Save Settings', 'jes-event-system' ) ?>"/></p>
	</form>
</div>
<?php
}

?>
