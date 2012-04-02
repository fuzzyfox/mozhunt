/**
 * This file contains all the needed code for those hiding tokens, with the
 * exception of the actual images.
 *
 * @author William Duyck <william@mozhunt.com>
 * @version 2012.04.01
 */

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
		{ elem['on'+type]; }
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
	};
	
	/**
	 * changes the token dom elements
	 */
	$mozhunt.tokenupdate = function(landingPage, config){
		$mozhunt.token.href = '//www.mozhunt.com/landing/'+landingPage;
		$mozhunt.token.img.src = '//www.mozhunt.com/token/'+(config.style)+'/'+landingPage+'.png?s='+(config.size);
	}
	
	/**
	 * initializes the mozhunt js, verifies token, does some back and forth to
	 * determine which image to show to the current user
	 *
	 * @param {Object} config The needed configuration information specific to the site implimenting this
	 */
	$mozhunt.init = function(config){
		// check config set and this method not called before
		if((!config) || (typeof $mozhunt.iframe !== 'Function'))
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
		}
		catch(e)
		{
			return;
		}
		
		// create iframe and destroy the create method
		$mozhunt.iframe = $mozhunt.iframe('//www.mozhunt.com/api/'+(config.apikey)+'/token/'+(config.tokenid));
		
		// setup what to do when mozhunt.com responds
		$mozhunt.comm.receiveMessage(function(msg){
			var data = msg.data;
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
						alert(data.alertString);
						return false;
					});
				break;
				// token not currently found by this user
				case 'default':
					$mozhunt.token.href = '//www.mozhunt.com/token/add/'+(data.addkey);
					$mozhunt.token.img.src = '//www.mozhunt.com/token/'+(config.style)+'/default.png?s='+(config.size);
					// add click event + ajax
					$mozhunt.addevent($mozhunt.token, 'click', function(e){
						$mozhunt.ajax('POST', '//www.mozhunt.com/token/add/'+(data.addkey), function(addResponse){
							addResponse = JSON.parse(addResponse);
							if(addResponse.success)
							{
								alert(addResponse.alertString[0]);
								$mozhunt.tokenupdate('found', config);
								// add click event
								$mozhunt.addevent($mozhunt.token, 'click', function(e){
									alert(addResponse.alertString[1]);
									return false;
								});
							}
							else
							{
								alert(addResponse.alertString[0]);
							}
						});
						return false;
					});
				break;
				// there was an error somewhere exit
				default:
					$mozhunt.tokenupdate('error', config);
					alert(data.status);
				break;
			}
		}, 'www.mozhunt.com');
	}
}