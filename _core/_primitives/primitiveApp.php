<?php

class App 
{
	
	private $name;
	
	private $controller;
	private $action;
	private $data;
	
	private $benchMarkMethod;
	private $startTime;
	private $endTime;
	
	function __construct( $applicationName )
	{
		global $autoload;
		global $config;

		$this->startTime = microtime( TRUE );	
		$this->name = $applicationName;
		$this->benchMarkMethod = $config['benchmarkMethod'];

		$this->loadExceptionService();
		
		for ( $i = 0; $i < sizeOf( $autoload['plugins'] ); $i++ ) {
			$this->loadPlugin( $autoload['plugins'][$i]);
		}

		if ( $config['authorization'] == true) {
			$this->loadAuthorizationService();
		}

		$this->afterConstruct();
	}

	function __destruct()
	{
		$this->afterDestruct();
		$this->endTime = microtime( TRUE );
		
		if( $this->benchMarkMethod != 'none' ) {
			if ( $this->benchMarkMethod == 'alert') {
				echo '<script> alert("' . ( ( $this->endTime - $this->startTime ) ) . ' uSeconds elapsed");</script>';
				return 0;
			}
			else if ( $this->benchMarkMethod == 'echo' ) {
				echo "Execution time : " . ( ( $this->endTime - $this->startTime ) );
				return 0;
			}
			else if ( $this->benchMarkMethod == 'silent' ) {
				echo "<!-- " . ( ( $this->endTime - $this->startTime ) ) . "uSeconds -->";
				return 0;
			}
			else {
				return ( ( $this->endTime - $this->startTime ) );
			}
		}	
	}
	
	public static function create( $applicationName ) 
	{
		return new static( $applicationName );
	}
	
	private function afterConstruct()
	{
		
	}
	
	private function afterDestruct()
	{	
		ob_end_flush();
	}
	
	private function parseUrlData() 
	{	
		global $defaults;
		global $config;
		global $authorization;
			
		$uri = rtrim( dirname( $_SERVER["SCRIPT_NAME"] ), '/' );
		$uri = '/' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '/' );
		$uri = urldecode( $uri );
		
		$urlData = explode( "/", ltrim( $uri, "/" ) );
		
		if ( isset( $urlData[0]) && ( $urlData[0] != '' ) ) {
			if ( isset( $urlData[1] ) ){
				if ( isset( $urlData[2] ) ){
					for ( $i = 2; $i < sizeof( $urlData ); $i++ ){
						$this->data[] = $urlData[$i];
					}
				}
				else {
					$this->data = [];
				}
				$this->action = $urlData[1];
			}
			else {
				$this->action = $defaults['action'];
				$this->data = [];
			}

			$this->controller = $urlData[0];
		}
		else {
			$this->controller = $defaults['controller'];
			$this->action = $defaults['action'];
			$this->data = [];
		}

		if ( $config['authorization'] == true ) {

				//echo $this->authorizationService->isUserAuthorized( $this->controller, $this->action );
				

			 	if ( $this->authorizationService->isUserAuthorized( $this->controller, $this->action ) == true ) {
				 //LOG ACCESS HERE
			 		//echo "authorization ok";
			 		return true;
				} else {
					
					 if($config['authorizationHandle']=='exception') 
					 {
						$this->exceptionsService->raise( 'accessUnauthorized' );
						return false;		
					} else  if($config['authorizationHandle']=='redirect')
					{
					   $this->rRedirect(HTTP_ADDRESS.$authorization['systemForcedRedirect']);
					} else 
					{

					}
				}
		}

