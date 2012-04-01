
	setInterval(function(){
		var currentTime = new Date();
		var startTime = new Date(2012, 3, 0, 0, 0, 0, 0);
		var finishTime = new Date(2012, 3, 3, 0, 0, 0, 0);
		var percentage = ((currentTime.UTC() - startTime.UTC()) / (finishTime.UTC() - startTime.UTC())) * 100;
		console.log('Final Development Sprint ' + percentage);
		$('#FinalDevelopmentSprint .bar').css('width', percentage + '%');
	}, (1000*60));
	
	setInterval(function(){
		var currentTime = new Date();
		var startTime = new Date(2012, 3, 3, 0, 0, 0, 0);
		var finishTime = new Date(2012, 3, 7, 0, 0, 0, 0);
		var percentage = ((currentTime.UTC() - startTime.UTC()) / (finishTime.UTC() - startTime.UTC())) * 100;
		console.log('Soft Launch ' + percentage);
		$('#SoftLaunch .bar').css('width', percentage + '%');
	}, (1000*60));