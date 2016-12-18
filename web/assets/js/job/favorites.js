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
					alert('简历投递成功！');
					location.reload();
				}else{
					alert('简历投递失败：' + resp.message);
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
					alert('已取消收藏！');
					location.reload();
				}else{
					alert('取消收藏失败：' + resp.message);
				}
			}
		});
	});
});