				
				<footer class="row footer">
					<img src="asset/img/panda/sleep.png" alt="Sleeping mozhunt panda" class="span1" />
					<p class="span4"><?php echo $this->lang->line('theme.footer.legal'); ?></p>
					<ul class="span2 offset5">
						<li><a href="legal/tos"><?php echo $this->lang->line('theme.footer.nav.tos'); ?></a></li>
						<li><a href="legal/privacy"><?php echo $this->lang->line('theme.fotoer.nav.privacy'); ?></a></li>
						<li><a href="legal/disclaimers"><?php echo $this->lang->line('theme.footer.nav.disclaimers'); ?></a></li>
						<li><a href="contact"><?php echo $this->lang->line('theme.footer.nav.contact'); ?></a></li>
					</ul>
				</footer>
			</div>
			
			<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
			<script>window.jQuery || document.write('<script src="asset/js/libs/jquery.min.js"><\/script>')</script>
			
			<script type="text/javascript" src="asset/js/bootstrap.min.js"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					$(".alert").alert();
				});
			</script>
			
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