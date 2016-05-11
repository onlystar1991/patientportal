<div class="main-content" >
	<div class="wrap-content container" id="container">
		<!-- start: BASIC TABLE -->
			<div class="container-fluid container-fullw bg-white">
				<div class="row">
					<div class="col-md-12">
						<a href="<?php echo base_url();?>admin/officebrands/create"><button type="button" class="btn btn-wide btn-o btn-primary pull-right">Create Office</button></a>
						<table class="table table-hover" id="sample-table-1">
							<thead>
								<tr>
									<th class="center">#</th>
									<th>Brand Name</th>
									<th class="hidden-xs">Address</th>
									<th>City</th>
									<th class="hidden-xs">State</th>
									<th>Zip Code</th>
									<th>Phone</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($offices as $office) { ?>
								<tr>
									<td class="center"><?=$office->office_id?></td>
									<td class="hidden-xs"><?=$office->brand_name?></td>
									<td><?=$office->address?></td>
									<td><?=$office->city?></td>
									<td class="hidden-xs"><?=$office->state?></td>
									<td class="hidden-xs"><?=$office->zip_code?></td>
									<td class="hidden-xs"><?=$office->phone?></td>
									<td class="center">
									<div class="visible-md visible-lg hidden-sm hidden-xs">
										<a href="<?php echo base_url();?>admin/officebrands/<?=$office->id?>" class="btn btn-transparent btn-xs" tooltip-placement="top" tooltip="Edit"><i class="fa fa-pencil"></i></a>
										<a href="#" class="btn btn-transparent btn-xs tooltips" tooltip-placement="top" tooltip="Remove"><i class="fa fa-times fa fa-white"></i></a>
									</div>
									<div class="visible-xs visible-sm hidden-md hidden-lg">
										<div class="btn-group" dropdown is-open="status.isopen">
											<button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" dropdown-toggle>
												<i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
											</button>
											<ul class="dropdown-menu pull-right dropdown-light" role="menu">
												<li>
													<a href="<?php echo base_url();?>admin/officebrands/<?=$office->id?>">
														Edit
													</a>
												</li>
												<li>
													<a href="#">
														Remove
													</a>
												</li>
											</ul>
										</div>
									</div></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- end: BASIC TABLE -->
	</div>
</div>

<script src="<?php echo base_url();?>assets/admin/assets/js/officebrands.js"></script>
