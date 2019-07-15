<?php
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
            </form>
            </span>
        </div>
    </div> <!-- /.row -->
</div> <!-- /.container -->
<div class="container">
	<div class="row">
    	<div class="col-xs-12">
        	<h3 style="text-align:center;">Employee History for <?php echo $set_year;?></h3>
    	</div>
    </div> <!-- /.row -->
	<div class="row">
    	<div class="col-xs-12">
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
						echo '<div class="col-md-3"><span class="holiday-history-value">Name</span></div>';
						echo '<div class="col-md-2"><span class="holiday-history-value">Used</span></div>';
						echo '<div class="col-md-2"><span class="holiday-history-value">Pending</span></div>';
						echo '<div class="col-md-2"><span class="holiday-history-value">Sick</span></div>';
						echo '<div class="col-md-2"><span class="holiday-history-value">Flexitime</span></div>';
						echo '<div class="col-md-1"><span class="holiday-history-value">&nbsp;</span></div>';
						echo '</div></div>';
						
						foreach($employees as $employee){
							echo '<div class="holiday-history-content"><div class="row">';
							echo '<div class="col-md-3"><span class="holiday-history-value">'. $employee->first_name . ' ' . $employee->last_name . '</span></div>';
							echo '<div class="col-md-2"><span class="holiday-history-value">'.get_holidays_used($employee->ID,$set_year).'</span></div>';
							echo '<div class="col-md-2"><span class="holiday-history-value">'.count(get_holiday_requests($employee->ID, 'pending-approval', $set_year)).'</span></div>';
							echo '<div class="col-md-2"><span class="holiday-history-value">'.get_sick_days($employee->ID,$set_year).'</span></div>';
							echo '<div class="col-md-2"><span class="holiday-history-value">'.get_flexitime_days($employee->ID,$set_year).'</span></div>';
							echo '<div class="col-md-1"><span class="holiday-history-value"><a href="'.get_permalink().'?user_id='.$employee->ID.'&holiday_year='.$set_year.'">View</a></span></div>';
							echo '</div></div>';
						}
					}else{
						echo '<p>No employees found!</p>';
					}
					echo '</div>';
					
				}
			}
			?>
    	</div>
    </div> <!-- /.row -->
</div> <!-- /.container -->

<?php endif;?>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <p><a href="<?php echo home_url('/');?>" class="button">Back</a></p>
        </div>
        <div class="col-xs-6">
			&nbsp;
        </div>
    </div>
</div>