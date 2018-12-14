/**
 * version_8_plugin_site.js
 *
 */
 "use strict";


/**
 * initialize on document ready
 *
 * @link 
 * @param
 * @return 
 * @uses
 */
jQuery(document).ready(function() 
{			
	/*/
	event_call_function_once(function()
	{
		version_7_complete_middle_man();
		//alert("test");
	}, 1000, "version_7_complete_middle_man");
	//*/
	return false
});
 
 
/**
 * Do Things Only Once
 *
 * @link
 * @param
 * @return
 * @uses
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