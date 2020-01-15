=== VI: Member Content ===
Contributors: Knighthawk
Donate link:
Tags:
Requires at least: ?
Tested up to: 5.3
Version: 9.1.200115
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Site Specific Functions

== Description ==

Allows you to place content intended for different users on the same post/page
Content for logged in/out users
Content separated by user role/ability

See Installation for a list of Shortcodes


== Installation ==
List of available shortcodes:

* publish content only visible by non-logged-in visitors
	[vi-visitor]
	your content
	[/vi-visitor]

* publish content only visible by logged-in visitors
	[vi-member]
	your content
	[/vi-member]

	[vi-member type="any"]
	your content
	[/vi-member]

* publish content only visible by logged-in visitors of a certian role/ability
	[vi-member type="editor"]
	your content
	[/vi-member]

	comma separated list of roles/abilities
	(user needs only one of these)
	[vi-member type="subscriber, editor, custom_ability"]
	your content
	[/vi-member]



== Changelog ==

= 9.1.200115 =
* Fixed bug: potential for empty string in foreach
* Edit: moved check if $content is null earlier to skip doing extra work

= 9.1.191203 =
* Fixed bug: missing parameter
* Edit: replaced !is_feed initial requirement with is_user_logged_in

= 9.1.191028 =
* Fixed role/ability separation

= 0.2.181214 =
* FPL