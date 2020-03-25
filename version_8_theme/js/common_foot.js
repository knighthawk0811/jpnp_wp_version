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





jQuery(document).ready(function(){
	//set the GCS placeholder text
	//wait until we click it, because we can't be faster than GCS loading
	jQuery("#modal-button").click(function(event){
		jQuery("#gsc-i-id1").attr("placeholder", "Search");
	});
});

//bootstrap modals, help with z-index
/*
jQuery('.modal-dialog').parent().on('show.bs.modal', function(e){
	jQuery(e.relatedTarget.attributes['data-target'].value).appendTo('body');
});
*/


/**
 * modal inner menu toggling functions
 *
 * @link
 * @version 8.3.190923
 * @since 8.3.190923
 */
jQuery(document).ready(function()
{
	jQuery("#nav-modal ul.menu a[href='#']").click(function(event){
		jQuery(this).parent().toggleClass( "toggle-on" );
		jQuery(this).parent().siblings().removeClass( "toggle-on" );
	});
});