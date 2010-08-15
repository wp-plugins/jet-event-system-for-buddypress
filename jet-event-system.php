<?php
/*
Plugin Name: Jet Event System for BuddyPress
Plugin URI: http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html
Description: System events for your social network. Ability to attract members of the network to the ongoing activities.
Version: 1.1.8.3
Author: Jettochkin
Author URI: http://milordk.ru/
Site Wide Only: true
Network: true
*/

define('Jet Events System', '1.1.8');
define ('JES_EVENTS_DB_VERSION', '1.2');

/* Define the slug for the component */
if ( !defined( 'JES_SLUG' ) ) {
$edata = get_option( 'jes_events' );
if (!$edata[ 'jes_events_costumslug_enable' ])  {
	define ( 'JES_SLUG', 'events' );
	}
	else
	{
	define ( 'JES_SLUG', $edata[ 'jes_events_costumslug' ] );	
	}
}

function hidden_events()
{
global $bp;
if ( ! (bp_is_page(JES_SLUG) ) ) {
	return;
}
	else
{
	if ( ! is_user_logged_in())
		bp_core_redirect($bp->root_domain.'/'.BP_REGISTER_SLUG);
	}
} 
$edata = get_option( 'jes_events' );
if ($edata[ 'jes_events_addnavi_disable' ]) {
add_action('get_header','hidden_events');
}

require ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-classes.php' );
require ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-templatetags.php' );
require ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-widgets.php' );
require ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-filters.php' );
require ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-notifications.php' );
require ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-admin.php' );

function jet_event_system_load_textdomain() {
	$locale = apply_filters( 'wordpress_locale', get_locale() );
	$mofile = dirname( __File__ )   . "/jet-event-system-$locale.mo";

	if ( file_exists( $mofile ) )
		load_textdomain( 'jet-event-system', $mofile );
}
add_action ( 'plugins_loaded', 'jet_event_system_load_textdomain', 7 );


function jes_add_admin_menu() {
	if ( !is_site_admin() )
		return false;
		
	add_submenu_page( 'bp-general-settings', __( 'Jet Event System', 'jet-event-system' ), __( 'Jet Event System', 'jet-event-system' ), 'manage_options', 'jes-event-admin', 'jes_event_admin' );

}
add_action( 'admin_menu', 'jes_add_admin_menu' );	


function jet_events_add_js() {
  global $bp;

	if ( $bp->current_component == $bp->jes_events->slug )
		wp_enqueue_script( 'jet-event-js', get_stylesheet_directory_uri() . '/events/js/datepacker.js' );
	
}
add_action( 'template_redirect', 'jet_events_add_js', 1 );	
	
function jes_events_init_jesdb() {
	global $wpdb, $bp;

	if ( !empty($wpdb->charset) )
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";

	$sql[] = "CREATE TABLE {$bp->jes_events->table_name} (
	  		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			creator_id bigint(20) NOT NULL,
	  		name varchar(100) NOT NULL,
			etype varchar(20) NOT NULL,
	  		slug varchar(100) NOT NULL,
	  		description longtext NOT NULL,
	  		eventterms longtext NOT NULL,			
			placedcity varchar(20) NOT NULL,
			placedaddress varchar(80) NOT NULL,			
			newspublic longtext,			
			newsprivate longtext,
			edtsd varchar(18) NOT NULL,
			edted varchar(18) NOT NULL,			
			edtsdunix varchar(18) NOT NULL,
			edtedunix varchar(18) NOT NULL,			
			status varchar(10) NOT NULL DEFAULT 'public',
			enable_forum tinyint(1) NOT NULL DEFAULT '1',
			eventapproved varchar(1),
			date_created datetime NOT NULL,
		    KEY creator_id (creator_id),
		    KEY status (status),
			KEY etype (etype),
			KEY placedcity (placedcity)
	 	   ) {$charset_collate};";

	$sql[] = "CREATE TABLE {$bp->jes_events->jes_table_name_members} (
	  		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			event_id bigint(20) NOT NULL,
			user_id bigint(20) NOT NULL,
			inviter_id bigint(20) NOT NULL,
			is_admin tinyint(1) NOT NULL DEFAULT '0',
			is_mod tinyint(1) NOT NULL DEFAULT '0',
			user_title varchar(100) NOT NULL,
			date_modified datetime NOT NULL,
			comments longtext NOT NULL,
			is_confirmed tinyint(1) NOT NULL DEFAULT '0',
			is_banned tinyint(1) NOT NULL DEFAULT '0',
			invite_sent tinyint(1) NOT NULL DEFAULT '0',
			KEY event_id (event_id),
			KEY is_admin (is_admin),
			KEY is_mod (is_mod),
		 	KEY user_id (user_id),
			KEY inviter_id (inviter_id),
			KEY is_confirmed (is_confirmed)
	 	   ) {$charset_collate};";

	$sql[] = "CREATE TABLE {$bp->jes_events->table_name_eventmeta} (
			id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			event_id bigint(20) NOT NULL,
			meta_key varchar(255) DEFAULT NULL,
			meta_value longtext DEFAULT NULL,
			KEY event_id (event_id),
			KEY meta_key (meta_key)
		   ) {$charset_collate};";
		   
	$sql[] = "CREATE TABLE {$bp->jes_events->table_name_activity} (
	  		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			creator_id bigint(20) NOT NULL,
	  		description longtext NOT NULL,
			a_datetime varchar(18) NOT NULL,
			a_datetime_unix varchar(18) NOT NULL,
		    KEY creator_id (creator_id),
			KEY a_datetime_unix (a_datetime_unix)
	 	   ) {$charset_collate};";
		   

	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
	dbDelta($sql);

	do_action( 'jes_events_init_jesdb' );

	update_site_option( 'jes-db-version', JES_EVENTS_DB_VERSION );	
	
}

function jes_events_setup_globals() {
	global $bp, $wpdb;

	/* For internal identification */
	$bp->jes_events->id = 'events';

	$bp->jes_events->table_name = $wpdb->base_prefix . 'jet_events';
	$bp->jes_events->table_name_activity = $wpdb->base_prefix . 'jet_events_activity';	
	$bp->jes_events->jes_table_name_members = $wpdb->base_prefix . 'jet_events_members';
	$bp->jes_events->table_name_eventmeta = $wpdb->base_prefix . 'jet_events_eventmeta';
	$bp->jes_events->format_notification_function = 'events_format_notifications';
	$bp->jes_events->slug = JES_SLUG;
	/* Register this in the active components array */
	$bp->active_components[$bp->jes_events->slug] = $bp->jes_events->id;

	$bp->jes_events->forbidden_names = apply_filters( 'events_forbidden_names', array( 'my-events', 'create', 'invites', 'send-invites', 'forum', 'delete', 'add', 'admin', 'request-join-to-event', 'members', 'settings', 'avatar', JES_SLUG ) );

	$bp->jes_events->event_creation_steps = apply_filters( 'events_create_event_steps', array(
		'event-details' => array( 'name' => __( 'Details', 'jet-event-system' ), 'position' => 0 ),
		'event-settings' => array( 'name' => __( 'Settings', 'jet-event-system' ), 'position' => 10 ),
		'event-avatar' => array( 'name' => __( 'Avatar', 'jet-event-system' ), 'position' => 20 ),
	) );

	$bp->jes_events->valid_status = apply_filters( 'events_valid_status', array( 'public', 'private', 'hidden' ) );

	do_action( 'jes_events_setup_globals' );
}
add_action( 'bp_setup_globals', 'jes_events_setup_globals' );

/* Ajax Tabs */
add_action( 'wp_ajax_events_filter', 'bp_dtheme_object_template_loader' );

function events_setup_root_component() {
	/* Register 'events' as a root component */
	bp_core_add_root_component( JES_SLUG );
}
add_action( 'bp_setup_root_components', 'events_setup_root_component' );

function events_check_installed() {
	/* Need to check db tables exist, activate hook no-worky in mu-plugins folder. */
	if ( get_site_option( 'jes-db-version' ) < JES_EVENTS_DB_VERSION )
		jes_events_init_jesdb();
}
add_action( 'admin_menu', 'events_check_installed' );

function add_events_to_main_menu() {

	$class = (bp_is_page('events')) ? ' class="selected" ' : '';

	echo  '<li ' . $class. '><a href="' . get_option('home') . '/'.JES_SLUG.'" title="' . __( 'Events', 'jet-event-system' ) .'">' .  __( 'Events', 'jet-event-system' ) .'</a></li>';

}

add_action('bp_nav_items','add_events_to_main_menu');


