<?php
 
use Phalcon\Mvc\Model\Criteria;

class CobActacomputoController extends ControllerBase
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
    public function verAction($id_actacomputo)
    {
    	$this->assets
    	->addCss('css/acta-impresion.css');
    	$acta = CobActacomputo::generarActa($id_actacomputo);
    	if (!$acta) {
    		$this->flash->error("El acta no fue encontrada");
    		return $this->response->redirect("cob_verificacion/");
    	}
    	$acta['datos']->id_acta = $id_actacomputo;
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
    public function datosAction($id_actacomputo)
    {
        if (!$this->request->isPost()) {

            $acta = CobActacomputo::findFirstByid_actacomputo($id_actacomputo);
            if (!$acta) {
                $this->flash->error("El acta no fue encontrada");

                return $this->response->redirect("cob_verificacion/");
            }$this->assets
            ->addJs('js/parsley.min.js')
            ->addJs('js/parsley.extend.js');
            $acta->id_acta = $id_actacomputo;
            if($acta->CobActacomputoDatos){
            	$this->tag->setDefault("fecha", $this->conversiones->fecha(2, $acta->CobActacomputoDatos->fecha));
            	$this->tag->setDefault("horaInicio", $acta->CobActacomputoDatos->horaInicio);
            	$this->tag->setDefault("horaFin", $acta->CobActacomputoDatos->horaFin);
            	$this->tag->setDefault("nombreEncargado", $acta->CobActacomputoDatos->nombreEncargado);
            	$this->tag->setDefault("observacionEncargado", $acta->CobActacomputoDatos->observacionEncargado);
            	$this->tag->setDefault("observacionUsuario", $acta->CobActacomputoDatos->observacionUsuario);
            	$this->tag->setDefault("cantidadEquipos", $acta->CobActacomputoDatos->cantidadEquipos);
            	$this->tag->setDefault("servicioInternet", $acta->CobActacomputoDatos->servicioInternet);
            }
            $this->view->sino = $this->elements->getSelect("sino");
            $this->view->acta = $acta;
            $this->actaCerrada($acta, $this->user['nivel']);
        }
    }
    
    /**
     * Guardar Datos
     *  
     */
    public function guardardatosAction($id_actacomputo)
    {
    	if (!$this->request->isPost()) {
            return $this->response->redirect("cob_verificacion/");
        }
        $acta = CobActacomputo::findFirstByid_actacomputo($id_actacomputo);
        if (!$acta) {
            $this->flash->error("El acta $id_actacomputo no existe ");
            return $this->response->redirect("cob_verificacion/");
        }
        $this->guardarActaCerrada($acta, $this->user['nivel']);
        $dato = new CobActacomputoDatos();
        $dato->id_actacomputo = $id_actacomputo;
        $dato->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
        $dato->horaInicio = $this->request->getPost("horaInicio");
        $dato->horaFin = $this->request->getPost("horaFin");
        $dato->nombreEncargado = $this->request->getPost("nombreEncargado");
        $dato->observacionEncargado = $this->request->getPost("observacionEncargado");
        $dato->observacionUsuario = $this->request->getPost("observacionUsuario");
        $dato->cantidadEquipos = $this->request->getPost("cantidadEquipos");
        $dato->servicioInternet = $this->request->getPost("servicioInternet");
        if (!$dato->save()) {
            foreach ($dato->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect("cob_actacomputo/datos/$id_actacomputo");
        }
        $this->flash->success("Los Datos Generales fueron actualizados exitosamente");
        return $this->response->redirect("cob_actacomputo/datos/$id_actacomputo");
    }

    /**
     * Cierra un acta
     *
     * @param int $id_actaconteo
     */
    public function cerrarAction($id_actacomputo)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actacomputo/ver/$id_actacomputo");
    	}
        $acta = CobActacomputo::findFirstByid_actacomputo($id_actacomputo);
        if (!$acta) {
            $this->flash->error("El acta no fue encontrada");
            return $this->response->redirect("cob_verificacion/");
        }
        $uri = $this->request->getPost("uri");
        $error = 0;
        if(!($acta->CobActacomputoDatos->fecha)){
        	$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta no puede ser cerrada debido a que:");
        	$this->flash->error("No han sido digitados los datos del acta.");
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
    public function abrirAction($id_actacomputo)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_actacomputo/ver/$id_actacomputo");
    	}
    	$acta = CobActacomputo::findFirstByid_actacomputo($id_actacomputo);
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