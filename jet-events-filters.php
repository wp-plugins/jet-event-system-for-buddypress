<?php

/* Apply WordPress defined filters */
add_filter( 'bp_get_event_description', 'wptexturize' );
add_filter( 'bp_get_event_eventterms', 'wptexturize' );
add_filter( 'bp_get_event_description_excerpt', 'wptexturize' );
add_filter( 'bp_get_event_name', 'wptexturize' );

add_filter( 'bp_get_event_description', 'convert_smilies' );
add_filter( 'bp_get_event_eventterms', 'convert_smilies' );
add_filter( 'bp_get_event_description_excerpt', 'convert_smilies' );

add_filter( 'bp_get_event_description', 'convert_chars' );
add_filter( 'bp_get_event_eventterms', 'convert_chars' );
add_filter( 'bp_get_event_description_excerpt', 'convert_chars' );
add_filter( 'bp_get_event_name', 'convert_chars' );

add_filter( 'bp_get_event_description', 'wpautop' );
add_filter( 'bp_get_event_eventterms', 'wpautop' );
add_filter( 'bp_get_event_description_excerpt', 'wpautop' );

add_filter( 'bp_get_event_description', 'make_clickable' );
add_filter( 'bp_get_event_description_excerpt', 'make_clickable' );

add_filter( 'bp_get_event_name', 'wp_filter_kses', 1 );
add_filter( 'bp_get_event_permalink', 'wp_filter_kses', 1 );
add_filter( 'bp_get_event_description', 'bp_events_filter_kses', 1 );
add_filter( 'bp_get_event_description_excerpt', 'wp_filter_kses', 1 );
add_filter( 'events_event_name_before_save', 'wp_filter_kses', 1 );
add_filter( 'events_event_description_before_save', 'wp_filter_kses', 1 );

add_filter( 'bp_get_event_description', 'stripslashes' );
add_filter( 'bp_get_event_description_excerpt', 'stripslashes' );
add_filter( 'bp_get_event_name', 'stripslashes' );
add_filter( 'bp_get_event_member_name', 'stripslashes' );
add_filter( 'bp_get_event_member_link', 'stripslashes' );

add_filter( 'events_new_event_forum_desc', 'bp_create_excerpt' );

add_filter( 'events_event_name_before_save', 'force_balance_tags' );
add_filter( 'events_event_description_before_save', 'force_balance_tags' );

add_filter( 'bp_get_total_event_count', 'bp_core_number_format' );
add_filter( 'bp_get_event_total_for_member', 'bp_core_number_format' );
add_filter( 'bp_get_event_total_members', 'bp_core_number_format' );

function bp_events_filter_kses( $content ) {
	global $allowedtags;

	$events_allowedtags = $allowedtags;
	$events_allowedtags['a']['class'] = array();
	$events_allowedtags['img'] = array();
	$events_allowedtags['img']['src'] = array();
	$events_allowedtags['img']['alt'] = array();
	$events_allowedtags['img']['class'] = array();
	$events_allowedtags['img']['width'] = array();
	$events_allowedtags['img']['height'] = array();
	$events_allowedtags['img']['class'] = array();
	$events_allowedtags['img']['id'] = array();
	$events_allowedtags['code'] = array();

	$events_allowedtags = apply_filters( 'bp_events_filter_kses', $events_allowedtags );
	return wp_kses( $content, $events_allowedtags );
}

/**** Filters for event forums ****/

function events_add_forum_privacy_sql() {
	global $bp;

	/* Only filter the forum SQL on event pages or on the forums directory */
	if ( ( $bp->events->current_event && 'public' == $bp->events->current_event->status ) || !$bp->events->current_event ) {
		add_filter( 'get_topics_fields', 'events_add_forum_fields_sql' );
		add_filter( 'get_topics_index_hint', 'events_add_forum_tables_sql' );
		add_filter( 'get_topics_where', 'events_add_forum_where_sql' );
	}
}
add_filter( 'bbpress_init', 'events_add_forum_privacy_sql' );

function events_add_forum_fields_sql( $sql ) {
	return $sql . ', g.id as object_id, g.name as object_name, g.slug as object_slug';
}

function events_add_forum_tables_sql( $sql ) {
	global $bp;
	return ', ' . $bp->events->table_name . ' AS g LEFT JOIN ' . $bp->events->table_name_eventmeta . ' AS gm ON g.id = gm.event_id ';
}

function events_add_forum_where_sql( $sql ) {
	global $bp;

	$bp->events->filter_sql = ' AND ' . $sql;
	return "(gm.meta_key = 'forum_id' AND gm.meta_value = t.forum_id) AND g.status = 'public' AND " . $sql;
}

function events_filter_bbpress_caps( $value, $cap, $args ) {
	global $bp;

	if ( is_site_admin() )
		return true;

	if ( 'add_tag_to' == $cap )
		if ( $bp->events->current_event->user_has_access ) return true;

	if ( 'manage_forums' == $cap && is_user_logged_in() )
		return true;

	return $value;
}
add_filter( 'bb_current_user_can', 'events_filter_bbpress_caps', 10, 3 );

?>