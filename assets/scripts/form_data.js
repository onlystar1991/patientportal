$(".view_form_data").click(function(){	
	console.log('clicked');
	$('.first_name.data').html($('input#first_name').val());
	$('.last_name.data').html($('input#last_name').val());
	$('.user_name.data').html($('input#user_name').val());
	$('.email_address.data').html($('input#email_address').val());
	$('.office_phone.data').html($('input#office_phone').val());
	$('.cell_phone.data').html($('input#cell_phone').val());
	$('.user_role.data').html($('#user_role :selected').val());
	$('.office_id.data').html($('input#office_id').val());
});