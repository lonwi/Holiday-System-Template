<?php

add_action( 'template_redirect', 'redirect_to_specific_page' );
function redirect_to_specific_page() {
	if ( !is_page(8) && !is_user_logged_in() ) {
		wp_redirect( get_permalink(8), 301 ); 
		exit;
	}elseif(is_page(8) && is_user_logged_in()){
		wp_redirect( home_url(), 301 ); 
		exit;
	}
}


add_filter( 'login_form_middle', '_wr_no_captcha_render_login_captcha' );
function _wr_no_captcha_render_login_captcha(){
	return '<div class="g-recaptcha" data-sitekey="' . get_option( 'wr_no_captcha_site_key' ) . '"></div>';
}

add_action( 'load-themes.php', 'add_holiday_theme_caps' );
function add_holiday_theme_caps(){
	global $pagenow;
	
	if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ){
	
		$result = add_role(
		'employee',
		__( 'Employee' ),
			array(
				'read'         => true,
				//'publish_posts'   => true,
				//'delete_posts' => false,
			)
		);
	} else {
		remove_role( 'employee' );
	}
}

add_filter('wp_dropdown_users', 'add_employee_to_author_meta');
function add_employee_to_author_meta($output)
{
	global $post;
	
	if('holiday' == $post->post_type ){
		$users = get_users('role=employee');
		$output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";
	
		//$output .= "<option value=\"1\">Admin</option>";
		foreach($users as $user)
		{
			$sel = ($post->post_author == $user->ID)?"selected='selected'":'';
			$output .= '<option value="'.$user->ID.'"'.$sel.'>'.$user->display_name.'</option>';
		}
		$output .= "</select>";
	}

    return $output;
}

/* Create the Holiday Request Custom Post Type */
add_action( 'init', 'create_holiday_request_post_type' );
if ( !function_exists('create_holiday_request_post_type') ) {
    function create_holiday_request_post_type() {
        $labels = array(
            'name' => __( 'Holiday Requests','websquare'),
            'singular_name' => __( 'Holiday Request','websquare' ),
            'add_new' => __('Add New','websquare'),
            'add_new_item' => __('Add New Holiday Request','websquare'),
            'edit_item' => __('Edit Holiday Request','websquare'),
            'new_item' => __('New Holiday Request','websquare'),
            'view_item' => __('View Holiday Request','websquare'),
            'search_items' => __('Search Holiday Request','websquare'),
            'not_found' =>  __('No Holiday Requests found','websquare'),
            'not_found_in_trash' => __('No Holiday Requests found in Trash','websquare'),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
			'description' => '',
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hierarchical' => false,
			'has_archive' => false,
			'rewrite' => array('slug' => 'holiday', 'with_front' => 0),
			'query_var' => true,
			'menu_position' => 5,
            'supports' => array('title','editor','page-attributes','author'),
        );

        register_post_type( 'holiday', $args );
    }
}

/* Add Holiday Type */
add_action( 'init', 'register_holiday_type' );
if ( !function_exists( 'register_holiday_type' ) ) {
	function register_holiday_type() {
		register_taxonomy( 'holiday_type',array (
		  0 => 'holiday',
		),
		array( 'hierarchical' => true,
			'label' => __('Holiday Type', 'websquare'),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'holiday-type', 'with_front' => 0),
			'show_admin_column' => true,
			'labels' => array (
				'search_items' => __('Holiday Type', 'websquare'),
			)
		) );
	}
}

/* Add Company */
add_action( 'init', 'register_company' );
if ( !function_exists( 'register_company' ) ) {
	function register_company() {
		register_taxonomy( 'company',array (
		  0 => 'holiday',
		),
		array( 'hierarchical' => true,
			'label' => __('Company', 'websquare'),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'company', 'with_front' => 0),
			'show_admin_column' => true,
			'labels' => array (
				'search_items' => __('Company', 'websquare'),
			)
		) );
	}
}

add_action( 'company_add_form_fields', 'add_company_email_field', 10, 2 );
function add_company_email_field($taxonomy) {
	
    ?><div class="form-field">
        <label for="_company_email"><?php _e('Company Email', 'websquare'); ?></label>
        <input type="email" value="" name="_company_email">
    </div><?php
}

