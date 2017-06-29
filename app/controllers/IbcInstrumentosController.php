<?php
 
use Phalcon\Mvc\Model\Criteria;

class IbcInstrumentosController extends ControllerBase
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
    public function indexAction()
    {
        $this->persistent->parameters = null;
        if (substr($this->conversiones->get_client_ip(), 0, 7) == "192.168"){
        	$this->view->url = "http://192.168.2.4/owncloud/index.php/s/Uw3983BdeJnuUfl";
        } else {
        	$this->view->url = "http://190.248.150.222:842/owncloud/index.php/s/Uw3983BdeJnuUfl";
        }
    }

}
