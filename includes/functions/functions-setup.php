<?php
/* we're firing all out initial functions at the start */
add_action( 'after_setup_theme', 'websquare_theme_setup', 16 );
function websquare_theme_setup () {
	
	add_action( 'init', 'websquare_head_cleanup' );
	
	// enqueue base scripts and styles
    add_action( 'wp_enqueue_scripts', 'websquare_theme_css', 999 );
	add_action( 'wp_enqueue_scripts', 'websquare_theme_js', 999 );
	
	add_action( 'wp_enqueue_scripts', 'wr_no_captcha_login_form_script' );
	//add_action( 'wp_enqueue_scripts', 'wr_no_captcha_css' );
		
	websquare_theme_support();
	
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
	
	add_action( 'widgets_init', 'websquare_register_sidebars' );
	
}

function websquare_head_cleanup(){
	
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
}

function websquare_theme_support() {
	
	add_theme_support('post-thumbnails');
	//set_post_thumbnail_size(350, 235, array( 'center', 'center'));

	// rss thingy
	add_theme_support('automatic-feed-links');
	
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	
	// wp menus
	add_theme_support( 'menus' );
	// registering wp3+ menus
	
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'shorts' ),   // main nav in header
			'footer-links' => __( 'Footer Links', 'shorts' ), // secondary nav in footer
			'account-nav' => __( 'Account Links', 'shorts' ), // secondary nav in footer
		)
	);
	
}

function websquare_theme_css() {
	global $wp_styles;
	if (!is_admin()) {
		
		// Fonts
		wp_register_style( 'font-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700', array(), '1.0', 'all' );
		
		// normalize.css v3.0.3
		wp_register_style( 'normalize-css', THEME_ASSETS . 'css/normalize.css', array(), '3.0.3', 'all' );
		wp_register_style( 'font-awesome-css', THEME_ASSETS . 'css/font-awesome.min.css', array(), '4.5.0', 'all' );
		
		wp_register_style( 'picker-css', 'https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/themes/default.css', array(), '3.5.6', 'all' );
		wp_register_style( 'picker-date-css', 'https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/themes/default.date.css', array(), '3.5.6', 'all' );
		
		// Main Style Sheet
		wp_register_style( 'main-css', THEME_ASSETS . 'css/style.css', array(), '1.0.0', 'all' );
		
		// IE Style Sheet
		wp_register_style( 'ie-css', THEME_ASSETS . 'css/ie.css', array(), '1.0.0', 'all' );
		
		// enqueue styles
		wp_enqueue_style( 'font-open-sans' );
		wp_enqueue_style( 'normalize-css' );
		wp_enqueue_style( 'font-awesome-css' );
		wp_enqueue_style( 'picker-css' );
		wp_enqueue_style( 'picker-date-css' );
		wp_enqueue_style( 'main-css' );
		wp_enqueue_style( 'ie-css' );
		
		$wp_styles->add_data( 'ie-css', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet
		
	}
}

function websquare_theme_js() {
	
	if (!is_admin()) {
		
		wp_register_script( 'print-js', THEME_ASSETS . 'js/plugins/jQuery.print.js', array( 'jquery' ), '1.3.3', true );
		wp_register_script( 'picker-js','https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/picker.js', array( 'jquery' ), '3.5.6', true );
		wp_register_script( 'picker-date-js', 'https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.5.6/compressed/picker.date.js', array( 'jquery' ), '3.5.6', true );

		wp_register_script( 'main-js', THEME_ASSETS . 'js/main.js', array( 'jquery' ), '1.0.0', true );

		wp_localize_script( 'main-js', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'themeurl' => THEME_ASSETS, 'nonce' => wp_create_nonce( "get_holiday_nonce" ))); 
		
		// enqueue scripts
		wp_enqueue_script( 'jquery' );
		
		wp_enqueue_script( 'print-js' );
		wp_enqueue_script( 'picker-js' );
		wp_enqueue_script( 'picker-date-js' );
		wp_enqueue_script( 'main-js' );
		
	}
	
}

/* Sidebars & Widgetizes Areas */
function websquare_register_sidebars() {
	
	register_sidebar(array(
		'id' => 'sidebar-page',
		'name' => __( 'Page Sidebar', 'ironmongery' ),
		'description' => __( 'Sidebar for pages.', 'ironmongery' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));	
} 

/* remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/) */
add_filter('the_content', 'filter_ptags_on_images');
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

/* custom excerpt length */
add_filter( 'excerpt_length', 'websquare_custom_excerpt_length', 999 );
function websquare_custom_excerpt_length( $length ) {
	return 40;
}


/* add more link to excerpt */
add_filter('excerpt_more', 'websquare_custom_excerpt_more');
function websquare_custom_excerpt_more($more) {
	global $post;
	return '';
}

/* changing default wordpres email settings */
add_filter('wp_mail_from', 'websquare_new_mail_from');
add_filter('wp_mail_from_name', 'websquare_new_mail_from_name');
 
function websquare_new_mail_from($old) {
 return 'info@websquare.co.uk';
}
function websquare_new_mail_from_name($old) {
 return 'Websqure Holiday Managment';
}

// hook failed login
add_action( 'wp_login_failed', 'websquare_login_failed' ); // hook failed login
function websquare_login_failed( $user ) {
  	$referrer = $_SERVER['HTTP_REFERER'];
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '?login=failed' )) {
			// Redirect to the login page and append a querystring of login failed
	    	wp_redirect( $referrer . '?login=failed');
	    } else {
	      	wp_redirect( $referrer );
	    }
	    exit;
	}
}
add_action( 'authenticate', 'websquare_blank_login');
function websquare_blank_login( $user ){
  	$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
  	$error = false;
  	if($_POST['log'] == '' || $_POST['pwd'] == '')
  	{
  		$error = true;
  	}
  	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $error ) {
    	if ( !strstr($referrer, '?login=failed') ) {
        	wp_redirect( $referrer . '?login=failed' );
      	} else {
        	wp_redirect( $referrer );
      	}
    exit;

  	}
}
add_action( 'admin_init', 'restrict_admin', 1 );
function restrict_admin()
{
	if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
    	wp_redirect( site_url() );
	}
}


?>