add_action( 'created_company', 'save_company_meta', 10, 2 );
function save_company_meta( $term_id, $tt_id ){
    if( isset( $_POST['_company_email'] ) && '' !== $_POST['_company_email'] ){
        $company_email = sanitize_email( $_POST['_company_email'] );
        add_term_meta( $term_id, '_company_email', $company_email, true );
    }
}

add_action( 'company_edit_form_fields', 'edit_company_field', 10, 2 );
function edit_company_field( $term, $taxonomy ){
    $company_email = get_term_meta( $term->term_id, '_company_email', true );
    ?>
    <tr class="form-field company-wrap">
        <th scope="row"><label for="_company_email"><?php _e('Company Email', 'websquare'); ?></label></th>
        <td><input type="email" value="<?php echo $company_email;?>" name="_company_email"></td>
    </tr>
<?php
}
add_action( 'edited_company', 'update_company_meta', 10, 2 );
function update_company_meta( $term_id, $tt_id ){
	
	if( isset( $_POST['_company_email'] ) && '' !== $_POST['_company_email'] ){
        $company_email = sanitize_email( $_POST['_company_email'] );
        update_term_meta( $term_id, '_company_email', $company_email);
    }
}
/* Add Holiday Request Status */
add_action( 'init', 'register_holiday_request_status' );
if ( !function_exists( 'register_holiday_request_status' ) ) {
	function register_holiday_request_status() {
		register_taxonomy( 'holiday_request_status',array (
		  0 => 'holiday',
		),
		array( 'hierarchical' => true,
			'label' => __('Request Status', 'websquare'),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'holiday-request-status', 'with_front' => 0),
			'show_admin_column' => true,
			'labels' => array (
				'search_items' => __('Request Status', 'websquare'),
			)
		) );
	}
}

function remove_post_custom_fields() {
	remove_meta_box( 'holiday_request_statusdiv' , 'holiday' , 'side' ); 
}
add_action( 'admin_menu' , 'remove_post_custom_fields' );

/* Add Admin Metabox */
if ( !function_exists( 'holiday_request_status_meta_box_markup' ) ) {
	function holiday_request_status_meta_box_markup($post) {
		
		wp_nonce_field('holiday_request_status_meta_box_markup', 'holiday_request_status_meta_box_nonce');
		
		$request_status = get_holiday_request_status($post->ID);
		$request_statuses = get_holiday_request_statuses();
		
		$request_type = get_holiday_request_type($post->ID);
		$request_types = get_holiday_request_types();
		
		$request_days = get_holiday_request_days($post->ID);
		$request_from = get_holiday_request_from($post->ID);
		$request_to = get_holiday_request_to($post->ID);
		
		$year = get_holiday_year($post->ID);

		
		
		?>
        <div class="clearfix"><p><strong>Request Status:</strong> <?php echo $request_status->name;?> <a href="#" class="change-request" data-container=".change-request-status-container">(edit)</a></p>
        	<div class="change-request-status-container hidden">
                <select name="_holiday_request_status">
                    <?php if(isset($request_statuses) && !empty($request_statuses)):?>
                        <?php foreach($request_statuses as $status):?>
                        <option value="<?php echo $status->slug;?>" <?php echo $request_status->slug === $status->slug ? "selected" : "";?>><?php echo $status->name;?></option>
                        <?php endforeach;?>
                    <?php else:?>
                        <option value="">Please Add Request Status</option>
                    <?php endif;?>
                </select>
        	</div>
        </div>
        
        <div class="clearfix"><p><strong>No. of Days Requested:</strong> <?php echo $request_days;?> <a href="#" class="change-request" data-container=".change-request-days-container">(edit)</a></p>
        	<div class="change-request-days-container hidden">
            	<input type="text" name="_holiday_request_days" value="<?php echo $request_days;?>">
            </div>
        </div>
        
        <div class="clearfix"><p><strong>From:</strong> <?php echo mysql2date('l, jS F Y', $request_from);?> <a href="#" class="change-request" data-container=".change-request-from-container">(edit)</a></p>
        	<div class="change-request-from-container hidden">
            	<input type="text" name="_holiday_request_from" value="<?php echo $request_from;?>" placeholder="YYYY-MM-DD">
            </div>
        </div>
        
        <div class="clearfix"><p><strong>To:</strong> <?php echo mysql2date('l, jS F Y', $request_to);?> <a href="#" class="change-request" data-container=".change-request-to-container">(edit)</a></p>
        	<div class="change-request-to-container hidden">
            	<input type="text" name="_holiday_request_to" value="<?php echo $request_to;?>"  placeholder="YYYY-MM-DD">
            </div>
        </div>
        <div class="clearfix"><p><strong>Request Date:</strong> <?php echo mysql2date('l, jS F Y', $post->post_date);?></p></div>
        
        <div class="clearfix"><p><strong>Holiday Year:</strong> <?php echo $year;?>  <a href="#" class="change-request" data-container=".change-request-year">(edit)</a></p>
        	<div class="change-request-year hidden">
            	<input type="text" name="_holiday_year" value="<?php echo $year;?>"  placeholder="YYYY">
            </div>
        </div>
        
		<script>
        jQuery(document).ready(function(){
            jQuery('.change-request').click(function(){
				var container = jQuery(jQuery(this).data('container'));
				jQuery(this).remove();
				container.removeClass('hidden');
				return false;
			});
        });
        </script>
        <?php
	}
}


