<section class="row">
	<section class="span3">
		<h1>Leaderboard</h1>
		<ol>
			<?php foreach($leaders->result_array() as $leader): ?>
			<li><?php echo $leader['nickname']; ?></li>
			<?php endforeach; ?>
		</ol>
		<?php if(count($leaders->result_array()) == 0): ?>
		<p>Well there are no leaders yet... just need to wait for gameplay to start 
		in a couple of days time.</p>
		<?php endif; ?>
	</section>
	<section class="span9">
		<?php if($loggedIn): ?>
		<section>
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
		</section>
		<hr />
		<?php endif;endif; ?>
		<section>
			<h1>How to play mozhunt</h1>
			<p><?php if(!$loggedIn): ?>Want to <a href="user/join">join in</a><?php endif;?> and play mozhunt? Looking for
			some hints and tips, then read on!</p>
			<ol class="howto">
				<?php if(!$loggedIn): ?>
				<li>
					<h2>Create an account</h2>
					<a href="user/join" class="btn btn-success btn-large pull-right">Sign up now!</a>
					<p>The first thing to do is to make sure you have an account with mozhunt. 
					Joining is easy and takes no time at all. All you need to do is visit our
					sign up page.</p>
				</li>
				<?php endif; ?>
				<li>
					<h2>Browse the web</h2>
					<p>Thats right... sounds like your normal daily routine doesn't it... well
					it sounds like ours anyway. There is a little more to it though. You need
					to browse the web and keep your eyes open for one of these:</p>
					<div style="text-align:center">
						<img src="asset/img/token/explore/explore_default.png" alt="explore panda" />
						<img src="asset/img/token/sleep/sleep_default.png" alt="sleep panda" />
						<img src="asset/img/token/wave/wave_default.png" alt="wave panda" />
						<img src="asset/img/token/faceplant/faceplant_default.png" alt="faceplant panda" />
						<img src="asset/img/token/run/run_default.png" alt="run panda" />
					</div>
				</li>
				<li>
					<h2>See a panda, click a panda!</h2>
					<p>Easy as 3.14159265....! Welll easier infact. Simply move your mouse to
					click on the panda, then click it! If you haven't previously found it you
					should get a nice little message to confirm the panda was found!</p>
				</li>
				<li>
					<h2>No step <?php echo ($loggedIn)?3:4; ?>!</h2>
					<p>Thats right... there is nothing more to the game, not unless you want to
					go the extra step and hide a <a href="//youtu.be/ihnhGoeq530">panda on your own website</a>.</p>
				</li>
			</ol>
		</section>
	</section>
</section>