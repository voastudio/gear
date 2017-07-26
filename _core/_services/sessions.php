<?php

class Sessions extends Service 
{


	protected function afterDestruct()
	{

	}	

	protected function afterConstruct() 
	{
        global $config;

             $this->start();
         
    }

    private function start() 
	{
    	session_start();
    	//return true;
    }
    
    public function clear() 
	{
    	session_unset();
    	return true;
    }
    
    public function end() 
	{
    	session_destroy(); 
    	return true;
    }

    public function set( $key, $value ) 
	{
   	 	if ( $key != '' ) { 
   	 		$_SESSION[$key] = $value;
    		return true;
    	}

    	return false;
    }

    public function get ( $key ) 
	{

        if ( isset( $_SESSION[$key] ) ) {
			return $_SESSION[$key];
		}	
		
		return false;
    }
    
    public function remove( $key ) 
	{
    	if ( $key != '' ) {
			unset( $_SESSION[$key] );
		}
    }
    
    public function dump() 
	{
    	print_r( $_SESSION );
    }
        
    public function id()
	{
		if ( session_id() != '') {
			return session_id();
		}
		
		return false;
    }

}