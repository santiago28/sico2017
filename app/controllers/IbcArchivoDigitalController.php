<?php
 
use Phalcon\Mvc\Model\Criteria;

class IbcArchivoDigitalController extends ControllerBase
{    
	public $user;
    public function initialize()
    {
        $this->tag->setTitle("Periodos");
        $this->user = $this->session->get('auth');
        $this->id_usuario = $this->user['id_usuario'];
        parent::initialize();
    }

    /**
     * index action
     */
    public function indexAction($anio)
    {
        $this->persistent->parameters = null;
        $menu = BcOferenteMenu::find("id_usuario = $this->id_usuario AND anio = $anio")->toArray();
        if($menu){
        	if (substr($this->conversiones->get_client_ip(), 0, 7) == "192.168"){
                //$this->view->url = "http://190.248.150.222:842/owncloud/" . $menu[0]['menu'];
                $this->view->url = "http://192.168.2.4/owncloud/" . $menu[0]['menu'];
        	} else {
        		$this->view->url = "http://190.248.150.222:842/owncloud/" . $menu[0]['menu'];
        	}
        } else {
        	$this->flash->error("No se encontraron archivos para el año $anio");
        }
    }

}
