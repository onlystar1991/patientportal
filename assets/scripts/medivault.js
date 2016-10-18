$(document).ready(function(){
	$('#gearbutton').click(function(){
		$("#gearbutton #lock").toggleClass("off");
	});

	$(".inline").colorbox({iframe: true, innerWidth:'50%', innerHeight:'70%'});  

	$(".inlineButton").click(function(){ 
		$(".inline:first").click();
		return false;
	});
});

function verifyUser() {
	$
}