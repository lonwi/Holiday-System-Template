<?php
if (isset($_POST['_edit_holiday_request_nonce']) && wp_verify_nonce($_POST['_edit_holiday_request_nonce'], $post->ID)){
	$holiday_request_status = sanitize_text_field( $_POST['_holiday_request_status'] );
	wp_set_object_terms( $post->ID, $holiday_request_status, 'holiday_request_status', false );
	update_post_meta( $post->ID, '_holiday_request_status', $holiday_request_status );
	$msg = 'Updated!!';
}
if (isset($_GET['_cancel_nonce']) && wp_verify_nonce($_GET['_cancel_nonce'], $post->ID)){
	wp_set_object_terms( $post->ID, 'cancelled', 'holiday_request_status', false );
	update_post_meta( $post->ID, '_holiday_request_status', 'cancelled' );
	$msg = 'Updated!!';
}

$request_type = get_holiday_request_type($post->ID);
$request_status = get_holiday_request_status($post->ID);
$request_statuses = get_holiday_request_statuses();
$request_days = get_holiday_request_days($post->ID);
$request_from = get_holiday_request_from($post->ID);
$request_to = get_holiday_request_to($post->ID);

$user = get_userdata($post->post_author);

$holidays_left = get_holidays_left($user->ID);
$holidays_used = get_holidays_used($user->ID);

$year = get_holiday_year($post->ID);

if(isset($_GET['pdf']) && $_GET['pdf'] == $post->ID):

	$notes = '<br><br><br>';
	if($request_status->slug == 'approved'){
		$notes = 'Already Approved<br><br>';
	}

	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor(false);
	$pdf->SetTitle('Holiday Request Form');
	$pdf->SetSubject(false);
	$pdf->SetKeywords(false);
	
	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	
	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	
	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	// set default font subsetting mode
	$pdf->setFontSubsetting(true);
	
	// Set font
	$pdf->SetFont('helvetica', '', 14, '', true);
	
	// Add a page
	$pdf->AddPage();
	
	
	// Set some content to print
	$html = '
	<style>
		table {
			width:100%;
		}
		th {
		}
		td {
			text-align:center;
		}
	
	</style>
	<h1 style="text-align:center;">Holiday Request Form</h1>
	<p>&nbsp;</p>
	<table cellspacing="0" cellpadding="5" border="1">
		<tr>
			<th>Name</th>
			<td>'. $user->first_name . ' ' . $user->last_name . '</td>
		</tr>
		<tr>
			<th>Days Requested</th>
			<td>'.$request_days.'</td>
		</tr>
		<tr>
			<th>From</th>
			<td>'.mysql2date('l, jS F Y', $request_from).'</td>
		</tr>
		<tr>
			<th>To</th>
			<td>'.mysql2date('l, jS F Y', $request_to).'</td>
		</tr>
		<tr>
			<th>Date of Request</th>
			<td>'.mysql2date('l, jS F Y', $post->post_date).'</td>
		</tr>
		<tr>
			<th>Holidays Taken in '.$year.'</th>
			<td>'.$holidays_used.'</td>
		</tr>
		<tr>
			<th>Remaining Holidays in '.$year.'</th>
			<td>'.$holidays_left.'</td>
		</tr>
	</table>
	<p>&nbsp;</p>
	<p>Signed ………………………………….  Print name …………………………………..</p>
	<p style="font-size:13px; font-style:italic;">Please note all holiday request forms must be submitted 7 days before due date of holiday request.</p>
	<p>&nbsp;</p>
	<h1 style="text-align:center;">Office Use Only</h1>
	<table cellspacing="0" cellpadding="5" border="1">
		<tr>
			<th>Holiday Type</th>
			<td>'.$request_type->name.'</td>
		</tr>
		<tr>
			<th>Notes</th>
			<td>'.$notes.'</td>
		</tr>
		<tr>
			<th>Processing Date</th>
			<td></td>
		</tr>
	</table>
	<p>&nbsp;</p>
	<p>Signed ………………………………….  Print name …………………………………..</p>
	
	';
	
	// Print text using writeHTMLCell()
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	
	// ---------------------------------------------------------
	
	$pdf->Output(sanitize_title($post->post_title).'.pdf', 'I');

elseif(current_user_can( 'manage_options' )):?>
<?php get_header(); ?>

