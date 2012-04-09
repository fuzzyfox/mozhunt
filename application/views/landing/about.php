<?php if(!$this->input->get('added')): ?>
<p class="alert alert-block alert-info">
	<a class="close" data-dismiss="alert">&times;</a>End up here by accident? <a href="javascript:history.go(-1);" class="btn"><i class="icon-chevron-left"></i>Go back</a> to where you were last.
</p>
<?php endif; ?>
<section class="row">
	<article class="span8">
		<h1>Welcome to mozhunt!</h1>
		<p>mozhunt is the one and only, cross domain treasure hunt. The treasure being
		pandas... pandas that have gone on an easter egg hunt and been gone just a little 
		too long... Playing mozhunt is easy, it takes just a few simple steps:</p>
		<h2>How to play mozhunt</h2>
		<p>Want to <a href="user/join">join in</a> and play mozhunt? Looking for
		some hints and tips, then read on!</p>
		<ol class="howto">
							<li>
				<h2>Create an account</h2>
				<a href="user/join" class="btn btn-success btn-large pull-right">Sign up now!</a>
				<p>The first thing to do is to make sure you have an account with mozhunt. 
				Joining is easy and takes no time at all. All you need to do is visit our
				sign up page.</p>
			</li>
							<li>
				<h2>Browse the web</h2>
				<p>Thats right... sounds like your normal daily routine doesn't it... well
				it sounds like ours anyway. There is a little more to it though. You need
				to browse the web and keep your eyes open for one of these:</p>
				<div style="text-align: center;">
					<img src="asset/img/token/explore/explore_default.png" alt="explore panda">
					<img src="asset/img/token/sleep/sleep_default.png" alt="sleep panda">
					<img src="asset/img/token/wave/wave_default.png" alt="wave panda">
					<img src="asset/img/token/faceplant/faceplant_default.png" alt="faceplant panda">
					<img src="asset/img/token/run/run_default.png" alt="run panda">
				</div>
			</li>
			<li>
				<h2>See a panda, click a panda!</h2>
				<p>Easy as 3.14159265....! Welll easier infact. Simply move your mouse to
				click on the panda, then click it! If you haven't previously found it you
				should get a nice little message to confirm the panda was found!</p>
			</li>
			<li>
				<h2>No step 4!</h2>
				<p>Thats right... there is nothing more to the game, not unless you want to
				go the extra step and hide a <a href="//youtu.be/ihnhGoeq530">panda on your own website</a>.</p>
			</li>
		</ol>
	</article>
	<?php if($loggedIn): ?>
	<section class="span4">
		<?php if($this->input->get('added')): ?>
		<p class="alert alert-block alert-success">Token successfully collected!</p>
		<?php else: echo form_open('landing/about/'.$alphaID, array('class'=>'form-horizontal')); ?>
			<input type="hidden" name="verifycode" value="<?php echo $verifycode; ?>" />
			<fieldset>
				<legend>Collect Token</legend>
				<p style="text-align:center;" class="well">
					<span style="font-size:2em;letter-spacing:1em;"><?php echo $verifycode; ?></span><br /><br />
					Please enter the above code to collect this token.
				</p>
				<div class="control-group<?php echo (form_error('confcode'))?' error':null; ?>">
					<label for="confcode" class="control-label">Confirmation Code</label>
					<div class="controls">
						<input type="text" name="confcode" />
						<?php echo form_error('confcode', '<span class="help-inline">', '</span>'); ?>
						<p class="help-block"><strong>Note:</strong> this field
						<strong>IS</strong> case sensitive. Spaces don&rsquo;t matter.</p>
					</div>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Collect</button>
					<a href="javascript:history.go(-1);" class="btn">Cancel</a>
				</div>
			</fieldset>
		</form>
		<?php endif; ?>
	</section>
	<?php endif; ?>
</section>