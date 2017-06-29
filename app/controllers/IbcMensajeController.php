<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class IbcMensajeController extends ControllerBase
{    
	public $user;
	public $id_usuario;
    public function initialize()
    {
        $this->tag->setTitle("Comunicaciones");
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
        return $this->response->redirect("ibc_mensaje/anuncios");;
    }
    
    /**
     * index action
     */
    public function mensajeAction($id_mensaje)
    {
    	$ibc_mensaje = IbcMensaje::findFirstByid_mensaje($id_mensaje);
    	if (!$ibc_mensaje) {
    		$this->flash->error("El mensaje no fue encontrado, posiblemente fue eliminado");
    		return $this->response->redirect("ibc_mensaje/");
    	}
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/mensajes.js')
    	->addJs('js/multifilter.min.js')
    	->addCss('css/mensajes.css');
    	$this->view->mensaje = $ibc_mensaje;
    }
    
    /**
     * index action
     */
    public function mensajesAction()
    {
    	$this->persistent->parameters = null;
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/mensajes.js')
    	->addJs('js/multifilter.min.js')
    	->addCss('css/mensajes.css');
    	$ibc_mensaje = IbcMensaje::find(['tipo = 2', 'order' => 'id_mensaje desc']);
    	if (count($ibc_mensaje) == 0) {
    		$mensajes = null;
    	} else {
    		$mensajes = $ibc_mensaje->filter(function($mensaje){
    			if ($mensaje->id_usuario == $this->id_usuario) {
    				return $mensaje;
    			}
    			else {
    				foreach($mensaje->IbcMensajeUsuario as $row){
    					if($row->id_usuario == $this->id_usuario) {
    						return $mensaje;
    					}
    				}
    			}
    		});
    	}
    $destinatarios = array();
    	$this->view->anuncio = "";
    	if($this->user['id_usuario_cargo'] == 6 || $this->user['id_usuario_cargo'] > 5){
    		$destinatarios['155'] = "Cobertura";
    		$destinatarios['160'] = "Gestión Institucional";
    		$destinatarios['157'] = "Infraestructura";
    		$destinatarios['162'] = "Nutrición";
    		$destinatarios['161'] = "Pedagogía";
    		$destinatarios['156'] = "Psicosocial";
    		$destinatarios['158'] = "Salud";
    		$destinatarios['159'] = "Verificación";
    	}
    	if($this->user['id_usuario_cargo'] == 7){
    		$this->view->anuncio = "<label class='btn btn-primary active input-group-addon'><input type='checkbox' name='anuncio' value='1' autocomplete='off'> Anuncio</label>";
    		$destinatarios['3'] = "Oferentes";    		
    	}
    	if($this->user['nivel'] < 2){
    		$destinatarios['1'] = $this->user['componente'];
    		$destinatarios['0'] = "Todos";
    		$destinatarios['4'] = "Usuario(s)";
    	}
    	if($this->user['nivel'] < 3){
    		$destinatarios['1'] = $this->user['componente'];
    		$this->view->anuncio = "<label class='btn btn-primary active input-group-addon'><input type='checkbox' name='anuncio' value='1' autocomplete='off'> Anuncio</label>";
    		$destinatarios['2'] = "Auxiliares";
    		$destinatarios['3'] = "Oferentes";
    		$destinatarios['4'] = "Usuario(s)";
    	}
    	$this->view->usuarios = IbcUsuario::find();
    	$this->view->mensajes = $mensajes;
    	$this->view->destinatarios = $destinatarios;
    }
    
    /**
     * index action
     */
    public function anunciosAction()
    {
    	$this->persistent->parameters = null;
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/mensajes.js')
    	->addJs('js/multifilter.min.js')
    	->addCss('css/mensajes.css');
    	$ibc_mensaje = IbcMensaje::find(['tipo = 1', 'order' => 'id_mensaje desc']);
    	if (count($ibc_mensaje) == 0) {
    		$anuncios = null;
    	} else {
    		$anuncios = $ibc_mensaje->filter(function($mensaje){
    			if ($mensaje->id_usuario == $this->id_usuario) {
    				return $mensaje;
    			}
    			else {
    				foreach($mensaje->IbcMensajeUsuario as $row){
    					if($row->id_usuario == $this->id_usuario) {
    						return $mensaje;
    					}
    				}
    			}
    		});
    	}
    	$destinatarios = array();
    	$this->view->anuncio = "";
    	if($this->user['id_usuario_cargo'] == 6 || $this->user['id_usuario_cargo'] > 5){
    		$destinatarios['155'] = "Cobertura";
    		$destinatarios['160'] = "Gestión Institucional";
    		$destinatarios['157'] = "Infraestructura";
    		$destinatarios['162'] = "Nutrición";
    		$destinatarios['161'] = "Pedagogía";
    		$destinatarios['156'] = "Psicosocial";
    		$destinatarios['158'] = "Salud";
    		$destinatarios['159'] = "Verificación";
    	}
    	if($this->user['id_usuario_cargo'] == 7){
    		$this->view->anuncio = "<input type='checkbox' name='anuncio' value='1' autocomplete='off' class='hide' checked>";
    		$destinatarios['3'] = "Oferentes";    		
    	}
    	if($this->user['nivel'] < 2){
    		$destinatarios['1'] = $this->user['componente'];
    		$destinatarios['0'] = "Todos";
    		$destinatarios['4'] = "Usuario(s)";
    	}
    	if($this->user['nivel'] < 3){
    		$destinatarios['1'] = $this->user['componente'];
    		$this->view->anuncio = "<label class='btn btn-primary active input-group-addon'><input type='checkbox' name='anuncio' value='1' autocomplete='off'> Anuncio</label>";
    		$destinatarios['2'] = "Auxiliares";
    		$destinatarios['3'] = "Oferentes";
    		$destinatarios['4'] = "Usuario(s)";
    	}
    	$this->view->usuarios = IbcUsuario::find();
    	$this->view->anuncios = $anuncios;
    	$this->view->destinatarios = $destinatarios;
    }
    
    /**
     * Creación de un nuevo mensaje
     */
    public function crearAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("ibc_mensaje/");
    	}
    	$mensaje = new IbcMensaje();
    	if($this->request->getPost("destinatario") == 4 && count($this->request->getPost("usuarios_agregados")) < 1){
    		$this->tag->setDefault("mensaje", $this->request->getPost("mensaje"));
    		$this->flash->error("Debes de seleccionar al menos un usuario.");
    		return $this->forward("ibc_mensaje/");;
    	}
    	$mensaje->id_usuario = $this->id_usuario;
    	$mensaje->mensaje = $this->request->getPost("mensaje");
    	$mensaje->fecha = date('Y-m-d H:i:s');
    	$mensaje->destinatario = $this->request->getPost("destinatario");
    	if($this->request->getPost("anuncio")){
    		$mensaje->tipo = 1;
    	} else {
    		$mensaje->tipo = 2;
    	}
    	if (!$mensaje->save()) {
    		foreach ($mensaje->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("ibc_mensaje");
    	}
    	$db = $this->getDI()->getDb();
    	$mail = $this->getDI()->getMail();
    	switch($this->request->getPost("destinatario")){
    		//Si es un mensaje para el componente
    		case 1:
    			$id_componente = $this->user['id_componente'];
    			$usuarios = IbcUsuario::find(["id_componente = $id_componente"])->toArray();
    			break;
    		//Si es un mensaje para todos
    		case 0:
    			$usuarios = IbcUsuario::find()->toArray();
    			break;
    		//Si es para los auxiliares
    		case 2:
    			$id_componente = $this->user['id_componente'];
    			$usuarios = IbcUsuario::find(["id_componente = $id_componente AND id_usuario_cargo = 5"])->toArray();
    			break;
    		//Si es para los oferentes
    		case 3:
    			$usuarios = IbcUsuario::find(["id_usuario_cargo = 6"])->toArray();
    			break;
    		//Si es para unos usuarios determinados
    		case 4:
    			$usuarios = $this->request->getPost("usuarios_agregados");
    			$usuarios_id = array();
    			foreach($usuarios as $row){
    				$ibc_usuario = IbcUsuario::findFirstByid_usuario($row);
    				$mail->send(array($ibc_usuario->email => $ibc_usuario->nombre), "Nuevo mensaje: Sistema de Información Interventoría Buen Comienzo", 'mensaje', array('remitente' => $this->user['nombre'], 'email' => $this->user['email'],'mensaje' => $mensaje->mensaje, 'id_mensaje' => $mensaje->id_mensaje));
    				$usuarios_id[] = $row;
    				$mensajes_id[] = $mensaje->id_mensaje;
    			}
    			$elementos = array(
    					'id_usuario' => $usuarios_id,
    					'id_mensaje' => $mensajes_id
    			);
    			$sql = $this->conversiones->multipleinsert("ibc_mensaje_usuario", $elementos);
    			$query = $db->query($sql);
    			$this->flash->success("El mensaje fue creado exitosamente.");
    			return $this->response->redirect("ibc_mensaje/");
    			break;
    		default:
    			$usuarios = array("id_usuario" => $this->request->getPost("destinatario"));
    			break;
    	}
    	$usuarios_id = array();
    	foreach($usuarios as $row){
    		$ibc_usuario = IbcUsuario::findFirstByid_usuario($row);
    		$mail->send(array($ibc_usuario->email => $ibc_usuario->nombre), "Nuevo mensaje: Sistema de Información Interventoría Buen Comienzo", 'mensaje', array('remitente' => $this->user['nombre'], 'email' => $this->user['email'],'mensaje' => $mensaje->mensaje, 'id_mensaje' => $mensaje->id_mensaje));
    		$usuarios_id[] = $row;
    		$mensajes_id[] = $mensaje->id_mensaje;
    	}
    	$elementos = array(
    			'id_usuario' => $usuarios_id,
    			'id_mensaje' => $mensajes_id
    	);
    	$sql = $this->conversiones->multipleinsert("ibc_mensaje_usuario", $elementos);
    	$query = $db->query($sql);
    	$this->flash->success("El mensaje fue creado exitosamente.");
    	return $this->response->redirect("ibc_mensaje/");
    }
    
    /**
     * Ver comentario
     */
    public function comentarioAction($id_mensaje, $tipo = NULL)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("ibc_mensaje/");
    	}
   		$ibc_mensaje = IbcMensaje::findFirstByid_mensaje($id_mensaje);
    	if (!$ibc_mensaje) {
    		$this->flash->error("El mensaje no fue encontrado, posiblemente fue eliminado");
    		return $this->response->redirect("ibc_mensaje/");
    	}
    	$comentario = new IbcMensajeComentario();
    	$comentario->id_usuario = $this->id_usuario;
    	$comentario->comentario = $this->request->getPost("comentario");
    	$comentario->id_mensaje = $id_mensaje;
    	$comentario->fecha = date('Y-m-d H:i:s');
    	if (!$comentario->save()) {
    		foreach ($comentario->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		if($tipo){
    			return $this->response->redirect("ibc_mensaje/mensaje/$id_mensaje");
    		}
    		return $this->response->redirect("ibc_mensaje");
    	}
    	$this->flash->success("El comentario fue guardado exitosamente.");
    	if($tipo){
    		return $this->response->redirect("ibc_mensaje/mensaje/$id_mensaje");
    	}
    	return $this->response->redirect("ibc_mensaje/");
    }
}
