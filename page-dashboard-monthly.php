<?php
/*
Template Name: Dashboard Month
*/

$month = date('m');
$year = date('Y')
?>
<?php get_header(); ?>

<?php if( current_user_can( 'manage_options' ) || current_user_can( 'manage_holidays' ) ):?>


<div id="content" class="content clearfix" role="main">

	<?php while ( have_posts() ) : the_post();?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
        <div id="site-content" class="site-content clearfix">
            
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">

						<h3 style="text-align:center;">Monthly Summary</h3>
                        
                    </div>
                </div>
            </div> <!-- /.container -->
            
            <?php $companies = get_terms('company', array('hide_empty' => true));?>
            <?php if(isset($companies) && !empty($companies)):?>
				<?php foreach($companies as $company):?>
            		<h4 style="text-align:center;"><?php echo $company->name;?></h4>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
        
                                <?php 
								$employees = array();
								$roles = array('employee', 'manager');
								foreach ($roles as $role) {
									$results = get_users(array('role'=> $role, 'orderby'=>'display_name', 'meta_key' => '_holiday_company', 'meta_value' => $company->slug));
									if ($results) $employees = array_merge($employees, $results);
								};
                                ?>
                                <?php if(isset($employees) && !empty($employees)):?>
                                	<div class="holiday-history-head">
                                    	<div class="row">
                                        	<div class="col-md-3"><span class="holiday-history-value">Name</span></div>
                                            <div class="col-md-2"><span class="holiday-history-value">Paid</span></div>
                                            <div class="col-md-2"><span class="holiday-history-value">Unpaid</span></div>
                                            <div class="col-md-2"><span class="holiday-history-value">Sickness</span></div>
                                        </div>
                                    </div>
                                    
                                    <?php foreach($employees as $employee):?>
                                    	
                                     	<div class="holiday-history-content">
                                        	<div class="row">
                                            	<div class="col-md-3"><span class="holiday-history-value"><?php echo $employee->first_name . ' ' . $employee->last_name;?></span></div>
                                                <div class="col-md-2">
                                                	<span class="holiday-history-value">
														<?php echo get_paid_holidays_by_month($employee->ID, $month, $year);?>
                                                    </span>
                                                </div>
                                                <div class="col-md-2">
                                                	<span class="holiday-history-value">
														<?php echo get_unpaid_holidays_by_month($employee->ID, $month, $year);?>
                                                    </span>
                                                </div>
                                                <div class="col-md-2">
                                                	<span class="holiday-history-value">
														<?php echo get_sickdays_by_month($employee->ID, $month, $year);?>
                                                    </span>
                                                </div>
                                            </div> 
                                        </div>
                                        
                                    <?php endforeach;?>
                                    
                                <?php endif;?>
        
                            </div>
                        </div>
                    </div> <!-- /.container -->
                    
            	<?php endforeach;?>
            <?php endif;?>
            
            
        </div> <!-- /#site-content -->
    
    </div><!-- #post-<?php the_ID(); ?> -->
    <?php endwhile; ?>
    
</div> <!-- /#content -->

<?php endif;?>
<?php get_footer(); ?>