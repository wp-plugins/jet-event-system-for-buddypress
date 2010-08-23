// AJAX Functions
var jq = jQuery;

// Global variable to prevent multiple AJAX requests
var bp_ajax_request = null;

jq(document).ready( function() {
	/** Invite Friends Interface ****************************************/

	/* Select a user from the list of friends and add them to the invite list */
	jq("div#event-invite-list input").click( function() {
		jq('.ajax-loader').toggle();

		var friend_id = jq(this).val();

		if ( jq(this).attr('checked') == true )
			var friend_action = 'invite';
		else
			var friend_action = 'uninvite';

		jq('div.item-list-tabs li.selected').addClass('loading');

		jq.post( ajaxurl, {
			action: 'events_invite_user',
			'friend_action': friend_action,
			'cookie': encodeURIComponent(document.cookie),
			'_wpnonce': jq("input#_wpnonce_invite_uninvite_user").val(),
			'friend_id': friend_id,
			'event_id': jq("input#event_id").val()
		},
		function(response)
		{
			if ( jq("#message") )
				jq("#message").hide();

			jq('.ajax-loader').toggle();

			if ( friend_action == 'invite' ) {
				jq('#event-friend-list').append(response);
			} else if ( friend_action == 'uninvite' ) {
				jq('#event-friend-list li#uid-' + friend_id).remove();
			}

			jq('div.item-list-tabs li.selected').removeClass('loading');
		});
	});

	/* Remove a user from the list of users to invite to a event */
	jq("#event-friend-list li a.remove").live('click', function() {
		jq('.ajax-loader').toggle();

		var friend_id = jq(this).attr('id');
		friend_id = friend_id.split('-');
		friend_id = friend_id[1];

		jq.post( ajaxurl, {
			action: 'events_invite_user',
			'friend_action': 'uninvite',
			'cookie': encodeURIComponent(document.cookie),
			'_wpnonce': jq("input#_wpnonce_invite_uninvite_user").val(),
			'friend_id': friend_id,
			'event_id': jq("input#event_id").val()
		},
		function(response)
		{
			jq('.ajax-loader').toggle();
			jq('#event-friend-list li#uid-' + friend_id).remove();
			jq('#invite-list input#f-' + friend_id).attr('checked', false);
		});

		return false;
	});
});