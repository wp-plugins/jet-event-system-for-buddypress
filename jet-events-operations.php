<?php
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

	if ( isset( $eventapproved ) )
		$event->eventapproved = $eventapproved;	
		
	if ( isset( $description ) )
		$event->description = $description;

	if ( isset( $eventterms ) )
		$event->eventterms = $eventterms;

	if ( isset( $placedcountry ) )
		$event->placedcountry = $placedcountry;

	if ( isset( $placedstate ) )
		$event->placedstate = $placedstate;
		
	if ( isset( $placedcity ) )
		$event->placedcity = $placedcity;
		
	if ( isset( $placedcity ) )
		$event->placedcity = $placedcity;

	if ( isset( $placedaddress ) )
		$event->placedaddress = $placedaddress;

	if ( isset( $placednote ) )
		$event->placednote = $placednote;

	if ( isset( $placedgooglemap ) )
		$event->placedgooglemap = $placedgooglemap;

	if ( isset( $flyer ) )
		$event->flyer = $flyer;
		
	if ( isset( $newspublic ) )
		$event->newspublic = $newspublic;

	if ( isset( $newsprivate ) )
		$event->newsprivate = $newsprivate;
		
	if ( isset( $edtsd ) )
		$event->edtsd = $edtsd;
		
	if ( isset( $edted ) )
		$event->edted = $edted;

	if ( isset( $edtsth ) )
		$event->edtsth = $edtsth;
		
	if ( isset( $edteth ) )
		$event->edteth = $edteth;

	if ( isset( $edtstm ) )
		$event->edtstm = $edtstm;
		
	if ( isset( $edtetm ) )
		$event->edtetm = $edtetm;
		
	if ( isset( $grouplink ) )
		$event->grouplink = $grouplink;

	if ( isset( $forumlink ) )
		$event->forumlink = $forumlink;		
		
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

function events_edit_base_event_details( $event_id, $event_name, $event_etype, $event_eventapproved, $event_desc, $event_eventterms, $event_placedcountry, $event_placedstate, $event_placedcity, $event_placedaddress, $event_placednote, $event_placedgooglemap, $event_flyer, $event_newspublic, $event_newsprivate, $event_edtsd, $event_edted, $event_edtsth, $event_edteth, $event_edtstm, $event_edtetm, $notify_members ) {
	global $bp;
	if ( empty( $event_name ) || empty( $event_desc ) || empty ( $event_placedcity) || empty ( $event_etype) || empty ( $event_edtsd) || empty ( $event_edted))
		return false;
	$event = new JES_Events_Event( $event_id );
	$event->name = $event_name;
	$event->etype = $event_etype;
	$event->eventapproved = $event_eventapproved;
	$event->description = $event_desc;
	$event->eventterms = $event_eventterms;	
	$event->placedcountry = $event_placedcountry;
	$event->placedstate = $event_placedstate;	
	$event->placedcity = $event_placedcity;
	$event->placedaddress = $event_placedaddress;
	$event->placednote = $event_placednote;
	$event->placedgooglemap = $event_placedgooglemap;
	$event->flyer = $event_flyer;
	$event->newspublic = $event_newspublic;
	$event->newsprivate = $event_newsprivate;
	$event->edtsd = $event_edtsd;
	$event->edted = $event_edted;
	$event->edtsth = $event_edtsth;
	$event->edteth = $event_edteth;	
	$event->edtstm = $event_edtstm;
	$event->edtetm = $event_edtetm;
	
	if ( !$event->save() )
		return false;

	if ( $notify_members ) {
		require_once ( WP_PLUGIN_DIR . '/jet-event-system-for-buddypress/jet-events-notifications.php' );
		events_notification_event_updated( $event->id );
	}

	do_action( 'events_details_updated', $event->id );

	return true;
}

function events_edit_event_settings( $event_id, $enable_forum, $glink, $flink, $status ) {
	global $bp;

	$event = new JES_Events_Event( $event_id );
	$event->enable_forum = $enable_forum;
	$event->grouplink = $glink;
	$event->forumlink = $flink;

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



?>