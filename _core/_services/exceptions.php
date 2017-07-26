<?php

class Exceptions extends Service 
{
	public function raise ( $exceptionName ) 
	{
		try {
			$exceptionName = $exceptionName.'Exception';
			$exceptionClassName = ucfirst( $exceptionName );
			require_once( EXCEPTIONS . '' . $exceptionName . '.php' );
			throw new $exceptionClassName();
		}catch( Exception $err) {
			$err->handle();
		}	
		
	}


	protected function afterDestruct()
	{
		 
	}

	protected function afterConstruct()
	{
		 
	}

}