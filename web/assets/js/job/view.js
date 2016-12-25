$(document).ready(function(){
	$('.js-btn-edit').off('click').on('click', function(event){
		console.log('go to : ', $(event.currentTarget).data('action'));
		location.href = location.origin + $(event.currentTarget).data('action');
	});

	$('.js-btn-open').off('click').on('click', function(event){
		$.ajax({
			url: $(event.currentTarget).data('action'),
			type: 'POST',
			success: function(resp){
				if(resp.success){
					notify('职位开放成功！');
					setTimeout(function(){
						location.reload();
					}, 1000);
				}else{
					notify('职位开放失败：' + resp.message);
				}
			}
		});
	});

	$('.js-btn-close').off('click').on('click', function(event){
		$.ajax({
			url: $(event.currentTarget).data('action'),
			type: 'POST',
			success: function(resp){
				if(resp.success){
					notify('职位关闭成功！');
					setTimeout(function(){
						location.reload();
					}, 1000);
				}else{
					notify('职位关闭失败：' + resp.message);
				}
			}
		});
	});

	$('.js-btn-delivery').off('click').on('click', function(event){
		$.ajax({
			url: $(event.currentTarget).data('action'),
			type: 'POST',
			success: function(resp){
				if(resp.success){
					notify('简历投递成功！');
					setTimeout(function(){
						location.reload();
					}, 1000);
				}else{
					if(resp.error == 10010){
						location.href = location.origin + '/resume/index';
					}else{
						notify('简历投递失败：' + resp.message);
					}
				}
			}
		});
	});

	$('.js-unfavorite').off('click').on('click', function(event){
		$.ajax({
			url: $(event.currentTarget).data('url'),
			type: 'POST',
			success: function(resp){
				if(resp.success){
					notify('取消收藏成功！');
					setTimeout(function(){
						location.reload();
					}, 1000);
				}else{
					notify('取消收藏失败：' + resp.message);
				}
			}
		});
	});

	$('.js-favorite').off('click').on('click', function(event){
		$.ajax({
			url: $(event.currentTarget).data('url'),
			type: 'POST',
			success: function(resp){
				if(resp.success){
					notify('职位收藏成功！');
					setTimeout(function(){
						location.reload();
					}, 1000);
				}else{
					notify('职位收藏失败：' + resp.message);
				}
			}
		});
	});
});