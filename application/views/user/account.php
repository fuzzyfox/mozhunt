<?php
	
	/*
	 get user details
	*/
	$user = $this->user_model->getUserBy('userID', $this->session->userdata('userID'));
	$user = (object)$user[0];
	
?>
<h1>Account</h1>
<img src="http://www.gravatar.com/avatar/<?php echo md5($user->userEmail); ?>?s=512" alt="<?php echo $user->userNickname; ?>'s Gravatar" class="span2" />
<section class="span10">
	
</section>