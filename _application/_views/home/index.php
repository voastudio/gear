<?php

class Index extends View 
{
	public function afterConstruct()
	{
	 
	$this->loadTemplateComponent('header');
	$this->loadWidget('configcheck');
	$this->loadTemplateComponent('footer');
	
	}
}
