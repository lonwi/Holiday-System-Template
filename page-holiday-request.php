<?php
/*
Template Name: Holiday Request
*/
?>
<?php 
$process_holiday_request = process_holiday_request();
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
            <?php if($process_holiday_request > 0):?>
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
                    	
                        <form id="holiday-request-form" name="holiday-request-form" method="post" action="<?php echo get_permalink();?>?user_id=<?php echo $user_id;?>">
                            <input type="hidden" name="_holiday_request_status" value="pending-approval">
                            <input type="hidden" name="_user_id" value="<?php echo $user_id;?>">
                            <input type="hidden" name="_company" value="<?php echo get_holiday_company($user_id);?>">
                            
                            <div class="form-row">
                            	<div class="row">
                                    <div class="col-md-6">
                                        <label>From: <span class="required">*</span></label>
                                        <div class="row">
                                        
                                        	<div class="col-xs-2">
                                            	<a href="#" class="field-from-datepicker"><i class="fa fa-calendar fa-3x"></i>
</a>
                                            </div>
                                        
                                            <div class="col-xs-3">
                                                <input type="number" id="field-from-dd" name="field-from-dd" placeholder="DD" min="1" max="31" value="<?php echo $_POST['field-from-dd'];?>" required>
                                            </div>
                                            <div class="col-xs-3">
                                                <input type="number" id="field-from-mm" name="field-from-mm" placeholder="MM" min="1" max="12" value="<?php echo $_POST['field-from-mm'];?>" required>
                                            </div>
                                            <div class="col-xs-4">
                                                <input type="number" id="field-from-yyyy" name="field-from-yyyy" placeholder="YYYY"  min="<?php echo date('Y') - 1;?>" max="<?php echo date('Y') + 5;?>" value="<?php echo $_POST['field-from-yyyy'];?>" required>
                                            </div>
                                            
                                            
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>To: <span class="required">*</span></label>
                                        
                                        <div class="row">
                                        	
                                            <div class="col-xs-2">
                                            	<a href="#" class="field-to-datepicker"><i class="fa fa-calendar fa-3x"></i>
</a>
                                            </div>
                                        
                                            <div class="col-xs-3">
                                                <input type="number" id="field-to-dd" name="field-to-dd" placeholder="DD" min="1" max="31" value="<?php echo $_POST['field-to-dd'];?>" required>
                                            </div>
                                            <div class="col-xs-3">
                                                <input type="number" id="field-to-mm" name="field-to-mm" placeholder="MM" min="1" max="12" value="<?php echo $_POST['field-to-mm'];?>" required>
                                            </div>
                                            <div class="col-xs-4">
                                                <input type="number" id="field-to-yyyy" name="field-to-yyyy" placeholder="YYYY" min="<?php echo date('Y') - 1;?>" max="<?php echo date('Y') + 5;?>" value="<?php echo $_POST['field-to-yyyy'];?>" required>
                                            </div>
                                            
                                        </div>
                                    </div>
                            	</div>
                            </div> <!-- /.form-row --> 
                            
                            <div class="form-row">
                            	<div class="row">
                                    <div class="col-md-6">
                                        <label>No. of Days Requested: <span class="required">*</span></label>
                                        <input type="number" step="0.25" id="_holiday_request_days" name="_holiday_request_days" value="<?php echo $_POST['_holiday_request_days'];?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Type of holiday: <span class="required">*</span></label>
                                        <?php $request_types = get_holiday_request_types();?>
                                        <select name="_holiday_request_type">
                                            <?php if(isset($request_types) && !empty($request_types)):?>
                                                <?php foreach($request_types as $request_type):?>
                                                <option value="<?php echo $request_type->slug;?>" <?php echo $_POST['_holiday_request_type'] === $request_type->slug ? "selected" : "";?>><?php echo $request_type->name;?></option>
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <option value="">Please Add Request Type</option>
                                            <?php endif;?>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- /.form-row --> 
                            
                            <div class="form-row">
                            	<div class="row">
                                	<div class="col-xs-6">
                                    	<a href="<?php echo home_url('/');?>" class="button">Back</a>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                    	<input type="submit" name="holiday-request" class="button" value="Request Holiday">
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