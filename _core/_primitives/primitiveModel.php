<?php

class Model 
{
	private $name;

	public $App;
	
	function __construct( $modelName , &$parentApp)
	{
		$this->name = $modelName;
		$this->App = &$parentApp;
		
		$this->afterConstruct();
	}

	public function __destruct()
	{	
		$this->afterDestruct();
	}
	
	public static function create( $modelName, $parentApp ) 
	{
		return new static( $modelName, $parentApp );
	}
	
	public function afterConstruct()
	{
		
	}
	
	public function afterDestruct()
	{
		
	}

	public function loadFacade( $facadeName, array $dependeces = null ) 
	{
		$facadeClassName = ucfirst( $facadeName ).'Facade';
		$fileForInclusion = ENTITIES . $facadeName . 'Facade.php';

		//print_r($facadeClassName.'</br>');
		//print_r($facadeName);

		if ( file_exists( $fileForInclusion ) ) {
			include_once( $fileForInclusion );
			$this->{$facadeName.'Facade'} = $facadeClassName::create( $facadeName.'Facade', $this->App );
			//$this->{$facadeName.'Facade'}->loadDependeces( $dependeces );
		}
		else {
			$this->App->exceptionsService->raise( 'facadeNotFound' );
		}
	}

	
	public function greet()
	{
		echo "Model <b>" . $this->name . "</b> Online <br/>";
	}
				
}