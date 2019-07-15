<?php
/*
Template Name: Dashboard
*/
?>
<?php get_header(); ?>
<?php
	if( ( current_user_can( 'manage_options' ) || current_user_can( 'manage_holidays' ) ) && isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
	}else{
		$user_id = get_current_user_id();
	}	
	$_current_user = get_userdata( $user_id );
?>
<?php if(current_user_can( 'manage_options' ) && !isset($_GET['user_id']) || current_user_can( 'manage_holidays' ) && !isset($_GET['user_id'])):?>
<div id="content" class="content clearfix" role="main">
	<?php while ( have_posts() ) : the_post();?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	
        <div id="site-content" class="site-content clearfix">
        
        	<div class="container">
            	<div class="row">
                    
                    <div class="col-sm-6 col-xs-12">
                    
                    	<div class="dashboard-box">
                            <h3 class="dashboard-box-title">Employees on Flexitime</h3>
                            
                            <div class="dashboard-box-content">
								<?php echo get_users_on_flexitime($user_id);?>
                            </div>
						</div> <!-- /.dashboard-box -->

                    </div>
                    
                    <div class="col-sm-6 col-xs-12">
						
                        <div class="dashboard-box">
                            <h3 class="dashboard-box-title">Employees on Holiday</h3>
                            
                            <div class="dashboard-box-content">
                            
                            	<?php echo get_users_on_holiday($user_id);?>
                                
                            </div>
						</div> <!-- /.dashboard-box -->
                        
                    </div>
                    
                </div> <!-- /.row -->
                
            </div> <!-- /.container -->
        	
            <div class="container">
            	
                <div class="row">
                    
                    <div class="col-xs-12">
                    	<?php if(current_user_can( 'manage_holidays' ) && !current_user_can( 'manage_options' )):?>
                        <div class="dashboard-box" style="min-height: auto;">
                            <div class="dashboard-box-content">
                                <p><a href="<?php echo home_url('/');?>?user_id=<?php echo $_current_user->ID;?>" class="button">Request Holiday</a></p>
                            </div>
						</div> <!-- /.dashboard-box -->
						<?php endif;?>
                    
                    	<h3 style="text-align:center;">Pending Holiday Requests</h3>
                        <?php $pending_holidays = get_holiday_requests( 0, 'pending-approval');?>
                        <?php if(isset($pending_holidays) && !empty($pending_holidays)):?>
                        
                        
                        <div class="holiday-history-table">
                        	<div class="holiday-history-head">
                        	<div class="row">
                            		<div class="col-md-2 col-xs-6">
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
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value">Type</span>
                                    </div>
                                    <div class="col-md-2 col-xs-12">
                                    	<span class="holiday-history-value">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php foreach($pending_holidays as $pending_holiday):?>
                            <div class="holiday-history-content">
                            	<div class="row">
                                	<div class="col-md-2 col-xs-6">
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
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_type($pending_holiday->ID)->name;?></span>
                                    </div>
                                    
                                    <div class="col-md-2 col-xs-12">
                                    	<span class="holiday-history-value"><a href="<?php echo get_permalink($pending_holiday->ID);?>?pdf=<?php echo $pending_holiday->ID;?>" target="_blank">Print</a> / <a href="<?php echo get_permalink($pending_holiday->ID);?>?home=1">View</a> <?php if(current_user_can( 'manage_options' ) || ( current_user_can( 'manage_holidays') &&  $pending_holiday->post_author != $_current_user->ID )):?>/ <a href="<?php echo wp_nonce_url(get_permalink($pending_holiday->ID), 'approved', 'update_status');?>">Approve</a><?php endif;?></span>
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
            </div>  <!-- /.container -->
            
            
            <div class="container">
            	
                <div class="row">
                    
                    <div class="col-xs-12">
                    
                    	<h3 style="text-align:center;">Pending Flexitime Requests</h3>
                        <?php $pending_flexitimes = get_flexitime_requests( 0, 'pending-approval');?>
                        <?php if(isset($pending_flexitimes) && !empty($pending_flexitimes)):?>
                        
                        
                        <div class="holiday-history-table">
                        	<div class="holiday-history-head">
                        	<div class="row">
                            		<div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value">Name</span>
                                    </div>
                                	<div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value">Requested On</span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value">Requested Day</span>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value">Reason</span>
                                    </div>
                                    <div class="col-md-2 col-xs-12">
                                    	<span class="holiday-history-value">&nbsp;</span>
                                    </div>
                                </div>
                            </div>
                            
                            <?php foreach($pending_flexitimes as $pending_flexitime):?>
                            <div class="holiday-history-content">
                            	<div class="row">
                                	<div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo the_author_meta( 'display_name' , $pending_flexitime->post_author );?></span>
                                    </div>
                                	<div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo mysql2date('l, jS F Y - H:i', $pending_flexitime->post_date);?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', get_flexitime_request_date($pending_flexitime->ID));?></span>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_flexitime_request_reason($pending_flexitime->ID);?></span>
                                    </div>
                                    
                                    <div class="col-md-2 col-xs-12">
                                    	<span class="holiday-history-value"><a href="<?php echo get_permalink($pending_flexitime->ID);?>?pdf=<?php echo $pending_flexitime->ID;?>" target="_blank">Print</a> / <a href="<?php echo get_permalink($pending_flexitime->ID);?>?home=1">View</a> <?php if(current_user_can( 'manage_options' ) || ( current_user_can( 'manage_holidays') &&  $pending_flexitime->post_author != $_current_user->ID )):?>/ <a href="<?php echo wp_nonce_url(get_permalink($pending_flexitime->ID), 'approved', 'update_status');?>">Approve</a><?php endif;?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        <?php else:?>
                        <p>There are no pending flexitime requests.</p>
                        <?php endif;?>
            		</div>
                </div>
            </div>  <!-- /.container -->
            
            
            <div class="container">
            	
                <div class="row">
                	
                    <div class="col-xs-12">
                    <h3 style="text-align:center;">Employee History</h3>
                    <?php
					$companies = get_terms('company', array('hide_empty' => true));
					if(isset($companies) && !empty($companies)){
						foreach($companies as $company){
							echo '<h4>'.esc_attr($company->name).'</h4>';
							echo '<div class="holiday-history-table clearfix">';
							$employees = array();
							$roles = array('employee', 'manager');
							foreach ($roles as $role) :
							$results = get_users(array('role'=> $role, 'orderby'=>'display_name', 'meta_key' => '_holiday_company', 'meta_value' => $company->slug));
							if ($results) $employees = array_merge($employees, $results);
							endforeach;
							
							if(isset($employees) && !empty($employees)){
								echo '<div class="holiday-history-head"><div class="row">';
								echo '<div class="col-md-2"><span class="holiday-history-value">Name</span></div>';
								echo '<div class="col-md-1"><span class="holiday-history-value">Used</span></div>';
								echo '<div class="col-md-1"><span class="holiday-history-value">Left</span></div>';
								echo '<div class="col-md-1"><span class="holiday-history-value">Pending</span></div>';
								echo '<div class="col-md-1"><span class="holiday-history-value">Sick</span></div>';
								echo '<div class="col-md-1"><span class="holiday-history-value">Unpaid</span></div>';
								echo '<div class="col-md-1"><span class="holiday-history-value">Flexitime</span></div>';
								echo '<div class="col-md-3"><span class="holiday-history-value">Upcoming Holiday</span></div>';
								echo '<div class="col-md-1"><span class="holiday-history-value">&nbsp;</span></div>';
								echo '</div></div>';
								
								foreach($employees as $employee){
									$holiday_company = get_holiday_company( $employee->ID );
									$next_holiday = get_next_holiday($employee->ID, 'approved');
									echo '<div class="holiday-history-content"><div class="row">';
									echo '<div class="col-md-2"><span class="holiday-history-value">'. $employee->first_name . ' ' . $employee->last_name . '</span></div>';
									echo '<div class="col-md-1"><span class="holiday-history-value">'.get_holidays_used($employee->ID).'</span></div>';
									echo '<div class="col-md-1"><span class="holiday-history-value">'.get_holidays_left($employee->ID).'</span></div>';
									
									
									echo '<div class="col-md-1"><span class="holiday-history-value">'.count(get_holiday_requests($employee->ID, 'pending-approval')).'</span></div>';
									echo '<div class="col-md-1"><span class="holiday-history-value">'.get_sick_days($employee->ID).'</span></div>';
									echo '<div class="col-md-1"><span class="holiday-history-value">'.get_unpaid_days($employee->ID).'</span></div>';
									echo '<div class="col-md-1"><span class="holiday-history-value">'.get_flexitime_days($employee->ID).'</span></div>';
									echo '<div class="col-md-3"><span class="holiday-history-value">';
									if($next_holiday){
										$days = get_holiday_request_days($next_holiday->ID);
										echo mysql2date('l, jS F Y', get_holiday_request_from($next_holiday->ID));
										if($days > 1){
											echo ' ('.$days.' days)';
										}else{
											echo ' ('.$days.' day)';
										}
										
									}else{
										echo 'None';
									}
									echo '</span></div>';
									echo '<div class="col-md-1"><span class="holiday-history-value"><a href="'.get_permalink().'?user_id='.$employee->ID.'">View</a></span></div>';
									echo '</div></div>';
								}
							}else{
								echo '<p>No employees found!</p>';
							}
							echo '</div>';
							
						}
					}
					?>
                    <p class="text-center"><a href="<?php echo get_permalink(84);?>" class="button">View Current Month</a> <a href="<?php echo get_permalink(191);?>" class="button">View Previous Years</a> </p>
                    </div>
                </div> <!-- /.row -->
            
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
                        <?php if(current_user_can( 'manage_holidays' ) && !current_user_can( 'manage_options' )):?>
                        <div class="dashboard-box" style="min-height: auto;">
                            <div class="dashboard-box-content">
                                <p><a href="<?php echo home_url('/');?>" class="button">Manage Holidays</a></p>
                            </div>
						</div> <!-- /.dashboard-box -->
						<?php endif;?>
                    </div>
                    
                </div>
                
            </div>  <!-- /.container -->
            
            <div class="container">
            
                <div class="row">
                    
                    <div class="col-sm-6 col-xs-12">
                    
                    	<div class="dashboard-box">
                            <h3 class="dashboard-box-title">Holidays Left</h3>
                            
                            <div class="dashboard-box-content">
                            
                                <?php if(($holidays_left = get_holidays_left($user_id)) > 0):?>
                                    <h4><?php echo $holidays_left;?></h4>
                                <?php else:?>
                                	<h4>0</h4>
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
                                    <h4><?php echo $bank_holiday['title'];?></h4>
                                    <p><?php echo $bank_holiday['notes'];?></p>
                                    <p><?php echo mysql2date('l, jS F Y', $bank_holiday['date']);?></p>
                                <?php endif;?>
                            
                            
                                <p><a href="https://www.gov.uk/bank-holidays" target="_blank" class="button">Learn More</a></p>
                            </div>
						</div> <!-- /.dashboard-box -->
                        
                    </div>
                    
                </div> <!-- /.row -->
                
                <div class="row">
                    
                    <div class="col-sm-6 col-xs-12">
                    
                    	<div class="dashboard-box">
                            <h3 class="dashboard-box-title">Flexitimes Used This Year</h3>
                            
                            <div class="dashboard-box-content">

                                <h4><?php echo get_flexitime_days($user_id);?></h4>
                            
                                <p><a href="<?php echo get_permalink(51);?>?user_id=<?php echo $user_id;?>" class="button">Request Flexitime</a></p>
                            </div>
						</div> <!-- /.dashboard-box -->

                    </div>
                    
                    <div class="col-sm-6 col-xs-12">
						
                        <div class="dashboard-box">
                            <h3 class="dashboard-box-title">Employees on Holiday</h3>
                            
                            <div class="dashboard-box-content">
                            
                            	<?php echo get_users_on_holiday($user_id);?>
                                
                            </div>
						</div> <!-- /.dashboard-box -->
                        
                    </div>
                    
                </div> <!-- /.row -->
                
                <div class="row">
                    
                    <div class="col-xs-12">
						
                        <h3 style="text-align:center;">Pending Holiday Requests</h3>
                        
                        <h4></h4>
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
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value">Days</span>
                                    </div>
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value">Type</span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value">Status</span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
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
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_days($pending_holiday->ID);?></span>
                                    </div>
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_type($pending_holiday->ID)->name;?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_status($pending_holiday->ID)->name;?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
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
              
              <div class="row">
                    
                <div class="col-xs-12">
                
                    <h3 style="text-align:center;">Pending Flexitime Requests</h3>
                    <?php $pending_flexitimes = get_flexitime_requests( $user_id, 'pending-approval');?>
                    <?php if(isset($pending_flexitimes) && !empty($pending_flexitimes)):?>
                    
                    
                    <div class="holiday-history-table">
                        <div class="holiday-history-head">
                        <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    <span class="holiday-history-value">Name</span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value">Requested On</span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value">Requested Day</span>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <span class="holiday-history-value">Reason</span>
                                </div>
                                <div class="col-md-2 col-xs-12">
                                    <span class="holiday-history-value">&nbsp;</span>
                                </div>
                            </div>
                        </div>
                        
                        <?php foreach($pending_flexitimes as $pending_flexitime):?>
                        <div class="holiday-history-content">
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    <span class="holiday-history-value"><?php echo the_author_meta( 'display_name' , $pending_flexitime->post_author );?></span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', $pending_flexitime->post_date);?></span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', get_flexitime_request_date($pending_flexitime->ID));?></span>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <span class="holiday-history-value"><?php echo get_flexitime_request_reason($pending_flexitime->ID);?></span>
                                </div>
                                
                                <div class="col-md-2 col-xs-12">
                                    <span class="holiday-history-value"><a href="<?php echo get_permalink($pending_flexitime->ID);?>?pdf=<?php echo $pending_flexitime->ID;?>" target="_blank">Print</a> / <a href="<?php echo get_permalink($pending_flexitime->ID);?>">View</a></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <?php else:?>
                    <p>There are no pending flexitime requests.</p>
                    <?php endif;?>
                </div>
            </div>          
                        
              <div class="row">
                    
                    <div class="col-xs-12">          
                        
                        <h3 style="text-align:center;">Holiday History</h3>
                        
                        <?php $all_holidays = get_holiday_requests($user_id, array('approved', 'cancelled', 'not-approved'), date('Y'), '>=');?>
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
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value">Days</span>
                                    </div>
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value">Type</span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value">Status</span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
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
                                    <div class="col-md-1 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_days($all_holiday->ID);?></span>
                                    </div>
                                    <div class="col-md-1 col-xs-6">
                                        <span class="holiday-history-value"><?php echo get_holiday_request_type($all_holiday->ID)->name;?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                    	<span class="holiday-history-value"><?php echo get_holiday_request_status($all_holiday->ID)->name;?></span>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
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
                
                <div class="row">
                    
                <div class="col-xs-12">
                
                    <h3 style="text-align:center;">Flexitime History</h3>
                    <?php $all_flexitimes = get_flexitime_requests( $user_id, array('approved', 'cancelled', 'not-approved'), date('Y'), '>=');?>
                    <?php if(isset($all_flexitimes) && !empty($all_flexitimes)):?>
                    
                    
                    <div class="holiday-history-table">
                        <div class="holiday-history-head">
                        <div class="row">
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value">Name</span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value">Requested On</span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value">Requested Day</span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value">Reason</span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value">Status</span>
                                </div>
                                <div class="col-md-2 col-xs-12">
                                    <span class="holiday-history-value">&nbsp;</span>
                                </div>
                            </div>
                        </div>
                        
                        <?php foreach($all_flexitimes as $flexitime):?>
                        <?php $request_status = get_flexitime_request_status($flexitime->ID);?>
                        <div class="holiday-history-content">
                            <div class="row">
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value"><?php echo the_author_meta( 'display_name' , $flexitime->post_author );?></span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', $flexitime->post_date);?></span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', get_flexitime_request_date($flexitime->ID)).' '.get_flexitime_request_date($flexitime->ID);?></span>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value"><?php echo get_flexitime_request_reason($flexitime->ID);?></span>
                                </div>
                                
                                <div class="col-md-2 col-xs-6">
                                    <span class="holiday-history-value"><?php echo $request_status->name;?></span>
                                </div>
                                
                                <div class="col-md-2 col-xs-12">
                                    <span class="holiday-history-value"><a href="<?php echo get_permalink($flexitime->ID);?>?pdf=<?php echo $flexitime->ID;?>" target="_blank">Print</a> / <a href="<?php echo get_permalink($flexitime->ID);?>">View</a></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                    <?php else:?>
                    <p>There are no pending flexitime requests.</p>
                    <?php endif;?>
                    <p class="text-center"><a href="<?php echo get_permalink(191);?>?user_id=<?php echo $user_id;?>" class="button">View Past Years</a></p>
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

