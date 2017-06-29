<?php

use Phalcon\Mvc\Model\Criteria;

class CobActafocalizacionController extends ControllerBase
{
	public $user;

    public function initialize()
    {
        $this->tag->setTitle("Acta de Verificación de Focalización");
        $this->user = $this->session->get('auth');
        parent::initialize();
    }

    /**
     * Ver
     *
     * @param int $id_periodo
     */
    public function verAction($id_actafocalizacion)
    {
    	$this->assets
    	->addCss('css/acta-impresion-talentohumano.css');
    	$acta = CobActafocalizacion::generarActa($id_actafocalizacion);
    	if (!$acta) {
    		$this->flash->error("El acta no fue encontrada");
    		return $this->response->redirect("cob_actafocalizacion/");
    	}
    	$acta['datos']->id_acta = $id_actafocalizacion;
    	$this->view->nivel = $this->user['nivel'];
    	$this->view->acta_html = $acta['html'];
    	$this->view->acta_datos = $acta['datos'];
    	$this->view->acta = $acta['datos'];
    }

    /**
     * Datos
     *
     * @param int $id_actafocalizacion
     */
    public function datosAction($id_actafocalizacion)
    {
          $acta = CobActafocalizacion::findFirstByid_actafocalizacion($id_actafocalizacion);
          if (!$acta) {
              $this->flash->error("El acta no fue encontrada");

              return $this->response->redirect("cob_actafocalizacion/");
          }
          $this->assets
          ->addJs('js/parsley.min.js')
          ->addJs('js/parsley.extend.js');
          $acta->id_acta = $id_actafocalizacion;
          if($acta->CobActafocalizacionDatos){
          	$this->tag->setDefault("fecha", $this->conversiones->fecha(2, $acta->CobActafocalizacionDatos->fecha));
          	$this->tag->setDefault("horaInicio", $acta->CobActafocalizacionDatos->horaInicio);
          	$this->tag->setDefault("horaFin", $acta->CobActafocalizacionDatos->horaFin);
          	$this->tag->setDefault("nombreEncargado", $acta->CobActafocalizacionDatos->nombreEncargado);
          	$this->tag->setDefault("observacionEncargado", $acta->CobActafocalizacionDatos->observacionEncargado);
          	$this->tag->setDefault("observacionUsuario", $acta->CobActafocalizacionDatos->observacionUsuario);
          }
          $this->view->acta = $acta;
          $this->actaCerrada($acta, $this->user['nivel']);
    }

