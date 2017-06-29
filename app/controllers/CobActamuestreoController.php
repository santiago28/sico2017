<?php

use Phalcon\Mvc\Model\Criteria;

class CobActamuestreoController extends ControllerBase
{
	public $user;

    public function initialize()
    {
        $this->tag->setTitle("Acta de Muestreo");
        $this->user = $this->session->get('auth');
        parent::initialize();
    }

    /**
     * index action
     */
    public function indexAction()
    {
        return $this->dispatcher->forward(array(
    				"controller" => "cob_periodo",
    				"action" => "index"
    	));
    }

    /**
     * Ver
     *
     * @param int $id_periodo
     */
    public function verAction($id_actamuestreo)
    {
    	$this->assets
    	->addCss('css/acta-impresion-metrosalud.css');
    	$acta = CobActamuestreo::generarActa($id_actamuestreo);
    	if (!$acta) {
    		$this->flash->error("El acta no fue encontrada");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$this->view->recorridos = CobActamuestreo::maximum(array("column" => "recorrido"));
    	$this->view->nivel = $this->user['nivel'];
    	$this->view->acta_html = $acta['html'];
    	$this->view->acta_datos = $acta['datos'];
    	$this->view->acta = $acta['datos'];
    }

    /**
     * Datos
     *
     * @param int $id_actamuestreo
     */
    public function datosAction($id_actamuestreo)
    {
        if (!$this->request->isPost()) {
            $acta = CobActamuestreo::findFirstByid_actamuestreo($id_actamuestreo);
            if (!$acta) {
                $this->flash->error("El acta no fue encontrada");

                return $this->response->redirect("cob_periodo/");
            }
            $asiste1 = $acta->getCobActamuestreoPersona(['asistencia = 1']);
            $asiste4 = $acta->getCobActamuestreoPersona(['asistencia = 4']);
            $asiste6 = $acta->getCobActamuestreoPersona(['asistencia = 6']);
            $asiste7 = $acta->getCobActamuestreoPersona(['asistencia = 7']);
            $asiste8 = $acta->getCobActamuestreoPersona(['asistencia = 8']);
            $asistetotal = $acta->getCobActamuestreoPersona();
            $this->view->asiste1 = count($asiste1);
            $this->view->asiste4 = count($asiste4);
            $this->view->asiste6 = count($asiste6);
            $this->view->asiste7 = count($asiste7);
            $this->view->asiste8 = count($asiste8);
            $this->view->asistetotal = count($asistetotal);
            $this->assets
            ->addJs('js/parsley.min.js')
            ->addJs('js/parsley.extend.js');
            $this->view->id_actamuestreo = $id_actamuestreo;
            $this->view->valla_sede = $this->elements->getSelect("datos_valla");
            $this->view->sinona = $this->elements->getSelect("sinona");
            if($acta->CobActamuestreoDatos){
            	$this->tag->setDefault("fecha", $this->conversiones->fecha(2, $acta->CobActamuestreoDatos->fecha));
            	$this->tag->setDefault("horaInicio", $acta->CobActamuestreoDatos->horaInicio);
            	$this->tag->setDefault("horaFin", $acta->CobActamuestreoDatos->horaFin);
            	$this->tag->setDefault("nombreEncargado", $acta->CobActamuestreoDatos->nombreEncargado);
            	$this->tag->setDefault("pendonClasificacion", $acta->CobActamuestreoDatos->pendonClasificacion);
            	$this->tag->setDefault("correccionDireccion", $acta->CobActamuestreoDatos->correccionDireccion);
            	$this->tag->setDefault("instalacionesDomiciliarias", $acta->CobActamuestreoDatos->instalacionesDomiciliarias);
            	$this->tag->setDefault("condicionesSeguridad", $acta->CobActamuestreoDatos->condicionesSeguridad);
            	$this->tag->setDefault("observacionEncargado", $acta->CobActamuestreoDatos->observacionEncargado);
            	$this->tag->setDefault("observacionUsuario", $acta->CobActamuestreoDatos->observacionUsuario);
            }
            $this->view->acta = $acta;
            $this->actaCerrada($acta, $this->user['nivel']);
        }
    }

    /**
     * Guardar Datos
     *
     */
    public function guardardatosAction($id_actamuestreo)
    {
    	if (!$this->request->isPost()) {
            return $this->response->redirect("cob_periodo/");
        }
        $acta = CobActamuestreo::findFirstByid_actamuestreo($id_actamuestreo);
        if (!$acta) {
            $this->flash->error("El acta $id_actamuestreo no existe ");
            return $this->response->redirect("cob_periodo/");
        }
        $this->guardarActaCerrada($acta, $this->user['nivel']);
        $dato = new CobActamuestreoDatos();
        $dato->id_actamuestreo = $id_actamuestreo;
        $dato->id_usuario = $this->session->auth['id_usuario'];
        $dato->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
        $dato->horaInicio = $this->request->getPost("horaInicio");
        $dato->horaFin = $this->request->getPost("horaFin");
        $dato->nombreEncargado = $this->request->getPost("nombreEncargado");
        $dato->pendonClasificacion = $this->request->getPost("pendonClasificacion");
        $dato->correccionDireccion = $this->request->getPost("correccionDireccion");
        $dato->instalacionesDomiciliarias = $this->request->getPost("instalacionesDomiciliarias");
        $dato->condicionesSeguridad = $this->request->getPost("condicionesSeguridad");
        $dato->observacionEncargado = $this->request->getPost("observacionEncargado");
        $dato->observacionUsuario = $this->request->getPost("observacionUsuario");
        if (!$dato->save()) {
            foreach ($dato->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect("cob_actamuestreo/datos/$id_actamuestreo");
        }
        $this->flash->success("Los Datos Generales fueron actualizados exitosamente");
        return $this->response->redirect("cob_actamuestreo/datos/$id_actamuestreo");
    }

    /**
     * Guardar Beneficiarios
     *
     */
    public function guardarbeneficiariosAction($id_actamuestreo)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_periodo/");
    	}
    	$db = $this->getDI()->getDb();
    	$acta = CobActamuestreo::findFirstByid_actamuestreo($id_actamuestreo);
    	if (!$acta) {
    		$this->flash->error("El acta $id_actamuestreo no existe");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$this->guardarActaCerrada($acta, $this->user['nivel']);
    	$i = 0;
    	$elementos = array(
    			'id_actamuestreo_persona' => $this->request->getPost("id_actamuestreo_persona"),
    			'cicloVital' => $this->request->getPost("cicloVital"),
    			'complAlimientario' => $this->request->getPost("complAlimientario"),
    			'asistencia' => $this->request->getPost("asistencia")
    	);
    	$sql = $this->conversiones->multipleupdate("cob_actamuestreo_persona", $elementos, "id_actamuestreo_persona");
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_actamuestreo/datos/$id_actamuestreo");
    	}
    	$acta->estado = 1;
    	$acta->save();
    	$this->flash->success("Los beneficiarios fueron actualizados exitosamente");
    	return $this->response->redirect("cob_actamuestreo/beneficiarios/$id_actamuestreo");
    }

