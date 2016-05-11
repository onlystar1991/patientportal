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
							<li>
								<a data-toggle="tab" href="#panel_overview">
									Overview
								</a>
							</li>
							<li class="active">
								<a data-toggle="tab" href="#panel_edit_account">
									Edit Account
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="panel_overview" class="tab-pane fade">
								<?php echo validation_errors(); ?>
								<div class="row">
									<div class="col-sm-5 col-md-4">
										<div class="user-left">
											<div class="center">
												<h4><?=$user->first_name?> <?=$user->last_name?></h4>
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="user-image">
														<div class="fileinput-new thumbnail"><img src="/uploads/<?=$user->profile_picture?>" alt=""></div>
													</div>
												</div>
												<hr>
											</div>
											<table class="table table-condensed">
												<thead>
													<tr>
														<th colspan="3">Contact Information</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>email:</td>
														<td>
														<a href="">
															<?=$user->email?>
														</a></td>
														<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<tr>
														<td>office phone:</td>
														<td><?=$user->office_phone?></td>
														<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
													<tr>
														<td>cell phone:</td>
														<td><?=$user->cell_phone?></td>
														<td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div id="panel_edit_account" class="tab-pane fade in active">
								<form action="/admin/users/<?=$user->id?>" enctype="multipart/form-data" method="POST" role="form" id="form">
									<fieldset>
										<legend>
											Account Info
										</legend>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														First Name
													</label>
													<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo set_value('first_name', $user->first_name); ?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Last Name
													</label>
													<input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo set_value('last_name', $user->last_name); ?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Email Address
													</label>
													<input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email', $user->email); ?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Office Phone
													</label>
													<input type="text" class="form-control" id="office_phone" name="office_phone" value="<?php echo set_value('office_phone', $user->office_phone); ?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Cell Phone
													</label>
													<input type="text" class="form-control" id="cell_phone" name="cell_phone" value="<?php echo set_value('email', $user->cell_phone); ?>">
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
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>
																Office
															</label>
															<select class="js-example-basic-single js-states form-control" name="office_id">
																<?php foreach ($offices as $value) { ?>
																<option value="<?=$value->id?>"
																		<?php if($user->office->id == $value->id) { ?>selected="selected"<?php } ?>>
																	<?=$value->brand_name?>
																</option>
																<?php } ?>
															</select>
														</div>
														<div class="form-group">
															<label class="control-label">
																Address
															</label>
															<input class="form-control tooltips" type="text" data-rel="tooltip" title=""
																	data-placement="top" name="address" id="address" disabled
																	value="<?php echo set_value('office_address', $user->office->address); ?>">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																City
															</label>
															<input class="form-control tooltips" type="text" data-rel="tooltip" title=""
																	data-placement="top" name="city" id="city" disabled
																	value="<?php echo set_value('office_city', $user->office->city); ?>">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																State
															</label>
															<input class="form-control tooltips" type="text" data-rel="tooltip" title=""
																	data-placement="top" name="state" id="state" disabled
																	value="<?php echo set_value('office_state', $user->office->state); ?>">
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label">
																Zip Code
															</label>
															<input class="form-control" type="text" name="zipcode" id="zipcode" disabled
																	value="<?php echo set_value('office_zip_code', $user->office->zip_code); ?>">
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>
														Image Upload
													</label>
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<div class="fileinput-new thumbnail"><img src="/uploads/<?=$user->profile_picture?>" alt="">
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
												Update <i class="fa fa-arrow-circle-right"></i>
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

	offices = [];

	<?php foreach ($offices as $value) { ?>
		offices[<?=$value->id?>] = ["<?=htmlspecialchars($value->address)?>",
									"<?=htmlspecialchars($value->city)?>",
									"<?=htmlspecialchars($value->state)?>",
									"<?=htmlspecialchars($value->zip_code)?>"];
	<?php } ?>

	$('select').on('change', function() {
		$('input#address').val(offices[this.value][0]);
		$('input#city').val(offices[this.value][1]);
		$('input#state').val(offices[this.value][2]);
		$('input#zipcode').val(offices[this.value][3]);
	});
</script>
