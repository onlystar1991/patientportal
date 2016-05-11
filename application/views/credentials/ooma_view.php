<?php echo form_open(); ?>

	<img id="app_logo" src="<?php echo base_url();?>assets/images/ooma_logo_05.png">
	
	<ul>
		<li>
			<div class="phone">
				<input type="text" name="phone" placeholder="PHONE NUMBER"
					required="required" value="<?php echo set_value('phone', @$credentials->phone); ?>">
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