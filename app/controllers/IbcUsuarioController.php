<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class IbcUsuarioController extends ControllerBase
{    
	public $user;
    public function initialize()
    {
        $this->tag->setTitle("Usuarios");
        $this->user = $this->session->get('auth');
        parent::initialize();
    }

    /**
     * index action
     */
    public function indexAction()
    {
    	$usuarios = IbcUsuario::find();
    	if (count($usuarios) == 0) {
    		$this->flash->notice("No se ha agregado ningún usuario hasta el momento");
    		$usuarios = null;
    	}
    	$this->view->usuarios = $usuarios;
    	$this->view->nivel = $this->user['nivel'];
    }

    /**
     * Formulario para creación de usuario
     */
    public function nuevoAction()
    {
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/jquery.cropit.min.js')
    	->addCss('css/cropit.css')
    	->addJs('js/nuevo_usuario.js');
    	$componentes = IbcComponente::find();
    	$this->view->componentes = $componentes;
    	$cargos = IbcUsuarioCargo::find();
    	$this->view->cargos = $cargos;
    	$this->view->usuarios_lider = IbcUsuario::find(['id_usuario_cargo = 5', 'order' => 'usuario asc']);
    }
    
    /**
     * Ver Usuario
     *
     * @param int $id_usuario
     */
    public function verAction($id_usuario)
    {
    	$ibc_usuario = IbcUsuario::findFirstByid_usuario($id_usuario);
    	if (!$ibc_usuario) {
    		$this->flash->error("El usuario no fue encontrado");
    		return $this->response->redirect("ibc_usuario/");
    	}
    	$this->view->usuario = $ibc_usuario;
    }

    /**
     * Editar Usuario
     *
     * @param int $id_usuario
     */
    public function editarAction($id_usuario)
    {
        if (!$this->request->isPost()) {

            $usuario = IbcUsuario::findFirstByid_usuario($id_usuario);
            if (!$usuario) {
                $this->flash->error("El usuario no fue encontrado");
                return $this->response->redirect("ibc_usuario/");
            }
            $this->assets
	    	->addJs('js/parsley.min.js')
	    	->addJs('js/parsley.extend.js')
	    	->addJs('js/jquery.cropit.min.js')
	    	->addCss('css/cropit.css')
	    	->addJs('js/nuevo_usuario.js');
	    	$componentes_get = IbcComponente::find();
	    	$componentes = array();
	    	foreach($componentes_get as $row) {
	    		$componentes[$row->id_componente] = $row->nombre;
	    	}
	    	$this->view->componentes = $componentes;
	    	$cargos_get = IbcUsuarioCargo::find();
	    	$cargos = array();
	    	foreach($cargos_get as $row) {
	    		$cargos[$row->id_usuario_cargo] = $row->nombre;
	    	}
	    	$usuarios_lider_get = IbcUsuario::find(['id_usuario_cargo = 5', 'order' => 'usuario asc']);
	    	$usuarios_lider = array();
	    	foreach($usuarios_lider_get as $row) {
	    		$usuarios_lider[$row->id_usuario] = $row->nombre;
	    	}
	    	$this->view->usuarios_lider = $usuarios_lider;
	    	$this->view->cargos = $cargos;
            $this->view->usuario = $usuario;
            $this->tag->setDefault("usuario", $usuario->usuario);
            $this->tag->setDefault("nombre", $usuario->nombre);
            $this->tag->setDefault("email", $usuario->email);
            $this->tag->setDefault("telefono", $usuario->telefono);
            $this->tag->setDefault("celular", $usuario->celular);
            $this->tag->setDefault("foto", $usuario->foto);
            $this->tag->setDefault("id_componente", $usuario->id_componente);
            $this->tag->setDefault("id_usuario_cargo", $usuario->id_usuario_cargo);
            $this->tag->setDefault("id_usuario_lider", $usuario->id_usuario_lider);
        }
    }
    
    /**
     * Editar Usuario
     *
     * @param int $id_usuario
     */
    public function editarperfilAction()
    {
    	if (!$this->request->isPost()) {
    
    		$usuario = IbcUsuario::findFirstByid_usuario($this->user['id_usuario']);
    		if (!$usuario) {
    			$this->flash->error("El usuario no fue encontrado");
    			return $this->response->redirect("ibc_mensaje");
    		}
    		$this->assets
    		->addJs('js/parsley.min.js')
    		->addJs('js/parsley.extend.js')
    		->addJs('js/jquery.cropit.min.js')
    		->addCss('css/cropit.css')
    		->addJs('js/nuevo_usuario.js');
    		$this->view->usuario = $usuario;
    		$this->tag->setDefault("nombre", $usuario->nombre);
    		$this->tag->setDefault("email", $usuario->email);
    		$this->tag->setDefault("telefono", $usuario->telefono);
    		$this->tag->setDefault("celular", $usuario->celular);
    		$this->tag->setDefault("foto", $usuario->foto);
    	}
    }
    
    /**
     * actualizardatos
     *
     * @param int $id_usuario
     */
    public function actualizardatosAction()
    {
    	if (!$this->request->isPost()) {
    		$this->flash->error("<strong>Atención:</strong> Debes de actualizar tus datos antes de ingresar a las opciones del Sistema de Información.");
    		$usuario = IbcUsuario::findFirstByid_usuario($this->user['id_usuario']);
    		if (!$usuario) {
    			$this->flash->error("El usuario no fue encontrado");
    			return $this->response->redirect("ibc_mensaje");
    		}
    		$this->assets
    		->addJs('js/parsley.min.js')
    		->addJs('js/parsley.extend.js')
    		->addJs('js/jquery.cropit.min.js')
    		->addCss('css/cropit.css')
    		->addJs('js/nuevo_usuario.js');
    		$this->view->usuario = $usuario;
    		$this->view->id_usuario_cargo = $this->user['id_usuario_cargo'];
    		$this->tag->setDefault("nombre", $usuario->nombre);
    		$this->tag->setDefault("email", $usuario->email);
    		$this->tag->setDefault("telefono", $usuario->telefono);
    		$this->tag->setDefault("celular", $usuario->celular);
    		$this->tag->setDefault("foto", $usuario->foto);
    	}
    }
    
    /**
     * Creación de un nuevo usuario
     */
    public function crearAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("ibc_usuario/");
    	}
    	$usuario = new IbcUsuario();
    	if($this->request->getPost("image-data")){
    		$usuario->foto = $this->request->getPost("image-data");
    	}
    	$usuario->id_componente = $this->request->getPost("id_componente");
    	$usuario->usuario = $this->request->getPost("usuario");
    	$usuario->nombre = $this->request->getPost("nombre");
    	$usuario->telefono = $this->request->getPost("telefono");
    	$usuario->celular = $this->request->getPost("celular");
    	$usuario->email = $this->request->getPost("email");
    	$usuario->id_usuario_cargo = $this->request->getPost("id_usuario_cargo");
    	$usuario->id_usuario_lider = $this->request->getPost("id_usuario_lider");
    	$usuario->password = $this->security->hash($this->request->getPost("password"));
    	$usuario->estado = 1;
    	if (!$usuario->save()) {
    		foreach ($usuario->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("ibc_usuario/nuevo");
    	}
    	$this->flash->success("El usuario fue creado exitosamente.");
    	return $this->response->redirect("ibc_usuario/");
    }
 
    /**
     * Guarda el usuario editado
     *
     */
    public function guardarAction($id_usuario)
    {

        if (!$this->request->isPost()) {
            return $this->response->redirect("ibc_usuario");
        }
        
        $usuario = IbcUsuario::findFirstByid_usuario($id_usuario);
        if (!$usuario) {
        	$this->flash->error("El usuario no fue encontrado");
        	return $this->response->redirect("ibc_usuario/");
        }
    	if($this->request->getPost("image-data")){
    		$usuario->foto = $this->request->getPost("image-data");
    	}
    	$usuario->id_componente = $this->request->getPost("id_componente");
    	$usuario->usuario = $this->request->getPost("usuario");
    	$usuario->nombre = $this->request->getPost("nombre");
    	$usuario->telefono = $this->request->getPost("telefono");
    	$usuario->celular = $this->request->getPost("celular");
    	$usuario->email = $this->request->getPost("email");
    	$usuario->id_usuario_lider = $this->request->getPost("id_usuario_lider");
    	$usuario->id_usuario_cargo = $this->request->getPost("id_usuario_cargo");
    	if($this->request->getPost("password")){
    		$usuario->password = $this->security->hash($this->request->getPost("password"));
    	}
    	if (!$usuario->save()) {
    		foreach ($usuario->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("ibc_usuario/editar/$id_usuario");
    	}
    	$this->flash->success("El usuario fue actualizado exitosamente.");
    	return $this->response->redirect("ibc_usuario/editar/$id_usuario");

    }
    
    /**
     * Guarda el usuario editado
     *
     */
    public function guardarperfilAction()
    {
    
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("ibc_usuario");
    	}
    
    	$usuario = IbcUsuario::findFirstByid_usuario($this->user['id_usuario']);
    	if (!$usuario) {
    		$this->flash->error("El usuario no fue encontrado");
    		return $this->response->redirect("ibc_mensaje/");
    	}
    	if($this->request->getPost("image-data")){
    		$usuario->foto = $this->request->getPost("image-data");
    	}
    	if($this->request->getPost("nombre")){
    		$usuario->nombre = $this->request->getPost("nombre");
    	}
    	$usuario->telefono = $this->request->getPost("telefono");
    	$usuario->celular = $this->request->getPost("celular");
    	$usuario->email = $this->request->getPost("email");
    	$usuario->estado = 1;
    	if($this->request->getPost("password")){
    		$usuario->password = $this->security->hash($this->request->getPost("password"));
    	}
    	if (!$usuario->save()) {
    		foreach ($usuario->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("ibc_usuario/editarperfil");
    	}
    	$this->flash->success("El usuario fue actualizado exitosamente.");
    	return $this->response->redirect("ibc_usuario/editarperfil");
    
    }
    
    /**
     * Guarda el usuario editado
     *
     */
    public function guardaractualizardatosAction()
    {
    
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("ibc_usuario");
    	}
    
    	$usuario = IbcUsuario::findFirstByid_usuario($this->user['id_usuario']);
    	if (!$usuario) {
    		$this->flash->error("El usuario no fue encontrado");
    		return $this->response->redirect("ibc_mensaje/");
    	}
    	if($this->request->getPost("image-data")){
    		$usuario->foto = $this->request->getPost("image-data");
    	}
    	if($this->request->getPost("nombre")){
    		$usuario->nombre = $this->request->getPost("nombre");
    	}
    	$usuario->telefono = $this->request->getPost("telefono");
    	$usuario->celular = $this->request->getPost("celular");
    	$usuario->email = $this->request->getPost("email");
    	$usuario->estado = 1;
    	if($this->request->getPost("password")){
    		$usuario->password = $this->security->hash($this->request->getPost("password"));
    	}
    	if (!$usuario->save()) {
    		foreach ($usuario->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("ibc_usuario/actualizardatos");
    	}
    	$this->flash->success("El usuario fue actualizado exitosamente.");
    	$id_usuario = $this->user['id_usuario'];
    	return $this->response->redirect("session/restart/$id_usuario");
    
    }

    /**
     * Elimina un usuario
     *
     * @param int $id_usuario
     */
    public function eliminarAction($id_usuario)
    {

        $usuario = IbcUsuario::findFirstByid_usuario($id_usuario);
        if (!$usuario) {
            $this->flash->error("El usuario no fue encontrado");
            return $this->response->redirect("ibc_usuario/");
        }

        if (!$usuario->delete()) {

            foreach ($usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->response->redirect("ibc_usuario/");
        }

        $this->flash->success("El usuario fue eliminado correctamente");

        return $this->response->redirect("ibc_usuario/");
    }
    
    /**
     * Asignar Interventores
     *
     * @param int $id_usuario
     */
    public function interventoresAction()
    {
    
    	$interventores = IbcUsuario::find(['id_usuario_cargo = 3', 'order' => 'usuario asc']);
    	if (count($interventores) == 0) {
    		$this->flash->notice("No se ha agregado ningún interventor hasta el momento");
    		$interventores == null;
    	}
    	$this->view->interventores = $interventores;
    }

}
