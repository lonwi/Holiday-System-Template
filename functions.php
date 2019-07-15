<?php
/* URI shortcuts
================================================== */
define( 'THEME_ASSETS', get_template_directory_uri() . '/assets/', true );
define( 'THEME_INCLUDES', get_template_directory_uri() . '/includes/', true );
define( 'TEMPLATE_PATH', get_template_directory_uri(), true );
define( 'TEMPLATE_DIR', get_template_directory(), true );
define( 'GETTEXT_DOMAIN', 'websquare' );

/* Bank Holidays
================================================== */
require_once dirname( __FILE__ ) . '/includes/functions/functions-bank-holidays.php';

/* Functions
================================================== */
require_once dirname( __FILE__ ) . '/includes/functions/functions-template.php';
require_once dirname( __FILE__ ) . '/includes/functions/functions-setup.php';
require_once dirname( __FILE__ ) . '/includes/tcpdf/tcpdf.php';


require_once dirname( __FILE__ ) . '/includes/functions/functions-holiday.php';
require_once dirname( __FILE__ ) . '/includes/functions/functions-flexitime.php';