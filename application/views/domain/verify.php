<h1>Domain Verification for <?php echo htmlentities($url); ?></h1>
<p>In order to authorize your domain and enable your tokens to be found, you
must verify your domain. You can choose to verify your domain via a TXT DNS record,
<strong>OR</strong>, by placing a plaintext file in the root of your domain.</p>
<h2>Verify by DNS</h2>
<p>In order to verify by this method you must be able to modify the DNS records
for your domain. If you are unable to do this then please move to the next method
of verification.</p>
<div class="well clearfix">
	<p>To verify using DNS please enter the following TXT DNS record to your domain.</p>
	<pre><?php echo $activationKey;?></pre>
	<p>Once this has been done click the verify button to your right.</p>
	<a href="domain/verify/<?php echo $domainID;?>/dns" class="btn btn-primary pull-right">Verify via dns</a>
</div>
<h2>Verify by text file</h2>
<p>This method simply requires the ability to upload/create a single file on your
domain. This can be done via a number of methods such as ssh, scp, ftp, etc... How
this file ends up on your domain is up to you.</p>
<div class="well clearfix">
	<p>To verify using text file simply create a file called <code>mozhunt.txt</code>
	at the root of your domain, and ensure you can access it via
	<a href="//<?php echo $url;?>/mozhunt.txt"><?php echo $url; ?>/mozhunt.txt</a>.</p>
	<p>The contents of this text file should include nothing but the below.</p>
	<pre><?php echo $activationKey;?></pre>
	<p>Once the file has been successfully uploaded/created click the verify button
	to your right.</p>
	<a href="domain/verify/<?php echo $domainID;?>/text" class="btn btn-primary pull-right">Verify via text file</a>
</div>