function events_setup_nav() {
	global $bp;

	if ( $bp->current_component == $bp->jes_events->slug && $event_id = JES_Events_Event::jes_event_exists($bp->current_action) ) {

		/* This is a single event page. */
		$bp->is_single_item = true;
		$bp->jes_events->current_event = new JES_Events_Event( $event_id );

		/* Using "item" not "event" for generic support in other components. */
		if ( is_site_admin() )
			$bp->is_item_admin = 1;
		else
			$bp->is_item_admin = events_is_user_admin( $bp->loggedin_user->id, $bp->jes_events->current_event->id );

		/* If the user is not an admin, check if they are a moderator */
		if ( !$bp->is_item_admin )
			$bp->is_item_mod = events_is_user_mod( $bp->loggedin_user->id, $bp->jes_events->current_event->id );

		/* Is the logged in user a member of the event? */
		$bp->jes_events->current_event->is_user_member = ( is_user_logged_in() && events_is_user_member( $bp->loggedin_user->id, $bp->jes_events->current_event->id ) ) ? true : false;

		/* Should this event be visible to the logged in user? */
		$bp->jes_events->current_event->is_event_visible_to_member = ( 'public' == $bp->jes_events->current_event->status || $is_member ) ? true : false;
	}

	/* Add 'Events' to the main navigation */
	bp_core_new_nav_item( array( 'name' => sprintf( __( 'Events <span>(%d)</span>', 'jet-event-system' ), events_total_events_for_user() ), 'slug' => $bp->jes_events->slug, 'position' => 70, 'screen_function' => 'events_screen_my_events', 'default_subnav_slug' => 'my-events', 'item_css_id' => $bp->jes_events->id ) );

	$events_link = $bp->loggedin_user->domain . $bp->jes_events->slug . '/';

	/* Add the subnav items to the events nav item */
	bp_core_new_subnav_item( array( 'name' => __( 'My Events', 'jet-event-system' ), 'slug' => 'my-events', 'parent_url' => $events_link, 'parent_slug' => $bp->jes_events->slug, 'screen_function' => 'events_screen_my_events', 'position' => 10, 'item_css_id' => 'events-my-events' ) );

	if ( $bp->current_component == $bp->jes_events->slug ) {

		if ( bp_is_my_profile() && !$bp->is_single_item ) {

			$bp->bp_options_title = __( 'My Events', 'jet-event-system' );

		} else if ( !bp_is_my_profile() && !$bp->is_single_item ) {

			$bp->bp_options_avatar = bp_core_fetch_avatar( array( 'item_id' => $bp->displayed_user->id, 'type' => 'thumb' ) );
			$bp->bp_options_title = $bp->displayed_user->fullname;

		} else if ( $bp->is_single_item ) {
			// We are viewing a single event, so set up the
			// event navigation menu using the $bp->jes_events->current_event global.

			/* When in a single event, the first action is bumped down one because of the
			   event name, so we need to adjust this and set the event name to current_item. */
			$bp->current_item = $bp->current_action;
			$bp->current_action = $bp->action_variables[0];
			array_shift($bp->action_variables);

			$bp->bp_options_title = $bp->jes_events->current_event->name;

			if ( !$bp->bp_options_avatar = bp_core_fetch_avatar( array( 'item_id' => $bp->jes_events->current_event->id, 'object' => 'event', 'type' => 'thumb', 'avatar_dir' => 'event-avatars', 'alt' => __( 'Event Avatar', 'jet-event-system' ) ) ) )
				$bp->bp_options_avatar = '<img src="' . attribute_escape( $event->avatar_full ) . '" class="avatar" alt="' . attribute_escape( $event->name ) . '" />';

			$event_link = $bp->root_domain . '/' . $bp->jes_events->slug . '/' . $bp->jes_events->current_event->slug . '/';

			// If this is a private or hidden event, does the user have access?
			if ( 'private' == $bp->jes_events->current_event->status || 'hidden' == $bp->jes_events->current_event->status ) {
				if ( $bp->jes_events->current_event->is_user_member && is_user_logged_in() || is_site_admin() )
					$bp->jes_events->current_event->user_has_access = true;
				else
					$bp->jes_events->current_event->user_has_access = false;
			} else {
				$bp->jes_events->current_event->user_has_access = true;
			}

			/* Reset the existing subnav items */
			bp_core_reset_subnav_items($bp->jes_events->slug);

			/* Add a new default subnav item for when the events nav is selected. */
			bp_core_new_nav_default( array( 'parent_slug' => $bp->jes_events->slug, 'screen_function' => 'events_screen_event_home', 'subnav_slug' => 'home' ) );

			/* Add the "Home" subnav item, as this will always be present */
			bp_core_new_subnav_item( array( 'name' => __( 'Home', 'jet-event-system' ), 'slug' => 'home', 'parent_url' => $event_link, 'parent_slug' => $bp->jes_events->slug, 'screen_function' => 'events_screen_event_home', 'position' => 10, 'item_css_id' => 'home' ) );

			/* If the user is a event mod or more, then show the event admin nav item */
			if ( $bp->is_item_mod || $bp->is_item_admin )
				bp_core_new_subnav_item( array( 'name' => __( 'Admin', 'jet-event-system' ), 'slug' => 'admin', 'parent_url' => $event_link, 'parent_slug' => $bp->jes_events->slug, 'screen_function' => 'events_screen_event_admin', 'position' => 20, 'user_has_access' => ( $bp->is_item_admin + (int)$bp->is_item_mod ), 'item_css_id' => 'admin' ) );

			// If this is a private event, and the user is not a member, show a "Request Membership" nav item.
			if ( !is_site_admin() && is_user_logged_in() && !$bp->jes_events->current_event->is_user_member && !events_jes_check_for_membership_request( $bp->loggedin_user->id, $bp->jes_events->current_event->id ) && $bp->jes_events->current_event->status == 'private' )
				bp_core_new_subnav_item( array( 'name' => __( 'Request join to event', 'jet-event-system' ), 'slug' => 'request-join-to-event', 'parent_url' => $event_link, 'parent_slug' => $bp->jes_events->slug, 'screen_function' => 'events_screen_event_request_membership', 'position' => 30, 'item_css_id' => 'request-join-to-event'  ) );

		/*	if ( $bp->jes_events->current_event->enable_forum && function_exists('bp_forums_setup') )
				bp_core_new_subnav_item( array( 'name' => __( 'Forum', 'jet-event-system' ), 'slug' => 'forum', 'parent_url' => $event_link, 'parent_slug' => $bp->jes_events->slug, 'screen_function' => 'events_screen_event_forum', 'position' => 40, 'user_has_access' => $bp->jes_events->current_event->user_has_access, 'item_css_id' => 'forums' ) );
*/
			bp_core_new_subnav_item( array( 'name' => sprintf( __( 'Members (%s)', 'jet-event-system' ), number_format( $bp->jes_events->current_event->total_member_count ) ), 'slug' => 'members', 'parent_url' => $event_link, 'parent_slug' => $bp->jes_events->slug, 'screen_function' => 'events_screen_event_members', 'position' => 60, 'user_has_access' => $bp->jes_events->current_event->user_has_access, 'item_css_id' => 'members'  ) );

			if ( is_user_logged_in() && events_is_user_member( $bp->loggedin_user->id, $bp->jes_events->current_event->id ) ) {
				if ( function_exists('friends_install') )
					bp_core_new_subnav_item( array( 'name' => __( 'Send Invites', 'jet-event-system' ), 'slug' => 'send-invites', 'parent_url' => $event_link, 'parent_slug' => $bp->jes_events->slug, 'screen_function' => 'events_screen_jes_event_invite', 'item_css_id' => 'invite', 'position' => 70, 'user_has_access' => $bp->jes_events->current_event->user_has_access ) );
			}
		}
	}

	do_action( 'events_setup_nav', $bp->jes_events->current_event->user_has_access );
}
add_action( 'bp_setup_nav', 'events_setup_nav' );

function events_directory_events_setup() {
	global $bp;

	if ( $bp->current_component == $bp->jes_events->slug && empty( $bp->current_action ) && empty( $bp->current_item ) ) {
		$bp->is_directory = true;

		do_action( 'events_directory_events_setup' );
		bp_core_load_template( apply_filters( 'events_template_directory_events', 'events/index' ) );
	}
}
add_action( 'wp', 'events_directory_events_setup', 2 );

function events_setup_adminbar_menu() {
	global $bp;

	if ( !$bp->jes_events->current_event )
		return false;

	/* Don't show this menu to non site admins or if you're viewing your own profile */
	if ( !is_site_admin() )
		return false;
	?>
	<li id="bp-adminbar-adminoptions-menu">
		<a href=""><?php _e( 'Admin Options', 'jet-event-system' ) ?></a>

		<ul>
			<li><a class="confirm" href="<?php echo wp_nonce_url( jes_bp_get_event_permalink( $bp->jes_events->current_event ) . 'admin/delete-event/', 'events_delete_event' ) ?>&amp;delete-event-button=1&amp;delete-event-understand=1"><?php _e( "Delete Event", 'jet-event-system' ) ?></a></li>

			<?php do_action( 'events_adminbar_menu_items' ) ?>
		</ul>
	</li>
	<?php
}
add_action( 'bp_adminbar_menus', 'events_setup_adminbar_menu', 20 );


/********************************************************************************
 * Screen Functions
 *
 * Screen functions are the controllers of BuddyPress. They will execute when their
 * specific URL is caught. They will first save or manipulate data using business
 * functions, then pass on the user to a template file.
 */

function events_screen_my_events() {
	global $bp;

	if ( isset($_GET['n']) ) {
		// Delete event request notifications for the user
		bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->jes_events->id, 'membership_request_accepted' );
		bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->jes_events->id, 'membership_request_rejected' );
		bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->jes_events->id, 'member_promoted_to_mod' );
		bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->jes_events->id, 'member_promoted_to_admin' );
	}

	do_action( 'events_screen_my_events' );

	bp_core_load_template( apply_filters( 'events_template_my_events', 'members/single/home' ) );
}

function events_screen_jes_event_invite_jes() {
	global $bp;

	$event_id = $bp->action_variables[1];

	if ( isset($bp->action_variables) && in_array( 'accept', (array)$bp->action_variables ) && is_numeric($event_id) ) {
		/* Check the nonce */
		if ( !check_admin_referer( 'events_jes_accept_invite' ) )
			return false;

		if ( !events_jes_accept_invite( $bp->loggedin_user->id, $event_id ) ) {
			bp_core_add_message( __('Event invite could not be accepted', 'jet-event-system'), 'error' );
		} else {
			bp_core_add_message( __('Event invite accepted', 'jet-event-system') );

			/* Record this in activity streams */
			$event = new JES_Events_Event( $event_id );

			events_record_activity( array(
				'action' => apply_filters( 'events_activity_accepted_invite_action', sprintf( __( '%s joined the event %s', 'jet-event-system'), bp_core_get_userlink( $bp->loggedin_user->id ), '<a href="' . jes_bp_get_event_permalink( $event ) . '">' . attribute_escape( $event->name ) . '</a>' ), $bp->loggedin_user->id, &$event ),
				'type' => 'joined_event',
				'item_id' => $event->id
			) );
		}

		bp_core_redirect( $bp->loggedin_user->domain . $bp->current_component . '/' . $bp->current_action );

	} else if ( isset($bp->action_variables) && in_array( 'reject', (array)$bp->action_variables ) && is_numeric($event_id) ) {
		/* Check the nonce */
		if ( !check_admin_referer( 'events_reject_invite' ) )
			return false;

		if ( !events_reject_invite( $bp->loggedin_user->id, $event_id ) ) {
			bp_core_add_message( __('Event invite could not be rejected', 'jet-event-system'), 'error' );
		} else {
			bp_core_add_message( __('Event invite rejected', 'jet-event-system') );
		}

		bp_core_redirect( $bp->loggedin_user->domain . $bp->current_component . '/' . $bp->current_action );
	}

	// Remove notifications
	bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->jes_events->id, 'jes_event_invite' );

	do_action( 'events_screen_jes_event_invites', $event_id );

	bp_core_load_template( apply_filters( 'events_template_jes_event_invites', 'members/single/home' ) );
}

function events_screen_event_home() {
	global $bp;

	if ( $bp->is_single_item ) {
		if ( isset($_GET['n']) ) {
			// Delete event request notifications for the user
			bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->jes_events->id, 'membership_request_accepted' );
			bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->jes_events->id, 'membership_request_rejected' );
			bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->jes_events->id, 'member_promoted_to_mod' );
			bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->jes_events->id, 'member_promoted_to_admin' );
		}

		do_action( 'events_screen_event_home' );

		bp_core_load_template( apply_filters( 'events_template_event_home', 'events/single/home' ) );
	}
}


function events_screen_event_members() {
	global $bp;

	if ( $bp->is_single_item ) {
		/* Refresh the event member count meta */
		events_update_eventmeta( $bp->jes_events->current_event->id, 'total_member_count', events_jes_get_total_member_count( $bp->jes_events->current_event->id ) );

		do_action( 'events_screen_event_members', $bp->jes_events->current_event->id );
		bp_core_load_template( apply_filters( 'events_template_event_members', 'events/single/home' ) );
	}
}

function events_screen_jes_event_invite() {
	global $bp;

	if ( $bp->is_single_item ) {
		if ( isset($bp->action_variables) && 'send' == $bp->action_variables[0] ) {

			if ( !check_admin_referer( 'events_send_invites', '_wpnonce_send_invites' ) )
				return false;

			// Send the invites.
			events_send_invite_jes( $bp->loggedin_user->id, $bp->jes_events->current_event->id );

			bp_core_add_message( __('Event invites sent.', 'jet-event-system') );

			do_action( 'events_screen_jes_event_invite', $bp->jes_events->current_event->id );

			bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) );
		} else {
			// Show send invite page
			bp_core_load_template( apply_filters( 'events_template_jes_event_invite', 'events/single/home' ) );
		}
	}
}

function events_screen_event_request_membership() {
	global $bp;

	if ( !is_user_logged_in() )
		return false;

	if ( 'private' == $bp->jes_events->current_event->status ) {
		// If the user has submitted a request, send it.
		if ( isset( $_POST['event-request-send']) ) {
			/* Check the nonce first. */
			if ( !check_admin_referer( 'events_request_join_to_event' ) )
				return false;

			if ( !events_send_membership_request( $bp->loggedin_user->id, $bp->jes_events->current_event->id ) ) {
				bp_core_add_message( __( 'There was an error sending your join event request, please try again.', 'jet-event-system' ), 'error' );
			} else {
				bp_core_add_message( __( 'Your request to join was sent to the event administrator successfully. You will be notified when the event administrator responds to your request.', 'jet-event-system' ) );
			}
			bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) );
		}

		do_action( 'events_screen_event_request_membership', $bp->jes_events->current_event->id );

		bp_core_load_template( apply_filters( 'events_template_event_request_membership', 'events/single/home' ) );
	}
}

function events_screen_event_activity_permalink() {
	global $bp;

	if ( $bp->current_component != $bp->jes_events->slug || $bp->current_action != $bp->activity->slug || empty( $bp->action_variables[0] ) )
		return false;

	$bp->is_single_item = true;

	bp_core_load_template( apply_filters( 'events_template_event_home', 'events/single/home' ) );
}
add_action( 'wp', 'events_screen_event_activity_permalink', 3 );

function events_screen_event_admin() {
	global $bp;

	if ( $bp->current_component != JES_SLUG || 'admin' != $bp->current_action )
		return false;

	if ( !empty( $bp->action_variables[0] ) )
		return false;

	bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) . 'admin/edit-details/' );
}

