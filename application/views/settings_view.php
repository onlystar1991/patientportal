<script src="<?php echo base_url();?>assets/scripts/tabs_old.js"></script>

<div id="dashboardtitle">User Settings for <?php echo $this->session->userdata('user_name'); ?></div>
<div id="medivaultcontentholder">

	<div id="tabContainer">
<div id="tabcontrolholder">
		<div id="tabs">
			<ul>
				<li id="tabHeader_1">Account Details</li>
				<li id="tabHeader_2">Account Settings</li>
				<!--<li id="tabHeader_3">Page 3</li>-->
			</ul>
		</div>
</div>
		<div id="tabscontent">

			<div class="tabpage" id="tabpage_1">
			
				<p>
					<?php $attributes = array('id' => 'updateform'); ?>
					
					<?php echo form_open("user/settings", $attributes); ?>
			
						<span id="coll1">
							<p>
								<label for="user_name">First Name:</label>
								<input type="text" id="first_name" name="first_name" value="<?php echo set_value('first_name', $first_name); ?>" />
							</p>

							<p>
								<label for="email_address">Last Name</label>
								<input type="text" id="last_name" name="last_name" value="<?php echo set_value('last_name', $last_name); ?>" />
							</p>

							<div style="clear:both"></div>

						</span>

						<span id="coll1">
							<p>
								<label for="office_phone">Office Phone</label>
								<input type="text" id="office_phone" name="office_phone" value="<?php echo set_value('office_phone', $office_phone); ?>" />
							</p>

							<p>
								<label for="cell_phone">Cell Phone</label>
								<input type="text" id="cell_phone" name="cell_phone" value="<?php echo set_value('cell_phone', $cell_phone); ?>" />
							</p>

							<input name="submit" type="submit" value="Update">

							<div style="clear:both"></div>
						</span>
					
					</form>
				</p>
				<div style="clear:both"></div>
			</div>

			<div class="tabpage" id="tabpage_2">

				<p>
					<?php $attributes = array('id' => 'updateform'); ?>
					<?php echo form_open("user/settings", $attributes); ?>
<span id="coll1"><p>
						<label for="user_name">User Name:</label>
						<input type="text" id="user_name" name="user_name" value="<?php echo set_value('user_name', $username); ?>" /></p><p>
				
						<label for="email_address">Your Email:</label>
						<input type="text" id="email_address" name="email_address" value="<?php echo set_value('email_address', $email); ?>" /></p>
				</span>
                
                <span id="coll1"><p>
						<label for="password">Password:</label>
						<input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" /></p>
			<p>
						<label for="con_password">Confirm Password:</label>
						<input type="password" id="con_password" name="con_password" value="<?php echo set_value('con_password'); ?>" />
					</p>
						<input name="submit" type="submit" value="Update">
				</span>
					</form>
				</p>
			</div>
		</div>
	</div>

</div>


</div>

</div>