<?php echo form_open(); ?>

	<img id="app_logo" src="<?php echo base_url();?>assets/images/intacctlogo_05.png">
	
	<ul>

		<li>
			<div class="companyid">
				<input type="text" id="companyid" name="companyid" placeholder="COMPANY ID"
					required="required" value="<?php echo set_value('companyid', @$credentials->intacct_company_id); ?>">
			</div>
		</li>

		<li>
			<div class="userid">
				<input type="text" id="userid" name="userid" placeholder="USER ID"
					required="required" value="<?php echo set_value('userid', @$credentials->intacct_user_id); ?>">
			</div>
		</li>

		<li>
			<div class="password">
				<input type="password" id="password" name="password" placeholder="PASSWORD"
					required="required" value="<?php echo set_value('password', @$credentials->intacct_password); ?>">
			</div>
		</li>

		<li>
			<div class="password">
				<input type="password" id="confirm_password" name="confirm_password" placeholder="CONFIRM PASSWORD">
			</div>
		</li>

		<li class="show_password"><input type="checkbox" class="show_password">Show Password</li>

		<li><input type="radio" name="trial" value="yes"<?php if(@$credentials->trial == true) { echo ' checked'; } ?>>Trial Account<br></li>
		<li><input type="radio" name="trial" value="no"<?php if(@$credentials->trial == false) { echo ' checked'; } ?>>Real Account<br><br></li>

		<li><input type="submit" value="SAVE"></li>
	</ul>

<?php echo form_close(); ?>