<?php
/*
Template Name: Dashboard
*/
?>
<?php get_header(); ?>
<?php
	if(current_user_can( 'manage_options' ) && isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
	}else{
		$user_id = get_current_user_id();
	}	
	$_current_user = get_userdata( $user_id );
?>
<?php if(current_user_can( 'manage_options' ) && !isset($_GET['user_id'])):?>
<div id="content" class="content clearfix" role="main">
	<?php while ( have_posts() ) : the_post();?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	
        <div id="site-content" class="site-content clearfix">
        	
            <div class="container">
            	
                <div class="row">
                    
                    <div class="col-xs-12">
						
                        <h3>Holiday History</h3>
                        
                        <h4>Pending</h4>
                        <?php $pending_holidays = get_holiday_requests( 0, 'pending-approval');?>
                        <?php if(isset($pending_holidays) && !empty($pending_holidays)):?>
                        
                        
                        <div class="holiday-history-table">
                        	<div class="holiday-history-head">
                        	<div class="row">
                            		<div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value">Name</span>
                                    </div>
                                	<div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value">From</span>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value">To</span>
                                    </div>
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value">Days</span>
                                    </div>
                                    <div class="col-md-2 col-xs-12">
                                    	<span class="holiday-history-value">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php foreach($pending_holidays as $pending_holiday):?>
                            <div class="holiday-history-content">
                            	<div class="row">
                                	<div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo the_author_meta( 'display_name' , $pending_holiday->post_author );?></span>
                                    </div>
                                	<div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', get_holiday_request_from($pending_holiday->ID));?></span>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', get_holiday_request_to($pending_holiday->ID));?></span>
                                    </div>
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_days($pending_holiday->ID);?></span>
                                    </div>
                                    
                                    <div class="col-md-2 col-xs-12">
                                    	<span class="holiday-history-value"><a href="<?php echo get_permalink($pending_holiday->ID);?>?pdf=<?php echo $pending_holiday->ID;?>" target="_blank">Print</a> / <a href="<?php echo get_permalink($pending_holiday->ID);?>">View</a></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        <?php else:?>
                        <p>There are no pending holiday requests.</p>
                        <?php endif;?>
            		</div>
                </div>
            </div>
            
            <div class="container">
            	
                <div class="row">
                	
                    <div class="col-xs-12">
                    <?php
					$companies = get_terms('company', array('hide_empty' => false));
					if(isset($companies) && !empty($companies)){
						foreach($companies as $company){
							echo '<h3>'.esc_attr($company->name).'</h3>';
							echo '<div class="holiday-history-table clearfix">';
							$employees = get_users(array('role'=>'employee', 'orderby'=>'display_name', 'meta_key' => '_holiday_company', 'meta_value' => $company->slug));
							if(isset($employees) && !empty($employees)){
								echo '<div class="holiday-history-head"><div class="row">';
								echo '<div class="col-md-3"><span class="holiday-history-value">Name</span></div>';
								echo '<div class="col-md-1"><span class="holiday-history-value">Left</span></div>';
								echo '<div class="col-md-1"><span class="holiday-history-value">Pending</span></div>';
								echo '<div class="col-md-1"><span class="holiday-history-value">Sick</span></div>';
								echo '<div class="col-md-4"><span class="holiday-history-value">Upcoming Holiday</span></div>';
								echo '<div class="col-md-2"><span class="holiday-history-value">&nbsp;</span></div>';
								echo '</div></div>';
								
								foreach($employees as $employee){
									$holiday_company = get_holiday_company( $employee->ID );
									$next_holiday = get_next_holiday($employee->ID, 'approved');
									echo '<div class="holiday-history-content"><div class="row">';
									echo '<div class="col-md-3"><span class="holiday-history-value">'. $employee->first_name . ' ' . $employee->last_name . '</span></div>';
									echo '<div class="col-md-1"><span class="holiday-history-value">'.get_holidays_left($employee->ID).'</span></div>';
									
									
									echo '<div class="col-md-1"><span class="holiday-history-value">'.count(get_holiday_requests($employee->ID, 'pending-approval')).'</span></div>';
									echo '<div class="col-md-1"><span class="holiday-history-value">'.get_sick_days($employee->ID).'</span></div>';
									echo '<div class="col-md-4"><span class="holiday-history-value">';
									if($next_holiday){
										$days = get_holiday_request_days($next_holiday->ID);
										echo mysql2date('l, jS F Y', get_holiday_request_from($next_holiday->ID));
										if($days > 0){
											echo ' ('.$days.' days)';
										}else{
											echo ' ('.$days.' day)';
										}
										
									}else{
										echo 'None';
									}
									echo '</span></div>';
									echo '<div class="col-md-2"><span class="holiday-history-value"><a href="'.get_permalink().'?user_id='.$employee->ID.'">View Details</a></span></div>';
									echo '</div></div>';
								}
								echo '</div>';
							}else{
								echo '<p>No employees found!</p>';
							}
							echo '</div>';
							
						}
					}
					?>
                    </div>
                </div>
            
            </div>  <!-- /.container -->
        
        </div> <!-- /#site-content -->
    
    </div><!-- #post-<?php the_ID(); ?> -->
    <?php endwhile; ?>
