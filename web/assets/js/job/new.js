$(document).ready(function(){
	var $form = $('#post-form');
	var validator = $form.validate({
		onkeyup: false,
		rules: {
			full_name: {
				required: true,
				minlength: 1,
				maxlength: 100
			},
			short_name: {
				required: true,
				minlength:1,
				maxlength: 20
			},
			industry: {
				required: true
			},
			scale: {
				required: true
			},
			fund: {
				required: true
			},
			website: {
				required: true,
				url: true
			},
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
			full_name: '请输入公司全称',
			short_name: '请输入公司简称',
			industry: '请选择所属行业',
			scale: '请选择公司规模',
			fund: '请选择融资阶段',
			website: '请输入有效的网址',
			job_type: '请选择职位类型',
			title: '请输入职位名称',
			exp_level: '请选择经验要求',
			edu_level: '请选择学历要求',
			addr_city: '请选择工作城市',
			address: '请输入工作地点',
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
