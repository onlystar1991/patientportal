<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

<script>

var browser = navigator.sayswho= (function(){
	var ua= navigator.userAgent, tem, 
	M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
	if(/trident/i.test(M[1])){
		tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
		return 'IE '+(tem[1] || '');
	}
	if(M[1]=== 'Chrome'){
		tem= ua.match(/\bOPR\/(\d+)/)
		if(tem!= null) return 'Opera '+tem[1];
	}
	M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
	if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
	return M.join(' ');
})();

if(browser.indexOf("Chrome") > -1) { browser = "Chrome"; }
else if(browser.indexOf("Firefox") > -1) { browser = "Firefox"; }
else { browser = ""; }

if(browser == "Chrome") {
	console.log("Chrome detected");
	$.detectChromeExtension = function(extensionId, accesibleResource, callback){
		if (typeof(chrome) !== 'undefined'){
			var testUrl = 'chrome-extension://' +extensionId +'/' +accesibleResource;
			$.ajax({
				url: testUrl,
				timeout: 1000,
				type: 'HEAD',
				success: function(){
					if (typeof(callback) == 'function')
						callback.call(this, true);
				},
				error: function(){                
					if (typeof(callback) == 'function')
						callback.call(this, false);
				}
			});
		} else {
			if (typeof(callback) == 'function')
				callback.call(this, false);
		}
	};

	function myCallbackFunction(extensionExists) {
		if(extensionExists) {

			var editorExtensionId = "<?php echo EXTENSION_ID; ?>";

			// Make a simple request:
			chrome.runtime.sendMessage(editorExtensionId, {setCookie: { "name": "<?php echo $cookie_name; ?>",
																		"value": "<?php echo $cookie_value; ?>",
																		"url": "<?php echo $url; ?>" } },
			function(response) {
				document.location = "<?=$redirection?>";
			});

			console.log("Cookie data sent to extension");
		} else {
			console.log("Extension not found");
		}
	}

	$.detectChromeExtension('<?php echo EXTENSION_ID; ?>', 'background.js', myCallbackFunction);

} else if(browser == "Firefox") {
	console.log("Firefox detected");

	window.onload = function() {
		var cookieData = ["<?php echo $url; ?>", "<?php echo $cookie_name; ?>", "<?php echo $cookie_value; ?>"];
		window.postMessage(cookieData, "*");

		console.log("Cookie info sent");

		setTimeout(function() {
			document.location = "<?=$redirection?>";
			clearInterval(interval);
		}, 1000);
	};
} else {
	console.log("Invalid browser");
}

</script>