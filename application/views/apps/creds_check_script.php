<script>
$(document).ready(function() {
	var appsCredsAvailable = <?php echo $appsCredsAvailable; ?>

	$('#whiteblock a').click(function() {
		if(	typeof $(this).attr('app') != 'undefined'
			&& typeof appsCredsAvailable[$(this).attr('app')] != 'undefined'
			&& appsCredsAvailable[$(this).attr('app')] == false ) {
				$(this).parent().parent().find("#controlsiconholder a").click();
				return false;
		}
		
		return true;
	});
});
</script>