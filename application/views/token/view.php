<ul class="breadcrumb">
    <li>
	    <a href="domain">Domain Management</a> <span class="divider">/</span>
    </li>
    <li>
	    <a href="domain/view/<?php echo $domainID; ?>">Domain</a> <span class="divider">/</span>
    </li>
    <li class="active">Token</li>
</ul>
<h1>Token: <?php echo $name; ?></h1>
<p>Time to hide this token then! We have done what we can to make this process
as painless as possible. All you need to do is copy paste the code below into the
webpage you wish to show to token on!</p>
<section class="row">
	<div class="span8">
		<h2>Code</h2>
		<p>This first block of code needs to be place either in the <code>&lt;head&gt;</code>
		tag of your site <strong>OR</strong> as we recommend, last place in you <code>&lt;body&gt;</code>
		tag.</p>
		<pre><code>&lt;script type="text/javascript" src="//www.mozhunt.com/asset/js/mozhuntclient.js"&gt;&lt/script&gt;
&lt;script type="text/javascript"&gt;
	$mozhunt.init({
		tokenid : <?php echo $tokenID; ?>,
		apikey : '<?php echo $domain['apiKey']; ?>',
		style : 'default',
		size : 'default'
	});
&lt/script&gt;</code></pre>
		<p>Final step... see told you this was easy! This should be placed where ever
		you wish the token to display on your site... it can be in a blog post,
		the footer, sidebar... its up to you.</p>
		<pre><code>&lt;a href="//www.mozhunt.com/landing/about"&gt;
	&lt;img src="//www.mozhunt.com/token/img/default/default.png?s=default" alt="mozhunt token" /&gt;
&lt;/a&gt;</code></pre>
	</div>
	<div class="span4">
		<h2>Preview</h2>
		<a href="//www.mozhunt.com/landing/about">
			<img src="//www.mozhunt.com/token/img/default/default.png?s=default" alt="mozhunt token" />
		</a>
	</div>
</section>