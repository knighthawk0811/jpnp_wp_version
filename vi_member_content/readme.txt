=== Version 8 Plugin: Member Content ===
Contributors: Knighthawk
Donate link:
Tags:
Requires at least: ?
Tested up to: 5.2
Version: 9.1.191028
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Site Specific Functions

== Description ==

Allows you to place content for different users on the same post/page
Separated by logged in/out
Separated by user role or ability

See Installation for a list of Shortcodes


== Installation ==
List of available shortcodes:

* publish content only visible by non-logged-in visitors
	[visitor]
	your content
	[/visitor]

* publish content only visible by logged-in visitors
	[member]
	your content
	[/member]

	[member type="any"]
	your content
	[/member]

* publish content only visible by logged-in visitors of a certian role/ability
	[member type="editor"]
	your content
	[/member]

	comma separated list of roles/abilities
	(user needs only one of these)
	[member type="subscriber, editor, custom_ability"]
	your content
	[/member]



== Changelog ==

= 9.1.191028 =
* Fixed role/ability separation

= 0.2.181214 =
* FPL