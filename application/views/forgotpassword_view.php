		<script src="<?php echo base_url();?>assets/scripts/jquery.colorbox.js"></script>

		<script>
		$(document).ready(function() {
			$('input[type=password]').focus(function(){
				$(this).parent('div').addClass('active');
			});

			$('input[type=password]').focusout(function(){
				$(this).parent('div').removeClass('active');
			});
		});
		</script>

		<link rel="stylesheet" href="<?=base_url()?>assets/css/signin.css">

		<img class="logo" src="<?php echo base_url();?>assets/images/alex-logo.png">

		<?php if($error) { ?>
			<p><?=$errormessage?></p>
		<?php } else { ?>
			<form action="/user/forgotpassword/reset" method="post" accept-charset="utf-8" autocomplete="off">

				<input type="hidden" name="user_id" value="<?=$user_id?>">
				<input type="hidden" name="token" value="<?=$token?>">
			
				<ul>
					<li><div class="password"><input type="password" name="password" placeholder="PASSWORD"></div></li>
					<li><div class="password"><input type="password" name="confirm_password" placeholder="CONFIRM PASSWORD"></div></li>
					<li><input type="submit" class="submitButton" value="RESET PASSWORD"></li>
				</ul>
			</form>
		<?php } ?>

	</div><!-- content -->	
</div><!-- container -->

</body>
</html>