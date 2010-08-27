<?php

function move_template($fpatch, $fname)
	{
		$stringtoreturn = '>> '.$fname.'('.$fpatch.')- ';
		$filename1 = WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/templates/'.$fpatch.'/'.$fname;
		$filename2 = TEMPLATEPATH . '/'.$fpatch.'/'.$fname;
		if ( file_exists($filename1) )
			{
				$stringtoreturn = $stringtoreturn.'ok=ft, ';
			}
			else
			{
				$stringtoreturn = $stringtoreturn.'err=ft!, ';
			}

		if ( !rename ($filename1,$filename2) )
			{
				$stringtoreturn = $stringtoreturn.'opps.. permission!';
			}
			else
			{
				$stringtoreturn = $stringtoreturn.'ok, copied!';
			}
		$stringtoreturn = $stringtoreturn.'=';
		$fresult = $stringtoreturn;
	return $fresult;
}


function update_template()
	{
// Create Dir
		if ( !mkdir( TEMPLATEPATH . '/events', 0777, 1 ) ) { echo 'dir (/events) exists?, '; } else { echo 'ok, created dir /events, '; }
		if ( !mkdir( TEMPLATEPATH . '/events/single', 0777, 1 ) ) { echo 'dir (/events/single) exists? , '; } else { echo 'ok, create dir /events/single, '; }
		if ( !mkdir( TEMPLATEPATH . '/events/js', 0777, 1 ) ) { echo 'dir (/events/js) exists? , '; } else { echo 'ok, create dir /events/js, '; }
		if ( !mkdir( TEMPLATEPATH . '/members', 0777, 1 ) ) { echo 'dir (/members) exists?, '; } else { echo 'ok, create dir /members, '; }
		if ( !mkdir( TEMPLATEPATH . '/members/single', 0777, 1 ) ) { echo 'dir (/members/single) exists?, '; } else { echo 'ok, create dir /members/single, '; }
		if ( !mkdir( TEMPLATEPATH . '/events/css', 0777, 1 ) ) { echo 'dir (/members/single) exists?, '; } else { echo 'ok, create dir /events/css, '; }
		if ( !mkdir( TEMPLATEPATH . '/events/css/images', 0777, 1 ) ) { echo 'dir (/members/single) exists?, '; } else { echo 'ok, create dir /events/css/images, '; }		
	echo '<br />';
// Copy templates files
		echo move_template( 'events','create.php');
		echo move_template( 'events','events-loop.php');
		echo move_template( 'events','index.php');
		echo move_template( 'events/single','activity.php');
		echo move_template( 'events/single','admin.php');
		echo move_template( 'events/single','details.php');
		echo move_template( 'events/single','event-header.php');
		echo move_template( 'events/single','home.php');
		echo move_template( 'events/single','members.php');
		echo move_template( 'events/single','plugins.php');
		echo move_template( 'events/single','request-join-to-event.php');
		echo move_template( 'events/single','send-invites.php');
		echo move_template( 'events/single','google-map.php');		
		echo move_template( 'events/css','datepacker.css');
		echo move_template( 'events/css/images','ui-bg_flat_0_aaaaaa_40x100.png');		
		echo move_template( 'events/css/images','ui-bg_flat_75_ffffff_40x100.png');
		echo move_template( 'events/css/images','ui-bg_glass_55_fbf9ee_1x400.png');		
		echo move_template( 'events/css/images','ui-bg_glass_65_ffffff_1x400.png');		
		echo move_template( 'events/css/images','ui-bg_glass_75_dadada_1x400.png');		
		echo move_template( 'events/css/images','ui-bg_glass_75_e6e6e6_1x400.png');		
		echo move_template( 'events/css/images','ui-bg_glass_95_fef1ec_1x400.png');
		echo move_template( 'events/css/images','ui-bg_highlight-soft_75_cccccc_1x100.png');
		echo move_template( 'events/css/images','ui-icons_2e83ff_256x240.png');		
		echo move_template( 'events/css/images','ui-icons_222222_256x240.png');
		echo move_template( 'events/css/images','ui-icons_454545_256x240.png');
		echo move_template( 'events/css/images','ui-icons_888888_256x240.png');
		echo move_template( 'events/css/images','ui-icons_cd0a0a_256x240.png');
		
		echo move_template( 'events/js','jquery-1.4.2.min.js');
		echo move_template( 'events/js','jquery-ui-1.8.4.custom.min.js');
		
		echo move_template( 'members/single','events.php');
		echo move_template( 'members/single/events','invites.php');	

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
		$jes_events[ 'jes_events_show_avatar_invite_enable' ] = 0;
		$jes_events[ 'jes_events_countryopt_enable' ] = 0;
		$jes_events[ 'jes_events_stateopt_enable' ] = 0;
		$jes_events[ 'jes_events_cityopt_enable' ] = 0;
		$jes_events[ 'jes_events_specialconditions_enable' ] = 0;
		$jes_events[ 'jes_events_publicnews_enable' ] = 0;
		$jes_events[ 'jes_events_privatenews_enable' ] = 0;
		$jes_events[ 'jes_events_show_avatar_invite_enable' ] = 0;
		
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

/* Access to Event Fields */
		if ( $_POST[ 'jes_events_specialconditions_enable' ] == 1 ) 
			$jes_events[ 'jes_events_specialconditions_enable' ] = 1;
			
		if ( $_POST[ 'jes_events_publicnews_enable' ] == 1 ) 
			$jes_events[ 'jes_events_publicnews_enable' ] = 1;

		if ( $_POST[ 'jes_events_privatenews_enable' ] == 1 ) 
			$jes_events[ 'jes_events_privatenews_enable' ] = 1;

/* Slug */
		if ( $_POST[ 'jes_events_costumslug' ] != null ) {
			$jes_events[ 'jes_events_costumslug' ] = stripslashes($_POST[ 'jes_events_costumslug' ]);
		}else{
			$jes_events[ 'jes_events_costumslug' ] = 'events';
		}

/* Date format */
		if ( $_POST[ 'jes_events_date_format' ] != null ) {
			$jes_events[ 'jes_events_date_format' ] = stripslashes($_POST[ 'jes_events_date_format' ]);
		}else{
			$jes_events[ 'jes_events_date_format' ] = 'dd mm yy';
		}		
		
		if ( $_POST[ 'jes_events_date_format_in' ] != null ) {
			$jes_events[ 'jes_events_date_format_in' ] = stripslashes($_POST[ 'jes_events_date_format_in' ]);
		}else{
			$jes_events[ 'jes_events_date_format_in' ] = 'd m Y';
		}		
		
/* Style */		
		if ( $_POST[ 'jes_events_style' ] != null ) {
			$jes_events[ 'jes_events_style' ] = stripslashes($_POST[ 'jes_events_style' ]);
		}else{
			$jes_events[ 'jes_events_style' ] = __('Standart','jet-event-system');
		}

		if ( $_POST[ 'jes_events_style_single' ] != null ) {
			$jes_events[ 'jes_events_style_single' ] = stripslashes($_POST[ 'jes_events_style_single' ]);
		}else{
			$jes_events[ 'jes_events_style_single' ] = __('Standart','jet-event-system');
		}

/* Avatars size */	
		if ( $_POST[ 'jes_events_show_avatar_invite_enable' ] == 1 )
			$jes_events[ 'jes_events_show_avatar_invite_enable' ] = 1;

		if ( $_POST[ 'jes_events_show_avatar_invite_size' ] != null ) {
			$jes_events[ 'jes_events_show_avatar_invite_size' ] = stripslashes($_POST[ 'jes_events_show_avatar_invite_size' ]);
		} else {
			$jes_events[ 'jes_events_show_avatar_invite_size' ] = 50;
		}

		if ( $_POST[ 'jes_events_show_avatar_main_size' ] != null ) {
			$jes_events[ 'jes_events_show_avatar_main_size' ] = stripslashes($_POST[ 'jes_events_show_avatar_main_size' ]);
		} else {
			$jes_events[ 'jes_events_show_avatar_main_size' ] = 150;
		}

		if ( $_POST[ 'jes_events_show_avatar_directory_size' ] != null ) {
			$jes_events[ 'jes_events_show_avatar_directory_size' ] = stripslashes($_POST[ 'jes_events_show_avatar_directory_size' ]);
		} else {
			$jes_events[ 'jes_events_show_avatar_directory_size' ] = 150;
		}

/* Classifications */		
		if ( $_POST[ 'jes_events_text_one' ] != null ) {
			$jes_events[ 'jes_events_text_one' ] = stripslashes($_POST[ 'jes_events_text_one' ]);
		}else{
			$jes_events[ 'jes_events_text_one' ] = __('Site','jet-event-system');
		}
		if ( $_POST[ 'jes_events_text_two' ] != null ) {
			$jes_events[ 'jes_events_text_two' ] = stripslashes($_POST[ 'jes_events_text_two' ]);
		}else{
			$jes_events[ 'jes_events_text_two' ] = __('Personal','jet-event-system');
		}		
		if ( $_POST[ 'jes_events_text_three' ] != null ) {
			$jes_events[ 'jes_events_text_three' ] = stripslashes($_POST[ 'jes_events_text_three' ]);
		}

		if ( $_POST[ 'jes_events_text_four' ] != null ) {
			$jes_events[ 'jes_events_text_four' ] = stripslashes($_POST[ 'jes_events_text_four' ]);
		}		

		if ( $_POST[ 'jes_events_text_five' ] != null ) {
			$jes_events[ 'jes_events_text_five' ] = stripslashes($_POST[ 'jes_events_text_five' ]);
		}

/* Sort */		
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

/* Country/Statr/City */
		if ( $_POST[ 'jes_events_countryopt_enable' ] == 1 ) 
			$jes_events[ 'jes_events_countryopt_enable' ] = 1;			
			
		if ( $_POST[ 'jes_events_stateopt_enable' ] == 1 ) 
			$jes_events[ 'jes_events_stateopt_enable' ] = 1;			

		if ( $_POST[ 'jes_events_cityopt_enable' ] == 1 ) 
			$jes_events[ 'jes_events_cityopt_enable' ] = 1;				

		if ( $_POST[ 'jes_events_countryopt_def' ] != null ) {
			$jes_events[ 'jes_events_countryopt_def' ] = stripslashes($_POST[ 'jes_events_countryopt_def' ]);
		}	

		if ( $_POST[ 'jes_events_stateopt_def' ] != null ) {
			$jes_events[ 'jes_events_stateopt_def' ] = stripslashes($_POST[ 'jes_events_stateopt_def' ]);
		}	

		if ( $_POST[ 'jes_events_cityopt_def' ] != null ) {
			$jes_events[ 'jes_events_cityopt_def' ] = stripslashes($_POST[ 'jes_events_cityopt_def' ]);
		}

/* -------------------- */
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
		<h4><?php _e('version','jet-event-system'); ?> 1.2 <?php _e('build','jet-event-system'); ?> 4
				- <?php _e('Template version:','jet-event-system');?> <?php if ( get_site_option( 'jes-theme-version' ) < JES_EVENTS_THEME_VERSION ) { echo "<span style='color:#CC0033;'"; } else { echo '<span>'; } ?><?php echo get_site_option( 'jes-theme-version' ); ?></span><?php echo '('.JES_EVENTS_THEME_VERSION.')'; ?>
				- <?php _e('DB version:','jet-event-system'); ?> <?php if ( get_site_option( 'jes-events-db-version' ) < JES_EVENTS_DB_VERSION ) { echo "<span style='color:#CC0033;'"; } else { echo '<span>'; } ?><?php echo get_site_option( 'jes-events-db-version' );?></span> <?php echo '('.JES_EVENTS_DB_VERSION.')'; ?></h4>

	<form action="" name="jes_events_update_component" id="jes_events_update_component" method="post">
	<?php
		if ( get_site_option( 'jes-events-db-version' ) < JES_EVENTS_DB_VERSION )
			{
				jes_events_init_jesdb();
				echo 'The database is updated!<br />';
			} 
				else
			{ ?>
				<SCRIPT LANGUAGE="JavaScript">
					function updateDB(form){
						var code="<?php jes_events_init_jesdb(); ?>";
						alert('The database is updated!');
					return true;
					}
				</SCRIPT>
				<input type="button" value="<?php _e('Update Database','jet-event-system'); ?> (<?php echo JES_EVENTS_DB_VERSION; ?>)" onClick="return updateDB(this.form)"> 
	<?php } ?>
	
<?php	if ( get_site_option( 'jes-theme-version' ) < JES_EVENTS_THEME_VERSION )
			{
				_e('There were changes in the theme file!','jet-event-system');
				echo '<br />';
				if ( update_template() )
					{
						_e('Theme files successfully updated!','jet-event-system');
						echo '<br />';
						update_site_option( 'jes-theme-version', JES_EVENTS_THEME_VERSION );
					}
						else
					{
						_e('An error occurred while updating the files! (check the folder themes)','jet-event-system');
					}
			}
				else
			{ ?>
				<SCRIPT LANGUAGE="JavaScript">
					function updateTHEME(form){
						var code="<?php update_template(); ?>";
						alert('Templates is updated!');
					return true;
					}
				</SCRIPT>			
				<input type="button" value="<?php _e('Update Templates','jet-event-system'); ?> (<?php echo JES_EVENTS_THEME_VERSION ?>)" onClick="return updateTHEME(this.form)"> 
			<?php }	?>
	</form>	
	
	<form action="<?php echo site_url() . '/wp-admin/admin.php?page=jes-event-admin' ?>" name="jes_events_form" id="jes_events_form" method="post">
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y" />

		<h3><?php _e( "Let's make some changes:", 'jet-event-system' ) ?></h3>

			<p><a href="#base-options" class="button"><?php _e('Base Options','jet-event-system'); ?></a> <a href="#sbase-options" class="button"><?php _e('Setting up access to the fields events','jet-event-system'); ?></a> <a href="#style-options" class="button"><?php _e('Style Options','jet-event-system'); ?></a> <a href="#classification-options" class="button"><?php _e('Classification Options','jet-event-system'); ?></a></p>
			<p><a href="#restrict-options" class="button"><?php _e('Restrict options','jet-event-system'); ?></a> <a href="#privacy-options" class="button"><?php _e('Privacy options','jet-event-system'); ?></a></p>
			<p><a href="#support" class="button"><?php _e('Support','jet-event-system'); ?></a> <a href="#translate" class="button"><?php _e('Translate','jet-event-system'); ?></a> <a href="#future" class="button"><?php _e('Future','jet-event-system'); ?></a> <a href="#donations" class="button"><?php _e('Donations','jet-event-system'); ?></a></p>
			<table width="100%">
				<tr valign="top">
					<td width="60%">
						<table class="form-table">
							<tr valign="top"><td><a name="base-options"><h4><?php _e('Base Options','jet-event-system'); ?></h4></a></td></tr>
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
										<option <?php if ($jes_events[ 'jes_events_sort_by' ] == 'soon') { ?>selected<?php } ?> value="soon"><?php _e('Upcoming','jet-event-system'); ?></option> 
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
							<th scope="row"><label for="jes_events_date_format"><?php _e( 'Date format (templates)*: ', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_date_format" type="text" id="jes_events_date_format" value="<?php echo $jes_events[ 'jes_events_date_format' ]; ?>" />
									<p><?php _e('* Please specify the date format in the format JQuery!','jet-event-system') ?><a href="http://docs.jquery.com/UI/Datepicker/formatDate"><?php _e('manual','jet-event-system'); ?></a></p>
								</td>
							</tr>

							<tr valign="top">
							<th scope="row"><label for="jes_events_date_format_in"><?php _e( 'Date format (php)**: ', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_date_format_in" type="text" id="jes_events_date_format_in" value="<?php echo $jes_events[ 'jes_events_date_format_in' ]; ?>" />
									<p><?php _e('** Please specify the date format in the format PHP!','jet-event-system') ?><a href="http://php.net/manual/en/function.date.php"><?php _e('manual','jet-event-system'); ?></a></p>
								</td>
							</tr>

							<tr valign="top"><td><a name="sbase-options"><h4><?php _e('Setting up access to the fields events','jet-event-system'); ?></h4></a></td></tr>

		<!-- Country/State/City Options -->
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

							<tr valign="top">
							<th scope="row"><label for="jes_events_cityopt_enable"><?php _e( 'Allow City', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_cityopt_enable" type="checkbox" id="jes_events_cityopt_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_cityopt_enable' ] ? ' checked="checked"' : '' ); ?> />
									<label for="jes_events_cityopt_def"><?php _e( 'Name of the city by default:', 'jet-event-system' ) ?></label>
									<input name="jes_events_cityopt_def" type="text" id="jes_events_cityopt_def" value="<?php echo $jes_events[ 'jes_events_cityopt_def' ]; ?>" />	
								</td>
							</tr>
							
		<!-- Country/State/City Options -->	
							
							<tr valign="top">
							<th scope="row"><label for="jes_events_specialconditions_enable"><?php _e( 'Allow Special Conditions', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_specialconditions_enable" type="checkbox" id="jes_events_specialconditions_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_specialconditions_enable' ] ? ' checked="checked"' : '' ); ?> />
								</td>
							</tr>			

							<tr valign="top">
							<th scope="row"><label for="jes_events_publicnews_enable"><?php _e( 'Allow Public News', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_publicnews_enable" type="checkbox" id="jes_events_publicnews_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_publicnews_enable' ] ? ' checked="checked"' : '' ); ?> />
								</td>
							</tr>			

							<tr valign="top">
							<th scope="row"><label for="jes_events_privatenews_enable"><?php _e( 'Allow Private News', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_privatenews_enable" type="checkbox" id="jes_events_privatenews_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_privatenews_enable' ] ? ' checked="checked"' : '' ); ?> />
								</td>
							</tr>	
		
							<tr valign="top"><td><a name="style-options"><h4><?php _e('Style Options','jet-event-system'); ?></h4></a></td></tr>			
			
							<tr valign="top">
							<th scope="row"><label for="jes_events_style"><?php _e( 'Style for Event Catalog:', 'jet-event-system' ) ?></label></th>
								<td>
									<select name="jes_events_style" id="jes_events_style" size = "1">
										<option <?php if ($jes_events[ 'jes_events_style' ] == 'Standart') { ?>selected <?php } ?>value="Standart"><?php _e('Standart Style','jet-event-system'); ?></option>
										<option <?php if ($jes_events[ 'jes_events_style' ] == 'Standard will full description') { ?>selected <?php } ?>value="Standard will full description"><?php _e('Standard will full description Style','jet-event-system'); ?></option>						
										<option <?php if ($jes_events[ 'jes_events_style' ] == 'Twitter') { ?>selected <?php } ?>value="Twitter"><?php _e('Twitter Style','jet-event-system'); ?></option>
									</select>
								</td>
							</tr>
	
							<tr valign="top">
							<th scope="row"><label for="jes_events_style_single"><?php _e( 'Style for Single Event:', 'jet-event-system' ) ?></label></th>
								<td>
									<select name="jes_events_style_single" id="jes_events_style_single" size = "1">
										<option <?php if ($jes_events[ 'jes_events_style_single' ] == 'Standart') { ?>selected <?php } ?>value="Standart"><?php _e('Standart Style','jet-event-system'); ?></option>			
										<option <?php if ($jes_events[ 'jes_events_style_single' ] == 'Twitter') { ?>selected <?php } ?>value="Twitter"><?php _e('Twitter Style','jet-event-system'); ?></option>
									</select>
								</td>
							</tr>

							<tr valign="top"><td><a name="avatar-options"><h5><?php _e('Avatar Options','jet-event-system'); ?></h5></a></td></tr>
							
							<tr valign="top">
							<th scope="row"><label for="jes_events_show_avatar_invite_enable"><?php _e( 'Show avatars in the list of invited friends', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_show_avatar_invite_enable" type="checkbox" id="jes_events_show_avatar_invite_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_show_avatar_invite_enable' ] ? ' checked="checked"' : '' ); ?> />
									<label for="jes_events_show_avatar_invite_size"><?php _e( 'Avatars size:', 'jet-event-system' ) ?></label>
									<input name="jes_events_show_avatar_invite_size" type="text" id="jes_events_show_avatar_invite_size" value="<?php echo $jes_events[ 'jes_events_show_avatar_invite_size' ]; ?>" />
								</td>
							</tr>

							<tr valign="top">
							<th scope="row"><label for="jes_events_show_avatar_main_size"><?php _e( 'Single Event - avatars size (25..150px):', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_show_avatar_main_size" type="text" id="jes_events_show_avatar_main_size" value="<?php echo $jes_events[ 'jes_events_show_avatar_main_size' ]; ?>" />
								</td>
							</tr>

							<tr valign="top">
							<th scope="row"><label for="jes_events_show_avatar_directory_size"><?php _e( 'Directory Events - avatars size ( 25..150px):', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_show_avatar_directory_size" type="text" id="jes_events_show_avatar_directory_size" value="<?php echo $jes_events[ 'jes_events_show_avatar_directory_size' ]; ?>" />
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

		<!-- Restrict options -->
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

		<!-- Privacy options -->	
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
				<p align="center" class="submit"><input type="submit" name="submit" value="<?php _e( 'Save Settings', 'jet-event-system' ) ?>"/></p>
	</form>
					</td>
					<td>
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

					<p>(<?php _e('please specify in the designation of the site and name:) All who have made a contribution to the development of plug-in will be included in honor roll, as well as gain access to additional modules!','jet-event-system'); ?>)<br /><br /></p>

						<a name="support"><h4><?php _e('Support','jet-event-system'); ?></h4></a>
							<p><a href="http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html">About</a><br />
							<a href="http://jes.milordk.ru">Website Developer</a><br /></p>
						<a name="future"><h4><?php _e('Future','jet-event-system'); ?></h4></a>
							<ul>
								<li>* In version 1.3 will be added to the possibility of tying the event to a group</li>
								<li>* In version 2.0 will ensure compatibility of the system with the new version of BP</li>
								<li>* In version 2.5 will be able to add events to Outlook Calendar and iCal (list may vary from those of the creator of the plug and the wishes of the participants testing)</li>
								<li>* In version 3.0 will be added to the possibility of tying the event to your blog (s)</li>
							</ul>

						<a name="translate"><h4><?php _e('Translate','jet-event-system'); ?></h4></a>
							<ul>
								<li><strong>ru_RU</strong> - <em>Jettochkin</em>, <a href="http://milordk.ru" target="_blank">http://milordk.ru</a></li>
								<li><strong>fr_FR</strong> - <em>Laurent Hermann</em>, <a href="http://www.paysterresdelorraine.com/" target="_blank">http://www.paysterresdelorraine.com/</a></li>
								<li><strong>de_DE</strong> - <em>Manuel MЭller</em>, <a href="http://www.pixelartist.de" target="_blank">www.pixelartist.de</a></li>
								<li><strong>es_ES</strong> - <em>Alex_Mx</em></li>
								<li><strong>da_DK</strong> - <em>Cavamondo</em></li>
							</ul>
							<p><br />To translate use <a href="http://www.poedit.net/">POEdit</a>, also present in the folder plugin POT-file</p>
							<p><em><?php _e('Please send your translations to milord_k @ mail.ru','jet-event-system'); ?></em></p>
							<p>Do not forget to include links to your sites (for accommodation options in the list of translators)</p>
							<p><?php _e('Translates can be discussed at the forum on the official website of the plugin:','jet-event-system'); ?> <a href="http://jes.milordk.ru/groups/translates/">Group</a></p>

						<a name="plugins"><h4><?php _e('Recommended plugins','jet-event-system'); ?></h4></a>
							<ul>
								<li><a href="http://milordk.ru/r-lichnoe/opyt/cms/jet-site-unit-could-poleznye-vidzhety-dlya-vashej-socialnoj-seti.html" title="Jet Site Unit Could">Jet Site Unit Could</a></li>
							</ul>
					</td>
				</tr>
			</table>
	</div>
<?php } ?>