<div id="content" class="content clearfix" role="main">

	<?php while ( have_posts() ) : the_post();?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
        <div id="site-content" class="site-content clearfix">
        	<?php if(isset($msg)):?>
        	<div class="container">
            	<div class="row">
                	<div class="col-xs-12">
                		<div class="info-box clearfix"><?php echo $msg;?></div>
                    </div>
                </div>
        	</div>
            <?php endif;?>
        	<div class="container">
            	<div class="row">
                	<div class="col-xs-12">
                	<h3>Request Details</h3>
                    <p>&nbsp;</p>
                    </div>
                </div>
        	</div>
            
            <form id="edit-holiday-request" name="edit-holiday-request" method="post" action="">
            	
                <?php wp_nonce_field( $post->ID, '_edit_holiday_request_nonce' ); ?>
                
                <div class="container request-details">
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <span class="request-detail">Name:</span>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <span class="request-detail"><?php echo $user->first_name . ' ' . $user->last_name;?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <span class="request-detail">Days Requested:</span>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <span class="request-detail"><?php echo $request_days;?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <span class="request-detail">From:</span>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <span class="request-detail"><?php echo mysql2date('l, jS F Y', $request_from);?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <span class="request-detail">To:</span>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <span class="request-detail"><?php echo mysql2date('l, jS F Y', $request_to);?></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <span class="request-detail">Type:</span>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <span class="request-detail"><?php echo $request_type->name;?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <span class="request-detail">Status:</span>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <span class="request-detail">
                            	
                                <select name="_holiday_request_status">
									<?php if(isset($request_statuses) && !empty($request_statuses)):?>
                                        <?php foreach($request_statuses as $status):?>
                                        <option value="<?php echo $status->slug;?>" <?php echo $request_status->slug === $status->slug ? "selected" : "";?>><?php echo $status->name;?></option>
                                        <?php endforeach;?>
                                    <?php else:?>
                                        <option value="">Please Add Request Status</option>
                                    <?php endif;?>
                                </select>
                            
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="container">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><a href="<?php echo home_url('/');?>?user_id=<?php echo $user->ID;?>" class="button">Back</a></p>
                        </div>
                        <div class="col-xs-6">
                        	<p class="text-right"><input type="submit" name="holiday-request" class="button" value="Update"></p>
                        </div>
                    </div>
                </div>
            
            </form>
        
        </div> <!-- /#site-content -->
    
    </div><!-- #post-<?php the_ID(); ?> -->
    <?php endwhile; ?>
    
</div> <!-- /#content -->

<?php get_footer(); ?>

<?php else:?>

<?php get_header(); ?>

<div id="content" class="content clearfix" role="main">

	<?php while ( have_posts() ) : the_post();?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
        <div id="site-content" class="site-content clearfix">
        
        	<div class="container">
            	<div class="row">
                	<div class="col-xs-12">
                	<h3>Request Details</h3>
                    <p>&nbsp;</p>
                    </div>
                </div>
        	</div>
        	<div class="container request-details">
            	<div class="row">
                    <div class="col-xs-6 col-md-4">
                        <span class="request-detail">Name:</span>
                    </div>
                    <div class="col-xs-6 col-md-8">
                        <span class="request-detail"><?php echo $user->first_name . ' ' . $user->last_name;?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <span class="request-detail">Days Requested:</span>
                    </div>
                    <div class="col-xs-6 col-md-8">
                        <span class="request-detail"><?php echo $request_days;?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <span class="request-detail">From:</span>
                    </div>
                    <div class="col-xs-6 col-md-8">
                        <span class="request-detail"><?php echo mysql2date('l, jS F Y', $request_from);?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <span class="request-detail">To:</span>
                    </div>
                    <div class="col-xs-6 col-md-8">
                        <span class="request-detail"><?php echo mysql2date('l, jS F Y', $request_to);?></span>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <span class="request-detail">Type:</span>
                    </div>
                    <div class="col-xs-6 col-md-8">
                        <span class="request-detail"><?php echo $request_type->name;?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <span class="request-detail">Status:</span>
                    </div>
                    <div class="col-xs-6 col-md-8">
                        <span class="request-detail"><?php echo $request_status->name;?></span>
                    </div>
                </div>
        	</div>
            
            <div class="container">
            	<div class="row">
                	<div class="col-xs-6">
						<p><a href="<?php echo home_url('/');?>" class="button">Back</a></p>
                    </div>
                    <div class="col-xs-6">
                    	<?php if($request_status->slug == 'pending-approval'):?>
						<p class="text-right"><a href="<?php echo wp_nonce_url( get_permalink($post->ID), $post->ID, '_cancel_nonce' );?>" class="button">Cancel Request</a></p>
                        <?php endif;?>
                    </div>
                </div>
        	</div>
        
        </div> <!-- /#site-content -->
    
    </div><!-- #post-<?php the_ID(); ?> -->
    <?php endwhile; ?>
    
</div> <!-- /#content -->

<?php get_footer(); ?>
<?php endif;?>