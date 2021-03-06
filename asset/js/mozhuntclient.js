/**
 * This file contains all the needed code for those hiding tokens, with the
 * exception of the actual images.
 *
 * @author William Duyck <william@mozhunt.com>
 * @version 2012.04.01
 */
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
// check for another instance of namespace
if(typeof $mozhunt === 'undefined')
{
	var $mozhunt = {};
	
	/**
	 * create the hidden iframe for two way communication with mozhunt
	 *
	 * @param {String} url The url to point the iframe to.
	 * @returns {DOMElement} The DOMElement for the newly created iframe.
	 */
	$mozhunt.iframe = function(url){
		url += '#' + encodeURIComponent(document.location.href);
		
		var iframe = document.createElement('iframe');
		iframe.src = url;
		iframe.style.width = '0';
		iframe.style.height = '0';
		iframe.style.visibility = 'hidden';
		iframe.id = 'mozhuntconnection';
		iframe.name = 'mozhuntconnection';
		return document.body.appendChild(iframe);
	};
	
	/**
	 * add an event to an element
	 * 
	 * @param elem {object} the dom object to attach the event to
	 * @param type {string} the type of event to listen for
	 * @param fn {function} the function to run on event
	 */
	$mozhunt.addevent = function(elem, type, fn, capture){
		if(typeof capture !== 'boolean')
		{ capture = false; }
		if(elem.addEventListener)
		{ elem.addEventListener(type, fn, capture); }
		else if(elem.attachEvent)
		{ elem.attachEvent('on'+type, fn); }
		else
		{ elem['on'+type] = fn; }
		return this;
	};
	
	/**
	 * a simple ajax control for quick easy ajax calls
	 * 
	 * @param method {string} method of request in CAPS
	 * @param url {string} the url we want to make the request to
	 * @param callback {function} the function to run on success
	 */
	$mozhunt.ajax = function(method, url, callback){
		var xhr;
		if(window.XMLHttpRequest)
		{
			xhr = new XMLHttpRequest();
		}
		else
		{
			xhr = new ActiveXObject('Microsoft.XMLHTTP');
		}
		xhr.onreadystatechange = function(){
			if((xhr.readyState == 4)&&(xhr.status == 200))
			{
				callback(xhr.responseText);
			}
		};
		xhr.open(method, url, true);
		xhr.send();
	}
	
	/**
	 * creates a postMessage interface with fallback for older browsers
	 *
	 * @returns {Object} The postMessage interface w/ fallback rolled in.
	 */
	$mozhunt.comm = function(){
		var interval_id, last_hash, cache_bust = 1, attached_callback;
		
		return {
			/**
			 * Sends a JSON message to another website via an iframe to avoid the
			 * same origin rule.
			 *
			 * @param {Object} message The message to send in JSON format.
			 * @param {String} target_url The website to send the information to.
			 * @param {Object} target which side of the iframe is the target?
			 */
			postMessage : function(msg, target_url, target){
				// check at least the two most needed params were passed in
				if(!target_url)
				{
					return;
				}
				
				// target = talk to child iframe, parent = talk to website containing this script in an iframe
				target = target || parent;
				
				// detect browser support for postMessage
				if(window['postMessage'])
				{
					// browser does support postMessage so call it with a targetOrigin
					target['postMessage'](msg, target_url.replace(/([^:]+:\/\/[^\/]+).*/, '$1'));
				}
				else if(target_url)
				{
					// browser does not support postMessage so use the # hack to work around
					// add a cache_bust value to prevent browser from caching responses
					target.location = target_url.replace(/#.*$/, '') + '#' + (new Date) + (cache_bust++) + '&' + JSON.stringify(msg);
				}
			},
			
			/**
			 * Receives a JSON message from another website via an iframe to avoid
			 * the same origin rule
			 *
			 * @param {Function} callback The function to run when data is received
			 * @param {String} source_origin Where we expect the data to be coming from
			 */
			receiveMessage : function(callback, source_origin){
				// detect browser support for postMessage
				if(window['postMessage'])
				{
					// browser does support postMessage so bind callback to the event associated with postMessage
					if(callback)
					{
						// rework the callback a little for safety
						attached_callback = function(e){
							if((typeof source_origin === 'string' && e.origin !== source_origin) ||
							   (Object.prototype.toString.call(source_origin) === '[Object Function]' && source_origin(e.origin)))
							{
								return !1;
							}
							callback(e);
						};
					}
					
					// workout the correct type of event listener to attach the callback to
					if(window['addEventListener'])
					{
						window[callback ? 'addEventListener' : 'removeEventListener']('message', attached_callback, !1);
					}
					else
					{
						window[callback ? 'attachEvent' : 'detachEvent']('onmessage', attached_callback);
					}
				}
				else
				{
					// browser does not support postMessage so use the # hack to work around
					
					// create a polling loop to detech changes to the #
					interval_id && clearInterval(interval_id);
					interval_id = null;
					
					if(callback)
					{
						interval_id = setInterval(function(){
							var hash = document.location.hash, re = /^#?\d+&/;
							if(hash !== last_hash && re.test(hash))
							{
								last_hash = hash;
								callback({
									data : JSON.parse(hash.replace(re, ''))
								});
							}
						}, 100);
					}
				}
			}
		};
	}();
	
	/**
	 * changes the token dom elements
	 */
	$mozhunt.tokenupdate = function(landingPage, config){
		$mozhunt.token.href = '//www.mozhunt.com/landing/'+landingPage;
		$mozhunt.token.img.src = '//www.mozhunt.com/token/img/'+(config.style)+'/'+landingPage+'.png?s='+(config.size);
	}
	
	/**
	 * initializes the mozhunt js, verifies token, does some back and forth to
	 * determine which image to show to the current user
	 *
	 * @param {Object} config The needed configuration information specific to the site implimenting this
	 */
	$mozhunt.init = function(config){
		// check config set and this method not called before
		if((!config) || (typeof $mozhunt.proxy !== 'undefined'))
		{
			return;
		}
		
		/*
		 some things relating to elements that should be in the dom on this page
		 already so we can use them to check if we need to continue on.
		*/
		try
		{
			$mozhunt.token = document.getElementById('mozhunttoken');
			$mozhunt.token.img = document.getElementById('mozhunttokenimg');
			console.log('token detected... initilising');
		}
		catch(e)
		{
			return;
		}
		
		// create iframe and destroy the create method
		$mozhunt.proxy = $mozhunt.iframe('//www.mozhunt.com/token/api/verify/'+(config.tokenid)+'/'+(config.apikey));
		
		var cDate = new Date();
		var lDate = new Date('April 15, 2012 00:00:00');
		if(cDate.getTime() > lDate.getTime())
		{
			// setup what to do when mozhunt.com responds
			$mozhunt.comm.receiveMessage(function(msg){
				var data = JSON.parse(msg.data);
				switch(data.status)
				{
					// user is no a mozhunt player
					case 'guest':
						$mozhunt.tokenupdate(data.status, config);
					break;
					// token has previously been found by this user
					case 'found':
						$mozhunt.tokenupdate(data.status, config);
						// add click event
						$mozhunt.addevent($mozhunt.token, 'click', function(e){
							window.showModalDialog("//www.mozhunt.com/asset/misc/modal_found.html", "", "dialogWidth:480px; dialogHeight:380px");
							e.preventDefault();
							return false;
						});
					break;
					// token not currently found by this user
					case 'default':
						$mozhunt.token.href = '//www.mozhunt.com/token/find/'+(data.addkey);
						$mozhunt.token.img.src = '//www.mozhunt.com/token/img/'+(config.style)+'/default.png?s='+(config.size);
						// add click event + ajax
						$mozhunt.addevent($mozhunt.token, 'click', function(e){
							$mozhunt.ajax('GET', 'http://www.mozhunt.com/token/find/'+(data.addkey), function(addResponse){
								addResponse = JSON.parse(addResponse);
								if(addResponse.success)
								{
									window.showModalDialog("//www.mozhunt.com/asset/misc/modal_success.html", "", "dialogWidth:480px; dialogHeight:380px");
									$mozhunt.tokenupdate('found', config);
									// add click event
									$mozhunt.addevent($mozhunt.token, 'click', function(e){
										window.showModalDialog("//www.mozhunt.com/asset/misc/modal_found.html", "", "dialogWidth:480px; dialogHeight:380px");
										e.preventDefault();
										return false;
									});
								}
								else
								{
									window.showModalDialog("//www.mozhunt.com/asset/misc/modal_error.html", "", "dialogWidth:480px; dialogHeight:380px");
								}
							});
							e.preventDefault();
							return false;
						});
					break;
					// there was an error somewhere exit
					default:
						$mozhunt.tokenupdate('error', config);
						window.showModalDialog("//www.mozhunt.com/asset/misc/modal_error.html", "", "dialogWidth:480px; dialogHeight:380px");
					break;
				}
			}, 'http://www.mozhunt.com');
		}
		else
		{
			$mozhunt.token.style.display = "none";
		}
	}
}