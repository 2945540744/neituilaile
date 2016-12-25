$(document).ready(function(){
	var $form = $('#post-form');
	var validator = $form.validate({
		onkeyup: false,
		rules: {
			job_type: {
				required: false
			},
			title: {
				required: true,
				minlength:1,
				maxlength: 50
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
			exp_level: {
				required: true
			},
			edu_level: {
				required: true
			},
			addr_city: {
				required: true
			},
			address: {
				required: true,
				minlength: 1,
				maxlength: 100
			},
			summary: {
				required: true,
				minlength: 1,
				maxlength: 1000
			}
		},
		messages: {
			title: '请输入职位名称',
			address: {
				required: '请输入工作地点',
				maxlength: '输入内容过长'
			},
			pay_range_from: {
				before: '薪水下限不应高于上限'
			},
			summary: {
				required: '请输入职位描述',
				maxlength: '输入内容过长'
			}
		}
	});

	$('#pay_range_from').change(function(event){
		$from = $('#pay_range_from').val();
		$to = $('#pay_range_to').val();
		if($from > $to){
			$('#pay_range_to').val($from);
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
