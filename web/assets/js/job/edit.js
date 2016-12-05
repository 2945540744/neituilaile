$(document).ready(function(){
	//init selects
	$('.mobileSelect').mobileSelect({
		style: 'btn-link'
	});

	//TODO 给表单添加jquery validation
	var validator = $('#post-form').validate({

	});
	//update post
	$('.js-btn-edit').off('click').on('click', function(){
		// if(validator.form()){
			$('#post-form').submit();	
		// }
	});	
});
