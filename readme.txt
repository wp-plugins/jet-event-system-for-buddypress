=== Jet Event System for BuddyPress ===
Contributors: Jettochkin
Donate link: http://milordk.ru/uslugi.html
Plugin link: http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html
Authoe link: http://milordk.ru/
Tags: BuddyPress, Wordpress MU, meta, members, widget
Requires at least: 3.0, BuddyPress 1.2.5
Tested up to: 3.0.1, BuddyPress 1.2.5.2
Stable tag: trunk

System events for your social network. Ability to attract members of the network to the ongoing activities.
<a href="http://jes.milordk.ru">JES DEV Site</a>. <strong>Before you install or upgrade sure to read the Readme file!</strong>!


== Description ==

en: System events for your social network. Ability to attract members of the network to the ongoing activities.
The plugin is in testing, may not operate some features! Please give your suggestions for new features and improving existing ones. Please do not remove references to the developer (for the statistics units)

ru: Система событий для Вашей социальной сети. Возможность привлекать участников сети к проводимым мероприятиям. 
Плагин находится в стадии тестирования, могут не работать некоторые функции! Просьба высказывать свои предложения по новым функциям и улучшению уже существующих. Просьба не удалять ссылки на разработчика (для статистики установок)


<strong>Before you install or upgrade sure to read the Readme file!</strong>!

<strong>Перед установкой или обновлением обязательно прочтите Readme файл!</strong>


Live Demo: <a href="http://sportactions.ru">Sport site</a> and <a href="http://volks-wagen-club.ru">Volkswagen Club</a> (Please do not create events on these sites! Use the <a href="http://jes.milordk.ru">jes.milordk.ru</a>)


<a href="http://jes.milordk.ru">Official website of the plugin</a> (You can register and create events, thereby testing the latest version of plug-ins under development)


== Installation ==

1. Upload `jet-event-system-for-buddypress` folder to the `/wp-content/plugins/` directory
2. Be sure to transfer the contents of the folder from the Templates folder (Events, Members) in the root of the plugin you are using themes BP (default: / plugins / buddypress / bp-themes / bp-default)
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Add widget to site (if needed)
5. See Events Catalog: http://yousite/events


== Screenshots ==

1. **Event catalog**
2. **Create Event Screen**
3. **Event Setting**
4. **Widget on Site Wide**
5. **Admin Panel**

== Special Note ==

Used your theme should be based on the default theme BP (styles and functions)! The efficiency of the plug can only be guaranteed on these topics!
As one of the options for addressing emerging problems with other themes - connection functions.php from a default theme to your BP

<strong>If you are using a theme different from the BP-Default, be sure to install and activate</strong> - <a href="http://wordpress.org/extend/plugins/bp-template-pack/">BP Template Pack</a>

Your wishes for the development of plug-in you can leave: http://jes.milordk.ru/groups/proposals-for-the-future/

Discuss the issues of localization plugin, you can: http://jes.milordk.ru/groups/translates/

Tell about problems with the plugin and read the other comments you can: http://jes.milordk.ru/groups/test-group-16902666/


== Future ==

* In version 1.2 will ensure compatibility of the system with the new version of BP
* In version 1.3 will be added to the possibility of tying the event to a group
* In version 1.4 will be added to the possibility of tying the event to your blog (s) 

== Contact ==

For suggestions, bugs, hugs and love can be donated at the following locations.
[Authors page](http://milordk.ru)
[Plugin page](http://milordk.ru/r-lichnoe/opyt/cms/jet-event-system-for-buddypress-sistema-sobytij-dlya-vashej-socialnoj-seti.html)


== Changelog ==

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