    /**
     * Beneficiarios
     *
     * @param int $id_actamuestreo
     */
    public function beneficiariosAction($id_actamuestreo) {
    	if (!$this->request->isPost()) {
    		$acta = CobActamuestreo::findFirstByid_actamuestreo($id_actamuestreo);
    		if (!$acta) {
    			$this->flash->error("El acta no fue encontrada");
    			return $this->response->redirect("cob_periodo/");
    		}
    		$this->assets
    		->addJs('js/parsley.min.js')
    		->addJs('js/parsley.extend.js')
    		->addJs('js/beneficiarios-metrosalud.js')
    		->addJs('js/beneficiarios.js');
    		$this->view->nombre = array();
    		$this->view->acta = $acta;
    		$this->view->beneficiarios = $acta->getCobActamuestreoPersona(['order' => 'grupo, primerNombre asc']);
    		$this->view->id_actamuestreo = $id_actamuestreo;
    		$this->view->asistencia = $this->elements->getSelect("asistencia");
    		$this->view->sinona = $this->elements->getSelect("sinona");
    		$this->view->ciclovital = $this->elements->getSelect("ciclovital");
    		$this->view->acta = $acta;
    		$this->actaCerrada($acta, $this->user['nivel']);
    	}
    }

    /**
     * Elimina un acta
     *
     * @param int $id_actamuestreo
     */
    public function eliminarAction($id_actamuestreo)
    {

        $acta = CobActamuestreo::findFirstByid_actamuestreo($id_actamuestreo);
        if (!$acta) {
            $this->flash->error("El acta no fue encontrada");
            return $this->response->redirect("cob_actamuestreo/");
        }
        if ($this->user['nivel'] > 1) {
            $this->flash->error("No puede eliminar el acta porque no cuenta con suficientes permisos para hacerlo");
            return $this->response->redirect("cob_actamuestreo/");
        }
        $recorrido = $acta->recorrido;
        $periodo = $acta->id_periodo;
        if (!$acta->delete()) {
            foreach ($acta->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect("cob_periodo/");
        }
        $db = $this->getDI()->getDb();
        $db->query("DELETE FROM cob_actamuestreo WHERE id_actamuestreo = $id_actamuestreo");
        $db->query("DELETE FROM cob_actamuestreo_datos WHERE id_actamuestreo = $id_actamuestreo");
        $db->query("DELETE FROM cob_actamuestreo_persona WHERE id_actamuestreo = $id_actamuestreo");
        $this->flash->success("El acta fue eliminada correctamente");
        return $this->response->redirect("cob_periodo/recorrido/$periodo/$recorrido");
    }

    /**
     * Cierra un acta
     *
     * @param int $id_actamuestreo
     */
    public function cerrarAction($id_actamuestreo)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actamuestreo/ver/$id_actamuestreo");
    	}
        $acta = CobActamuestreo::findFirstByid_actamuestreo($id_actamuestreo);
        if (!$acta) {
            $this->flash->error("El acta no fue encontrada");
            return $this->response->redirect("cob_actamuestreo/");
        }
        $uri = $this->request->getPost("uri");
        $error = 0;
        if(!($acta->CobActamuestreoDatos->fecha)){
        	$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta no puede ser cerrada debido a que:");
        	$this->flash->error("No han sido digitados los datos del acta.");
        	$error = 1;
        }
        if($acta->CobActamuestreoPersona[0]->asistencia == 0){
        	if($error == 0)
        		$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta no puede ser cerrada debido a que:");
        	$this->flash->error("No han sido digitados los beneficiarios del acta.");
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
     * @param int $id_actamuestreo
     */
    public function abrirAction($id_actamuestreo)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actamuestreo/ver/$id_actamuestreo");
    	}
    	$acta = CobActamuestreo::findFirstByid_actamuestreo($id_actamuestreo);
    	if (!$acta) {
    		$this->flash->error("El acta no fue encontrada");
    		return $this->response->redirect("cob_actamuestreo/");
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

    /**
     * Duplicar una acta
     */
    public function duplicaractaAction($id_actamuestreo){
    	if (!$id_actamuestreo) {
    		return $this->response->redirect("cob_actamuestreo/ver/$id_actamuestreo");
    	}
    	$acta = CobActamuestreo::findFirstByid_actamuestreo($id_actamuestreo);
    	if (!$acta) {
    		$this->flash->error("El acta no fue encontrada");
    		return $this->response->redirect("cob_actamuestreo/ver/$id_actamuestreo");
    	}
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($acta->id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no existe");
    		return $this->response->redirect("cob_actamuestreo/ver/$id_actamuestreo");
    	}
    	$duplicar = CobActamuestreo::duplicarActa($acta, $cob_periodo);
    	if($duplicar){
    		$this->flash->success("Se duplicó exitosamente el acta");
    	} else {
    		$this->flash->error("No se duplicó el acta");
    	}
    	return $this->response->redirect("cob_actamuestreo/ver/$id_actamuestreo");
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
    		return $this->response->redirect("cob_actamuestreo/datos/$acta->id_actamuestreo");
    	} else if($acta->estado > 2){
    		$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>Cerrada por Auxiliar</b>, si realizar un cambio contacte con su coordinador.");
    		return $this->response->redirect("cob_actamuestreo/datos/$acta->id_actamuestreo");
    	} else if($acta->estado > 1){
    		if($nivel == 3){
    			$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>Cerrada por Interventor</b>, si realizar un cambio contacte con su coordinador.");
    			return $this->response->redirect("cob_actamuestreo/datos/$acta->id_actamuestreo");
    		}
    		return FALSE;
    	} else {
    		return FALSE;
    	}
    }

}
