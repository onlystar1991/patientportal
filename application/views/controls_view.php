<link rel="stylesheet" href="<?php echo base_url();?>assets/css/slider.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/idangerous/css/swiper.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/controls.css">

<script src="<?php echo base_url();?>assets/scripts/jPushMenu.js"></script>
<script src="<?php echo base_url();?>assets/vendor/idangerous/js/swiper.min.js"></script>

<script>

window.onmessage = function(e){
	if(e.data[0] == "Lua" && e.data[1] == "MessageClicked") {
		$(".cbp-spmenu-lua").addClass("cbp-spmenu-lua-expanded");
		$("#LuaBlackBackground").addClass("active");
	} else if(e.data[0] == "LuaMessages") {
		$("#LuaLoading").removeClass("active");

		if(e.data[1] == 0) {
			$("#LuaNotificationsIndicator").removeClass("active");
		} else {
			$("#LuaNotificationsIndicator").addClass("active");
			$('#LuaNotificationsIndicator').text(e.data[1]);
		}
	}
};

$(document).ready(function() {
	$('body').click(function() {
		$("#LuaBlackBackground").removeClass("active");
		if(!$("#videoCallWindow").hasClass("active")) {
			$("#conversationContainer").removeClass("expanded");
		}
		$("#conversationContainer").removeClass("contacts");
	});

	$('#exitButton').click(function() {
		$("#LuaBlackBackground").removeClass("active");
		if(!$("#videoCallWindow").hasClass("active")) {
			$("#conversationContainer").removeClass("expanded");
		}
		$("#conversationContainer").removeClass("contacts");
		$('body').click();
	});

	$('#contactsButton').click(function() {
		if($('#chatContactsList').hasClass("active")) {
			if(!$("#videoCallWindow").hasClass("active")) {
				$("#conversationContainer").removeClass("expanded");
			}
			$("#conversationContainer").removeClass("contacts");
			$("#chatContactsList").removeClass("active");
			$(this).removeClass("active");
		} else {
			$("#conversationContainer").addClass("expanded");
			$("#conversationContainer").addClass("contacts");
			$("#chatContactsList").addClass("active");
			$('#conversationMenu #contactsButton').addClass("active");
		}
	});

	$('#videoChatButton').click(function() {
		$("#conversationContainer .section").removeClass("active");
		$("#conversationContainer").removeClass();
		$('#chatButton, #contactsButton').removeClass('active');
		$("#conversationContainer").addClass("expanded");
		$("#videoCallWindow").addClass("active");
		$(this).addClass('active');
	});

	$('.cameraButton.toggle-menu.menu-lua.push-body').click(function() {
		$("#LuaBlackBackground").toggleClass("active");
		if(!$("#videoCallWindow").hasClass("active")) {
			$("#conversationContainer").removeClass("expanded");
		}
	});

	$('#chatButton').click(function() {
		$("#conversationContainer").removeClass();
		$('#conversationContainer .active').removeClass('active')
		$('#chatWindow').addClass('active');
		$('#latestConversations').addClass('active');
		$(this).addClass('active');
	});

	$('#videoChatButton').click(function() {
		$("#conversationContainer").removeClass();
		$('#conversationContainer .active').removeClass('active')
		$("#conversationContainer").addClass("expanded");
		$("#videoCallWindow").addClass("active");
		$(this).addClass('active');
	});

	$('#audioCallButton').click(function() {
		$("#conversationContainer").removeClass();
		$('#conversationContainer .active').removeClass('active')
		$("#conversationContainer").addClass("expanded");
		$("#audioCallWindow").addClass("active");
		$(this).addClass('active');
	});

	$(".addContactButton").click(function() {
		console.log($(this).parent().find(".callContactsList"));
		$(this).parent().find(".callContactsList").toggleClass("active");
	});

	$('.toggle-menu').jPushMenu();

	var mySwiper = new Swiper ('.swiper-container', {
		// Optional parameters
		direction: 'horizontal',
		loop: true,
		centeredSlides: true,
		slidesPerView: 'auto',
		spaceBetween: 50
	});
});

</script>

<div id="LuaBlackBackground"></div>

<?php if(!(isset($title) && $title == "Welcome")) { ?>
<!--Right sidebar-->
<div class="rightSidebar">
	<div class="sidebar">
		<ul>
			<a href="#"><li class="cameraButton toggle-menu menu-lua push-body"></li></a>
			<a href="<?php echo base_url();?>app/neocertified"><li class="emailButton"></li></a>
			<a href="#"><li class="formBuildButton"></li></a>
			<a href="<?php echo base_url();?>user/newmedivault"><li class="mediaVaultButton"></li></a>
			<?php if(isset($admin) && $admin == true) { ?><a href="<?php echo base_url();?>admin"><li class="adminButton"></li></a><?php } ?>
			<a href="<?php echo base_url();?>user/settings"><li class="settingsButton"></li></a>
		</ul>
	</div>
</div>
<?php } ?>

<!--Lua menu-->
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-lua">
	<?php $this->load->view('conversation/index'); ?>
	<?php $this->load->view('conversation/chat'); ?>
	<?php $this->load->view('conversation/videoChat'); ?>
	<?php $this->load->view('conversation/audioChat'); ?>
</nav>

<!--Bottom menu-->
<nav class="cbp-spmenu cbp-spmenu-horizontal cbp-spmenu-bottom">
	<!-- Slider main container -->
	<div class="swiper-container">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			<!-- Slides -->
			
			<?php
				foreach ($user_apps as $app) {
					if($app->credentials !== false) {
						$appClass = get_class($app);
						?>
							<div class="swiper-slide">
								<div id="whiteblock">
									<a href="<?php echo base_url();?>app/<?php echo $appClass::$name; ?>"><div id="<?php echo $appClass::$name; ?>-app"></div></a>
								</div>
							</div>
				<?php
					}
				}
				?>
		</div>
	</div>
</nav>