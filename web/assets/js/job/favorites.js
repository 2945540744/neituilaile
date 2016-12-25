$(document).ready(function(){
	$('.js-job-item').off('click').on('click', function(event){
		location.href = location.origin + $(event.currentTarget).data('url');
	});

	$('.js-btn-delivery').off('click').on('click', function(event){
		$.ajax({
			url: $(event.currentTarget).data('url'),
			type: 'POST',
			success: function(resp){
				if(resp.success){
					notify('简历投递成功！');
					setTimeout(function(){
						location.reload();
					}, 1000);
				}else{
					notify('简历投递失败：' + resp.message);
				}
			}
		});
	});

	$('.js-btn-unfavorite').off('click').on('click', function(event){
		$.ajax({
			url: $(event.currentTarget).data('url'),
			type: 'POST',
			success: function(resp){
				if(resp.success){
					notify('已取消收藏！');
					setTimeout(function(){
						location.reload();
					}, 1000);
				}else{
					notify('取消收藏失败：' + resp.message);
				}
			}
		});
	});
});