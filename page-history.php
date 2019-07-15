<?php
/*
Template Name: History
*/
?>
<?php
	if( ( current_user_can( 'manage_options' ) || current_user_can( 'manage_holidays' ) ) && isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
	}else{
		$user_id = get_current_user_id();
	}	
	$_current_user = get_userdata( $user_id );
?>
<?php get_header(); ?>
<div id="content" class="content clearfix" role="main">
<?php while ( have_posts() ) : the_post();?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    	<div id="site-content" class="site-content clearfix">
        
			<?php if(current_user_can( 'manage_options' ) && !isset($_GET['user_id']) || current_user_can( 'manage_holidays' ) && !isset($_GET['user_id'])):?>
            	<?php get_template_part( 'includes/history/summary', 'users' ); ?>
            <?php else:?>
            	<?php get_template_part( 'includes/history/summary', 'user' ); ?>
            <?php endif;?>
            
    	</div> <!-- /#site-content -->
    </div>
<?php endwhile; ?>
</div> <!-- /#content -->
<?php get_footer(); ?>