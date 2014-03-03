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
			<div class="title"><?php echo get_the_title(); ?> </div>
                <?php portfolio_menu(); ?>
                </div>
            </div>
            
            <div class="content">
            	
                    <?php the_content(); ?>
                    	<div class="imageView"><div class="navigation"><div class="pre"><</div><div class="backBut">back</div><div class="next">></div></div><br></div>
                    
                    <div class="pictures">
                    
                  
                  
                  
                    </div>
            </div>
    </div>	
<?php endwhile; ?> 
    
<div class="footer">
<?php get_footer() ?>

</div>