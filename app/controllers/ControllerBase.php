<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
	/**
	 * Definición del título y el archivo de plantilla base
	 */
    protected function initialize()
    {
        $this->tag->prependTitle('Interventoría Buen Comienzo | ');
        $this->view->setTemplateAfter('main');
    }
    protected function forward($uri)
    {
    	$uriParts = explode('/', $uri);
    	$params = array_slice($uriParts, 2);
    	return $this->dispatcher->forward(
    			array(
    					'controller' => $uriParts[0],
    					'action' => $uriParts[1],
    					'params' => $params
    			)
    	);
    }
}