add_action("add_meta_boxes", "add_custom_meta_box");
if ( !function_exists( 'add_custom_meta_box' ) ) {
	function add_custom_meta_box() {
	   add_meta_box("holiday-request-status-meta-box", "Request Details", "holiday_request_status_meta_box_markup", "holiday", "side", "high", null);
	}
}

add_action( 'save_post', 'holiday_request_status_meta_box_save' );
if ( !function_exists( 'holiday_request_status_meta_box_save' ) ) {
	function holiday_request_status_meta_box_save( $post_id ) {
		
		if ( ! isset( $_POST['holiday_request_status_meta_box_nonce'] ) ) {
			return;
		}
		
		if ( ! wp_verify_nonce( $_POST['holiday_request_status_meta_box_nonce'], 'holiday_request_status_meta_box_markup') ) {
			return;
		}
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		if ( isset( $_POST['post_type'] ) && 'holiday' != $_POST['post_type'] ) {
			return;
		}

		if ( ! isset( $_POST['_holiday_request_status'] ) && ! isset( $_POST['_holiday_request_days'] ) && ! isset( $_POST['_holiday_request_from'] ) && ! isset( $_POST['_holiday_request_to'] ) && ! isset( $_POST['_holiday_request_type'] ) && ! isset($_POST['_holiday_year']) ) {
			return;
		}
		
		$holiday_request_status = sanitize_text_field( $_POST['_holiday_request_status'] );
		$holiday_request_type = sanitize_text_field( $_POST['_holiday_request_type'] );
		$holiday_request_days = sanitize_text_field( $_POST['_holiday_request_days'] );
		$holiday_request_from = sanitize_text_field( $_POST['_holiday_request_from'] );
		$holiday_request_to = sanitize_text_field( $_POST['_holiday_request_to'] );
		$holiday_request_year = sanitize_text_field( $_POST['_holiday_year'] );
		
		wp_set_object_terms( $post_id, $holiday_request_status, 'holiday_request_status', false );
		update_post_meta( $post_id, '_holiday_request_status', $holiday_request_status );
		
		update_post_meta( $post_id, '_holiday_request_days', $holiday_request_days );
		update_post_meta( $post_id, '_holiday_request_from', $holiday_request_from );
		update_post_meta( $post_id, '_holiday_request_to', $holiday_request_to );
		update_post_meta( $post_id, '_holiday_year', $holiday_request_year );
	}
}



