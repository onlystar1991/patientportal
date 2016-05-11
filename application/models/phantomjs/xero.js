var page = require('webpage').create();
var args = require('system').args;

var username = args[1]; var password = args[2];

var fillLoginInfo = function(username, password){
	var frm = document.getElementById("LoginForm");
	frm.elements["userName"].value = username;
	frm.elements["password"].value = password;
	frm.submit();
}

page.onLoadFinished = function(){
	if(page.title.indexOf("Login") > -1) {
		page.evaluate(fillLoginInfo, username, password);
		return;
	}
	else if(page.title.indexOf("Dashboard") > -1)
	{
		console.log(JSON.stringify(phantom.cookies, null, 4));
		phantom.exit();
	}
}

page.open('https://login.xero.com/');
