=== Jet Event System for BuddyPress ===
Contributors: Jettochkin
Donate link: http://milordk.ru/uslugi.html
Plugin link: http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html
Authoe link: http://milordk.ru/
Tags: BuddyPress, Wordpress MU, meta, members, widget, event, group, invite
Requires at least: 3.0, BuddyPress 1.2.5
Tested up to: 3.0.1, BuddyPress 1.2.5.2
Stable tag: trunk

The modern System of events for your social network. Ability to attract members of the network to the ongoing activities, a wide range of possibilities and options, support for different types of display, etc. <a href="http://jes.milordk.ru">JES DEV Site</a>. <strong>Before you install or upgrade sure to read the Readme file!</strong>!


== Description ==

<strong>en:</strong> The modern System of events for your social network. Ability to attract members of the network to the ongoing activities, a wide range of possibilities and options, support for different types of display, etc.

<strong>ru:</strong> Современная Система событий для Вашей социальной сети. Возможность привлекать участников сети к проводимым мероприятиям, широкий спектр возможностей и настроек, поддержка разных видов отображения и т.п.

<strong>Before you install or upgrade sure to read the Readme file!</strong>! 
<strong>Перед установкой или обновлением обязательно прочтите Readme файл!</strong>

Translation for the following locations: ru_RU, fr_FR, de_DE, es_ES, da_DK, it_IT (see Translate section in readme)

Live Demo: <a href="http://sportactions.ru">Sport site</a> , <a href="http://volks-wagen-club.ru">Volkswagen Club</a> (Please do not create events on these sites! Use the <a href="http://jes.milordk.ru">jes.milordk.ru</a>)


<a href="http://jes.milordk.ru">Official website of the plugin</a> (You can register and create events, thereby testing the latest version of plug-ins under development)


== Installation ==

1. Upload `jet-event-system-for-buddypress` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin automatically updates the Templates (and DB), but if you changed the subject and / or updated plug-in - need to visit the administrative panel of the plugin and follow the instructions - upgrade Templates!
4. Visit the admin panel plugin (Jes Event system)
5. Add widget to site (if needed)
6. See Events Catalog: http://yousite/events


== Screenshots ==

1. **Event catalog**
2. **Single Event**
3. **Datepicker**
4. **Widget on Site Wide**
5. **Admin Panel**

== Frequently Asked Questions ==

= Where can I see the plug-in work? =

You can see the latest version of the dev website: <a href="http://jes.milordk.ru">http://jes.milordk.ru</a>

= Can I affect the development of plug-in? =

Yes, the dev website there is a group for proposals for the development of plug-in. <a href="http://jes.milordk.ru">http://jes.milordk.ru</a>

= I have not updated Templates, what to do? =

Make sure that the owner of the folders and files contained in them is the owner of the web server (www/apache/nginx/nobody?)

= Can I get extended support plug-in or implementation of additional (specific) functional? =
You can, but keep in mind that the cost of implementing individual (not popular majority) functions - should be paid off


== Special Note ==

Used your theme should be based on the default theme BP (styles and functions)! The efficiency of the plug can only be guaranteed on these themes!
As one of the options for addressing emerging problems with other themes - connection functions.php from a default theme to your BP

<strong>If you are using a theme different from the BP-Default, be sure to install and activate</strong> - <a href="http://wordpress.org/extend/plugins/bp-template-pack">BP Template Pack</a>

Your wishes for the development of plug-in you can leave: http://jes.milordk.ru/groups/proposals-for-the-future

Discuss the issues of localization plugin, you can: http://jes.milordk.ru/groups/translates

Tell about problems with the plugin and read the other comments you can: http://jes.milordk.ru/groups/the-bugs


== Translate ==

