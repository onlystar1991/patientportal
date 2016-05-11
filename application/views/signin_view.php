		<script src="<?php echo base_url();?>assets/scripts/jquery.colorbox.js"></script>

		<script>
		$(document).ready(function() {
			$('input[type=text], input[type=password]').focus(function(){
				$(this).parent('div').addClass('active');
			});

			$('input[type=text], input[type=password]').focusout(function(){
				$(this).parent('div').removeClass('active');
			});

			$('.forgotPasswordForm').submit(function() {
				$('.responseMessage').css({'height': '25px'});
				$('.responseMessage .loadingImage').css({'opacity': '1'});
				$('.responseMessage .message').css({'opacity': '0'});

				$.post( "/user/forgotpassword", { username: $('#forgotPasswordDiv .username input').val(),
					email: $('#forgotPasswordDiv .email input').val() }).done(function(data) {

					$('.responseMessage .loadingImage').css({'opacity': '0'});
					$('.responseMessage .message').css({'opacity': '1'});
					$('.responseMessage .message').html('');

					data = JSON.parse(data);
					console.log(data.errormessages);

					if(data["status"] == "success") {
						$('.responseMessage .message').append('<span>Please check your e-mail for the link</span>');
					} else if(data["status"] == "error") {
						$('.responseMessage .message').append('<span>Error occured</span>');

						$.each(data["errormessages"], function(index, value) {
							$('.responseMessage .message').append('<span>' + value + '</span>');
						});
					}

					$('.responseMessage').css({'height': ($('p.message').height() + 60) + 'px'});
				});

				return false;
			});

			$("a.forgotPasswordLink").colorbox({width:"600px", height:"520px", inline:true});
		}, "json");
		</script>

		<link rel="stylesheet" href="<?=base_url()?>assets/css/signin.css">
		<form action="<?php echo base_url();?>user/login" method="post" accept-charset="utf-8" autocomplete="off">
			<input type="text" style="display:none">
			<input type="password" style="display:none">	
			<ul>
				<li><div class="username"><input type="text" name="username" placeholder="USERNAME"></div></li>
				<li><div class="password"><input type="password" name="password" placeholder="PASSWORD"></div></li>
				<li><input type="submit" class="submitButton" value="SECURE LOGIN"></li>
				<li><a href="<?php echo base_url();?>user/register"><button type="button">CREATE ACCOUNT</button></a></li>
				<li><a href="#forgotPasswordDiv" class="forgotPasswordLink"><span class="forgotPasswordSpan">Forgot Password?</span></a></li>
			</ul>
		</form>
	</div><!-- content -->	
</div><!-- container -->

<div style="display: none">
	<div id='forgotPasswordDiv'>
			<div id="pop">
				<img src="<?php echo base_url();?>assets/images/alex-logo.png">

				<p class="title">FORGOT PASSWORD - RESET</p>

				<div class="responseMessage">
					<img class="loadingImage" src="<?php echo base_url();?>assets/images/loading.gif" border="0" width="27px" height="30px"/>

					<p class="message"></p>
				</div>

				<form class="forgotPasswordForm" action="/user/forgotpassword" method="post" accept-charset="utf-8" autocomplete="off">

					<input type="text" style="display:none">
					<input type="password" style="display:none">
				
					<ul>
						<li><div class="username"><input type="text" name="username" placeholder="USERNAME" required="required"></div></li>
						<li><div class="email"><input type="email" name="email" placeholder="EMAIL ADDRESS" required="required"></div></li>
						<li><input type="submit" class="forgotPasswordSubmitButton" value="SUBMIT"></li>
					</ul>
				</form>
			</div> 
	</div>
</div>

<div id="footer">
	<div id="securityLogos">
		<div id="ssllogo"></div>
		<div id="hipaalogo"></div>
	</div>
</div>

</body>
</html>