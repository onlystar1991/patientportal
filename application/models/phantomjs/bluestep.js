var page = require('webpage').create();
var args = require('system').args;

var username = args[1]; var password = args[2]; var subdomain = args[3];

var fillLoginInfo = function(username, password){
	$('input#myUserName').val(username);
	$('input#myPassword').val(password);
	$('#myPassword').parent().parent().parent().find('a').find('img').click();
}

page.onLoadFinished = function(){
	if(page.url.indexOf("shared/home.jsp") > -1)
	{
		console.log(JSON.stringify(phantom.cookies, null, 4));
		phantom.exit();
	}
	else {
		page.injectJs('jquery-2.1.4.min.js');
		page.evaluate(fillLoginInfo, username, password);
		return;
	}
}

page.open('https://' + subdomain + '.bluestep.net/');
