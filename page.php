<!--<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="" />
<link rel="stylesheet" media="" href="<?php bloginfo('template_directory'); ?>/smallStyle.css" />-->
<link id="size-stylesheet" rel="stylesheet" type="text/css" href="http://ydefeldt.com/photo/wp-content/themes/cc/style.css" />
<link rel="stylesheet" type="text/css" href="http://ydefeldt.com/photo/wp-content/themes/cc/smallStyle.css" media="only screen and (max-width: 767px)"/>


<script src="http://ydefeldt.com/photo/wp-content/themes/cc/scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="http://ydefeldt.com/photo/wp-content/themes/cc/scripts/purl.js" type="text/javascript"></script>

<script src="http://ydefeldt.com/photo/wp-content/themes/cc/scripts/jquery.isotope.js" type="text/javascript"></script>


<script src="http://ydefeldt.com/photo/wp-content/themes/cc/javascript.js" type="text/javascript"></script>

<?php get_header() ?>
<?php while ( have_posts() ) : the_post(); ?>


    <div class="wrapper">
            <div class="content">
                    <?php the_content(); ?>
            </div>
    </div>	
<?php endwhile; ?> 
    
<div class="footer"></div>
    