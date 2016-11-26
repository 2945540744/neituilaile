$(document).ready(function(){
	//TODO form validator
	var $form = $('#resume-form');
	var validator = $form.validate({

	});

	$('.js-btn-edit').click(function(event){
		if(validator.form()){
			$form.submit();
		}
	});
});