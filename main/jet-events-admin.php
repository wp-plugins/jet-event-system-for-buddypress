<?php
//avoid direct calls to this file where wp core files not present
if ( !function_exists( 'add_action' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

require ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/main/jet-events-update.php' );

$new_jes_events_admin = new JES_EVENTS_ADMIN_PAGE();

class JES_EVENTS_ADMIN_PAGE {

	//constructor of class, PHP4 compatible construction for backward compatibility (until WP 3.1)
	function jes_events_admin_page() {
		add_filter( 'screen_layout_columns', array( &$this, 'on_screen_layout_columns' ), 10, 2 );
		add_action( 'admin_menu', array( &$this, 'jeson_admin_menu' ) );
	}

	function on_screen_layout_columns( $columns, $screen ) {
		if ( $screen == $this->pagehook ) {
			$columns[ $this->pagehook ] = 2;
		}
		return $columns;
	}
	function jeson_admin_menu() {	
		$this->pagehook = add_submenu_page( 'bp-general-settings', __( 'Jet Event System', 'jet-event-system' ), __( 'Jet Event System', 'jet-event-system' ), 'manage_options', 'jes-event-admin', array( &$this, 'jeson_show_page' ) );
		add_action( 'load-'.$this->pagehook, array( &$this, 'on_load_page' ) );
	}
	//will be executed if wordpress core detects this page has to be rendered
	function on_load_page() {
		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'postbox' );

		// sidebar
		add_meta_box( 'jes-events-admin-information', __( 'Information', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_information'), $this->pagehook, 'side', 'core' );
		add_meta_box('jes-events-admin-donations', __( 'Donations', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_donations'), $this->pagehook, 'side', 'core');
		add_meta_box('jes-events-admin-setup', __( 'Setup', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_setupmain'), $this->pagehook, 'side', 'core');
		add_meta_box('jes-events-admin-support', __( 'Support', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_support'), $this->pagehook, 'side', 'core');
		add_meta_box('jes-events-admin-translate', __( 'Translate', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_translate'), $this->pagehook, 'side', 'core');
		add_meta_box('jes-events-admin-note', __( 'Note', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_note'), $this->pagehook, 'side', 'core');

		// main content - normal
		add_meta_box( 'jes-event-admin-baseoptions', __( 'Base Options', 'jet-event-system' ), array( &$this, 'on_jes_events_admin_baseoptions' ), $this->pagehook, 'normal', 'core' );
		add_meta_box('jes-event-admin-accessfield', __( 'Setting up access to the fields events', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_accessfield'), $this->pagehook, 'normal', 'core');

		add_meta_box('jes-event-admin-styleoptions', __( 'Style Options', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_styleoptions'), $this->pagehook, 'normal', 'core');		
	
		add_meta_box('jes-event-admin-classificationoptions', __( 'Classification options', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_classificationoptions'), $this->pagehook, 'normal', 'core');		

		add_meta_box('jes-event-admin-googlemap', __( 'Google Map options (future)', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_googlemap'), $this->pagehook, 'normal', 'core');

		add_meta_box('jes-event-admin-reminder', __( 'Reminder options (future)', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_reminder'), $this->pagehook, 'normal', 'core');

		add_meta_box('jes-event-admin-restrictoptions', __( 'Restrict options', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_restrictoptions'), $this->pagehook, 'normal', 'core');

		add_meta_box('jes-event-admin-privacyoptions', __( 'Privacy options', 'jet-event-system' ), array(&$this, 'on_jes_events_admin_privacyoptions'), $this->pagehook, 'normal', 'core');

	}

	//executed to show the plugins complete admin page
	function jeson_show_page() {
		global $bp, $wpdb;
		global $screen_layout_columns;

		//define some data can be given to each metabox during rendering
		$jes_events = get_option( 'jes-events' );
		?>
		<div id="jes-event-admin-general" class="wrap">
		<h2><img src="<?php echo WP_PLUGIN_URL . '/jet-event-system-for-buddypress/images/jeslogo.gif'; ?>"></h2>
		<?php
/* JES */

if ( isset($_POST['updatedb']) )
		{
			jes_events_init_jesdb();
			echo "<div id='message' class='updated fade'><p>" . __( 'Database updated.', 'jet-event-system' ) . "</p></div>";
		}

if ( isset($_POST['updatetemplate']) )
		{
			update_template($_POST['jthemepath']);
			echo "<div id='message' class='updated fade'><p>" . __( 'Templates updated.', 'jet-event-system' ) . "</p></div>";
		}

if ( isset($_POST['checkfiles']) )
		{
			echo "<div id='message' class='updated fade'><p>" . __( 'Files checked.', 'jet-event-system' ) . " - ".check_template($_POST['jthemepath'])."</p></div>";
		}

	$jes_events = get_option( 'jes_events' );
if ( isset($_POST['saveData']) ) {
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
		$jes_events[ 'jes_events_noteopt_enable' ] = 0;
		$jes_events[ 'jes_events_googlemapopt_enable' ] = 0;
		$jes_events[ 'jes_events_flyeropt_enable' ] = 0;
		$jes_events[ 'jes_events_specialconditions_enable' ] = 0;
		$jes_events[ 'jes_events_publicnews_enable' ] = 0;
		$jes_events[ 'jes_events_privatenews_enable' ] = 0;
		$jes_events[ 'jes_events_show_avatar_invite_enable' ] = 0;
		$jes_events[ 'jes_events_notifymembers_manual_enable' ] = 0;
		$jes_events[ 'jes_events_flyer_toall' ] = 0;		

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

		if ( $_POST[ 'jes_events_notifymembers_manual_enable' ] == 1 ) 
			$jes_events[ 'jes_events_notifymembers_manual_enable' ] = 1;
		
		if ( $_POST[ 'jes_events_flyer_toall' ] == 1 ) 
			$jes_events[ 'jes_events_flyer_toall' ] = 1;
			
			
/* Access to Event Fields */
	/* Conditions - News */
		if ( $_POST[ 'jes_events_specialconditions_enable' ] == 1 ) 
			$jes_events[ 'jes_events_specialconditions_enable' ] = 1;
			
		if ( $_POST[ 'jes_events_publicnews_enable' ] == 1 ) 
			$jes_events[ 'jes_events_publicnews_enable' ] = 1;

		if ( $_POST[ 'jes_events_privatenews_enable' ] == 1 ) 
			$jes_events[ 'jes_events_privatenews_enable' ] = 1;
	/* Country/State/City */
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
	/* Note / googlemap / flyer */
		if ( $_POST[ 'jes_events_noteopt_enable' ] == 1 ) 
			$jes_events[ 'jes_events_noteopt_enable' ] = 1;

		if ( $_POST[ 'jes_events_googlemapopt_enable' ] == 1 ) 
			$jes_events[ 'jes_events_googlemapopt_enable' ] = 1;

		if ( $_POST[ 'jes_events_flyeropt_enable' ] == 1 ) 
			$jes_events[ 'jes_events_flyeropt_enable' ] = 1;	
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

/* Color Event */

		if ( $_POST[ 'jes_events_color_past' ] != null ) {
			$jes_events[ 'jes_events_color_past' ] = stripslashes($_POST[ 'jes_events_color_past' ]);
		} else {
			$jes_events[ 'jes_events_color_past' ] = 'CCCCCC';
		}

		if ( $_POST[ 'jes_events_color_current' ] != null ) {
			$jes_events[ 'jes_events_color_current' ] = stripslashes($_POST[ 'jes_events_color_current' ]);
		} else {
			$jes_events[ 'jes_events_color_current' ] = '33CC00';
		}

		if ( $_POST[ 'jes_events_color_active' ] != null ) {
			$jes_events[ 'jes_events_color_active' ] = stripslashes($_POST[ 'jes_events_color_active' ]);
		} else {
			$jes_events[ 'jes_events_color_active' ] = 'FF9900';
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

/* Notify */
		if ( $_POST[ 'jes_events_notify_timed' ] != null ) {
			$jes_events[ 'jes_events_notify_timed' ] = stripslashes($_POST[ 'jes_events_notify_timed' ]);
		}else{
			$jes_events[ 'jes_events_notify_timed' ] = '12';		
		}

		if ( $_POST[ 'jes_events_notifymembers_enable' ] != null ) {
			$jes_events[ 'jes_events_notifymembers_enable' ] = stripslashes($_POST[ 'jes_events_notifymembers_enable' ]);
		}else{
			$jes_events[ 'jes_events_notifymembers_enable' ] = 'admin';
		}
/* Google map */
		if ( $_POST[ 'jes_events_googlemapopt_type' ] != null ) {
			$jes_events[ 'jes_events_googlemapopt_type' ] = stripslashes($_POST[ 'jes_events_googlemapopt_type' ]);
		}else{
			$jes_events[ 'jes_events_googlemapopt_type' ] = 'google';
		}

/* -------------------- */

if (stripos($blogversion, 'MU') > 0)
	{
		$blogs_ids = get_blog_list( 0, 'all' );
		foreach ($blogs_ids as $blog) {
			update_blog_option( $blog['blog_id'], 'jes_events', $jes_events );
		}
	} else {
		update_option( 'jes_events', $jes_events );
	}
		echo "<div id='message' class='updated fade'><p>" . __( 'Options updated.', 'jet-event-system' ) . "</p></div>";
	}

/* JES */
		?>

	<form action="<?php echo site_url() . '/wp-admin/admin.php?page=jes-event-admin' ?>" name="jes_events_form" id="jes_events_form" method="post">
			<?php wp_nonce_field('jes-event-admin-general'); ?>
			<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>

			<div id="poststuff" class="metabox-holder<?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
            <div id="side-info-column" class="inner-sidebar">
					<?php do_meta_boxes($this->pagehook, 'side', $jes_events); ?>
				</div>
				<div id="post-body" class="has-sidebar">
					<div id="post-body-content" class="has-sidebar-content">
						<?php do_meta_boxes($this->pagehook, 'normal', $jes_events); ?>
				<p align="center" class="submit"><input type="submit" name="saveData" value="<?php _e( 'Save Settings', 'jet-event-system' ) ?>"/></p>						
					</div>
				</div>
			</div>
		</form>
		</div>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
		});
		//]]>
	</script>

		<?php
	}
   /*
    * Sidebar Blocks
    */
	
function on_jes_events_admin_donations($jes_events) {
?>
	<p><em>WMZ</em>: <strong>Z113010060388</strong> / <em>WMR</em>: <strong>R144831580346</strong></p>

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

		<p>(<?php _e('please specify in the designation of the site and name :) All who have made a contribution to the development of plug-in will be included in honor roll, as well as gain access to additional modules!','jet-event-system'); ?>)</p>
<?php
}
	
function on_jes_events_admin_support($jes_events) {
?>
	<p><a href="http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html">About</a></p>
	<p><a href="http://jes.milordk.ru">Website Developer</a>: <a href="http://jes.milordk.ru/manual-working-with-a-event.html">Manual</a>, <a href="http://jes.milordk.ru/changelog.html">Changelog</a>, <a href="http://jes.milordk.ru/polls-oprosy.html">Polls</a></p>
<?php
}

function on_jes_events_admin_translate($jes_events) {
?>
<p><ul>
		<li><strong>ru_RU</strong> - <em>Jettochkin</em>, <a href="http://milordk.ru" target="_blank">milordk.ru</a></li>
		<li><strong>fr_FR</strong> - <em>Laurent Hermann</em>, <a href="http://www.paysterresdelorraine.com/" target="_blank">paysterresdelorraine.com/</a></li>
		<li><strong>de_DE</strong> - <em>Manuel MЭller</em>, <a href="http://www.pixelartist.de" target="_blank">pixelartist.de</a></li>
		<li><strong>es_ES</strong> - <em>Alex_Mx</em></li>
		<li><strong>da_DK</strong> - <em>Cavamondo</em></li>
		<li><strong>it_IT</strong> - <em>Andrea</em>, <a href="http://riderbook.it">riderbook.it</a>
	</ul></p>
	<p>To translate use <a href="http://www.poedit.net/">POEdit</a>, also present in the folder plugin POT-file</p>
	<p><em><?php _e('Please send your translations to milord_k @ mail.ru','jet-event-system'); ?></em></p>
	<p>Do not forget to include links to your sites (for accommodation options in the list of translators)</p>
	<p><?php _e('Translates can be discussed at the forum on the official website of the plugin:','jet-event-system'); ?> <a href="http://jes.milordk.ru/groups/translates/">Group</a></p>
<?php
}

function on_jes_events_admin_note($jes_events) {
?>
<p><strong><?php _e('Recommended plugins','jet-event-system'); ?></strong>
	<ul>
		<li><a href="http://milordk.ru/r-lichnoe/opyt/cms/jet-site-unit-could-poleznye-vidzhety-dlya-vashej-socialnoj-seti.html" title="Jet Site Unit Could">Jet Site Unit Could</a></li>
		<li><a href="http://milordk.ru/r-lichnoe/opyt/cms/publikaciya-v-wordpress-minuyu-administrativnuyu-panel-jet-quickpress.html">Jet QuickPress</a></li>
		<li><a href="http://milordk.ru/r-lichnoe/opyt/cms/v-pomoshh-adminam-jet-footer-code.html">Jet Footer Code</a></li>
		<li><a href="http://cosydale.com/plugin-cd-avatar-bubble.html">CD Avatar Bubble</a></li>
	</ul></p>
	<p>Special thanks to <a href="http://cosydale.com">slaFFik</a> for his help in writing a plugin!</p>
<?php
}
	
function on_jes_events_admin_information($jes_events) {
?>
		<h4>Jet Event System <?php _e('version','jet-event-system'); ?> <?php echo JES_EVENTS_VERSION; ?> <?php _e('build','jet-event-system'); ?> <?php echo JES_EVENTS_BUILD; ?></h4>
				<p><?php echo JES_EVENTS_RELEASE; ?></p>
			<p><?php _e('Template version:','jet-event-system');?>
				<?php if ( get_site_option( 'jes-theme-version' ) < JES_EVENTS_THEME_VERSION )
							{
								echo '<span style="color:#CC0033;">';
							} else {
								echo '<span>';
							} ?>
				<?php echo get_site_option( 'jes-theme-version' ); ?></span><?php echo '('.JES_EVENTS_THEME_VERSION.')'; ?></p>
				<p><?php _e('DB version:','jet-event-system'); ?>
				<?php if ( get_site_option( 'jes-events-db-version' ) < JES_EVENTS_DB_VERSION )
							{
								echo '<span style="color:#CC0033;">';
							} else {
								echo '<span>';
							} ?>
				<?php echo get_site_option( 'jes-events-db-version' );?></span><?php echo '('.JES_EVENTS_DB_VERSION.')'; ?></p>
			<p><strong>locale:</strong> wplang: <?php echo WPLANG; ?>, wplocale: <?php echo apply_filters( 'wordpress_locale', get_locale() ); ?></p>
<?php
}

function on_jes_events_admin_setupmain($jes_events) {
?>  
	<form action="<?php echo site_url() . '/wp-admin/admin.php?page=jes-event-admin' ?>" name="jes_events_update_j" id="jes_events_update_j" method="post">
		<label name="jthemepath"><?php _e('Select the location you are using themes:','jet-event-system'); ?></label>
<?php
	$stps_vis = substr(STYLESHEETPATH,strlen(STYLESHEETPATH)-25,strlen(STYLESHEETPATH)-24);
?>
		<select name="jthemepath">
			<option value="<?php echo STYLESHEETPATH; ?>">..<?php echo substr(STYLESHEETPATH,strlen(STYLESHEETPATH)-30,strlen(STYLESHEETPATH)-29); ?>*</option>
			<option value="<?php echo TEMPLATEPATH; ?>">..<?php echo substr(TEMPLATEPATH,strlen(TEMPLATEPATH)-30,strlen(TEMPLATEPATH)-29); ?></option>
		</select>
		<input type="submit" name="updatedb" value="<?php _e( 'Update Database', 'jet-event-system' ) ?>"/>
		<input type="submit" name="updatetemplate" value="<?php _e( 'Update Templates', 'jet-event-system' ) ?>"/>
		<input type="submit" name="checkfiles" value="<?php _e( 'Checking for files', 'jet-event-system' ) ?>"/>		
	</form>	
<?php	}

   /*
    * Main Content Blocks
    */
	function on_jes_events_admin_baseoptions($jes_events) {
	?>
						<table class="form-table" width="90%">
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
</table>
<?
	}

	function on_jes_events_admin_accessfield($jes_events) {
?>
						<table class="form-table" width="90%">
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

<?php /* note / googlemap / flyer */ ?>

							<tr valign="top">
							<th scope="row"><label for="jes_events_noteopt_enable"><?php _e( 'Allow Event Note', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_noteopt_enable" type="checkbox" id="jes_events_noteopt_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_noteopt_enable' ] ? ' checked="checked"' : '' ); ?> />
								</td>
							</tr>	

							<tr valign="top">
							<th scope="row"><label for="jes_events_googlemapopt_enable"><?php _e( 'Allow Event GoogleMap', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_googlemapopt_enable" type="checkbox" id="jes_events_googlemap_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_googlemapopt_enable' ] ? ' checked="checked"' : '' ); ?> />
								</td>
							</tr>
							
							<tr valign="top">
							<th scope="row"><label for="jes_events_flyeropt_enable"><?php _e( 'Allow Event Flyer', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_flyeropt_enable" type="checkbox" id="jes_events_flyeropt_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_flyeropt_enable' ] ? ' checked="checked"' : '' ); ?> />
								</td>
							</tr>				
</table>
<?php      
   }

	function on_jes_events_admin_styleoptions($jes_events) {
?>
						<table class="form-table" width="90%">
							<tr valign="top">
							<th scope="row"><label for="jes_events_style"><?php _e( 'Style for Event Catalog:', 'jet-event-system' ) ?></label></th>
								<td>
									<select name="jes_events_style" id="jes_events_style" size = "1">
										<option <?php if ($jes_events[ 'jes_events_style' ] == 'Standart') { ?>selected <?php } ?>value="Standart"><?php _e('Standart Style','jet-event-system'); ?></option>
										<option <?php if ($jes_events[ 'jes_events_style' ] == 'Standard will full description') { ?>selected <?php } ?>value="Standard will full description"><?php _e('Standard will full description Style','jet-event-system'); ?></option>						
										<option <?php if ($jes_events[ 'jes_events_style' ] == 'Twitter') { ?>selected <?php } ?>value="Twitter"><?php _e('Twitter Style','jet-event-system'); ?></option>
										<option <?php if ($jes_events[ 'jes_events_style' ] == 'Custom') { ?>selected <?php } ?>value="Custom"><?php _e('Custom Style*','jet-event-system'); ?></option>
									</select>
<p><?php _e('* To use a custom design Directory Events, modify the file:','jet-event-system'); ?> <?php echo STYLESHEETPATH.'/events/looptemplates/custom.php'; ?></p>
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

							<tr valign="top"><td><p><strong><?php _e('Avatar Options','jet-event-system'); ?></strong></p></td></tr>
							
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
							
							<tr valign="top">
							<th scope="row"><label for="jes_events_color_past"><?php _e( 'Color for past event:', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_color_past" type="text" id="jes_events_color_past" value="<?php echo $jes_events[ 'jes_events_color_past' ]; ?>" />
								</td>
							</tr>							

							<tr valign="top">
							<th scope="row"><label for="jes_events_color_active"><?php _e( 'Color for active event:', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_color_active" type="text" id="jes_events_color_active" value="<?php echo $jes_events[ 'jes_events_color_active' ]; ?>" />
								</td>
							</tr>

							<tr valign="top">
							<th scope="row"><label for="jes_events_color_current"><?php _e( 'Color for current event:', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_color_current" type="text" id="jes_events_color_current" value="<?php echo $jes_events[ 'jes_events_color_current' ]; ?>" />
								</td>
							</tr>
							
</table>							
<?php  
   }   

	function on_jes_events_admin_classificationoptions($jes_events) {
?>
						<table class="form-table" width="90%">
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
</table>
<?php  
   } 
   
	function on_jes_events_admin_restrictoptions($jes_events) {
?>
						<table class="form-table" width="90%">
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
</table>
<?php   } 

	function on_jes_events_admin_privacyoptions($jes_events) {
?>
						<table class="form-table" width="90%">
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
							
							<tr valign="top">
							<th scope="row"><label for="jes_events_flyer_toall"><?php _e( 'Show flyers to all users? (otherwise, flyers will be available only to participants of the event)', 'jet-event-system' ) ?></label></th>
								<td>
									<input name="jes_events_flyer_toall" type="checkbox" id="jes_events_flyer_toall" value="1"<?php echo( '1' == $jes_events[ 'jes_events_flyer_toall' ] ? ' checked="checked"' : '' ); ?> />
								</td>
							</tr>							
</table>
<?php   }   

	function on_jes_events_admin_reminder($jes_events) {
?>
	<table class="form-table" width="90%">
	
		<tr valign="top">
			<th scope="row"><label for="jes_events_notifymembers_manual_enable"><?php _e( 'Provide administrators an opportunity to remind participants of the events of the coming event in manual mode?', 'jet-event-system' ) ?></label></th>
			<td>
				<input name="jes_events_notifymembers_manual_enable" type="checkbox" id="jes_events_notifymembers_manual_enable" value="1"<?php echo( '1' == $jes_events[ 'jes_events_notifymembers_manual_enable' ] ? ' checked="checked"' : '' ); ?> />
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row"><label for="jes_events_notifymembers_enable"><?php _e( 'To allow the setting reminder?', 'jet-event-system' ) ?></label></th>
			<td>
				<select name="jes_events_notifymembers_enable" id="jes_events_notifymembers_enable">
					<option <?php if ($jes_events[ 'jes_events_notifymembers_enable' ] == 'admin') { ?>selected<?php } ?> value="admin"><?php _e('Administrators','jet-event-system'); ?></option>
					<option <?php if ($jes_events[ 'jes_events_notifymembers_enable' ] == 'user') { ?>selected<?php } ?> value="user"><?php _e('All users','jet-event-system'); ?></option>
					<option <?php if ($jes_events[ 'jes_events_notifymembers_enable' ] == 'none') { ?>selected<?php } ?> value="none"><?php _e('Function is not active','jet-event-system'); ?></option>				
				</select>
			</td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="jes_events_notify_timed"><?php _e( 'Time remind default:', 'jet-event-system' ) ?></label></th>
			<td>
				<select name="jes_events_notify_timed" id="jes_events_notify_timed">
					<option <?php if ($jes_events[ 'jes_events_notify_timed' ] == '1') { ?>selected<?php } ?> value="1"><?php echo sprintf ( __('%s hours','jet-event-system'),'1'); ?></option>
					<option <?php if ($jes_events[ 'jes_events_notify_timed' ] == '2') { ?>selected<?php } ?> value="2"><?php echo sprintf ( __('%s hours','jet-event-system'),'2'); ?></option>
					<option <?php if ($jes_events[ 'jes_events_notify_timed' ] == '3') { ?>selected<?php } ?> value="3"><?php echo sprintf ( __('%s hours','jet-event-system'),'3'); ?></option>
					<option <?php if ($jes_events[ 'jes_events_notify_timed' ] == '5') { ?>selected<?php } ?> value="5"><?php echo sprintf ( __('%s hours','jet-event-system'),'5'); ?></option>
					<option <?php if ($jes_events[ 'jes_events_notify_timed' ] == '12') { ?>selected<?php } ?> value="12"><?php echo sprintf ( __('%s hours','jet-event-system'),'12'); ?></option>
					<option <?php if ($jes_events[ 'jes_events_notify_timed' ] == '24') { ?>selected<?php } ?> value="24"><?php echo sprintf ( __('%s hours','jet-event-system'),'24'); ?></option>
					<option <?php if ($jes_events[ 'jes_events_notify_timed' ] == '48') { ?>selected<?php } ?> value="48"><?php echo sprintf ( __('%s hours','jet-event-system'),'48'); ?></option>
			</select>
			</td>
		</tr>
	</table>
<?php   } 

	function on_jes_events_admin_googlemap($jes_events) {
?>
	<table class="form-table" width="90%">
		
		<tr valign="top">
			<th scope="row"><label for="jes_events_googlemapopt_type"><?php _e( 'Use the following mechanism for the demonstration maps:', 'jet-event-system' ) ?></label></th>
			<td>
				<select name="jes_events_googlemapopt_type" id="jes_events_googlemapopt_type">
					<option <?php if ($jes_events[ 'jes_events_googlemapopt_type' ] == 'google') { ?>selected<?php } ?> value="google"><?php _e('Google','jet-event-system'); ?></option>
					<option <?php if ($jes_events[ 'jes_events_googlemapopt_type' ] == 'image') { ?>selected<?php } ?> value="image"><?php _e('Image','jet-event-system'); ?></option>
				</select>
			</td>
		</tr>
	</table>
<?php   } 
}
?>