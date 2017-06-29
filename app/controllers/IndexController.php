<?php

use Phalcon\Mvc\Model\Criteria;

class IndexController extends ControllerBase
{
	public $user;
	
    public function initialize()
    {
        $this->user = $this->session->get('auth');        
        parent::initialize();
        $this->view->setTemplateAfter('mainindex');
    }

    public function indexAction()
    {
    	$this->persistent->parameters = null;
    	$this->assets
    	->addCss('css/carousel.css');
    }
    
    public function quienessomosAction()
    {
    }
    
    public function directorioAction()
    {
    }
    
    public function contactoAction()
    {
    	$this->assets
    	->addJs('http://maps.googleapis.com/maps/api/js?sensor=false&extension=.js&output=embed')
    	->addJs('js/parsley.min.js')
    	->addJs('js/contacto.js');
    	$this->assets
    	->addCss('css/contacto.css');
    }
}
