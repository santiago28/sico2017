<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class BcHcbController extends ControllerBase
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
        $BcHcbperiodo = BcHcbperiodo::find(['order' => 'id_hcbperiodo asc']);
        if (count($BcHcbperiodo) == 0) {
						$this->flash->notice("No se ha agregado ningún periodo hasta el momento");
            $BcHcbperiodo = null;
        }
        $this->view->periodos = $BcHcbperiodo;
				$this->view->id_componente = $this->user['id_componente'];
    	}

    /**
     * Formulario para creación de empleado
     */
    public function nuevoempleadoAction()
    {
			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
			if(!$oferente){
				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
				return $this->response->redirect("/");
			}
			$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
			if(!$id_oferente){
				$this->flash->error("Solamente los prestadores pueden agregar empleados.");
				return $this->response->redirect("bc_hcb/");
			}
			$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/picnet.table.filter.min.js')
			->addJs('js/nuevoempleadohcb.js');
			$this->view->cargo = $this->elements->getSelect("cargoitinerante");
    }

		/**
     * Formulario para creación de empleado
     */
    public function empleadosAction()
    {
			// Si es oferente
			if($this->user['id_componente'] == 3){
				$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
				if(!$oferente){
					$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
					return $this->response->redirect("/");
				}
				$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
				$empleados = BcHcbempleado::find(array("id_oferente = $id_oferente"));
				$this->view->pick('bc_hcb/empleados_bc');
			} else {
				$empleados = BcHcbempleado::find();
				$this->view->pick('bc_hcb/empleados_ibc');
			}
			$this->view->empleados = $empleados;
			$this->assets
    	->addJs('js/picnet.table.filter.min.js')
			->addJs('js/hcb_filtro.js')
			->addJs('js/nuevoempleadohcb.js');
    }

		/**
     * Acción de guardar nuevo empleado
     */
    public function guardarempleadoAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_hcb/nuevoempleado");
    	}
			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
			if(!$oferente){
				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
				return $this->response->redirect("/");
			}
			$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
    	$empleado = new BcHcbempleado();
    	$empleado->numDocumento = $this->request->getPost("numDocumento");
    	$empleado->primerNombre = $this->request->getPost("primerNombre");
			$empleado->segundoNombre = $this->request->getPost("segundoNombre");
			$empleado->primerApellido = $this->request->getPost("primerApellido");
			$empleado->segundoApellido = $this->request->getPost("segundoApellido");
			$empleado->id_cargo = $this->request->getPost("cargo");
			$empleado->id_oferente = $id_oferente;
    	if (!$empleado->save()) {
    		foreach ($empleado->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("bc_hcb/nuevoempleado");
    	}
    	$this->flash->success("El empleado fue creado exitosamente.");
    	return $this->response->redirect("bc_hcb/nuevoempleado");
    }

		/**
     * Formulario para creación de empleado
     */
    public function editarempleadoAction($id_hcbempleado)
    {
			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
			if(!$oferente){
				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
				return $this->response->redirect("/");
			}
			$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
			$empleado = BcHcbempleado::findFirstByid_hcbempleado($id_hcbempleado);
			if (!$empleado) {
					$this->flash->error("El empleado no fue encontrado");

					return $this->response->redirect("bc_hcb/empleados");
			}
			$this->view->empleado = $empleado;
			$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/picnet.table.filter.min.js')
			->addJs('js/nuevoempleadohcb.js');
			$this->view->cargo = $this->elements->getSelect("cargoitinerante");
    }

		/**
     * Acción de guardar nuevo empleado
     */
    public function guardareditarempleadoAction($id_hcbempleado)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_hcb/editarempleado/$id_hcbempleado");
    	}
			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
			if(!$oferente){
				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
				return $this->response->redirect("/");
			}
    	$empleado = BcHcbempleado::findFirstByid_hcbempleado($id_hcbempleado);
			$empleado->numDocumento = $this->request->getPost("numDocumento");
    	$empleado->primerNombre = $this->request->getPost("primerNombre");
			$empleado->segundoNombre = $this->request->getPost("segundoNombre");
			$empleado->primerApellido = $this->request->getPost("primerApellido");
			$empleado->segundoApellido = $this->request->getPost("segundoApellido");
			$empleado->id_cargo = $this->request->getPost("cargo");

    	if (!$empleado->save()) {
    		foreach ($empleado->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("bc_hcb/editarempleado/$id_hcbempleado");
    	}
    	$this->flash->success("El empleado fue actualizado exitosamente.");
    	return $this->response->redirect("bc_hcb/editarempleado/$id_hcbempleado");
    }

    /**
     * Recorrido
     *
     * @param int $id_hcbperiodo
     */
    public function verAction($id_hcbperiodo)
    {
    	$BcHcbperiodo = BcHcbperiodo::findFirstByid_hcbperiodo($id_hcbperiodo);
    	if (!$BcHcbperiodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("bc_hcb/");
    	}
			// Si es oferente
			if($this->user['id_componente'] == 3){
				$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
				if(!$oferente){
					$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
					return $this->response->redirect("/");
				}
				$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
				$sedes = BcSedeContrato::find(array("id_modalidad = 12 AND id_oferente = $id_oferente AND estado = 1"));
			} else {
				$sedes = BcSedeContrato::find(array("id_modalidad = 12 AND estado = 1"));
			}
    	$this->assets
			->addJs('js/picnet.table.filter.min.js')
			->addJs('js/hcb_filtro.js');
			if ($sedes == null){
				$this->flash->error("No tiene permisos para ver los hogares comunitarios");
			}
			$this->view->id_componente = $this->user['id_componente'];
			$this->view->sedes = $sedes;
			$this->view->periodo = $BcHcbperiodo;
			$this->view->sedes = $sedes;
			$this->view->mes = $this->conversiones->fecha(11, $id_hcbperiodo);
    	$this->view->id_usuario = $this->id_usuario;
    	$this->view->nivel = $this->user['nivel'];
    }

		/**
     * Reporte de Novedades (Cancelaciones y nuevos)
     *
     * @param int $id_hcbperiodo
     */
    public function novedadesAction($id_hcbperiodo)
    {
			if(!$id_hcbperiodo){
				$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("bc_hcb/");
			}
    	$BcHcbperiodo = BcHcbperiodo::findFirstByid_hcbperiodo($id_hcbperiodo);
    	if (!$BcHcbperiodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("bc_hcb/");
    	}
    	$this->assets
			->addJs('js/picnet.table.filter.min.js')
			->addJs('js/hcb_filtro.js');
			$meses = $this->elements->getSelect("meses2");
			$this->view->mes = $this->conversiones->fecha(11, $id_hcbperiodo);
			$novedades = BcHcbperiodoEmpleadoFecha::find(array("id_hcbperiodo = $id_hcbperiodo AND estado > 0"));
			$this->view->novedades = $novedades;
    }

		/**
     * Nuevo Periodo
     *
     * @param int $id_hcbperiodo
     */
    public function nuevo_periodoAction()
    {
    	$this->assets
			->addJs('js/parsley.min.js')
			->addJs('js/parsley.extend.js');
			$meses = $this->elements->getSelect("meses2");
			$periodos = BcHcbperiodo::find();
			if(count($periodos) > 0){
				foreach($periodos as $periodo){
					unset($meses[$periodo->id_hcbperiodo]);
				}
			}
			$this->view->meses = $meses;
    }

		/**
     * Acción de guardar nuevo periodo
     */
    public function crear_periodoAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_hcb/nuevo_periodo");
    	}
			$periodo = new BcHcbperiodo();
			$periodo->id_hcbperiodo = $this->request->getPost("mes");
			if (!$periodo->save()) {
    		foreach ($periodo->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("bc_hcb/nuevo_periodo");
    	}
    	$this->flash->success("El periodo fue creado exitosamente.");
    	return $this->response->redirect("bc_hcb");
    }

		/**
     * Recorrido
     *
     * @param int $id_hcbperiodo
     */
    public function cronogramaAction($id_hcbperiodo, $id_sede_contrato)
    {

			if(!$id_hcbperiodo){
				$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("bc_hcb/");
			}
    	$BcHcbperiodo = BcHcbperiodo::findFirstByid_hcbperiodo($id_hcbperiodo);
    	if (!$BcHcbperiodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("bc_hcb/");
    	}

			if(!$id_sede_contrato){
				$this->flash->error("El hogar comunitario no fue encontrado");
    		return $this->response->redirect("bc_hcb/");
			}

			$sede = BcSedeContrato::findFirstByid_sede_contrato($id_sede_contrato);
    	if (!$sede) {
    		$this->flash->error("El hogar comunitario no fue encontrado");
    		return $this->response->redirect("bc_hcb/ver/$id_hcbperiodo");
    	}
			$id_componente = $this->user['id_componente'];
			$empleados_periodo = BcHcbperiodoEmpleado::find(array("id_sede_contrato = $id_sede_contrato AND id_hcbperiodo = $id_hcbperiodo"));
			// Si es oferente
			if($this->user['id_componente'] == 3){
				$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
				if(!$oferente){
					$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
					return $this->response->redirect("/");
				}
				$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
				$empleados_agregados = array();
				foreach($empleados_periodo as $row){
					$empleados_agregados[] = $row->id_hcbempleado;
				}
				$empleados = BcHcbempleado::find(array("id_oferente = $id_oferente"));
				if(!$empleados){
					$this->flash->error("Antes de crear el cronograma debe de agregar empleados.");
					return $this->response->redirect("bc_hcb/nuevoempleado");
				}
				if(strtotime(date('Y').'-'.$id_hcbperiodo.'-01') < strtotime(date('Y-m-d'))){
					 $this->view->activar_formulario = 0;
					 $this->assets
 					->addJs('js/parsley.min.js')
 					->addJs('js/parsley.extend.js')
 					->addCss('css/tooltipster.css')
 					->addJs('js/jquery.tooltipster.min.js')
 					->addJs('js/picnet.table.filter.min.js')
 					->addJs('js/cronogramahcb_c.js');

				} else {
					$this->view->activar_formulario = 1;
					$this->assets
					->addJs('js/parsley.min.js')
					->addJs('js/parsley.extend.js')
					->addJs('js/jquery.autoNumeric.js')
					->addJs('js/jquery.timepicker.min.js')
					->addJs('js/bootstrap-datepicker.min.js')
					->addJs('js/bootstrap-datepicker.es.min.js')
					->addJs('js/jquery.datepair.min.js')
					->addCss('css/jquery.timepicker.css')
					->addCss('css/bootstrap-datepicker.min.css')
					->addCss('css/tooltipster.css')
					->addJs('js/jquery.tooltipster.min.js')
					->addJs('js/picnet.table.filter.min.js')
					->addJs('js/cronogramahcb.js');
				}
				$this->view->empleados_id = $empleados_agregados;
				$this->view->empleados = $empleados;
				$fecha_inicio = date('d/m/Y', strtotime(date('Y').'-'.$id_hcbperiodo.'-01'));
				$next_month = $id_hcbperiodo + 1;
				$fecha_fin = date('d/m/Y', strtotime(date('Y').'-'.$next_month.'-01, -1 day'));
				$this->view->fecha_inicio = $fecha_inicio;
				$this->view->fecha_fin = $fecha_fin;

				$this->view->pick('bc_hcb/cronograma_bc');
			} else {
				$this->assets
				->addCss('css/tooltipster.css')
				->addJs('js/jquery.tooltipster.min.js');
				$this->view->pick('bc_hcb/cronograma_ibc');
			}
			$this->view->id_componente = $id_componente;
			$this->view->cronograma = $this->cronograma($BcHcbperiodo, $sede, $empleados_periodo, $id_componente);
			$this->view->empleados_periodo = $empleados_periodo;
			$this->view->sede = $sede;
			$this->view->periodo = $BcHcbperiodo;
			$this->view->mes = $this->conversiones->fecha(11, $id_hcbperiodo);
    	$this->view->id_usuario = $this->id_usuario;
    	$this->view->nivel = $this->user['nivel'];

    }

		/**
     * Acción de guardar cronograma
     */
    public function guardarcronogramaAction($id_hcbperiodo, $id_sede_contrato)
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_hcb/editarempleado/$id_hcbempleado");
    	}
			if(!$id_hcbperiodo){
				$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("bc_hcb/");
			}
			if(strtotime(date('Y').'-'.$id_hcbperiodo.'-01') < strtotime(date('Y-m-d'))){
				$this->flash->error("El cronograma no puede ser guardado mediante formulario porque ya venció el plazo para agregarlo");
    		return $this->response->redirect("bc_hcb/cronograma/$id_hcbperiodo/$id_sede_contrato");
			}
    	$BcHcbperiodo = BcHcbperiodo::findFirstByid_hcbperiodo($id_hcbperiodo);
    	if (!$BcHcbperiodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("bc_hcb/");
    	}

			if(!$id_sede_contrato){
				$this->flash->error("El hogar comunitario no fue encontrado");
    		return $this->response->redirect("bc_hcb/");
			}
			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
			if(!$oferente){
				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
				return $this->response->redirect("/");
			}
			$db = $this->getDI()->getDb();
			$db->query("DELETE FROM bc_hcbperiodo_empleado WHERE id_sede_contrato = $id_sede_contrato AND id_hcbperiodo = $id_hcbperiodo");
			$db->query("DELETE FROM bc_hcbperiodo_empleado_fecha WHERE id_sede_contrato = $id_sede_contrato AND id_hcbperiodo = $id_hcbperiodo");
			$i = 0;
			$fechamaniana = $this->request->getPost("fechamaniana");
			$fechatarde = $this->request->getPost("fechatarde");
			$ids_hcbempleado = $this->request->getPost("id_hcbempleado");
			if(strtotime(date('Y').'-'.$id_hcbperiodo.'-01') < strtotime(date('Y-m-d'))){
				$estado = 2;
			} else {
				$estado = 0;
			}
			foreach($ids_hcbempleado as $id_hcbempleado){
				if($fechamaniana[$i] || $fechatarde[$i]) {
					$periodoempleado = new BcHcbperiodoEmpleado();
					$periodoempleado->id_hcbperiodo = $id_hcbperiodo;
		    	$periodoempleado->id_hcbempleado = $id_hcbempleado;
					$periodoempleado->id_sede_contrato = $id_sede_contrato;
					$periodoempleado->save();
					if($fechamaniana[$i]){
						$fecha1 = explode(",", $fechamaniana[$i]);
						$elementos = array(
								'fecha' => $this->conversiones->array_fechas(1, $fecha1),
								'jornada' => 1,
								'id_hcbperiodo_empleado' => $periodoempleado->id_hcbperiodo_empleado,
								'id_hcbperiodo' => $id_hcbperiodo,
								'id_sede_contrato' => $id_sede_contrato,
								'estado' => $estado,
								'fechahoraCreacion' => date('Y-m-d H:i:s')
						);
						$sql = $this->conversiones->multipleinsert("bc_hcbperiodo_empleado_fecha", $elementos);
						$query = $db->query($sql);
					}
					if($fechatarde[$i]){
						$fecha2 = explode(",", $fechatarde[$i]);
						$elementos = array(
								'fecha' => $this->conversiones->array_fechas(1, $fecha2),
								'jornada' => 2,
								'id_hcbperiodo_empleado' => $periodoempleado->id_hcbperiodo_empleado,
								'id_hcbperiodo' => $id_hcbperiodo,
								'id_sede_contrato' => $id_sede_contrato,
								'estado' => $estado,
								'fechahoraCreacion' => date('Y-m-d H:i:s')
						);
						$sql = $this->conversiones->multipleinsert("bc_hcbperiodo_empleado_fecha", $elementos);
						$query = $db->query($sql);
					}
				}
				$i++;
			}
    	$this->flash->success("El hogar comunitario fue actualizado exitosamente.");
    	return $this->response->redirect("bc_hcb/cronograma/$id_hcbperiodo/$id_sede_contrato");
    }

		/**
     * Cancela una visita
     *
     *
     */
    public function cancelar_fechaAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect('bc_hcb');
    	}
    	$id_hcbperiodo_empleado_fecha = $this->request->getPost("id_hcbperiodo_empleado_fecha");

			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
			if(!$oferente){
				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
				return $this->response->redirect('bc_permiso');
			}
			$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
			$empleadofecha = BcHcbperiodoEmpleadoFecha::findFirstByid_hcbperiodo_empleado_fecha($id_hcbperiodo_empleado_fecha);
			if(!$empleadofecha){
				$this->flash->error("No fue encontrado un empleado para esa fecha");
    		return $this->response->redirect("bc_hcb/");
			}
			if($empleadofecha->estado == 1){
				$this->flash->error("Esta visita ya fue cancelada, por lo tanto no puede ser cancelada nuevamente.");
				return $this->response->redirect("bc_hcb/cronograma/$empleadofecha->id_hcbperiodo/$empleadofecha->id_sede_contrato");
			}
			$empleadofecha->estado = 1;
			$empleadofecha->fechahoraCancelacion = date('Y-m-d H:i:s');
    	$empleadofecha->observacionCancelacion = $this->request->getPost("observacion");
    	if (!$empleadofecha->save()) {
    		foreach ($bc_permiso->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("bc_hcb/cronograma/$empleadofecha->id_hcbperiodo/$empleadofecha->id_sede_contrato");
    	}
    	$this->flash->success("La visita fue cancelada exitosamente.");
    	return $this->response->redirect("bc_hcb/cronograma/$empleadofecha->id_hcbperiodo/$empleadofecha->id_sede_contrato");
    }

		/**
     * Crea una visita
     *
     *
     */
    public function crear_fechaAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect('bc_hcb');
    	}
			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
			if(!$oferente){
				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
				return $this->response->redirect('bc_permiso');
			}

			$id_hcbperiodo = $this->request->getPost("id_hcbperiodo");
			$id_sede_contrato = $this->request->getPost("id_sede_contrato");
			$id_hcbempleado = $this->request->getPost("id_hcbempleado");
			$periodoempleado = BcHcbperiodoEmpleado::findFirst(array("id_sede_contrato = $id_sede_contrato AND id_hcbperiodo = $id_hcbperiodo AND id_hcbempleado = $id_hcbempleado"));
			if(!$periodoempleado){
				$periodoempleado = new BcHcbperiodoEmpleado();
				$periodoempleado->id_hcbperiodo = $id_hcbperiodo;
				$periodoempleado->id_hcbempleado = $id_hcbempleado;
				$periodoempleado->id_sede_contrato = $id_sede_contrato;
				$periodoempleado->save();
			}
			$jornada = $this->request->getPost("jornada");
			$fecha = $this->request->getPost("fecha");
			$empleadofecha = BcHcbperiodoEmpleadoFecha::findFirst(array("id_hcbperiodo_empleado = $periodoempleado->id_hcbperiodo_empleado AND jornada = $jornada AND fecha = '$fecha'"));
			if($empleadofecha){
				$this->flash->error("No se pudo crear la visita porque ya existe este empleado asignado a la misma fecha y jornada.");
	    	return $this->response->redirect("bc_hcb/cronograma/$id_hcbperiodo/$id_sede_contrato");
			}
			$empleadofecha = new BcHcbperiodoEmpleadoFecha();
			$empleadofecha->id_hcbperiodo_empleado = $periodoempleado->id_hcbperiodo_empleado;
			$empleadofecha->id_hcbperiodo = $id_hcbperiodo;
			$empleadofecha->id_sede_contrato = $id_sede_contrato;
			$empleadofecha->fecha = $this->request->getPost("fecha");
			$empleadofecha->jornada = $this->request->getPost("jornada");
			$empleadofecha->fechahoraCreacion = date('Y-m-d H:i:s');

			if(strtotime(date('Y').'-'.$id_hcbperiodo.'-01') < strtotime(date('Y-m-d'))){
				$empleadofecha->estado = 2;
			} else {
				$empleadofecha->estado = 0;
			}
    	if (!$empleadofecha->save()) {
    		foreach ($empleadofecha->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("bc_hcb/cronograma/$d_hcbperiodo/$id_sede_contrato");
    	}
    	$this->flash->success("La visita fue creada exitosamente.");
    	return $this->response->redirect("bc_hcb/cronograma/$id_hcbperiodo/$id_sede_contrato");
    }

		private function cronograma($BcHcbperiodo, $sede, $empleados_periodo, $id_componente){
			$html = "";
			$id_hcbperiodo = $BcHcbperiodo->id_hcbperiodo;
			$fecha = date('Y').'-'.$id_hcbperiodo.'-1';
			$dia_semana_inicial = date('N', strtotime($fecha));
			if($dia_semana_inicial < 6){
				if($dia_semana_inicial > 1){
					$i = 1;
					$html .= "<tr>";
					while($i < $dia_semana_inicial){
						$html .= "<td><br><br></td>";
						$i++;
					}
				}
				$fecha_actual = date('Y-m-d', strtotime($fecha));
				$dia_actual = date('d', strtotime($fecha));
			} else {
				$fecha_actual = date('Y-m-d', strtotime($fecha.' next Monday'));
				$dia_actual = date('d', strtotime($fecha.' next Monday'));
			}
			while(date('n', strtotime($fecha_actual)) == $id_hcbperiodo){
				if(date('N', strtotime($fecha_actual)) == 1){ // Si es Lunes
					$html .= "<tr><td><p style='text-align:center; font-weight: bold;'>";
					if($id_componente == 3){
						$html .="<a class='crear_fecha' data-fechaf_crear='".$fecha_actual."' data-fecha_crear='".$this->conversiones->fecha(4, $fecha_actual)."' href='#crear_fecha' data-toggle='modal'>".date('d', strtotime($fecha_actual)) ."</a>";
					} else {
						$html .= date('d', strtotime($fecha_actual));
					}
					$html .= "</p>". $this->empleados_dia($empleados_periodo, $fecha_actual, $id_componente)."</td>";
					$fecha_actual = date('Y-m-d', strtotime($fecha_actual.' + 1 days'));
				} else if(date('N', strtotime($fecha_actual)) == 5){ // Si es viernes
					$html .= "<td><p style='text-align:center; font-weight: bold;'>";
					if($id_componente == 3){
						$html .="<a class='crear_fecha' data-fechaf_crear='".$fecha_actual."' data-fecha_crear='".$this->conversiones->fecha(4, $fecha_actual)."' href='#crear_fecha' data-toggle='modal'>".date('d', strtotime($fecha_actual)) ."</a>";
					} else {
						$html .= date('d', strtotime($fecha_actual));
					}
					$html .= "</p>". $this->empleados_dia($empleados_periodo, $fecha_actual, $id_componente)."</td></tr>";
					$fecha_actual = date('Y-m-d', strtotime($fecha_actual.' next Monday'));
				} else { // Para martes, miércoles y jueves
					$html .= "<td><p style='text-align:center; font-weight: bold;'>";
					if($id_componente == 3){
						$html .="<a class='crear_fecha' data-fechaf_crear='".$fecha_actual."' data-fecha_crear='".$this->conversiones->fecha(4, $fecha_actual)."' href='#crear_fecha' data-toggle='modal'>".date('d', strtotime($fecha_actual)) ."</a>";
					} else {
						$html .= date('d', strtotime($fecha_actual));
					}
					$html .= "</p>". $this->empleados_dia($empleados_periodo, $fecha_actual, $id_componente)."</td>";
					$fecha_actual = date('Y-m-d', strtotime($fecha_actual.' + 1 days'));
				}
			}
			if (date('N', strtotime($fecha_actual)) !== 5){
				$html .="</tr>";
			}
			return $html;
		}
		private function empleados_dia($empleados_periodo, $fecha, $id_componente){
			$empleados_dia = "";
			$cancelado = "";
			foreach($empleados_periodo as $empleado_dia){
				if($empleado_dia->getBcHcbperiodoEmpleadoFecha()){
					foreach($empleado_dia->getBcHcbperiodoEmpleadoFecha() as $row){
						if($row->fecha == $fecha){
							if($row->estado == 1) {
								$cancelado = ". Cancelado: ".$this->conversiones->hora(2, $row->fechahoraCancelacion) . ". Observación Cancelación: " . $row->observacionCancelacion;
							}
							$empleados_dia .= "<span rel='tooltip' title='Nombre: ".$row->BcHcbperiodoEmpleado->BcHcbempleado->getNombrecompleto().". Creado: ".$this->conversiones->hora(2, $row->fechahoraCreacion). $cancelado . "' class='label label-".$row->labelEstado()."'>".$row->BcHcbperiodoEmpleado->BcHcbempleado->primerNombre." - ". $row->getJornada();
							if($id_componente == 3){
								$empleados_dia .= " <a style='color: white;' class='glyphicon glyphicon-remove cancelar_fecha' data-fecha_cancelar='".$this->conversiones->fecha(4, $fecha)."' data-nombre_cancelar='".$row->BcHcbperiodoEmpleado->BcHcbempleado->getNombrecompleto()."' data-id='".$row->id_hcbperiodo_empleado_fecha."' href='#cancelar_fecha' data-toggle='modal'></a>";
							}
							$empleados_dia .= "</span> ";
						}
					}
				}

			}
			if($empleados_dia == ""){
				$empleados_dia = "<br><br>";
			}
			return $empleados_dia;
		}
}
