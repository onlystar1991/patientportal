		<div class="clear"></div>
	</div><!-- content -->	
</div><!-- container -->
<div id="call-dialog" style="display: none;">
</div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/footer.css">

<div id="footer">
	<div id="button2holder">
		<?php if(!isset($signIn) || $signIn == false) {
			
		$id = $this->session->userdata('user_id');
		$userObject = User_model::init(array('id' => $this->session->userdata('user_id')));

		$userObject->profile_picture = $userObject->profile_picture_from_id($userObject->profile_picture);
		?>
		<div class="profileFooter">
			<img src="/uploads/<?=$userObject->profile_picture?>">
			<ul class="detailsBox">
				<li><?=$userObject->first_name?> <?=$userObject->last_name?></li>
				<li><?=$userObject->office->brand_name?></li>
			</ul>
		</div>
		<button id="button2" class="toggle-menu menu-bottom push-body"></button>
		<a href="<?php echo base_url();?>user/logout"><button id="logoutButton"></button></a>
		<?php } ?>
	</div>
</div>

</body>
</html>