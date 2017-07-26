<?php

class Home extends Controller 
{

	public function index( array $data = null ) 
    {
    	$indexView = $this->loadView('index',$data); //load ok
	}


}
