<div id="medivaultcontentholder">

	<div id="tabContainer">
		<div id="tabscontent3">

			<?php
				$linksBlock = "";

				foreach ($wordpress as $value) {
					$linksBlock .= '
					<a href="<?php echo base_url();?>app/wordpress/' . $value->name . '" target="_parent">' . $value->name . '</a>';
				}

				echo $linksBlock;
			?>
		<div style="clear:both"></div>
		</div>
	</div>
</div>

<div style="clear:both"></div>