function events_screen_event_admin_edit_details() {
	global $bp;

	if ( $bp->current_component == $bp->jes_events->slug && 'edit-details' == $bp->action_variables[0] ) {

		if ( $bp->is_item_admin || $bp->is_item_mod  ) {

			// If the edit form has been submitted, save the edited details
			if ( isset( $_POST['save'] ) ) {
				/* Check the nonce first. */
				if ( !check_admin_referer( 'events_edit_event_details' ) )
					return false;

				if ( !events_edit_base_event_details( $_POST['event-id'], $_POST['event-name'], $_POST['event-etype'], $_POST['event-desc'], $_POST['event-placedcity'], $_POST['event-placedaddress'], $_POST['event-newspublic'], $_POST['event-newsprivate'], $_POST['event-edtsd'], $_POST['event-edted'], (int)$_POST['event-notify-members'] ) ) {
					bp_core_add_message( __( 'There was an error updating event details, please try again.', 'jet-event-system' ), 'error' );
				} else {
					bp_core_add_message( __( 'Event details were successfully updated.', 'jet-event-system' ) );
				}

if ( datetounix($_POST['event-edtsd']) > datetounix($_POST['event-edted'])) {
					bp_core_add_message( __( 'There was an error updating event details (check date!), please try again.', 'jet-event-system' ), 'error' );
}				
				
				do_action( 'events_event_details_edited', $bp->jes_events->current_event->id );

				bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) . 'admin/edit-details/' );
			}

			do_action( 'events_screen_event_admin_edit_details', $bp->jes_events->current_event->id );

			bp_core_load_template( apply_filters( 'events_template_event_admin', 'events/single/home' ) );
		}
	}
}
add_action( 'wp', 'events_screen_event_admin_edit_details', 4 );

function events_screen_event_admin_settings() {
	global $bp;

	if ( $bp->current_component == $bp->jes_events->slug && 'event-settings' == $bp->action_variables[0] ) {

		if ( !$bp->is_item_admin )
			return false;

		// If the edit form has been submitted, save the edited details
		if ( isset( $_POST['save'] ) ) {
			$enable_forum = ( isset($_POST['event-show-forum'] ) ) ? 1 : 0;

			$allowed_status = apply_filters( 'events_allowed_status', array( 'public', 'private', 'hidden' ) );
			$status = ( in_array( $_POST['event-status'], (array)$allowed_status ) ) ? $_POST['event-status'] : 'public';

			/* Check the nonce first. */
			if ( !check_admin_referer( 'events_edit_event_settings' ) )
				return false;

			if ( !events_edit_event_settings( $_POST['event-id'], $enable_forum, $status ) ) {
				bp_core_add_message( __( 'There was an error updating event settings, please try again.', 'jet-event-system' ), 'error' );
			} else {
				bp_core_add_message( __( 'Event settings were successfully updated.', 'jet-event-system' ) );
			}

			do_action( 'events_event_settings_edited', $bp->jes_events->current_event->id );

			bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) . 'admin/event-settings/' );
		}

		do_action( 'events_screen_event_admin_settings', $bp->jes_events->current_event->id );

		bp_core_load_template( apply_filters( 'events_template_event_admin_settings', 'events/single/home' ) );
	}
}
add_action( 'wp', 'events_screen_event_admin_settings', 4 );

function events_screen_event_admin_avatar() {
	global $bp;

	if ( $bp->current_component == $bp->jes_events->slug && 'event-avatar' == $bp->action_variables[0] ) {

		if ( !$bp->is_item_admin )
			return false;

		/* If the event admin has deleted the admin avatar */
		if ( 'delete' == $bp->action_variables[1] ) {

			/* Check the nonce */
			check_admin_referer( 'jes_bp_event_avatar_delete' );

			if ( bp_core_delete_existing_avatar( array( 'item_id' => $bp->jes_events->current_event->id, 'object' => 'event' ) ) )
				bp_core_add_message( __( 'Your avatar was deleted successfully!', 'jet-event-system' ) );
			else
				bp_core_add_message( __( 'There was a problem deleting that avatar, please try again.', 'jet-event-system' ), 'error' );

		}

		$bp->avatar_admin->step = 'upload-image';

		if ( !empty( $_FILES ) ) {

			/* Check the nonce */
			check_admin_referer( 'bp_avatar_upload' );

			/* Pass the file to the avatar upload handler */
			if ( bp_core_avatar_handle_upload( $_FILES, 'events_avatar_upload_dir' ) ) {
				$bp->avatar_admin->step = 'crop-image';

				/* Make sure we include the jQuery jCrop file for image cropping */
				add_action( 'wp', 'bp_core_add_jquery_cropper' );
			}

		}

		/* If the image cropping is done, crop the image and save a full/thumb version */
		if ( isset( $_POST['avatar-crop-submit'] ) ) {

			/* Check the nonce */
			check_admin_referer( 'bp_avatar_cropstore' );

			if ( !bp_core_avatar_handle_crop( array( 'object' => 'event', 'avatar_dir' => 'event-avatars', 'item_id' => $bp->jes_events->current_event->id, 'original_file' => $_POST['image_src'], 'crop_x' => $_POST['x'], 'crop_y' => $_POST['y'], 'crop_w' => $_POST['w'], 'crop_h' => $_POST['h'] ) ) )
				bp_core_add_message( __( 'There was a problem cropping the avatar, please try uploading it again', 'jet-event-system' ) );
			else
				bp_core_add_message( __( 'The new event avatar was uploaded successfully!', 'jet-event-system' ) );

		}

		do_action( 'events_screen_event_admin_avatar', $bp->jes_events->current_event->id );

		bp_core_load_template( apply_filters( 'events_template_event_admin_avatar', 'events/single/home' ) );
	}
}
add_action( 'wp', 'events_screen_event_admin_avatar', 4 );

function events_screen_event_admin_manage_members() {
	global $bp;

	if ( $bp->current_component == $bp->jes_events->slug && 'manage-members' == $bp->action_variables[0] ) {

		if ( !$bp->is_item_admin )
			return false;

		if ( 'promote' == $bp->action_variables[1] && ( 'mod' == $bp->action_variables[2] || 'admin' == $bp->action_variables[2] ) && is_numeric( $bp->action_variables[3] ) ) {
			$user_id = $bp->action_variables[3];
			$status = $bp->action_variables[2];

			/* Check the nonce first. */
			if ( !check_admin_referer( 'events_promote_member' ) )
				return false;

			// Promote a user.
			if ( !events_promote_member( $user_id, $bp->jes_events->current_event->id, $status ) ) {
				bp_core_add_message( __( 'There was an error when promoting that user, please try again', 'jet-event-system' ), 'error' );
			} else {
				bp_core_add_message( __( 'User promoted successfully', 'jet-event-system' ) );
			}

			do_action( 'events_promoted_member', $user_id, $bp->jes_events->current_event->id );

			bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) . 'admin/manage-members/' );
		}

		if ( 'demote' == $bp->action_variables[1] && is_numeric( $bp->action_variables[2] ) ) {
			$user_id = $bp->action_variables[2];

			/* Check the nonce first. */
			if ( !check_admin_referer( 'events_demote_member' ) )
				return false;

			// Demote a user.
			if ( !events_demote_member( $user_id, $bp->jes_events->current_event->id ) ) {
				bp_core_add_message( __( 'There was an error when demoting that user, please try again', 'jet-event-system' ), 'error' );
			} else {
				bp_core_add_message( __( 'User demoted successfully', 'jet-event-system' ) );
			}

			do_action( 'events_demoted_member', $user_id, $bp->jes_events->current_event->id );

			bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) . 'admin/manage-members/' );
		}

		if ( 'ban' == $bp->action_variables[1] && is_numeric( $bp->action_variables[2] ) ) {
			$user_id = $bp->action_variables[2];

			/* Check the nonce first. */
			if ( !check_admin_referer( 'events_ban_member' ) )
				return false;

			// Ban a user.
			if ( !events_ban_member( $user_id, $bp->jes_events->current_event->id ) ) {
				bp_core_add_message( __( 'There was an error when banning that user, please try again', 'jet-event-system' ), 'error' );
			} else {
				bp_core_add_message( __( 'User banned successfully', 'jet-event-system' ) );
			}

			do_action( 'events_banned_member', $user_id, $bp->jes_events->current_event->id );

			bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) . 'admin/manage-members/' );
		}

		if ( 'unban' == $bp->action_variables[1] && is_numeric( $bp->action_variables[2] ) ) {
			$user_id = $bp->action_variables[2];

			/* Check the nonce first. */
			if ( !check_admin_referer( 'events_unban_member' ) )
				return false;

			// Remove a ban for user.
			if ( !events_unban_member( $user_id, $bp->jes_events->current_event->id ) ) {
				bp_core_add_message( __( 'There was an error when unbanning that user, please try again', 'jet-event-system' ), 'error' );
			} else {
				bp_core_add_message( __( 'User ban removed successfully', 'jet-event-system' ) );
			}

			do_action( 'events_unbanned_member', $user_id, $bp->jes_events->current_event->id );

			bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) . 'admin/manage-members/' );
		}

		do_action( 'events_screen_event_admin_manage_members', $bp->jes_events->current_event->id );

		bp_core_load_template( apply_filters( 'events_template_event_admin_manage_members', 'events/single/home' ) );
	}
}
add_action( 'wp', 'events_screen_event_admin_manage_members', 4 );

function events_screen_event_admin_requests() {
	global $bp;

	if ( $bp->current_component == $bp->jes_events->slug && 'membership-requests' == $bp->action_variables[0] ) {

		/* Ask for a login if the user is coming here via an email notification */
		if ( !is_user_logged_in() )
			bp_core_redirect( site_url( 'wp-login.php?redirect_to=' . $bp->root_domain . '/' . $bp->current_component . '/' . $bp->current_item . '/admin/membership-requests/' ) );

		if ( !$bp->is_item_admin || 'public' == $bp->jes_events->current_event->status )
			return false;

		// Remove any screen notifications
		bp_core_delete_notifications_for_user_by_type( $bp->loggedin_user->id, $bp->jes_events->id, 'new_membership_request' );

		$request_action = $bp->action_variables[1];
		$membership_id = $bp->action_variables[2];

		if ( isset($request_action) && isset($membership_id) ) {
			if ( 'accept' == $request_action && is_numeric($membership_id) ) {

				/* Check the nonce first. */
				if ( !check_admin_referer( 'events_accept_membership_request' ) )
					return false;

				// Accept the membership request
				if ( !events_accept_membership_request( $membership_id ) ) {
					bp_core_add_message( __( 'There was an error accepting the membership request, please try again.', 'jet-event-system' ), 'error' );
				} else {
					bp_core_add_message( __( 'Event membership request accepted', 'jet-event-system' ) );
				}

			} else if ( 'reject' == $request_action && is_numeric($membership_id) ) {
				/* Check the nonce first. */
				if ( !check_admin_referer( 'events_reject_membership_request' ) )
					return false;

				// Reject the membership request
				if ( !events_reject_membership_request( $membership_id ) ) {
					bp_core_add_message( __( 'There was an error rejecting the membership request, please try again.', 'jet-event-system' ), 'error' );
				} else {
					bp_core_add_message( __( 'Event membership request rejected', 'jet-event-system' ) );
				}

			}

			do_action( 'events_event_request_managed', $bp->jes_events->current_event->id, $request_action, $membership_id );

			bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) . 'admin/membership-requests/' );
		}

		do_action( 'events_screen_event_admin_requests', $bp->jes_events->current_event->id );

		bp_core_load_template( apply_filters( 'events_template_event_admin_requests', 'events/single/home' ) );
	}
}
add_action( 'wp', 'events_screen_event_admin_requests', 4 );

function events_screen_event_admin_delete_event() {
	global $bp;

	if ( $bp->current_component == $bp->jes_events->slug && 'delete-event' == $bp->action_variables[0] ) {

		if ( !$bp->is_item_admin && !is_site_admin() )
			return false;

		if ( isset( $_REQUEST['delete-event-button'] ) && isset( $_REQUEST['delete-event-understand'] ) ) {
			/* Check the nonce first. */
			if ( !check_admin_referer( 'events_delete_event' ) )
				return false;

			// Event admin has deleted the event, now do it.
			if ( !events_delete_event( $bp->jes_events->current_event->id ) ) {
				bp_core_add_message( __( 'There was an error deleting the event, please try again.', 'jet-event-system' ), 'error' );
			} else {
				bp_core_add_message( __( 'The event was deleted successfully', 'jet-event-system' ) );

				do_action( 'events_event_deleted', $bp->jes_events->current_event->id );

				bp_core_redirect( $bp->loggedin_user->domain . $bp->jes_events->slug . '/' );
			}

			bp_core_redirect( $bp->loggedin_user->domain . $bp->current_component );
		}

		do_action( 'events_screen_event_admin_delete_event', $bp->jes_events->current_event->id );

		bp_core_load_template( apply_filters( 'events_template_event_admin_delete_event', 'events/single/home' ) );
	}
}
add_action( 'wp', 'events_screen_event_admin_delete_event', 4 );

