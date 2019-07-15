<?php
/*
Template Name: Flexitime Request
*/
?>
<?php 
$process_flexitime_request = process_flexitime_request();
?>
<?php get_header(); ?>
<?php
	
	if(current_user_can( 'manage_options' ) && isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
	}else{
		$user_id = get_current_user_id();
	}	
	$current_user = get_userdata( $user_id );
?>
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
            <?php if($process_flexitime_request > 0):?>
            <div class="container">
            
                <div class="row">
                    
                    <div class="col-xs-12">
                    	
                        <div class="info-box clearfix">Thank You. Your reqest has been successfully saved.</div>

                    </div>
                    
                </div>
                
            </div>  <!-- /.container -->
            <div class="container">
            	<div class="row">
                	<div class="col-xs-12">
						<p><a href="<?php echo home_url('/');?>" class="button">Back</a></p>
                    </div>
                </div>
        	</div>
            <?php else:?>
            <div class="container">
            
                <div class="row">
                    
                    <div class="col-xs-12">
                    	
                        <form id="flexitime-request-form" name="flexitime-request-form" method="post" action="<?php echo get_permalink();?>">
                        	<?php wp_nonce_field( 'flexitime_request_form', 'flexitime_request_form_nonce_field' ); ?>
                            <input type="hidden" name="_flexitime_request_status" value="pending-approval">
                            <input type="hidden" name="_user_id" value="<?php echo $user_id;?>">
                            <input type="hidden" name="_company" value="<?php echo get_holiday_company($user_id);?>">
                            
                            <div class="form-row">
                            	<div class="row">
                                    <div class="col-md-6">
                                        <label>From: <span class="required">*</span></label>
                                        <div class="row">
                                        
                                        	<div class="col-xs-2">
                                            	<a href="#" class="field-datepicker"><i class="fa fa-calendar fa-3x"></i></a>
                                            </div>
                                        
                                            <div class="col-xs-3">
                                                <input type="number" id="field-dd" name="field-dd" placeholder="DD" min="1" max="31" value="<?php echo $_POST['field-dd'];?>" required>
                                            </div>
                                            <div class="col-xs-3">
                                                <input type="number" id="field-mm" name="field-mm" placeholder="MM" min="1" max="12" value="<?php echo $_POST['field-mm'];?>" required>
                                            </div>
                                            <div class="col-xs-4">
                                                <input type="number" id="field-yyyy" name="field-yyyy" placeholder="YYYY"  min="<?php echo date('Y') - 1;?>" max="<?php echo date('Y') + 5;?>" value="<?php echo $_POST['field-yyyy'];?>" required>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Reason: <span class="required">*</span></label>
                                        
                                        <input type="text" id="flexitime_request_reason" name="_flexitime_request_reason" value="<?php echo $_POST['_flexitime_request_reason'];?>" required>
                                        
                                    </div>
                            	</div>
                            </div> <!-- /.form-row --> 
                            
                            <div class="form-row">
                            	<div class="row">
                                    <div class="col-md-12">
                                        <label>Comments: <span class="required">*</span></label>
                                        <textarea name="_flexitime_request_comments" id="flexitime_request_comments" required><?php echo $_POST['_flexitime_request_comments'];?></textarea>
                                    </div>
                                    
                                </div>
                            </div> <!-- /.form-row --> 
                            
                            <div class="form-row">
                            	<div class="row">
                                	<div class="col-xs-6">
                                    	<a href="<?php echo home_url('/');?>" class="button">Back</a>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                    	<input type="submit" name="flexitime-request" class="button" value="Request Flexitime">
                                    </div>
                            	
                                </div>
                            </div> <!-- /.form-row -->
                            
                        </form>

                    </div>
                    
                </div>
                
            </div>  <!-- /.container -->
        	<?php endif;?>
        </div> <!-- /#site-content -->
    
    </div><!-- #post-<?php the_ID(); ?> -->
    <?php endwhile; ?>
    
</div> <!-- /#content -->

<?php get_footer(); ?>