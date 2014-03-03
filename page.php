
<?php get_header() ?>


    <div class="wrapper">
            
            
            <div class="sidebar"><?php get_sidebar(); ?></div>
                        <div class="content">
            
              <?php while ( have_posts() ) : the_post(); ?>
              	<div class="postwp">

              	<div class="title"><?php the_title(); ?></div>
              	<?php the_content(); ?>
              	</div>
              	
              <?php endwhile; ?>
            
            
            
              </div>
            

            
    </div>	
    
    <div class="footer">
    <?php get_footer() ?>
    
    </div>