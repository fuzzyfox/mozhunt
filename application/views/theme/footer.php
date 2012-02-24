        
		</div>
		<!-- end main content -->
		
		<!-- start of footer -->
        <footer>
            <section id="footer-main" class="wrap">
                <article>
                    <img src="asset/img/panda/sleep.png" alt="Sleeping mozhunt panda" />
                </article>
                <article>
                    <p>Except where otherwise noted all content on this site is licensed
                    under the <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative
                    Commons Attribution-NonCommercial-ShareAlike 3.0</a> license.</p>
                </article>
                <article>
                    <ul>
                        <li><a href="#">Terms Of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Disclaimers</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </article>
            </section>
        </footer>
        
        <!-- JavaScript at the bottom for fast page loading -->
        
        <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="asset/js/libs/jquery.min.js"><\/script>')</script>
        
		<!-- scripts -->
		
		<!-- end scripts -->
		
        <!-- dynamically loaded scripts -->
		<?php
			if(isset($scripts))
			{
				foreach($scripts as $script)
				{
					echo '<script defer src="asset/js/'.$script.'.js"></script>' . "\r\n";
				}
			}
		?>
        <!-- end dynamically loaded scripts -->
        
        <!-- google analytics tracking code -->
        <script>
            window._gaq = [['_setAccount','UAXXXXXXXX1'],['_trackPageview'],['_trackPageLoadTime']];
            Modernizr.load({
            load: ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'
            });
        </script>
        
        
        <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
        chromium.org/developers/how-tos/chrome-frame-getting-started -->
        <!--[if lt IE 7 ]>
        <script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
        <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
        <![endif]-->
    
    </body>
</html>