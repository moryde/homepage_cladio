
<?php get_header() ?>
<?php while ( have_posts() ) : the_post(); ?>


    <div class="wrapper">
            
            
            <div class="content">
                    <?php the_content(); ?>
                    
             </div>
    </div>	
<?php endwhile; ?> 
    
    <div class="footer">
    </div>