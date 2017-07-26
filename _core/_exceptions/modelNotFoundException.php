<?php

class ModelNotFoundException extends PrimitiveException
{
	public function __construct()
	{
		$msg = 'model not found';
		$this->message = $msg;
	}

}