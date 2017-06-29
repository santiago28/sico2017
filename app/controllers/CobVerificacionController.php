<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CobVerificacionController extends ControllerBase
{
	public $user;
    public function initialize()
    {
        $this->tag->setTitle("Verificaciones");
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
        $cob_verificacion = CobVerificacion::find(['order' => 'fecha, tipo asc']);
        if (count($cob_verificacion) == 0) {
            $this->flash->notice("No se ha agregado ninguna verificación hasta el momento");
            $cob_verificacion = null;
        }
        $this->view->nivel = $this->user['nivel'];
        $this->view->cob_verificacion = $cob_verificacion;
    }

    /**
     * Formulario para creación
     */
    public function nuevoAction()
    {
    	$modalidades = BcModalidad::find();
			$this->view->meses = MatrizEjecucionRh::find(['group' => 'id_mes', 'order' => 'id_mes DESC']);
    	$this->view->modalidades = $modalidades;
    	$this->view->cargas = BcCarga::find(['order' => 'fecha DESC']);
    }

    /**
     * Ver
     *
     * @param int $id_periodo
     */
    public function verAction($id_verificacion)
    {
    	$cob_verificacion = CobVerificacion::findFirstByid_verificacion($id_verificacion);
    	if (!$cob_verificacion) {
    		$this->flash->error("La verificacion no fue encontrada");
    		return $this->response->redirect("cob_periodo/");
    	}
			if($cob_verificacion->tipo == 5) {
    		$actas = CobActafocalizacion::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    	}
      else if($cob_verificacion->tipo == 4 || $cob_verificacion->tipo == 6) {
    		$actas = CobActath::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    	}
    	else if($cob_verificacion->tipo == 3) {
    		$actas = CobActatelefonica::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    	}
    	else if($cob_verificacion->tipo == 2) {
    		$actas = CobActacomputo::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    	} else if($cob_verificacion->tipo == 1) {
    		$actas = CobActadocumentacion::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    	}
    	$this->assets
    	->addJs('js/jquery.tablesorter.min.js')
    	->addJs('js/jquery.tablesorter.widgets.js')
    	->addJs('js/filtrar.js');
    	$this->view->id_usuario = $this->id_usuario;
    	$this->view->verificacion = $cob_verificacion;
    	$this->view->id_verificacion = $id_verificacion;
    	$this->view->actas = $actas;
    	$this->view->nivel = $this->user['nivel'];
    }

    /**
     * Editar
     *
     * @param int $id_periodo
     */
    public function editarAction($id_verificacion)
    {
        if (!$this->request->isPost()) {

            $cob_verificacion = CobVerificacion::findFirstByid_verificacion($id_verificacion);
            if (!$cob_verificacion) {
                $this->flash->error("La verificacion no fue encontrada");

                return $this->response->redirect("cob_verificacion/");
            }
            $this->assets
            ->addJs('js/parsley.min.js')
            ->addJs('js/parsley.extend.js');
            $this->view->id_verificacion = $cob_verificacion->id_verificacion;
            $this->tag->setDefault("id_verificacion", $cob_verificacion->id_verificacion);
            $this->tag->setDefault("nombre", $cob_verificacion->nombre);
            $this->tag->setDefault("fecha", $this->conversiones->fecha(2, $cob_verificacion->fecha));
        }
    }

    /**
     * Creación de una nueva cob_verificacion
     */
    public function crearAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_verificacion/nuevo");
    	}
    	$cob_verificacion = new CobVerificacion();
    	$cob_verificacion->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
    	$tipo = $this->request->getPost("tipo");
    	$cob_verificacion->tipo = $tipo;
    	$cob_verificacion->nombre = $this->request->getPost("nombre");
    	$id_carga = $this->request->getPost("carga");
    	$modalidades = implode(",", $this->request->getPost("modalidad"));
    	$carga = BcCarga::findFirstByid_carga($id_carga);
    	if (!$carga) {
    		$this->flash->error("La carga no existe");
    		return $this->response->redirect("cob_periodo/nuevorecorrido1/$id_periodo");
    	}
    	if (!$cob_verificacion->save()) {
    		foreach ($cob_verificacion->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_verificacion/nuevo");
    	}
    	if($tipo == 1){
    		$actas = CobActadocumentacion::cargarBeneficiarios($carga, $modalidades, $cob_verificacion->id_verificacion);
    		if($actas){
    			$this->flash->success("La verificación fue creada exitosamente.");
    		}
    	} else if ($tipo == 2){
    		$actas = CobActacomputo::cargarBeneficiarios($carga, $modalidades, $cob_verificacion->id_verificacion);
    		if($actas){
    			$this->flash->success("La verificación fue creada exitosamente.");
    		}

    	} else if ($tipo == 3){
    		$actas = CobActatelefonica::cargarBeneficiarios($carga, $modalidades, $cob_verificacion->id_verificacion);
    		if($actas){
    			$this->flash->success("La verificación fue creada exitosamente.");
				}
    	} else if($tipo == 4){
					$id_mes = $this->request->getPost("id_mes");
					$actas = MatrizEjecucionRh::cargarBeneficiarios($cob_verificacion->id_verificacion, $id_mes);
					if($actas){
						$this->flash->success("La verificación fue creada exitosamente.");
					}
			}	else if ($tipo == 5){
					$actas = CobActafocalizacion::cargarBeneficiarios($carga, $cob_verificacion->id_verificacion);
					if($actas){
						$this->flash->success("La verificación fue creada exitosamente.");
					}
			} else if ($tipo == 6){
					$id_mes = $this->request->getPost("id_mes");
					$actas = PersonalContratado::cargarBeneficiarios($cob_verificacion->id_verificacion, $id_mes);
					if($actas){
					$this->flash->success("La verificación fue creada exitosamente.");
					}
    	}
    	return $this->response->redirect("cob_verificacion/");
    }

    /**
     * Guarda el cob_verificacion editado
     *
     */
    public function guardarAction()
    {

        if (!$this->request->isPost()) {
            return $this->response->redirect("cob_verificacion/");
        }

        $id_verificacion = $this->request->getPost("id_verificacion");

        $cob_verificacion = CobVerificacion::findFirstByid_verificacion($id_verificacion);
        if (!$cob_verificacion) {
            $this->flash->error("La verificacion no existe " . $id_verificacion);
            return $this->response->redirect("cob_verificacion/");
        }

        $cob_verificacion->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
        $cob_verificacion->nombre = $this->request->getPost("nombre");


        if (!$cob_verificacion->save()) {

            foreach ($cob_verificacion->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect("cob_verificacion/ver/$id_verificacion");
        }

        $this->flash->success("La verificacion fue actualizada exitosamente");

        return $this->response->redirect("cob_verificacion/");

    }

    /**
     * Elimina un cob_verificacion
     *
     * @param int $id_verificacion
     */
    public function eliminarAction($id_verificacion)
    {
        $cob_verificacion = CobVerificacion::findFirstByid_verificacion($id_verificacion);
        if (!$cob_verificacion) {
            $this->flash->error("La verificacion no fue encontrada");

            return $this->response->redirect("cob_verificacion/");
        }
				$db = $this->getDI()->getDb();
				$db->query("DELETE FROM cob_verificacion WHERE id_verificacion = $id_verificacion");

				if($tipo == 1){
					$db->query("DELETE FROM cob_actadocumentacion WHERE id_verificacion = $id_verificacion");
					$db->query("DELETE FROM cob_actadocumentacion_persona WHERE id_verificacion = $id_verificacion");
	    	} else if ($tipo == 2){
					$db->query("DELETE FROM cob_actacomputo WHERE id_verificacion = $id_verificacion");
	    	} else if ($tipo == 3){
					$db->query("DELETE FROM cob_actatelefonica WHERE id_verificacion = $id_verificacion");
					$db->query("DELETE FROM cob_actatelefonica_persona WHERE id_verificacion = $id_verificacion");
	    	} else if($tipo == 4){
					$db->query("DELETE FROM cob_actath WHERE id_verificacion = $id_verificacion");
					$db->query("DELETE FROM cob_actath_persona WHERE id_verificacion = $id_verificacion");
					$db->query("DELETE FROM cob_actath_persona_listado WHERE id_verificacion = $id_verificacion");
				}	else if ($tipo == 5){
					$db->query("DELETE FROM cob_actafocalizacion WHERE id_verificacion = $id_verificacion");
					$db->query("DELETE FROM cob_actafocalizacion_persona WHERE id_verificacion = $id_verificacion");
				} else if ($tipo == 6){
					$db->query("DELETE FROM cob_actath WHERE id_verificacion = $id_verificacion");
					$db->query("DELETE FROM cob_actath_persona WHERE id_verificacion = $id_verificacion");
					$db->query("DELETE FROM cob_actath_persona_listado WHERE id_verificacion = $id_verificacion");
	    	}
        $this->flash->success("La verificacion fue eliminada correctamente");
        return $this->response->redirect("cob_verificacion/");
    }

    /**
     * Recorrido
     *
     * @param int $id_verificacion
     */
    public function rutearAction($id_verificacion)
    {
    	$cob_verificacion = CobVerificacion::findFirstByid_verificacion($id_verificacion);
    	if (!$cob_verificacion) {
    		$this->flash->error("La verificación no fue encontrada");
    		return $this->response->redirect("cob_periodo/");
    	}
			$this->view->periodos = CobActaconteo::find(['group' => 'id_periodo, recorrido']);
			if($cob_verificacion->tipo == 5) {
    		$actas = CobActafocalizacion::find(array(
    				"id_verificacion = $id_verificacion"
    		));
				$this->view->verificaciones = CobActafocalizacion::find(['group' => 'id_verificacion']);
			} else if($cob_verificacion->tipo == 4 || $cob_verificacion->tipo == 6) {
    		$actas = CobActath::find(array(
    				"id_verificacion = $id_verificacion"
    		));
				$this->view->verificaciones = CobActath::find(['group' => 'id_verificacion']);
			} else if($cob_verificacion->tipo == 3) {
    		$actas = CobActatelefonica::find(array(
    				"id_verificacion = $id_verificacion"
    		));
				$this->view->verificaciones = CobActatelefonica::find(['group' => 'id_verificacion']);
    	} else if($cob_verificacion->tipo == 2) {
    		$actas = CobActacomputo::find(array(
    				"id_verificacion = $id_verificacion"
    		));
				$this->view->verificaciones = CobActacomputo::find(['group' => 'id_verificacion']);
    	} else if($cob_verificacion->tipo == 1) {
    		$actas = CobActadocumentacion::find(array(
    				"id_verificacion = $id_verificacion"
    		));
				$this->view->verificaciones = CobActadocumentacion::find(['group' => 'id_verificacion']);
    	}
    	if (!$actas) {
    		$this->flash->error("No se encontraron actas");
    		return $this->response->redirect("cob_verificacion/");
    	}
    	$this->assets
    	->addJs('js/jquery.tablesorter.min.js')
    	->addJs('js/jquery.tablesorter.widgets.js')
    	->addJs('js/rutear.js');
    	$this->view->periodos = CobActaconteo::find(['group' => 'id_periodo, recorrido']);
    	$this->view->id_verificacion = $cob_verificacion->id_verificacion;
    	$this->view->fecha_periodo = $cob_verificacion->id_verificacion;
    	$this->view->actas = $actas;
    	$this->view->interventores = IbcUsuario::find(['id_usuario_cargo = 3', 'order' => 'usuario asc']);
    }

    /**
     * Guarda el cob_periodo editado
     *
     */
    public function ruteoguardarAction($id_verificacion)
    {

    	if (!$this->request->isPost()) {
    		return $this->response->redirect("/");
    	}
    	$cob_verificacion = CobVerificacion::findFirstByid_verificacion($id_verificacion);
    	if (!$cob_verificacion) {
    		$this->flash->error("La verificación no fue encontrada");
    		return $this->response->redirect("cob_verificacion/");
    	}
			if($cob_verificacion->tipo == 5){
    		$actas = CobActafocalizacion::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    		$db = $this->getDI()->getDb();
    		$estado = array();
    		foreach($this->request->getPost("contador_asignado") as $row){
    			if($row == "NULL")
    				$estado[] = 0;
    			else
    				$estado[] = 1;
    		}
    		$elementos = array(
    				'id_actafocalizacion' => $this->request->getPost("id_acta"),
    				'estado' => $estado,
    				'id_usuario' => $this->request->getPost("contador_asignado")
    		);
    		$sql = $this->conversiones->multipleupdate("cob_actafocalizacion", $elementos, "id_actafocalizacion");
    	} else if($cob_verificacion->tipo == 4 || $cob_verificacion->tipo == 6){
    		$actas = CobActath::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    		$db = $this->getDI()->getDb();
    		$estado = array();
    		foreach($this->request->getPost("contador_asignado") as $row){
    			if($row == "NULL")
    				$estado[] = 0;
    			else
    				$estado[] = 1;
    		}
    		$elementos = array(
    				'id_actath' => $this->request->getPost("id_acta"),
    				'estado' => $estado,
    				'id_usuario' => $this->request->getPost("contador_asignado")
    		);
    		$sql = $this->conversiones->multipleupdate("cob_actath", $elementos, "id_actath");
    	} else if($cob_verificacion->tipo == 3){
    		$actas = CobActatelefonica::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    		$db = $this->getDI()->getDb();
    		$estado = array();
    		foreach($this->request->getPost("contador_asignado") as $row){
    			if($row == "NULL")
    				$estado[] = 0;
    			else
    				$estado[] = 1;
    		}
    		$elementos = array(
    				'id_actatelefonica' => $this->request->getPost("id_acta"),
    				'estado' => $estado,
    				'id_usuario' => $this->request->getPost("contador_asignado")
    		);
    		$sql = $this->conversiones->multipleupdate("cob_actatelefonica", $elementos, "id_actatelefonica");
    	} else  if($cob_verificacion->tipo == 2){
    		$actas = CobActacomputo::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    		$db = $this->getDI()->getDb();
    		$estado = array();
    		foreach($this->request->getPost("contador_asignado") as $row){
    			if($row == "NULL")
    				$estado[] = 0;
    			else
    				$estado[] = 1;
    		}
    		$elementos = array(
    				'id_actacomputo' => $this->request->getPost("id_acta"),
    				'estado' => $estado,
    				'id_usuario' => $this->request->getPost("contador_asignado")
    		);
    		$sql = $this->conversiones->multipleupdate("cob_actacomputo", $elementos, "id_actacomputo");
    	} else if($cob_verificacion->tipo == 1) {
    		$actas = CobActadocumentacion::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    		$db = $this->getDI()->getDb();
    		$estado = array();
    		foreach($this->request->getPost("contador_asignado") as $row){
    			if($row == "NULL")
    				$estado[] = 0;
    			else
    				$estado[] = 1;
    		}
    		$elementos = array(
    				'id_actadocumentacion' => $this->request->getPost("id_acta"),
    				'estado' => $estado,
    				'id_usuario' => $this->request->getPost("contador_asignado")
    		);
    		$sql = $this->conversiones->multipleupdate("cob_actadocumentacion", $elementos, "id_actadocumentacion");
    	}
    	if (!$actas) {
    		$this->flash->error("No se encontraron actas");
    		return $this->response->redirect("cob_verificacion/");
    	}
    	$query = $db->execute($sql);
    	if (!$query) {
    		foreach ($query->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_verificacion/rutear/$id_verificacion");
    	}
    	$this->flash->success("El ruteo fue actualizado exitosamente");
    	return $this->response->redirect("cob_verificacion/rutear/$id_verificacion");
    }

    /**
     * Rutea desde otro recorrido
     *
     */
    public function ruteodesdeotroguardarAction($id_verificacion)
    {

    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_verificacion/rutear/$id_verificacion");
    	}
			$id_verificacion_actualizar = $this->request->getPost("id_periodo_actualizar");
    	$id_periodo_actualizar = $this->request->getPost("id_periodo_actualizar");
    	$recorrido_actualizar = $this->request->getPost("recorrido_actualizar");
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo_actualizar);
    	if($cob_periodo->tipo == 2){
    		$actas = CobActamuestreo::find(array(
    				"id_periodo = $id_periodo_actualizar AND recorrido = $recorrido_actualizar",
    				"group" => "id_actamuestreo"
    		));
    	} else {
    		$actas = CobActaconteo::find(array(
    				"id_periodo = $id_periodo_actualizar AND recorrido = $recorrido_actualizar",
    				"group" => "id_actaconteo"
    		));
    		$tabla_acta = "cob_actaconteo";
    	}
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	if (!$actas) {
    		$this->flash->error("El recorrido no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
			$cob_verificacion = CobVerificacion::findFirstByid_verificacion($id_verificacion);
    	if (!$cob_verificacion) {
    		$this->flash->error("La verificación no fue encontrada");
    		return $this->response->redirect("cob_verificacion/");
    	}
			if($cob_verificacion->tipo == 5){
				$tabla = "cob_actafocalizacion";
			} else if($cob_verificacion->tipo == 4 || $cob_verificacion->tipo == 6){
				$tabla = "cob_actath";
			} else if($cob_verificacion->tipo == 3){
				$tabla = "cob_actatelefonica";
			} else  if($cob_verificacion->tipo == 2){
				$tabla = "cob_actacomputo";
			} else if($cob_verificacion->tipo == 1) {
				$tabla = "cob_actadocumentacion";
			}
    	$db = $this->getDI()->getDb();
    	foreach($actas as $row){
    		$id_usuario = $row->id_usuario;
    		$id_contrato = $row->id_contrato;
    		$id_sede = $row->id_sede;
    		$query = $db->execute("UPDATE $tabla SET id_usuario = $id_usuario WHERE id_verificacion = $id_verificacion AND id_contrato = $id_contrato AND id_sede = $id_sede");
    	}
    	$this->flash->success("El ruteo fue actualizado exitosamente");
    	return $this->response->redirect("cob_verificacion/rutear/$id_verificacion");
    }
		/**
     * Rutea desde otro recorrido
     *
     */
    public function ruteodesdeotroverificacionguardarAction($id_verificacion)
    {

    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_verificacion/rutear/$id_verificacion");
    	}
			$id_verificacion_actualizar = $this->request->getPost("id_periodo_actualizar");
    	$cob_verificacion = CobVerificacion::findFirstByid_periodo($id_verificacion_actualizar);
			if($cob_verificacion->tipo == 5) {
    		$actas = CobActafocalizacion::find(array(
    				"id_verificacion = $id_verificacion"
    		));
				$tabla = "cob_actafocalizacion";
			} else if($cob_verificacion->tipo == 4 || $cob_verificacion->tipo == 6) {
    		$actas = CobActath::find(array(
    				"id_verificacion = $id_verificacion"
    		));
				$tabla = "cob_actath";
			} else if($cob_verificacion->tipo == 3) {
    		$actas = CobActatelefonica::find(array(
    				"id_verificacion = $id_verificacion"
    		));
				$tabla = "cob_actatelefonica";
    	} else if($cob_verificacion->tipo == 2) {
    		$actas = CobActacomputo::find(array(
    				"id_verificacion = $id_verificacion"
    		));
				$tabla = "cob_actacomputo";
    	} else if($cob_verificacion->tipo == 1) {
    		$actas = CobActadocumentacion::find(array(
    				"id_verificacion = $id_verificacion"
    		));
				$tabla = "cob_actadocumentacion";
    	}
    	if (!$cob_verificacion) {
    		$this->flash->error("La verificacion no fue encontrada");
    		return $this->response->redirect("cob_periodo/");
    	}
    	if (!$actas) {
    		$this->flash->error("No se encontraron actas asignadas");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$db = $this->getDI()->getDb();
    	foreach($actas as $row){
    		$id_usuario = $row->id_usuario;
    		$id_contrato = $row->id_contrato;
    		$id_sede = $row->id_sede;
    		$query = $db->execute("UPDATE $tabla SET id_usuario = $id_usuario WHERE id_verificacion = $id_verificacion AND id_contrato = $id_contrato AND id_sede = $id_sede");
    	}
    	$this->flash->success("El ruteo fue actualizado exitosamente");
    	return $this->response->redirect("cob_verificacion/rutear/$id_verificacion");
    }

    /**
     * Recorrido
     *
     * @param int $id_periodo
     * @param int $recorrido
     */
    public function gdocumentalAction($id_verificacion)
    {
    	$cob_verificacion = CobVerificacion::findFirstByid_verificacion($id_verificacion);
    	if (!$cob_verificacion) {
    		$this->flash->error("La verificación no fue encontrada");
    		return $this->response->redirect("cob_verificacion/");
    	}
			if($cob_verificacion->tipo == 5){
    		$actas = CobActafocalizacion::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    	} else if($cob_verificacion->tipo == 4 || $cob_verificacion->tipo == 6){
    		$actas = CobActath::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    	} else if($cob_verificacion->tipo == 3){
    		$actas = CobActatelefonica::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    	} else if($cob_verificacion->tipo == 2){
    		$actas = CobActacomputo::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    	} else if($cob_verificacion->tipo == 1) {
    		$actas = CobActadocumentacion::find(array(
    				"id_verificacion = $id_verificacion"
    		));
    	}
    	if (!$actas) {
    		$this->flash->error("No se encontraron actas");
    		return $this->response->redirect("cob_verificacion/");
    	}
    	$this->assets
    	->addJs('js/jquery.tablesorter.min.js')
    	->addJs('js/jquery.tablesorter.widgets.js')
    	->addJs('js/recorrido.js');
    	$this->view->id_verificacion = $id_verificacion;
    	$this->view->id_usuario = $this->id_usuario;
    	$this->view->fecha_verificacion = $cob_verificacion->fecha;
    	$this->view->actas = $actas;
    	$this->view->nivel = $this->user['nivel'];
    }

}
