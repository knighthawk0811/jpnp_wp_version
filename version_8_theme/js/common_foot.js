/**
 * version_8_js_foot.js
 * loaded in the footer
 *
 * @link
 * @version 8.3.190625
 */
 "use strict";



/**
 * generic toggling functions
 *
 * @link
 * @version 8.3.190625
 * @since 7.2.190415
 */
jQuery(document).ready(function()
{
	//vip generic toggle
	jQuery(".vip-toggle-container .vip-toggle-button").click(function(event){
		jQuery(this).parent().toggleClass( "toggle-on" );
		jQuery(this).parentsUntil('.vip-toggle-container').parent().toggleClass( "toggle-on" );
	});
});

/**
 * for tabular display swapping
 *
 * @link https://www.mkyong.com/jquery/how-to-use-css-and-jquery-to-hide-and-show-tab-content/
 * @version 8.3.1900910
 * @since 7.2.190415
 */
jQuery(document).ready(function()
{
	jQuery('.vip-tabular-container ul > li > a').click(function(event){
		//"this" = the link that was clicked
		//stop browser from following link
		event.preventDefault();

		//vars, get now before changes
		var container_selector = jQuery(this).parentsUntil('.vip-tabular-container').parent();
		var target_tab_selector = jQuery(this).attr('href');

		//hide currently active
		jQuery(container_selector).find('.active').addClass('hide');
		jQuery(container_selector).find('.active').removeClass('active');

		//navigation
		//add 'active' class into clicked navigation
		jQuery(this).parents('li').addClass('active');
		jQuery(this).parents('li').removeClass('hide');

		//show the new tab
		jQuery(target_tab_selector).removeClass('hide');
		jQuery(target_tab_selector).addClass('active');
	});
});



/**
 * Do Things Only Once
 *
 * @link
 * @version 7.2.190415
 * @since 7.2.190415
 */
var event_call_function_once = (function ()
{
	var timers = {};
	return function (callback, ms, uniqueId)
	{
		if (!ms)
		{
			ms = 2000;
		}
		if (!uniqueId)
		{
			uniqueId = "Don't call this twice without a uniqueId";
		}
		if (timers[uniqueId])
		{
			clearTimeout (timers[uniqueId]);
		}
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();