		return true;

	} // end of parseUrlData() method


	public function run(){
		if ($this->parseUrlData()==true) {
			$this->execute();
		} else {
			//couldn't run (exception thrown, etc, but could not run).
		}
	}

	public function execute()
	{
		function ob_html_compress( $buf )
		{
			return preg_replace( 
				array( '/<!--(.*)-->/Uis', 
				"/[[:blank:]]+/"), 
				array( '', ' '), 
				str_replace( array( "\n", "\r", "\t" ),
				'', 
				$buf 
			) );
		}
		
		ob_start( "ob_html_compress" );
		
		if ( $this->controller == '' ){
			$this->exceptionsService->raise( 'controllerNotFound' );
		}
			
		if ( $this->action == '' ){
			$this->exceptionsService->raise( 'actionNotFound' );
		}
				
		if ( !ctype_alnum( $this->controller ) ) {
			$this->exceptionsService->raise( 'controllerNameInvalid' );
		}
			
		if (!ctype_alnum( $this->action ) ) {
			$this->exceptionsService->raise( 'actionNameInvalid' );
		}
			
		$this->loadController( $this->controller, $this );
	
		if ( !method_exists( $this->{$this->controller.'Controller'}, $this->action ) ) {
			$this->exceptionsService->raise( 'actionNotFound' );
		}
		else {
			 
			$this->{$this->controller.'Controller'}->{$this->action}( $this->data );
		}
		
	} // end of execute() method
	
	private function loadController( $controllerName, $parentApp )
	{
		$controllerClassName = ucfirst( $controllerName );
		$fileForInclusion = CONTROLLERS . '' . $controllerName.'.php';

		if ( file_exists( $fileForInclusion ) ){
			require_once( $fileForInclusion );
			$this->{$controllerName.'Controller'} = $controllerClassName::create( $controllerName, $parentApp );

			//print_r($this->{$controllerName.'Controller'});
		}
		else {
			$this->exceptionsService->raise( 'controllerNotFound' );
		}
		
	}
	
	private function loadExceptionService()
	{
		$serviceName = 'exceptions';
		$serviceClassName = ucfirst( $serviceName );
		$fileForInclusion = SERVICES . '' . $serviceName . '.php';
	
		if ( file_exists( $fileForInclusion ) ) {
			include_once( $fileForInclusion );
			$this->{$serviceName.'Service'} = $serviceClassName::create( $serviceName, $this );
		}
		else {
			//$this->primitiveException->raise( 'serviceNotFound' );
			//cannot throw exception via our method
			try {
				throw new Exception("Exceptions Service not found", 1);
			} catch(Exception $r) {
				echo $r->getMessage();
			}
			
			
			
		}
	}

	private function loadAuthorizationService()
	{
		$serviceName = 'authorization';
		$serviceClassName = ucfirst( $serviceName );
		$fileForInclusion = SERVICES . '' . $serviceName . '.php';
		
		if ( file_exists( $fileForInclusion ) ) {
			include_once( $fileForInclusion );
			$this->{$serviceName.'Service'} = $serviceClassName::create( $serviceName, $this );
		}
		else {
			$this->exceptionsService->raise( 'serviceNotFound' );
		}
	}

	private function loadPlugin( $pluginName )
	{
		$pluginClassName = ucfirst( $pluginName );
		$fileForInclusion = PLUGINS . '' . $pluginName . '/' . $pluginName . '.php';
		
		if ( file_exists( $fileForInclusion ) ){
			include_once( $fileForInclusion );
			$this->{$pluginName.'Plugin'} = $pluginClassName::create( $pluginName );
		}
		else {
			$this->exceptionsService->raise( 'pluginNotFound' );
		}	
	}

	public function getController()
	{
		return $this->controller;
	}
	
	public  function getAction()
	{
		return $this->action;
	}
		
	public function getData()
	{
		return $this->data;
	}
	
	public function greet()
	{
		echo "Application <b>" . $this->name . "</b> Online <br/>";
	}

	public function redirect( $destination ) 
	{
		header( "Location: " . $destination );
		exit;
	}	


	public function rRedirect( $destination ) 
	{
		header( "Location: " . $destination, true, 302 );
		exit;
	}	


	
}