function events_screen_notification_settings() {
	global $current_user; ?>
	<table class="notification-settings zebra" id="events-notification-settings">
		<thead>
			<tr>
				<th class="icon"></th>
				<th class="title"><?php _e( 'Events', 'jet-event-system' ) ?></th>
				<th class="yes"><?php _e( 'Yes', 'jet-event-system' ) ?></th>
				<th class="no"><?php _e( 'No', 'jet-event-system' )?></th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td></td>
				<td><?php _e( 'A member invites you to join a event', 'jet-event-system' ) ?></td>
				<td class="yes"><input type="radio" name="notifications[notification_events_invite]" value="yes" <?php if ( !get_usermeta( $current_user->id, 'notification_events_invite') || 'yes' == get_usermeta( $current_user->id, 'notification_events_invite') ) { ?>checked="checked" <?php } ?>/></td>
				<td class="no"><input type="radio" name="notifications[notification_events_invite]" value="no" <?php if ( 'no' == get_usermeta( $current_user->id, 'notification_events_invite') ) { ?>checked="checked" <?php } ?>/></td>
			</tr>
			<tr>
				<td></td>
				<td><?php _e( 'Event information is updated', 'jet-event-system' ) ?></td>
				<td class="yes"><input type="radio" name="notifications[notification_events_event_updated]" value="yes" <?php if ( !get_usermeta( $current_user->id, 'notification_events_event_updated') || 'yes' == get_usermeta( $current_user->id, 'notification_events_event_updated') ) { ?>checked="checked" <?php } ?>/></td>
				<td class="no"><input type="radio" name="notifications[notification_events_event_updated]" value="no" <?php if ( 'no' == get_usermeta( $current_user->id, 'notification_events_event_updated') ) { ?>checked="checked" <?php } ?>/></td>
			</tr>
			<tr>
				<td></td>
				<td><?php _e( 'You are promoted to a event administrator or moderator', 'jet-event-system' ) ?></td>
				<td class="yes"><input type="radio" name="notifications[notification_events_admin_promotion]" value="yes" <?php if ( !get_usermeta( $current_user->id, 'notification_events_admin_promotion') || 'yes' == get_usermeta( $current_user->id, 'notification_events_admin_promotion') ) { ?>checked="checked" <?php } ?>/></td>
				<td class="no"><input type="radio" name="notifications[notification_events_admin_promotion]" value="no" <?php if ( 'no' == get_usermeta( $current_user->id, 'notification_events_admin_promotion') ) { ?>checked="checked" <?php } ?>/></td>
			</tr>
			<tr>
				<td></td>
				<td><?php _e( 'A member requests to join a private event for which you are an admin', 'jet-event-system' ) ?></td>
				<td class="yes"><input type="radio" name="notifications[notification_events_membership_request]" value="yes" <?php if ( !get_usermeta( $current_user->id, 'notification_events_membership_request') || 'yes' == get_usermeta( $current_user->id, 'notification_events_membership_request') ) { ?>checked="checked" <?php } ?>/></td>
				<td class="no"><input type="radio" name="notifications[notification_events_membership_request]" value="no" <?php if ( 'no' == get_usermeta( $current_user->id, 'notification_events_membership_request') ) { ?>checked="checked" <?php } ?>/></td>
			</tr>

			<?php do_action( 'events_screen_notification_settings' ); ?>
		</tbody>
	</table>
<?php
}
add_action( 'bp_notification_settings', 'events_screen_notification_settings' );


/********************************************************************************
 * Action Functions
 *
 * Action functions are exactly the same as screen functions, however they do not
 * have a template screen associated with them. Usually they will send the user
 * back to the default screen after execution.
 */

function events_action_create_event() {
	global $bp;

	/* If we're not at domain.org/events/create/ then return false */
	if ( $bp->current_component != $bp->jes_events->slug || 'create' != $bp->current_action )
		return false;

	if ( !is_user_logged_in() )
		return false;

	/* Make sure creation steps are in the right order */
	events_action_sort_creation_steps();

	/* If no current step is set, reset everything so we can start a fresh event creation */
	if ( !$bp->jes_events->current_create_step = $bp->action_variables[1] ) {

		unset( $bp->jes_events->current_create_step );
		unset( $bp->jes_events->completed_create_steps );

		setcookie( 'bp_new_event_id', false, time() - 1000, COOKIEPATH );
		setcookie( 'bp_completed_create_steps', false, time() - 1000, COOKIEPATH );

		$reset_steps = true;
		bp_core_redirect( $bp->root_domain . '/' . $bp->jes_events->slug . '/create/step/' . array_shift( array_keys( $bp->jes_events->event_creation_steps ) ) . '/' );
	}

	/* If this is a creation step that is not recognized, just redirect them back to the first screen */
	if ( $bp->action_variables[1] && !$bp->jes_events->event_creation_steps[$bp->action_variables[1]] ) {
		bp_core_add_message( __('There was an error saving event details. Please try again.', 'jet-event-system'), 'error' );
		bp_core_redirect( $bp->root_domain . '/' . $bp->jes_events->slug . '/create/' );
	}

	/* Fetch the currently completed steps variable */
	if ( isset( $_COOKIE['bp_completed_create_steps'] ) && !$reset_steps )
		$bp->jes_events->completed_create_steps = unserialize( stripslashes( $_COOKIE['bp_completed_create_steps'] ) );

	/* Set the ID of the new event, if it has already been created in a previous step */
	if ( isset( $_COOKIE['bp_new_event_id'] ) ) {
		$bp->jes_events->new_event_id = $_COOKIE['bp_new_event_id'];
		$bp->jes_events->current_event = new JES_Events_Event( $bp->jes_events->new_event_id );
	}

	/* If the save, upload or skip button is hit, lets calculate what we need to save */
	if ( isset( $_POST['save'] ) ) {

		/* Check the nonce */
		check_admin_referer( 'events_create_save_' . $bp->jes_events->current_create_step );

		if ( 'event-details' == $bp->jes_events->current_create_step ) {
			if ( empty( $_POST['event-name'] ) || empty( $_POST['event-desc'] ) || !strlen( trim( $_POST['event-name'] ) ) || !strlen( trim( $_POST['event-desc'] ) ) ) {
				bp_core_add_message( __( 'Please fill in all of the required fields', 'jet-event-system' ), 'error' );
				bp_core_redirect( $bp->root_domain . '/' . $bp->jes_events->slug . '/create/step/' . $bp->jes_events->current_create_step . '/' );
			}

			if ( !$bp->jes_events->new_event_id = events_create_event( array( 'event_id' => $bp->jes_events->new_event_id, 'name' => $_POST['event-name'], 'etype' => $_POST['event-etype'], 'description' => $_POST['event-desc'], 'eventterms' => $_POST['event-eventterms'], 'placedcity' => $_POST['event-placedcity'], 'placedaddress' => $_POST['event-placedaddress'], 'newspublic' => $_POST['event-newspublic'], 'newsprivate' => $_POST['event-newsprivate'], 'edtsd' => $_POST['event-edtsd'], 'edted' => $_POST['event-edted'], 'slug' => events_jes_check_slug( sanitize_title( esc_attr( $_POST['event-name'] ) ) ), 'date_created' => gmdate( "Y-m-d H:i:s" ), 'status' => 'public' ) ) ) {
				bp_core_add_message( __( 'There was an error saving event details, please try again.', 'jet-event-system' ), 'error' );
				bp_core_redirect( $bp->root_domain . '/' . $bp->jes_events->slug . '/create/step/' . $bp->jes_events->current_create_step . '/' );
			}

			events_update_eventmeta( $bp->jes_events->new_event_id, 'total_member_count', 1 );
			events_update_eventmeta( $bp->jes_events->new_event_id, 'last_activity', gmdate( "Y-m-d H:i:s" ) );
		}

		if ( 'event-settings' == $bp->jes_events->current_create_step ) {
			$event_status = 'public';
			$event_enable_forum = 1;

			if ( !isset($_POST['event-show-forum']) ) {
				$event_enable_forum = 0;
			} else {
			}

			if ( 'private' == $_POST['event-status'] )
				$event_status = 'private';
			else if ( 'hidden' == $_POST['event-status'] )
				$event_status = 'hidden';

			if ( !$bp->jes_events->new_event_id = events_create_event( array( 'event_id' => $bp->jes_events->new_event_id, 'status' => $event_status, 'enable_forum' => $event_enable_forum ) ) ) {
				bp_core_add_message( __( 'There was an error saving event details, please try again.', 'jet-event-system' ), 'error' );
				bp_core_redirect( $bp->root_domain . '/' . $bp->jes_events->slug . '/create/step/' . $bp->jes_events->current_create_step . '/' );
			}
		}

		if ( 'event-invites' == $bp->jes_events->current_create_step ) {
			events_send_invite_jes( $bp->loggedin_user->id, $bp->jes_events->new_event_id );
		}

		do_action( 'events_create_event_step_save_' . $bp->jes_events->current_create_step );
		do_action( 'events_create_event_step_complete' ); // Mostly for clearing cache on a generic action name

		/**
		 * Once we have successfully saved the details for this step of the creation process
		 * we need to add the current step to the array of completed steps, then update the cookies
		 * holding the information
		 */
		if ( !in_array( $bp->jes_events->current_create_step, (array)$bp->jes_events->completed_create_steps ) )
			$bp->jes_events->completed_create_steps[] = $bp->jes_events->current_create_step;

		/* Reset cookie info */
		setcookie( 'bp_new_event_id', $bp->jes_events->new_event_id, time()+60*60*24, COOKIEPATH );
		setcookie( 'bp_completed_create_steps', serialize( $bp->jes_events->completed_create_steps ), time()+60*60*24, COOKIEPATH );

		/* If we have completed all steps and hit done on the final step we can redirect to the completed event */
		if ( count( $bp->jes_events->completed_create_steps ) == count( $bp->jes_events->event_creation_steps ) && $bp->jes_events->current_create_step == array_pop( array_keys( $bp->jes_events->event_creation_steps ) ) ) {
			unset( $bp->jes_events->current_create_step );
			unset( $bp->jes_events->completed_create_steps );

			/* Once we compelete all steps, record the event creation in the activity stream. */
			events_record_activity( array(
				'action' => apply_filters( 'events_activity_created_event_action', sprintf( __( '%s created the event %s', 'jet-event-system'), bp_core_get_userlink( $bp->loggedin_user->id ), '<a href="' . jes_bp_get_event_permalink( $bp->jes_events->current_event ) . '">' . attribute_escape( $bp->jes_events->current_event->name ) . '</a>' ) ),
				'type' => 'created_event',
				'item_id' => $bp->jes_events->new_event_id
			) );

			do_action( 'events_event_create_complete', $bp->jes_events->new_event_id );

			bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) );
		} else {
			/**
			 * Since we don't know what the next step is going to be (any plugin can insert steps)
			 * we need to loop the step array and fetch the next step that way.
			 */
			foreach ( (array)$bp->jes_events->event_creation_steps as $key => $value ) {
				if ( $key == $bp->jes_events->current_create_step ) {
					$next = 1;
					continue;
				}

				if ( $next ) {
					$next_step = $key;
					break;
				}
			}

			bp_core_redirect( $bp->root_domain . '/' . $bp->jes_events->slug . '/create/step/' . $next_step . '/' );
		}
	}

	/* Event avatar is handled separately */
	if ( 'event-avatar' == $bp->jes_events->current_create_step && isset( $_POST['upload'] ) ) {
		if ( !empty( $_FILES ) && isset( $_POST['upload'] ) ) {
			/* Normally we would check a nonce here, but the event save nonce is used instead */

			/* Pass the file to the avatar upload handler */
			if ( bp_core_avatar_handle_upload( $_FILES, 'events_avatar_upload_dir' ) ) {
				$bp->avatar_admin->step = 'crop-image';

				/* Make sure we include the jQuery jCrop file for image cropping */
				add_action( 'wp', 'bp_core_add_jquery_cropper' );
			}
		}

		/* If the image cropping is done, crop the image and save a full/thumb version */
		if ( isset( $_POST['avatar-crop-submit'] ) && isset( $_POST['upload'] ) ) {
			/* Normally we would check a nonce here, but the event save nonce is used instead */

			if ( !bp_core_avatar_handle_crop( array( 'object' => 'event', 'avatar_dir' => 'event-avatars', 'item_id' => $bp->jes_events->current_event->id, 'original_file' => $_POST['image_src'], 'crop_x' => $_POST['x'], 'crop_y' => $_POST['y'], 'crop_w' => $_POST['w'], 'crop_h' => $_POST['h'] ) ) )
				bp_core_add_message( __( 'There was an error saving the event avatar, please try uploading again.', 'jet-event-system' ), 'error' );
			else
				bp_core_add_message( __( 'The event avatar was uploaded successfully!', 'jet-event-system' ) );
		}
	}

 	bp_core_load_template( apply_filters( 'events_template_create_event', 'events/create' ) );
}
add_action( 'wp', 'events_action_create_event', 3 );

