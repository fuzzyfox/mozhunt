<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        
        <title><?php echo (isset($page_title))? $page_title.' - ' : ''; ?>mozhunt</title>
        
        <!-- Mobile viewport optimized: j.mp/bplateviewport -->
        <meta name="viewport" content="width=device-width,initial-scale=1">
        
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
        
        <base href="<?php echo $this->config->base_url(); ?>">
        
        <!-- CSS: implied media=all -->
        <link rel="stylesheet" href="asset/css/style.css">
        <?php
            if(isset($stylesheets))
            {
                foreach($stylesheets as $stylesheet)
                {
                    echo '<link rel="stylesheet" href="asset/css/'.$stylesheet.'.css">' . "\r\n";
                }
            }
        ?>
        <!-- end CSS-->
        
        <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->
        
        <!-- All JavaScript at the bottom, except for Modernizr / Respond.
        Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
        For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
        <script src="asset/js/libs/modernizr.min.js"></script>
    </head>

    <body>
        <header>
            <h1 class="wordmark"><span class="blue">moz</span>hunt</h1>
            <h2><?php echo $this->lang->line('theme.header.slogan'); ?></h2>
            <nav>
                <ul>
                    <li><a href="#"><?php echo $this->lang->line('theme.nav.home'); ?></a></li>
                    <li class="active"><a href="#"><?php echo $this->lang->line('theme.nav.about'); ?></a></li>
                    <li><a href="#"><?php echo $this->lang->line('theme.nav.play'); ?></a></li>
                    <li><a href="#"><?php echo $this->lang->line('theme.nav.contact'); ?></a></li>
                </ul>
            </nav>
        </header>
        <!-- end of header -->
        
        <!-- start main content -->
        <div id="main-content" class="wrap">
