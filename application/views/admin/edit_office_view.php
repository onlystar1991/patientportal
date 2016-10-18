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
									Edit Office
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="panel_edit_account" class="tab-pane fade in active">
								<form enctype="multipart/form-data" method="POST" role="form" id="form">
									<fieldset>
										<legend>
											Office Info
										</legend>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														Office ID
													</label>
													<input type="text" class="form-control" id="office_id" name="office_id" value="<?=$office->office_id?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Name
													</label>
													<input type="text" class="form-control" id="brand_name" name="brand_name" value="<?=$office->brand_name?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Address
													</label>
													<input type="text" class="form-control" id="address" name="address" value="<?=$office->address?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														City
													</label>
													<input type="text" class="form-control" id="city" name="city" value="<?=$office->city?>">
												</div>
												<div class="form-group">
													<label>
														State
													</label>
													<select class="js-example-basic-single js-states form-control" name="state">
														<option value=""></option>
														<optgroup label="Alaskan/Hawaiian Time Zone">
															<option value="AK" <?php if($office->state == "AK") { ?> selected="selected"<?php } ?>>Alaska</option>
															<option value="HI" <?php if($office->state == "HI") { ?> selected="selected"<?php } ?>>Hawaii</option>
														</optgroup>
														<optgroup label="Pacific Time Zone">
															<option value="CA" <?php if($office->state == "CA") { ?> selected="selected"<?php } ?>>California</option>
															<option value="NV" <?php if($office->state == "NV") { ?> selected="selected"<?php } ?>>Nevada</option>
															<option value="OR" <?php if($office->state == "OR") { ?> selected="selected"<?php } ?>>Oregon</option>
															<option value="WA" <?php if($office->state == "WA") { ?> selected="selected"<?php } ?>>Washington</option>
														</optgroup>
														<optgroup label="Mountain Time Zone">
															<option value="AZ" <?php if($office->state == "AZ") { ?> selected="selected"<?php } ?>>Arizona</option>
															<option value="CO" <?php if($office->state == "CO") { ?> selected="selected"<?php } ?>>Colorado</option>
															<option value="ID" <?php if($office->state == "ID") { ?> selected="selected"<?php } ?>>Idaho</option>
															<option value="MT" <?php if($office->state == "MT") { ?> selected="selected"<?php } ?>>Montana</option>
															<option value="NE" <?php if($office->state == "NE") { ?> selected="selected"<?php } ?>>Nebraska</option>
															<option value="NM" <?php if($office->state == "NM") { ?> selected="selected"<?php } ?>>New Mexico</option>
															<option value="ND" <?php if($office->state == "ND") { ?> selected="selected"<?php } ?>>North Dakota</option>
															<option value="UT" <?php if($office->state == "UT") { ?> selected="selected"<?php } ?>>Utah</option>
															<option value="WY" <?php if($office->state == "WY") { ?> selected="selected"<?php } ?>>Wyoming</option>
														</optgroup>
														<optgroup label="Central Time Zone">
															<option value="AL" <?php if($office->state == "AL") { ?> selected="selected"<?php } ?>>Alabama</option>
															<option value="AR" <?php if($office->state == "AR") { ?> selected="selected"<?php } ?>>Arkansas</option>
															<option value="IL" <?php if($office->state == "IL") { ?> selected="selected"<?php } ?>>Illinois</option>
															<option value="IA" <?php if($office->state == "IA") { ?> selected="selected"<?php } ?>>Iowa</option>
															<option value="KS" <?php if($office->state == "KS") { ?> selected="selected"<?php } ?>>Kansas</option>
															<option value="KY" <?php if($office->state == "KY") { ?> selected="selected"<?php } ?>>Kentucky</option>
															<option value="LA" <?php if($office->state == "LA") { ?> selected="selected"<?php } ?>>Louisiana</option>
															<option value="MN" <?php if($office->state == "MN") { ?> selected="selected"<?php } ?>>Minnesota</option>
															<option value="MS" <?php if($office->state == "MS") { ?> selected="selected"<?php } ?>>Mississippi</option>
															<option value="MO" <?php if($office->state == "MO") { ?> selected="selected"<?php } ?>>Missouri</option>
															<option value="OK" <?php if($office->state == "OK") { ?> selected="selected"<?php } ?>>Oklahoma</option>
															<option value="SD" <?php if($office->state == "SD") { ?> selected="selected"<?php } ?>>South Dakota</option>
															<option value="TX" <?php if($office->state == "TX") { ?> selected="selected"<?php } ?>>Texas</option>
															<option value="TN" <?php if($office->state == "TN") { ?> selected="selected"<?php } ?>>Tennessee</option>
															<option value="WI" <?php if($office->state == "WI") { ?> selected="selected"<?php } ?>>Wisconsin</option>
														</optgroup>
														<optgroup label="Eastern Time Zone">
															<option value="CT" <?php if($office->state == "CT") { ?> selected="selected"<?php } ?>>Connecticut</option>
															<option value="DE" <?php if($office->state == "DE") { ?> selected="selected"<?php } ?>>Delaware</option>
															<option value="FL" <?php if($office->state == "FL") { ?> selected="selected"<?php } ?>>Florida</option>
															<option value="GA" <?php if($office->state == "GA") { ?> selected="selected"<?php } ?>>Georgia</option>
															<option value="IN" <?php if($office->state == "IN") { ?> selected="selected"<?php } ?>>Indiana</option>
															<option value="ME" <?php if($office->state == "ME") { ?> selected="selected"<?php } ?>>Maine</option>
															<option value="MD" <?php if($office->state == "MD") { ?> selected="selected"<?php } ?>>Maryland</option>
															<option value="MA" <?php if($office->state == "MA") { ?> selected="selected"<?php } ?>>Massachusetts</option>
															<option value="MI" <?php if($office->state == "MI") { ?> selected="selected"<?php } ?>>Michigan</option>
															<option value="NH" <?php if($office->state == "NH") { ?> selected="selected"<?php } ?>>New Hampshire</option>
															<option value="NJ" <?php if($office->state == "NJ") { ?> selected="selected"<?php } ?>>New Jersey</option>
															<option value="NY" <?php if($office->state == "NY") { ?> selected="selected"<?php } ?>>New York</option>
															<option value="NC" <?php if($office->state == "NC") { ?> selected="selected"<?php } ?>>North Carolina</option>
															<option value="OH" <?php if($office->state == "OH") { ?> selected="selected"<?php } ?>>Ohio</option>
															<option value="PA" <?php if($office->state == "PA") { ?> selected="selected"<?php } ?>>Pennsylvania</option>
															<option value="RI" <?php if($office->state == "RI") { ?> selected="selected"<?php } ?>>Rhode Island</option>
															<option value="SC" <?php if($office->state == "SC") { ?> selected="selected"<?php } ?>>South Carolina</option>
															<option value="VT" <?php if($office->state == "VT") { ?> selected="selected"<?php } ?>>Vermont</option>
															<option value="VA" <?php if($office->state == "VA") { ?> selected="selected"<?php } ?>>Virginia</option>
															<option value="WV" <?php if($office->state == "WV") { ?> selected="selected"<?php } ?>>West Virginia</option>
														</optgroup>
													</select>
												</div>
												<div class="form-group">
													<label class="control-label">
														ZIP Code
													</label>
													<input type="text" class="form-control" id="zip_code" name="zip_code" value="<?=$office->zip_code?>">
												</div>
												<div class="form-group">
													<label class="control-label">
														Phone
													</label>
													<input type="text" class="form-control" id="phone" name="phone" value="<?=$office->phone?>">
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
</script>