<?php
/*
Template Name: Gallery Template
*/
?>

<?php get_header() ?>
<?php while ( have_posts() ) : the_post(); ?>

    <div class="wrapper">
            
            <div class="menuContainer">
                <div class="mainMenu">
                <?php //wp_nav_menu(); ?>
                <?php photographers_menu(); ?>
                </div>
            </div>
            
            <div class="content">
            	
                    <?php the_content(); ?>
                    <div class="pictures">
                    
                  <?php get_random_pictures(); ?>
                  
                  
                  
                    </div>
            </div>
    </div>	
<?php endwhile; ?> 
    
    <div class="footer">
    </div>