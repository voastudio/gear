<?php

class ControllerNotFoundException extends PrimitiveException 
{
	
	public function __construct()
  	{
		$msg = 'kd controller, cralho?';
		$this->message = $msg;
	}
	
}