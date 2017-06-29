<?php

use Phalcon\Mvc\Model\Criteria;

class BcPermisoController extends ControllerBase
{
	public $user;
    public function initialize()
    {
        $this->tag->setTitle("Permisos");
        $this->user = $this->session->get('auth');
        $this->id_usuario = $this->user['id_usuario'];
        parent::initialize();
    }

    /**
     * index action
     */
    public function indexAction()
    {
			switch ($this->user['id_componente']) {
    		case 3:
					return $this->response->redirect("bc_permiso/mes");
    			break;
    		case 4:
					return $this->response->redirect("bc_permiso/mes");
    			break;
    		case 1:
    			if($this->user['nivel'] > 2){
						return $this->response->redirect("bc_permiso/mes");
    			} else {
						return $this->response->redirect("bc_permiso/revision");
    			}
    			break;
    		case 2:
    			return $this->response->redirect("bc_permiso/revision");
    			break;
    	}
    }

    /**
     * permiso action
     */
    public function permisoAction($id_permiso)
    {
    	if(!$id_permiso){
    		return $this->response->redirect("bc_permiso");
    	}
    	$id_permiso = intval($id_permiso);
    	$permiso = BcPermiso::find(array("id_permiso = $id_permiso"));
    	if(!isset($permiso[0])){
    		$this->flash->error("El permiso con ID <strong>$id_permiso</strong> no fue encontrado en la base de datos.");
    		return $this->response->redirect("bc_permiso");
    	}
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/permisos_lista.js')
			->addCss('css/tooltipster.css')
			->addJs('js/jquery.tooltipster.min.js')
			->addJs('js/permiso_general_individual.js');
			$agregar_participantes = 0;
    	$fecha_limite = strtotime(date('Y-m-d'). ' +1 days');
    	$texto_aprobar = array("aprobar_salida" => "", "aprobar_jornada" => "");;
			$id_sede_contrato = $permiso[0]->id_sede_contrato;
			$permisos = BcPermiso::find(array("id_permiso <> $id_permiso AND id_sede_contrato = $id_sede_contrato", "order" => "fecha ASC"));
			$listado_beneficiarios = BcPermisoParticipante::find(array("id_permiso = $id_permiso", "order" => "id_permiso_participante ASC"));
    	switch ($this->user['id_componente']) {
    		case 3:
    			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
    			if(!$oferente){
    				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
    				return $this->response->redirect("/");
    			}
    			$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
    			$permiso = BcPermiso::find(array("id_oferente = $id_oferente AND id_permiso = $id_permiso"));
	    		if(strtotime($permiso[0]->fecha) > $fecha_limite && $permiso[0]->estado < 3){
	    			$this->view->accion_permiso = "<a style='margin-left: 3px;' href='#eliminar_elemento' data-toggle = 'modal' class='btn btn-danger regresar eliminar_fila' data-id = '". $permiso[0]->id_permiso ."'><i class='glyphicon glyphicon-remove'></i> Anular Permiso</a>";
	    		}
					if($permiso[0]->fecha > date('Y-m-d')){
	 				 $agregar_participantes = 1;
				 	}
    			break;
    		case 1:
    			if($this->user['nivel'] > 2){
						$permisos = BcPermiso::find(array("id_permiso <> $id_permiso AND id_sede_contrato = $id_sede_contrato AND estado = 2", "order" => "fecha ASC"));
    				$this->view->accion_permiso = "";
    			}
    			if($permiso[0]->estado == 0){
    				$this->view->accion_permiso = "<a style='margin-left: 3px;' href='/sico/bc_permiso/aprobar/".$permiso[0]->id_permiso."' class='btn btn-success regresar'><i class='glyphicon glyphicon-ok'></i> Pre Aprobar Permiso</a><a style='margin-left: 3px;' href='#eliminar_elemento' data-toggle = 'modal' class='btn btn-danger regresar eliminar_fila' data-id = '". $permiso[0]->id_permiso ."' id='/sico/bc_permiso/eliminar/".$permiso[0]->id_permiso."'><i class='glyphicon glyphicon-remove'></i> Anular Permiso</a>";
    			} else if($permiso[0]->estado == 1){
    				$this->view->accion_permiso = "<a style='margin-left: 3px;' href='#eliminar_elemento' data-toggle = 'modal' class='btn btn-danger regresar eliminar_fila' data-id = '". $permiso[0]->id_permiso ."'><i class='glyphicon glyphicon-remove'></i> Anular Permiso</a>";
    			}
					if($permiso[0]->fecha > date('Y-m-d')){
	 				 $agregar_participantes = 1;
	 			 	}
    			break;
    		case 2:
    			if($permiso[0]->estado == 1){
    				$this->view->accion_permiso = "<a style='margin-left: 3px;' href='#aprobar_permiso' rel='tooltip' title='Aprobar' class='btn btn-success regresar eliminar_fila' data-id = '".$permiso[0]->id_permiso."' data-toggle = 'modal'><i class='glyphicon glyphicon-ok'></i> Aprobar Permiso</a><a style='margin-left: 3px;' href='#eliminar_elemento' data-toggle = 'modal' class='btn btn-danger regresar eliminar_fila' data-id = '". $permiso[0]->id_permiso ."'><i class='glyphicon glyphicon-remove'></i> Anular Permiso</a>";
    			} else if($permiso[0]->estado == 4){
						$this->view->accion_permiso = "<a style='margin-left: 3px;' href='#aprobar_permiso' rel='tooltip' title='Aprobar' class='btn btn-success regresar eliminar_fila' data-id = '".$permiso[0]->id_permiso."' data-toggle = 'modal'><i class='glyphicon glyphicon-ok'></i> Aprobar Permiso</a>";
					} else if($permiso[0]->estado == 2){
						$this->view->accion_permiso = "<a style='margin-left: 3px;' href='#eliminar_elemento' data-toggle = 'modal' class='btn btn-danger regresar eliminar_fila' data-id = '". $permiso[0]->id_permiso ."'><i class='glyphicon glyphicon-remove'></i> Anular Permiso</a>";
					}
    			$texto_aprobar = $this->elements->texto_aprobar();
					if($permiso[0]->fecha > date('Y-m-d')){
	 				 $agregar_participantes = 1;
	 			 	}
    			break;
    		case 4:
					$permisos = BcPermiso::find(array("id_permiso <> $id_permiso AND id_sede_contrato = $id_sede_contrato AND estado = 2", "order" => "fecha ASC"));
    			$this->view->accion_permiso = "";
    			break;
    	}
    	if (count($permiso) == 0) {
    		$this->flash->notice("El permiso con id <strong>$id_permiso</strong> no fue encontrado en la base de datos");
    		return $this->response->redirect("bc_permiso");
    	}
    	$this->assets
    	->addCss('css/observaciones.css');
			if(count($listado_beneficiarios) > 0){
				$this->view->listado_beneficiarios = $listado_beneficiarios;
			}
			if(count($permisos) > 0){
				$this->view->permisos = $permisos;
			}
    	$this->view->permiso = $permiso[0];
    	$this->view->pick("bc_permiso/permiso_" . $this->elements->getCategoriaEnlace($permiso[0]->categoria));
    	$this->view->texto_aprobar = $texto_aprobar;
			$this->view->agregar_participantes = $agregar_participantes;
    }

