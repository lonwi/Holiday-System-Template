<?php
if( ( current_user_can( 'manage_options' ) || current_user_can( 'manage_holidays' ) ) && isset($_GET['user_id'])){
	$user_id = $_GET['user_id'];
}else{
	$user_id = get_current_user_id();
}	
$_current_user = get_userdata( $user_id );
$years = range(date("Y")-1, 2015);
if(isset($_GET["holiday_year"])){
	$set_year = $_GET["holiday_year"];
}else{
	$set_year = date("Y")-1;
}
?>
<?php if(isset($years) && !empty($years)):?>
<div class="container">
	<div class="row">
        <div class="col-xs-6 col-md-4">
            <span>Change Year:</span>
        </div>
        <div class="col-xs-6 col-md-8">
            <span>
            <form action="<?php echo get_permalink();?>" id="change-year" method="get">
                <select id="year" name="holiday_year">
					<?php foreach($years as $year):?>
                    <option value="<?php echo $year;?>" <?php echo $set_year == $year ? "selected" : "";?>><?php echo $year;?></option>
                    <?php endforeach;?>
                </select>
                <input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
            </form>
            </span>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container -->
<div class="container">
	<div class="row">
    	<div class="col-xs-12">
        	<h3 style="text-align:center;">Holiday History <?php echo $set_year;?></h3>
                        
				<?php $all_holidays = get_holiday_requests($user_id, null, $set_year);?>
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
                <p>There are no holiday requests for <?php echo $set_year;?>.</p>
                <?php endif;?>
    	</div>
    </div> <!-- /.row -->
</div> <!-- /.container -->

<div class="container">
	<div class="row">
        <div class="col-xs-12">
        
            <h3 style="text-align:center;">Flexitime History <?php echo $set_year;?></h3>
            <?php $all_flexitimes = get_flexitime_requests( $user_id, null, $set_year);?>
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
                            <span class="holiday-history-value"><?php echo mysql2date('l, jS F Y', get_flexitime_request_date($flexitime->ID));?></span>
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
            <p>There are no flexitime requests for <?php echo $set_year;?>.</p>
            <?php endif;?>
        </div>
    </div>
</div> <!-- /.container -->

<?php endif;?>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <p><a href="<?php echo get_permalink(191);?>" class="button">Back</a></p>
        </div>
        <div class="col-xs-6">
			&nbsp;
        </div>
    </div>
</div>