function events_action_join_event() {
	global $bp;

	if ( !$bp->is_single_item || $bp->current_component != $bp->jes_events->slug || $bp->current_action != 'join' )
		return false;

	// Nonce check
	if ( !check_admin_referer( 'events_join_event' ) )
		return false;

	// Skip if banned or already a member
	if ( !events_is_user_member( $bp->loggedin_user->id, $bp->jes_events->current_event->id ) && !events_is_user_banned( $bp->loggedin_user->id, $bp->jes_events->current_event->id ) ) {

		// User wants to join a event that is not public
		if ( $bp->jes_events->current_event->status != 'public' ) {
			if ( !events_check_user_has_invite( $bp->loggedin_user->id, $bp->jes_events->current_event->id ) ) {
				bp_core_add_message( __( 'There was an error joining the event.', 'jet-event-system' ), 'error' );
				bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) );
			}
		}

		// User wants to join any event
		if ( !events_join_event( $bp->jes_events->current_event->id ) )
			bp_core_add_message( __( 'There was an error joining the event.', 'jet-event-system' ), 'error' );
		else
			bp_core_add_message( __( 'You joined the event!', 'jet-event-system' ) );

		bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) );
	}

	bp_core_load_template( apply_filters( 'events_template_event_home', 'events/single/home' ) );
}
add_action( 'wp', 'events_action_join_event', 3 );


function events_action_leave_event() {
	global $bp;

	if ( !$bp->is_single_item || $bp->current_component != $bp->jes_events->slug || $bp->current_action != 'leave-event' )
		return false;

	// Nonce check
	if ( !check_admin_referer( 'events_leave_event' ) )
		return false;

	// User wants to leave any event
	if ( events_is_user_member( $bp->loggedin_user->id, $bp->jes_events->current_event->id ) ) {
		if ( !events_leave_event( $bp->jes_events->current_event->id ) ) {
			bp_core_add_message( __( 'There was an error leaving the event.', 'jet-event-system' ), 'error' );
		} else {
			bp_core_add_message( __( 'You successfully left the event.', 'jet-event-system' ) );
		}
		bp_core_redirect( jes_bp_get_event_permalink( $bp->jes_events->current_event ) );
	}

	bp_core_load_template( apply_filters( 'events_template_event_home', 'events/single/home' ) );
}
add_action( 'wp', 'events_action_leave_event', 3 );


function events_action_sort_creation_steps() {
	global $bp;

	if ( $bp->current_component != JES_SLUG && $bp->current_action != 'create' )
		return false;

	if ( !is_array( $bp->jes_events->event_creation_steps ) )
		return false;

	foreach ( (array)$bp->jes_events->event_creation_steps as $slug => $step ) {
		while ( !empty( $temp[$step['position']] ) )
			$step['position']++;

		$temp[$step['position']] = array( 'name' => $step['name'], 'slug' => $slug );
	}

	/* Sort the steps by their position key */
	ksort($temp);
	unset($bp->jes_events->event_creation_steps);

	foreach( (array)$temp as $position => $step )
		$bp->jes_events->event_creation_steps[$step['slug']] = array( 'name' => $step['name'], 'position' => $position );
}

function events_action_redirect_to_random_event() {
	global $bp, $wpdb;

	if ( $bp->current_component == $bp->jes_events->slug && isset( $_GET['random-event'] ) ) {
		$event = events_get_events( array( 'type' => 'random', 'per_page' => 1 ) );

		bp_core_redirect( $bp->root_domain . '/' . $bp->jes_events->slug . '/' . $event['events'][0]->slug . '/' );
	}
}
add_action( 'wp', 'events_action_redirect_to_random_event', 6 );

function events_action_event_feed() {
	global $bp, $wp_query;

	if ( !bp_is_active( 'activity' ) || $bp->current_component != $bp->jes_events->slug || !$bp->jes_events->current_event || $bp->current_action != 'feed' )
		return false;

	$wp_query->is_404 = false;
	status_header( 200 );

	if ( 'public' != $bp->jes_events->current_event->status ) {
		if ( !events_is_user_member( $bp->loggedin_user->id, $bp->jes_events->current_event->id ) )
			return false;
	}

	include_once( 'bp-activity/feeds/bp-activity-event-feed.php' );
	die;
}
add_action( 'wp', 'events_action_event_feed', 3 );


/********************************************************************************
 * Activity & Notification Functions
 *
 * These functions handle the recording, deleting and formatting of activity and
 * notifications for the user and for this specific component.
 */

function events_register_activity_actions() {
	global $bp;

	if ( !function_exists( 'bp_activity_set_action' ) )
		return false;

	bp_activity_set_action( $bp->jes_events->id, 'created_event', __( 'Created a event', 'jet-event-system' ) );
	bp_activity_set_action( $bp->jes_events->id, 'joined_event', __( 'Joined a event', 'jet-event-system' ) );
	bp_activity_set_action( $bp->jes_events->id, 'new_forum_topic', __( 'New event forum topic', 'jet-event-system' ) );
	bp_activity_set_action( $bp->jes_events->id, 'new_forum_post', __( 'New event forum post', 'jet-event-system' ) );

	do_action( 'events_register_activity_actions' );
}
add_action( 'bp_register_activity_actions', 'events_register_activity_actions' );

function events_record_activity( $args = '' ) {
	global $bp;

	if ( !function_exists( 'bp_activity_add' ) )
		return false;

	/* If the event is not public, hide the activity sitewide. */
	if ( 'public' == $bp->jes_events->current_event->status )
		$hide_sitewide = false;
	else
		$hide_sitewide = true;

	$defaults = array(
		'id' => false,
		'user_id' => $bp->loggedin_user->id,
		'action' => '',
		'content' => '',
		'primary_link' => '',
		'component' => $bp->jes_events->id,
		'type' => false,
		'item_id' => false,
		'secondary_item_id' => false,
		'recorded_time' => gmdate( "Y-m-d H:i:s" ),
		'hide_sitewide' => $hide_sitewide
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r );

	return bp_activity_add( array( 'id' => $id, 'user_id' => $user_id, 'action' => $action, 'content' => $content, 'primary_link' => $primary_link, 'component' => $component, 'type' => $type, 'item_id' => $item_id, 'secondary_item_id' => $secondary_item_id, 'recorded_time' => $recorded_time, 'hide_sitewide' => $hide_sitewide ) );
}

function events_update_last_activity( $event_id ) {
	events_update_eventmeta( $event_id, 'last_activity', gmdate( "Y-m-d H:i:s" ) );
}
add_action( 'events_joined_event', 'events_update_last_activity' );
add_action( 'events_leave_event', 'events_update_last_activity' );
add_action( 'events_created_event', 'events_update_last_activity' );


function events_format_notifications( $action, $item_id, $secondary_item_id, $total_items ) {
	global $bp;

	switch ( $action ) {
		case 'new_membership_request':
			$event_id = $secondary_item_id;
			$requesting_user_id = $item_id;

			$event = new JES_Events_Event( $event_id );

			$event_link = jes_bp_get_event_permalink( $event );

			if ( (int)$total_items > 1 ) {
				return apply_filters( 'jes_bp_events_multiple_new_membership_requests_notification', '<a href="' . $event_link . '/admin/membership-requests/?n=1" title="' . __( 'Event Membership Requests', 'jet-event-system' ) . '">' . sprintf( __( '%d new membership requests for the event "%s"', 'jet-event-system' ), (int)$total_items, $event->name ) . '</a>', $event_link, $total_items, $event->name );
			} else {
				$user_fullname = bp_core_get_user_displayname( $requesting_user_id );
				return apply_filters( 'jes_bp_events_single_new_membership_request_notification', '<a href="' . $event_link . 'admin/membership-requests/?n=1" title="' . $user_fullname .' requests event membership">' . sprintf( __( '%s requests membership for the event "%s"', 'jet-event-system' ), $user_fullname, $event->name ) . '</a>', $event_link, $user_fullname, $event->name );
			}
		break;

		case 'membership_request_accepted':
			$event_id = $item_id;

			$event = new JES_Events_Event( $event_id );
			$event_link = jes_bp_get_event_permalink( $event );

			if ( (int)$total_items > 1 )
				return apply_filters( 'jes_bp_events_multiple_membership_request_accepted_notification', '<a href="' . $bp->loggedin_user->domain . $bp->jes_events->slug . '/?n=1" title="' . __( 'Events', 'jet-event-system' ) . '">' . sprintf( __( '%d accepted event membership requests', 'jet-event-system' ), (int)$total_items, $event->name ) . '</a>', $total_items, $event_name );
			else
				return apply_filters( 'jes_bp_events_single_membership_request_accepted_notification', '<a href="' . $event_link . '?n=1">' . sprintf( __( 'Membership for event "%s" accepted', 'jet-event-system' ), $event->name ) . '</a>', $event_link, $event->name );

		break;

		case 'membership_request_rejected':
			$event_id = $item_id;

			$event = new JES_Events_Event( $event_id );
			$event_link = jes_bp_get_event_permalink( $event );

			if ( (int)$total_items > 1 )
				return apply_filters( 'jes_bp_events_multiple_membership_request_rejected_notification', '<a href="' . site_url() . '/' . BP_MEMBERS_SLUG . '/' . $bp->jes_events->slug . '/?n=1" title="' . __( 'Events', 'jet-event-system' ) . '">' . sprintf( __( '%d rejected event membership requests', 'jet-event-system' ), (int)$total_items, $event->name ) . '</a>', $total_items, $event->name );
			else
				return apply_filters( 'jes_bp_events_single_membership_request_rejected_notification', '<a href="' . $event_link . '?n=1">' . sprintf( __( 'Membership for event "%s" rejected', 'jet-event-system' ), $event->name ) . '</a>', $event_link, $event->name );

		break;

		case 'member_promoted_to_admin':
			$event_id = $item_id;

			$event = new JES_Events_Event( $event_id );
			$event_link = jes_bp_get_event_permalink( $event );

			if ( (int)$total_items > 1 )
				return apply_filters( 'jes_bp_events_multiple_member_promoted_to_admin_notification', '<a href="' . $bp->loggedin_user->domain . $bp->jes_events->slug . '/?n=1" title="' . __( 'Events', 'jet-event-system' ) . '">' . sprintf( __( 'You were promoted to an admin in %d events', 'jet-event-system' ), (int)$total_items ) . '</a>', $total_items );
			else
				return apply_filters( 'jes_bp_events_single_member_promoted_to_admin_notification', '<a href="' . $event_link . '?n=1">' . sprintf( __( 'You were promoted to an admin in the event %s', 'jet-event-system' ), $event->name ) . '</a>', $event_link, $event->name );

		break;

		case 'member_promoted_to_mod':
			$event_id = $item_id;

			$event = new JES_Events_Event( $event_id );
			$event_link = jes_bp_get_event_permalink( $event );

			if ( (int)$total_items > 1 )
				return apply_filters( 'jes_bp_events_multiple_member_promoted_to_mod_notification', '<a href="' . $bp->loggedin_user->domain . $bp->jes_events->slug . '/?n=1" title="' . __( 'Events', 'jet-event-system' ) . '">' . sprintf( __( 'You were promoted to a mod in %d events', 'jet-event-system' ), (int)$total_items ) . '</a>', $total_items );
			else
				return apply_filters( 'jes_bp_events_single_member_promoted_to_mod_notification', '<a href="' . $event_link . '?n=1">' . sprintf( __( 'You were promoted to a mod in the event %s', 'jet-event-system' ), $event->name ) . '</a>', $event_link, $event->name );

		break;

		case 'jes_event_invite':
			$event_id = $item_id;

			$event = new JES_Events_Event( $event_id );
			$user_url = bp_core_get_user_domain( $user_id );

			if ( (int)$total_items > 1 )
				return apply_filters( 'jes_bp_events_multiple_jes_event_invite_notification', '<a href="' . $bp->loggedin_user->domain . $bp->jes_events->slug . '/invites/?n=1" title="' . __( 'Event Invites', 'jet-event-system' ) . '">' . sprintf( __( 'You have %d new event invitations', 'jet-event-system' ), (int)$total_items ) . '</a>', $total_items );
			else
				return apply_filters( 'jes_bp_events_single_jes_event_invite_notification', '<a href="' . $bp->loggedin_user->domain . $bp->jes_events->slug . '/invites/?n=1" title="' . __( 'Event Invites', 'jet-event-system' ) . '">' . sprintf( __( 'You have an invitation to the event: %s', 'jet-event-system' ), $event->name ) . '</a>', $event->name );

		break;
	}

	do_action( 'events_format_notifications', $action, $item_id, $secondary_item_id, $total_items );

	return false;
}


