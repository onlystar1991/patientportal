<?php if($gears == false) //Leave it as ==. $gears is stored in the database as a string, either "0" or "1"
	{ ?> <style>#controlsicon { display: none; }</style> <?php } ?>

<div id="dashboardtitle"><?php echo $title; ?></div>

<div id="mainsectioninside-appholder">
	<div id="blockholder">

		<?php

		$applicationbox = "";
		$wordpress = "";

		foreach ($apps as $value) {

			$wordpress = "";			
			if($value == "wordpress") { $wordpress = ' class="inline"'; }

			?>

		<div id="applicationbox">

			<div id="whiteblock">
				<a href="<?php echo base_url();?>app/<?=$value?>" app="<?=$value?>" <?php echo $wordpress; ?>><div id="<?=$value?>-app"></div></a>
			</div>

			<div id="controlsiconholder">
				<a class="inline" href="<?php echo base_url();?>user/credentials/<?=$value?>"></a>
			</div>

		</div>

		<?php } ?>

	</div>
</div>

<script src="<?=base_url()?>assets/scripts/jquery.colorbox.js"></script>

<script>
	$(document).ready(function() {

		$(".inline").colorbox({iframe: true, innerWidth:'50%', innerHeight:'70%'});  

		$(".inlineButton").click(function(){ 
			$(".inline:first").click();
			return false;
		});
	});
</script>

</div>	