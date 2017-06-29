<?php

use Phalcon\Mvc\Model\Criteria;

class CobActathController extends ControllerBase
{
	public $user;

    public function initialize()
    {
        $this->tag->setTitle("Acta de Verificación de Talento Humano");
        $this->user = $this->session->get('auth');
        parent::initialize();
    }

    /**
     * Ver
     *
     * @param int $id_periodo
     */
    public function verAction($id_actath)
    {
    	$this->assets
    	->addCss('css/acta-impresion-talentohumano.css');
    	$acta = CobActath::generarActa($id_actath);
    	if (!$acta) {
    		$this->flash->error("El acta no fue encontrada");
    		return $this->response->redirect("cob_actath/");
    	}
    	$acta['datos']->id_acta = $id_actath;
    	$this->view->nivel = $this->user['nivel'];
    	$this->view->acta_html = $acta['html'];
    	$this->view->acta_datos = $acta['datos'];
    	$this->view->acta = $acta['datos'];
    }

    /**
     * Datos
     *
     * @param int $id_actath
     */
    public function datosAction($id_actath)
    {
        if (!$this->request->isPost()) {

            $acta = CobActath::findFirstByid_actath($id_actath);
            if (!$acta) {
                $this->flash->error("El acta no fue encontrada");

                return $this->response->redirect("cob_actath/");
            }
            $this->assets
            ->addJs('js/parsley.min.js')
            ->addJs('js/parsley.extend.js');
            $acta->id_acta = $id_actath;
            if($acta->CobActathDatos){
            	$this->tag->setDefault("fecha", $this->conversiones->fecha(2, $acta->CobActathDatos->fecha));
            	$this->tag->setDefault("horaInicio", $acta->CobActathDatos->horaInicio);
            	$this->tag->setDefault("horaFin", $acta->CobActathDatos->horaFin);
            	$this->tag->setDefault("nombreEncargado", $acta->CobActathDatos->nombreEncargado);
            	$this->tag->setDefault("observacionEncargado", $acta->CobActathDatos->observacionEncargado);
            	$this->tag->setDefault("observacionUsuario", $acta->CobActathDatos->observacionUsuario);
            }
            $this->view->acta = $acta;
            $this->actaCerrada($acta, $this->user['nivel']);
        }
    }