/********************************************************************************
 * Business Functions
 *
 * Business functions are where all the magic happens in BuddyPress. They will
 * handle the actual saving or manipulation of information. Usually they will
 * hand off to a database class for data access, then return
 * true or false on success or failure.
 */

function events_get_event( $args = '' ) {
	$defaults = array(
		'event_id' => false,
		'load_users' => false
	);

	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	return apply_filters( 'events_get_event', new JES_Events_Event( $event_id, true, $load_users ) );
}

/*** Event Creation, Editing & Deletion *****************************************/

function events_create_event( $args = '' ) {
	global $bp;

	extract( $args );

	/**
	 * Possible parameters (pass as assoc array):
	 *	'event_id'
	 *	'creator_id'
	 *	'name'
	 *	'description'
	 *	'slug'
	 *	'status'
	 *	'enable_forum'
	 *	'date_created'
	 */

	if ( $event_id )
		$event = new JES_Events_Event( $event_id );
	else
		$event = new JES_Events_Event;

	if ( $creator_id )
		$event->creator_id = $creator_id;
	else
		$event->creator_id = $bp->loggedin_user->id;

	if ( isset( $name ) )
		$event->name = $name;

	if ( isset( $etype ) )
		$event->etype = $etype;		
		
	if ( isset( $description ) )
		$event->description = $description;

	if ( isset( $eventterms ) )
		$event->eventterms = $eventterms;
		
	if ( isset( $placedcity ) )
		$event->placedcity = $placedcity;

	if ( isset( $placedaddress ) )
		$event->placedaddress = $placedaddress;
		
	if ( isset( $newspublic ) )
		$event->newspublic = $newspublic;

	if ( isset( $newsprivate ) )
		$event->newsprivate = $newsprivate;
		
	if ( isset( $edtsd ) )
		$event->edtsd = $edtsd;
		
	if ( isset( $edted ) )
		$event->edted = $edted;
	
	if ( isset( $slug ) && events_jes_check_slug( $slug ) )
		$event->slug = $slug;

	if ( isset( $status ) ) {
		if ( events_is_valid_status( $status ) )
			$event->status = $status;
	}

	if ( isset( $enable_forum ) )
		$event->enable_forum = $enable_forum;
	else if ( !$event_id && !isset( $enable_forum ) )
		$event->enable_forum = 1;

	if ( isset( $date_created ) )
		$event->date_created = $date_created;

	if ( !$event->save() )
		return false;

	if ( !$event_id ) {
		/* If this is a new event, set up the creator as the first member and admin */
		$member = new JES_Events_Member;
		$member->event_id = $event->id;
		$member->user_id = $event->creator_id;
		$member->is_admin = 1;
		$member->user_title = __( 'Event Admin', 'jet-event-system' );
		$member->is_confirmed = 1;
		$member->date_modified = gmdate( "Y-m-d H:i:s" );

		$member->save();
	}

	do_action( 'events_created_event', $event->id );

	return $event->id;
}

function events_edit_base_event_details( $event_id, $event_name, $event_etype, $event_desc, $event_placedcity, $event_placedaddress, $event_newspublic, $event_newsprivate, $event_edtsd, $event_edted, $notify_members ) {
	global $bp;

	if ( empty( $event_name ) || empty( $event_desc ) || empty ( $event_placedcity) || empty ( $event_etype) || empty ( $event_edtsd) || empty ( $event_edted))
		return false;

	$event = new JES_Events_Event( $event_id );
	$event->name = $event_name;
	$event->etype = $event_etype;
	$event->description = $event_desc;
	$event->eventerms = $event_eventterms;	
	$event->placedcity = $event_placedcity;
	$event->placedaddress = $event_placedaddress;
	$event->newspublic = $event_newspublic;
	$event->newsprivate = $event_newsprivate;
	$event->edtsd = $event_edtsd;
	$event->edted = $event_edted;

	if ( !$event->save() )
		return false;

	if ( $notify_members ) {
		require_once ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-notifications.php' );
		events_notification_event_updated( $event->id );
	}

	do_action( 'events_details_updated', $event->id );

	return true;
}

function events_edit_event_settings( $event_id, $enable_forum, $status ) {
	global $bp;

	$event = new JES_Events_Event( $event_id );
	$event->enable_forum = $enable_forum;

	/***
	 * Before we potentially switch the event status, if it has been changed to public
	 * from private and there are outstanding membership requests, auto-accept those requests.
	 */
	if ( 'private' == $event->status && 'public' == $status )
		events_accept_all_pending_membership_requests( $event->id );

	/* Now update the status */
	$event->status = $status;

	if ( !$event->save() )
		return false;

	events_update_eventmeta( $event->id, 'last_activity', gmdate( "Y-m-d H:i:s" ) );
	do_action( 'events_settings_updated', $event->id );

	return true;
}

function events_delete_event( $event_id ) {
	global $bp;

	// Check the user is the event admin.
	if ( !$bp->is_item_admin )
		return false;

	// Get the event object
	$event = new JES_Events_Event( $event_id );

	if ( !$event->delete() )
		return false;

	/* Delete all event activity from activity streams */
	if ( function_exists( 'bp_activity_delete_by_item_id' ) ) {
		bp_activity_delete_by_item_id( array( 'item_id' => $event_id, 'component' => $bp->jes_events->id ) );
	}

	// Remove all outstanding invites for this event
	events_jes_delete_all_jes_event_invite_jes( $event_id );

	// Remove all notifications for any user belonging to this event
	bp_core_delete_all_notifications_by_type( $event_id, $bp->jes_events->slug );

	do_action( 'events_delete_event', $event_id );

	return true;
}

function events_is_valid_status( $status ) {
	global $bp;

	return in_array( $status, (array)$bp->jes_events->valid_status );
}

function events_jes_check_slug( $slug ) {
	global $bp;

	if ( 'wp' == substr( $slug, 0, 2 ) )
		$slug = substr( $slug, 2, strlen( $slug ) - 2 );

	if ( in_array( $slug, (array)$bp->jes_events->forbidden_names ) ) {
		$slug = $slug . '-' . rand();
	}

	if ( JES_Events_Event::jes_check_slug( $slug ) ) {
		do {
			$slug = $slug . '-' . rand();
		}
		while ( JES_Events_Event::jes_check_slug( $slug ) );
	}

	return $slug;
}

function events_jes_get_slug( $event_id ) {
	$event = new JES_Events_Event( $event_id );
	return $event->slug;
}

/*** User Actions ***************************************************************/

function events_leave_event( $event_id, $user_id = false ) {
	global $bp;

	if ( !$user_id )
		$user_id = $bp->loggedin_user->id;

	/* Don't let single admins leave the event. */
	if ( count( events_get_event_admins( $event_id ) ) < 2 ) {
		if ( events_is_user_admin( $user_id, $event_id ) ) {
			bp_core_add_message( __( 'As the only Admin, you cannot leave the event.', 'jet-event-system' ), 'error' );
			return false;
		}
	}

	$membership = new JES_Events_Member( $user_id, $event_id );

	// This is exactly the same as deleting an invite, just is_confirmed = 1 NOT 0.
	if ( !events_uninvite_user( $user_id, $event_id ) )
		return false;

	/* Modify event member count */
	events_update_eventmeta( $event_id, 'total_member_count', (int) events_get_eventmeta( $event_id, 'total_member_count') - 1 );

	/* Modify user's event memberhip count */
	update_usermeta( $user_id, 'jes_total_event_count', (int) get_usermeta( $user_id, 'jes_total_event_count') - 1 );

	/* If the user joined this event less than five minutes ago, remove the joined_event activity so
	 * users cannot flood the activity stream by joining/leaving the event in quick succession.
	 */
	if ( function_exists( 'bp_activity_delete' ) && gmmktime() <= strtotime( '+5 minutes', (int)strtotime( $membership->date_modified ) ) )
		bp_activity_delete( array( 'component' => $bp->jes_events->id, 'type' => 'joined_event', 'user_id' => $user_id, 'item_id' => $event_id ) );

	bp_core_add_message( __( 'You successfully left the event.', 'jet-event-system' ) );

	do_action( 'events_leave_event', $event_id, $user_id );

	return true;
}

function events_join_event( $event_id, $user_id = false ) {
	global $bp;

	if ( !$user_id )
		$user_id = $bp->loggedin_user->id;

	/* Check if the user has an outstanding invite, is so delete it. */
	if ( events_check_user_has_invite( $user_id, $event_id ) )
		events_jes_delete_invite( $user_id, $event_id );

	/* Check if the user has an outstanding request, is so delete it. */
	if ( events_jes_check_for_membership_request( $user_id, $event_id ) )
		events_delete_membership_request( $user_id, $event_id );

	/* User is already a member, just return true */
	if ( events_is_user_member( $user_id, $event_id ) )
		return true;

	if ( !$bp->jes_events->current_event )
		$bp->jes_events->current_event = new JES_Events_Event( $event_id );

	$new_member = new JES_Events_Member;
	$new_member->event_id = $event_id;
	$new_member->user_id = $user_id;
	$new_member->inviter_id = 0;
	$new_member->is_admin = 0;
	$new_member->user_title = '';
	$new_member->date_modified = gmdate( "Y-m-d H:i:s" );
	$new_member->is_confirmed = 1;

	if ( !$new_member->save() )
		return false;

	/* Record this in activity streams */
	events_record_activity( array(
		'action' => apply_filters( 'events_activity_joined_event', sprintf( __( '%s joined the event %s', 'jet-event-system'), bp_core_get_userlink( $user_id ), '<a href="' . jes_bp_get_event_permalink( $bp->jes_events->current_event ) . '">' . attribute_escape( $bp->jes_events->current_event->name ) . '</a>' ) ),
		'type' => 'joined_event',
		'item_id' => $event_id
	) );

	/* Modify event meta */
	events_update_eventmeta( $event_id, 'total_member_count', (int) events_get_eventmeta( $event_id, 'total_member_count') + 1 );
	events_update_eventmeta( $event_id, 'last_activity', gmdate( "Y-m-d H:i:s" ) );

	do_action( 'events_join_event', $event_id, $user_id );

	return true;
}

/*** General Event Functions ****************************************************/

function events_check_jes_event_exists( $event_id ) {
	return JES_Events_Event::jes_event_exists( $event_id );
}

