<ul>
	<?php
	foreach($faqs as $faq){
	?>
	<li><?php echo "<a href=\"{$faq['link']}\">{$faq['name']}</a>"; ?></li>
	<?php
	}
	?>
</ul>