/* Add Custom User Meta */
add_action( 'show_user_profile', 'add_extra_fields_to_user' );
add_action( 'edit_user_profile', 'add_extra_fields_to_user' );
if (!function_exists('add_extra_fields_to_user')) {
	function add_extra_fields_to_user($user){
		?>
	        <h3>Holidays Setup</h3>
			<table class="form-table">
				<tr>
					<th><label for="_holiday_allowance">Holiday Allowance</label></th>
					<td><input type="text" name="_holiday_allowance" value="<?php echo esc_attr(get_holiday_allowance( $user->ID )); ?>" class="regular-text" /></td>
				</tr>

			</table>
            <table class="form-table">
				<tr>
					<th><label for="_holiday_company">Company</label></th>
					<td>
                    
                    	
                        <?php $companies = get_terms('company', array('hide_empty' => false));?>
                        <?php $holiday_company = get_holiday_company( $user->ID );?>
                        
                        
                    	<select name="_holiday_company">
                        	
                            <?php if(isset($companies) && !empty($companies)):?>
                            	
                                <option value=""></option>
								<?php foreach($companies as $company):?>
                                    <option value="<?php echo esc_attr($company->slug);?>" <?php echo $holiday_company == $company->slug ? "selected" : "";?>><?php echo esc_attr($company->name);?></option>
                                <?php endforeach;?>
                            <?php else:?>
                                <option value="">Please add company names under Holiday Requests</option>
                            <?php endif;?>
                        </select>
                    </td>
				</tr>

			</table>
    	<?php
	}
}

add_action( 'personal_options_update', 'save_extra_fields_to_user' );
add_action( 'edit_user_profile_update', 'save_extra_fields_to_user' );
if ( !function_exists('save_extra_fields_to_user') ) {
	function save_extra_fields_to_user( $user_id ){
		update_user_meta( $user_id,'_holiday_allowance', sanitize_text_field( $_POST['_holiday_allowance'] ) );
		update_user_meta( $user_id,'_holiday_company', sanitize_text_field( $_POST['_holiday_company'] ) );
	}
}

/* Process Holiday Form Submission */
//add_action('template_redirect', 'process_holiday_request');
if ( !function_exists( 'process_holiday_request' ) ) {
	function process_holiday_request(){
		
		if(isset($_POST['holiday-request']) && !empty($_POST['holiday-request']) && wp_verify_nonce( $_POST['holiday_request_form_nonce_field'], 'holiday_request_form' ) ){
			
			if(isset($_POST['field-from-dd']) && isset($_POST['field-from-mm']) && isset($_POST['field-from-yyyy']) && is_numeric($_POST['field-from-dd']) && is_numeric($_POST['field-from-mm']) && is_numeric($_POST['field-from-yyyy'])){
				$holiday_request_from = sanitize_text_field( sprintf("%02d",$_POST['field-from-dd']) .'-' . sprintf("%02d",$_POST['field-from-mm']) .'-'. sprintf("%04d",$_POST['field-from-yyyy']));
				$yearfrom = sprintf("%04d",$_POST['field-from-yyyy']);
			}else{
				return false;
			}
			
			
			if(isset($_POST['field-to-dd']) && isset($_POST['field-to-mm']) && isset($_POST['field-to-yyyy']) && is_numeric($_POST['field-to-dd']) && is_numeric($_POST['field-to-mm']) && is_numeric($_POST['field-to-yyyy'])){
				$holiday_request_to = sanitize_text_field( sprintf("%02d",$_POST['field-to-dd']) .'-' . sprintf("%02d",$_POST['field-to-mm']) .'-'. sprintf("%04d",$_POST['field-to-yyyy']));
				$yearto = sprintf("%04d",$_POST['field-to-yyyy']);
			}else{
				return false;
			}
			
			
			if(isset($yearfrom) && isset($yearto) && $yearfrom == $yearto){
				$year = $yearfrom;
			}else{
				return false;
			}
			
			
			if(isset($_POST['_holiday_request_days']) && is_numeric($_POST['_holiday_request_days'])){
				$holiday_request_days = sanitize_text_field( $_POST['_holiday_request_days'] );
			}else{
				return false;
			}
			
			
			if(isset($_POST['_user_id']) && is_numeric($_POST['_user_id'])){
				$user_id = sanitize_text_field( $_POST['_user_id'] );
				$current_user = get_userdata( $user_id );
			}else{
				return false;
			}
			
			
			if(isset($_POST['_holiday_request_status'])){
				$holiday_request_status = sanitize_text_field( $_POST['_holiday_request_status'] );
			}else{
				return false;
			}
			
			
			if(isset($_POST['_holiday_request_type'])){
				$holiday_request_type = sanitize_text_field( $_POST['_holiday_request_type'] );
			}else{
				return false;
			}
			
			
			if(isset($_POST['_company'])){
				$company = sanitize_text_field( $_POST['_company'] );
			}else{
				return false;
			}
			
			if(isset($holiday_request_from) && isset($holiday_request_to) && isset($holiday_request_days) && isset($user_id) && isset($holiday_request_status) && isset($holiday_request_type) && isset($company)){
				
				$post = array(
					'post_type' => 'holiday',
					'post_title' => $current_user->first_name . ' ' . $current_user->last_name .' - '. $holiday_request_from . ' / ' . $holiday_request_to,
					'post_status' =>  'publish',
					'post_author' => $user_id
				);
				$post_id = wp_insert_post($post);
				
				if(isset($post_id) && !empty($post_id)){
					wp_set_object_terms( $post_id, $holiday_request_status, 'holiday_request_status', false );
					update_post_meta( $post_id, '_holiday_request_status', $holiday_request_status );
					
					wp_set_object_terms( $post_id, $holiday_request_type, 'holiday_type', false );
					update_post_meta( $post_id, '_holiday_request_type', $holiday_request_type );
					
					wp_set_object_terms( $post_id, $company, 'company', false );
					
					update_post_meta( $post_id, '_holiday_request_days', $holiday_request_days );
					update_post_meta( $post_id, '_holiday_request_from', $holiday_request_from );
					update_post_meta( $post_id, '_holiday_request_to', $holiday_request_to );
					update_post_meta( $post_id, '_holiday_year', $year );
					
					$company_term = get_term_by('slug', $company, 'company' );
					$company_email = get_term_meta( $company_term->term_id, '_company_email', true );
					
					$mailTo = $company_email;

					$subject = "New Holiday Request - ".$current_user->first_name.' '.$current_user->last_name;
					$body = "New Holiday Request: ".get_permalink($post_id);
					wp_mail($mailTo, utf8_decode($subject), utf8_decode($body));
					
					
					return $post_id;
				}else{
					return false;
				}
				
			}else{
				return false;
			}

		}else{
			return false;
		}
	}
}

