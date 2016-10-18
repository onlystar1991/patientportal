<!DOCTYPE html>
<html class="no-js">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="<?php if(isset($this->description)) echo $this->description; else echo "ALEX - Assisted Living Evolution X1"; ?>" />
		<meta name="keywords" content="ALEX - Assisted Living Evolution X1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
		<meta name="HandheldFriendly" content="true">
		<title>ALEX Platform X-<?=VERSION?><?php if(isset($title)) echo " | " . $title; ?></title>
		<link rel="author" href="<?php echo base_url();?>humans.txt" />
		<link rel="canonical" href="https://ideskmd.com/" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

		<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-1.9.1.min.js" type="text/javascript"></script>

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css">
		<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/rightSidebar.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/notify.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>assets/scripts/jquery-ui.js"></script>
		
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '<?=GOOGLE_ANALYTICS_ID?>']);
			_gaq.push(['_trackPageview']);
			_gaq.push(['_setCustomVar', 1, 'X',
				<?php if($_SERVER['REMOTE_ADDR'] == '52.8.249.49') { ?> 'ev3YuYs2MW3W' <?php } else { ?> 'H6n7RPhXDbaG' <?php } ?>,
			1]);
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	</head>
	<body class="pushmenu-push">
		<div id="container">
			<div id="content">
				<div id="header">
					<div id="logo"></div>
					<?php if(!isset($signIn) || $signIn == false) { ?>
					<div id="topicons">
						<?php if(!(isset($title) && $title == "Welcome")) { ?><button class="rightSidebarButton"></button><?php } ?>
						<div id="LuaNotificationsIndicator">?</div>
					</div>

					<div id="buttonboxback">
						<?php if(!(isset($title) && $title == "Welcome")) { ?><a href="<?php echo base_url();?>"><button class="backButton"></button></a><?php } ?>
					</div>
					<?php } ?>
				</div>
				<?php if(!isset($signIn) || $signIn == false) { $this->load->view('controls_view', $controls_view); } ?>
