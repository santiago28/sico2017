<?php
 
use Phalcon\Mvc\Model\Criteria;

class CobActadocumentacionController extends ControllerBase
{    
	public $user;
	
    public function initialize()
    {
        $this->tag->setTitle("Acta de Conteo");
        $this->user = $this->session->get('auth');
        parent::initialize();
    }
    
    /**
     * Ver
     *
     * @param int $id_periodo
     */
    public function verAction($id_actadocumentacion)
    {
    	$this->assets
    	->addCss('css/acta-impresion.css');
    	$acta = CobActadocumentacion::generarActa($id_actadocumentacion);
    	if (!$acta) {
    		$this->flash->error("El acta no fue encontrada");
    		return $this->response->redirect("cob_verificacion/");
    	}
    	$acta['datos']->id_acta = $id_actadocumentacion;
    	$this->view->nivel = $this->user['nivel'];
    	$this->view->acta_html = $acta['html'];
    	$this->view->acta_datos = $acta['datos'];
    	$this->view->acta = $acta['datos'];
    }

    /**
     * Datos
     *
     * @param int $id_actaconteo
     */
    public function datosAction($id_actadocumentacion)
    {
        if (!$this->request->isPost()) {

            $acta = CobActadocumentacion::findFirstByid_actadocumentacion($id_actadocumentacion);
            if (!$acta) {
                $this->flash->error("El acta no fue encontrada");

                return $this->response->redirect("cob_verificacion/");
            }
            $this->assets
            ->addJs('js/parsley.min.js')
            ->addJs('js/parsley.extend.js');
            $acta->id_acta = $id_actadocumentacion;
            if($acta->CobActadocumentacionDatos){
            	$this->tag->setDefault("fecha", $this->conversiones->fecha(2, $acta->CobActadocumentacionDatos->fecha));
            	$this->tag->setDefault("horaInicio", $acta->CobActadocumentacionDatos->horaInicio);
            	$this->tag->setDefault("horaFin", $acta->CobActadocumentacionDatos->horaFin);
            	$this->tag->setDefault("nombreEncargado", $acta->CobActadocumentacionDatos->nombreEncargado);
            	$this->tag->setDefault("observacionEncargado", $acta->CobActadocumentacionDatos->observacionEncargado);
            	$this->tag->setDefault("observacionUsuario", $acta->CobActadocumentacionDatos->observacionUsuario);
            }
            $this->view->acta = $acta;
            $this->actaCerrada($acta, $this->user['nivel']);
        }
    }
    
