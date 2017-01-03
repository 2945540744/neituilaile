$(document).ready(function(){
	var $form = $('#resume-form');
	var validator = $form.validate({
		onkeyup: false,
		rules: {
			nickname: {
				required: true,
				minlength: 1,
				maxlength: 20
			},
			edu_level: {
				required: true
			},
			exp_level: {
				required: true
			},
			birthday: {
				required: true,
				validBirth: true
			},
			email: {
				required: true,
				email: true
			},
			mobile: {
				required: true,
				mobile: true
			}
		},
		messages: {
			nickname: '请输入您的昵称',
			edu_level: '请选择最高学历',
			exp_level: '请选择工作年限',
			birthday: '请选择生日',
			email: {
				required: '请输入您的邮箱',
				email: '邮箱格式有误'
			},
			mobile: {
				required: '请输入您的手机号',
				mobile: '手机格式有误'
			}
		}
	});

	$.validator.addMethod(
	  "validBirth",
	  function(value, element, params) {
	    if(!value) return true;
	    $d = new Date(value).getTime();
	    $now = new Date().getTime();
	    $min = new Date('1970-01-01').getTime();
	    return $d < $now && $d > $min; 	
	  },
	  '无效的生日'
	);

	$('.js-btn-edit').click(function(event){
		if(!validator.form()){
			notify(validator.errorList[0].message);
		}else{
			$form.submit();
		}
	});
});