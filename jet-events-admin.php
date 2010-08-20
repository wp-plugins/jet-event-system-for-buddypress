<?php

function move_template($fpatch, $fname)
{
	$stringtoreturn = '> Copy: '.$fname.' on '.$fpatch.'<BR />';
	$filename1 = WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/templates/'.$fpatch.'/'.$fname;
	$filename2 = TEMPLATEPATH . '/'.$fpatch.'/'.$fname;
	if ( file_exists($filename1) )
	    {
		$stringtoreturn = $stringtoreturn.'files theme plugin found, ';
	    }
		else
	    {
		$stringtoreturn = $stringtoreturn.'files theme plugin not found!, ';
	    }

	if ( !rename ($filename1,$filename2) )
	    {
		$stringtoreturn = $stringtoreturn.'opps.. error when copy templates files.. please check permission!';
	    }
		else
	    {
		$stringtoreturn = $stringtoreturn.'ok, templates file copied!';
	    }
	$stringtoreturn = $stringtoreturn.'<br />';
	$fresult = $stringtoreturn;
return $fresult;
}


function update_template()
{
// Create Dir
	if ( !mkdir( TEMPLATEPATH . '/events', 0777, 1 ) ) { echo 'error when create dir /events<br />'; } else { echo 'ok, created dir /events<br />'; }
	if ( !mkdir( TEMPLATEPATH . '/events/single', 0777, 1 ) ) { echo 'error when create dir /events/single<br />'; } else { echo 'ok, create dir /events/single<br />'; }
	if ( !mkdir( TEMPLATEPATH . '/events/js', 0777, 1 ) ) { echo 'error when create dir /events/js<br />'; } else { echo 'ok, create dir /events/js<br />'; }
	if ( !mkdir( TEMPLATEPATH . '/members', 0777, 1 ) ) { echo 'error when create dir /members<br />'; } else { echo 'ok, create dir /members<br />'; }
	if ( !mkdir( TEMPLATEPATH . '/members/single', 0777, 1 ) ) { echo 'error when create dir /members/single<br />'; } else { echo 'ok, create dir /members/single<br />'; }

// Copy files
	echo move_template( 'events','create.php');
	echo move_template( 'events','events-loop.php');
	echo move_template( 'events','index.php');
	echo move_template( 'events/single','activity.php');
	echo move_template( 'events/single','admin.php');
	echo move_template( 'events/single','details.php');
	echo move_template( 'events/single','event-header.php');
	echo move_template( 'events/single','forum.php');
	echo move_template( 'events/single','home.php');
	echo move_template( 'events/single','members.php');
	echo move_template( 'events/single','plugins.php');
	echo move_template( 'events/single','request-join-to-event.php');
	echo move_template( 'events/single','send-invites.php');
	echo move_template( 'events/js','datepacker.js');
	echo move_template( 'members/single','events.php');
return true;
}

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

		if ( $_POST[ 'jes_events_countryopt_enable' ] == 1 ) 
			$jes_events[ 'jes_events_countryopt_enable' ] = 1;			
			
		if ( $_POST[ 'jes_events_stateopt_enable' ] == 1 ) 
			$jes_events[ 'jes_events_stateopt_enable' ] = 1;			
		
		if ( $_POST[ 'jes_events_costumslug' ] != null ) {
			$jes_events[ 'jes_events_costumslug' ] = stripslashes($_POST[ 'jes_events_costumslug' ]);
		}else{
			$jes_events[ 'jes_events_costumslug' ] = 'events';
		}

		if ( $_POST[ 'jes_events_style' ] != null ) {
			$jes_events[ 'jes_events_style' ] = stripslashes($_POST[ 'jes_events_style' ]);
		}else{
			$jes_events[ 'jes_events_style' ] = __('Standart','jet-event-system');
		}
		
		if ( $_POST[ 'jes_events_text_one' ] != null ) {
			$jes_events[ 'jes_events_text_one' ] = stripslashes($_POST[ 'jes_events_text_one' ]);
		}else{
			$jes_events[ 'jes_events_text_one' ] = __('Public','jet-event-system');
		}
		if ( $_POST[ 'jes_events_text_two' ] != null ) {
			$jes_events[ 'jes_events_text_two' ] = stripslashes($_POST[ 'jes_events_text_two' ]);
		}else{
			$jes_events[ 'jes_events_text_two' ] = __('Private','jet-event-system');
		}		
		if ( $_POST[ 'jes_events_text_three' ] != null ) {
			$jes_events[ 'jes_events_text_three' ] = stripslashes($_POST[ 'jes_events_text_three' ]);
		}else{
			$jes_events[ 'jes_events_text_three' ] = __('Home','jet-event-system');
		}

		if ( $_POST[ 'jes_events_sort_by' ] != null ) {
			$jes_events[ 'jes_events_sort_by' ] = stripslashes($_POST[ 'jes_events_sort_by' ]);
		}else{
			$jes_events[ 'jes_events_sort_by' ] = 'soon';		
		}
		if ( $_POST[ 'jes_events_sort_by_ad' ] != null ) {
			$jes_events[ 'jes_events_sort_by_ad' ] = stripslashes($_POST[ 'jes_events_sort_by_ad' ]);
		}else{
			$jes_events[ 'jes_events_sort_by' ] = 'ASC';			
		}

		if ( $_POST[ 'jes_events_countryopt_def' ] != null ) {
			$jes_events[ 'jes_events_countryopt_def' ] = stripslashes($_POST[ 'jes_events_countryopt_def' ]);
		}else{
			$jes_events[ 'jes_events_countryopt_def' ] = __('Russia','jet-event-system');
		}	
		
		if ( $_POST[ 'jes_events_stateopt_def' ] != null ) {
			$jes_events[ 'jes_events_stateopt_def' ] = stripslashes($_POST[ 'jes_events_stateopt_def' ]);
		}else{
			$jes_events[ 'jes_events_stateopt_def' ] = __('State','jet-event-system');
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
	<h4><?php _e('version','jet-event-system'); ?> 1.1 <?php _e('build','jet-event-system'); ?> 9 - <?php _e('Template version:','jet-event-system');?> <?php echo get_site_option( 'jes-template-version' ); ?> - <?php _e('DB version:','jet-event-system'); ?> <?php echo get_site_option( 'jes-db-version' ); ?></h4>
	
<?php	if ( get_site_option( 'jes-template-version' ) < JES_EVENTS_TEMPLATE_VERSION )
			{
				_e('There were changes in the theme file!','jet-event-system');
				echo '<br />';
				if ( update_template() )
					{
					_e('Theme files successfully updated!','jet-event-system');
					echo '<br />';
					update_site_option( 'jes-template-version', JES_EVENTS_TEMPLATE_VERSION );
					} else {
					_e('An error occurred while updating the files! (check the folder themes)','jet-event-system');
					}
			}	
	?>
	
	<form action="<?php echo site_url() . '/wp-admin/admin.php?page=jes-event-admin' ?>" name="jes_events_form" id="jes_events_form" method="post">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y" />

		<h3><?php _e( "Let's make some changes:", 'jet-event-system' ) ?></h3>
		<p><a href="#base-options" class="button"><?php _e('Base Options','jet-event-system'); ?></a> <a href="#classification-options" class="button"><?php _e('Classification Options','jet-event-system'); ?></a> <a href="#country-state-options" class="button"><?php _e('Country/State Options','jet-event-system'); ?></a> <a href="#restrict-options" class="button"><?php _e('Restrict options','jet-event-system'); ?></a> <a href="#privacy-options" class="button"><?php _e('Privacy options','jet-event-system'); ?></a></p>
		<p><a href="#support" class="button"><?php _e('Support','jet-event-system'); ?></a> <a href="#translate" class="button"><?php _e('Translate','jet-event-system'); ?></a> <a href="#future" class="button"><?php _e('Future','jet-event-system'); ?></a> <a href="#donations" class="button"><?php _e('Donations','jet-event-system'); ?></a></p>
<table width="100%">
<tr valign="top">
<td width="60%">
		<table class="form-table">
		<tr valign="top"><td><a name="base-options"><h4><?php _e('Base options','jet-event-system'); ?></h4></a></td></tr>

			<tr valign="top">
				<th scope="row"><label for="jes_events_costumslug_enable"><?php _e( 'Allow costum slug', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_costumslug_enable" type="checkbox" id="jes_events_costumslug_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_costumslug_enable' ] ? ' checked="checked"' : '' ); ?> />
				<label for="jes_events_costumslug"><?php _e( 'Slug:', 'jet-event-system' ) ?></label>
					<input name="jes_events_costumslug" type="text" id="jes_events_costumslug" value="<?php echo $jes_events[ 'jes_events_costumslug' ]; ?>" />
					
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><label for="jes_events_sort_by"><?php _e( 'Sort of events in the directory (by default)', 'jet-event-system' ) ?></label></th>
				<td>
					<select name="jes_events_sort_by" id="jes_events_sort_by" size = "1">
						<option <?php if ($jes_events[ 'jes_events_sort_by' ] == 'soon') { ?>selected<?php } ?> value="soon"><?php _e('Soon','jet-event-system'); ?></option> 
						<option <?php if ($jes_events[ 'jes_events_sort_by' ] == 'last-active') { ?>selected<?php } ?> value="last-active"><?php _e('Last Active','jet-event-system'); ?></option> 
						<option <?php if ($jes_events[ 'jes_events_sort_by' ] == 'popular') { ?>selected<?php } ?> value="popular"><?php _e('Most Members','jet-event-system'); ?></option> 
						<option <?php if ($jes_events[ 'jes_events_sort_by' ] == 'newest') { ?>selected<?php } ?> value="newest"><?php _e('Newly Created','jet-event-system'); ?></option>  
						<option <?php if ($jes_events[ 'jes_events_sort_by' ] == 'alphabetical') { ?>selected<?php } ?> value="alphabetical"><?php _e('Alphabetical','jet-event-system'); ?></option>
					</select>
				<label for="jes_events_sort_by_ad"><?php _e( 'By:', 'jet-event-system' ) ?></label>
					<select name="jes_events_sort_by_ad" id="jes_events_sort_by_ad" size = "1">
						<option <?php if ($jes_events[ 'jes_events_sort_by_ad' ] == 'ASC') { ?>selected<?php } ?> value="ASC"><?php _e('Ascending','jet-event-system'); ?></option> 
						<option <?php if ($jes_events[ 'jes_events_sort_by_ad' ] == 'DESC') { ?>selected<?php } ?> value="DESC"><?php _e('Descending','jet-event-system'); ?></option> 
					</select>	
				</td>
			</tr>				

			<tr valign="top">
				<th scope="row"><label for="jes_events_style"><?php _e( 'Style for Event Catalog:', 'jet-event-system' ) ?></label></th>
				<td>
					<select name="jes_events_style" id="jes_events_style" size = "1">
						<option <?php if ($jes_events[ 'jes_events_style' ] == 'Standart') { ?>selected <?php } ?>value="Standart "><?php _e('Standart Style','jet-event-system'); ?></option>
						<option <?php if ($jes_events[ 'jes_events_style' ] == 'Twitter') { ?>selected <?php } ?>value="Twitter"><?php _e('Twitter Style','jet-event-system'); ?></option>
					</select>
				</td>
			</tr>
			
		<tr valign="top"><td><a name="classification-options"><h4><?php _e('Classification options','jet-event-system'); ?></h4></a></td></tr>			

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

<?php
// Country/State
?>
		<tr valign="top"><td><a name="country-state-options"><h4><?php _e('Country/State Options','jet-event-system'); ?></h4></a></td></tr>
			<tr valign="top">
				<th scope="row"><label for="jes_events_countryopt_enable"><?php _e( 'Allow Country', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_countryopt_enable" type="checkbox" id="jes_events_countryopt_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_countryopt_enable' ] ? ' checked="checked"' : '' ); ?> />
				<label for="jes_events_countryopt_def"><?php _e( 'Name of the country by default:', 'jet-event-system' ) ?></label>
					<input name="jes_events_countryopt_def" type="text" id="jes_events_countryopt_def" value="<?php echo $jes_events[ 'jes_events_countryopt_def' ]; ?>" />	
				</td>
			</tr>			
			
			<tr valign="top">
				<th scope="row"><label for="jes_events_stateopt_enable"><?php _e( 'Allow State', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_stateopt_enable" type="checkbox" id="jes_events_stateopt_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_stateopt_enable' ] ? ' checked="checked"' : '' ); ?> />
				<label for="jes_events_stateopt_def"><?php _e( 'Name of the state by default:', 'jet-event-system' ) ?></label>
					<input name="jes_events_stateopt_def" type="text" id="jes_events_stateopt_def" value="<?php echo $jes_events[ 'jes_events_stateopt_def' ]; ?>" />	
				</td>
			</tr>

		<tr valign="top"><td><a name="restrict-options"><h4><?php _e('Restrict options','jet-event-system'); ?></h4></a></td></tr>
		
			<tr valign="top">
				<th scope="row"><label for="jes_events_createnonadmin_disable"><?php _e( 'Prohibit non-administrators to create events', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_createnonadmin_disable" type="checkbox" id="jes_events_createnonadmin_disable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_createnonadmin_disable' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>

			<tr valign="top">
				<th scope="row"><label for="jes_events_adminapprove_enable"><?php _e( 'Allow verification of events by the administrator', 'jet-event-system' ) ?></label></th>
				<td>
					<input name="jes_events_adminapprove_enable" type="checkbox" id="jes_events_adminapprove_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_adminapprove_enable' ] ? ' checked="checked"' : '' ); ?> />
				</td>
			</tr>
			
		<tr valign="top"><td><a name="privacy-options"><h4><?php _e('Privacy options','jet-event-system'); ?></h4></a></td></tr>

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
<a name="support"><h4><?php _e('Support','jet-event-system'); ?></h4></a>
<p><a href="http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html">About</a><br />
<a href="http://jes.milordk.ru">Website Developer</a><br />
<a name="donations"><h4><?php _e('Donations','jet-event-system'); ?>:</h4></a>
<em>WMZ</em>: <strong>Z113010060388</strong> / <em>WMR</em>: <strong>R144831580346</strong><br />

<SCRIPT LANGUAGE="JavaScript">
function chcount(form){
    document.sf.amount.value = document.sf.UCount.value;    
    return true;
}
</SCRIPT>
<form name="sf" method="post" action= "https://www.paypal.com/cgi-bin/webscr">
<input type="text" name="UCount" value="20" MAXLENGTH="3" SIZE="3" onChange="return chcount(this.form)">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="milordk@rambler.ru">
<input type="hidden" name="item_name" value="Project Support JES">
<input type="hidden" name="item_number" value="1">
<input type="hidden" name="amount" value="20">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="<?php echo site_url() . '/wp-admin/admin.php?page=jes-event-admin' ?>">
<input type="submit" value="Donations with PayPal (USD)">
</form>

<br />(<?php _e('please specify in the designation of the site and name:) All who have made a contribution to the development of plug-in will be included in honor roll, as well as gain access to additional modules!','jet-event-system'); ?>)<br /><br /></p>
<a name="future"><h4><?php _e('Future','jet-event-system'); ?></h4></a>
<ul>
<li>* In version 1.2 will ensure compatibility of the system with the new version of BP</li>
<li>* In version 1.3 will be added to the possibility of tying the event to a group</li>
<li>* In version 1.4 will be added to the possibility of tying the event to your blog (s) </li>
</ul>

<a name="translate"><h4><?php _e('Translate','jet-event-system'); ?></h4></a>
<ul>
<li><strong>ru_RU</strong> - <em>Jettochkin</em>, <a href="http://milordk.ru" target="_blank">http://milordk.ru</a></li>
<li><strong>fr_FR</strong> - <em>Laurent Hermann</em>, <a href="http://www.paysterresdelorraine.com/" target="_blank">http://www.paysterresdelorraine.com/</a></li>
<li><strong>de_DE</strong> - <em>Manuel MЭller</em>, <a href="www.pixelartist.de" target="_blank">www.pixelartist.de</a></li>
<li><strong>es_ES</strong> - <em>Alex_Mx</em></li>
</ul>
<p><br />To translate use <a href="http://www.poedit.net/">POEdit</a>, also present in the folder plugin POT-file</p>
<p><em><?php _e('Please send your translations to milord_k @ mail.ru','jet-event-system'); ?></em></p>
<p>Do not forget to include links to your sites (for accommodation options in the list of translators)</p>
<p><?php _e('Translates can be discussed at the forum on the official website of the plugin:','jet-event-system'); ?> <a href="http://jes.milordk.ru/groups/translates/">Group</a></p>
</td>
</tr>
</table>
</div>
<?php
}
?>
