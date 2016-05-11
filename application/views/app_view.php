<?php if(!isset($appLoginType)) { $appLoginType = 'serverside'; } ?>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/app_view.css">

<div id="giffloat2">
	<img src="<?php echo base_url();?>assets/images/loading.gif" border="0" width="340" height="380"><br/>
	<div class="loadingApplication">
		LOADING APPLICATION...
	</div>
</div>

<iframe id="appIFrame" name="appIFrame" height="100%" width="100%" style="background-color:#fff; position:absolute; z-index:5; opacity: 0;"
		<?php if(isset($blockTopNavigation) && $blockTopNavigation === true) { ?>
					sandbox="allow-forms allow-scripts allow-pointer-lock allow-popups allow-same-origin" <?php } ?>></iframe>

<script>

var editorExtensionId = "<?php echo EXTENSION_ID; ?>";

<?php if($appLoginType == 'serverside') { ?>

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
			var testUrl = 'chrome-extension://' + extensionId +'/' +accesibleResource;
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
			// Make a simple request:
			chrome.runtime.sendMessage(editorExtensionId, {setCookie: { "name": "<?php echo $cookie_name; ?>",
																		"value": "<?php echo $cookie_value; ?>",
																		"url": "<?php echo $url; ?>" } },
			function(response) {
				document.getElementById('appIFrame').src = "<?php echo $redirection_url; ?>";

				$('#appIFrame').load(function(){
					$('#appIFrame').css("opacity", "1");
					$('#giffloat2').css("display", "none");

					clearInterval(interval);
				});
			});

			console.log("Cookie data sent to extension");
		} else {
			console.log("Extension not found");
		}
	}

	$.detectChromeExtension(editorExtensionId, 'background.js', myCallbackFunction);

} else if(browser == "Firefox") {
	console.log("Firefox detected");

	window.onload = function() {
		var cookieData = ["<?php echo $url; ?>", "<?php echo $cookie_name; ?>", "<?php echo $cookie_value; ?>"];
		window.postMessage(cookieData, "*");

		console.log("Cookie info sent");

		setTimeout(function() {
			document.getElementById('appIFrame').src = '<?php echo $redirection_url; ?>';
			
			<?php if(!isset($disableFirefoxLoading) || $disableFirefoxLoading !== true) { echo '$(\'#appIFrame\').load(function(){'; } ?>
				$('#appIFrame').css("opacity", "1");
				$('#giffloat2').css("display", "none");

				clearInterval(interval);
			<?php if(!isset($disableFirefoxLoading) || $disableFirefoxLoading !== true) { echo '});'; } ?>
		}, 1000);
	};
} else {
	console.log("Invalid browser");
}

<?php } else if($appLoginType == 'clientside') { ?>

	var loggingIn = false;

	// chrome.runtime.sendMessage(editorExtensionId, {removeCookies: <?php echo $cookiesToRemove; ?> },
	// function(response) {
		document.getElementById('appIFrame').src = "<?php echo $url; ?>";
	// });

	$('#appIFrame').one('load', function(){
		
		<?php if(isset($app) && $app == 'sentrian') { ?> setTimeout(function(){ <?php } ?>
		
		var win = document.getElementById("appIFrame").contentWindow;
		var creds = <?php echo $credsJSONArray; ?>;

		win.postMessage(
			creds, "*"
		);

		<?php if(isset($app) && $app == 'healthtap') { ?>

		setTimeout(function(){
			document.getElementById('appIFrame').src = '<?php echo $url; ?>';
			
			$('#appIFrame').one('load', function(){

				$('#appIFrame').css("opacity", "1");
				$('#giffloat2').css("display", "none");

				clearInterval(interval);
			});
		}, 2000);

		<?php } else if(isset($app) && $app == 'PointClickCare') { ?>

		setTimeout(function(){
			document.getElementById('appIFrame').src = '<?php echo $url; ?>';
			
			$('#appIFrame').one('load', function(){

				$('#appIFrame').css("opacity", "1");
				$('#giffloat2').css("display", "none");

				clearInterval(interval);
			});
		}, 2000);

		<?php } else { ?>

		$('#appIFrame').css("opacity", "1");
		$('#giffloat2').css("display", "none");

		clearInterval(interval);

		<?php } ?>

		<?php if(isset($app) && $app == 'sentrian') { ?> }, 2000); <?php } ?>
	});

<?php } ?>

function iterateDots(){
	var el = document.getElementsByClassName("loadingApplication")[0];
	var dotsStr = el.innerHTML;
	var dotsLen = dotsStr.length;

	var maxDots = 3 + 19;
	el.innerHTML = (dotsLen < maxDots ? dotsStr + '.' : 'LOADING APPLICATION');
}

var interval = setInterval("iterateDots()", 300);

</script>