function events_get_event_admins( $event_id ) {
	return JES_Events_Member::jes_get_event_administrator_ids( $event_id );
}

function events_get_event_mods( $event_id ) {
	return JES_Events_Member::get_event_moderator_ids( $event_id );
}

function events_get_event_members( $event_id, $limit = false, $page = false ) {
	return JES_Events_Member::jes_get_all_for_event( $event_id, $limit, $page );
}

function events_jes_get_total_member_count( $event_id ) {
	return JES_Events_Event::jes_get_total_member_count( $event_id );
}

/*** Event Fetching, Filtering & Searching  *************************************/

function events_get_events( $args = '' ) {
	global $bp;

	$defaults = array(
		'type' => 'soon', // active, newest, alphabetical, random, popular, most-forum-topics or most-forum-posts
		'user_id' => false, // Pass a user_id to limit to only events that this user is a member of
		'search_terms' => false, // Limit to events that match these search terms

		'per_page' => 10, // The number of results to return per page
		'page' => 1, // The page to return if limiting per page
		'populate_extras' => true, // Fetch meta such as is_banned and is_member
	);

	$params = wp_parse_args( $args, $defaults );
	extract( $params, EXTR_SKIP );

	switch ( $type ) {
		case 'active': default:
			$events = JES_Events_Event::jes_get_active( $per_page, $page, $user_id, $search_terms, $populate_extras );
			break;
		case 'newest':
			$events = JES_Events_Event::jes_get_newest( $per_page, $page, $user_id, $search_terms, $populate_extras );
			break;
		case 'popular':
			$events = JES_Events_Event::jes_get_popular( $per_page, $page, $user_id, $search_terms, $populate_extras );
			break;
		case 'alphabetical':
			$events = JES_Events_Event::jes_get_alphabetically( $per_page, $page, $user_id, $search_terms, $populate_extras );
			break;
		case 'random':
			$events = JES_Events_Event::jes_get_random( $per_page, $page, $user_id, $search_terms, $populate_extras );
			break;
		case 'most-forum-topics':
			$events = JES_Events_Event::jet_get_by_most_forum_topics( $per_page, $page, $user_id, $search_terms, $populate_extras );
			break;
		case 'most-forum-posts':
			$events = JES_Events_Event::jet_get_by_most_forum_posts( $per_page, $page, $user_id, $search_terms, $populate_extras );
			break;
		case 'soon':
			$events = JES_Events_Event::jes_get_soon( $per_page, $page, $user_id, $search_terms, $populate_extras );
			break;			
	}
	
	return apply_filters( 'events_get_events', $events, &$params );
}

function events_jes_get_jes_total_event_count() {
	if ( !$count = wp_cache_get( 'bp_jes_total_event_count', 'bp' ) ) {
		$count = JES_Events_Event::jes_get_jes_total_event_count();
		wp_cache_set( 'bp_jes_total_event_count', $count, 'bp' );
	}

	return $count;
}

function events_get_user_events( $user_id = false, $pag_num = false, $pag_page = false ) {
	global $bp;

	if ( !$user_id )
		$user_id = $bp->displayed_user->id;

	return JES_Events_Member::jes_get_event_ids( $user_id, $pag_num, $pag_page );
}

function events_total_events_for_user( $user_id = false ) {
	global $bp;

	if ( !$user_id )
		$user_id = ( $bp->displayed_user->id ) ? $bp->displayed_user->id : $bp->loggedin_user->id;

	if ( !$count = wp_cache_get( 'bp_total_events_for_user_' . $user_id, 'bp' ) ) {
		$count = JES_Events_Member::jes_total_event_count( $user_id );
		wp_cache_set( 'bp_total_events_for_user_' . $user_id, $count, 'bp' );
	}

	return $count;
}

/*** Event Avatars *************************************************************/

function events_avatar_upload_dir( $event_id = false ) {
	global $bp;

	if ( !$event_id )
		$event_id = $bp->jes_events->current_event->id;

	$path = BP_AVATAR_UPLOAD_PATH . '/event-avatars/' . $event_id;
	$newbdir = $path;

	if ( !file_exists( $path ) )
		@wp_mkdir_p( $path );

	$newurl = BP_AVATAR_URL . '/event-avatars/' . $event_id;
	$newburl = $newurl;
	$newsubdir = '/event-avatars/' . $event_id;

	return apply_filters( 'events_avatar_upload_dir', array( 'path' => $path, 'url' => $newurl, 'subdir' => $newsubdir, 'basedir' => $newbdir, 'baseurl' => $newburl, 'error' => false ) );
}

/*** Event Member Status Checks ************************************************/

function events_is_user_admin( $user_id, $event_id ) {
	return JES_Events_Member::jes_check_is_admin( $user_id, $event_id );
}

function events_is_user_mod( $user_id, $event_id ) {
	return JES_Events_Member::jes_check_is_mod( $user_id, $event_id );
}

function events_is_user_member( $user_id, $event_id ) {
	return JES_Events_Member::jes_check_is_member( $user_id, $event_id );
}

function events_is_user_banned( $user_id, $event_id ) {
	return JES_Events_Member::jes_check_is_banned( $user_id, $event_id );
}

/*** Event Activity Posting **************************************************/

