<?php

class ActionNameInvalidException extends PrimitiveException 
{	
	public function __construct()
	{
		$msg = 'action name invalid';
		$this->message = $msg;
	}
		
}