    /**
     * permiso action
     */
    public function revisionAction()
    {
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/picnet.table.filter.min.js')
    	->addJs('js/permisos_lista.js');
    	$texto_aprobar = array("aprobar_salida" => "", "aprobar_jornada" => "");
    	if($this->user['id_componente'] == 1){
    		$permisos = BcPermiso::find(array("estado = 0", "order" => "id_permiso ASC"));
    		$this->assets->addJs('js/permisos_revision_interventor.js');
    		$this->view->pick('bc_permiso/revision_interventor');
    	} else if($this->user['id_componente'] == 2) {
    		$permisos = BcPermiso::find(array("estado = 1", "order" => "id_permiso ASC"));
    		$texto_aprobar = $this->elements->texto_aprobar();
    		$this->assets->addJs('js/permisos_revision_bc.js');
    		$this->view->pick('bc_permiso/revision_bc');
    	}
    	if (count($permisos) == 0) {
    		$this->flash->notice("Felicitaciones: no se encontraron permisos para revisar.");
    		//return $this->response->redirect("bc_permiso");
    	}
    	$this->view->permisos = $permisos;
    	$this->view->texto_aprobar = $texto_aprobar;
    }

    /**
     * semana action
     */
    public function diaAction($fecha)
    {
			if(!$fecha){
				$fecha = date("Y-m-d");
			}
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/picnet.table.filter.min.js')
    	->addJs('js/permisos_lista.js');
    	$date = new DateTime($fecha);
    	$semana = $fecha;
    	$mes_actual = $date->format("m");
    	if(date("w", strtotime($fecha)) != 0){
    		$semana = date("Y-m-d", strtotime($fecha. ' next Sunday'));
    	}
    	$dia_anterior = date("Y-m-d", strtotime($fecha. ' - 1 day'));
    	$dia_siguiente = date("Y-m-d", strtotime($fecha. ' + 1 day'));
    	$permisos = BcPermiso::find(array("fecha = '$fecha'", "order" => "fecha ASC"));
			$texto_aprobar = array("aprobar_salida" => "", "aprobar_jornada" => "");;
    	switch ($this->user['id_componente']) {
    		case 3:
    			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
    			if(!$oferente){
    				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
    				return $this->response->redirect("/");
    			}
    			$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
    			$permisos = BcPermiso::find(array("id_oferente = $id_oferente AND fecha = '$fecha'", "order" => "fecha ASC"));
    			$this->view->pick('bc_permiso/index_prestador');
    			break;
    		case 4:
    			$permisos = BcPermiso::find(array("estado = 2 AND fecha = '$fecha'", "order" => "fecha ASC"));
    			$this->view->pick('bc_permiso/index_ibc');
    			break;
    		case 1:
    			if($this->user['nivel'] > 2){
    				$permisos = BcPermiso::find(array("estado = 2 AND fecha = '$fecha'", "order" => "fecha ASC"));
    				$this->view->pick('bc_permiso/index_ibc');
    			} else {
    				$this->view->pick('bc_permiso/index_interventor');
    			}
    			break;
    		case 2:
    			$this->view->pick('bc_permiso/index_bc');
					$texto_aprobar = $this->elements->texto_aprobar();
    			break;
    	}
    	if (count($permisos) == 0) {
    		$this->flash->notice("No se existen permisos para esta semana");
    		$permisos = null;
    	}
    	if($fecha == date('Y') . "-01-01"){
    		$this->view->btn_anterior = "<a disabled='disabled' class='btn btn-primary'>&lt;&lt; Anterior</a>";
    	} else {
    		$this->view->btn_anterior = "<a href='/sico/bc_permiso/dia/". $dia_anterior ."'class='btn btn-primary'>&lt;&lt; Anterior</a>";
    	}
    	if($fecha == date('Y') . "-12-31"){
    		$this->view->btn_siguiente = "<a disabled='disabled' class='btn btn-primary'>Siguiente &gt;&gt;</a>";
    	} else {
    		$this->view->btn_siguiente = "<a href='/sico/bc_permiso/dia/". $dia_siguiente ."' class='btn btn-primary'>Siguiente &gt;&gt;</a>";
    	}
    	$this->view->btn_anio = "<a href='/sico/bc_permiso/anio/' class='btn btn-warning'>Año</button>";
    	$this->view->btn_mes = "<a href='/sico/bc_permiso/mes/" . $mes_actual . "' class='btn btn-warning'>Mes</a>";
    	$this->view->btn_semana = "<a href='/sico/bc_permiso/semana/" . $semana . "' class='btn btn-warning'>Semana</a>";
    	$this->view->btn_dia = "<a class='btn btn-warning active'>Día</a>";
    	$this->view->titulo = $this->conversiones->fecha(4, $fecha);
			$this->view->texto_aprobar = $texto_aprobar;
    	$this->view->permisos = $permisos;
    }

    /**
     * semana action
     */
    public function semanaAction($fecha_inicio)
    {
			if(!$fecha_inicio){
				$fecha_inicio = date("Y-m-d", strtotime(date("Y-m-d"). ' last Sunday'));
			}
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/picnet.table.filter.min.js')
    	->addJs('js/permisos_lista.js');
    	$date = new DateTime($fecha_inicio);
			$fecha_inicio_comparacion = date("Y") . "-01-01";
    	if($fecha_inicio == $fecha_inicio_comparacion){
    		//Si es sabado fecha final sera la misma, de lo contrario será el próximo sábado
    		$this->view->btn_anterior = "<a disabled='disabled' class='btn btn-primary'>&lt;&lt; Anterior</a>";
    		if(date("w", strtotime("$fecha_inicio")) == 6){
    			$fecha_final = $fecha_inicio;
    		} else {
    			$fecha_final = date("Y-m-d", strtotime($fecha_inicio. ' next Saturday'));
    		}
    	} else {
    		$fecha_final = date("Y-m-d", strtotime($fecha_inicio. ' next Saturday'));
    		$semana_anterior = date("Y-m-d", strtotime($fecha_final. ' - 13 days'));
    		if(date("Y", strtotime($semana_anterior)) < date("Y")){
    			$semana_anterior = date("Y") . "-01-01";

    		}
    		$this->view->btn_anterior = "<a href='/sico/bc_permiso/semana/" . $semana_anterior . "' class='btn btn-primary'>&lt;&lt; Anterior</a>";
    	}
    	$semana_siguiente = date("Y-m-d", strtotime($fecha_final. ' + 1 day'));
    	if(date("Y", strtotime($semana_siguiente)) > date("Y")){
    		$this->view->btn_siguiente = "<a disabled='disabled' class='btn btn-primary'>Siguiente &gt;&gt;</a>";

    	} else {
    		$this->view->btn_siguiente = "<a href='/sico/bc_permiso/semana/". $semana_siguiente ."' class='btn btn-primary'>Siguiente &gt;&gt;</a>";
    	}
			$texto_aprobar;
    	$permisos = BcPermiso::find(array("fecha >= '$fecha_inicio' AND fecha <= '$fecha_final'", "order" => "fecha ASC"));
    	switch ($this->user['id_componente']) {
    		case 3:
    			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
    			if(!$oferente){
    				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
    				return $this->response->redirect("/");
    			}
    			$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
    			$permisos = BcPermiso::find(array("id_oferente = $id_oferente AND fecha >= '$fecha_inicio' AND fecha <= '$fecha_final'", "order" => "fecha ASC"));
    			$this->view->pick('bc_permiso/index_prestador');
    			break;
    		case 4:
    			$permisos = BcPermiso::find(array("estado = 2 AND fecha >= '$fecha_inicio' AND fecha <= '$fecha_final'", "order" => "fecha ASC"));
    			$this->view->pick('bc_permiso/index_ibc');
    			break;
    		case 1:
    			if($this->user['nivel'] > 2){
    				$permisos = BcPermiso::find(array("estado = 2 AND fecha >= '$fecha_inicio' AND fecha <= '$fecha_final'", "order" => "fecha ASC"));
    			$this->view->pick('bc_permiso/index_ibc');
    			} else {
    				$this->view->pick('bc_permiso/index_interventor');
    			}
    			break;
    		case 2:
    			$this->view->pick('bc_permiso/index_bc');
					$texto_aprobar = $this->elements->texto_aprobar();
    			break;
    	}
    	if (count($permisos) == 0) {
    		$this->flash->notice("No se existen permisos para esta semana");
    		$permisos = null;
    	}
    	$this->view->btn_anio = "<a href='/sico/bc_permiso/anio/' class='btn btn-warning'>Año</button>";
    	$this->view->btn_mes = "<a href='/sico/bc_permiso/mes/" . $date->format("m") . "' class='btn btn-warning'>Mes</a>";
    	$this->view->btn_semana = "<a class='btn btn-warning active'>Semana</a>";
    	$this->view->btn_dia = "<a href='/sico/bc_permiso/dia/". $fecha_inicio ."' class='btn btn-warning'>Día</a>";
    	$this->view->titulo = $this->conversiones->fecha(10, $fecha_inicio) . " - " . $this->conversiones->fecha(10, $fecha_final);
			$this->view->texto_aprobar = $texto_aprobar;
    	$this->view->permisos = $permisos;
    }

