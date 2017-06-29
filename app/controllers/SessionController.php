<?php

/**
 * SessionController
 *
 * Permite autenticar a los usuarios
 */
class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Iniciar Sesión');
        parent::initialize();
    }

    public function indexAction()
    {
    }

    /**
     * Registra el usuario autenticado en los datos de la sesión (session)
     *
     * @param IbcUsuario $user
     */
    private function _registerSession($user)
    {
    	$this->session->set('auth', array(
    			'id_usuario' => $user->id_usuario,
    			'id_componente' => $user->id_componente,
    			'componente' => $user->IbcComponente->nombre,
    			'usuario' => $user->usuario,
    			'email' => $user->email,
    			'nombre' => $user->nombre,
    			'id_usuario_cargo' => $user->id_usuario_cargo,
    			'foto' => $user->foto,
    			'estado' => $user->estado,
    			'nivel' => $user->IbcUsuarioCargo->nivelPermiso
    	));
    }

    /**
     * Autenticación y logueo del usuario en la aplicación
     *
     */
    
    public function startAction()
    {
    	if ($this->request->isPost()) {
    		$password = $this->request->getPost('password');
    		$usuario = $this->request->getPost('usuario');
    		$user = IbcUsuario::findFirst(array("email='$usuario' OR usuario = '$usuario'"));
    		if ($user) {
    			if ($this->security->checkHash($password, $user->password)) {
    				$this->_registerSession($user);
    				$this->flash->success('Bienvenido(a) ' . $user->nombre);
    				if ($this->session->has("last_url")) {
    					return $this->response->redirect($this->session->get("last_url"));
    				}
    				return $this->response->redirect('ibc_mensaje/anuncios');
    			}
    		}
            $this->flash->error('Contraseña o usuario inválido');
        }
        return $this->response->redirect('session/index');
    }
    
    public function restartAction($id_usuario)
    {
    	$usuario = IbcUsuario::findFirstByid_usuario($id_usuario);
    	if ($usuario) {
    		$this->_registerSession($usuario);
    		return $this->response->redirect('ibc_mensaje/anuncios');
    	} else {
    		return $this->response->redirect('session/index');
    	}
    	return $this->response->redirect('session/index');
    }

    /**
     * Finalización de la sesión redireccionando al inicio
     *
     * @return unknown
     */
    public function endAction()
    {
        $this->session->remove('auth');
        $this->flash->success('¡Hasta pronto!');
        return $this->response->redirect('session/index');
    }
}
