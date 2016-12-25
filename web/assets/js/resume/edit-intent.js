$(document).ready(function(){
	var $form = $('#resume-form');
	var validator = $form.validate({
		onkeyup: false,
		rules: {
			post_name: {
				required: true,
				minlength: 3,
				maxlength: 100
			},
			job_type: {
				required: true
			},
			addr_city: {
				required: true
			},
			pay_range_from: {
				required: true,
				before: {
					ele: '#pay_range_to',
					type: 'num',
					allowEq: true
				}
			},
			pay_range_to: {
				required: true,
				after: {
					ele: '#pay_range_from',
					type: 'num',
					allowEq: true
				}
			},
			on_the_job: {
				required: true
			},
			summary: {
				required: false,
				minlength: 1,
				maxlength: 1000
			}
		},
		messages: {
			post_name: '请输入您的期望职位',
			pay_range_from: {
				before: '薪水下限不应高于上限'
			},
			summary: {
				maxlength: '输入内容过长'
			}
		}
	});

	$('.js-btn-edit').click(function(event){
		if(!validator.form()){
			notify(validator.errorList[0].message);
		}else{
			$form.submit();
		}
	});
});