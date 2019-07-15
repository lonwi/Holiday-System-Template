<?php
add_action( 'init', 'create_flexitime_request_post_type' );
if ( !function_exists('create_flexitime_request_post_type') ) {
    function create_flexitime_request_post_type() {
        $labels = array(
            'name' => __( 'Flexitime Requests','websquare'),
            'singular_name' => __( 'Flexitime Request','websquare' ),
            'add_new' => __('Add New','websquare'),
            'add_new_item' => __('Add New Flexitime Request','websquare'),
            'edit_item' => __('Edit Flexitime Request','websquare'),
            'new_item' => __('New Flexitime Request','websquare'),
            'view_item' => __('View Flexitime Request','websquare'),
            'search_items' => __('Search Flexitime Request','websquare'),
            'not_found' =>  __('No Flexitime Requests found','websquare'),
            'not_found_in_trash' => __('No Flexitime Requests found in Trash','websquare'),
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
			'rewrite' => array('slug' => 'flexitime', 'with_front' => 0),
			'query_var' => true,
			'menu_position' => 5,
            'supports' => array('title','editor','page-attributes','author'),
        );

        register_post_type( 'flexitime', $args );
    }
}

add_action( 'init', 'register_flexitime_request_status' );
if ( !function_exists( 'register_flexitime_request_status' ) ) {
	function register_flexitime_request_status() {
		register_taxonomy( 'flexitime_request_status',array (
		  0 => 'flexitime',
		),
		array( 'hierarchical' => true,
			'label' => __('Request Status', 'websquare'),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'flexitime-request-status', 'with_front' => 0),
			'show_admin_column' => true,
			'labels' => array (
				'search_items' => __('Request Status', 'websquare'),
			)
		) );
	}
}

