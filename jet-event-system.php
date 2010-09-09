<?php
/*
Plugin Name: Jet Event System for BuddyPress
Plugin URI: http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html
Description: The modern System of events for your social network. Ability to attract members of the network to the ongoing activities, a wide range of possibilities and options, support for different types of display, etc. <a href="http://jes.milordk.ru">JES DEV Site</a>. <strong>Before you install or upgrade sure to read the Readme file!</strong>
Version: 1.4.2.1
Author: Jettochkin
Author URI: http://milordk.ru/
Site Wide Only: true
Network: true
*/

define ('Jet Events System', '1.4');
define ('JES_EVENTS_VERSION', '1.4' );
define ('JES_EVENTS_BUILD', '2' );
define ('JES_EVENTS_DB_VERSION', 13 );
define ('JES_EVENTS_THEME_VERSION', 18 );
define ('JES_EVENTS_RELEASE', '2010-09-09');

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
include ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/main/jet-event-start.php' );
?>