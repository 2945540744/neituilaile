$(document).ready(function(){

	var $form = $('#resume-form');
	var validator = $form.validate({
		onkeyup: false,
		rules: {
			school_name: {
				required: true,
				minlength: 3,
				maxlength: 100
			},
			major_name: {
				required: true,
				minlength: 2,
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
			edu_level: {
				required: true
			}
		},
		messages: {
			school_name: '请输入您的学校名称',
			major_name: '请输入您的专业名称',
			start_date: {
				before: '入学日期应早于毕业日期'
			}
			// end_date: {
			// 	after: '毕业日期应晚于入学日期'
			// }
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