    /**
     * mes action
     */
    public function mesAction($mes_actual)
    {
			if(!$mes_actual){
				$mes_actual = date('m');
			}
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/picnet.table.filter.min.js')
    	->addJs('js/permisos_lista.js');
    	$fecha_actual = date("Y-$mes_actual-01");
    	$date = new DateTime($fecha_actual);
    	$semana = $fecha_actual;
    	if(date("w", strtotime($fecha_actual)) !== 0 && $mes_actual > 1){
    		$semana = date("Y-m-d", strtotime($fecha_actual. ' next Sunday'));
    	}
    	$mes_siguiente = intval($mes_actual) + 1;
    	$mes_siguiente = sprintf("%02d", $mes_siguiente);
    	$mes_anterior = intval($mes_actual) - 1;
    	$mes_anterior = sprintf("%02d",$mes_anterior);
			$texto_aprobar = array("aprobar_salida" => "", "aprobar_jornada" => "");;
    	$permisos = BcPermiso::find(array("MONTH(fecha) = $mes_actual", "order" => "fecha ASC"));
    	switch ($this->user['id_componente']) {
    		case 3:
    			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
    			if(!$oferente){
    				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
    				return $this->response->redirect("/");
    			}
    			$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
    			$permisos = BcPermiso::find(array("id_oferente = $id_oferente AND MONTH(fecha) = $mes_actual", "order" => "fecha ASC"));
    			$this->view->pick('bc_permiso/index_prestador');
    			break;
    		case 4:
    			$permisos = BcPermiso::find(array("estado = 2 AND MONTH(fecha) = $mes_actual", "order" => "fecha ASC"));
    			$this->view->pick('bc_permiso/index_ibc');
    			break;
    		case 1:
    			if($this->user['nivel'] > 2){
    				$permisos = BcPermiso::find(array("estado = 2 AND MONTH(fecha) = $mes_actual", "order" => "fecha ASC"));
    				$this->view->pick('bc_permiso/index_ibc');
    			} else {
    				$this->view->pick('bc_permiso/index_interventor');
    			}
    			break;
    		case 2:
    			$this->view->pick('bc_permiso/index_bc');
					$texto_aprobar = $this->elements->texto_aprobar();
    			break;
    	}
    	if (count($permisos) == 0) {
    		$this->flash->notice("No se existen permisos para este mes");
    		$permisos = null;
    	}
    	if($mes_actual == "01"){
    		$this->view->btn_anterior = "<a disabled='disabled' class='btn btn-primary'>&lt;&lt; Anterior</a>";
    	} else {
    		$this->view->btn_anterior = "<a href='/sico/bc_permiso/mes/". $mes_anterior ."'class='btn btn-primary'>&lt;&lt; Anterior</a>";
    	}
    	if($mes_actual == "12"){
    		$this->view->btn_siguiente = "<a disabled='disabled' class='btn btn-primary'>Siguiente &gt;&gt;</a>";
    	} else {
    		$this->view->btn_siguiente = "<a href='/sico/bc_permiso/mes/". $mes_siguiente ."' class='btn btn-primary'>Siguiente &gt;&gt;</a>";
    	}
    	$this->view->btn_anio = "<a href='/sico/bc_permiso/anio/' class='btn btn-warning'>Año</button>";
    	$this->view->btn_mes = "<a class='btn btn-warning active'>Mes</a>";
    	$this->view->btn_semana = "<a href='/sico/bc_permiso/semana/". $semana ."' class='btn btn-warning'>Semana</a>";
    	$this->view->btn_dia = "<a href='/sico/bc_permiso/dia/". $semana ."' class='btn btn-warning'>Día</a>";
    	$this->view->titulo = $this->conversiones->fecha(8, $fecha_actual);
			$this->view->texto_aprobar = $texto_aprobar;
    	$this->view->permisos = $permisos;
    }

    /**
     * anio action
     */
    public function anioAction()
    {
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js')
    	->addJs('js/picnet.table.filter.min.js')
    	->addJs('js/permisos_lista.js');
    	$fecha_actual = date("Y-01-01");
    	$date = new DateTime($fecha_actual);
    	$permisos = BcPermiso::find(array("order" => "fecha ASC"));
			$texto_aprobar = array("aprobar_salida" => "", "aprobar_jornada" => "");;
    	switch ($this->user['id_componente']) {
    		case 3:
    			$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
    			if(!$oferente){
    				$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
    				return $this->response->redirect("/");
    			}
    			$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
    			$permisos = BcPermiso::find(array("id_oferente = $id_oferente", "order" => "fecha ASC"));
    			$this->view->pick('bc_permiso/index_prestador');
    			break;
    		case 4:
    			$permisos = BcPermiso::find(array("estado = 2", "order" => "fecha ASC"));
    			$this->view->pick('bc_permiso/index_ibc');
    			break;
    		case 1:
    			if($this->user['nivel'] > 2){
    				$permisos = BcPermiso::find(array("estado = 2", "order" => "fecha ASC"));
    				$this->view->pick('bc_permiso/index_ibc');
    			} else {
    				$this->view->pick('bc_permiso/index_interventor');
    			}
    			break;
    		case 2:
    			$this->view->pick('bc_permiso/index_bc');
					$texto_aprobar = $this->elements->texto_aprobar();
    			break;
    	}
    	if (count($permisos) == 0) {
    		$this->flash->notice("No se existen permisos para este año");
    		$permisos = null;
    	}
    	$this->view->btn_anterior = "";
    	$this->view->btn_siguiente = "";
    	$this->view->btn_anio = "<a class='btn btn-warning active'>Año</button>";
    	$this->view->btn_mes = "<a href='/sico/bc_permiso/mes/01' class='btn btn-warning'>Mes</a>";
    	$this->view->btn_semana = "<a href='/sico/bc_permiso/semana/". date("Y") ."-01-01' class='btn btn-warning'>Semana</a>";
    	$this->view->btn_dia = "<a href='/sico/bc_permiso/dia/". date("Y") ."-01-01' class='btn btn-warning'>Día</a>";
    	$this->view->titulo = "Año " . date('Y');
			$this->view->texto_aprobar = $texto_aprobar;
    	$this->view->permisos = $permisos;
    }

