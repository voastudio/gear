<?php

class DiskIoException extends PrimitiveException 
{

	public function __construct()
	{
		$msg = 'Your hard disc has died!';
		$this->message = $msg;
	}
	
}