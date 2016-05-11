<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
<link href="<?php echo base_url();?>assets/admin/vendor/bootstrap-fileinput/jasny-bootstrap.min.css" rel="stylesheet" media="screen">
<link href="<?php echo base_url();?>assets/admin/vendor/select2/select2.min.css" rel="stylesheet" media="screen">
<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?php echo base_url();?>assets/admin/vendor/bootstrap-fileinput/jasny-bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/admin/vendor/select2/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/assets/js/form-elements.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

<div class="main-content" >
	<div class="wrap-content container" id="container">
		<!-- start: USER PROFILE -->
		<div class="container-fluid container-fullw bg-white">
			<div class="row">
				<div class="col-md-12">
					<div class="tabbable">
						<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
							<li class="active">
								<a data-toggle="tab" href="#panel_edit_account">
									Create User
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="panel_edit_account" class="tab-pane fade in active">
								<form action="/admin/users/create" enctype="multipart/form-data" method="POST" role="form" id="form">
									<fieldset>
										<legend>
											Account Info
										</legend>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														Username
													</label>
													<input type="text" class="form-control" id="username" name="username" value="<?php echo set_value('username', ''); ?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														First Name
													</label>
													<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo set_value('first_name', ''); ?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Last Name
													</label>
													<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo set_value('last_name', ''); ?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Email Address
													</label>
													<input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email', ''); ?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Office Phone
													</label>
													<input type="text" class="form-control" id="office_phone" name="office_phone" value="<?php echo set_value('office_phone', ''); ?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Cell Phone
													</label>
													<input type="text" class="form-control" id="cell_phone" name="cell_phone" value="<?php echo set_value('email', ''); ?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Password
													</label>
													<input type="password" class="form-control" name="password" id="password">
												</div>
												<div class="form-group">
													<label class="control-label">
														Confirm Password
													</label>
													<input type="password" class="form-control" id="password_again" name="password_again">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>
														Office
													</label>
													<select class="js-example-basic-single js-states form-control" name="office_id">
														<option value=""></option>
														<?php foreach ($offices as $value) { ?>
														<option value="<?=$value->id?>">
															<?=$value->brand_name?>
														</option>
														<?php } ?>
													</select>
												</div>
												<div class="form-group">
													<label>
														Image Upload
													</label>
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-new thumbnail"><img src="<?=$profile_picture?>" alt="">
														</div>
														<div class="fileinput-preview fileinput-exists thumbnail"></div>
														<div class="user-edit-image-buttons">
															<span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span><span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span>
																<input type="file" name="file">
															</span>
															<a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
																<i class="fa fa-times"></i> Remove
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</fieldset>
									<div class="row">
										<div class="col-md-8">
											<p>
												By clicking UPDATE, you are agreeing to the Policy and Terms &amp; Conditions.
											</p>
										</div>
										<div class="col-md-4">
											<button class="btn btn-primary pull-right" type="submit">
												Create <i class="fa fa-arrow-circle-right"></i>
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end: USER PROFILE -->
	</div>
</div>

<script>
	jQuery(document).ready(function() {
		Main.init();
		FormElements.init();
	});
</script>