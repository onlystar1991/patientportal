<!DOCTYPE html>
<!-- Template Name: Clip-Two - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>ALEX Platform X-<?=VERSION?> | Admin Panel</title>
		<!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: GOOGLE FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<!-- end: GOOGLE FONTS -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/vendor/themify-icons/themify-icons.min.css">
		<link href="<?php echo base_url();?>assets/admin/vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo base_url();?>assets/admin/vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo base_url();?>assets/admin/vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<!-- end: MAIN CSS -->
		<!-- start: CLIP-TWO CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/assets/css/styles.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/assets/css/plugins.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/assets/css/themes/theme-1.css" id="skin_color" />
		<!-- end: CLIP-TWO CSS -->
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="<?php echo base_url();?>assets/admin/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/admin/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/admin/vendor/modernizr/modernizr.js"></script>
		<script src="<?php echo base_url();?>assets/admin/vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="<?php echo base_url();?>assets/admin/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="<?php echo base_url();?>assets/admin/vendor/switchery/switchery.min.js"></script>
		<script src="<?php echo base_url();?>assets/admin/assets/js/main.js"></script>

		<script>
			jQuery(document).ready(function() {
				Main.init();
			});
		</script>
		<!-- end: MAIN JAVASCRIPTS -->
	</head>
	<!-- end: HEAD -->
	<body>
		<div id="app">
			<!-- sidebar -->
			<div class="sidebar app-aside" id="sidebar">
				<div class="sidebar-container perfect-scrollbar">
					<nav>
						<!-- start: MAIN NAVIGATION MENU -->
						<div class="navbar-title">
							<span>Main Navigation</span>
						</div>
						<ul class="main-navigation-menu">
							<li>
								<a href="<?php echo base_url();?>admin">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-dashboard"></i>
										</div>
										<div class="item-inner">
											<span class="title">Admin Dashboard</span>
										</div>
									</div>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url();?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-home"></i>
										</div>
										<div class="item-inner">
											<span class="title">ALEX Platform</span>
										</div>
									</div>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url();?>admin/officebrands">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-agenda"></i>
										</div>
										<div class="item-inner">
											<span class="title">Office &amp; Brands</span>
										</div>
									</div>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url();?>admin/users">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-user"></i>
										</div>
										<div class="item-inner">
											<span class="title">Users</span>
										</div>
									</div>
								</a>
							</li>
							<li>
								<a href="<?php echo base_url();?>user/logout">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-unlock"></i>
										</div>
										<div class="item-inner">
											<span class="title">Log Out</span>
										</div>
									</div>
								</a>
							</li>
						</ul>
						<!-- end: MAIN NAVIGATION MENU -->
					</nav>
				</div>
			</div>
			<!-- / sidebar -->
			<div class="app-content">
				<!-- start: TOP NAVBAR -->
				<header class="navbar navbar-default navbar-static-top">
					<!-- start: NAVBAR HEADER -->
					<div class="navbar-header">
						<a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
							<i class="ti-align-justify"></i>
						</a>
						<a class="navbar-brand" href="#">
							ALEX ADMIN
						</a>
						<a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
							<i class="ti-align-justify"></i>
						</a>
					</div>
					<!-- end: NAVBAR HEADER -->
				</header>
				<!-- end: TOP NAVBAR -->
