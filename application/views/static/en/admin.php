<?php if($this->session->userdata('userStatus') < 2): ?>
<section class="row">
	<h1>Support and Issue Tracking</h1>
	<section class="span4">
		<h2>Issue Statistics</h2>
	</section>
	<section class="span4">
		<a href="//www.github.com/fuzyfox/mozhunt/issues/" class="btn pull-right clearfix">View all on github</a>
		<h2>Latest Issues</h2>
		<ul class="unstyled">
		<?php
			$gitIssues = file_get_contents('https://api.github.com/repos/fuzzyfox/mozhunt/issues');
			$gitIssues = json_decode($gitIssues);
			foreach($gitIssues as $issue)
			{
				echo '<li>';
				if($issue->assignee == null)
				{
					
					echo '<a href="'.$issue->html_url.'" class="badge badge-error">'.$issue->state.'</a> ';
				}
				else
				{
					echo '<a href="'.$issue->html_url.'" class="badge badge-warning">'.$issue->state.'</a> ';
				}
				echo '<a href="'.$issue->html_url.'">'.$issue->title.'</a>';
			}
		?>
		</ul>
		<?php if(count($gitIssues) == 0): ?>
		<div class="alert alert-block alert-success">
			<h4>Yay! No open development issues right now!</h4>
			Good job! Thanks for helping make mozhunt even more awesome but helping
			clear all the open issues. So... guess all that's left to do is put your
			feet up, and have a nice cup of coffee don't you?
		</div>
		<?php endif; ?>
		<p>If you spot any issues that could be related to the develoment of mozhunt
		then please do not hesitate to tell the develment team by opening a
		<a href="https://github.com/fuzzyfox/mozhunt/issues/new">new issue</a> over on github.</p>
	</section>
	<section class="span4">
		<div class="well">
			<h2>Latest @mentions</h2>
			<ul class="unstyled">
			<?php foreach($mentions as $mention): ?>
				<li class="clearfix">
					<a href="https://twitter.com/#!/<?php echo $mention->user->screen_name;?>/status/<?php echo $mention->id;?>" class="thumbnail pull-left clearfix" style="margin-right:10px;">
						<img src="<?php echo $mention->user->profile_image_url;?>" alt="@<?php echo $mention->user->screen_name;?>'s avatar" />
					</a>
					<?php echo $mention->text; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</section>
</section>
<?php endif; ?>
<?php if($this->session->userdata('userStatus') == 0): ?>
<section class="row">
	<h1>Administration</h1>
	<section class="span4">
		<h2>User Statistics</h2>
	</section>
	<section class="span4">
		<a href="admin/user" class="btn btn-primary pull-right clearfix">View all</a>
		<h2>Latest Users</h2>
		<?php foreach($latestUsers->result() as $user): ?>
			<a href="admin/user/view/<?php echo $user->userID?>" class="thumbnail pull-left clearfix" style="margin-right:10px;">
				<img src="http://www.gravatar.com/avatar/<?php echo md5($user->email); ?>?s=64" alt="<?php echo $user->nickname; ?>'s Gravatar" />
			</a>
			<dl>
				<dt><i class="icon-user"></i> Nickname:</dt><dd><?php echo $user->nickname; ?></dd>
				<dt><i class="icon-time"></i> Member Since:</dt><dd><?php echo date('l jS F, Y', $user->registeredAt); ?></dd>
			</dl>
			<hr>
		<?php endforeach; ?>
	</section>
	<section class="span4">
		<?php echo form_open('admin', array('class'=>'well')); ?>
			<fieldset>
				<legend>Tweet as @mozhunt</legend>
				<?php echo validation_errors('<div class="alert alert-block alert-error">', '</div>'); ?>
				<?php if($this->input->get('tweet') == 'success'): ?>
				<div class="alert alert-success alert-block">
					Tweet successfully made!
				</div>
				<?php endif; ?>
				<?php if($this->input->get('tweet') == 'fail'): ?>
				<div class="alert alert-error alert-block">
					Tweet failed for an unknown reason... please create a
					<a href="//www.github.com/fuzzyfox/mozhunt/issues/new">new issue</a>
					on github.
				</div>
				<?php endif; ?>
				<label for="tweet">Message</label>
				<textarea class="input-xlarge" name="tweet" id="tweet" maxlength="<?php echo (138 - strlen($this->session->userdata('nickname')));?>"></textarea>
				<p class="help-block">Your tweet will be appended with <em>^<?php echo $this->session->userdata('nickname'); ?></em></p>
				<button type="submit" class="btn btn-primary">Tweet</button>
			</fieldset>
		</form>
	</section>
</section>
<?php endif; ?>