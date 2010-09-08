<?php
//avoid direct calls to this file where wp core files not present
if ( !function_exists( 'add_action' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/* Update Templates from Admin Panel */
function move_template($fpatch, $fname)
	{
		$permisionsbug = 0;
		$stringtoreturn = ' ';
		$filename1 = WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/templates/'.$fpatch.'/'.$fname;
		$filename2 = TEMPLATEPATH . '/'.$fpatch.'/'.$fname;
		if ( file_exists($filename2) )
			{
				if (!unlink($filename2))
					{
						$permisionsbug = 1;
					}
			}		
		if ( !copy($filename1,$filename2) )
			{ $permisionsbug = 1; }
					else
			{ $permisionsbug = 0; }

		if ($permisionsbug)
			{
				return false;
			} else {
				return true;
			}
}

function update_template()
	{
?>
<p>Code create folders:&nbsp;
<?php
// Create Dir
		mkdir( TEMPLATEPATH . '/events', 0777, 1 );
		mkdir( TEMPLATEPATH . '/events/single', 0777, 1 );
		mkdir( TEMPLATEPATH . '/events/js', 0777, 1 );
		mkdir( TEMPLATEPATH . '/members', 0777, 1 );
		mkdir( TEMPLATEPATH . '/members/single', 0777, 1 );
		mkdir( TEMPLATEPATH . '/members/single/events', 0777, 1 );
		mkdir( TEMPLATEPATH . '/events/css', 0777, 1 );
		mkdir( TEMPLATEPATH . '/events/css/images', 0777, 1 );
		echo '</p>';
?>
<p>Code transfer Templates:&nbsp;
<?php		
// Copy templates files
	/* Events Main */
$rezult = 1;
		if (!move_template( 'events','create.php')) { $rezult = 0; }
		if (!move_template( 'events','events-loop.php')) { $rezult = 0; }
		if (!move_template( 'events','index.php')) { $rezult = 0; }
	/* Events single */
		if (!move_template( 'events/single','activity.php')) { $rezult = 0; }
		if (!move_template( 'events/single','admin.php')) { $rezult = 0; }
		if (!move_template( 'events/single','details.php')) { $rezult = 0; }
		if (!move_template( 'events/single','event-header.php')) { $rezult = 0; }
		if (!move_template( 'events/single','home.php')) { $rezult = 0; }
		if (!move_template( 'events/single','members.php')) { $rezult = 0; }
		if (!move_template( 'events/single','plugins.php')) { $rezult = 0; }
		if (!move_template( 'events/single','request-join-to-event.php')) { $rezult = 0; }
		if (!move_template( 'events/single','send-invites.php')) { $rezult = 0; }
		if (!move_template( 'events/single','google-map.php')) { $rezult = 0; }
		if (!move_template( 'events/single','flyer.php')) { $rezult = 0; }
	/* Datepicker */
		if (!move_template( 'events/css','datepicker.css')) { $rezult = 0; }
		if (!move_template( 'events/css/images','ui-bg_flat_0_aaaaaa_40x100.png')) { $rezult = 0; }		
		if (!move_template( 'events/css/images','ui-bg_flat_75_ffffff_40x100.png')) { $rezult = 0; }
		if (!move_template( 'events/css/images','ui-bg_glass_55_fbf9ee_1x400.png')) { $rezult = 0; }		
		if (!move_template( 'events/css/images','ui-bg_glass_65_ffffff_1x400.png')) { $rezult = 0; }		
		if (!move_template( 'events/css/images','ui-bg_glass_75_dadada_1x400.png')) { $rezult = 0; }		
		if (!move_template( 'events/css/images','ui-bg_glass_75_e6e6e6_1x400.png')) { $rezult = 0; }		
		if (!move_template( 'events/css/images','ui-bg_glass_95_fef1ec_1x400.png')) { $rezult = 0; }
		if (!move_template( 'events/css/images','ui-bg_highlight-soft_75_cccccc_1x100.png')) { $rezult = 0; }
		if (!move_template( 'events/css/images','ui-icons_2e83ff_256x240.png')) { $rezult = 0; }		
		if (!move_template( 'events/css/images','ui-icons_222222_256x240.png')) { $rezult = 0; }
		if (!move_template( 'events/css/images','ui-icons_454545_256x240.png')) { $rezult = 0; }
		if (!move_template( 'events/css/images','ui-icons_888888_256x240.png')) { $rezult = 0; }
		if (!move_template( 'events/css/images','ui-icons_cd0a0a_256x240.png')) { $rezult = 0; }
		if (!move_template( 'events/js','jquery-1.4.2.min.js')) { $rezult = 0; }
		if (!move_template( 'events/js','jquery-ui-1.8.4.custom.min.js')) { $rezult = 0; }
	/* Member section */
		if (!move_template( 'members/single','events.php')) { $rezult = 0; }
		if (!move_template( 'members/single/events','invites.php')) { $rezult = 0; }
return $rezult;
}
?>