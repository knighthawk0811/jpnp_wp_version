/**
 * version_7_ajax.js
 *
 * @link 
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
 * initialize on command
 *
 * @link 
 * @param
 * @return 
 * @uses version_7_complete_middle_man
 */
function version_7_complete_init() 
{			
	event_call_function_once(function()
	{
		version_7_complete_middle_man();
		//1200 ms wait
	}, 1200, "version_7_complete_middle_man");
	
	return false
}
/**
 * call action "middle-man"
 *
 * add a CSS class to the content somewhere and check against duplicate runs
 *
 * @link 
 * @param
 * @return 
 * @uses version_7_complete_ajax
 */
function version_7_complete_middle_man() 
{
	if(jQuery("#main").hasClass("loaded"))
	{
		//do nothing, already done
	}
	else
	{
		version_7_complete_ajax();
	}
}
/**
 * main action
 *
 * has generic args because it has little knowledge of what the called function might do
 *
 * @link 
 * @param
 * @return 
 * @uses version_7_generic_ajax_callback
 */
function version_7_generic_ajax(arg0 = '', arg1 = '', arg2 = '', arg3 = '') 
{
	var output = '';
	jQuery.ajax(
	{
		url: theurl.ajaxurl,
		type: 'post',
		data: 
		{
			action: 'version_7_generic_ajax_callback',
			param0: arg0,
			param1: arg1,
			param2: arg2,
			param3: arg3
		},
		success: function( result ) 
		{
			//alert('test-lsjeuhrg');
			//add class "loaded" to avoid happening more than once
			//jQuery("#main").addClass("loaded");

			output = result;

			switch(arg0)
			{
				case 'search_adv_by_name':
					search_adv_by_name(result);
				break;
				case 'search_ag_by_name':
					search_ag_by_name(result);
				break;
				default:
			}
		}
	});
	return output;
}
 
 
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