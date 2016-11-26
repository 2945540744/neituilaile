$(document).ready(function(){
	$('.js-btn-edit').off('click').on('click', function(event){
		console.log('go to : ', $(event.target).data('action'));
		location.href = location.origin + $(event.target).data('action');
		// location.href = location.origin + '/demo/new-post.html';
	});

	$('.js-btn-close').off('click').on('click', function(event){
		alert('Close the Post: '+ $(event.target).data('action'));
	});
});