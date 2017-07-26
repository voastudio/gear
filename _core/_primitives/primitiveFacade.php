<?php

class Facade 
{
	private $name;
	private $entitiesArray;
	private $daoArray;

	public $App;
	
	/*	How to list the components of a facade class:
	
		$dependeces = array(
			'entities' => array( 'entity1', 'entity2' ),
			'daos' => array( 'dao1', 'dao2' )
		);
	*/
	private function __construct( $facadeName, &$parentApp )
	{
		$this->name = $facadeName;
		$this->App = &$parentApp;

		$this->afterConstruct(); // nothing will happen
	}


	public static function create( $facadeName, $parentApp ) 
	{
		return new static( $facadeName, $parentApp );
	}


	public function loadDependeces( array $dependeces = null  )
	{
		if ( sizeof( $dependeces[ 'entities' ] ) > 0 ) {
			$this->entitiesArray = $dependeces[ 'entities' ];
		}

		if ( sizeof( $dependeces[ 'daos' ] ) > 0 ) {
			$this->daoArray = $dependeces[ 'daos' ];
		}
		
		for ( $i = 0; $i < sizeOf( $this->entitiesArray ); $i++) {
			$this->loadEntity( $this->entitiesArray[$i] );
		}
		
		for ( $i = 0; $i < sizeOf( $this->daoArray ); $i++) {
			$this->loadDao( $this->daoArray[$i] );
		}
	}

	public function loadEntity( $entityName ) 
	{
		$entityClassName = ucfirst( $entityName ).'Entity';
		$fileForInclusion = ENTITIES  . $entityName . '/' . $entityName . 'Entity.php';


		//echo ($fileForInclusion);
		//die();

		if ( file_exists( $fileForInclusion ) ) {
			require_once( $fileForInclusion );
			$this->{$entityName.'Entity'} = $entityClassName::create( $entityName . 'Entity', $this->App );	
		}
		else {
			$this->App->exceptionsService->raise( 'entityNotFound' );
		}
	}
	

	public function loadDao( $entityName ) 
	{
		$entityClassName = ucfirst( $entityName ).'Dao';
		$fileForInclusion = ENTITIES . '/' . $entityName . '/' . $entityName . 'Dao.php';

		//echo ($fileForInclusion);
		//die();


		if ( file_exists( $fileForInclusion ) ) {
			require_once( $fileForInclusion );
			$this->{$entityName.'Dao'} = $entityClassName::create( $entityName . 'Dao', $this->App );
		}
		else {
			$this->App->exceptionsService->raise( 'daoNotFound' );
		}
	}
	
	public function afterConstruct( )
	{

	}
	
	public function afterDestruct()
	{
		
	}
	
}