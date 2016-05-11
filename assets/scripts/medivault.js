$(document).ready(function(){
	$('#gearbutton').click(function(){
		if($("#gearbutton #lock").hasClass("on")) {

		} else if($("#gearbutton #lock").hasClass("off")) {
			$.colorbox({
				width:"80%",
				height:"80%",
				iframe:true,
				href:"/user/verify_creds"
			});
		}

		$("#gearbutton #lock").toggleClass("off");
	});

	$(".inline").colorbox({iframe: true, innerWidth:'50%', innerHeight:'70%'});

	$(".inlineButton").click(function(){ 
		$(".inline:first").click();
		return false;
	});
});