</div>
<?php else:?>
<div id="content" class="content clearfix" role="main">

	<?php while ( have_posts() ) : the_post();?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
        <div id="site-content" class="site-content clearfix">
        	<div class="container">
            
                <div class="row">
                    
                    <div class="col-xs-12">
                    	<!--<h3>Hello <?php echo $_current_user->first_name;?>.</h3>-->
                        <?php the_content(); ?>

                    </div>
                    
                </div>
                
            </div>  <!-- /.container -->
            
            <div class="container">
            
                <div class="row">
                    
                    <div class="col-sm-6 col-xs-12">
                    
                    	<div class="dashboard-box">
                            <h3 class="dashboard-box-title">Holidays Left</h3>
                            
                            <div class="dashboard-box-content">
                            
                                <?php if($holidays_left = get_holidays_left($user_id)):?>
                                    <h4><?php echo $holidays_left;?></h4>
                                <?php endif;?>
                            
                            
                                <p><a href="<?php echo get_permalink(4);?>?user_id=<?php echo $user_id;?>" class="button">Request Holiday</a></p>
                            </div>
						</div> <!-- /.dashboard-box -->

                    </div>
                    
                    <div class="col-sm-6 col-xs-12">
                    
                    	<div class="dashboard-box">
                            <h3 class="dashboard-box-title">Next Bank Holiday</h3>
                            
                            <div class="dashboard-box-content">
                            
                                <?php if($bank_holiday = get_bank_holiday()):?>
                                    <h4><?php echo $bank_holiday['name'];?></h4>
                                    <p><?php echo mysql2date('l, jS F Y', $bank_holiday['date']);?></p>
                                <?php endif;?>
                            
                            
                                <p><a href="https://www.gov.uk/bank-holidays" target="_blank" class="button">Learn More</a></p>
                            </div>
						</div> <!-- /.dashboard-box -->
                        
                    </div>
                    
                </div> <!-- /.row -->
                
                <div class="row">
                    
                    <div class="col-sm-6 col-xs-12">

                    </div>
                    
                    <div class="col-sm-6 col-xs-12">

                    </div>
                    
                </div> <!-- /.row -->
                
                <div class="row">
                    
                    <div class="col-xs-12">
						
                        <h3>Holiday History</h3>
                        
                        <h4>Pending</h4>
                        <?php $pending_holidays = get_holiday_requests($user_id, 'pending-approval');?>
                        <?php if(isset($pending_holidays) && !empty($pending_holidays)):?>
                        
                        
                        <div class="holiday-history-table">
                        	<div class="holiday-history-head">
                        	<div class="row">
                                	<div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value">From</span>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value">To</span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value">Days</span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value">Status</span>
                                    </div>
                                    <div class="col-md-2 col-xs-12">
                                    	<span class="holiday-history-value">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php foreach($pending_holidays as $pending_holiday):?>
                            <div class="holiday-history-content">
                            	<div class="row">
                                	<div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', get_holiday_request_from($pending_holiday->ID));?></span>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', get_holiday_request_to($pending_holiday->ID));?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_days($pending_holiday->ID);?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_status($pending_holiday->ID)->name;?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-12">
                                    	<span class="holiday-history-value"><a href="<?php echo get_permalink($pending_holiday->ID);?>?pdf=<?php echo $pending_holiday->ID;?>" target="_blank">Print</a> / <a href="<?php echo get_permalink($pending_holiday->ID);?>">View</a></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        <?php else:?>
                        <p>There are no pending holiday requests.</p>
                        <?php endif;?>
                        
                        <?php $all_holidays = get_holiday_requests($user_id, array('approved', 'cancelled', 'not-approved'));?>
                        <h4>Other</h4>
                        <?php if(isset($all_holidays) && !empty($all_holidays)):?>
                        
                        <div class="holiday-history-table">
                            <div class="holiday-history-head">
                                <div class="row">
                                	<div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value">From</span>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value">To</span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value">Days</span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value">Status</span>
                                    </div>
                                    <div class="col-md-2 col-xs-12">
                                    	<span class="holiday-history-value">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php foreach($all_holidays as $all_holiday):?>
                            
                            
                            <div class="holiday-history-content">
                                <div class="row">
                                	<div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', get_holiday_request_from($all_holiday->ID));?></span>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', get_holiday_request_to($all_holiday->ID));?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_days($all_holiday->ID);?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_status($all_holiday->ID)->name;?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-12">
                                    	<span class="holiday-history-value"><a href="<?php echo get_permalink($all_holiday->ID);?>?pdf=<?php echo $all_holiday->ID;?>" target="_blank">Print</a> / <a href="<?php echo get_permalink($all_holiday->ID);?>">View</a></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        <?php else:?>
                        <p>There are no holiday requests.</p>
                        <?php endif;?>
                        
                    </div>
                    
                </div>
                
            </div>  <!-- /.container -->
            <?php if(isset($_GET['user_id'])):?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-6">
                        <p><a href="<?php echo home_url('/');?>" class="button">Back</a></p>
                    </div>
                    <div class="col-xs-6">
                    </div>
                </div>
            </div>
            <?php endif;?>
        
        </div> <!-- /#site-content -->
    
    </div><!-- #post-<?php the_ID(); ?> -->
    <?php endwhile; ?>
    
</div> <!-- /#content -->
<?php endif;?>
<?php get_footer(); ?>

