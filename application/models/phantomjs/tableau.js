var page = require('webpage').create();
var args = require('system').args;

var email = args[1]; var password = args[2];

var fillLoginInfo = function(email, password){
	$('#email').val(email);
	$('#password').val(password);
	$('input[type=submit]').click();
}

var loginFlag = 0;

page.onLoadFinished = function(){

	if(page.url == "https://sso.online.tableau.com/public/prelogin"
		|| page.url.indexOf("https://auth.tableausoftware.com/user/login") > -1) {
		if(loginFlag < 2) {
			loginFlag++;
			page.injectJs('jquery-2.1.4.min.js');
			page.evaluate(fillLoginInfo, email, password);
			return;
		} else {
			console.log("");
			phantom.exit();
		}
	}
	else if(page.url.indexOf("10ay.online.tableau.com") > -1)
	{
		console.log(JSON.stringify(phantom.cookies, null, 4));
		phantom.exit();
	}
}

page.open('https://sso.online.tableau.com/public/prelogin');
