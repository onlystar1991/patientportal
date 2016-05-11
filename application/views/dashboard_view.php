<link rel="stylesheet" href="<?php echo base_url();?>assets/css/dashboard.css">

<div id="dashboardtitle">Welcome Dr. <?php echo $this->session->userdata('user_name'); ?></div>

<div id="mainsectioninside">
	<div id="dashboardContainer">
		<div id="sidebar">
			<ul>
				<a href="#"><li class="cameraButton toggle-menu menu-lua push-body"></li></a>
				<a href="<?php echo base_url();?>app/neocertified"><li class="emailButton"></li></a>
				<a href="#"><li class="formBuildButton"></li></a>
				<a href="<?php echo base_url();?>user/newmedivault"><li class="mediaVaultButton"></li></a>
				<?php if(isset($admin) && $admin == true) { ?><a href="<?php echo base_url();?>admin"><li class="adminButton"></li></a><?php } ?>
				<a href="<?php echo base_url();?>user/settings"><li class="settingsButton"></li></a>
				<?php if(!isset($admin) || $admin == false) { ?><li></li><?php } ?>
			</ul>
		</div>

		<div class="btncol">
			<ul>
				<a href="<?php echo base_url();?>apps/ehr"><li class="ehrButton">ELECTRONIC<br>HEALTH RECORDS (EHR)</li></a>
				<a href="<?php echo base_url();?>apps/storage"><li class="storageButton">COLLABORATION<br/>&amp; STORAGE</li></a>
				<a href="<?php echo base_url();?>apps/financial"><li class="financialButton">FINANCIAL</li></a>
			</ul>
		</div>

		<div class="btncol">
			<ul>
				<a href="<?php echo base_url();?>apps/lgcns"><li class="aslButton">ASSISTED LIVING<br/>CARE SUITE</li></a>
				<a href="<?php echo base_url();?>apps/communications"><li class="communButton">HIPAA SECURE<br/>COMMUNICATIONS</li></a>
				<a href="<?php echo base_url();?>apps/admin"><li class="adminButton">ADMINISTRATION</li></a>
			</ul>
		</div>
		
		<div class="btncol">
			<ul>
				<a href="<?php echo base_url();?>apps/telehealth"><li class="telehealthButton">TELEHEALTH</li></a>
				<a href="<?php echo base_url();?>apps/office"><li class="officeButton">OFFICE<br/>PRODUCTIVITY</li></a>
				<a href="<?php echo base_url();?>apps/pharma"><li class="pharmaButton">PHARMA DISPENSARY<br/>&amp; LAB RESULTS</li></a>
			</ul>
		</div>
	</div>
</div>

<div class="update"><a href="#">UPDATE!</a></div>

<script>
	/*function updateExtension(currentVersion) {
		if(currentVersion < 0.5) { $('.update').css("display", "block"); }
	}*/
</script>
