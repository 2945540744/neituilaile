$(document).ready(function(){
	$('.js-btn-edit').off('click').on('click', function(event){
		console.log('go to : ', $(event.target).data('action'));
		location.href = location.origin + $(event.target).data('action');
		// location.href = location.origin + '/demo/new-post.html';
	});

	$('.js-btn-close').off('click').on('click', function(event){
		// alert('Close the Post: '+ $(event.target).data('action'));
		$.ajax({
			url: $(event.currentTarget).data('action'),
			type: 'POST',
			success: function(resp){
				if(resp.success){
					alert('职位关闭成功！');
					location.reload();
				}else{
					alert('职位关闭失败：' + resp.message);
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
					alert('简历投递成功！');
					location.reload();
				}else{
					alert('简历投递失败：' + resp.message);
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
					alert('职位收藏成功！');
					location.reload();
				}else{
					alert('职位收藏失败：' + resp.message);
				}
			}
		});
	});
});