    /**
     * Formulario para la creación de un permiso
     */
    public function nuevoAction($id_categoria, $id_sede_contrato, $accion)
    {
    	if($this->user['id_componente'] == 3){
    		$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
    		if(!$oferente){
    			$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
    			return $this->response->redirect("/");
    		}
    		$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
    		$sedes = BcSedeContrato::find(array("id_oferente = $id_oferente", "group" => "id_sede_contrato"));
    	} else {
    		$sedes = BcSedeContrato::find(array("group" => "id_sede_contrato"));
    	}
    	//Cuando no existen contratos se coloca mensaje de alerta
    	if (count($sedes) == 0) {
    		$this->flash->notice("No se ha agregado ningún contrato, por lo tanto no puede crear permisos");
    		$sedes = null;
    	}
    	$this->view->sedes = $sedes;
    	if($id_categoria == 'incidente'){
    		if(!$id_sede_contrato){
    			$this->assets
    			->addJs('js/multifilter.min.js');
    			$this->view->titulo = "Nuevo Permiso - Incidente";
    			$this->view->enlace = "incidente";
    			$this->view->pick('bc_permiso/seleccionar_sede');
    		} else {
    			$sede = BcSedeContrato::findFirstByid_sede_contrato($id_sede_contrato);
    			if(!$sede){
    				$this->flash->notice("No se encontró la sede, por favor inténtelo nuevamente o contacte con el administrador");
    				return $this->response->redirect("bc_permiso");
    			}
    			$this->view->sede = $sede;
    			$this->view->id_sede_contrato = $id_sede_contrato;
    			$this->assets
    			->addJs('js/parsley.min.js')
    			->addJs('js/parsley.extend.js')
    			->addJs('js/bootstrap-datepicker.min.js')
    			->addJs('js/bootstrap-datepicker.es.min.js')
    			->addJs('js/jquery.datepair.min.js')
    			->addCss('css/bootstrap-datepicker.min.css')
    			->addJs('js/permiso_incidente.js');
    			$this->view->pick('bc_permiso/nuevo_incidente');
    		}

    	} else if($id_categoria == 'jornada_planeacion'){
    		if(!$id_sede_contrato){
    			$this->assets
    			->addJs('js/multifilter.min.js');
    			$this->view->titulo = "Nuevo Permiso - Jornada de Planeación";
    			$this->view->enlace = "jornada_planeacion";
    			$this->view->pick('bc_permiso/seleccionar_sede');
    		} else {
    			$sede = BcSedeContrato::findFirstByid_sede_contrato($id_sede_contrato);
    			if(!$sede){
    				$this->flash->notice("No se encontró la sede, por favor inténtelo nuevamente o contacte con el administrador");
    				return $this->response->redirect("bc_permiso");
    			}
    			if($sede->modalidad == 5 || $sede->id_modalidad == 12){
    				$limite_permisos = 2;
    			} else {
    				$limite_permisos = 1;
    			}
    			$this->view->permisos_anuales = 12 * $limite_permisos;
    			$this->view->sede = $sede;
    			$this->view->id_sede_contrato = $id_sede_contrato;
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
    			->addJs('js/jornada_planeacion.js');
    			$this->view->pick('bc_permiso/nuevo_jornada_planeacion');

    		}

    	} else if($id_categoria == 'jornada_formacion'){
    		if(!$id_sede_contrato){
    			$this->assets
    			->addJs('js/multifilter.min.js');
    			$this->view->titulo = "Nuevo Permiso - Jornada de Formación";
    			$this->view->enlace = "jornada_formacion";
    			$this->view->pick('bc_permiso/seleccionar_sede');
    		} else {
    			$sede = BcSedeContrato::findFirstByid_sede_contrato($id_sede_contrato);
    			if(!$sede){
    				$this->flash->notice("No se encontró la sede, por favor inténtelo nuevamente o contacte con el administrador");
    				return $this->response->redirect("bc_permiso");
    			}
    			if($sede->modalidad == 5 || $sede->id_modalidad == 12){
    				$limite_permisos = 2;
    			} else {
    				$limite_permisos = 1;
    			}
    			$this->view->permisos_anuales = 12 * $limite_permisos;
    			$this->view->sede = $sede;
    			$this->view->id_sede_contrato = $id_sede_contrato;
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
    			->addJs('js/jornada_formacion.js');
    			$this->view->pick('bc_permiso/nuevo_jornada_formacion');

    		}

    	} else if($id_categoria == "salida_pedagogica" || $id_categoria == "movilizacion_social" || $id_categoria == "salida_ludoteka"){
    		$this->view->titulo = $this->elements->getCategoriaPermiso($id_categoria)['titulo'];
    		$this->view->enlace = $this->elements->getCategoriaPermiso($id_categoria)['enlace'];
    		if(!$id_sede_contrato){
    			$this->assets
    			->addJs('js/multifilter.min.js');
    			$this->view->pick('bc_permiso/seleccionar_sede');
    		} else {
    			$sede = BcSedeContrato::findFirstByid_sede_contrato($id_sede_contrato);
    			if(!$sede){
    				$this->flash->notice("No se encontró la sede, por favor inténtelo nuevamente o contacte con el administrador");
    				return $this->response->redirect("bc_permiso");
    			}
    			$this->view->sede = $sede;
    			$this->view->id_sede_contrato = $id_sede_contrato;
    			$this->view->id_categoria = $this->elements->getCategoriaPermiso($id_categoria)['id'];
    			$this->view->categoria = $id_categoria;
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
    			->addJs('js/bootstrap-filestyle.min.js')
					->addJs('js/jquery.tooltipster.min.js')
    			->addJs('js/permiso_general.js');
    			$this->view->pick('bc_permiso/nuevo_general');
    		}
    	}
    }

    public function crear_incidenteAction($id_sede_contrato){
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_permiso/nuevo");
    	}
    	$sede = BcSedeContrato::findFirstByid_sede_contrato($id_sede_contrato);
    	if(!$sede){
    		$this->flash->notice("No se encontró la sede, por favor inténtelo nuevamente o contacte con el administrador");
    		return $this->response->redirect("/bc_permiso/nuevo");
    	}
    	//Verificamos que el permiso no sea menor o igual al día de ayer
    	if(strtotime($this->conversiones->fecha(1, $this->request->getPost("fecha"))) <= strtotime('-1 day')){
    		$this->view->fechas = $this->request->getPost("fecha");
    		$this->view->titulo = $this->request->getPost("titulo");
    		$this->view->observaciones = $this->request->getPost("observaciones");
    		$this->flash->error("No puedes crear un permiso con fecha anterior.");
    		$this->dispatcher->forward(
    				array(
    						"controller" => "bc_permiso",
    						"action" => "nuevo",
    						"params" => array("incidente", $id_sede_contrato)
    				)
    		);
    		return;
    	}
    	$bc_permiso = new BcPermiso();
    	$bc_permiso->id_oferente = $sede->id_oferente;
    	$bc_permiso->categoria = 1;
    	$bc_permiso->estado = 0;
    	$bc_permiso->id_sede_contrato = $sede->id_sede_contrato;
    	$bc_permiso->titulo = $this->request->getPost("titulo");
    	$bc_permiso->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
    	$bc_permiso->fechahora = date('Y-m-d H:i:s');
    	$bc_permiso->observaciones = $this->request->getPost("observaciones");
    	if (!$bc_permiso->save()) {
    		foreach ($bc_permiso->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("bc_permiso/nuevo/incidente");
    	}
    	$this->flash->success("El permiso con ID <strong>$bc_permiso->id_permiso</strong> se creó exitosamente.");
    	return $this->response->redirect("bc_permiso");
    }

