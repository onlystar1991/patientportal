<?php echo form_open(); ?>

	<img id="app_logo" src="<?php echo base_url();?>assets/images/transcensuswordpresslogo_05.png"><br>

		Please make sure to add "http://" or "https://" at the beginning of the link and WITHOUT "/" at the end

		<ul id="appsList">

		<?php
			$appsCount = -1;
			$inputBlock = "";

			foreach ($credentials as $value) {

				$appsCount++;

				$inputBlock .= '
			<li>
				<div class="name">
					<input type="text" placeholder="Name" name="apps[' . $appsCount . '][name]" value="'
														. set_value('apps[' . $appsCount . '][name]', $value->name) . '">
				</div>
			</li>

			<li>
				<div class="link">
					<input type="text" placeholder="http://domain.com/" name="apps[' . $appsCount . '][link]" value="'
														. set_value('apps[' . $appsCount . '][link]', $value->link) . '">
				</div>
			</li>

			<li>
				<div class="username">
					<input type="text" placeholder="Username" name="apps[' . $appsCount . '][username]" value="' 
														. set_value('apps[' . $appsCount . '][username]', $value->username) . '">
				</div>
			</li>

			<li>
				<div class="password">
					<input class="password" type="password" placeholder="Password" name="apps[' . $appsCount . '][password]" value="'
														. set_value('apps[' . $appsCount . '][password]', $value->password) . '">
				</div>
			</li>

			<li>
				<div class="link">
					<input type="text" placeholder="Login Page" name="apps[' . $appsCount . '][login]" value="'
														. set_value('apps[' . $appsCount . '][login]', $value->login_url) . '">
				</div>
			</li>

			<br><br>
		';

			}

			echo $inputBlock;
		?>

	</ul>

	<ul>
		<li><div id="AddApp">Add</div></li>

		<li class="show_password"><input type="checkbox" class="show_password">Show Password</li>

		<li><input type="submit"></li>
	</ul>

<?php echo form_close(); ?>

<script>
	var appsNumber = <?php echo $appsCount; ?>;
	
	$(document).ready(function() {
		$('#AddApp').click(function() {
			appsNumber++;
			$('#appsList').append("\
				<li>\
					<div class=\"name\">\
						<input type=\"text\" placeholder=\"Name\" name=\"apps[" + appsNumber + "][name]\">\
					</div>\
				</li>\
\
				<li>\
					<div class=\"link\">\
						<input type=\"text\" placeholder=\"http://domain.com/\" name=\"apps[" + appsNumber + "][link]\">\
					</div>\
				</li>\
\
				<li>\
					<div class=\"username\">\
						<input type=\"text\" placeholder=\"Username\" name=\"apps[" + appsNumber + "][username]\">\
					</div>\
				</li>\
\
				<li>\
					<div class=\"password\">\
						<input class=\"password\" type=\"password\" placeholder=\"Password\" name=\"apps[" + appsNumber + "][password]\">\
					</div>\
				</li>\
\
				<li>\
					<div class=\"link\">\
						<input type=\"text\" placeholder=\"Login Page\" name=\"apps[" + appsNumber + "][login]\">\
					</div>\
				</li>\
\
			<br><br>");
		});
		
	});
</script>