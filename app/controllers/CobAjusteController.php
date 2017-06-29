<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CobAjusteController extends ControllerBase
{
	public $user;
    public function initialize()
    {
        $this->tag->setTitle("Ajustes");
        $this->user = $this->session->get('auth');
        parent::initialize();
    }

    /**
     * index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
        $cob_ajuste_periodo = CobAjuste::find(["ajusteDentroPeriodo = 1", "group" => "fecha_ajuste_reportado"]);
        $cob_ajuste_noasignados = CobAjuste::find(["(ajusteDentroPeriodo IS NULL OR ajusteDentroPeriodo = 0) AND (fecha_ajuste_reportado IS NULL OR fecha_ajuste_reportado = '0000-00-00')"]);
        $cob_ajuste_reporte = CobAjuste::find(["(ajusteDentroPeriodo IS NULL OR ajusteDentroPeriodo = 0) AND (fecha_ajuste_reportado IS NOT NULL OR fecha_ajuste_reportado != '0000-00-00')", "group" => "fecha_ajuste_reportado"]);
        $this->assets
        ->addJs('js/multifilter.min.js');
        $this->view->nivel = $this->user['nivel'];
        $this->view->cob_ajuste_periodo = $cob_ajuste_periodo;
        $this->view->cob_ajuste_reporte = $cob_ajuste_reporte;
        $this->view->cob_ajuste_noasignados = $cob_ajuste_noasignados;
    }

    /**
     * reporte action
     */
    public function reporteAction($fecha)
    {
    	$cob_ajuste = CobAjuste::find(["(ajusteDentroPeriodo IS NULL OR ajusteDentroPeriodo = 0) AND fecha_ajuste_reportado = '$fecha'"]);
    	if (!$cob_ajuste) {
    		$this->flash->error("No se encontraron ajustes");

    		return $this->response->redirect("cob_ajuste/");
    	}
    	$this->assets
    	->addJs('js/multifilter.min.js');
    	$this->view->nivel = $this->user['nivel'];
    	$this->view->cob_ajuste = $cob_ajuste;
    	$this->view->h1 = "Ajustes Fuera del Periodo <small>Fecha Reporte ".$this->conversiones->fecha(3, $fecha)."</small>";
    	$this->view->pick('cob_ajuste/lista');
    }

    /**
     * noasignados action
     */
    public function noasignadosAction($fecha)
    {
    	$cob_ajuste = CobAjuste::find(["(ajusteDentroPeriodo IS NULL OR ajusteDentroPeriodo = 0) AND (fecha_ajuste_reportado IS NULL OR fecha_ajuste_reportado = '0000-00-00')"]);
    	if (!$cob_ajuste) {
    		$this->flash->error("No se encontraron ajustes");

    		return $this->response->redirect("cob_ajuste/");
    	}
    	$this->assets
    	->addJs('js/multifilter.min.js');
    	$this->view->nivel = $this->user['nivel'];
    	$this->view->cob_ajuste = $cob_ajuste;
    	$this->view->h1 = "Ajustes No Asignados";
    	$this->view->pick('cob_ajuste/lista');
    }

    /**
     * periodo action
     */
    public function periodoAction($id_periodo)
    {
    	$cob_ajuste = CobAjuste::find(["ajusteDentroPeriodo = 1 AND id_periodo = '$id_periodo'"]);
    	if (!$cob_ajuste) {
    		$this->flash->error("No se encontraron ajustes");

    		return $this->response->redirect("cob_ajuste/");
    	}
    	$this->assets
    	->addJs('js/multifilter.min.js');
    	$this->view->nivel = $this->user['nivel'];
    	$this->view->cob_ajuste = $cob_ajuste;
    	$this->view->h1 = "Ajustes Dentro del Periodo <small>".$cob_ajuste[0]->CobPeriodo->getFechaDetail()." - ".$cob_ajuste[0]->CobPeriodo->getTipoperiodoDetail()."</small>";
    	$this->view->pick('cob_ajuste/lista');
    }

    /**
     * Formulario para buscar
     */
    public function buscarAction()
    {
    	$this->persistent->parameters = null;
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js');
    	$this->view->periodos = CobPeriodo::find(['order' => 'fecha DESC']);
    }

    /**
     * Formulario para agregar fecha de reporte a los ajustes
     */
    public function asignarAction()
    {
    	$this->persistent->parameters = null;
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js');
    	$this->view->ajustes = CobAjuste::find(["(id_ajuste_reportado IS NULL OR id_ajuste_reportado = 0) AND (ajusteDentroPeriodo = 0 OR ajusteDentroPeriodo IS NULL) AND (certificar = 3 OR certificar = 4)", 'order' => 'datetime DESC']);
    	$this->view->fechas = CobAjusteReportado::find(["estado = 1", 'order' => 'fecha DESC']);
    }

    /**
     * Formulario para agregar ajustes a un periodo antes de la fecha de facturación
     */
    public function asignarperiodoAction($fecha_ajuste_reportado)
    {
    	$this->persistent->parameters = null;
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js');
    	$sql_periodos = CobPeriodo::find(["fecha = '$fecha_ajuste_reportado'", "group" => "id_periodo"]);
    	$periodos = array();
    	foreach($sql_periodos as $row){
    		$periodos[] = $row->id_periodo;
    	}
    	$periodos = implode(', ', $periodos);
    	$cob_ajuste = CobAjuste::find(["(fecha_ajuste_reportado IS NULL OR fecha_ajuste_reportado = '0000-00-00') AND (ajusteDentroPeriodo = 0 OR ajusteDentroPeriodo IS NULL) AND (certificar = 3 OR certificar = 4) AND (id_periodo IN ($periodos))", 'order' => 'datetime DESC']);
    	if (count($cob_ajuste) == 0) {
    		$this->flash->error("No existen ajustes disponibles para ser asignados");
    		return $this->response->redirect("cob_ajuste/index");
    	}
    	$this->view->ajustes = $cob_ajuste;
    }

    /**
     * Lista de periodos
     */
    public function asignarperiodosAction()
    {
    	$this->persistent->parameters = null;
    	$this->assets
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js');

    	$cob_ajuste = CobAjuste::find(["(fecha_ajuste_reportado IS NULL OR fecha_ajuste_reportado = '0000-00-00') AND (ajusteDentroPeriodo = 0 OR ajusteDentroPeriodo IS NULL) AND (certificar = 3 OR certificar = 4)", 'order' => 'datetime DESC', 'group' => 'id_periodo']);
    	if (count($cob_ajuste) == 0) {
    		$this->flash->error("No existen ajustes disponibles para ser asignados");
    		return $this->response->redirect("cob_ajuste/index");
    	}
    	$this->view->ajustes = $cob_ajuste;
    }

    /**
     * Formulario para agregar fecha de reporte
     */
    public function nuevafechareporteAction()
    {
    	$this->view->fechas = CobAjusteReportado::find(['order' => 'fecha DESC']);
    }

    /**
     * Guarda el fecha de reporte
     *
     */
    public function guardarfechareporteAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_ajuste/nuevafechareporte");
    	}
    	$cob_ajuste_reporte = new CobAjusteReportado();
    	$cob_ajuste_reporte->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
    	$cob_ajuste_reporte->estado = 1;

    	if (!$cob_ajuste_reporte->save()) {
    		foreach ($cob_ajuste_reporte->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_ajuste/nuevafechareporte");
    	}
    	$this->flash->success("La fecha de reporte fue creada exitosamente.");
    	return $this->response->redirect("cob_ajuste/nuevafechareporte");
    }

    /**
     * Elimina una fecha de reporte
     *
     * @param int $id_periodo
     */
    public function eliminarfechareporteAction($id_ajuste_reportado)
    {
    	$cob_ajuste_reportado = CobAjusteReportado::findFirstByid_ajuste_reportado($id_ajuste_reportado);
    	if (!$cob_ajuste_reportado) {
    		$this->flash->error("La fecha no fue encontrada");

    		return $this->response->redirect("cob_ajuste/nuevafechareporte");
    	}
    	if (!$cob_ajuste_reportado->delete()) {
    		foreach ($cob_ajuste_reportado->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_ajuste/nuevafechareporte");
    	}
    	$this->flash->success("La fecha fue eliminada correctamente");
    	return $this->response->redirect("cob_ajuste/nuevafechareporte");
    }

    /**
     * Deshabilita una fecha de reporte
     *
     * @param int $id_periodo
     */
    public function deshabilitarfechareporteAction($id_ajuste_reportado)
    {
    	$cob_ajuste_reportado = CobAjusteReportado::findFirstByid_ajuste_reportado($id_ajuste_reportado);
    	if (!$cob_ajuste_reportado) {
    		$this->flash->error("La fecha no fue encontrada");

    		return $this->response->redirect("cob_ajuste/nuevafechareporte");
    	}
    	$cob_ajuste_reportado->estado = 2;
    	if (!$cob_ajuste_reportado->save()) {

    		foreach ($cob_ajuste_reportado->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_ajuste/nuevafechareporte");
    	}
    	$this->flash->success("La fecha fue deshabilitada correctamente");
    	return $this->response->redirect("cob_ajuste/nuevafechareporte");
    }

    /**
     * Habilita una fecha de reporte
     *
     * @param int $id_periodo
     */
    public function habilitarfechareporteAction($id_ajuste_reportado)
    {
    	$cob_ajuste_reportado = CobAjusteReportado::findFirstByid_ajuste_reportado($id_ajuste_reportado);
    	if (!$cob_ajuste_reportado) {
    		$this->flash->error("La fecha no fue encontrada");

    		return $this->response->redirect("cob_ajuste/nuevafechareporte");
    	}
    	$cob_ajuste_reportado->estado = 1;
    	if (!$cob_ajuste_reportado->save()) {

    		foreach ($cob_ajuste_reportado->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_ajuste/nuevafechareporte");
    	}
    	$this->flash->success("La fecha fue habilitada correctamente");
    	return $this->response->redirect("cob_ajuste/nuevafechareporte");
    }

    /**
     * Reportes de los ajustes
     */
    public function reportesAction()
    {
    	$this->view->fechas = CobAjuste::find(["id_ajuste_reportado IS NOT NULL", 'order' => 'id_ajuste_reportado DESC', 'group' => 'id_periodo, id_ajuste_reportado']);
    }

    /**
     * Reportes sedes de los ajustes
     */
    public function reportesedesAction($id_ajuste_reportado, $id_periodo, $tipo)
    {
    	$cob_ajuste = CobAjuste::find(array("id_ajuste_reportado = $id_ajuste_reportado AND id_periodo = $id_periodo", "group" => "id_sede_contrato"));
    	if (count($cob_ajuste) == 0) {
    		$this->flash->error("No se encontraron ajustes con esta fecha de reporte");
    		return $this->response->redirect("cob_ajuste/reportes");
    	}
    	$this->view->cob_ajuste = $cob_ajuste;
    	if($tipo == 1){
    		$this->view->setTemplateAfter('../cob_ajuste/rpt_sedes_general');
    	} else if($tipo == 3) {
    		$this->view->setTemplateAfter('../cob_ajuste/rpt_sedes_comunitario');
    	} else if($tipo == 4) {
    		$this->view->setTemplateAfter('../cob_ajuste/rpt_sedes_itinerante');
    	} else if($tipo == 5) {
    		$this->view->setTemplateAfter('../cob_ajuste/rpt_sedes_jardines');
    	}
    }

    /**
     * Reportes contratos de los ajustes
     */
    public function reportecontratosAction($id_ajuste_reportado, $id_periodo, $tipo)
    {
    	$cob_ajuste = CobAjuste::find(array("id_ajuste_reportado = $id_ajuste_reportado AND id_periodo = $id_periodo", "group" => "id_contrato"));
    	if (count($cob_ajuste) == 0) {
    		$this->flash->error("No se encontraron ajustes con esta fecha de reporte");
    		return $this->response->redirect("cob_ajuste/reportes");
    	}
    	$this->view->cob_ajuste = $cob_ajuste;
    	if($tipo == 1){
    		$this->view->setTemplateAfter('../cob_ajuste/rpt_contratos_general');
    	} else if($tipo == 3) {
    		$this->view->setTemplateAfter('../cob_ajuste/rpt_contratos_comunitario');
    	} else if($tipo == 4) {
    		$this->view->setTemplateAfter('../cob_ajuste/rpt_contratos_itinerante');
    	} else if($tipo == 5) {
    		$this->view->setTemplateAfter('../cob_ajuste/rpt_contratos_jardines');
    	}
    }

    /**
     * Reportes contratos de los ajustes
     */
    public function reportebeneficiarioscontratoAction($fecha_ajuste_reportado, $id_periodo, $id_contrato)
    {
    	$cob_ajuste = CobAjuste::find(array("fecha_ajuste_reportado = '$fecha_ajuste_reportado' AND id_periodo = $id_periodo AND id_contrato = $id_contrato AND (certificar = 3 OR certificar = 4)"));
    	if (count($cob_ajuste) == 0) {
    		$this->flash->error("No se encontraron ajustes con esta fecha de reporte");
    		return $this->response->redirect("bc_reporte/beneficiarios_contratoajustes/$id_periodo/$id_contrato");
    	}
    	$this->view->cob_ajuste = $cob_ajuste;
    	$this->view->fecha = $cob_ajuste[0]->fecha_ajuste_reportado;
    	$this->view->contrato = $cob_ajuste[0]->CobActaconteo;
    	$this->view->periodo = $cob_ajuste[0]->CobPeriodo;
    }

    /**
     * Formulario para creación
     */
    public function nuevoAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_ajuste/buscar");
    	}
    	$id_periodo = $this->request->getPost("id_periodo");
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no existe ");
    		return $this->response->redirect("cob_ajuste/buscar");
    	}
    	$id_contrato = $this->request->getPost("id_contrato");
    	$numDocumento = $this->request->getPost("numDocumento");
    	$beneficiario = CobActaconteoPersonaFacturacion::findFirst(array("id_periodo = $id_periodo AND id_contrato = $id_contrato AND numDocumento = $numDocumento"));
    	if (!$beneficiario) {
    		$this->flash->error("El beneficiario con número de documento <strong>$numDocumento</strong> no fue encontrado en el contrato <strong>$id_contrato</strong> para el periodo <strong>$cob_periodo->fecha</strong>");
    		return $this->response->redirect("cob_ajuste/buscar");
    	}
    	$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> Por favor, antes de ingresar la información verifique que el ajuste corresponde al periodo y la información del beneficiario.");
    	$this->assets
    	->addJs('js/ajuste.js')
    	->addJs('js/parsley.min.js')
    	->addJs('js/parsley.extend.js');
    	$acta = CobActaconteo::findFirst(array("id_periodo = $id_periodo AND id_sede_contrato = $beneficiario->id_sede_contrato"));
    	$this->view->sino = CobAjuste::CertificarSelect();
    	$this->view->acta = $acta;
    	$this->view->periodo = $this->conversiones->fecha(5, $cob_periodo->fecha);
    	$this->view->beneficiario = $beneficiario;
    }

    /**
     * Guardar asignación de ajustes a fecha
     */
    public function guardarasignarAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_ajuste/asignar");
    	}
    	$fechas = $this->request->getPost("fechaReportado");
    	$id_ajuste_reportado = array();
    	$fecha_ajuste_reportado = array();
    	foreach($fechas as $row){
    		$fecha = explode("x", $row);
    		$id_ajuste_reportado[] = $fecha[0];
    		$fecha_ajuste_reportado[] = $fecha[1];
    	}
    	$elementos = array(
    			'id_ajuste' => $this->request->getPost("id_ajuste"),
    			'id_ajuste_reportado' => $id_ajuste_reportado,
    			'fecha_ajuste_reportado' => $fecha_ajuste_reportado
    	);
    	$sql = $this->conversiones->multipleupdate("cob_ajuste", $elementos, "id_ajuste");
    	$db = $this->getDI()->getDb();
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_ajuste/asignar");
    	}
    	$this->flash->success("Las fechas de reporte han sido actualizadas correctamente");
    	return $this->response->redirect("cob_ajuste");
    }

    /**
     * Guardar asignación de ajustes a periodo
     */
    public function guardarasignarperiodoAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_ajuste/asignar");
    	}
    	$elementos = array(
    			'id_ajuste' => $this->request->getPost("id_ajuste"),
    			'fecha_ajuste_reportado' => $this->request->getPost("fecha_ajuste_reportado"),
    			'ajusteDentroPeriodo' => $this->request->getPost("ajusteDentroPeriodo")
    	);
    	$sql = $this->conversiones->multipleupdate("cob_ajuste", $elementos, "id_ajuste");
    	$db = $this->getDI()->getDb();
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_ajuste/asignar");
    	}
    	$elementos = array(
    			'id_actaconteo_persona_facturacion' => $this->request->getPost("id_actaconteo_persona_facturacion"),
    			'certificacionFacturacion' => $this->request->getPost("certificacionFacturacion"),
    			'certificacionLiquidacion' => $this->request->getPost("certificacionFacturacion"),
    			'asistenciaFinalFacturacion' => $this->request->getPost("asistenciaFinalFacturacion")
    	);
    	$sql = $this->conversiones->multipleupdate("cob_actaconteo_persona_facturacion", $elementos, "id_actaconteo_persona_facturacion");
    	$db = $this->getDI()->getDb();
    	$query = $db->query($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_ajuste/asignar");
    	}
    	$this->flash->success("Los ajustes han sido asignados al periodo correctamente");
    	return $this->response->redirect("cob_ajuste");
    }

    /**
     * Guardar ajuste
     */
    public function guardarAction($id_actaconteo_persona_facturacion)
    {
    	$beneficiario = CobActaconteoPersonaFacturacion::findFirstByid_actaconteo_persona_facturacion($id_actaconteo_persona_facturacion);
    	if (!$beneficiario) {
    		$this->flash->error("La persona no fue encontrada");
    		return $this->response->redirect("cob_ajuste/buscar");    	}
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_ajuste/buscar");
    	}
    	if($beneficiario->certificacionLiquidacion == 1 && $this->request->getPost("certificar") == 1){
    		$this->flash->error("El beneficiario ya se encuentra certificado, por lo tanto no puede volver a certificarlo");
    		return $this->response->redirect("cob_ajuste/nuevo/$id_actaconteo_persona_facturacion");
    	} else if(($beneficiario->certificacionLiquidacion == 2 || $beneficiario->certificacionLiquidacion == 3) && $this->request->getPost("certificar") == 3){
    		$this->flash->error("El beneficiario ya se encuentra en estado de 'No certificar', por lo tanto no puede descontarse.");
    		return $this->response->redirect("cob_ajuste/nuevo/$id_actaconteo_persona_facturacion");
    	}
    	$ajuste = new CobAjuste();
    	$ajuste->id_periodo = $beneficiario->id_periodo;
    	$ajuste->id_sede_contrato = $beneficiario->id_sede_contrato;
    	$ajuste->id_contrato = $beneficiario->id_contrato;
    	$ajuste->id_actaconteo_persona_facturacion = $id_actaconteo_persona_facturacion;
    	$certificar = $this->request->getPost("certificar");
    	$ajuste->certificar = $certificar;
    	$ajuste->datetime = date('Y-m-d H:i:s');
    	$ajuste->observacion = $this->request->getPost("observacion");
    	$ajuste->radicado = $this->request->getPost("radicado");
    	$ajuste->id_usuario = $this->user['id_usuario'];
    	if (!$ajuste->save()) {
    		foreach ($ajuste->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_ajuste/nuevo/$id_actaconteo_persona_facturacion");
    	}
    	if($certificar != 5){
    		$ninofac = CobActaconteoPersonaFacturacion::findFirstByid_actaconteo_persona_facturacion($id_actaconteo_persona_facturacion);
    		if (!$ninofac) {
    			$this->flash->error("El niño no existe en la base de datos de facturación pero sí se guardó el ajuste, favor informar esto al administrador inmediatamente");
    			return $this->response->redirect("cob_ajuste");
    		}
    		$ninofac->certificacionLiquidacion = $certificar;
    		if (!$ninofac->save()) {
    			foreach ($ninofac->getMessages() as $message) {
    				$this->flash->error($message);
    			}
    			return $this->response->redirect("cob_ajuste");
    		}
    	}
    	$this->flash->success("El ajuste fue realizado exitosamente.");
    	return $this->response->redirect("cob_ajuste/buscar");
    }

    /**
     * Elimina un ajuste
     *
     * @param int $id_ajuste
     */
    public function eliminarAction($id_ajuste)
    {
    	$nivel = $this->user['nivel'];
    	if($nivel <= 1){
    		$cob_ajuste = CobAjuste::findFirstByid_ajuste($id_ajuste);
    		if (!$cob_ajuste) {
    			$this->flash->error("El ajuste no fue encontrado");
    			return $this->response->redirect("cob_ajuste/");
    		}
    		if($cob_ajuste->fecha_ajuste_reportado != NULL){
    			$this->flash->error("El ajuste no puede ser eliminado porque ya fue reportado, si desea cambiar el estado de certificación debe de agregar el ajuste nuevamente.");
    			return $this->response->redirect("cob_ajuste/");
    		}
    		$id_actaconteo_persona_facturacion = $cob_ajuste->id_actaconteo_persona_facturacion;
    		if (!$cob_ajuste->delete()) {
    			foreach ($cob_ajuste->getMessages() as $message) {
    				$this->flash->error($message);
    			}
    			return $this->response->redirect("cob_ajuste/");
    		}
    		$ajuste_anterior = CobAjuste::find(["id_ajuste != $id_ajuste AND id_actaconteo_persona_facturacion = $id_actaconteo_persona_facturacion AND (certificar = 3 OR certificar = 4)", 'order' => 'id_ajuste DESC'])->toArray();
    		$ninofac = CobActaconteoPersonaFacturacion::findFirstByid_actaconteo_persona_facturacion($id_actaconteo_persona_facturacion);
    		if (count($ajuste_anterior) > 0) {
    			$certificar = $ajuste_anterior[0]['certificar'];
    		} else {
    			if (!$ninofac) {
    				$this->flash->error("El niño no existe en la base de datos de facturación pero el ajuste fue eliminado, favor informar esto al administrador inmediatamente");
    				return $this->response->redirect("cob_ajuste");
    			}
    			$certificar = $ninofac->certificacionFacturacion;
    		}
    		$ninofac->certificacionLiquidacion = $certificar;
    		if (!$ninofac->save()) {
    			foreach ($ninofac->getMessages() as $message) {
    				$this->flash->error($message);
    			}
    			return $this->response->redirect("cob_ajuste");
    		}
    		$this->flash->success("El ajuste fue eliminado correctamente");
    		return $this->response->redirect("cob_ajuste/");
    	} else {
    		$this->flash->error("Usted no tiene permisos para eliminar ajustes.");
    		return $this->response->redirect("cob_ajuste/");
    	}

    }

}