    /**
     * Guardar Datos
     *  
     */
    public function guardardatosAction($id_actadocumentacion)
    {
    	if (!$this->request->isPost()) {
            return $this->response->redirect("cob_verificacion/");
        }
        $acta = CobActadocumentacion::findFirstByid_actadocumentacion($id_actadocumentacion);
        if (!$acta) {
            $this->flash->error("El acta $id_actadocumentacion no existe ");
            return $this->response->redirect("cob_verificacion/");
        }
        $this->guardarActaCerrada($acta, $this->user['nivel']);
        $dato = new CobActadocumentacionDatos();
        $dato->id_actadocumentacion = $id_actadocumentacion;
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
            return $this->response->redirect("cob_actadocumentacion/datos/$id_actadocumentacion");
        }
        $this->flash->success("Los Datos Generales fueron actualizados exitosamente");
        return $this->response->redirect("cob_actadocumentacion/datos/$id_actadocumentacion");
    }
    
    /**
     * Guardar Beneficiarios
     *
     */
    public function guardarbeneficiariosAction($id_actadocumentacion)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_verificacion/");
    	}
    	$db = $this->getDI()->getDb();
    	$acta = CobActadocumentacion::findFirstByid_actadocumentacion($id_actadocumentacion);
    	if (!$acta) {
    		$this->flash->error("El acta $id_actadocumentacion no existe");
    		return $this->response->redirect("cob_verificacion/");
    	}
    	$this->guardarActaCerrada($acta, $this->user['nivel']);
    	$persona = new CobActadocumentacionPersona();
    	$i = 0;
    	$elementos = array(
    			'id_actadocumentacion_persona' => $this->request->getPost("id_actadocumentacion_persona"),
    			'nombreCedulaSibc' => $this->request->getPost("nombreCedulaSibc"),
    			'telefonoSibc' => $this->request->getPost("telefonoSibc"),
    			'certificadoSgs' => $this->request->getPost("certificadoSgs"),
    			'certificadoSisben' => $this->request->getPost("certificadoSisben"),
    			'matriculaFirmada' => $this->request->getPost("matriculaFirmada"),
    			'fechaMatricula' => $this->request->getPost("fechaMatricula")
    	);
    	$sql = $this->conversiones->multipleupdate("cob_actadocumentacion_persona", $elementos, "id_actadocumentacion_persona");
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_actadocumentacion/beneficiarios/$id_actadocumentacion");
    	}
    	$acta->estado = 1;
    	$acta->save();
    	$this->flash->success("Los beneficiarios fueron actualizados exitosamente");
    	return $this->response->redirect("cob_actadocumentacion/beneficiarios/$id_actadocumentacion");
    }
    
    /**
     * Beneficiarios
     *
     * @param int $id_actaconteo
     */
    public function beneficiariosAction($id_actadocumentacion) {
    	if (!$this->request->isPost()) {
    		$acta = CobActadocumentacion::findFirstByid_actadocumentacion($id_actadocumentacion);
    		if (!$acta) {
    			$this->flash->error("El acta no fue encontrada");
    			return $this->response->redirect("cob_periodo/");
    		}
    		$this->assets
    		->addJs('js/parsley.min.js')
    		->addJs('js/parsley.extend.js')
    		->addJs('js/beneficiarios-verificacion.js')
    		->addJs('js/beneficiarios.js');
    		$this->view->nombre = array();
    		$this->view->acta = $acta;
    		$this->view->beneficiarios = $acta->getCobActadocumentacionPersona(['order' => 'grupo, primerNombre asc']);
    		$acta->id_acta = $id_actadocumentacion;
    		$this->view->acta = $acta;
    		$this->view->sinonare = $this->elements->getSelect("sinonare");
    		$this->actaCerrada($acta, $this->user['nivel']);
    	}
    }
    
    /**
     * Cierra un acta
     *
     * @param int $id_actaconteo
     */
    public function cerrarAction($id_actadocumentacion)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actadocumentacion/ver/$id_actadocumentacion");
    	}
        $acta = CobActadocumentacion::findFirstByid_actadocumentacion($id_actadocumentacion);
        if (!$acta) {
            $this->flash->error("El acta no fue encontrada");
            return $this->response->redirect("cob_verificacion/");
        }
        $uri = $this->request->getPost("uri");
        $error = 0;
        if(!($acta->CobActadocumentacionDatos->fecha)){
        	$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta no puede ser cerrada debido a que:");
        	$this->flash->error("No han sido digitados los datos del acta.");
        	$error = 1;
        }
        if($acta->CobActadocumentacionPersona[0]->nombreCedulaSibc == 0){
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
     * @param int $id_actaconteo
     */
    public function abrirAction($id_actadocumentacion)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actadocumentacion/ver/$id_actadocumentacion");
    	}
    	$acta = CobActadocumentacion::findFirstByid_actadocumentacion($id_actadocumentacion);
    	if (!$acta) {
    		$this->flash->error("El acta no fue encontrada");
    		return $this->response->redirect("cob_verificacion/");
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
    		return $this->response->redirect("cob_actaconteo/datos/$acta->id_actaconteo");
    	} else if($acta->estado > 2){
    		$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>Cerrada por Auxiliar</b>, si realizar un cambio contacte con su coordinador.");
    		return $this->response->redirect("cob_actaconteo/datos/$acta->id_actaconteo");
    	} else if($acta->estado > 1){
    		if($nivel == 3){
    			$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>Cerrada por Interventor</b>, si realizar un cambio contacte con su coordinador.");
    			return $this->response->redirect("cob_actaconteo/datos/$acta->id_actaconteo");
    		}
    		return FALSE;
    	} else {
    		return FALSE;
    	}
    }
    
}