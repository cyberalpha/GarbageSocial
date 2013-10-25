/**
 * Handle window communication
 */


// Try to solve window communication with W3C postMessage API
if (window.postMessage) {

	// Define message event handler
	function receiveMessage(event) {

		// Special solution for Opera 9
		if (navigator.userAgent.match(/Opera\/9/g)) {

			// Process received message
			window.opener.mgpReturnResult(event.data);
			window.close();

		}

		// Only proceed if message from valid domain
		else if(event.origin.match(/mygeoposition\.com$/g)) {

			// Process received message
			window.opener.mgpReturnResult(event.data);
			window.close();

		}

	}

	// Attach event handling
	if (window.addEventListener) {
		window.addEventListener("message", receiveMessage, false);
	} else {
		window.attachEvent("onmessage", receiveMessage);
	}

}

// Fallback to URL fragment hash hack
else {

	// Polling function to retrieve geocoding result
	function checkReturnValue() {

		// Keep on checking until message is there
		if (document.location.href.indexOf("#MGPResult:") == -1) {
			setTimeout(checkReturnValue, 100);
		}

		// Retrieve message
		else {

			var location = document.location.href;

			// Fix for safari - it does not allow two hashes in one URL and URLencodes the 2nd+ ones
			location = location.replace(/#MGPDummy%23/, "#");
			location = location.replace(/#MGPDummy#/, "#");

			// Extract message from URL
			var pos = location.indexOf("#MGPResult:")
			if (pos >= 0) {
				var returnValue = location.substring(pos + 11);
				var newLocation = location.substring(0, pos);
				newLocation = newLocation.replace(/#MGPDummy/, "");
				newLocation = newLocation + "#MGPDummy";
				document.location.href = newLocation;

				window.opener.mgpReturnResult(utf8_decode(returnValue));
				window.close();
			}
		}
	}
	setTimeout(checkReturnValue, 100);

}



/**
 * UTF8 decodes a string.
 */
function utf8_decode(utftext) {
	var string = "";
	var i = 0;
	var c = c1 = c2 = 0;

	utftext = unescape(utftext);

	while ( i < utftext.length ) {

		c = utftext.charCodeAt(i);

		if (c < 128) {
			string += String.fromCharCode(c);
			i++;
		}
		else if((c > 191) && (c < 224)) {
			c2 = utftext.charCodeAt(i+1);
			string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
			i += 2;
		}
		else {
			c2 = utftext.charCodeAt(i+1);
			c3 = utftext.charCodeAt(i+2);
			string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
			i += 3;
		}

	}

	return string;
}