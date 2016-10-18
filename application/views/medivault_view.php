<link rel="stylesheet" href="<?=base_url()?>assets/css/medivault.css">

<script type="text/javascript" src="<?=base_url()?>assets/scripts/jquery.colorbox.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/scripts/medivault.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/credentials.css">

<script>
	$(document).ready(function() {

		$(".inline").colorbox({iframe: true, innerWidth:'50%', innerHeight:'70%'});  

		$(".inlineButton").click(function(){ 
			$(".inline:first").click();
			return false;
		});
	});
</script>

	<div id="dashboardtitle">Dr. <?php echo $this->session->userdata('user_name'); ?>'s Medivault</div>
	<div class="clear"></div>
	<div id="gearbutton">
		<div id="lock"></div>
		<div id="leftSide">OFF</div>
		<div id="rightSide">ON</div>
	</div>

	<div id="credsVerification" class="inline">
		<?php echo form_open(); ?>
		
		<ul>
			Please verify your identity

			<li>
				<div class="password">
					<input type="password" id="password" name="password" placeholder="PASSWORD" required="required" value="<?php echo set_value('password', @$credentials->password); ?>">
				</div>
			</li>

			<li><input type="submit" value="SUBMIT"></li>
		</ul>

		<?php echo form_close(); ?>
	</div>

	<div id="medivaultblockholder">
		<?php foreach ($allApps as $app) {?>
		<div id="applicationbox">
			<div id="whiteblock">
				<div id="<?=$app?>-app"></div>
			</div>

			<div id="controlsiconholder">
				<a class="inline" href="<?php echo base_url();?>user/credentials/<?=$app?>">
					<div id="controlsicon"><img src="<?=base_url()?>assets/images/controlsgear.png" width="37" height="37" /></div>
				</a>
			</div>
		</div>
		<?php } ?>
	</div>
</div>