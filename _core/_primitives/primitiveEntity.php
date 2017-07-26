<?php

class Entity
{
	

	
	public function afterConstruct()
	{
		
	}
	
	public function afterDestruct()
	{
		
	}


	private function __construct( $entityName, &$parentApp )
	{
		$this->name = $entityName;
		$this->App = &$parentApp;

		$this->afterConstruct(); // nothing will happen
	}


	public static function create( $entityName, $parentApp ) 
	{
		return new static( $entityName, $parentApp );
	}


		
}