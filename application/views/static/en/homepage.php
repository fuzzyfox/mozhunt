<?php
	
	// currnet progress
	$stage = array(
		'Kick-Off Sprint' => 100,
		'Primary Development' => 100,
		'Final Development Sprint' => ((now() - local_to_gmt(strtotime('April 1st, 2012')))/(strtotime('April 4th, 2012') - strtotime('April 1st, 2012'))) * 100,
		'Soft Launch' => ((now() - local_to_gmt(strtotime('April 4th, 2012')))/(strtotime('April 8th, 2012') - strtotime('April 4th, 2012'))) * 100
	);
	
?>
<section class="hero-unit">
	<h1>mozhunt, coming soon</h1>
	<p>The one and only, cross domain treasure hunt is back, and this time
	its all about them easter eggs! With just a few days to go we are looking
	for those who think they have what it takes to hide easter eggs, and hide
	them well. So... do you think you have what it takes?</p>
	
	<?php foreach($stage as $heading => $percentage): ?>
	<h2><?php echo $heading?></h2>
	    <div id="<?php echo implode('', explode(' ', $heading)); ?>" class="progress <?php echo ($percentage < 50)?'progress-success':(($percentage < 75)?'progress-warning':'progress-danger');?>">
			<div class="bar" style="width: <?php echo $percentage?>%;"></div>
		</div>
	<?php endforeach; ?>
</section>