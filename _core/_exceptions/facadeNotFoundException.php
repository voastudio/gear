<?php


class FacadeNotFoundException extends PrimitiveException
{

	public function __construct()
	{
		$msg = 'facade not found';
		$this->message = $msg;
	}
	
}