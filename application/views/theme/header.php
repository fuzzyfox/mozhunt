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
							<span class="iconbar"></span>
							<span class="iconbar"></span>
							<span class="iconbar"></span>
						</a>
						<a href="./" class="brand">mozhunt</a>
						<div class="nav-collapse">
							<ul class="nav">
								<li><a href="./"><?php echo $this->lang->line('theme.nav.home'); ?></a></li>
								<li><a href="about"><?php echo $this->lang->line('theme.nav.about'); ?></a></li>
								<li><a href="play"><?php echo $this->lang->line('theme.nav.play'); ?></a></li>
								<li><a href="contact"><?php echo $this->lang->line('theme.nav.contact'); ?></a></li>
							</ul>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>
			
			<div class="container">
				