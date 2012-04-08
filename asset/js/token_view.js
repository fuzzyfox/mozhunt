$(document).ready(function(){
	$('.thumbnail').click(function(e){
		if($(this).attr('id') != 'mozhunttoken')
		{
			var src = 'asset/img/token/' + $(this).find('img').attr('rel') + '/' + $(this).find('img').attr('rel') + '_large.png'
			$('#mozhunttokenimg').attr('src', src);
			$('.tokenstyle').html($(this).find('img').attr('rel'));
		}
		return false;
	});
});

$mozhunt.init({
	tokenid : 5,
	apikey : 'IG5lKZkgtxrEehzOKckNPSZ3C9ryJR',
	style : 'default',
	size : 'default'
});