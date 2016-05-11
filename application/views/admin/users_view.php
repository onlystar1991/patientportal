<div class="main-content" >
	<div class="wrap-content container" id="container">
		<!-- start: BASIC TABLE -->
			<div class="container-fluid container-fullw bg-white">
				<div class="row">
					<div class="col-md-12">
						<a href="<?php echo base_url();?>admin/users/create"><button type="button" class="btn btn-wide btn-o btn-primary pull-right">Create User</button></a>
						<table class="table table-hover" id="sample-table-1">
							<thead>
								<tr>
									<th class="center">Username</th>
									<th>First Name</th>
									<th class="hidden-xs">Last Name</th>
									<th>User Role</th>
									<th>Office</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($users as $user) { ?>
								<tr>
									<td class="center"><?=$user->username?></td>
									<td class="hidden-xs"><?=$user->first_name?></td>
									<td><?=$user->last_name?></td>
									<td><?=$user->user_role?></td>
									<td><?=$user->office->brand_name?></td>
									<td class="center">
									<div class="visible-md visible-lg hidden-sm hidden-xs">
										<a href="<?php echo base_url();?>admin/users/<?=$user->id?>" class="btn btn-transparent btn-xs" tooltip-placement="top" tooltip="Edit"><i class="fa fa-pencil"></i></a>
										<a href="#" class="btn btn-transparent btn-xs tooltips" tooltip-placement="top" tooltip="Remove"><i class="fa fa-times fa fa-white"></i></a>
									</div>
									<div class="visible-xs visible-sm hidden-md hidden-lg">
										<div class="btn-group" dropdown is-open="status.isopen">
											<button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" dropdown-toggle>
												<i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
											</button>
											<ul class="dropdown-menu pull-right dropdown-light" role="menu">
												<li>
													<a href="<?php echo base_url();?>admin/users/<?=$user->id?>">
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
