$(document).ready(function(){
	$.validator.setDefaults({
	  errorClass: 'input-error',
	  errorElement: 'p',
	  onkeyup: false,
	  ignore: '',
	  ajax: false,
	  currentDom: null, 
	  highlight: function(element, errorClass, validClass) {
	    let $row = $(element).addClass('input-error').closest('.form-group').addClass('has-error');
	    $row.find('.help-block').hide();
	  },
	  unhighlight: function(element, errorClass, validClass) {
	    let $row = $(element).removeClass('input-error').closest('.form-group');
	    $row.removeClass('has-error');
	    $row.find('.help-block').show();
	  },
	  errorPlacement: function(error, element) {
	    if (element.parent().hasClass('controls')) {
	      element.parent('.controls').append(error);
	    } else if (element.parent().hasClass('input-group')) {
	      element.parent().after(error);
	    } else if (element.parent().is('label')) {
	      element.parent().parent().append(error);
	    } else {
	      element.parent().append(error);
	    }
	  }
	});

	$.validator.addMethod(
	  "mobile",
	  function(value, element, params) {
	    if(!value) return true;
	    return /^0{0,1}1[3|4|5|6|7|8|9][0-9]{9}$/.test(value);	
	  },
	  '手机号码格式有误'
	);
	$.validator.addMethod(
	  "before",
	  function(value, element, params) {
	  	if(!value) return true;
	  	toCompare = $(params.ele).val();
	  	if(!toCompare) return true;
	  	if(params.type == 'num'){
	  		if(params.allowEq){
	  			return parseFloat(value) <= parseFloat(toCompare);
	  		}else{
	  			return parseFloat(value) < parseFloat(toCompare);
	  		}
	  	}else{// default as date
	  		return params.allowEq ? value <= toCompare : value < toCompare;
	  	}
	  }, ''
	);

	$.validator.addMethod(
	  "after",
	  function(value, element, params) {
	  	if(!value) return true;
	  	toCompare = $(params.ele).val();
	  	if(!toCompare) return true;
	  	if(params.type == 'num'){
	  		if(params.allowEq){
	  			return parseFloat(value) >= parseFloat(toCompare);
	  		}else{
	  			return parseFloat(value) > parseFloat(toCompare);
	  		}
	  	}else{// default as date
	  		return params.allowEq ? value >= toCompare : value > toCompare;
	  	}
	  },
	  ''
	);
	window.notify = function(msg){
		$.notify({
			message: msg
		},{
			type: 'danger',
			delay: 1000,
			timer: 300,
			allow_dismiss: false,
			placement: {
				from: 'top',
				align: 'center'
			},
			offset: {
				y: screen.height * 0.4
			},
			template: '<div data-notify="container" class="alert alert-{0}" role="alert"><button type="button" aria-hidden="true" class="close" data-notify="dismiss">&times;</button><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a></div>'
		});
	};
});