/* Get Holiday Allowance */
if ( !function_exists( 'get_holiday_allowance' ) ) {
	function get_holiday_allowance( $user_id ){
		$result = get_the_author_meta( '_holiday_allowance', $user_id );
		return $result;
	}
}

/* Calculate Sockness Days */
if ( !function_exists( 'get_sick_days' ) ) {
	function get_sick_days( $user_id, $year = null ){
		if(empty($year)) $year = date('Y');
		
		$args = array(
			'posts_per_page'			=> -1,
			'author'					=> $user_id,
			'post_type'        			=> 'holiday',
			'holiday_request_status' 	=> 'approved',
			'holiday_type' 				=> 'sickness',
			'meta_key'					=> '_holiday_year',
			'meta_value'				=> $year,
		);
		
		$result = 0;
		
		$holiday_requests = get_posts($args);
		
		
		if(isset($holiday_requests) && !empty($holiday_requests)){
			foreach($holiday_requests as $holiday_request){
				$result = $result + get_holiday_request_days($holiday_request->ID);
			}
		}
		return $result;
	}
}

/* Calculate Holidays Used */
if ( !function_exists( 'get_holidays_used' ) ) {
	function get_holidays_used( $user_id, $year = null ){
		if(empty($year)) $year = date('Y');
		
		$args = array(
			'posts_per_page'			=> -1,
			'author'					=> $user_id,
			'post_type'        			=> 'holiday',
			'holiday_request_status' 	=> 'approved',
			'holiday_type' 				=> 'paid',
			'meta_key'					=> '_holiday_year',
			'meta_value'				=> $year,
		);
		
		$result = 0;
		
		$holiday_requests = get_posts($args);
		if(isset($holiday_requests) && !empty($holiday_requests)){
			foreach($holiday_requests as $holiday_request){
				$result = $result + get_holiday_request_days($holiday_request->ID);
			}
		}
		return $result;
	}
}

/* Calculate Holidays Left */
if ( !function_exists( 'get_holidays_left' ) ) {
	function get_holidays_left( $user_id, $year = null ){
		$holiday_allowance = get_holiday_allowance( $user_id );
		$holidays_used = get_holidays_used( $user_id, $year );
		
		$result = $holiday_allowance - $holidays_used;
		
		return $result;
	}
}

