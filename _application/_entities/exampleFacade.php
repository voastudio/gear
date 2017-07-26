<?php 

class ExampleFacade extends Facade
{
    public function getData()
    {
        $this->loadEntity('example');
        $this->loadDao('example');
        $this->exampleDao->setDbTable('example');
        //print_r($this->powerwordssectionDao);
        return $this->exampleDao->find();
    }



}