function events_post_update( $args = '' ) {
	global $bp;

	$defaults = array(
		'content' => false,
		'user_id' => $bp->loggedin_user->id,
		'event_id' => $bp->jes_events->current_event->id
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	if ( empty($content) || !strlen( trim( $content ) ) || empty($user_id) || empty($event_id) )
		return false;

	$bp->jes_events->current_event = new JES_Events_Event( $event_id );

	/* Be sure the user is a member of the event before posting. */
	if ( !is_site_admin() && !events_is_user_member( $user_id, $event_id ) )
		return false;

	/* Record this in activity streams */
	$activity_action = sprintf( __( '%s posted an update in the event %s:', 'jet-event-system'), bp_core_get_userlink( $user_id ), '<a href="' . jes_bp_get_event_permalink( $bp->jes_events->current_event ) . '">' . attribute_escape( $bp->jes_events->current_event->name ) . '</a>' );
	$activity_content = $content;

	$activity_id = events_record_activity( array(
		'user_id' => $user_id,
		'action' => apply_filters( 'events_activity_new_update_action', $activity_action ),
		'content' => apply_filters( 'events_activity_new_update_content', $activity_content ),
		'type' => 'activity_update',
		'item_id' => $event_id
	) );

 	/* Require the notifications code so email notifications can be set on the 'bp_activity_posted_update' action. */
	require_once( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-notifications.php' );

	events_update_eventmeta( $event_id, 'last_activity', gmdate( "Y-m-d H:i:s" ) );
	do_action( 'jes_bp_events_posted_update', $content, $user_id, $event_id, $activity_id );

	return $activity_id;
}

/*** Event Invitations *********************************************************/

function events_jes_get_invites_for_user( $user_id = false, $limit = false, $page = false ) {
	global $bp;

	if ( !$user_id )
		$user_id = $bp->loggedin_user->id;

	return JES_Events_Member::jes_get_invite_jes( $user_id, $limit, $page );
}

function events_invite_user( $args = '' ) {
	global $bp;

	$defaults = array(
		'user_id' => false,
		'event_id' => false,
		'inviter_id' => $bp->loggedin_user->id,
		'date_modified' => gmdate( "Y-m-d H:i:s" ),
		'is_confirmed' => 0
	);

	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	if ( !$user_id || !$event_id )
		return false;

	if ( !events_is_user_member( $user_id, $event_id ) && !events_check_user_has_invite( $user_id, $event_id ) ) {
		$invite = new JES_Events_Member;
		$invite->event_id = $event_id;
		$invite->user_id = $user_id;
		$invite->date_modified = $date_modified;
		$invite->inviter_id = $inviter_id;
		$invite->is_confirmed = $is_confirmed;

		if ( !$invite->save() )
			return false;

		do_action( 'events_invite_user', $args );
	}

	return true;
}

function events_uninvite_user( $user_id, $event_id ) {
	global $bp;

	if ( !JES_Events_Member::delete( $user_id, $event_id ) )
		return false;

	do_action( 'events_uninvite_user', $event_id, $user_id );

	return true;
}

function events_jes_accept_invite( $user_id, $event_id ) {
	global $bp;

	if ( events_is_user_member( $user_id, $event_id ) )
		return false;

	$member = new JES_Events_Member( $user_id, $event_id );
	$member->jes_accept_invite();

	if ( !$member->save() )
		return false;

	/* Remove request to join */
	if ( $member->jes_check_for_membership_request( $user_id, $event_id ) )
		$member->jes_delete_request( $user_id, $event_id );

	/* Modify event meta */
	events_update_eventmeta( $event_id, 'total_member_count', (int) events_get_eventmeta( $event_id, 'total_member_count') + 1 );
	events_update_eventmeta( $event_id, 'last_activity', gmdate( "Y-m-d H:i:s" ) );

	bp_core_delete_notifications_for_user_by_item_id( $user_id, $event_id, $bp->jes_events->id, 'jes_event_invite' );

	do_action( 'events_jes_accept_invite', $user_id, $event_id );
	return true;
}

function events_reject_invite( $user_id, $event_id ) {
	if ( !JES_Events_Member::delete( $user_id, $event_id ) )
		return false;

	do_action( 'events_reject_invite', $user_id, $event_id );

	return true;
}

function events_jes_delete_invite( $user_id, $event_id ) {
	global $bp;

	$delete = JES_Events_Member::jes_delete_invite( $user_id, $event_id );

	if ( $delete )
		bp_core_delete_notifications_for_user_by_item_id( $user_id, $event_id, $bp->jes_events->id, 'jes_event_invite' );

	return $delete;
}

function events_send_invite_jes( $user_id, $event_id ) {
	global $bp;

	require_once ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-notifications.php' );

	if ( !$user_id )
		$user_id = $bp->loggedin_user->id;

	// Send friend invites.
	$invited_users = events_jes_get_invites_for_event( $user_id, $event_id );
	$event = new JES_Events_Event( $event_id );

	for ( $i = 0; $i < count( $invited_users ); $i++ ) {
		$member = new JES_Events_Member( $invited_users[$i], $event_id );

		// Send the actual invite
		events_notification_jes_event_invite_jes( $event, $member, $user_id );

		$member->invite_sent = 1;
		$member->save();
	}

	do_action( 'events_send_invites', $bp->jes_events->current_event->id, $invited_users );
}

function events_jes_get_invites_for_event( $user_id, $event_id ) {
	return JES_Events_Event::jes_get_invite_jes( $user_id, $event_id );
}

function events_check_user_has_invite( $user_id, $event_id ) {
	return JES_Events_Member::jes_check_has_invite( $user_id, $event_id );
}

function events_jes_delete_all_jes_event_invite_jes( $event_id ) {
	return JES_Events_Event::jes_jes_delete_all_invite_jes( $event_id );
}

/*** Event Promotion & Banning *************************************************/

function events_promote_member( $user_id, $event_id, $status ) {
	global $bp;

	if ( !$bp->is_item_admin )
		return false;

	$member = new JES_Events_Member( $user_id, $event_id );

	do_action( 'events_premote_member', $event_id, $user_id, $status );

	return $member->promote( $status );
}

function events_demote_member( $user_id, $event_id ) {
	global $bp;

	$member = new JES_Events_Member( $user_id, $event_id );

	do_action( 'events_demote_member', $event_id, $user_id );

	return $member->demote();
}

function events_ban_member( $user_id, $event_id ) {
	global $bp;

	if ( !$bp->is_item_admin )
		return false;

	$member = new JES_Events_Member( $user_id, $event_id );

	do_action( 'events_ban_member', $event_id, $user_id );

	if ( !$member->ban() )
		return false;

	update_usermeta( $user_id, 'jes_total_event_count', (int)$total_count - 1 );
}

function events_unban_member( $user_id, $event_id ) {
	global $bp;

	if ( !$bp->is_item_admin )
		return false;

	$member = new JES_Events_Member( $user_id, $event_id );

	do_action( 'events_unban_member', $event_id, $user_id );

	return $member->unban();
}

/*** Event Membership ****************************************************/

function events_send_membership_request( $requesting_user_id, $event_id ) {
	global $bp;

	/* Prevent duplicate requests */
	if ( events_jes_check_for_membership_request( $requesting_user_id, $event_id ) )
		return false;

	/* Check if the user is already a member or is banned */
	if ( events_is_user_member( $requesting_user_id, $event_id ) || events_is_user_banned( $requesting_user_id, $event_id ) )
		return false;

	$requesting_user = new JES_Events_Member;
	$requesting_user->event_id = $event_id;
	$requesting_user->user_id = $requesting_user_id;
	$requesting_user->inviter_id = 0;
	$requesting_user->is_admin = 0;
	$requesting_user->user_title = '';
	$requesting_user->date_modified = gmdate( "Y-m-d H:i:s" );
	$requesting_user->is_confirmed = 0;
	$requesting_user->comments = $_POST['event-request-join-to-event-comments'];

	if ( $requesting_user->save() ) {
		$admins = events_get_event_admins( $event_id );

		require_once ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-notifications.php' );

		for ( $i = 0; $i < count( $admins ); $i++ ) {
			// Saved okay, now send the email notification
			events_notification_new_membership_request( $requesting_user_id, $admins[$i]->user_id, $event_id, $requesting_user->id );
		}

		do_action( 'events_membership_requested', $requesting_user_id, $admins, $event_id, $requesting_user->id );

		return true;
	}

	return false;
}

function events_accept_membership_request( $membership_id, $user_id = false, $event_id = false ) {
	global $bp;

	if ( $user_id && $event_id )
		$membership = new JES_Events_Member( $user_id, $event_id );
	else
		$membership = new JES_Events_Member( false, false, $membership_id );

	$membership->jes_accept_request();

	if ( !$membership->save() )
		return false;

	/* Check if the user has an outstanding invite, if so delete it. */
	if ( events_check_user_has_invite( $membership->user_id, $membership->event_id ) )
		events_jes_delete_invite( $membership->user_id, $membership->event_id );

	/* Modify event member count */
	events_update_eventmeta( $membership->event_id, 'total_member_count', (int) events_get_eventmeta( $membership->event_id, 'total_member_count') + 1 );

	/* Record this in activity streams */
	$event = new JES_Events_Event( $membership->event_id );

	events_record_activity( array(
		'action'	=> apply_filters( 'events_activity_membership_accepted_action', sprintf( __( '%s joined the event %s', 'jet-event-system'), bp_core_get_userlink( $membership->user_id ), '<a href="' . jes_bp_get_event_permalink( $event ) . '">' . attribute_escape( $event->name ) . '</a>' ), $membership->user_id, &$event ),
		'type'		=> 'joined_event',
		'item_id'	=> $membership->event_id,
		'user_id'	=> $membership->user_id
	) );

	/* Send a notification to the user. */
	require_once ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-notifications.php' );
	events_notification_membership_request_completed( $membership->user_id, $membership->event_id, true );

	do_action( 'events_membership_accepted', $membership->user_id, $membership->event_id );

	return true;
}

function events_reject_membership_request( $membership_id, $user_id = false, $event_id = false ) {
	if ( !$membership = events_delete_membership_request( $membership_id, $user_id, $event_id ) )
		return false;

	// Send a notification to the user.
	require_once ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-notifications.php' );
	events_notification_membership_request_completed( $membership->user_id, $membership->event_id, false );

	do_action( 'events_membership_rejected', $membership->user_id, $membership->event_id );

	return true;
}

function events_delete_membership_request( $membership_id, $user_id = false, $event_id = false ) {
	if ( $user_id && $event_id )
		$membership = new JES_Events_Member( $user_id, $event_id );
	else
		$membership = new JES_Events_Member( false, false, $membership_id );

	if ( !JES_Events_Member::delete( $membership->user_id, $membership->event_id ) )
		return false;

	return $membership;
}

function events_jes_check_for_membership_request( $user_id, $event_id ) {
	return JES_Events_Member::jes_check_for_membership_request( $user_id, $event_id );
}

function events_accept_all_pending_membership_requests( $event_id ) {
	$user_ids = JES_Events_Member::jes_get_all_membership_request_user_ids( $event_id );

	if ( !$user_ids )
		return false;

	foreach ( (array) $user_ids as $user_id ) {
		events_accept_membership_request( false, $user_id, $event_id );
	}

	do_action( 'events_accept_all_pending_membership_requests', $event_id );

	return true;
}

/*** Event Meta ****************************************************/

function events_delete_eventmeta( $event_id, $meta_key = false, $meta_value = false ) {
	global $wpdb, $bp;

	if ( !is_numeric( $event_id ) )
		return false;

	$meta_key = preg_replace('|[^a-z0-9_]|i', '', $meta_key);

	if ( is_array($meta_value) || is_object($meta_value) )
		$meta_value = serialize($meta_value);

	$meta_value = trim( $meta_value );

	if ( !$meta_key ) {
		$wpdb->query( $wpdb->prepare( "DELETE FROM " . $bp->jes_events->table_name_eventmeta . " WHERE event_id = %d", $event_id ) );
	} else if ( $meta_value ) {
		$wpdb->query( $wpdb->prepare( "DELETE FROM " . $bp->jes_events->table_name_eventmeta . " WHERE event_id = %d AND meta_key = %s AND meta_value = %s", $event_id, $meta_key, $meta_value ) );
	} else {
		$wpdb->query( $wpdb->prepare( "DELETE FROM " . $bp->jes_events->table_name_eventmeta . " WHERE event_id = %d AND meta_key = %s", $event_id, $meta_key ) );
	}

	/* Delete the cached object */
	wp_cache_delete( 'jes_events_eventmeta_' . $event_id . '_' . $meta_key, 'bp' );

	return true;
}

function events_get_eventmeta( $event_id, $meta_key = '') {
	global $wpdb, $bp;

	$event_id = (int) $event_id;

	if ( !$event_id )
		return false;

	if ( !empty($meta_key) ) {
		$meta_key = preg_replace('|[^a-z0-9_]|i', '', $meta_key);

		if ( !$metas = wp_cache_get( 'jes_events_eventmeta_' . $event_id . '_' . $meta_key, 'bp' ) ) {
			$metas = $wpdb->get_col( $wpdb->prepare("SELECT meta_value FROM " . $bp->jes_events->table_name_eventmeta . " WHERE event_id = %d AND meta_key = %s", $event_id, $meta_key) );
			wp_cache_set( 'jes_events_eventmeta_' . $event_id . '_' . $meta_key, $metas, 'bp' );
		}
	} else {
		$metas = $wpdb->get_col( $wpdb->prepare("SELECT meta_value FROM " . $bp->jes_events->table_name_eventmeta . " WHERE event_id = %d", $event_id) );
	}

	if ( empty($metas) ) {
		if ( empty($meta_key) )
			return array();
		else
			return '';
	}

	$metas = array_map('maybe_unserialize', (array)$metas);

	if ( 1 == count($metas) )
		return $metas[0];
	else
		return $metas;
}

function events_update_eventmeta( $event_id, $meta_key, $meta_value ) {
	global $wpdb, $bp;

	if ( !is_numeric( $event_id ) )
		return false;

	$meta_key = preg_replace( '|[^a-z0-9_]|i', '', $meta_key );

	if ( is_string($meta_value) )
		$meta_value = stripslashes($wpdb->escape($meta_value));

	$meta_value = maybe_serialize($meta_value);

	if (empty($meta_value)) {
		return events_delete_eventmeta( $event_id, $meta_key );
	}

	$cur = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM " . $bp->jes_events->table_name_eventmeta . " WHERE event_id = %d AND meta_key = %s", $event_id, $meta_key ) );

	if ( !$cur ) {
		$wpdb->query( $wpdb->prepare( "INSERT INTO " . $bp->jes_events->table_name_eventmeta . " ( event_id, meta_key, meta_value ) VALUES ( %d, %s, %s )", $event_id, $meta_key, $meta_value ) );
	} else if ( $cur->meta_value != $meta_value ) {
		$wpdb->query( $wpdb->prepare( "UPDATE " . $bp->jes_events->table_name_eventmeta . " SET meta_value = %s WHERE event_id = %d AND meta_key = %s", $meta_value, $event_id, $meta_key ) );
	} else {
		return false;
	}

	/* Update the cached object and recache */
	wp_cache_set( 'jes_events_eventmeta_' . $event_id . '_' . $meta_key, $meta_value, 'bp' );

	return true;
}

/*** Event Cleanup Functions ****************************************************/

function jes_events_remove_data_for_user( $user_id ) {
	JES_Events_Member::jes_delete_all_for_user($user_id);

	do_action( 'jes_events_remove_data_for_user', $user_id );
}
// add_action( 'wpmu_delete_user', 'jes_events_remove_data_for_user' );
// add_action( 'delete_user', 'jes_events_remove_data_for_user' );
// add_action( 'make_spam_user', 'jes_events_remove_data_for_user' );


/********************************************************************************
 * Caching
 *
 * Caching functions handle the clearing of cached objects and pages on specific
 * actions throughout BuddyPress.
 */

function events_clear_event_object_cache( $event_id ) {
	wp_cache_delete( 'events_event_nouserdata_' . $event_id, 'bp' );
	wp_cache_delete( 'events_event_' . $event_id, 'bp' );
	wp_cache_delete( 'newest_events', 'bp' );
	wp_cache_delete( 'soon_events', 'bp' );
	wp_cache_delete( 'active_events', 'bp' );
	wp_cache_delete( 'popular_events', 'bp' );
	wp_cache_delete( 'events_random_events', 'bp' );
	wp_cache_delete( 'bp_jes_total_event_count', 'bp' );
}
add_action( 'events_event_deleted', 'events_clear_event_object_cache' );
add_action( 'events_settings_updated', 'events_clear_event_object_cache' );
add_action( 'events_details_updated', 'events_clear_event_object_cache' );
add_action( 'events_event_avatar_updated', 'events_clear_event_object_cache' );
add_action( 'events_create_event_step_complete', 'events_clear_event_object_cache' );

function datetounix($inputdate) {
	$ev_day = substr($inputdate,0,2);
	$ev_month = substr($inputdate,3,2);
	$ev_year = substr($inputdate,6,4);

	$ev_h = substr($inputdate,11,2);
	$ev_m = substr($inputdate,14,2);

	$ev_dres = mktime ($ev_h,$ev_m,0,$ev_month,$ev_day,$ev_year);
return $ev_dres;
}

function events_clear_event_user_object_cache( $event_id, $user_id ) {
	wp_cache_delete( 'bp_total_events_for_user_' . $user_id );
}
add_action( 'events_join_event', 'events_clear_event_user_object_cache', 10, 2 );
add_action( 'events_leave_event', 'events_clear_event_user_object_cache', 10, 2 );
add_action( 'events_ban_member', 'events_clear_event_user_object_cache', 10, 2 );
add_action( 'events_unban_member', 'events_clear_event_user_object_cache', 10, 2 );

/* List actions to clear super cached pages on, if super cache is installed */
add_action( 'events_join_event', 'bp_core_clear_cache' );
add_action( 'events_leave_event', 'bp_core_clear_cache' );
add_action( 'events_jes_accept_invite', 'bp_core_clear_cache' );
add_action( 'events_reject_invite', 'bp_core_clear_cache' );
add_action( 'events_invite_user', 'bp_core_clear_cache' );
add_action( 'events_uninvite_user', 'bp_core_clear_cache' );
add_action( 'events_details_updated', 'bp_core_clear_cache' );
add_action( 'events_settings_updated', 'bp_core_clear_cache' );
add_action( 'events_unban_member', 'bp_core_clear_cache' );
add_action( 'events_ban_member', 'bp_core_clear_cache' );
add_action( 'events_demote_member', 'bp_core_clear_cache' );
add_action( 'events_premote_member', 'bp_core_clear_cache' );
add_action( 'events_membership_rejected', 'bp_core_clear_cache' );
add_action( 'events_membership_accepted', 'bp_core_clear_cache' );
add_action( 'events_membership_requested', 'bp_core_clear_cache' );
add_action( 'events_create_event_step_complete', 'bp_core_clear_cache' );
add_action( 'events_created_event', 'bp_core_clear_cache' );
add_action( 'events_event_avatar_updated', 'bp_core_clear_cache' );

?>