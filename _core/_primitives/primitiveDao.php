<?php
//table is set in variable $table


class Dao 
{
	private $name;
	private $database;
	private $table;
	private $order = 'ASC';
	private $lastInsert;
	public $App;
	
	private function __construct( $daoName , &$parentApp )
	{
		$this->name = $daoName;
		$this->App = &$parentApp;
		 
		$this->loadDatabaseService();
		$this->afterConstruct();
	}
	
	public static function create( $daoName, $parentApp ) 
	{
		return new static( $daoName, $parentApp );
	}
	
	public function __destruct()
	{	
	
		$this->afterDestruct();
	}
	
	public function afterConstruct()
	{
		
	}
	
	public function afterDestruct()
	{
		
	}
	
	public function setDbTable( $table )
	{
		$this->table = $table;
	}
	
	public function getDbTable( $table )
	{
		return $this->table;
	}
	
	public function greet()
	{
		echo "DAO <b>" . $this->name . "</b> Online <br/>";
	}
	
    protected function loadDatabaseService()
	{
    	$serviceName = 'mysql';
      	$serviceClassName = ucfirst( $serviceName );
  
      	$fileForInclusion = SERVICES . '' . $serviceName . '.php';
      	if ( file_exists( $fileForInclusion ) ) {
        	include_once( $fileForInclusion );
        	$this->database = $serviceClassName::create( $this->name . '->' . $serviceName, $this->App );
			
		}
      	else {
        	$this->App->exceptionsService->raise( 'serviceNotFound' );
      	}
    }
	
	public function orderUp()
	{
		$this->order = 'ASC';
	}
	
	public function orderDown()
	{
		$this->order = 'DESC';
	}
	
	public function find( $key = null, $value = null, $fields = null )
	{	
		if ( $fields == null ) {
			$fieldstring = "*";
		}
		else {
			$fieldstring = implode( ",", $fields);
		}

		if ($key == null) {
			$sql = "SELECT " . $fieldstring . " FROM " . $this->table . " ORDER BY id " . $this->order;
		}
		else {
			$sql = "SELECT " . $fieldstring . " FROM " . $this->table . " WHERE `" . $key . "` = '" . $value . "' ORDER BY id " . $this->order;
		}
		
		$result = $this->database->query( $sql );
		return $result->fetchAll();
	}

	public function insert( $fields, $data )
	{
		for ( $i = 0; $i < count( $data ); $i++ ) {
			$data[$i] = htmlentities( $data[$i], ENT_QUOTES );
		}
		
		$fieldstring = "`" . implode( "`,`", $fields ) . "`";
		$datastring = "'" . implode( "','", $data ) . "'";
		$sql = "INSERT INTO " . $this->table . " (" . $fieldstring . ") VALUES (" . $datastring . ")";
		$result = $this->database->query( $sql );
		$this->lastInsert =  $this->database->lastInsert;
	
		return $result;
	}

	public function lastInsert() 
	{
		return $this->database->lastInsert;
	}

	public function remove( $key, $value )
	{	
		$sql = "DELETE FROM " . $this->table . " WHERE `" . $key . "`='" . $value . "'";
		$result = $this->database->query( $sql );
		return $result;
	}
	
	public function update( $key, $value, $fields, $sdata )
	{
		$setstring = "";	
		
		for ( $i = 0; $i < count( $fields ); $i++ ){
			$setstring = $setstring . "`" . $fields[$i] . "`='" . htmlentities( $sdata[$i], ENT_QUOTES ) . "'";
			if ( $i < count( $fields ) - 1 ) {
				$setstring = $setstring . ",";
			} 
		}
		
		$sql =  "UPDATE " . $this->table . " SET " . $setstring . " WHERE `" . $key . "` = '" . $value . "'";
		$result = $this->database->query( $sql );		
		return $result;
	}
	
}