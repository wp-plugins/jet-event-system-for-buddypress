<?php
/*
Plugin Name: Jet Event System for BuddyPress
Plugin URI: http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html
Description: The modern System of events for your social network. Ability to attract members of the network to the ongoing activities, a wide range of possibilities and options, support for different types of display, etc. <a href="http://jes.milordk.ru">JES DEV Site</a>. <strong>Before you install or upgrade sure to read the Readme file!</strong>
Version: 1.6.2
Author: Jettochkin
Author URI: http://milordk.ru/
Site Wide Only: true
Network: true
*/

define ('Jet Events System', '1.6');
define ('JES_EVENTS_VERSION', '1.6' );
define ('JES_EVENTS_BUILD', '5' );
define ('JES_EVENTS_DB_VERSION', 17 );
define ('JES_EVENTS_THEME_VERSION', 23 );
define ('JES_EVENTS_RELEASE', '2010-10-07');

/* Define the slug for the component */
if ( !defined( 'JES_SLUG' ) ) {
$jes_adata = get_option( 'jes_events' );
if (!$jes_adata[ 'jes_events_costumslug_enable' ])
	{
		define ( 'JES_SLUG', 'events' );
	}
		else
	{
		define ( 'JES_SLUG', $jes_adata[ 'jes_events_costumslug' ] );	
	}
}

include ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/main/jet-event-start.php' );

register_activation_hook( __FILE__, 'jes_activation' );
register_deactivation_hook( __FILE__, 'jes_deactivation' );

function jes_activation() {
/* Update DB and Templates */

/* DB */
	if ( get_site_option( 'jes-events-db-version' ) < JES_EVENTS_DB_VERSION )
		{
			jes_events_init_jesdb();
		} 
/* Template */
	if ( get_site_option( 'jes-theme-version' ) < JES_EVENTS_THEME_VERSION )
		{
			update_template(null,'no');
		}
}

function jes_deactivation() {
// delete_option( 'jes_events' ); 
}

/* LOAD LANGUAGES */
function jet_event_system_load_textdomain() {
	$locale = apply_filters( 'wordpress_locale', get_locale() );
	$mofile = dirname( __File__ ) . "/lang/jet-event-system-$locale.mo";

	if ( file_exists( $mofile ) )
		load_textdomain( 'jet-event-system', $mofile );
}
add_action ( 'plugins_loaded', 'jet_event_system_load_textdomain', 7 );
?>