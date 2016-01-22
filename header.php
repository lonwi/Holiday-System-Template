<?php
	if(current_user_can( 'manage_options' ) && isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
	}else{
		$user_id = get_current_user_id();
	}	
	$_current_user = get_userdata( $user_id );
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes();?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes();?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes();?>> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" <?php language_attributes();?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes();?>> <!--<![endif]-->
<head>
	<!-- Meta Tags -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <title><?php wp_title( '|', true, 'right' ); ?></title>	
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="referrer" content="origin">
    
    <link rel="apple-touch-icon" href="<?php echo THEME_ASSETS ?>images/apple-icon-touch.png">
	<link rel="icon" href="<?php echo THEME_ASSETS ?>images/favicon.png">
    <!--[if IE]>
        <link rel="shortcut icon" href="<?php echo THEME_ASSETS;?>/images/favicon.ico">
    <![endif]-->
	<?php wp_head(); ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body <?php body_class('no-js'); ?>>
<div class="page-wrapper">
			
    <header role="banner">
    	
        <?php /*
        <div id="pre-header" class="pre-header clearfix">
        	
            <div class="container">
        
            	<div class="row">
                	
                    <div class="col-xs-12">
                    	
                        <p>This website requires cookies to provide all of its features. For more information on what data is contained in the cookies, please see our <a href="<?php echo get_permalink();?>" target="_blank">Privacy Policy page</a>.</p>
                        
                    </div>
                
                </div>
        	
            </div>  
        
        </div>
		*/?>
            
    	<div id="header" class="header clearfix">
        
        	<div class="container">
        
            	<div class="row">
                	
                    <div class="col-md-4 col-xs-6">
                    
                    	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php _e('Websquare', 'websquare');?>" rel="home">
                        	<img src="<?php echo THEME_ASSETS;?>images/logo.png" alt="<?php _e('Websquare Logo', 'websquare');?>">
                        </a>
                    	
                    </div>
                    
                    <div class="col-md-4 col-xs-12 hidden-xs hidden-sm">
                    
                        <h1 class="page-title">Holidays Dashboard</h1>
                        <h2 style="font-size:14px; margin-bottom:0;"><?php echo $_current_user->first_name . ' ' . $_current_user->last_name;?></h2>
                    	
                    </div>
                    
                    <div class="col-md-4 col-xs-6 text-right">
                    	
                        <?php if(is_user_logged_in()):?>
                        	<a href="<?php echo wp_logout_url( home_url() ); ?>" class="button">Sign Out</a>
                        <?php else:?>
                    		<a href="<?php echo get_permalink(8); ?>" class="button">Sign In</a>
                        <?php endif;?>
                    	
                    </div>
                
                </div>
                
                <div class="row hidden-md hidden-lg">
                
                	<div class="col-xs-12">
                    	
                        <h1 class="page-title">Holiday Dashboard</h1>
                        <h2 style="font-size:12px;  margin-bottom:0;"><?php echo $_current_user->first_name . ' ' . $_current_user->last_name;?></h2>
                    	
                    </div>
                    
                </div>
        	
            </div>        
        
        </div>
    
    </header> <!-- /header -->
    
    <div id="main" class="main clearfix">       