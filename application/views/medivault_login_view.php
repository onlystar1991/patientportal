<html>

<head>
	<link rel="stylesheet" href="<?=base_url()?>assets/css/credentials.css">

	<script type="text/javascript" src="<?=base_url()?>assets/scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/scripts/jquery.form.js" type="text/javascript"></script>

	<script>
		$(document).ready(function() {
			$('form').ajaxForm(function(e) {
				e = JSON.parse(e);

				if(e.status == "failed") {
					/* Do what here? */
				} else if(e.status == "success") {
					console.log("success, I guess")
					parent.location.href = parent.location.href;
				}

				return false;
			}); 
		});
	</script>
</head>

<body>
	<div id="medivaultcontentholder">

		<div id="tabContainer">
			<div id="tabscontent3">
				<?php echo form_open(); ?>

					<img id="app_logo" src="<?php echo base_url();?>assets/images/alex-logo.png">
					
					<ul>
						<li>
							<div class="password">
								<input type="password" id="password" name="password" placeholder="PASSWORD" required="required" value="<?php echo set_value('password', @$credentials->password); ?>">
							</div>
						</li>

						<li><input type="submit" value="SAVE"></li>
					</ul>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</body>

</html>