* <strong>ru_RU</strong> - <em>Jettochkin</em>, <a href="http://milordk.ru" target="_blank">http://milordk.ru</a>
* <strong>fr_FR</strong> - <em>Laurent Hermann</em>, <a href="http://www.paysterresdelorraine.com/" target="_blank">http://www.paysterresdelorraine.com/</a>
* <strong>de_DE</strong> - <em>Manuel MЭller</em>, <a href="http://www.pixelartist.de" target="_blank">www.pixelartist.de</a>
* <strong>es_ES</strong> - <em>Alex_Mx</em>
* <strong>da_DK</strong> - <em>Cavamondo</em>
* <strong>it_IT</strong> - <em>Andrea Bianchi</em>


== Future ==

* In version 1.4 will be updated mechanism for the formation of Google Maps (manually or automatically at the specified location of the event)
* In version 1.5 will be implemented to use shortkode to insert into your records
* In version 1.6 will be added to the possibility of tying the event to a group
* In version 2.0 will ensure compatibility of the system with the new version of BP
* In version 2.5 will be able to add events to Outlook Calendar and iCal (list may vary from those of the creator of the plug and the wishes of the participants testing)
* In version 3.0 will be added to the possibility of tying the event to your blog (s)

List of future functions formed the opinion creator plug-in and test participants, if you have something to offer - <a href="http://jes.milordk.ru/groups/proposals-for-the-future">Poposals for the future</a>

Author plug reserves the right to order the implementation of functions


== Contact ==

For suggestions, bugs, hugs and love can be donated at the following locations.

