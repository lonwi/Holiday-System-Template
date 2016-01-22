<?php
/*
Template Name: Login
*/
?>

<?php get_header(); ?>

<div id="content" class="content clearfix" role="main">

	<?php while ( have_posts() ) : the_post();?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
        <div id="site-content" class="site-content clearfix">
        
        	<div class="container">
            
                <div class="row">
                    
                    <div class="col-xs-12">
                    	
                        <?php the_content(); ?>

                    </div>
                    
                </div>
                
            </div>  <!-- /.container -->
        	
            <div class="container">
            
            	<div class="row">
                
                    <div class="col-xs-12">
                    
                        <?php wp_login_form(); ?>
                        
                    </div>
                    
                </div>
                
            </div>  <!-- /.container -->
        
        </div> <!-- /#site-content -->
    
    </div><!-- #post-<?php the_ID(); ?> -->
    <?php endwhile; ?>
    
</div> <!-- /#content -->

<?php get_footer(); ?>