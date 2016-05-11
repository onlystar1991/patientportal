<?php echo form_open(); ?>

	<img id="app_logo" src="<?php echo base_url();?>assets/images/ehrsoftwarelogos2_31.png"><br>

	<ul>
		<input type="radio" name="LoginType" value="email"
			<?php echo set_radio('LoginType', 'email', @$credentials->usesEmailForLogin); ?>>E-mail
		<br>

		<input type="radio" name="LoginType" value="id"
			<?php echo set_radio('LoginType', 'id', !@$credentials->usesEmailForLogin); ?>>PracticeFusion ID
		<br><br>

		<li class="email">
			<div class="email">
				<input type="email" name="email" placeholder="E-MAIL ADDRESS"
					value="<?php if(isset($credentials->usesEmailForLogin) && $credentials->usesEmailForLogin) {
							echo set_value('email', @$credentials->login);
						} else { echo set_value('email', ''); } ?>">
			</div>
		</li>

		<li class="id">
			<div class="username">
				<input type="text" name="username" placeholder="USERNAME"
					value="<?php if(isset($credentials->usesEmailForLogin) && !$credentials->usesEmailForLogin) {
							echo set_value('username', @$credentials->login);
						} else { echo set_value('username', ''); } ?>">
			</div>
		</li>

		<li class="id">
			<div class="id">
				<input type="text" name="practicefusion_id" placeholder="ID"
					value="<?php echo set_value('id', @$credentials->practicefusion_id); ?>">
			</div>
		</li>

		<li>
			<div class="password">
				<input type="password" id="password" name="password" placeholder="PASSWORD"
					required="required" value="<?php echo set_value('password', @$credentials->password); ?>">
			</div>
		</li>

		<li>
			<div class="password">
				<input type="password" id="confirm_password" name="confirm_password" placeholder="CONFIRM PASSWORD">
			</div>
		</li>

		<li class="show_password"><input type="checkbox" class="show_password">Show Password</li>

		<li><input type="submit" value="SAVE"></li>
	</ul>

<?php echo form_close(); ?>

<script>
	$(document).ready(function() {
		if($('form input[type=radio]:checked').val() == 'id') {
			$('.email').css('display', 'none');
		} else {
			$('.id').css('display', 'none');
		}

		$('input[type=radio]').change(function() {       
			if(this.value == 'id') {
				$('.email').css('display', 'none');
				$('.id').css('display', 'inline-block');
			} else {
				$('.email').css('display', 'inline-block');
				$('.id').css('display', 'none');
			}
		});
	});
</script>