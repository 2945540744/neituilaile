$(document).ready(function(){
	var $form = $('#company-form');
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
			profile: {
				required: true,
				minlength: 1,
				maxlength: 200
			},
			website: {
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
			profile: {
				required: '请输入一句话介绍',
				maxlength: '输入内容过长'
			},
			address: {
				required: '请输入公司地址',
				maxlength: '输入内容过长'
			},
			summary: {
				required: '请输入职位描述',
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
