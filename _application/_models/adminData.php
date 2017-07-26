<?php

class ExampleData extends Model 
{


    public function geExampletData()
    {

        $this->loadFacade('example');
        return $this->exampleFacade->getData();
    }


	
}