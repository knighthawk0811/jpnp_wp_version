=== Plugin Name ===
Contributors: knighthawk0811
Tags: get, params, shortcode, vars
Requires at least: 4.0
Tested up to: 4.8
Stable tag: 0.1.181130
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shortcodes allowing you to display URL parameters from the current URL in pages and posts, or show/hide content depending
on URL param values

== Description ==

version_8_plugin_url_param provides your pages and posts with shortcodes allowing you to display URL parameters from 
the current URL in pages and posts, or show/hide content depending on URL param values.

** Modified from the plugin "display get params - version 1.1 - https://wordpress.org/plugins/get-params/" **
** NOTE: this modification WAS specifically to use the WP built in function get_query_var **
** BUT, it's too late to "add_filter( 'query_vars'," by the time shortcodes run
** So, we will check if the query var has been setup, and fall back if needed

Examples follow, assuming the user goes to your post page http://example.com/post/3/?paramname=showme

= Displaying URL parameters directly =

 `[display-param name="paramname"]`
 
 Shows the value of URL named paramname ('showme' in the example URL), or "blank value" if none given.
 
 `[display-param name="paramname" default="Paramname was blank"]`
 
 Shows the value of URL named paramname, or "Paramname was blank" if none
 
= Display content IF the URL parameter is set =

 `[display-if name="myparam"]`
 
	This enclosed content only shows if myparam is passed as a URL param (with any value)
	
 `[/display-if]`

= Display content IF the URL parameter is set to a specific value =

 `[display-if name="myparam" value="true"]`
 
	This content only shows if myparam is passed as a URL param and equals "true"

 `[/display-if]`
 
= Display content IF the URL parameter is NOT set =

 `[display-if-not name="myparam"]`
 
	This enclosed content only shows if myparam is NOT passed as a URL param (with any value)
	
 `[/display-if-not]`

= Display content IF the URL parameter is NOT set to a specific value =

 `[display-if-not name="myparam" value="true"]`
 
	This content only shows if myparam is passed as a URL param and IS NOT equal "true"

 `[/display-if-not]`



== Changelog ==


= 0.1.181130 =
FPL