    /**
     * Guardar Datos
     *
     */
    public function guardardatosAction($id_actafocalizacion)
    {
    	if (!$this->request->isPost()) {
            return $this->response->redirect("cob_actafocalizacion/");
        }
        $acta = CobActafocalizacion::findFirstByid_actafocalizacion($id_actafocalizacion);
        if (!$acta) {
            $this->flash->error("El acta $id_actafocalizacion no existe ");
            return $this->response->redirect("cob_actafocalizacion/");
        }
        $this->guardarActaCerrada($acta, $this->user['nivel']);
        $dato = new CobActafocalizacionDatos();
        $dato->id_actafocalizacion = $id_actafocalizacion;
        $dato->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
        $dato->horaInicio = $this->request->getPost("horaInicio");
        $dato->horaFin = $this->request->getPost("horaFin");
        $dato->nombreEncargado = $this->request->getPost("nombreEncargado");
        $dato->observacionEncargado = $this->request->getPost("observacionEncargado");
        $dato->observacionUsuario = $this->request->getPost("observacionUsuario");
        if (!$dato->save()) {
            foreach ($dato->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect("cob_actafocalizacion/datos/$id_actafocalizacion");
        }
        $this->flash->success("Los Datos Generales fueron actualizados exitosamente");
        return $this->response->redirect("cob_actafocalizacion/datos/$id_actafocalizacion");
    }

    /**
     * Guardar Beneficiarios
     *
     */
    public function guardarbeneficiariosAction($id_actafocalizacion)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actafocalizacion/");
    	}
    	$db = $this->getDI()->getDb();
    	$acta = CobActafocalizacion::findFirstByid_actafocalizacion($id_actafocalizacion);
    	if (!$acta) {
    		$this->flash->error("El acta $id_actafocalizacion no existe");
    		return $this->response->redirect("cob_actafocalizacion/");
    	}
    	$this->guardarActaCerrada($acta, $this->user['nivel']);
    	$elementos = array(
					'id_actafocalizacion_persona' => $this->request->getPost("id_actafocalizacion_persona"),
    			'encuestaSisben' => $this->request->getPost("encuestaSisben"),
    			'puntajeSisben' => $this->request->getPost("puntajeSisben"),
    			'ciudadSisben' => $this->request->getPost("ciudadSisben"),
    			'continuidad2015' => $this->request->getPost("continuidad2015"),
    			'oficioAutorizacion' => $this->request->getPost("oficioAutorizacion"),
    			'observacion' => $this->request->getPost("observacion"),
    	);
    	$sql = $this->conversiones->multipleupdate("cob_actafocalizacion_persona", $elementos, "id_actafocalizacion_persona");
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_actafocalizacion/beneficiarios/$id_actafocalizacion");
    	}
    	$acta->estado = 1;
    	$acta->save();
    	$this->flash->success("Los beneficiarios fueron actualizados exitosamente");
    	return $this->response->redirect("cob_actafocalizacion/beneficiarios/$id_actafocalizacion");
    }

    /**
     * beneficiarios
     *
     * @param int $id_actafocalizacion
     */
    public function beneficiariosAction($id_actafocalizacion) {
    	if (!$this->request->isPost()) {
    		$acta = CobActafocalizacion::findFirstByid_actafocalizacion($id_actafocalizacion);
    		if (!$acta) {
    			$this->flash->error("El acta no fue encontrada");
    			return $this->response->redirect("cob_verificacion/");
    		}
    		$this->assets
    		->addJs('js/parsley.min.js')
    		->addJs('js/parsley.extend.js')
				->addJs('js/jquery.autoNumeric.js')
    		->addJs('js/beneficiarios.js');
    		$this->view->nombre = array();
    		$this->view->beneficiarios = $acta->getCobActafocalizacionPersona(['order' => 'id_sede, primerNombre asc']);
    		$acta->id_acta = $id_actafocalizacion;
    		$this->view->acta = $acta;
				$this->view->asistencia = $this->elements->getSelect("asistencia");
    		$this->view->sinona = $this->elements->getSelect("sinona");
    		$this->actaCerrada($acta, $this->user['nivel']);
    	}
    }

    /**
     * Cierra un acta
     *
     * @param int $id_actafocalizacion
     */
    public function cerrarAction($id_actafocalizacion)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actafocalizacion/ver/$id_actafocalizacion");
    	}
        $acta = CobActafocalizacion::findFirstByid_actafocalizacion($id_actafocalizacion);
        if (!$acta) {
            $this->flash->error("El acta no fue encontrada");
            return $this->response->redirect("cob_actafocalizacion/");
        }
        $uri = $this->request->getPost("uri");
        $error = 0;
        if(!($acta->CobActafocalizacionDatos->fecha)){
        	$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta no puede ser cerrada debido a que:");
        	$this->flash->error("No han sido digitados los datos del acta.");
        	$error = 1;
        }
        if($acta->CobActafocalizacionPersona[0]->encuestaSisben == 0){
        	if($error == 0)
        		$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta no puede ser cerrada debido a que:");
        	$this->flash->error("No han sido digitados beneficiarios en el acta.");
        	$error = 1;
        }
        if($error > 0){
        	return $this->response->redirect($uri);
        } else {
        	//Si es interventor
        	if($this->user['id_usuario_cargo'] == 3){
        		$acta->estado = 2;
        	}
        	//Si es auxiliar administrativo
        	else if($this->user['id_usuario_cargo'] == 5) {
        		$acta->estado = 3;
        	}
        	if (!$acta->save()) {
        		foreach ($acta->getMessages() as $message) {
        			$this->flash->error($message);
        		}
        		return $this->response->redirect($uri);
        	}
        	$this->flash->success("El acta fue cerrada exitosamente");
        	return $this->response->redirect($uri);
        }
    }
    /**
     * Abre un acta
     *
     * @param int $id_actafocalizacion
     */
    public function abrirAction($id_actafocalizacion)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actafocalizacion/ver/$id_actafocalizacion");
    	}
    	$acta = CobActafocalizacion::findFirstByid_actafocalizacion($id_actafocalizacion);
    	if (!$acta) {
    		$this->flash->error("El acta no fue encontrada");
    		return $this->response->redirect("cob_actafocalizacion/");
    	}
    	$uri = $this->request->getPost("uri");
    	//Si es interventor
    	if($this->user['id_usuario_cargo'] !== "5" || $acta->estado !== "2"){
    		$this->flash->error("El acta no puede ser abierta");
    		return $this->response->redirect($uri);
    	}
    	$acta->estado = 1;
    	if (!$acta->save()) {
    		foreach ($acta->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect($uri);
    	}
    	$this->flash->success("El acta fue abierta exitosamente para el interventor");
    	return $this->response->redirect($uri);
    }

    private function actaCerrada($acta, $nivel){
    	if($acta->estado > 3){
    		$estado = $acta->getEstadoDetail();
    		$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta ya ha sido consolidada, por lo tanto no puede ser modificada.");
    		$this->assets
    		->addJs('js/acta_cerrada.js');
    		return 2;
    	} else if($acta->estado == 2 || $acta->estado == 3){
    		$estado = $acta->getEstadoDetail();
    		$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>$estado</b>, por lo tanto no puede modificarla a menos que sea un auxiliar o administrador. Si necesita realizar algún cambio contacte con su auxiliar administrativo.");
    		if($nivel == 3){
    			$this->assets
    			->addJs('js/acta_cerrada.js');
    		}
    		return 1;
    	} else {
    		return FALSE;
    	}
    }
    private function guardarActaCerrada($acta, $nivel){
    	if($acta->estado > 3){
    		$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta no puede ser guardada porque ya ha sido consolidada, si necesita modificar una asistencia realice un ajuste.");
    		return $this->response->redirect("cob_actafocalizacion/datos/$acta->id_actafocalizacion");
    	} else if($acta->estado > 2){
    		$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>Cerrada por Auxiliar</b>, si realizar un cambio contacte con su coordinador.");
    		return $this->response->redirect("cob_actafocalizacion/datos/$acta->id_actafocalizacion");
    	} else if($acta->estado > 1){
    		if($nivel == 3){
    			$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>Cerrada por Interventor</b>, si realizar un cambio contacte con su coordinador.");
    			return $this->response->redirect("cob_actafocalizacion/datos/$acta->id_actafocalizacion");
    		}
    		return FALSE;
    	} else {
    		return FALSE;
    	}
    }

}
