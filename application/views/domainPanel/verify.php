<h1>Domain Verification for <?php echo htmlentities($domain['url']); ?></h1>
<p>In order to authorize your domain and enable your tokens to be found, you
must verify your domain</p>
<h1><?php echo $dnsLink; ?></h1>
<p>You can choose to verify your domain via a TXT DNS Record. To do this you must
    have the ability to modify your DNS Records for your domain.</p>

<h1><?php echo $textLink; ?></h1>
<p>An often simpler option is to place a plaintext file in the root of the domain
    that you registered.</p>