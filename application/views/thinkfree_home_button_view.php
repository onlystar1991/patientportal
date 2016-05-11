<div id="ThinkFreeBackButton" style="position: fixed;
width: 151px;
background: #fff;
right: 0px;
z-index: 99;
cursor: pointer;
bottom: 12%;
font-size: 15px;
padding: 10px;
border: 2px solid #000;
text-align: center;">Thinkfree Dashboard</div>
<script>
$('#ThinkFreeBackButton').click(function() {
    document.getElementById('appIFrame').src = "<?php echo $redirection_url; ?>"
});
</script>