    /**
     * Guardar Datos
     *
     */
    public function guardardatosAction($id_actath)
    {
    	if (!$this->request->isPost()) {
            return $this->response->redirect("cob_actath/");
        }
        $acta = CobActath::findFirstByid_actath($id_actath);
        if (!$acta) {
            $this->flash->error("El acta $id_actath no existe ");
            return $this->response->redirect("cob_actath/");
        }
        $this->guardarActaCerrada($acta, $this->user['nivel']);
        $dato = new CobActathDatos();
        $dato->id_actath = $id_actath;
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
            return $this->response->redirect("cob_actath/datos/$id_actath");
        }
        $this->flash->success("Los Datos Generales fueron actualizados exitosamente");
        return $this->response->redirect("cob_actath/datos/$id_actath");
    }

    /**
     * Guardar Talento Humano
     *
     */
    public function guardartalentohumanoAction($id_actath)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actath/");
    	}
    	$db = $this->getDI()->getDb();
    	$acta = CobActath::findFirstByid_actath($id_actath);
    	if (!$acta) {
    		$this->flash->error("El acta $id_actath no existe");
    		return $this->response->redirect("cob_actath/");
    	}
    	$this->guardarActaCerrada($acta, $this->user['nivel']);
			$fechaRetiro = $this->conversiones->array_fechas(1, $this->request->getPost("fechaRetiro"));
    	$elementos = array(
    			'id_actath_persona' => $this->request->getPost("id_actath_persona"),
    			'cedulaCoincide' => $this->request->getPost("cedulaCoincide"),
    			'nombreCoincide' => $this->request->getPost("nombreCoincide"),
    			'formacionacademicaCoincide' => $this->request->getPost("formacionacademicaCoincide"),
    			'cargoCoincide' => $this->request->getPost("cargoCoincide"),
    			'tipocontratoCoincide' => $this->request->getPost("tipocontratoCoincide"),
    			'salarioCoincide' => $this->request->getPost("salarioCoincide"),
					'dedicacionCoincide' => $this->request->getPost("dedicacionCoincide"),
					'fechaingresoCoincide' => $this->request->getPost("fechaingresoCoincide"),
					'fechaRetiro' => $fechaRetiro,
					'asistencia' => $this->request->getPost("asistencia"),
					'observacion' => $this->request->getPost("observacion")
    	);
    	$sql = $this->conversiones->multipleupdate("cob_actath_persona", $elementos, "id_actath_persona");
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_actath/talentohumano/$id_actath");
    	}
    	$acta->estado = 1;
    	$acta->save();
    	$this->flash->success("El talento humano fue actualizado exitosamente");
    	return $this->response->redirect("cob_actath/talentohumano/$id_actath");
    }

    /**
     * talentohumano
     *
     * @param int $id_actath
     */
    public function talentohumanoAction($id_actath) {
    	if (!$this->request->isPost()) {
    		$acta = CobActath::findFirstByid_actath($id_actath);
    		if (!$acta) {
    			$this->flash->error("El acta no fue encontrada");
    			return $this->response->redirect("cob_verificacion/");
    		}
    		$this->assets
    		->addJs('js/parsley.min.js')
    		->addJs('js/parsley.extend.js')
    		->addJs('js/talentohumano.js');
    		$this->view->nombre = array();
    		$this->view->talentohumano = $acta->getCobActathPersona(['tipoPersona = 0', 'order' => 'id_sede asc']);
    		$acta->id_acta = $id_actath;
    		$this->view->acta = $acta;
				$this->view->asistencia = $this->elements->getSelect("asistencia");
    		$this->view->sinonare = $this->elements->getSelect("sinonare");
    		$this->actaCerrada($acta, $this->user['nivel']);
    	}
    }

		/**
     * Adicionales
     *
     * @param int $id_actath
     */
    public function adicionalesAction($id_actath) {
    	if (!$this->request->isPost()) {
    		$acta = CobActath::findFirstByid_actath($id_actath);
    		if (!$acta) {
    			$this->flash->error("El acta no fue encontrada");
    			return $this->response->redirect("cob_verificacion/");
    		}
    		$this->assets
    		->addJs('js/bootstrap-filestyle.min.js')
    		->addJs('js/parsley.min.js')
    		->addJs('js/parsley.extend.js')
    		->addJs('js/jquery.autoNumeric.js')
    		->addJs('js/talentohumano-adicionales.js');
    		$empleados = $acta->getCobActathPersona(['tipoPersona = 0', 'order' => 'id_sede asc']);
    		$array_empleados = array();
    		foreach($empleados as $row){
    			$array_empleados[] = $row->numDocumento;
    		}
				$acta->id_acta = $id_actath;
    		$this->view->adicionales = $acta->getCobActathPersona(['tipoPersona = 1', 'order' => 'id_sede asc']);
    		$this->view->listado_empleados = implode(",", $array_empleados);
    		$this->view->id_actath = $id_actath;
    		$this->view->asistencia = $this->elements->getSelect("asistencia");
				$this->view->cargo = $this->elements->getSelect("cargoth");
				$this->view->tipoContrato = $this->elements->getSelect("tipoContrato");
    		$this->view->acta = $acta;
    		$this->actaCerrada($acta, $this->user['nivel']);
    	}
    }

		/**
     * Guardar Adicionales
     *
     */
    public function guardaradicionalesAction($id_actath)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_verificacion/");
    	}
    	$db = $this->getDI()->getDb();
    	$acta = CobActath::findFirstByid_actath($id_actath);
    	if (!$acta) {
    		$this->flash->error("El acta $id_actath no existe");
    		return $this->response->redirect("cob_verificacion/");
    	}
    	$this->guardarActaCerrada($acta, $this->user['nivel']);
    	$eliminar_adicionales = $this->request->getPost("eliminar_adicionales");
    	if($eliminar_adicionales){
	    	$sql = $this->conversiones->multipledelete("cob_actath_persona", "id_actath_persona", $eliminar_adicionales);
	    	$query = $db->query($sql);
    	}
    	if($this->request->getPost("num_documento")){
				$fechaIngreso = $this->conversiones->array_fechas(1, $this->request->getPost("fechaIngreso"));
				$fechaRetiro = $this->conversiones->array_fechas(1, $this->request->getPost("fechaRetiro"));
				$porcentajeDedicacion = $this->conversiones->array_porcentaje($this->request->getPost("porcentajeDedicacion"));
    		$elementos = array(
    				'numDocumento' => $this->request->getPost("num_documento"),
    				'primerNombre' => $this->request->getPost("primerNombre"),
    				'segundoNombre' => $this->request->getPost("segundoNombre"),
    				'primerApellido' => $this->request->getPost("primerApellido"),
    				'segundoApellido' => $this->request->getPost("segundoApellido"),
    				'formacionAcademica' => $this->request->getPost("formacionAcademica"),
						'cargo' => $this->request->getPost("cargo"),
						'tipoContrato' => $this->request->getPost("tipoContrato"),
						'baseSalario' => $this->request->getPost("baseSalario"),
						'porcentajeDedicacion' => $porcentajeDedicacion,
						'fechaIngreso' => $fechaIngreso,
						'fechaRetiro' => $fechaRetiro,
    				'asistencia' => $this->request->getPost("asistencia"),
						'observacion' => $this->request->getPost("observacion"),
    				'tipoPersona' => '1',
    				'id_actath' => $id_actath,
    				'id_verificacion' => $acta->id_verificacion,
						'id_mes' => $acta->id_mes,
						'id_sede' => $acta->id_sede,
    				'id_contrato' => $acta->id_contrato
    		);
    		$sql = $this->conversiones->multipleinsert("cob_actath_persona", $elementos);
    		$query = $db->query($sql);
    		if (!$query) {
    			foreach ($query->getMessages() as $message) {
    				$this->flash->error($message);
    			}
    			return $this->response->redirect("cob_actath/adicionales/$id_actath");
    		}
    	}
    	$this->flash->success("Los adicionales fueron actualizados exitosamente");
    	return $this->response->redirect("cob_actath/adicionales/$id_actath");
    }

		/**
     * adicionales_listado
     *
     * @param int $id_actath
     */
    public function adicionales_listadoAction($id_actath) {
    	if (!$this->request->isPost()) {
    		$acta = CobActath::findFirstByid_actath($id_actath);
    		if (!$acta) {
    			$this->flash->error("El acta no fue encontrada");
    			return $this->response->redirect("cob_verificacion/");
    		}
    		$this->assets
    		->addJs('js/parsley.min.js')
    		->addJs('js/parsley.extend.js')
    		->addJs('js/talentohumano-adicionaleslistado.js');
    		$this->view->nombre = array();
				$this->view->adicionales_listado = CobActathPersonaListado::find("id_actath = $id_actath");
    		$this->view->talentohumano = CobActathPersona::find("id_contrato = $acta->id_contrato AND id_mes = $acta->id_mes AND id_sede != $acta->id_sede AND tipoPersona = 0");
    		$acta->id_acta = $id_actath;
    		$this->view->acta = $acta;
				$this->view->asistencia = $this->elements->getSelect("asistencia");
    		$this->view->sinonare = $this->elements->getSelect("sinonare");
    		$this->actaCerrada($acta, $this->user['nivel']);
    	}
    }

		/**
     * Guardar Talento Humano
     *
     */
    public function guardaradicionales_listadoAction($id_actath)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actath/");
    	}
    	$db = $this->getDI()->getDb();
    	$acta = CobActath::findFirstByid_actath($id_actath);
    	if (!$acta) {
    		$this->flash->error("El acta $id_actath no existe");
    		return $this->response->redirect("cob_actath/");
    	}
    	$this->guardarActaCerrada($acta, $this->user['nivel']);
			$fechaRetiro = $this->conversiones->array_fechas(1, $this->request->getPost("fechaRetiro"));
    	$elementos = array(
    			'id_actath_persona' => $this->request->getPost("id_actath_persona"),
					'numDocumento' => $this->request->getPost("numDocumento"),
    			'cedulaCoincide' => $this->request->getPost("cedulaCoincide"),
    			'nombreCoincide' => $this->request->getPost("nombreCoincide"),
    			'formacionacademicaCoincide' => $this->request->getPost("formacionacademicaCoincide"),
    			'cargoCoincide' => $this->request->getPost("cargoCoincide"),
    			'tipocontratoCoincide' => $this->request->getPost("tipocontratoCoincide"),
    			'salarioCoincide' => $this->request->getPost("salarioCoincide"),
					'dedicacionCoincide' => $this->request->getPost("dedicacionCoincide"),
					'fechaingresoCoincide' => $this->request->getPost("fechaingresoCoincide"),
					'fechaRetiro' => $fechaRetiro,
					'asistencia' => $this->request->getPost("asistencia"),
					'observacion' => $this->request->getPost("observacion"),
					'tipoPersona' => 2,
					'id_actath' => $id_actath,
					'id_verificacion' => $acta->id_verificacion,
					'id_mes' => $acta->id_mes,
					'id_sede' => $acta->id_sede,
					'id_contrato' => $acta->id_contrato
    	);
    	$sql = $this->conversiones->multipleinsert("cob_actath_persona_listado", $elementos);
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_actath/adicionales_listado/$id_actath");
    	}
    	$acta->estado = 1;
    	$acta->save();
    	$this->flash->success("Los Adicionales de Listado fueron actualizados exitosamente");
    	return $this->response->redirect("cob_actath/adicionales_listado/$id_actath");
    }

    /**
     * Cierra un acta
     *
     * @param int $id_actath
     */
    public function cerrarAction($id_actath)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actath/ver/$id_actath");
    	}
        $acta = CobActath::findFirstByid_actath($id_actath);
        if (!$acta) {
            $this->flash->error("El acta no fue encontrada");
            return $this->response->redirect("cob_actath/");
        }
        $uri = $this->request->getPost("uri");
        $error = 0;
        if(!($acta->CobActathDatos->fecha)){
        	$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta no puede ser cerrada debido a que:");
        	$this->flash->error("No han sido digitados los datos del acta.");
        	$error = 1;
        }
        if($acta->CobActathPersona[0]->cedulaCoincide == 0){
        	if($error == 0)
        		$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta no puede ser cerrada debido a que:");
        	$this->flash->error("No han sido digitados el talento humano del acta.");
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
     * @param int $id_actath
     */
    public function abrirAction($id_actath)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actath/ver/$id_actath");
    	}
    	$acta = CobActath::findFirstByid_actath($id_actath);
    	if (!$acta) {
    		$this->flash->error("El acta no fue encontrada");
    		return $this->response->redirect("cob_actath/");
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
    		return $this->response->redirect("cob_actath/datos/$acta->id_actath");
    	} else if($acta->estado > 2){
    		$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>Cerrada por Auxiliar</b>, si realizar un cambio contacte con su coordinador.");
    		return $this->response->redirect("cob_actath/datos/$acta->id_actath");
    	} else if($acta->estado > 1){
    		if($nivel == 3){
    			$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>Cerrada por Interventor</b>, si realizar un cambio contacte con su coordinador.");
    			return $this->response->redirect("cob_actath/datos/$acta->id_actath");
    		}
    		return FALSE;
    	} else {
    		return FALSE;
    	}
    }

}
