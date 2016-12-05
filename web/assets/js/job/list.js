$(document).ready(function(){
	$('.post-item').click(function(event){
		console.log('go to detail: ', $(event.currentTarget).data('detail-url'));
		location.href = location.origin + $(event.currentTarget).data('detail-url');
		// location.href = location.origin + '/demo/view-post.html';
	});

	$('.js-btn-new-post').on('click', function(event){
		console.log('go to new-post');
		location.href = location.origin + '/job/add';
	});
});