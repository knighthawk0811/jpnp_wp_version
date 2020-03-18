/**
 * version_8_js_foot.js
 * loaded in the footer
 *
 * @link
 * @version 8.3.190625
 */
 "use strict";






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