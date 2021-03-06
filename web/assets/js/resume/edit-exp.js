$(document).ready(function(){
	var $form = $('#resume-form');
	var validator = $form.validate({
		onkeyup: false,
		rules: {
			company_name: {
				required: true,
				minlength: 1,
				maxlength: 100
			},
			position_name: {
				required: true,
				minlength: 1,
				maxlength: 100
			},
			start_date: {
				required: true,
				before: {
					ele: '#end_date',
					type: 'date',
					allowEq: false
				}
			},
			end_date: {
				required: true,
				after: {
					ele: '#start_date',
					type: 'date',
					allowEq: false
				}
			},
			summary: {
				required: true,
				minlength: 1,
				maxlength: 1000
			}
		},
		messages: {
			company_name: '请输入您的公司名称',
			position_name: '请输入您的职位',
			start_date: {
				required: '请选择入职时间',
				before: '入职时间应早于离职时间'
			},
			end_date: '请选择离职时间',
			summary: {
				required: '请输入职责描述',
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