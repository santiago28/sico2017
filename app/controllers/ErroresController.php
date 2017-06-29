<?php
use Phalcon\Mvc\Model\Criteria;

class ErroresController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Ocurrió un error');
        parent::initialize();
    }

    public function error404Action()
    {
    	$this->persistent->parameters = null;

    }

    public function error401Action()
    {
    	$this->persistent->parameters = null;

    }

    public function error500Action()
    {
    	$this->persistent->parameters = null;

    }
}