    public function crear_jornada_planeacionAction($id_sede_contrato){
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_permiso/nuevo");
    	}
    	$sede = BcSedeContrato::findFirstByid_sede_contrato($id_sede_contrato);
    	if(!$sede){
    		$this->flash->notice("No se encontró la sede, por favor inténtelo nuevamente o contacte con el administrador");
    		return $this->response->redirect("/bc_permiso/nuevo");
    	}
    	if($sede->modalidad == 5 || $sede->id_modalidad == 12){
    		$limite_permisos = 2;
    	} else {
    		$limite_permisos = 1;
    	}
    	$error = array();
    	$meses = array("0");
    	foreach($this->request->getPost("fecha") as $row){
    		$parts = explode('/', $row);
    		$mes = intval($parts[1]);
    		$count_meses = array_count_values($meses);
    		$sede2 = BcPermiso::find("MONTH(fecha) = $mes AND categoria = 5 AND id_sede_contrato = $id_sede_contrato AND estado < 3");

    		//Primero que no sea menor a la fecha actual + 15 días
    		if(strtotime($this->conversiones->fecha(1, $row)) < strtotime('+14 days')){
    			$error[] = 1;
    		} else if(count($sede2) >= $limite_permisos){
    			$error[] = 2;
    		} else if($count_meses["$mes"] >= $limite_permisos){
    			$error[] = 3;
    		} else {
    			$error[] = 0;
    		}
    		$meses[] = $mes;
    	}
    	if(max($error) > 0){
    		$this->view->fechas = $this->request->getPost("fecha");
    		$this->view->horasInicio = $this->request->getPost("horaInicio");
    		$this->view->horasFin = $this->request->getPost("horaFin");
    		$this->view->error = $error;
    		$this->view->limite = $limite_permisos;
    		$this->dispatcher->forward(
    				array(
    						"controller" => "bc_permiso",
    						"action" => "nuevo",
    						"params" => array("jornada_planeacion", $id_sede_contrato)
    				)
    		);
    		return;
    	}
    	$fechas = $this->conversiones->array_fechas(1, $this->request->getPost("fecha"));
    	$elementos = array(
    			'fecha' => $fechas,
    			'fechahora' => date('Y-m-d H:i:s'),
    			'id_oferente' => $sede->id_oferente,
    			'categoria' => '5',
    			'estado' => '0',
    			'id_sede_contrato' => $sede->id_sede_contrato,
	    		'horaInicio' => $this->request->getPost("horaInicio"),
	    		'horaFin' => $this->request->getPost("horaFin")
	    );
    	$db = $this->getDI()->getDb();
    	$sql = $this->conversiones->multipleinsert("bc_permiso", $elementos);
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("bc_permiso/nuevo");
    	}
    	$this->flash->success("Los permisos se crearon exitosamente");
    	return $this->response->redirect("bc_permiso/");
    }

	public function crear_jornada_formacionAction($id_sede_contrato){
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_permiso/nuevo");
    	}
    	$sede = BcSedeContrato::findFirstByid_sede_contrato($id_sede_contrato);
    	if(!$sede){
    		$this->flash->notice("No se encontró la sede, por favor inténtelo nuevamente o contacte con el administrador");
    		return $this->response->redirect("/bc_permiso/nuevo");
    	}
    	if($sede->modalidad == 5 || $sede->id_modalidad == 12){
    		$limite_permisos = 2;
    	} else {
    		$limite_permisos = 1;
    	}
    	$error = array();
    	$meses = array("0");
    	foreach($this->request->getPost("fecha") as $row){
    		$parts = explode('/', $row);
    		$mes = intval($parts[1]);
    		$count_meses = array_count_values($meses);
    		$sede2 = BcPermiso::find("MONTH(fecha) = $mes AND categoria = 6 AND id_sede_contrato = $id_sede_contrato AND estado < 3");

    		//Primero que no sea menor a la fecha actual + 15 días
    		if(strtotime($this->conversiones->fecha(1, $row)) < strtotime('+14 days')){
    			$error[] = 1;
    		} else if(count($sede2) >= $limite_permisos){
    			$error[] = 2;
    		} else if($count_meses["$mes"] >= $limite_permisos){
    			$error[] = 3;
    		} else {
    			$error[] = 0;
    		}
    		$meses[] = $mes;
    	}
    	if(max($error) > 0){
    		$this->view->fechas = $this->request->getPost("fecha");
    		$this->view->horasInicio = $this->request->getPost("horaInicio");
    		$this->view->horasFin = $this->request->getPost("horaFin");
    		$this->view->error = $error;
    		$this->view->limite = $limite_permisos;
    		$this->dispatcher->forward(
    				array(
    						"controller" => "bc_permiso",
    						"action" => "nuevo",
    						"params" => array("jornada_formacion", $id_sede_contrato)
    				)
    		);
    		return;
    	}
    	$fechas = $this->conversiones->array_fechas(1, $this->request->getPost("fecha"));
    	$elementos = array(
    			'fecha' => $fechas,
    			'fechahora' => date('Y-m-d H:i:s'),
    			'id_oferente' => $sede->id_oferente,
    			'categoria' => '6',
    			'estado' => '0',
    			'id_sede_contrato' => $sede->id_sede_contrato,
	    		'horaInicio' => $this->request->getPost("horaInicio"),
	    		'horaFin' => $this->request->getPost("horaFin")
	    );
    	$db = $this->getDI()->getDb();
    	$sql = $this->conversiones->multipleinsert("bc_permiso", $elementos);
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("bc_permiso/nuevo");
    	}
    	$this->flash->success("Los permisos se crearon exitosamente");
    	return $this->response->redirect("bc_permiso/");
    }

    public function crear_generalAction($id_sede_contrato, $id_categoria){
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_permiso/nuevo");
    	}
    	$sede = BcSedeContrato::findFirstByid_sede_contrato($id_sede_contrato);
    	if(!$sede || $id_categoria == NULL){
    		$this->flash->notice("No se encontró la sede, por favor inténtelo nuevamente o contacte con el administrador");
    		return $this->response->redirect("/bc_permiso/nuevo");
    	}
			if(!$this->request->getPost("nombreCompleto") || !$this->request->getPost("numDocumento")){
    		$this->flash->error("Ocurrió un error al agregar el listado de participantes, el permiso no fue creado, por favor inténtelo nuevamente.");
    		return $this->response->redirect("/bc_permiso/nuevo");
    	}
    	$tipo_permiso = $this->request->getPost("tipo_permiso");
			$requiereTransporte = $this->request->getPost("requiereTransporte");
			/* $tipo_permiso
			* 0: No repetir
			* 1: Repetir Semanalmente
			* 2: Repetir Quincenalmente
			*/
    	if($tipo_permiso == 0){
    		$bc_permiso = new BcPermiso();
    		$bc_permiso->fechahora = date('Y-m-d H:i:s');
    		$bc_permiso->id_oferente = $sede->id_oferente;
    		$bc_permiso->categoria = $id_categoria;
    		$bc_permiso->estado = '0';
    		$bc_permiso->id_sede_contrato = $sede->id_sede_contrato;
    		$bc_permiso->titulo = $this->request->getPost("titulo");
    		$bc_permiso->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
    		$bc_permiso->horaInicio = $this->request->getPost("horaInicio");
    		$bc_permiso->horaFin = $this->request->getPost("horaFin");
    		$bc_permiso->observaciones = $this->request->getPost("observaciones");
    		if (!$bc_permiso->save()) {
    			foreach ($bc_permiso->getMessages() as $message) {
    				$this->flash->error($message);
    			}
    			return $this->response->redirect("bc_permiso/nuevo");
    		}
				$bc_permiso_general = new BcPermisoGeneral();
				$bc_permiso_general->id_permiso = $bc_permiso->id_permiso;
				$bc_permiso_general->actores = $this->request->getPost("actores");
				$bc_permiso_general->direccionEvento = $this->request->getPost("direccionEvento");
				$bc_permiso_general->personaContactoEvento = $this->request->getPost("personaContactoEvento");
				$bc_permiso_general->telefonoContactoEvento = $this->request->getPost("telefonoContactoEvento");
				$bc_permiso_general->emailContactoEvento = $this->request->getPost("emailContactoEvento");
				$bc_permiso_general->requiereTransporte = $requiereTransporte;
				if (!$bc_permiso_general->save()) {
					foreach ($bc_permiso->getMessages() as $message) {
						$this->flash->error($message);
					}
					$bc_permiso->delete();
					return $this->response->redirect("bc_permiso/nuevo");
				}
				if($requiereTransporte == 1){
					$this->agregarTransporte($bc_permiso, $bc_permiso_general);
				}
				$elementos = array(
						'numDocumento' => $this->request->getPost("numDocumento"),
						'nombreCompleto' => $this->request->getPost("nombreCompleto"),
						'id_permiso' => $bc_permiso->id_permiso
				);
				$db = $this->getDI()->getDb();
				$sql = $this->conversiones->multipleinsert("bc_permiso_participante", $elementos);
				$query = $db->query($sql);
				if (!$query) {
					foreach ($query->getMessages() as $message) {
						$this->flash->error($message);
					}
					$bc_permiso->delete();
					$bc_permiso_general->delete();
					return $this->response->redirect("bc_permiso/revision");
				}
    		$mensaje_success = "El permiso con ID <strong>$bc_permiso->id_permiso</strong> fue creado exitosamente";
    	} else if($tipo_permiso == 1 || $tipo_permiso == 2){
    		$fecha_inicio = $this->conversiones->fecha(1, $this->request->getPost("fecha_inicio_permiso"));
    		$fecha_fin = $this->conversiones->fecha(1, $this->request->getPost("fecha_fin_permiso"));
    		$dias = $this->request->getPost('dias');
    		$fechas = array();
    		foreach($dias as $dia){
    			$fecha_actual = $fecha_inicio;
    			//Si el día de la fecha inicio es igual al día se convierte en fecha actual
    			if(date('l', strtotime($fecha_inicio)) == $dia){
    				$fecha_actual = $fecha_inicio;
    			} else {
    				$fecha_actual = date("Y-m-d", strtotime("$fecha_inicio next $dia"));
    			}
    			//Mientras que la próxima semana sea menor o igual a la fecha fin se agrega la fecha actual
    			while(strtotime($fecha_actual) <= strtotime($fecha_fin)){
    				//Si no es festivo se agrega la fecha actual
    				if(!in_array($fecha_actual, $this->elements->festivos_array())){
    					$fechas[] = $fecha_actual;
    				}
    				$fecha_actual = strtotime($fecha_actual . " + ".$tipo_permiso." week");
    				$fecha_actual = date("Y-m-d", $fecha_actual);
    			}
    		}
    		if(!$fechas){
	    		$this->view->titulo = $this->request->getPost("titulo");
	    		$this->view->observaciones = $this->request->getPost("observaciones");
	    		$this->view->actores = $this->request->getPost("actores");
	    		$this->view->direccionEvento = $this->request->getPost("direccionEvento");
	    		$this->view->personaContactoEvento = $this->request->getPost("personaContactoEvento");
	    		$this->view->telefonoContactoEvento = $this->request->getPost("telefonoContactoEvento");
	    		$this->view->emailContactoEvento = $this->request->getPost("emailContactoEvento");
	    		$this->flash->error("No se creó el permiso porque el rango de fechas y los días seleccionados no contienen fechas disponibles, por favor revisa nuevamente o contacta al administrador.");
	    		$this->dispatcher->forward(
	    				array(
	    						"controller" => "bc_permiso",
	    						"action" => "nuevo",
	    						"params" => array($this->elements->getCategoriaNombre($id_categoria), $id_sede_contrato)
	    				)
	    		);
	    		return;
    		}
    		$i = 0;
    		foreach($fechas as $row){
    			$bc_permiso = new BcPermiso();
    			$bc_permiso->fechahora = date('Y-m-d H:i:s');
    			$bc_permiso->id_oferente = $sede->id_oferente;
    			$bc_permiso->categoria = $id_categoria;
    			$bc_permiso->estado = '0';
    			$bc_permiso->id_sede_contrato = $sede->id_sede_contrato;
    			$bc_permiso->titulo = $this->request->getPost("titulo");
    			$bc_permiso->fecha = $row;
    			$bc_permiso->horaInicio = $this->request->getPost("horaInicio");
    			$bc_permiso->horaFin = $this->request->getPost("horaFin");
    			$bc_permiso->observaciones = $this->request->getPost("observaciones");
    			if (!$bc_permiso->save()) {
    				foreach ($bc_permiso->getMessages() as $message) {
    					$this->flash->error($message);
    				}
    				return $this->response->redirect("bc_permiso/nuevo");
    			}
					$bc_permiso_general = new BcPermisoGeneral();
		    	$bc_permiso_general->id_permiso = $bc_permiso->id_permiso;
		    	$bc_permiso_general->actores = $this->request->getPost("actores");
		    	$bc_permiso_general->direccionEvento = $this->request->getPost("direccionEvento");
		    	$bc_permiso_general->personaContactoEvento = $this->request->getPost("personaContactoEvento");
		    	$bc_permiso_general->telefonoContactoEvento = $this->request->getPost("telefonoContactoEvento");
		    	$bc_permiso_general->emailContactoEvento = $this->request->getPost("emailContactoEvento");
		    	$bc_permiso_general->requiereTransporte = $requiereTransporte;
		    	if (!$bc_permiso_general->save()) {
		    		foreach ($bc_permiso->getMessages() as $message) {
		    			$this->flash->error($message);
		    		}
		    		$bc_permiso->delete();
		    		return $this->response->redirect("bc_permiso/nuevo");
		    	}
					if($requiereTransporte == 1){
						$this->agregarTransporte($bc_permiso, $bc_permiso_general);
					}
    			if($i == 0){
    				$id_permiso_vinculado = $bc_permiso->id_permiso;
    			} else {
    				$bc_permiso_vinculado = new BcPermisoVinculado();
    				$bc_permiso_vinculado->id_permiso_padre = $id_permiso_vinculado;
    				$bc_permiso_vinculado->id_permiso = $bc_permiso->id_permiso;
    				$bc_permiso_vinculado->save();
    			}
					$elementos = array(
		    			'numDocumento' => $this->request->getPost("numDocumento"),
		    			'nombreCompleto' => $this->request->getPost("nombreCompleto"),
							'id_permiso' => $bc_permiso->id_permiso
			    );
		    	$db = $this->getDI()->getDb();
		    	$sql = $this->conversiones->multipleinsert("bc_permiso_participante", $elementos);
		    	$query = $db->query($sql);
					if (!$query) {
		    		foreach ($query->getMessages() as $message) {
		    			$this->flash->error($message);
		    		}
						$bc_permiso->delete();
						$bc_permiso_general->delete();
		    		return $this->response->redirect("bc_permiso/revision");
		    	}
    			$i++;
    		}
    		$mensaje_success = "Los permisos fueron creados exitosamente";
    	}
    	$this->flash->success($mensaje_success);
    	return $this->response->redirect("bc_permiso/");
    }

		public function agregarTransporte($bc_permiso, $bc_permiso_general){
    		$bc_permiso_general_transporte = new BcPermisoGeneralTransporte();
    		$bc_permiso_general_transporte->id_permiso = $bc_permiso->id_permiso;
    		$bc_permiso_general_transporte->runtConductor = $this->request->getPost("runtConductor");
    		$bc_permiso_general_transporte->runtVehiculo = $this->request->getPost("runtVehiculo");
    		$bc_permiso_general_transporte->polizaResponsabilidadCivil = $this->request->getPost("polizaResponsabilidadCivil");
    		$bc_permiso_general_transporte->tarjetaOperacionVehiculo = $this->request->getPost("tarjetaOperacionVehiculo");
				if (!$bc_permiso_general_transporte->save()) {
    			foreach ($bc_permiso->getMessages() as $message) {
    				$this->flash->error($message);
    			}
    			$bc_permiso->delete();
    			$bc_permiso_general->delete();
    			return $this->response->redirect("bc_permiso/nuevo");
    		}
		}

    /**
     * Subir adicional
     *
     */
    public function subir_archivoAction($id_sede_contrato, $tipo) {

    	$this->view->disable();
    	if($tipo == "imgpdf"){
    		$tipos = array("image/png", "image/jpeg", "image/jpg", "image/bmp", "image/gif", "application/pdf");
    	} else if($tipo == "xls"){
    		$tipos = array("application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    	}
    	if ($this->request->isPost()) {
    		if ($this->request->hasFiles() == true) {
    			$uploads = $this->request->getUploadedFiles();
    			$isUploaded = false;
    			foreach($uploads as $upload){
						if(!$upload->getName()){
							continue;
						}
    				if(in_array($upload->gettype(), $tipos)){
    					$nombre = $id_sede_contrato.date("ymdHis").".".$upload->getextension ();
    					$path = "files/permisos/".$nombre;
    					($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
    				} else {
    					echo $tipo;
    					exit;
    				}
    			}
    			if($isUploaded){
    				chmod($path, 0777);
    				echo $nombre;

    			} else {
    				echo "Error";
    			}
    		}else {
    			echo "Error";
    		}
    	}
    }

    /**
     * permiso action
     */
    public function aprobarAction($id_permiso)
    {

    	if($this->user['nivel'] > 2){
    		$this->flash->error("Usted no tiene suficiente privilegios para realizar esta acción.");
    		return $this->response->redirect("bc_permiso");
    	}
    	$permiso = BcPermiso::findFirstByid_permiso($id_permiso);
    	if (!$permiso) {
    		$this->flash->notice("El permiso con ID <strong>$id_permiso</strong> no fue encontrado en la base de datos.");
    		return $this->response->redirect("bc_permiso");
    	}
    	$permiso_observacion = new BcPermisoObservacion();
    	//id_componente 1 (Cobertura); id_componente 2 (Secretaría Buen Comienzo)
    	if($this->user['id_componente'] == 1){
    		if($permiso->estado == 0 || $permiso->estado == 3){
	    		$permiso->estado = 1;
	    		$permiso_observacion->estado = 1;
    		} else {
    			$this->flash->notice("Este permiso con ID <strong>$id_permiso</strong> no puede ser aprobado porque ya fue aprobado o no fue anulado por usted, por favor revíselo he inténtelo nuevamente.");
    			return $this->response->redirect("bc_permiso");
    		}
    	} else if($this->user['id_componente'] == 2) {
    		if($permiso->estado == 1 || $permiso->estado == 4){
    			$permiso->estado = 2;
					$permiso->fechaAprobacion = date("Y-m-d");
    			$permiso_observacion->estado = 2;
    		} else {
    			$this->flash->notice("El permiso con ID <strong>$id_permiso</strong> no puede ser aprobado porque no ha sido Revisado por Interventoría, ya fue aprobado, o fue anulado por alguien diferente a usted, por favor revíselo he inténtelo nuevamente.");
    			return $this->response->redirect("bc_permiso");
    		}
    	}
    	$permiso->save();
    	$permiso_observacion->id_permiso = $id_permiso;
    	$permiso_observacion->id_usuario = $this->id_usuario;
    	$permiso_observacion->fechahora = date("Y-m-d H:i:s");
    	$permiso_observacion->observacion = $this->request->getPost("observacion");
    	$permiso_observacion->save();
    	$this->flash->success("El permiso con ID <strong>$id_permiso</strong> fue aprobado exitosamente");
    	return $this->response->redirect('bc_permiso');
    }

    /**
     * Aprobar permiso por parte de Buen Comienzo
     * Se diferencia de las demás aprobaciones porque en Secreataría colocan observación al aprobar
     *
     *
     * @param string $id_carga
     */
    public function aprobarbcAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_permiso");
    	}
    	$id_permiso = $this->request->getPost("id_permiso");
    	$permiso = BcPermiso::findFirstByid_permiso($id_permiso);
    	if (!$permiso) {
    		$this->flash->error("El permiso con ID <strong>$id_permiso</strong> no fue encontrado.");
    		return $this->response->redirect('bc_permiso');
    	}
    	$permiso_observacion = new BcPermisoObservacion();
    	//id_componente 1 (Cobertura); id_componente 2 (Buen Comienzo)
    	if($this->user['id_componente'] == 1){
    		$permiso->estado = 1;
    		$permiso_observacion->estado = 1;
    	} else if($this->user['id_componente'] == 2) {
    		$permiso->estado = 2;
    		$permiso_observacion->estado = 2;
				$permiso->fechaAprobacion = date("Y-m-d");
    	}
    	$permiso->save();
    	$permiso_observacion->id_permiso = $id_permiso;
    	$permiso_observacion->id_usuario = $this->id_usuario;
    	$permiso_observacion->fechahora = date("Y-m-d H:i:s");
    	$permiso_observacion->observacion = $this->request->getPost("observacion");
    	$permiso_observacion->save();
    	$this->flash->success("El permiso con ID <strong>$id_permiso</strong> fue aprobado exitosamente");
        return $this->response->redirect('bc_permiso');
    }

		/**
		 *
		 * Agregar participantes
		 *
		 */
		 public function agregar_participantesAction($id_permiso){
			 if (!$this->request->isPost()) {
     		return $this->response->redirect('bc_permiso');
     	 }
			 $permiso = BcPermiso::findFirst(array("id_permiso = $id_permiso"));
			 if (!$permiso) {
             $this->flash->error("El permiso con ID <strong>$id_permiso</strong> no fue encontrado o no tiene privilegios para agregarle participantes");
             return $this->response->redirect("bc_permiso/");
			 }
			 if($permiso->fecha <= date('Y-m-d')){
				 $this->flash->error("Solo se pueden agregar participantes hasta un día anterior del día del permiso.");
				 return $this->response->redirect("bc_permiso/permiso/$id_permiso");
			 }
			 $elementos = array(
					 'numDocumento' => $this->request->getPost("numDocumento"),
					 'nombreCompleto' => $this->request->getPost("nombreCompleto"),
					 'id_permiso' => $permiso->id_permiso
			 );
			 $db = $this->getDI()->getDb();
			 $sql = $this->conversiones->multipleinsert("bc_permiso_participante", $elementos);
			 $query = $db->query($sql);
			 if (!$query) {
				 foreach ($query->getMessages() as $message) {
					 $this->flash->error($message);
				 }
				 return $this->response->redirect("bc_permiso/permiso/$id_permiso");
			 }
			 $this->flash->success("Se agregaron exitosamente los participantes para el permiso con ID <strong>$id_permiso</strong>.");
			 return $this->response->redirect("bc_permiso/permiso/$id_permiso");
		 }

    /**
     * Anular permiso
     *
     *
     */
    public function anularAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect('bc_permiso');
    	}
    	$id_permiso = $this->request->getPost("id_permiso");
    	//id_componente: 1 (Cobertura); 2 (Buen Comienzo); 3 (Oferente)
    	if($this->user['id_componente'] == 3){
    		$oferente = IbcUsuario::findFirstByid_usuario($this->id_usuario);
    		if(!$oferente){
    			$this->flash->error("Este usuario no fue encontrado en la base de datos de prestadores.");
    			return $this->response->redirect('bc_permiso');
    		}
    		$id_oferente = $oferente->IbcUsuarioOferente->id_oferente;
    		$permiso = BcPermiso::findFirst(array("id_oferente = $id_oferente AND id_permiso = $id_permiso"));
    		$estado = 5;
    	} else if($this->user['id_componente'] == 2){
    		$permiso = BcPermiso::findFirst(array("id_permiso = $id_permiso"));
    		$estado = 4;
    	} else if($this->user['id_componente'] == 1){
    		if($this->user['nivel'] > 2){
    			$this->flash->error("Usted no tiene suficiente privilegios para realizar esta acción.");
    			return $this->response->redirect("bc_permiso");
    		}
    		$permiso = BcPermiso::findFirst(array("id_permiso = $id_permiso"));
    		$estado = 3;
    	}
   		if (!$permiso) {
            $this->flash->error("El permiso con ID <strong>$id_permiso</strong> no fue encontrado o no tiene privilegios para anularlo");
            return $this->response->redirect("bc_permiso/");
        }
        if($permiso->estado == $estado){
        	$this->flash->error("El permiso con ID <strong>$id_permiso</strong> ya se encuentra anulado.");
        	return $this->response->redirect("bc_permiso/");
        }
        $permiso->estado = $estado;
				$permiso->fechaAprobacion = NULL;
        if (!$permiso->save()) {
        	foreach ($permiso->getMessages() as $message) {
        		$this->flash->error($message);
        	}
        	return $this->response->redirect("bc_permiso");
        }
        $permiso_observacion = new BcPermisoObservacion();
        $permiso_observacion->id_permiso = $id_permiso;
        $permiso_observacion->id_usuario = $this->id_usuario;
        $permiso_observacion->fechahora = date("Y-m-d H:i:s");
        $permiso_observacion->estado = $estado;
        $permiso_observacion->observacion = $this->request->getPost("observacion");
        $permiso_observacion->save();
        $this->flash->success("El permiso con ID <strong>$id_permiso</strong> fue anulado exitosamente");
        return $this->response->redirect('bc_permiso');
    }
    public function modificar_permisosAction(){
    	if (!$this->request->isPost()) {
    		return $this->response->redirect('bc_permiso/revision');
    	}
    	if($this->request->getPost("estado") == 0){
    		$this->flash->error("Debes de seleccionar un estado por el cual vas a cambiar el permiso.");
    		return $this->response->redirect('bc_permiso/revision');
    	}
    	$elementos = array(
    			'id_permiso' => $this->request->getPost("id_permiso"),
    			'estado' => $this->request->getPost("estado")
    	);
    	$db = $this->getDI()->getDb();
    	$sql = $this->conversiones->multipleupdate("bc_permiso", $elementos, "id_permiso");
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("bc_permiso/revision");
    	}
    	if($this->request->getPost("observacion") == NULL){
    		$observacion = "";
    	} else {
    		$observacion = $this->request->getPost("observacion");
    	}

    	$elementos = array(
    			'id_permiso' => $this->request->getPost("id_permiso"),
    			'estado' => $this->request->getPost("estado"),
    			'id_usuario' => $this->id_usuario,
    			'fechahora' => date("Y-m-d H:i:s"),
    			'observacion' => $observacion
    	);
    	$sql = $this->conversiones->multipleinsert("bc_permiso_observacion", $elementos);
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("bc_permiso/revision");
    	}
    	$this->flash->success("Los permisos fueron modificados exitosamente");
    	return $this->response->redirect('bc_permiso/revision');
    }

		/**
		 *
		 * Lista de los reportes generados de acuerdo a la aprobación de permisos
		 *
		 */
		 public function reportesAction(){
				$permisos = BcPermiso::find(array("fechaAprobacion IS NOT NULL AND fechaAprobacion != '0000-00-00' AND (categoria > 1 AND categoria < 5)", "group" => "fechaAprobacion", "order" => "fechaAprobacion ASC"));
				if (count($permisos) == 0) {
	    		$this->flash->notice("Hasta el momento no se han aprobado permisos");
	    		$permisos = null;
	    	}
				$this->assets
	    	->addJs('js/parsley.min.js')
	    	->addJs('js/parsley.extend.js')
	    	->addJs('js/picnet.table.filter.min.js')
	    	->addJs('js/permisos_lista.js');
	    	$this->view->permisos = $permisos;
		 }

		 /**
 		 *
 		 * Reporte de permisos aprobados para una fecha determinada
 		 *
 		 */
 		 public function reporteAction($fecha){
 			 	if(!$fecha){
  				$fecha = date("Y-m-d");
  			}
 				$permisos = BcPermiso::find(array("estado = 2 AND (categoria > 1 AND categoria < 5) AND fechaAprobacion = '$fecha'", "order" => "id_oferente ASC"));
 				if (count($permisos) == 0) {
 	    		$this->flash->notice("No se aprobaron permisos para este día");
 	    		$permisos = null;
 	    	}
 				$this->view->titulo = $this->conversiones->fecha(4, $fecha);
 	    	$this->view->permisos = $permisos;
				$this->view->fecha = $fecha;
 		 }
}
