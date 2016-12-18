$(document).ready(function(){
	//page range
	$('.js-pay-range-from').change(function(event){
		$from = $('.js-pay-range-from').val();
		$to = $('.js-pay-range-to').val();
		console.log('from to :', $from, $to);
		if($from > $to){
			$('.js-pay-range-to').val($from);
		}
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
