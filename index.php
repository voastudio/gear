<?php

define( 'HTTP_SERVER', 	 ( !empty( $_SERVER['HTTPS'] )? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . '/' );
define( 'RELATIVE_PATH', preg_replace( '/^' . preg_quote( $_SERVER['DOCUMENT_ROOT'], '/' ) . '/', '', __DIR__ ) . '/' );
define( 'ABSOLUTE_PATH', dirname( __FILE__ ) . '/' );
define( 'HTTP_ADDRESS', 		(!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . RELATIVE_PATH );

define( 'CORE', 	 	ABSOLUTE_PATH . '_core/' );
define( 'CONFIG', 	 	CORE . '_config/' );
define( 'INCLUDES', 	CORE . '_includes/' );
define( 'EXCEPTIONS', 	CORE . '_exceptions/' );
define( 'LOGS', 	 	CORE . '_logs/' );
define( 'PLUGINS', 	 	CORE . '_plugins/' );
define( 'PRIMITIVES', 	CORE . '_primitives/' );
define( 'SERVICES', 	CORE . '_services/' );

define( 'APPLICATION', 	ABSOLUTE_PATH . '_application/' );
define( 'MODELS', 	 	APPLICATION . '_models/' );
define( 'VIEWS', 	 	APPLICATION . '_views/' );
define( 'CONTROLLERS', 	APPLICATION . '_controllers/' );
define( 'WIDGETS', 	 	APPLICATION . '_widgets/' );
define( 'ENTITIES', 	APPLICATION . '_entities/' );

define( 'SHARED', 	 	ABSOLUTE_PATH . '_public/' );
define( 'FILES', 	 	SHARED . '_files/' );
define( 'TEMP', 	 	FILES . '_temp/' );
define( 'STATIC', 	 	SHARED . '_static/' );
define( 'FRONT', 	 	HTTP_SERVER . basename( dirname(__FILE__) ) . '/_public/_front/' );
define( 'PUBLIC_FILES', HTTP_SERVER . basename( dirname(__FILE__) ) . '/_public/_files/' );
define( 'TEMPLATES', 	SHARED . '_front/' );
define( 'ERRORS', 	 	TEMPLATES . '_errors/' );

require_once( CONFIG . 'config.php' );
require_once( CONFIG . 'autoload.php' );
require_once( CONFIG . 'routes.php' );
require_once( CONFIG . 'auth.php' );


require_once( PRIMITIVES . 'primitiveException.php' );
require_once( PRIMITIVES . 'primitiveView.php' );
require_once( PRIMITIVES . 'primitiveDao.php' );
require_once( PRIMITIVES . 'primitiveEntity.php' );
require_once( PRIMITIVES . 'primitiveFacade.php' );
require_once( PRIMITIVES . 'primitivePlugin.php' );
require_once( PRIMITIVES . 'primitiveService.php' );
require_once( PRIMITIVES . 'primitiveModel.php' );
require_once( PRIMITIVES . 'primitiveController.php' );
require_once( PRIMITIVES . 'primitiveApp.php' );

$Application = App::create( $config['appname'] );
$Application->run();