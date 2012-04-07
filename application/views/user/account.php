<?php
	
	/*
	 get user details
	*/
	if(($this->uri->segment(1) == 'admin') && ($this->uri->segment(3) == 'view'))
	{
		$user = $this->user_model->getUserBy('userID', $this->uri->segment(4));
		echo '<div class="alert alert-info clearfix"><a href="admin/user" class="btn btn-primary pull-right">Go Back</a>This is just a snapshot of what the user <strong>'.$user[0]['nickname'].'</strong> can see.
		You are unable to change any settings from here. Clicking any of the buttons bellow will act as if this is <strong>YOUR</strong> user account page.</div>';
	}
	else
	{
		$user = $this->user_model->getUserBy('userID', $this->session->userdata('userID'));
	}
	$user = (object)$user[0];
	
	// check for messages
	if($this->input->get('change'))
	{
		echo '<div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a>Your '.$this->input->get('change').' was successfully changed.</div>';
	}
	elseif($this->input->get('upgraded'))
	{
		echo '<div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a>Your '.$this->input->get('change').' was successfully upgraded.</div>';
	}
?>
<section class="row">
	<h1>Account</h1>
	<section class="span2">
		<div class="thumbnail">
			<img src="http://www.gravatar.com/avatar/<?php echo md5($user->email); ?>?s=512" alt="<?php echo $user->nickname; ?>'s Gravatar" />
			<div class="caption">
				Image via <a href="//www.gravatar.com">Gravatar</a>.
			</div>
		</div>
	</section>
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
<?php if($user->userStatus < 4): ?>
<section class="row">
	<section class="span6 offset2">
		<h2>Domains</h2>
		<?php if($this->domain_model->getUserDomainCount($user->userID) > 0): ?>
		<p>So, <?php echo $this->domain_model->getUserDomainCount($user->userID); ?> domain<?php echo ($this->domain_model->getUserDomainCount($user->userID) > 1)?'s':null; ?>
		linked to this account... need to <a href="domain">manage them</a>?</p>
		<?php elseif($user->userStatus < 3): ?>
		<p>Hmmm.... looks like you can hide some tokens... just need to
		<a href="domain/create">add a domain to your account</a>.</p>
		<?php else: ?>
		<p>The one and only, cross domain treasure hunt is back, and this time its
		all about them easter eggs! With just a few days to go we are looking for
		those who think they have what it takes to hide easter eggs, and hide them
		well. So... do you think you have what it takes?</p>
		<a href="domain/register" class="btn btn-success">Upgrade your account for free</a>
		<?php endif; ?>
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
