<head>

<link id="size-stylesheet" rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory');?>/style.css" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory');?>/smallStyle.css" media="only screen and (max-width: 767px)"/>

<script src="<?php bloginfo('template_directory');?>/scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory');?>/scripts/purl.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory');?>/scripts/lightbox-2.6.min.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory');?>/scripts/jquery.isotope.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory');?>/javascript.js" type="text/javascript"></script>


</head>
<div class="loadingScreen"><img src="<?php bloginfo('template_directory');?>/images/ajax-loader.gif"></div>
<div class="head">
    <div class="logo">
        <a href="<?php echo home_url(); ?>"><img id="logo" src="http://ydefeldt.com/photo/wp-content/themes/cc/images/logo2X.png"></a>
    </div>
    
    <div class="menuContainer">
        <div class="topMenu">
                                <?php wp_nav_menu(); ?> 
         </div>
    </div>
</div>