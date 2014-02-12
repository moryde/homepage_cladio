<?php
/*
Template Name: Portfilio Template
*/
?>

<?php get_header() ?>
<?php while ( have_posts() ) : the_post(); ?>

    <div class="wrapper">
            
            <div class="menuContainer">
                <div class="mainMenu">
                <?php //wp_nav_menu(); ?>
                <?php portfolio_menu(); ?>
                </div>
            </div>
            
            <div class="content">
            	
                    <?php the_content(); ?>
                    <div class="imageView"><div class="pre"><</div><div class="next">></div></div>
                    
                    <div class="pictures">
                    
                  
                  
                  
                    </div>
            </div>
    </div>	
<?php endwhile; ?> 
    
    <div class="footer">
    </div>