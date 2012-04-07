<section class="row">
	<section class="<?php echo ($loggedIn)?'span3':'span12'; ?>">
		<h1>Leaderboard</h1>
		<ol>
			<?php foreach($leaders->result_array() as $leader): ?>
			<li><?php echo $leader['nickname']; ?></li>
			<?php endforeach; ?>
		</ol>
	</section>
	<?php if($loggedIn): ?>
	<section class="span9">
		<h1>Current Score <small><?php echo ordinal_suffix($user_rank); ?></small></h1>
		<p>You have found tokens on the following websites:</p>
		<?php if($domains): ?>
		<ol>
			<?php foreach($domains as $domain): ?>
			<li><?php echo $domain['url']; ?></li>
			<?php endforeach; ?>
		</ol>
		<?php else: ?>
		None yet... get hunting!
		<?php endif; ?>
	</section>
	<?php endif; ?>
</section>