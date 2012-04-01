<?php
	
	/*
	 get user details
	*/
	$user = $this->user_model->getUserBy('userID', $this->session->userdata('userID'));
	$user = (object)$user[0];
	
	// check for messages
	if($this->input->get('change'))
	{
		echo '<div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a>Your '.$this->input->get('change').' was successfully changed.</div>';
	}
?>
<section class="row">
	<h1>Account</h1>
	<img src="http://www.gravatar.com/avatar/<?php echo md5($user->email); ?>?s=512" alt="<?php echo $user->nickname; ?>'s Gravatar" class="span2" />
	<section class="span6">
		<h2>Profile</h2>
		<dl>
			<dt><i class="icon-user"></i> Nickname:</dt><dd><?php echo $user->nickname; ?> <a href="user/account/nickname" class="btn btn-mini"><i class="icon-pencil"></i> Change</a></dd>
			<dt><i class="icon-envelope"></i> Email:</dt><dd><?php echo $user->email; ?> <a href="user/account/email" class="btn btn-mini"><i class="icon-pencil"></i> Change</a></dd>
			<dt><i class="icon-time"></i> Member Since:</dt><dd><?php echo date('l jS F, Y', $user->registeredAt); ?></dd>
			<dt><i class="icon-star"></i> User Level:</dt><dd><?php echo $this->user_model->getHumanStatus($user->userID); ?> <a href="docs/user#status-<?php echo $user->userStatus; ?>" class="btn btn-mini btn-info"><i class="icon-info-sign icon-white"></i> Learn More</a></dd>
		</dl>
	</section>
</section>
<section class="row">
	<section class="span6 offset2">
		<h2>Security</h2>
		<dl>
			<dt><i class="icon-envelope"></i> Recovery Emaill Address</dt>
			<dd><?php echo $user->email; ?> <p class="help-block"><strong>Note:</strong> This is the same as email you login with.</p></dd>
			<dt><i class="icon-asterisk"></i> Password</dt>
			<dd>
				**************** <a href="user/account/password" class="btn btn-mini"><i class="icon-pencil"></i> Change</a>
				<p class="help-block"><strong>Note:</strong> We do not, nor will
				we ever, know what your password is. To find out more about how we
				keep your data safe view our <a href="legal/privacy">privacy policy</a></p>
			</dd>
		</dl>
	</section>
</section>
<?php if($user->userStatus < 3): ?>
<section class="row">
	<section class="span6 offset2">
		<h2>Domains</h2>
	</section>
</section>
<?php endif; ?>
		
<?php if($user->userStatus < 2): ?>
<section class="row">
	<section class="span6 offset2">
		<h2>Latest Issues</h2>
		<h3>Development Related <a href="http://www.github.com/fuzzyfox/mozhunt/issues/" class="btn btn-small">view all on github</a></h3>
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
				echo '<a href="'.$issue->html_url.'">'.$issue->title.'</a><p class="help-block">'.str_replace("\r\n", '<br>', $issue->body).'</p>';
			}
		?>
		</ul>
	</section>
	
	<section class="span3">
		<h2>Issue Status Key</h2>
		<dl class="">
			<dt class="badge badge-success">green</dt>
			<dd>The issue has been resolved and is now closed.</dd>
			<dt class="badge badge-warning">orange</dt>
			<dd>The issue is still open however it has been assigned to someone.</dd>
			<dt class="badge badge-error">red</dt>
			<dd>The issue is open and not assigned to anyone.</dd>
		</dl>
	</section>
</section>
<?php endif; ?>
		
<?php if($user->userStatus < 1): ?>
<section class="row">
	<section class="span6 offset2">
		<h2>Administration</h2>
		<a href="admin" class="btn btn-primary btn-large pull-right">Go to admin area!</a>
		<p>Oooo! Looks like you are an administrator on this site! Did you know that
		there is an entire section of this site that only you can see! Yup... you
		are able to control almost all aspects of the game from where you sit. Just
		go to the admin area in your personal menu (top right) or use this nice big
		button here!</p>
	</section>
</section>
<?php endif; ?>