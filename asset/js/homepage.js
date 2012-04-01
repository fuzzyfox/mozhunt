
	setInterval(function(){
		var currentTime = new Date();
		var startTime = new Date(2012, 3, 1, 0, 0, 0, 0);
		var finishTime = new Date(2012, 3, 4, 0, 0, 0, 0);
		var percentage = ((currentTime.getTime() - startTime.getTime()) / (finishTime.getTime() - startTime.getTime())) * 100;
		console.log('Final Development Sprint ' + percentage);
		$('#FinalDevelopmentSprint .bar').css('width', percentage + '%');
	}, (1000*60*60));
	
	setInterval(function(){
		var currentTime = new Date();
		var startTime = new Date(2012, 3, 4, 0, 0, 0, 0);
		var finishTime = new Date(2012, 3, 8, 0, 0, 0, 0);
		var percentage = ((currentTime.getTime() - startTime.getTime()) / (finishTime.getTime() - startTime.getTime())) * 100;
		console.log('Soft Launch ' + percentage);
		$('#SoftLaunch .bar').css('width', percentage + '%');
	}, (1000*60*60));