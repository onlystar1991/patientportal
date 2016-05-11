<html>

<head>

	<link rel="stylesheet" href="<?=base_url()?>assets/css/credentials.css">

	<script type="text/javascript" src="<?=base_url()?>assets/scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/scripts/jquery.form.js" type="text/javascript"></script>
	
	<script>
		$(document).ready(function() {
			$('input.show_password').change(function() {
				var isChecked = $(this).is(':checked');
				if(isChecked == true) {
					$('div.password input').attr('type', 'text');
				} else {
					$('div.password input').attr('type', 'password');
				}
			});

			$('form').ajaxForm(function() { 
				parent.location.href = parent.location.href;
			}); 
		});
	</script>

</head>

<body>
	<div id="medivaultcontentholder">

		<div id="tabContainer">
			<div id="tabscontent3">
				<?=$form?>
			</div>
		</div>
	</div>
</body>

</html>