/* Get Company */
if ( !function_exists( 'get_holiday_company' ) ) {
	function get_holiday_company( $user_id ){
		$result = get_the_author_meta( '_holiday_company', $user_id );
		return $result;
	}
}

/* Get Request Types */
if ( !function_exists( 'get_holiday_request_types' ) ) {
	function get_holiday_request_types( ){
		$result = get_terms('holiday_type', array('hide_empty' => false));
		return $result;
	}
}

/* Get Request Type */
if ( !function_exists( 'get_holiday_request_type' ) ) {
	function get_holiday_request_type( $post_id ){
		
		$holiday_request_types = get_holiday_request_types();
		
		if(isset($holiday_request_types) && !empty($holiday_request_types)){
			
			$holiday_request_type = get_post_meta($post_id, "_holiday_request_type", true);
			if(isset($holiday_request_type) && !empty($holiday_request_type)){
				
				$result = get_term_by( 'slug', $holiday_request_type, 'holiday_type' );
				return $result;
			}
			
		}
	}
}


/* Get Request Statuses */
if ( !function_exists( 'get_holiday_request_statuses' ) ) {
	function get_holiday_request_statuses( ){
		$result = get_terms('holiday_request_status', array('hide_empty' => false));
		return $result;
	}
}

/* Get Request Status */
if ( !function_exists( 'get_holiday_request_status' ) ) {
	function get_holiday_request_status( $post_id ){
		
		$holiday_request_statuses = get_holiday_request_statuses();
		
		if(isset($holiday_request_statuses) && !empty($holiday_request_statuses)){
			
			$holiday_request_status = get_post_meta($post_id, "_holiday_request_status", true);
			if(isset($holiday_request_status) && !empty($holiday_request_status)){
				
				$result = get_term_by( 'slug', $holiday_request_status, 'holiday_request_status' );
				return $result;
			}
			
		}
	}
}

/* Get Request Number of Days */
if ( !function_exists( 'get_holiday_request_days' ) ) {
	function get_holiday_request_days( $post_id ){
		$result = get_post_meta($post_id, "_holiday_request_days", true);
		return $result;
	}
}

/* Get Request From Date */
if ( !function_exists( 'get_holiday_request_from' ) ) {
	function get_holiday_request_from( $post_id ){
		$result = get_post_meta($post_id, "_holiday_request_from", true);
		return $result;
	}
}

/* Get Request To Date */
if ( !function_exists( 'get_holiday_request_to' ) ) {
	function get_holiday_request_to( $post_id ){
		$result = get_post_meta($post_id, "_holiday_request_to", true);
		return $result;
	}
}

/* Get Request Year */
if ( !function_exists( 'get_holiday_year' ) ) {
	function get_holiday_year( $post_id ){
		$result = get_post_meta($post_id, "_holiday_year", true);
		return $result;
	}
}

/* Get Holiday Requests */
if ( !function_exists( 'get_holiday_requests' ) ) {
	function get_holiday_requests( $user_id = null, $status = null ){

		$args = array(
			'posts_per_page'	=> -1,
			'post_type'        	=> 'holiday',
		);
		if($user_id > 0) {
			$args['author'] = $user_id;
		}
		if($status){
			$args['meta_key'] = '_holiday_request_status';
			$args['meta_value'] = $status;
		}
		$holiday_requests = get_posts($args);
		
		$result = $holiday_requests;

		return $result;
	}
}

/* Get Next Holiday */
if ( !function_exists( 'get_next_holiday' ) ) {
	function get_next_holiday( $user_id, $status = 'approved' ){

		$args = array(
			'posts_per_page'	=> -1,
			'author'			=> $user_id,
			'post_type'        	=> 'holiday',
		);
		if($status){
			$args['meta_key'] = '_holiday_request_status';
			$args['meta_value'] = $status;
		}
		$holiday_requests = get_posts($args);
		
		if(isset($holiday_requests) && !empty($holiday_requests)){
			$date = date('Y-m-d');
			foreach($holiday_requests as $holiday_request){
				$day = get_holiday_request_from($holiday_request->ID);
				if($day >= $date){
					$interval[] = abs(strtotime($date) - strtotime($day));
				}
			}
			asort($interval);
			$closest = key($interval);
			$result = $holiday_requests[$closest];
		}else{
			$result = null;
		}

		return $result;
	}
}
?>