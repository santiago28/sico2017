<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CobPeriodoController extends ControllerBase
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
        $cob_periodo = CobPeriodo::find(['order' => 'fecha, tipo asc']);
        if (count($cob_periodo) == 0) {
            $this->flash->notice("No se ha agregado ningún periodo hasta el momento");
            $cob_periodo = null;
        }
        $this->view->nivel = $this->user['nivel'];
        $this->view->cob_periodo = $cob_periodo;
    }

    /**
     * Formulario para creación
     */
    public function nuevoAction()
    {

    }

    /**
     * Ver
     *
     * @param int $id_periodo
     */
    public function verAction($id_periodo)
    {
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
		//Daniel Gallo 27/02/2017 18:31
    	/*if($cob_periodo->tipo == 2) {
    		$recorridos = CobActamuestreo::find(array(
    				"id_periodo = $id_periodo",
    				"group" => "recorrido"
    		));
        $this->view->pick("cob_periodo/vermetro");
    	} else {*/
    		$recorridos = CobActaconteo::find(array(
    				"id_periodo = $id_periodo",
    				"group" => "recorrido"
    		));
        $this->view->fecha_cierre = $cob_periodo->fechaCierre;
      	$this->view->id_facturacion = $cob_periodo->id_carga_facturacion;
    	//}
      $this->view->crear_recorrido = count($recorridos) + 1;
      $this->view->recorridos = $recorridos;
    	$this->view->id_periodo = $cob_periodo->id_periodo;
    	$this->view->fecha_periodo = $cob_periodo->getFechaDetail();
    	$this->view->nivel = $this->user['nivel'];
    }

    /**
     * Recorrido
     *
     * @param int $id_periodo
     * @param int $recorrido
     */
    public function recorridoAction($id_periodo, $recorrido)
    {
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
		//Daniel Gallo 27/02/2017 - quitar condicional
    	/*if($cob_periodo->tipo == 2){
    		$actas_recorrido = CobActamuestreo::find(array(
    				"id_periodo = $id_periodo AND recorrido = $recorrido",
    				"group" => "id_actamuestreo"
    		));
    		$titulo = "Actas de Muestreo <small><span class='label label-danger'>Recorrido $recorrido</span></small>";
    	} else {*/
    		$actas_recorrido = CobActaconteo::find(array(
    				"id_periodo = $id_periodo AND recorrido = $recorrido",
    				"group" => "id_actaconteo"
    		));
    		$titulo = "Actas de Conteo <small><span class='label label-danger'>Recorrido $recorrido</span></small>";
    	//}
    	if (!$recorrido) {
    		$this->flash->error("El recorrido no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}

    	$this->assets
    	->addJs('js/jquery.tablesorter.min.js')
    	->addJs('js/jquery.tablesorter.widgets.js')
    	->addJs('js/recorrido.js');
    	$this->view->id_periodo = $cob_periodo->id_periodo;
    	$this->view->id_usuario = $this->id_usuario;
    	$this->view->recorrido = $recorrido;
			$this->view->cob_periodo = $cob_periodo;
    	$this->view->titulo = $titulo;
    	$this->view->fecha_periodo = $cob_periodo->id_periodo;
    	$this->view->actas = $actas_recorrido;
    	$this->view->nivel = $this->user['nivel'];
    }

    /**
     * Recorrido
     *
     * @param int $id_periodo
     * @param int $recorrido
     */
    public function gdocumentalAction($id_periodo, $recorrido)
    {
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	if($cob_periodo->tipo == 2){
    		$actas_recorrido = CobActamuestreo::find(array(
    				"id_periodo = $id_periodo AND recorrido = $recorrido",
    				"group" => "id_actamuestreo"
    		));
    	} else {
    		$actas_recorrido = CobActaconteo::find(array(
    				"id_periodo = $id_periodo AND recorrido = $recorrido",
    				"group" => "id_actaconteo"
    		));
    	}
    	if (!$recorrido) {
    		$this->flash->error("El recorrido no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$this->assets
    	->addJs('js/jquery.tablesorter.min.js')
    	->addJs('js/jquery.tablesorter.widgets.js')
    	->addJs('js/recorrido.js');
    	$this->view->id_periodo = $cob_periodo->id_periodo;
    	$this->view->id_usuario = $this->id_usuario;
    	$this->view->recorrido = $recorrido;
    	$this->view->fecha_periodo = $cob_periodo->fecha;
    	$this->view->actas = $actas_recorrido;
    	$this->view->nivel = $this->user['nivel'];
    }

    /**
     * Recorrido
     *
     * @param int $id_periodo
     * @param int $recorrido
     */
    public function rutearAction($id_periodo, $recorrido)
    {
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	/*if($cob_periodo->tipo == 2){
    		$actas = CobActamuestreo::find(array(
    				"id_periodo = $id_periodo AND recorrido = $recorrido",
    				"group" => "id_actamuestreo"
    		));
    		$this->view->periodos = CobActamuestreo::find(['group' => 'id_periodo, recorrido']);
    	} else {*/
    		$actas = CobActaconteo::find(array(
    				"id_periodo = $id_periodo AND recorrido = $recorrido",
    				"group" => "id_actaconteo"
    		));
    		$this->view->periodos = CobActaconteo::find(['group' => 'id_periodo, recorrido']);
    	//}
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	if (!$actas) {
    		$this->flash->error("El recorrido no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$this->assets
    	->addJs('js/jquery.tablesorter.min.js')
    	->addJs('js/jquery.tablesorter.widgets.js')
    	->addJs('js/rutear.js');

    	$this->view->id_periodo = $cob_periodo->id_periodo;
    	$this->view->recorrido = $recorrido;
    	$this->view->fecha_periodo = $cob_periodo->id_periodo;
    	$this->view->actas = $actas;
    	$this->view->interventores = IbcUsuario::find(['id_usuario_cargo = 3', 'order' => 'usuario asc']);
    }

    /**
     * Guarda el cob_periodo editado
     *
     */
    public function ruteoguardarAction($id_periodo, $recorrido)
    {

    	if (!$this->request->isPost()) {
    		 return $this->response->redirect("ibc_usuario/");
    	}
   	 	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
   	 	/*if($cob_periodo->tipo == 2){
   	 		$actas = CobActamuestreo::find(array(
   	 				"id_periodo = $id_periodo AND recorrido = $recorrido",
   	 				"group" => "id_actamuestreo"
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
   	 				'id_actamuestreo' => $this->request->getPost("id_acta"),
   	 				'estado' => $estado,
   	 				'id_usuario' => $this->request->getPost("contador_asignado")
   	 		);
   	 		$sql = $this->conversiones->multipleupdate("cob_actamuestreo", $elementos, "id_actamuestreo");
   	 	} else {*/
   	 		$actas = CobActaconteo::find(array(
   	 				"id_periodo = $id_periodo AND recorrido = $recorrido",
   	 				"group" => "id_actaconteo"
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
   	 				'id_actaconteo' => $this->request->getPost("id_acta"),
   	 				'estado' => $estado,
   	 				'id_usuario' => $this->request->getPost("contador_asignado")
   	 		);
   	 		$sql = $this->conversiones->multipleupdate("cob_actaconteo", $elementos, "id_actaconteo");
   	 	//}
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	if (!$actas) {
    		$this->flash->error("El recorrido no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$query = $db->execute($sql);
    	if (!$query) {
	    	foreach ($query->getMessages() as $message) {
	    			$this->flash->error($message);
	    		}
    		return $this->response->redirect("cob_periodo/rutear/$id_periodo/$recorrido");
    	}
    	$this->flash->success("El ruteo fue actualizado exitosamente");
    	return $this->response->redirect("cob_periodo/rutear/$id_periodo/$recorrido");
    }

    /**
     * Rutea desde otro recorrido
     *
     */
    public function ruteodesdeotroguardarAction($id_periodo, $recorrido)
    {

    	if (!$this->request->isPost()) {
    		return $this->response->redirect("rutear/$id_periodo/$recorrido");
    	}
    	$id_periodo_actualizar = $this->request->getPost("id_periodo_actualizar");
    	$recorrido_actualizar = $this->request->getPost("recorrido_actualizar");
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo_actualizar);

	//if comentado ya que el tipo del periodo ya no es necesario 20/06/2017	
    	/* if($cob_periodo->tipo == 2){
    		$actas = CobActamuestreo::find(array(
    				"id_periodo = $id_periodo_actualizar AND recorrido = $recorrido_actualizar",
    				"group" => "id_actamuestreo"
    		));
    		$tabla_acta = "cob_actamuestreo";
    	} else {
    		$actas = CobActaconteo::find(array(
    				"id_periodo = $id_periodo_actualizar AND recorrido = $recorrido_actualizar",
    				"group" => "id_actaconteo"
    		));
    		$tabla_acta = "cob_actaconteo";
    	}*/


	    	$actas = CobActaconteo::find(array(
    				"id_periodo = $id_periodo_actualizar AND recorrido = $recorrido_actualizar",
    				"group" => "id_actaconteo"
    		));
    		$tabla_acta = "cob_actaconteo";


    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	if (!$actas) {
    		$this->flash->error("El recorrido no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$db = $this->getDI()->getDb();
    	foreach($actas as $row){
    		$id_usuario = $row->id_usuario;
    		$id_contrato = $row->id_contrato;
    		$id_sede = $row->id_sede;
    		$query = $db->execute("UPDATE $tabla_acta SET id_usuario = $id_usuario WHERE id_periodo = $id_periodo AND recorrido = $recorrido AND id_contrato = $id_contrato AND id_sede = $id_sede");
    	}
    	$this->flash->success("El ruteo fue actualizado exitosamente");
    	return $this->response->redirect("cob_periodo/rutear/$id_periodo/$recorrido");
    }

    /**
     * nuevorecorrido
     *
     * @param int $id_periodo
     */
    public function nuevorecorridoAction($id_periodo)
    {
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$recorridos = CobActaconteo::find(array(
    			"id_periodo = $id_periodo",
    			"group" => "recorrido"
    	));
			$recorrido_anterior = count($recorridos);
			//Si el periodo es Itinerante se genera el nuevo recorrido
			if($cob_periodo->tipo == 4){
				$actas = CobActaconteo::generarActasItinerante($cob_periodo, $recorrido_anterior);
    		if($actas){
    			$this->flash->success("Se generaron exitosamente las actas");
    		}
    		return $this->response->redirect("cob_periodo/ver/$id_periodo");
			}
    	$facturacion = CobActaconteoPersonaFacturacion::findFirstByid_periodo($id_periodo);
    	if($facturacion){
    		$actas = CobActaconteo::generarActasFacturacion($cob_periodo, $recorrido_anterior);
    		if($actas){
    			$this->flash->success("Se generaron exitosamente las actas");
    		}
    		return $this->response->redirect("cob_periodo/ver/$id_periodo");
    	}
    	$this->view->id_periodo = $cob_periodo->id_periodo;
    	$this->view->fecha_corte = $this->conversiones->fecha(3, $cob_periodo->fecha);
    	$this->view->recorrido = count($recorridos) + 1;
    	$this->view->cargas = BcCarga::find(['order' => 'fecha DESC']);
    }

    /**
     * nuevorecorrido1
     *
     * @param int $id_periodo
     */
    public function nuevorecorrido1Action($id_periodo)
    {
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$this->view->id_periodo = $cob_periodo->id_periodo;
		// Comentado por Daniel Gallo 27/02/2017 16:53
        /*if($cob_periodo->tipo == 2) { 
    		$recorridos = CobActamuestreo::find(array(
    				"id_periodo = $id_periodo",
    				"group" => "recorrido"
    		));
        $this->view->pick("cob_periodo/nuevorecorrido1metro");
    	} else {*/
    		$recorridos = CobActaconteo::find(array(
    				"id_periodo = $id_periodo",
    				"group" => "recorrido"
    		));
        $this->view->fecha_corte = $this->conversiones->fecha(3, $cob_periodo->fecha);
		if($cob_periodo->tipo == 2) { // Si el tipo de periodo es entorno familiar en modalidades solo trae ENTORNO FAMILIAR 
        	$modalidades = BcModalidad::find(array(
				"id_modalidad = 5"
			));
		}
		else {
			$modalidades = BcModalidad::find();
		}
      	$this->view->modalidades = $modalidades;
    	//}
    	if (count($recorridos) == 0){
    		$this->view->recorridos = array("1" => "1");
    	} else if (count($recorridos) > 1) {
    		$this->view->recorridos = $recorridos;
    	} else {
    		$this->view->recorridos = $recorridos;
    	}
    	$this->view->cargas = BcCarga::find(['order' => 'fecha DESC']);
    }

    /**
     * Editar
     *
     * @param int $id_periodo
     */
    public function editarAction($id_periodo)
    {
        if (!$this->request->isPost()) {

            $cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
            if (!$cob_periodo) {
                $this->flash->error("El periodo no fue encontrado");

                return $this->response->redirect("cob_periodo/");
            }
            $this->assets
            ->addJs('js/parsley.min.js')
            ->addJs('js/parsley.extend.js');
            $this->view->id_periodo = $cob_periodo->id_periodo;
            $this->tag->setDefault("id_periodo", $cob_periodo->id_periodo);
            $this->tag->setDefault("fecha", $this->conversiones->fecha(2, $cob_periodo->fecha));
        }
    }

    /**
     * Creación de un nuevo cob_periodo
     */
    public function crearAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("cob_periodo/");
    	}
    	$cob_periodo = new CobPeriodo();
    	$cob_periodo->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
    	$cob_periodo->tipo = $this->request->getPost("tipo");

    	if (!$cob_periodo->save()) {
    		foreach ($cob_periodo->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_periodo/nuevo");
    	}
    	$this->flash->success("El periodo fue creado exitosamente.");
    	return $this->response->redirect("cob_periodo/");
    }

    /**
     * Generar un nuevo recorrido
     */
    public function generarrecorrido1Action($id_periodo){
        if (!$this->request->isPost() || !$id_periodo) {
            return $this->response->redirect("cob_periodo/");
        }
        $cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
        if (!$cob_periodo) {
        	$this->flash->error("El periodo no existe");

        	return $this->response->redirect("cob_periodo/");
        }
        $id_carga = $this->request->getPost("carga");
        $carga = BcCarga::findFirstByid_carga($id_carga);
        if (!$carga) {
        	$this->flash->error("La carga no existe");
        	return $this->response->redirect("cob_periodo/nuevorecorrido1/$id_periodo");
        }
		// Daniel Gallo 27/02/2017 17:00 se comenta donde el tipo sea entorno familiar 
        /*if($cob_periodo->tipo == 2) {
          $actas = CobActamuestreo::generarActasRcarga($cob_periodo, $carga, 0);
          if($actas){
            $this->flash->success("Se generaron exitosamente las actas");
          } else {
            $this->flash->error("Ocurrió un error al realizar la carga, por favor contacte al equipo de desarrollo");
          }
      	} else {*/
          $facturacion = $this->request->getPost("facturacion");
          $modalidades = implode(",", $this->request->getPost("modalidad"));
          $actas = CobActaconteo::generarActasR1($cob_periodo, $carga, $modalidades, $facturacion);
          if($actas){
          	$this->flash->success("Se generaron exitosamente las actas");
          } else {
            $this->flash->error("Ocurrió un error al realizar la carga, por favor contacte al equipo de desarrollo");
          }
      	//}
        return $this->response->redirect("cob_periodo/ver/$id_periodo");
    }

    /**
     * Generar un nuevo recorrido
     */
    public function generarrecorridoAction($id_periodo){
    	if (!$this->request->isPost() || !$id_periodo) {
    		return $this->response->redirect("cob_periodo/");
    	}
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no existe");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$id_carga = $this->request->getPost("carga");
      $carga = BcCarga::findFirstByid_carga($id_carga);
    	if (!$carga) {
    		$this->flash->error("La carga no existe");
    		return $this->response->redirect("cob_periodo/nuevorecorrido/$id_periodo");
    	}
		// Daniel Gallo 27/02/2017 17:00 se comenta donde el tipo sea entorno familiar 
      /*if($cob_periodo->tipo == 2) {
        $recorridos = CobActamuestreo::find(array(
            "id_periodo = $id_periodo",
            "group" => "recorrido"
        ));
        $actas = CobActamuestreo::generarActasRcarga($cob_periodo, $carga, count($recorridos));
        if($actas){
          $this->flash->success("Se generaron exitosamente las actas");
        } else {
          $this->flash->error("Ocurrió un error al realizar la carga, por favor contacte al equipo de desarrollo");
        }
      } else {*/
        $facturacion = $this->request->getPost("facturacion");
        $recorridos = CobActaconteo::find(array(
      			"id_periodo = $id_periodo",
      			"group" => "recorrido"
      	));
      	$actas = CobActaconteo::generarActasRcarga($cob_periodo, $carga, $facturacion, count($recorridos));
      	if($actas){
      		$this->flash->success("Se generaron exitosamente las actas");
      	} else {
          $this->flash->error("Ocurrió un error al realizar la carga, por favor contacte al equipo de desarrollo");
        }
      //}
    	return $this->response->redirect("cob_periodo/ver/$id_periodo");
    }

    /**
     * elegirfacturacion
     */
    public function elegirfacturacionAction($id_periodo){
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no existe");

    		return $this->response->redirect("cob_periodo/");
    	}
    	$cargas = BcCarga::find(['order' => 'fecha DESC']);
    	if (!$cargas) {
    		$this->flash->error("Hasta el momento no han sido creadas cargas");
    		return $this->response->redirect("cob_periodo/nuevorecorrido1/$id_periodo");
    	}
    	$this->view->cargas = $cargas;
    	$this->view->id_periodo = $id_periodo;
    }

    /**
     * elegirfacturacionguardar
     */
    public function elegirfacturacionguardarAction($id_periodo){
    	if (!$this->request->isPost() || !$id_periodo) {
    		return $this->response->redirect("cob_periodo/");
    	}
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no existe");
    		return $this->response->redirect("cob_periodo/");
    	}
    	$id_carga = $this->request->getPost("carga");
    	$carga = BcCarga::findFirstByid_carga($id_carga);
    	if (!$carga) {
    		$this->flash->error("La carga no existe");
    		return $this->response->redirect("cob_periodo/elegirfacturacion/$id_periodo");
    	}
    	$beneficiarios_facturacion = CobActaconteo::generarFacturacion($cob_periodo, $carga);
    	if($beneficiarios_facturacion){
    		$this->flash->success("Se generaron exitosamente los beneficiarios que serán facturados");
    	}
    	return $this->response->redirect("cob_periodo/ver/$id_periodo");
    }


    /**
     * Guarda el cob_periodo editado
     *
     */
    public function guardarAction()
    {

        if (!$this->request->isPost()) {
            return $this->response->redirect("cob_periodo/");
        }

        $id_periodo = $this->request->getPost("id_periodo");

        $cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
        if (!$cob_periodo) {
            $this->flash->error("cob_periodo no existe " . $id_periodo);
            return $this->response->redirect("cob_periodo/");
        }

        $cob_periodo->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
        $cob_periodo->tipo = $this->request->getPost("tipo");


        if (!$cob_periodo->save()) {

            foreach ($cob_periodo->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect("cob_periodo/ver/$id_periodo");
        }

        $this->flash->success("cob_periodo fue actualizado exitosamente");

        return $this->response->redirect("cob_periodo/");

    }

    /**
     * Elimina un  cob_periodo
     *
     * @param int $id_periodo
     */
    public function eliminarAction($id_periodo)
    {
        $cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
        if (!$cob_periodo) {
            $this->flash->error("El periodo no fue encontrado");
            return $this->response->redirect("cob_periodo/");
        }
				if($cob_periodo->fechaCierre != NULL){
					$this->flash->error("El periodo no puede ser eliminado porque ya fue cerrado; si desea eliminarlo debe de eliminar todos los registros de las tablas con el id_periodo, para un periodo normal serían las tablas cob_periodo, cob_actaconteo, cob_actaconteo_persona, cob_actaconteo_persona_facturacion, cob_periodo_contratosedecupos. Se recomienda hacer un backup de la Base de Datos antes de eliminar vía base de datos.");
					return $this->response->redirect("cob_periodo/");
				}
				$db = $this->getDI()->getDb();
				$db->query("DELETE FROM cob_periodo WHERE id_periodo = $id_periodo");
				// Si es Entorno Familiar
				if($cob_periodo->tipo == 2) {
					$db->query("DELETE FROM cob_actamuestreo WHERE id_periodo = $id_periodo");
					$db->query("DELETE FROM cob_actamuestreo_persona WHERE id_periodo = $id_periodo");
				} else {
					//Para el resto de periodos se eliminan las tablas de actas
					$db->query("DELETE FROM cob_actaconteo WHERE id_periodo = $id_periodo");
					$db->query("DELETE FROM cob_actaconteo_persona WHERE id_periodo = $id_periodo");
					$db->query("DELETE FROM cob_actaconteo_persona_facturacion WHERE id_periodo = $id_periodo");
					$db->query("DELETE FROM cob_periodo_contratosedecupos WHERE id_periodo = $id_periodo");
				}
        $this->flash->success("El periodo fue eliminado correctamente");
        return $this->response->redirect("cob_periodo/");
    }

    /**
     * Cerrar periodo
     */
    public function cerrarAction($id_periodo){
    	$cob_periodo = CobPeriodo::findFirstByid_periodo($id_periodo);
    	if (!$cob_periodo) {
    		$this->flash->error("El periodo no fue encontrado");
    		return $this->response->redirect("cob_periodo");
    	}
    	if ($cob_periodo->fechaCierre) {
    		$this->flash->error("El periodo ya fue cerrado");
    		return $this->response->redirect("cob_periodo/ver/$id_periodo");
    	}
    	$db = $this->getDI()->getDb();
    	$db->query("UPDATE cob_actaconteo_persona, cob_actaconteo_persona_facturacion SET cob_actaconteo_persona.id_actaconteo_persona_facturacion = cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion WHERE cob_actaconteo_persona.id_contrato = cob_actaconteo_persona_facturacion.id_contrato AND cob_actaconteo_persona.numDocumento = cob_actaconteo_persona_facturacion.numDocumento AND cob_actaconteo_persona.id_periodo = $id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $id_periodo");
    	$db->query("UPDATE cob_actaconteo_persona_facturacion, cob_actaconteo_persona SET cob_actaconteo_persona_facturacion.acta3 = cob_actaconteo_persona.id_actaconteo, cob_actaconteo_persona_facturacion.asistencia3 = cob_actaconteo_persona.asistencia, cob_actaconteo_persona_facturacion.id_actaconteo_persona3 = cob_actaconteo_persona.id_actaconteo_persona WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion AND cob_actaconteo_persona.recorrido = 3 AND cob_actaconteo_persona.id_periodo = $id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $id_periodo");
    	$db->query("UPDATE cob_actaconteo SET estado = 4 WHERE cob_actaconteo.id_periodo = $id_periodo");
    	$timestamp = new DateTime();
    	$tabla_certificar = "m" . $timestamp->getTimestamp();
    	$db->query("CREATE TEMPORARY TABLE $tabla_certificar (id_actaconteo_persona_facturacion BIGINT, asistencia BIGINT) CHARACTER SET utf8 COLLATE utf8_bin");
    	$db->query("INSERT IGNORE INTO $tabla_certificar (id_actaconteo_persona_facturacion, asistencia) SELECT id_actaconteo_persona_facturacion, asistencia FROM cob_actaconteo_persona WHERE cob_actaconteo_persona.id_periodo = $id_periodo");
    	$db->query("DELETE FROM $tabla_certificar WHERE id_actaconteo_persona_facturacion = 0");
    	$db->query("UPDATE cob_actaconteo_persona_facturacion, $tabla_certificar SET cob_actaconteo_persona_facturacion.certificacionRecorridos = 2, cob_actaconteo_persona_facturacion.certificacionFacturacion = 2, cob_actaconteo_persona_facturacion.certificacionLiquidacion = 2, cob_actaconteo_persona_facturacion.asistenciaFinalFacturacion = 6 WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = $tabla_certificar.id_actaconteo_persona_facturacion AND cob_actaconteo_persona_facturacion.id_periodo = $id_periodo AND $tabla_certificar.asistencia = 6");
    	$db->query("UPDATE cob_actaconteo_persona_facturacion, $tabla_certificar SET cob_actaconteo_persona_facturacion.certificacionRecorridos = 2, cob_actaconteo_persona_facturacion.certificacionFacturacion = 2, cob_actaconteo_persona_facturacion.certificacionLiquidacion = 2, cob_actaconteo_persona_facturacion.asistenciaFinalFacturacion = 5 WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = $tabla_certificar.id_actaconteo_persona_facturacion AND cob_actaconteo_persona_facturacion.id_periodo = $id_periodo AND $tabla_certificar.asistencia = 5");
    	$db->query("UPDATE cob_actaconteo_persona_facturacion, $tabla_certificar SET cob_actaconteo_persona_facturacion.certificacionRecorridos = 2, cob_actaconteo_persona_facturacion.certificacionFacturacion = 2, cob_actaconteo_persona_facturacion.certificacionLiquidacion = 2, cob_actaconteo_persona_facturacion.asistenciaFinalFacturacion = 4 WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = $tabla_certificar.id_actaconteo_persona_facturacion AND cob_actaconteo_persona_facturacion.id_periodo = $id_periodo AND $tabla_certificar.asistencia = 4");
    	$db->query("UPDATE cob_actaconteo_persona_facturacion, $tabla_certificar SET cob_actaconteo_persona_facturacion.certificacionRecorridos = 2, cob_actaconteo_persona_facturacion.certificacionFacturacion = 2, cob_actaconteo_persona_facturacion.certificacionLiquidacion = 2, cob_actaconteo_persona_facturacion.asistenciaFinalFacturacion = 8 WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = $tabla_certificar.id_actaconteo_persona_facturacion AND cob_actaconteo_persona_facturacion.id_periodo = $id_periodo AND $tabla_certificar.asistencia = 8");
    	$db->query("UPDATE cob_actaconteo_persona_facturacion, $tabla_certificar SET cob_actaconteo_persona_facturacion.certificacionRecorridos = 1, cob_actaconteo_persona_facturacion.certificacionFacturacion = 1, cob_actaconteo_persona_facturacion.certificacionLiquidacion = 1, cob_actaconteo_persona_facturacion.asistenciaFinalFacturacion = 7 WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = $tabla_certificar.id_actaconteo_persona_facturacion AND cob_actaconteo_persona_facturacion.id_periodo = $id_periodo AND $tabla_certificar.asistencia = 7");
    	$db->query("UPDATE cob_actaconteo_persona_facturacion, $tabla_certificar SET cob_actaconteo_persona_facturacion.certificacionRecorridos = 1, cob_actaconteo_persona_facturacion.certificacionFacturacion = 1, cob_actaconteo_persona_facturacion.certificacionLiquidacion = 1, cob_actaconteo_persona_facturacion.asistenciaFinalFacturacion = 1 WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = $tabla_certificar.id_actaconteo_persona_facturacion AND cob_actaconteo_persona_facturacion.id_periodo = $id_periodo AND $tabla_certificar.asistencia = 1");
    	$db->query("UPDATE cob_actaconteo_persona_facturacion SET certificacionRecorridos = 2, certificacionFacturacion = 2, certificacionLiquidacion = 2, asistenciaFinalFacturacion = 4 WHERE id_periodo = $id_periodo AND fechaRetiro > 0000-00-00");
    	$db->query("DROP TABLE $tabla_certificar");
    	$cob_periodo->fechaCierre = date('Y-m-d H:i:s');
    	if (!$cob_periodo->save()) {
    		foreach ($cob_periodo->getMessages() as $message) {
    			$this->flash->error($message);
    		}
    		return $this->response->redirect("cob_periodo/ver/$id_periodo");
    	}
    	$this->flash->success("El periodo fue cerrado exitosamente");
    	return $this->response->redirect("cob_periodo/ver/$id_periodo");
    }

}
