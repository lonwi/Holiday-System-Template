<?php if(isset($_GET['pdf']) && $_GET['pdf'] == $post->ID):?>
<?php
$request_type = get_holiday_request_type($post->ID);
$request_status = get_holiday_request_status($post->ID);

$notes = '<br><br><br>';
if($request_status->slug == 'approved'){
	$notes = 'Already Approved<br><br>';
}

$request_days = get_holiday_request_days($post->ID);
$request_from = get_holiday_request_from($post->ID);
$request_to = get_holiday_request_to($post->ID);

$user = get_userdata($post->post_author);

$holidays_left = get_holidays_left($user->ID);
$holidays_used = get_holidays_used($user->ID);

$year = get_holiday_year($post->ID);

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
		<td> '. $user->first_name . ' ' . $user->last_name . '</td>
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
?>

<?php else:?>

<?php get_header(); ?>

<div id="content" class="content clearfix" role="main">

	<?php while ( have_posts() ) : the_post();?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
        <div id="site-content" class="site-content clearfix">
        	single holiday request
        </div> <!-- /#site-content -->
    
    </div><!-- #post-<?php the_ID(); ?> -->
    <?php endwhile; ?>
    
</div> <!-- /#content -->

<?php get_footer(); ?>
<?php endif;?>