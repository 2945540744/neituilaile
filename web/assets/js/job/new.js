$(document).ready(function(){
	//TODO 给表单添加jquery validation
	var validator = $('#post-form').validate({

	});
	//new/update post
	$('.js-btn-edit').off('click').on('click', function(){
		// if(validator.form()){
			$('#post-form').submit();	
		// }
	});	
});
