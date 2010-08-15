<?php
function jes_event_admin() {
	$jes_events = get_option( 'jes_events' );
	$hidden_field_name = 'hidden_field_name';
	
	if ( $_POST[ $hidden_field_name ] == 'Y' ) {
		// save all inputed data
		$jes_events[ 'jes_events_class_enable' ] = 0;
		$jes_events[ 'jes_events_code_index' ] = 0;
		$jes_events[ 'jes_events_costumslug_enable' ] = 0;
		$jes_events[ 'jes_events_addnavi_disable' ] = 0;
		$jes_events[ 'jes_events_addnavicatalog_disable' ] = 0;
		$jes_events[ 'jes_events_createnonadmin_disable' ] = 0;
		$jes_events[ 'jes_events_adminapprove_enable' ] = 0;

		if ( $_POST[ 'jes_events_class_enable' ] == 1 ) 
			$jes_events[ 'jes_events_class_enable' ] = 1;
			
		if ( $_POST[ 'jes_events_code_index' ] == 1 ) 
			$jes_events[ 'jes_events_code_index' ] = 1;		

		if ( $_POST[ 'jes_events_costumslug_enable' ] == 1 ) 
			$jes_events[ 'jes_events_costumslug_enable' ] = 1;	

		if ( $_POST[ 'jes_events_addnavi_disable' ] == 1 ) 
			$jes_events[ 'jes_events_addnavi_disable' ] = 1;	

		if ( $_POST[ 'jes_events_addnavicatalog_disable' ] == 1 ) 
			$jes_events[ 'jes_events_addnavicatalog_disable' ] = 1;
			
		if ( $_POST[ 'jes_events_createnonadmin_disable' ] == 1 ) 
			$jes_events[ 'jes_events_createnonadmin_disable' ] = 1;

		if ( $_POST[ 'jes_events_createnonadmin_disable' ] == 1 ) 
			$jes_events[ 'jes_events_createnonadmin_disable' ] = 1;

		if ( $_POST[ 'jes_events_adminapprove_enable' ] == 1 ) 
			$jes_events[ 'jes_events_adminapprove_enable' ] = 1;			
			
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
		if ( $_POST[ 'jes_events_text_five' ] != null ) {
			$jes_events[ 'jes_events_text_five' ] = stripslashes($_POST[ 'jes_events_text_five' ]);
		}else{
			$jes_events[ 'jes_events_text_five' ] = _('Club','jet-event-system');
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
	<h4>version 1.1 build 8</h4>
	<form action="<?php echo site_url() . '/wp-admin/admin.php?page=jes-event-admin' ?>" name="jes_events_form" id="jes_events_form" method="post">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y" />

		<h3><?php _e( "Let's make some changes:", 'jet-event-system' ) ?></h3>
		<p><a href="#base-options" class="button">Base Options</a> <a href="#restrict-options" class="button">Restrict options</a> <a href="#privacy-options" class="button">Privacy options</a> <a href="#support" class="button">Support</a> <a href="#translate" class="button">Translate</a> <a href="#future" class="button">Future</a> <a href="#donations" class="button">Donations</a></p>
<table>
<tr valign="top">
<td width="70%">
		<table class="form-table">
		<tr valign="top"><td><a name="base-options"><h4>Base options</h4></a></td></tr>

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
				<th scope="row"><label for="jes_events_class_enable"><?php _e( 'Allow the use of classifiers through an administrative panel (unless you want to use some or classifier - leave his field blank)', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_class_enable" type="checkbox" id="jes_events_class_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_class_enable' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>	
			
			<tr valign="top">
				<th scope="row"><label for="jes_events_text_one"><?php _e( 'Classification - 1', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_text_one" type="text" size="40"id="jes_events_text_one" value="<?php echo $jes_events[ 'jes_events_text_one' ]; ?>" />
				</td>
			</tr>					
			<tr valign="top">
				<th scope="row"><label for="jes_events_text_two"><?php _e( 'Classification - 2', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_text_two" type="text" size="40" id="jes_events_text_two" value="<?php echo $jes_events[ 'jes_events_text_two' ]; ?>" />
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row"><label for="jes_events_text_three"><?php _e( 'Classification - 3', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_text_three" type="text"size="40" id="jes_events_text_three" value="<?php echo $jes_events[ 'jes_events_text_three' ]; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="jes_events_text_four"><?php _e( 'Classification - 4', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_text_four" type="text"size="40" id="jes_events_text_four" value="<?php echo $jes_events[ 'jes_events_text_four' ]; ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="jes_events_text_five"><?php _e( 'Classification - 5', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_text_five" type="text"size="40" id="jes_events_text_five" value="<?php echo $jes_events[ 'jes_events_text_five' ]; ?>" />
				</td>
			</tr>	

		<tr valign="top"><td><a name="restrict-options"><h4>Restrict options</h4></a></td></tr>
		
			<tr valign="top">
				<th scope="row"><label for="jes_events_createnonadmin_disable"><?php _e( 'Prohibit non-administrators to create events (available since version 1.1.9)', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_createnonadmin_disable" type="checkbox" id="jes_events_createnonadmin_disable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_createnonadmin_disable' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><label for="jes_events_adminapprove_enable"><?php _e( 'Allow verification of events by the administrator (available since version 1.1.9)', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_adminapprove_enable" type="checkbox" id="jes_events_adminapprove_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_adminapprove_enable' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>
			
		<tr valign="top"><td><a name="privacy-options"><h4>Privacy options</h4></a></td></tr>

			<tr valign="top">
				<th scope="row"><label for="jes_events_code_index"><?php _e( 'Allow indexing of events search engines', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_code_index" type="checkbox" id="jes_events_code_index" value="1"<?php echo( '1' == $jes_events[ 'jes_events_code_index' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><label for="jes_events_addnavi_disable"><?php _e( 'Deny access to events for unregistered users', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_addnavi_disable" type="checkbox" id="jes_events_addnavi_disable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_addnavi_disable' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><label for="jes_events_addnavi_disable"><?php _e( 'Show private events in the catalog for unregistered users (in the cases allow access to events)', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_addnavicatalog_disable" type="checkbox" id="jes_events_addnavicatalog_disable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_addnavicatalog_disable' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>
			
</table>
	<p align="center" class="submit"><input type="submit" name="submit" value="<?php _e( 'Save Settings', 'jes-event-system' ) ?>"/></p>
	</form>
</td>
<td>
<a name="support"><h4>Support</h4></a>
<p><a href="http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html">About</a><br />
<a href="http://jes.milordk.ru">Website Developer</a><br />
<a name="donations"><h4>Donations:</h4></a>
<em>WMZ</em>: <strong>Z113010060388</strong> / <em>WMR</em>: <strong>R144831580346</strong><br />(please specify in the designation of the site and name:) All who have made a contribution to the development of plug-in will be included in honor roll, as well as gain access to additional modules!)<br /><br /></p>
<a name="future"><h4>Future</h4></a>
<p>* In version 1.2 will be added ability to display current events as a widget and the directory</p>
* In version 1.3 will be added to the possibility of tying the event to a group<br />
+ Ability to limit the list of participants are allowed to create events</p>
<p>* In version 1.5 will be added to the possibility of tying the event to your blog (s)</p> 

<a name="translate"><h4>Translate</h4></a>
<ol>
<li><strong>ru_RU</strong> - <em>Jettochkin</em>, <a href="http://milordk.ru" target="_blank">http://milordk.ru</a></li>
<li><strong>fr_FR</strong> - <em>Laurent Hermann</em>, <a href="http://www.paysterresdelorraine.com/" target="_blank">http://www.paysterresdelorraine.com/</a></li>
<li><strong>de_DE</strong> - <em>Manuel MЭller</em>, <a href="www.pixelartist.de" target="_blank">www.pixelartist.de</a></li>
<li><strong>es_ES</strong> - <em>Alex_Mx</em></li>
</ol>
<p><br />To translate use <a href="http://www.poedit.net/">POEdit</a>, also present in the folder plugin POT-file</p>
<p><em>Please send your translations to milord_k @ mail.ru ()</em></p>
<p>Do not forget to include links to your sites (for accommodation options in the list of translators)</p>
<p>Translates can be discussed at the forum on the official website of the plugin: <a href="http://jes.milordk.ru/groups/translates/">Group</a></p>
</td>
</tr>
</table>
</div>
<?php
}
?>
