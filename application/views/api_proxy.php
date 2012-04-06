<!doctype html>
<script type="text/javascript">
$mozhuntpostmessage = function () {
	var interval_id, last_hash, cache_bust = 1,
		attached_callback, window = this;
	return {
		postMessage: function (message, target_url, target) {
			if (!target_url) {
				return;
			}
			target = target || parent; // default to parent
			if (window['postMessage']) {
				// the browser supports window.postMessage, so call it with a targetOrigin
				// set appropriately, based on the target_url parameter.
				target['postMessage'](message, target_url.replace(/([^:]+:\/\/[^\/]+).*/, '$1'));
			} else if (target_url) {
				// the browser does not support window.postMessage, so set the location
				// of the target to target_url#message. A bit ugly, but it works! A cache
				// bust parameter is added to ensure that repeat messages trigger the callback.
				target.location = target_url.replace(/#.*$/, '') + '#' + (+new Date) + (cache_bust++) + '&' + message;
			}
		},
		receiveMessage: function (callback, source_origin) {
			// browser supports window.postMessage
			if (window['postMessage']) {
				// bind the callback to the actual event associated with window.postMessage
				if (callback) {
					attached_callback = function (e) {
						if ((typeof source_origin === 'string' && e.origin !== source_origin) || (Object.prototype.toString.call(source_origin) === "[object Function]" && source_origin(e.origin) === !1)) {
							return !1;
						}
						callback(e);
					};
				}
				if (window['addEventListener']) {
					window[callback ? 'addEventListener' : 'removeEventListener']('message', attached_callback, !1);
				} else {
					window[callback ? 'attachEvent' : 'detachEvent']('onmessage', attached_callback);
				}
			} else {
				// a polling loop is started & callback is called whenever the location.hash changes
				interval_id && clearInterval(interval_id);
				interval_id = null;
				if (callback) {
					interval_id = setInterval(function () {
						var hash = document.location.hash,
							re = /^#?\d+&/;
						if (hash !== last_hash && re.test(hash)) {
							last_hash = hash;
							callback({
								data: hash.replace(re, '')
							});
						}
					}, 100);
				}
			}
		}
	};
}();
//	/**
//	 * This file contains all the needed code for those hiding tokens, with the
//	 * exception of the actual images.
//	 *
//	 * @author William Duyck <william@mozhunt.com>
//	 * @version 2012.04.01
//	 */
//	
//	// check for another instance of namespace
//	if(typeof $mozhunt === 'undefined')
//	{
//		var $mozhunt = {};
//		
//		/**
//		 * creates a postMessage interface with fallback for older browsers
//		 *
//		 * @returns {Object} The postMessage interface w/ fallback rolled in.
//		 */
//		$mozhunt.comm = function(){
//			var interval_id, last_hash, cache_bust = 1, attached_callback;
//			
//			return {
//				/**
//				 * Sends a JSON message to another website via an iframe to avoid the
//				 * same origin rule.
//				 *
//				 * @param {Object} message The message to send in JSON format.
//				 * @param {String} target_url The website to send the information to.
//				 * @param {Object} target which side of the iframe is the target?
//				 */
//				postMessage : function(msg, target_url, target){
//					// check at least the two most needed params were passed in
//					if(!target_url)
//					{
//						return;
//					}
//					
//					// target = talk to child iframe, parent = talk to website containing this script in an iframe
//					target = target || parent;
//					
//					// detect browser support for postMessage
//					if(window['postMessage'])
//					{
//						// browser does support postMessage so call it with a targetOrigin
//						target['postMessage'](msg, target_url.replace(/([^:]+:\/\/[^\/]+).*/, '$1'));
//					}
//					else if(target_url)
//					{
//						// browser does not support postMessage so use the # hack to work around
//						// add a cache_bust value to prevent browser from caching responses
//						target.location = target_url.replace(/#.*$/, '') + '#' + (new Date) + (cache_bust++) + '&' + JSON.stringify(msg);
//					}
//				},
//				
//				/**
//				 * Receives a JSON message from another website via an iframe to avoid
//				 * the same origin rule
//				 *
//				 * @param {Function} callback The function to run when data is received
//				 * @param {String} source_origin Where we expect the data to be coming from
//				 */
//				receiveMessage : function(callback, source_origin){
//					// detect browser support for postMessage
//					if(window['postMessage'])
//					{
//						// browser does support postMessage so bind callback to the event associated with postMessage
//						if(callback)
//						{
//							// rework the callback a little for safety
//							attached_callback = function(e){
//								if((typeof source_origin === 'string' && e.origin !== source_origin) ||
//								   (Object.prototype.toString.call(source_origin) === '[Object Function]' && source_origin(e.origin)))
//								{
//									return !1;
//								}
//								callback(e);
//							};
//						}
//						
//						// workout the correct type of event listener to attach the callback to
//						if(window['addEventListener'])
//						{
//							window[callback ? 'addEventListener' : 'removeEventListener']('message', attached_callback, !1);
//						}
//						else
//						{
//							window[callback ? 'attachEvent' : 'detachEvent']('onmessage', attached_callback);
//						}
//					}
//					else
//					{
//						// browser does not support postMessage so use the # hack to work around
//						
//						// create a polling loop to detech changes to the #
//						interval_id && clearInterval(interval_id);
//						interval_id = null;
//						
//						if(callback)
//						{
//							interval_id = setInterval(function(){
//								var hash = document.location.hash, re = /^#?\d+&/;
//								if(hash !== last_hash && re.test(hash))
//								{
//									last_hash = hash;
//									callback({
//										data : JSON.parse(hash.replace(re, ''))
//									});
//								}
//							}, 100);
//						}
//					}
//				}
//			};
//		}();
//		
//		/**
//		 * initializes the mozhunt js
//		 */
//		$mozhunt.init = function(){
//			var parentURL = decodeURIComponent(document.location.hash.replace(/^#/, ''));
//			$mozhuntpostmessage.postMessage({
//				status : '<?php echo $status; ?>',
//				addkey : '<?php echo $otk; ?>'
//			}, parentURL, parent);
//			return false;
//		}
//	}
//	
//	$mozhunt.init();
$mozhunt = {};
$mozhunt.send = function(msg)
{
	var parentURL = decodeURIComponent(document.location.hash.replace(/^#/, ''));
	msg = JSON.stringify(msg);
	$mozhuntpostmessage.postMessage(msg, parentURL, parent);
	return false;
}
$mozhunt.send({
	status : '<?php echo $status; ?>',
	addkey : '<?php echo $otk; ?>'
});

$mozhuntpostmessage.receiveMessage(function(msg){
	msg = JSON.parse(msg);
	console.log(msg);
	return false;
}, '*');
</script>