[Authors page](http://milordk.ru)

[Plugin page](http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html)


== Changelog ==

= 1.3.1 =

* Update translate: it_IT
* The suppression of warnings in the web server logs for jes_datetounix function
* Resolved: At sub-domains in some theme there is a problem with processing the menu in the administrative panel WP

= 1.3 =
* Fixed a security issue: if the prohibition did not create an event administrators - they can directly access the form creation events
* The opportunity to add a map location of the event and its flyer
* Added ability to specify location of the event (in addition to address)
* Added possibility to change for the Title avatar widget
* Added check event's name at the time of its creation (given warning if the name is already used or it is not specified)
* For those who use their own styles: all div-layers added id
* Redesign Admin Panel
* Added to the locale it_IT translation. thanks Andrea Bianchi
* Added to the locale da_DK translation. thanks Cavamondo

= 1.2.4 =
* Added ability to specify the size of an avatar for the Catalogue of events, single events and widget
* The date is set by Datepicker (now there is no need to bind to a certain size - you can configure in the administrative panel plugin)
* Produced redesign display a single event
* <strong>NOTE:</strong> Update DB and Templates through an administrative panel!

= 1.2.3 =
* Fix problem with displaying an avatar friends who are going to invite to the event (problem occurred when an avatar user profile associated with gravitar)
* Optimized the administrative panel (setting Countries / Cities moved to the section of access to the fields of event)
Note: option "Allow City" does not work! 
* Corrections in phrases
* Fixed a problem: demonstrating public news even if they are disabled via admin panel 

= 1.2.2.1 =
* Fix: Do not save some options in the administrative panel plugin
* Adjusted to the phrase in Template

= 1.2.1.2 =
*Fixed problem when you have activated the plugin at the invitation of the group is not list of selected users.

= 1.2.1.1 =
* Correction of templates and update the administrative panel plugin

= 1.2 =
* Improved mechanism to update the database and Themes
NOTE: To use the updating mechanism is necessary after updating the plugin go to the admin panel!
* Introduced the ability to specify a group for the event in the future will be further developed!

= 1.1.9.9.5 =
* Fully completed work on the system of invitations
* NOTE: Please fully implement the testing

= 1.1.9.9.1 =
* Added ability to display an avatar to your friends list to send invitations (convenient innovation for a large number of friends)

= 1.1.9.9 =
* Added ability to send invitations to events. (Send an email with information about the invitation to the event)
* NOTE: Preliminary version

= 1.1.9.8 =
* Added the ability to authorize or prohibit the following field events: Special Conditions, Public News, Private news. 
* Note: Be sure to visit the settings page plugin!

= 1.1.9.7.1 =
* Ability to notify participants of the event changes

= 1.1.9.6 =
* Fixed: user profile does not display events

= 1.1.9.5.3 =
* Added a new style: Normal, showing a full description of the event

= 1.1.9.5.2 =
* Starting with version 1.1.9 in the administrative console not saved the fourth and fifth classifiers.

= 1.1.9.5.1 =
* Fixed problem with choice of style "Standard" for the catalog of events

= 1.1.9.5 = 
* Now you can choose the display style of Events Catalog: Standard or Twitter. The configuration is done via admin panel

= 1.1.9.4.1 =
* Implemented auto-update feature you are using themes! The update is available automatically via the administrative panel plugin. 
* NOTE: You should check the permissions on all folders themes and plugin!

= 1.1.9.3.2 =
* Added ability to customize the widget showing the country and the state
* Correction of administrative panel

= 1.1.9.3.1 =
* Adjusted to show details of events: if you did not fill the "Special Conditions", "Public News" or "Private News", the earlier they appear in the details as headers. Now they are displayed only if they fill
* Note: The release does not bear any significant changes

= 1.1.9.3 =
* Ability to use field "Country" and "State"
* NOTE: Update Events and Members folders

= 1.1.9.2 =
* Added ability to customize the filter by default for a directory of events and widget administration panel (in debug mode)
* Small changes in appearance
* NOTE:
- Custom Slug only in Latin! (cyrillic support is not guaranteed!)
- In the archive there is a previous version of the plugin (1.1.9.1)

= 1.1.9.1 =
* Activate Resctrict options: Prohibit non-administrators to create events, Allow verification of events by the administrator
* NOTE: Be sure to update folders and Events Members!

= 1.1.8.3 =
* Add Spanish (Alex_Mx) and German (Manuel MЭller) translation

= 1.1.8 =
* Fix Events Catalog template (need copy folders from templates!)
* Small changes in the code
* Added French translation, thanks Laurent Hermann

= 1.1.7.8 =
* Fixed problem barring access to events for unregistered users (the settings in the admin panel worked the other way around).  (Thank lolodev)
* Added ability to restrict viewing of private events in the catalog for unregistered users.

= 1.1.7.7 = 
* Small changes in the subject and in the administrative part

= 1.1.7.6 =
* Ability to view your events in the profile
* Changed plugin folder! : Transfer the contents of the folder Templates (events, members) in the folder you are using threads (default: / plugins / buddypress / bp-themes / bp-default) - MUST!

= 1.1.7.5 =
* Fixed problem with user request to join a private event

= 1.1.7.3 =
* Fix widget: select archive/active, any small

= 1.1.7.2 =
* Small changes in the administrative panel (expanding the number of classifiers to 5)

= 1.1.6 =
* Fixed error in determining the status of events (active / archive)

= 1.1.5 =
* Changing the sorting events in the widget (correction)
* Added an option in the settings of the widget - show archived events only for the administrator or for all
* Small changes in the code

= 1.1.4 =
* Archived events stand out for the widget added the ability to customize the color

= 1.1.3 =
* Added ability to hide the events for unregistered users

= 1.1.2 =
* Added database creation to implement the "activity" (in the future)
* Added ability to change SLUG from admin panel
* Alterations to the theme! Please update the folder 'events' in the theme you are using

= 1.1.1 =
* Fix problem when makr user as spamer

= 1.1 =
* Added setup into a widget
* Made adjustments to display the events directory

= 1.0.8 =
* Fixed a problem when you first install the plugin (not created the database)

= 1.0.7 =
* Fix Widget link to event

= 1.0.6 =
* Fix problem with deleting users in Site Admin. 
* Ability to manage the indexing of the widget, the ability to set predefined classifiers 

= 1.0.5 =
* Fixed Widget

= 1.0.4 =
* The solution to create a blog for activate the plugin

= 1.0.3 =
* Fixed sorting Soon in the widget.
* Activated bookmark "My Events / All events from the list of events

= 1.0.2 =
* Fixed an issue where when you activate the plugin stopped working group forum (technical releases)

= 1.0.1 =
* Fix theme files

= 1.0 =
* First release. Main functionality


`<?php code(); // goes in backticks ?>`