if ( !function_exists( 'process_flexitime_request' ) ) {
	function process_flexitime_request(){
		
		if(isset($_POST['flexitime-request']) && !empty($_POST['flexitime-request']) && wp_verify_nonce( $_POST['flexitime_request_form_nonce_field'], 'flexitime_request_form' ) ){
			
			if(isset($_POST['field-dd']) && isset($_POST['field-mm']) && isset($_POST['field-yyyy']) && is_numeric($_POST['field-dd']) && is_numeric($_POST['field-mm']) && is_numeric($_POST['field-yyyy'])){
				//$flexitime_request_date = sanitize_text_field( sprintf("%02d",$_POST['field-dd']) .'-' . sprintf("%02d",$_POST['field-mm']) .'-'. sprintf("%04d",$_POST['field-yyyy']));
				$flexitime_request_date = sanitize_text_field( sprintf("%04d",$_POST['field-yyyy']) .'-'.sprintf("%02d",$_POST['field-mm']).'-'.sprintf("%02d",$_POST['field-dd']) );
				$flexitime_request_day = sprintf("%02d",$_POST['field-dd']);
				$flexitime_request_month = sprintf("%02d",$_POST['field-mm']);
				$flexitime_request_year = sprintf("%04d",$_POST['field-yyyy']);
			}else{
				return false;
			}
			
			if(isset($_POST['_flexitime_request_status'])){
				$flexitime_request_status = sanitize_text_field( $_POST['_flexitime_request_status'] );
			}else{
				return false;
			}
		
			
			if(isset($_POST['_user_id']) && is_numeric($_POST['_user_id'])){
				$user_id = sanitize_text_field( $_POST['_user_id'] );
				$current_user = get_userdata( $user_id );
			}else{
				return false;
			}
		
			
			if(isset($_POST['_company'])){
				$company = sanitize_text_field( $_POST['_company'] );
			}else{
				return false;
			}
			
			if(isset($_POST['_flexitime_request_reason'])){
				$flexitime_request_reason = sanitize_text_field( $_POST['_flexitime_request_reason'] );
			}else{
				return false;
			}
			
			if(isset($_POST['_flexitime_request_comments'])){
				$flexitime_request_comments = sanitize_text_field( $_POST['_flexitime_request_comments'] );
			}else{
				return false;
			}
			
			if(isset($flexitime_request_date) && isset($user_id) && isset($company) && isset($flexitime_request_reason) && isset($flexitime_request_comments)){
				
				$post = array(
					'post_type' => 'flexitime',
					'post_title' => $current_user->first_name . ' ' . $current_user->last_name .' - '. $flexitime_request_date,
					'post_status' =>  'publish',
					'post_content' => $flexitime_request_comments,
					'post_author' => $user_id
				);
				$post_id = wp_insert_post($post);
				
				if(isset($post_id) && !empty($post_id)){
					wp_set_object_terms( $post_id, $flexitime_request_status, 'flexitime_request_status', false );
					update_post_meta( $post_id, '_flexitime_request_status', $flexitime_request_status );
					
					wp_set_object_terms( $post_id, $company, 'company', false );
					
					update_post_meta( $post_id, '_flexitime_request_date', $flexitime_request_date );
					
					update_post_meta( $post_id, '_flexitime_day', $flexitime_request_day );
					update_post_meta( $post_id, '_flexitime_month', $flexitime_request_month );
					update_post_meta( $post_id, '_flexitime_year', $flexitime_request_year );
					
					update_post_meta( $post_id, '_flexitime_request_reason', $flexitime_request_reason );
					
					$company_term = get_term_by('slug', $company, 'company' );
					$company_email = get_term_meta( $company_term->term_id, '_company_email', true );
					
					if(user_can($user_id, 'manage_options' )){
						$mailTo = $company_email.',tanveer@websquare.co.uk';
					}else{
						$mailTo = $company_email;
					}

					$subject = "New Flexitime Request - ".$current_user->first_name.' '.$current_user->last_name;
					$body = "New Flexitime Request: ".get_permalink($post_id);
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

/* Get Request Statuses */
if ( !function_exists( 'get_flexitime_request_statuses' ) ) {
	function get_flexitime_request_statuses( ){
		$result = get_terms('flexitime_request_status', array('hide_empty' => false));
		return $result;
	}
}

/* Get Request Status */
if ( !function_exists( 'get_flexitime_request_status' ) ) {
	function get_flexitime_request_status( $post_id ){
		
		$flexitime_request_statuses = get_flexitime_request_statuses();
		
		if(isset($flexitime_request_statuses) && !empty($flexitime_request_statuses)){
			
			$flexitime_request_status = get_post_meta($post_id, "_flexitime_request_status", true);
			if(isset($flexitime_request_status) && !empty($flexitime_request_status)){
				
				$result = get_term_by( 'slug', $flexitime_request_status, 'flexitime_request_status' );
				return $result;
			}
			
		}
	}
}
/* Get Request Number of Days */
if ( !function_exists( 'get_flexitime_request_date' ) ) {
	function get_flexitime_request_date( $post_id ){
		$result = get_post_meta($post_id, "_flexitime_request_date", true);
		return $result;
	}
}

/* Get Request From Date */
if ( !function_exists( 'get_flexitime_request_reason' ) ) {
	function get_flexitime_request_reason( $post_id ){
		$result = get_post_meta($post_id, "_flexitime_request_reason", true);
		return $result;
	}
}

/* Get Request From Date */
if ( !function_exists( 'get_flexitime_request_year' ) ) {
	function get_flexitime_request_year( $post_id ){
		$result = get_post_meta($post_id, "_flexitime_year", true);
		return $result;
	}
}

/* Get Request From Date */
if ( !function_exists( 'get_flexitime_company' ) ) {
	function get_flexitime_company( $post_id ){
		$result = get_post_meta($post_id, "company", true);
		return $result;
	}
}

if ( !function_exists( 'get_flexitime_requests' ) ) {
	function get_flexitime_requests( $user_id = null, $status = null, $year = null, $compare = null ){

		$args = array(
			'posts_per_page'	=> -1,
			'post_type'        	=> 'flexitime',
			'meta_key' 			=> '_flexitime_request_date',
		  	'orderby' 			=> 'meta_value',
		    'order' 			=> 'DESC'
		);
		if($user_id > 0) {
			$args['author'] = $user_id;
		}
		if($status){
			$meta_query[] = array(
				'key' 		=> '_flexitime_request_status',
				'value' 	=> $status,
			);
		}
		if($year && !$compare){
			$meta_query[] = array(
				'key' 		=> '_flexitime_year',
				'value' 	=> $year,
			);
		}
		if($year && $compare){
			$meta_query[] = array(
				'key' 		=> '_flexitime_year',
				'value' 	=> $year,
				'compare'	=> $compare,
			);
		}
		$args['meta_query'] = $meta_query;
		$flexitime_requests = get_posts($args);
		
		$result = $flexitime_requests;

		return $result;
	}
}
if ( !function_exists( 'get_flexitime_days' ) ) {
	function get_flexitime_days( $user_id, $year = null ){
		if(empty($year)) $year = date('Y');
		
		$args = array(
			'posts_per_page'			=> -1,
			'author'					=> $user_id,
			'post_type'        			=> 'flexitime',
			'flexitime_request_status' 	=> 'approved',
			'meta_key'					=> '_flexitime_year',
			'meta_value'				=> $year,
		);
		
		$result = 0;
		
		$flexitime_days = get_posts($args);
		
		
		if(isset($flexitime_days) && !empty($flexitime_days)){
			$result = count($flexitime_days);
		}
		return $result;
	}
}

/* Add Admin Metabox */
if ( !function_exists( 'flexitime_request_status_meta_box_markup' ) ) {
	function flexitime_request_status_meta_box_markup($post) {
		
		wp_nonce_field('flexitime_request_status_meta_box_markup', 'flexitime_request_status_meta_box_nonce');
		
		$request_status = get_flexitime_request_status($post->ID);
		$request_statuses = get_flexitime_request_statuses();

		
		$request_reason = get_flexitime_request_reason($post->ID);
		
		$flexitime_request_date = get_flexitime_request_date($post->ID);
		
		$year = get_flexitime_request_year($post->ID);
		
		?>
        <div class="clearfix"><p><strong>Request Status:</strong> <?php echo $request_status->name;?> <a href="#" class="change-request" data-container=".change-request-status-container">(edit)</a></p>
        	<div class="change-request-status-container hidden">
                <select name="_flexitime_request_status">
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
        
        <div class="clearfix"><p><strong>Reason:</strong><br><?php echo $request_reason;?> <a href="#" class="change-request" data-container=".change-request-reason-container">(edit)</a></p>
        	<div class="change-request-reason-container hidden">
            	<input type="text" name="_flexitime_request_reason" value="<?php echo $request_reason;?>">
            </div>
        </div>        
        
        <div class="clearfix"><p><strong>Flexitime Requested Date:</strong><br><?php echo mysql2date('l, jS F Y', $flexitime_request_date);?> <a href="#" class="change-request" data-container=".change-request-to-container">(edit)</a></p>
        	<div class="change-request-to-container hidden">
            	<p style="font-size:12px">Please use YYYY-MM-DD format only</p>
            	<input type="text" name="_flexitime_request_date" value="<?php echo $flexitime_request_date;?>"  placeholder="YYYY-MM-DD">
            </div>
        </div>
        <div class="clearfix"><p><strong>Requested On:</strong><br><?php echo mysql2date('l, jS F Y', $post->post_date);?></p></div>

        
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

add_action("add_meta_boxes", "add_f_custom_meta_box");
if ( !function_exists( 'add_f_custom_meta_box' ) ) {
	function add_f_custom_meta_box() {
	   add_meta_box("flexitime-request-status-meta-box", "Request Details", "flexitime_request_status_meta_box_markup", "flexitime", "side", "high", null);
	}
}

add_action( 'save_post', 'flexitime_request_status_meta_box_save' );
if ( !function_exists( 'flexitime_request_status_meta_box_save' ) ) {
	function flexitime_request_status_meta_box_save( $post_id ) {
		
		if ( ! isset( $_POST['flexitime_request_status_meta_box_nonce'] ) ) {
			return;
		}
		
		if ( ! wp_verify_nonce( $_POST['flexitime_request_status_meta_box_nonce'], 'flexitime_request_status_meta_box_markup') ) {
			return;
		}
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		if ( isset( $_POST['post_type'] ) && 'flexitime' != $_POST['post_type'] ) {
			return;
		}

		if ( ! isset( $_POST['_flexitime_request_status'] ) && ! isset( $_POST['_flexitime_request_date'] ) && ! isset( $_POST['_flexitime_request_reason'] ) ) {
			return;
		}
		
		$flexitime_request_status = sanitize_text_field( $_POST['_flexitime_request_status'] );
		$flexitime_request_date = sanitize_text_field( $_POST['_flexitime_request_date'] );
		$flexitime_request_reason = sanitize_text_field( $_POST['_flexitime_request_reason'] );

		
		wp_set_object_terms( $post_id, $flexitime_request_status, 'flexitime_request_status', false );
		update_post_meta( $post_id, '_flexitime_request_status', $flexitime_request_status );
		
		update_post_meta( $post_id, '_flexitime_request_date', $flexitime_request_date );
		update_post_meta( $post_id, '_flexitime_request_reason', $flexitime_request_reason );

	}
}
/* Get Users On Flexitime */
if ( !function_exists( 'get_users_on_flexitime' ) ) {
	function get_users_on_flexitime( $user_id ){
		
		$holiday_company = get_holiday_company( $user_id );
		$roles = array('employee', 'manager');
		$employees = array();
		$result = '';

		$date = date('Y-m-d');
		$year = date('Y');
		
		foreach ($roles as $role) {
			$users = get_users(array('role'=> $role, 'orderby'=>'display_name', 'meta_key' => '_holiday_company', 'meta_value' => $holiday_company));
			if ($users) $employees = array_merge($employees, $users);
		
		}
		
		foreach($employees as $employee){
			
			$args = array(
				'posts_per_page'	=> -1,
				'author'			=> $employee->ID,
				'post_type'        	=> 'flexitime',
				
				'meta_query' => array(
					array(
						'key' => '_flexitime_request_status',
						'value' => 'approved',
					),
					array(
						'key' => '_flexitime_year',
						'value' => $year,
					),
					array(
						'key' => '_flexitime_request_date',
						'value' => $date,
					),
				)
			);

			$flexitime_requests = get_posts($args);
		
			foreach($flexitime_requests as $flexitime_request){
				$result .= '<h4><a href="'.get_permalink($flexitime_request->ID).'?home=1">'.$employee->first_name . ' ' . $employee->last_name.'</a></h4>';
			}
		}
		return $result;
	}
}