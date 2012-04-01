<!doctype html>
	<html lang="<?php echo $this->config->item('language'); ?>">
		<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width,initial-scale=1">
			<base href="<?php echo $this->config->base_url(); ?>">
			<title><?php echo (isset($page_title)) ? $page_title . ' - ' : null; ?>mozhunt</title>
			<link rel="stylesheet" href="asset/css/bootstrap.min.css" />
			<link rel="stylesheet" href="asset/css/mozhunt.css" />
			<style type="text/css">
				body {
				  padding-top: 60px;
				  padding-bottom: 40px;
				}
			</style>
			<?php
				if(isset($stylesheets))
				{
					foreach($stylesheets as $stylesheet)
					{
						echo '<link rel="stylesheet" href="asset/css/'.$stylesheet.'.css">' . "\r\n";
					}
				}
			?>
			<!--[if lt IE 9]>
				<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->
		</head>
		<body>
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<a href="./" class="brand">mozhunt</a>
						<div class="nav-collapse">
							<ul class="nav">
								<li><a href="./"><?php echo $this->lang->line('theme.nav.home'); ?></a></li>
								<li><a href="about"><?php echo $this->lang->line('theme.nav.about'); ?></a></li>
								<li><a href="play"><?php echo $this->lang->line('theme.nav.play'); ?></a></li>
								<li><a href="contact"><?php echo $this->lang->line('theme.nav.contact'); ?></a></li>
							</ul>
							<?php if(!$this->user_session->isUserLoggedIn() && ($this->uri->segment(2) != 'login')): ?>
							<a href="#modal-login" class="btn btn-primary pull-right" data-toggle="modal"><?php echo $this->lang->line('theme.nav.login'); ?></a>
							<?php elseif($this->uri->segment(2) == 'login'): ?>
							<a href="user/join" class="btn btn-success pull-right"><?php echo $this->lang->line('theme.nav.join'); ?></a>
							<?php else: ?>
								<div class="pull-right">
									<p class="navbar-text" style="display:inline-block;margin-right:-14px;">Hey</p>
									<ul class="nav pull-right">
										<li class="dropdown" id="userNav">
											<a class="dropdown-toggle" data-toggle="dropdown" href="#userNav">
											<?php
												$user = $this->user_model->getUserBy('userID', $this->session->userdata('userID'));
												echo $user[0]['nickname'];
											?>
											<b class="caret"></b>
										</a>
										<ul class="dropdown-menu">
											<li><a href="user">Account</a></li>
											<?php if($user[0]['userStatus'] < 1): ?>
											<li class="divider"></li>
											<li>
												<a href="admin">Admin</a>
												<ul class="unstyled" style="margin-left:10px;">
													<li><a href="admin/issue">Issue Management</a></li>
													<?php if($user[0]['userStatus'] == 0): ?>
													<li><a href="admin/user">User Management</a></li>
													<?php endif; ?>
												</ul>
											</li>
											<?php endif; ?>
											<li class="divider"></li>
											<li><a href="user/logout"><?php echo $this->lang->line('theme.nav.logout'); ?></a></li>
										</ul>
										</li>
									</ul>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			
			<?php if(!$this->user_session->isUserLoggedIn() && ($this->uri->segment(2) != 'login')): ?>
			<div id="modal-login" class="modal hide fade">
				<div class="modal-header">
					<a class="close" data-dismiss="modal">&times;</a>
					<h3>Sign in</h3>
				</div>
				<?php echo form_open('user/login', array('class'=>'form-horizontal')); ?>
					<div class="modal-body">
						<div class="control-group">
							<label for="email" class="control-label"><?php echo $this->lang->line('form.login.email.label'); ?></label>
							<div class="controls">
								<input type="text" name="email" class="span3" placeholder="<?php echo $this->lang->line('form.login.email.placeholder'); ?>" />
							</div>
						</div>
						<div class="control-group">
							<label for="password" class="control-label"><?php echo $this->lang->line('form.login.password.label'); ?></label>
							<div class="controls">
								<input type="password" name="password" class="span3" placeholder="<?php echo $this->lang->line('form.login.password.placeholder'); ?>" />
							</div>
						</div>
					</div>
					<div class="modal-footer form-actions">
						<p><?php echo $this->lang->line('form.login.new'); ?></p>
						<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('form.login.submit'); ?></button>
						<a class="btn" data-dismiss="modal"><?php echo $this->lang->line('form.login.cancel'); ?></a>
					</div>
				</form>
			</div>
			<?php endif; ?>
			
			<div class="container">
				<?php if($this->input->get('logout') == true): ?>
				<div class="alert alert-info">
					<a class="close" data-dismiss="alert">&times;</a>
					You were successfully logged out.
				</div>
				<?php endif; ?>
				