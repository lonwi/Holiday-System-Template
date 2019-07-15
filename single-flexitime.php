<?php
/*
$all_flexitimes = get_flexitime_requests();
foreach ($all_flexitimes as $flexitime){
	$flexitime_request_date = new DateTime(get_flexitime_request_date($flexitime->ID));
	update_post_meta( $flexitime->ID, '_flexitime_request_date', $flexitime_request_date->format('Y-m-d'));

}
print_result(count($all_flexitimes));
*/
if (isset($_GET['update_status']) && wp_verify_nonce($_GET['update_status'], 'approved')) {
	
	wp_set_object_terms( $post->ID, 'approved', 'flexitime_request_status', false );
	update_post_meta( $post->ID, '_flexitime_request_status', 'approved' );
	send_notification_email($post);
	wp_redirect( home_url() ); exit;
}
if (isset($_POST['_edit_flexitime_request_nonce']) && wp_verify_nonce($_POST['_edit_flexitime_request_nonce'], $post->ID)){
	$flexitime_request_status = sanitize_text_field( $_POST['_flexitime_request_status'] );
	wp_set_object_terms( $post->ID, $flexitime_request_status, 'flexitime_request_status', false );
	update_post_meta( $post->ID, '_flexitime_request_status', $flexitime_request_status );
	$msg = 'Updated!!';
	send_notification_email($post);
}
if (isset($_GET['_flexitime_cancel_nonce']) && wp_verify_nonce($_GET['_flexitime_cancel_nonce'], $post->ID)){
	wp_set_object_terms( $post->ID, 'cancelled', 'flexitime_request_status', false );
	update_post_meta( $post->ID, '_flexitime_request_status', 'cancelled' );
	$msg = 'Updated!!';
	send_notification_email($post);
}
$user_id = get_current_user_id();
$current_user = get_userdata( $user_id );

$request_status = get_flexitime_request_status($post->ID);
$request_statuses = get_flexitime_request_statuses();
$request_reason = get_flexitime_request_reason($post->ID);
$requested_date = get_flexitime_request_date($post->ID);
$requested_on = $post->post_date;
$user = get_userdata($post->post_author);

if(isset($_GET['pdf']) && $_GET['pdf'] == $post->ID):
$notes = '<br><br><br><br>';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Wojciech Bubolka');
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
$pdf->SetFont('helvetica', '', 12, '', true);

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
<h1 style="text-align:center;">Flexitime Request Form</h1>
<p>&nbsp;</p>
<table cellspacing="0" cellpadding="5" border="1">
	<tr>
		<th>Name</th>
		<td> '. $user->first_name . ' ' . $user->last_name . '</td>
	</tr>
	<tr>
		<th>Request Status</th>
		<td>'.$request_status->name.'</td>
	</tr>
	<tr>
		<th>Requested Date</th>
		<td>'.mysql2date('l, jS F Y', $requested_date).'</td>
	</tr>
	<tr>
		<th>Date of Request</th>
		<td>'.mysql2date('l, jS F Y - H:i', $post->post_date).'</td>
	</tr>
	<tr>
		<th>Reason</th>
		<td>'.$request_reason.'</td>
	</tr>
	<tr>
		<th colspan="2">Comments:<br>'.apply_filters('the_content',$post->post_content).'</th>
	</tr>
</table>
<p>&nbsp;</p>
<p>Signed ………………………………….  Print name …………………………………..</p>
<p>&nbsp;</p>
<h1 style="text-align:center;">Office Use Only</h1>
<table cellspacing="0" cellpadding="5" border="1">
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
elseif(current_user_can( 'manage_options' ) || (current_user_can( 'manage_holidays' ) && $current_user->ID != $post->post_author )):?>

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
                	<h3>Flexitime Request Details</h3>
                    <p>&nbsp;</p>
                    </div>
                </div>
        	</div>
            
            <form id="edit-flexitime-request" name="edit-flexitime-request" method="post" action="">
            	
                <?php wp_nonce_field( $post->ID, '_edit_flexitime_request_nonce' ); ?>
                
                
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
                            <span class="request-detail">Reason:</span>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <span class="request-detail"><?php echo $request_reason;?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <span class="request-detail">Requested Date:</span>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <span class="request-detail"><?php echo mysql2date('l, jS F Y', $requested_date);?></span>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <span class="request-detail">Status:</span>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <span class="request-detail">
                            	<select name="_flexitime_request_status">
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
                    
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <span class="request-detail">Comments:</span>
                        </div>
                        <div class="col-xs-6 col-md-8">
                            <span class="request-detail"><?php echo apply_filters('the_content',$post->post_content);?></span>
                        </div>
                    </div>
                    
                </div>
                
                
                <div class="container">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><a href="<?php echo home_url('/');?>?user_id=<?php echo $user->ID;?>" class="button">Back</a></p>
                        </div>
                        <div class="col-xs-6">
                        	<p class="text-right"><input type="submit" name="flexitime-request" class="button" value="Update"></p>
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
                	<h3>Flexitime Request Details</h3>
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
                        <span class="request-detail">Reason:</span>
                    </div>
                    <div class="col-xs-6 col-md-8">
                        <span class="request-detail"><?php echo $request_reason;?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <span class="request-detail">Requested Date:</span>
                    </div>
                    <div class="col-xs-6 col-md-8">
                        <span class="request-detail"><?php echo mysql2date('l, jS F Y', $requested_date);?></span>
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
                
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <span class="request-detail">Comments:</span>
                    </div>
                    <div class="col-xs-6 col-md-8">
                        <span class="request-detail"><?php echo apply_filters('the_content',$post->post_content);?></span>
                    </div>
                </div>
                
        	</div>
            
            <div class="container">
            	<div class="row">
                	<div class="col-xs-6">
						<p><a href="<?php echo home_url('/');?>" class="button">Back</a></p>
                    </div>
                    <div class="col-xs-6">
                    	<?php if($request_status->slug == 'pending-approval' || $request_status->slug == 'approved'):?>
						<p class="text-right"><a href="<?php echo wp_nonce_url( get_permalink($post->ID), $post->ID, '_flexitime_cancel_nonce' );?>" class="button">Cancel Request</a></p>
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