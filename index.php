
<?php get_header() ?>


    <div class="wrapper">
            
            
            
			                <div class="sidebar">			
			                	<?php get_sidebar(); ?>
			                </div>
			                            <div class="content">
			                
            <div class="pictures">
              <?php while ( have_posts() ) : the_post(); ?>
              	<div class="post">
              	<?php the_title(); ?>
              	<?php the_content(); ?>
              	</div>
              	
              <?php endwhile; ?>
            <?php get_random_pictures(); ?>
            

              </div>

             </div>
    </div>	
    
    <div class="footer">
    <?php get_footer() ?>
    
    </div>