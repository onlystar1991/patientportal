<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/dropzone.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/register.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/dropzone.css">

<script>

	currentFieldset = 0;

	$(document).ready(function() {
		$('input[type=text], input[type=password]').focus(function(){
			$(this).parent('div').addClass('active');
		});

		$('input[type=text], input[type=password]').focusout(function(){
			$(this).parent('div').removeClass('active');
		});

		$('button.next').click(function(){
			if($(this).hasClass('submit')) {
				$('#msform').submit();
				return true;
			}

			$('fieldset').css({'margin': '0 -150%'});
			currentFieldset++;

			$($('fieldset')[currentFieldset]).css({'margin': '0 10%'});

			$('#stepsTableArrow').css({'left': (51.5 + (121 * currentFieldset)) + 'px'});
		});

		$('button.previous').click(function(){
			$('fieldset').css({'margin': '0 -80%'});
			currentFieldset--;

			$($('fieldset')[currentFieldset]).css({'margin': '0 10%'});

			$('#stepsTableArrow').css({'left': (51.5 + (121 * currentFieldset)) + 'px'});
		});

		var myDropzone = new Dropzone("div#dropzone", { url: "/user/upload_file",
													maxFilesize: 2,
													maxFiles: 1,
													addRemoveLinks: true });

		myDropzone.on("success", function(file, response) {
			$('input[name="profile_picture"]').val(response);
		});
	});
</script>

<img class="logo" src="<?php echo base_url();?>assets/images/alex-logo.png">

<p class="title">CREATE ACCOUNT</p>

<table id="stepsTable">
	<tr>
		<td><img src="<?php echo base_url();?>assets/images/regsectionicons_29.png"></td>
		<td><img src="<?php echo base_url();?>assets/images/regsectionicons_31.png"></td>
		<td><img src="<?php echo base_url();?>assets/images/regsectionicons_33.png"></td>
		<td><img src="<?php echo base_url();?>assets/images/regsectionicons_35.png"></td>
		<td><img src="<?php echo base_url();?>assets/images/regsectionicons_37.png"></td>
		<td id="stepsTableArrow"><img src="<?php echo base_url();?>assets/images/regsection_arrow_64.png"></td>
	</tr>
</table>

	<?php echo form_open("user/register", array('id' => 'msform')); ?>

		<fieldset>

			<div class="field username">
				<input type="text" name="user_name"
					placeholder="USER NAME" value="<?php echo set_value('user_name'); ?>" />
			</div>

			<div class="field email">
				<input type="text" name="email_address"
					placeholder="EMAIL ADDRESS" value="<?php echo set_value('email_address'); ?>" />
			</div>

			<div class="field firstname">
				<input type="text" name="first_name"
					placeholder="FIRST NAME" value="<?php echo set_value('first_name'); ?>" />
			</div>

			<div class="field lastname">
				<input type="text" name="last_name"
					placeholder="LAST NAME" value="<?php echo set_value('last_name'); ?>" />
			</div>

			<div class="field password">
				<input type="password" name="password"
					placeholder="PASSWORD" value="<?php echo set_value('password'); ?>" />
			</div>
	
			<div class="field password">
				<input type="password" name="con_password"
					placeholder="CONFIRM PASSWORD" value="<?php echo set_value('con_password'); ?>" />
			</div>

			<div class="button-container"><button class="next" type="button">Next Step</button></div>

		</fieldset>

		<fieldset>
			<div class="field office_phone">
				<input type="text" name="office_phone"
					placeholder="OFFICE PHONE" value="<?php echo set_value('office_phone'); ?>" />
			</div>

			<div class="field cell_phone">
				<input type="text" id="cell_phone" name="cell_phone"
					placeholder="CELL PHONE" value="<?php echo set_value('cell_phone'); ?>" />
			</div>

			<div class="field user_role">
				<select name="user_role" value="<?php echo set_value('user_role'); ?>">
					<option value="" selected="selected">USER ROLE</option>
					<option value="1">Doctor</option>
					<option value="1">Nurse</option>
					<option value="1">Office Manager</option>
				</select>
			</div>

			<div class="field office_id">
				<input type="text" name="office_id"
					placeholder="OFFICE ID" value="<?php echo set_value('office_id'); ?>" />
			</div>
			
			<div class="button-container">
				<button class="previous" type="button">Previous Step</button>
				<button class="next" type="button">Next Step</button>
			</div>
		</fieldset>

		<fieldset>
			Some data
			
			<button class="previous" type="button">Previous Step</button>
			<button class="next" type="button">Next Step</button>
		</fieldset>

		<fieldset>
			<div>
				Profile Picture
			</div>

			<input type="hidden" name="profile_picture" value="">

			<div id="dropzone" class="alex-dropzone">
				<div class="dz-message" data-dz-message><span>Click here to upload profile picture<br/>Dimensions should be 150px X 150px</span></div>
			</div>

			<button class="previous" type="button">Previous Step</button>
			<button class="next" type="button">Next Step</button>
		</fieldset>

		<fieldset>
			<div id="regformtitle">Please Review the Information Below.</div>  
	
			<div id="reviewinfo">
				<span class="first_name label"></span>First Name: <div class="userinforev"><span class="first_name data"></span></div><br />
				<span class="last_name label"></span>Last Name: <div class="userinforev"><span class="last_name data"></span></div><br />
				<span class="user_name label"></span>User Name: <div class="userinforev"><span class="user_name data"></span></div><br />
				<span class="email_address label"></span>Email Address: <div class="userinforev"><span class="email_address data"></span></div><br />
				<span class="office_phone label"></span>Office Phone: <div class="userinforev"><span class="office_phone data"></span></div><br />
				<span class="cell_phone label"></span>Cell Phone: <div class="userinforev"><span class="cell_phone data"></span></div><br />
				<span class="user_role label"></span>Role: <div class="userinforev"><span class="user_role data"></span></div><br />
				<span class="office_id label"></span>Office ID: <div class="userinforev"><span class="office_id data"></div>
			</div>

			<div style="clear:both"></div>

			<button class="previous" style="top: 270px;" type="button">Previous Step</button>
			<button class="next submit" type="button">Submit</button>
		</fieldset>

	<?php echo form_close(); ?>

	<?php echo validation_errors('<p class="error">'); ?>
	
<div style="clear:both"></div>