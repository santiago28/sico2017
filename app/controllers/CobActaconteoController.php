<?php

use Phalcon\Mvc\Model\Criteria;

class CobActaconteoController extends ControllerBase
{
	public $user;

	public function initialize()
	{
		$this->tag->setTitle("Acta de Conteo");
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
	public function verAction($id_actaconteo)
	{
		$this->assets
		->addCss('css/acta-impresion.css');
		$acta = CobActaconteo::generarActa($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta no fue encontrada");
			return $this->response->redirect("cob_periodo/");
		}
		$this->view->recorridos = CobActaconteo::maximum(array("column" => "recorrido"));
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
	public function datosAction($id_actaconteo)
	{
		if (!$this->request->isPost()) {

			$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
			if (!$acta) {
				$this->flash->error("El acta no fue encontrada");

				return $this->response->redirect("cob_periodo/");
			}

			// Daniel Gallo - Validación 02/03/2017
			$cob_periodo = CobPeriodo::findFirstByid_periodo($acta->id_periodo);
			if (!$cob_periodo) {
				$this->flash->error("El periodo no existe");
				return $this->response->redirect("cob_periodo/");
			}

			$asiste1 = $acta->getCobActaconteoPersona(['tipoPersona = 0 AND asistencia = 1']);
			$asiste2 = $acta->getCobActaconteoPersona(['tipoPersona = 0 AND asistencia = 2']);
			$asiste3 = $acta->getCobActaconteoPersona(['tipoPersona = 0 AND asistencia = 3']);
			$asiste4 = $acta->getCobActaconteoPersona(['tipoPersona = 0 AND asistencia = 4']);
			$asiste5 = $acta->getCobActaconteoPersona(['tipoPersona = 0 AND asistencia = 5']);
			$asiste6 = $acta->getCobActaconteoPersona(['tipoPersona = 0 AND asistencia = 6']);
			$asiste7 = $acta->getCobActaconteoPersona(['tipoPersona = 0 AND asistencia = 7']);
			$asiste8 = $acta->getCobActaconteoPersona(['tipoPersona = 0 AND asistencia = 8']);
			$asistetotal = $acta->getCobActaconteoPersona(['tipoPersona = 0']);
			$asisteadicionales = $acta->getCobActaconteoPersona(['tipoPersona = 1']);
			$this->view->asiste1 = count($asiste1);
			$this->view->asiste2 = count($asiste2);
			$this->view->asiste3 = count($asiste3);
			$this->view->asiste4 = count($asiste4);
			$this->view->asiste5 = count($asiste5);
			$this->view->asiste6 = count($asiste6);
			$this->view->asiste7 = count($asiste7);
			$this->view->asiste8 = count($asiste8);
			$this->view->asistetotal = count($asistetotal);
			$this->view->asisteadicionales = count($asisteadicionales);
			$this->assets
			->addJs('js/parsley.min.js')
			->addJs('js/parsley.extend.js')
			->addJs('js/datos.js');
			$this->view->id_actaconteo = $id_actaconteo;
			$this->view->valla_sede = $this->elements->getSelect("datos_valla");
			$this->view->sino = $this->elements->getSelect("sinona");
			$this->view->estadoVisita = $this->elements->getSelect("estadoVisita");
			$this->view->numeroEncuentos = $this->elements->getSelect("numeroEncuentos");
			$this->view->tipo_encuentro = $this->elements->getSelect("tipoencuentro");
			if($acta->CobActaconteoDatos){
				$this->tag->setDefault("fecha", $this->conversiones->fecha(2, $acta->CobActaconteoDatos->fecha));
				$this->tag->setDefault("horaInicio", $acta->CobActaconteoDatos->horaInicio);
				$this->tag->setDefault("horaFin", $acta->CobActaconteoDatos->horaFin);
				$this->tag->setDefault("nombreEncargado", $acta->CobActaconteoDatos->nombreEncargado);
				$this->tag->setDefault("vallaClasificacion", $acta->CobActaconteoDatos->vallaClasificacion);
				$this->tag->setDefault("correccionDireccion", $acta->CobActaconteoDatos->correccionDireccion);
				$this->tag->setDefault("mosaicoFisico", $acta->CobActaconteoDatos->mosaicoFisico);
				$this->tag->setDefault("mosaicoDigital", $acta->CobActaconteoDatos->mosaicoDigital);
				$this->tag->setDefault("observacionEncargado", $acta->CobActaconteoDatos->observacionEncargado);
				$this->tag->setDefault("observacionUsuario", $acta->CobActaconteoDatos->observacionUsuario);
				$this->tag->setDefault("estadoVisita", $acta->CobActaconteoDatos->estadoVisita);
				$this->tag->setDefault("numeroEncuentos", $acta->CobActaconteoDatos->numeroEncuentos);
				$this->tag->setDefault("gestionTelefonica", $acta->CobActaconteoDatos->gestionTelefonica);
				if($acta->id_modalidad == 5){
					$this->tag->setDefault("encuentroSede", $acta->CobActaconteoDatos->encuentroSede);
					$this->tag->setDefault("nombreSede", $acta->CobActaconteoDatos->nombreSede);
					$this->tag->setDefault("mosaicoSanitario", $acta->CobActaconteoDatos->mosaicoSanitario);
					$this->tag->setDefault("mosaicoSeguridad", $acta->CobActaconteoDatos->mosaicoSeguridad);
					$this->tag->setDefault("mosaicoEncuentro", $acta->CobActaconteoDatos->tipoEncuentro);
					$this->tag->setDefault("gruposVisitados", $acta->CobActaconteoDatos->gruposVisitados);
				}
			}
			$this->view->acta = $acta;
			$this->view->periodo_tipo = $cob_periodo->tipo;
			$this->actaCerrada($acta, $this->user['nivel']);
		}
	}

	/**
	* Guardar Datos
	*
	*/
	public function guardardatosAction($id_actaconteo)
	{
		if (!$this->request->isPost()) {
			return $this->response->redirect("cob_periodo/");
		}
		$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta $id_actaconteo no existe ");
			return $this->response->redirect("cob_periodo/");
		}

		// Daniel Gallo - Validación 02/03/2017
		$cob_periodo = CobPeriodo::findFirstByid_periodo($acta->id_periodo);
		if (!$cob_periodo) {
			$this->flash->error("El periodo no existe");
			return $this->response->redirect("cob_periodo/");
		}

		$this->guardarActaCerrada($acta, $this->user['nivel']);
		$dato = new CobActaconteoDatos();
		$dato->id_actaconteo = $id_actaconteo;
		$dato->id_usuario = $this->session->auth['id_usuario'];
		$dato->fecha = $this->conversiones->fecha(1, $this->request->getPost("fecha"));
		$dato->horaInicio = $this->request->getPost("horaInicio");
		$dato->horaFin = $this->request->getPost("horaFin");
		$dato->nombreEncargado = $this->request->getPost("nombreEncargado");
		$dato->vallaClasificacion = $this->request->getPost("vallaClasificacion");
		$dato->correccionDireccion = $this->request->getPost("correccionDireccion");
		$dato->mosaicoFisico = $this->request->getPost("mosaicoFisico");
		$dato->mosaicoDigital = $this->request->getPost("mosaicoDigital");
		$dato->observacionEncargado = $this->request->getPost("observacionEncargado");
		$dato->observacionUsuario = $this->request->getPost("observacionUsuario");
		//Si es Entorno Comunitario Itinerante se guarda Estado de la Visita
		if($acta->id_modalidad == 12){
			$dato->estadoVisita = $this->request->getPost("estadoVisita");
			$dato->numeroEncuentos = $this->request->getPost("numeroEncuentos");
			$dato->gestionTelefonica = $this->request->getPost("gestionTelefonica");
		}
		else if($acta->id_modalidad == 5){ // Entorno familiar
			$dato->encuentroSede    = $this->request->getPost("encuentroSede");
			$dato->nombreSede       = $this->request->getPost("nombreSede");
			$dato->mosaicoSanitario = $this->request->getPost("mosaicoSanitario");
			$dato->mosaicoSeguridad = $this->request->getPost("mosaicoSeguridad");
			$dato->gruposVisitados = $this->request->getPost("gruposVisitados");
			$dato->tipoEncuentro = $this->request->getPost("mosaicoEncuentro");
		}

		if (!$dato->save()) {
			foreach ($dato->getMessages() as $message) {
				$this->flash->error($message);
			}
			return $this->response->redirect("cob_actaconteo/datos/$id_actaconteo");
		}
		$this->flash->success("Los Datos Generales fueron actualizados exitosamente");
		return $this->response->redirect("cob_actaconteo/datos/$id_actaconteo");
	}

	/**
	* Guardar Beneficiarios
	*
	*/
	public function guardarbeneficiariosAction($id_actaconteo)
	{
		if (!$this->request->isPost()) {
			return $this->response->redirect("cob_periodo/");
		}
		$db = $this->getDI()->getDb();
		$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta $id_actaconteo no existe");
			return $this->response->redirect("cob_periodo/");
		}
		$this->guardarActaCerrada($acta, $this->user['nivel']);
		$persona = new CobActaconteoPersona();
		$i = 0;
		$elementos = array(
			'id_actaconteo_persona' => $this->request->getPost("id_actaconteo_persona"),
			'asistencia' => $this->request->getPost("asistencia")
		);
		$fechas = $this->request->getPost("fecha");
		if(count($fechas) > 0) {
			$fechas = $this->conversiones->array_fechas(1, $fechas);
			$elementos['fechaInterventoria'] = $fechas;
		}
		$sql = $this->conversiones->multipleupdate("cob_actaconteo_persona", $elementos, "id_actaconteo_persona");
		$query = $db->query($sql);
		if (!$query) {
			foreach ($query->getMessages() as $message) {
				$this->flash->error($message);
			}
			return $this->response->redirect("cob_actaconteo/datos/$id_actaconteo");
		}
		$fechas = $this->request->getPost("fecha_excusa");
		if($fechas){
			$fechas = $this->conversiones->array_fechas(1, $fechas);
			$modalidades = array();
			for ($i=0; $i < count($fechas); $i++) {
				$modalidades[$i] = $acta->id_modalidad;
			}
			$elementos = array( // Nota se utilizo la misma tabla para almacenar los datos de gestión y acudiente
				'id_actaconteo_persona' => $this->request->getPost("id_actaconteo_persona2"),
				'motivo' => $this->request->getPost("motivo"), // Gestión Telefónica para la modalidad entorno familiar
				'fecha' => $fechas,
				'profesional' => $this->request->getPost("profesional"), // Acudiente para la modalidad entorno familiar
				'telefono' => $this->request->getPost("telefono"),
				'id_modalidad' => $modalidades // Se guarda la modalidad para que a la hora de verificar en base de datos se sepa la excusa a que modalida pertenece
			);

			$sql = $this->conversiones->multipleinsert("cob_actaconteo_persona_excusa", $elementos);
			$query = $db->query($sql);
			if (!$query) {
				foreach ($query->getMessages() as $message) {
					$this->flash->error($message);
				}
				return $this->response->redirect("cob_actaconteo/adicionales/$id_actaconteo");
			}
		}
		//Eliminar las excusas que ya no tienen clasificación de excusa
		if( $acta->id_modalidad == 5 )
		{
			$db->query("DELETE FROM cob_actaconteo_persona_excusa WHERE id_actaconteo_persona IN (SELECT a.id_actaconteo_persona FROM cob_actaconteo_persona as a, cob_actaconteo as b WHERE a.asistencia != 4 AND a.asistencia != 5 AND a.asistencia != 6 AND a.asistencia != 7 AND a.id_actaconteo = b.id_actaconteo AND b.id_modalidad = $acta->id_modalidad )");
		}
		else
		{
			$db->query("DELETE FROM cob_actaconteo_persona_excusa WHERE id_actaconteo_persona IN (SELECT a.id_actaconteo_persona FROM cob_actaconteo_persona as a, cob_actaconteo as b WHERE a.asistencia != 7 AND a.asistencia != 8 AND a.id_actaconteo = b.id_actaconteo AND b.id_modalidad != 5 )");
		}
		$acta->estado = 1;
		$acta->save();
		$this->flash->success("Los beneficiarios fueron actualizados exitosamente");
		return $this->response->redirect("cob_actaconteo/beneficiarios/$id_actaconteo");
	}
	/**
	* Guardar Adicionales
	*
	*/
	public function guardaradicionalesAction($id_actaconteo)
	{
		if (!$this->request->isPost()) {
			return $this->response->redirect("cob_periodo/");
		}
		$db = $this->getDI()->getDb();
		$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta $id_actaconteo no existe");
			return $this->response->redirect("cob_periodo/");
		}
		$this->guardarActaCerrada($acta, $this->user['nivel']);
		$eliminar_adicionales = $this->request->getPost("eliminar_adicionales");
		if($eliminar_adicionales){
			$sql = $this->conversiones->multipledelete("cob_actaconteo_persona", "id_actaconteo_persona", $eliminar_adicionales);
			$query = $db->query($sql);
		}
		if($this->request->getPost("num_documento")){
			$persona = new CobActaconteoPersona();
			$elementos = array(
				'numDocumento' => $this->request->getPost("num_documento"),
				'primerNombre' => $this->request->getPost("primerNombre"),
				'segundoNombre' => $this->request->getPost("segundoNombre"),
				'primerApellido' => $this->request->getPost("primerApellido"),
				'segundoApellido' => $this->request->getPost("segundoApellido"),
				'grupo' => $this->request->getPost("grupo"),
				'asistencia' => $this->request->getPost("asistencia"),
				'urlAdicional' => $this->request->getPost("urlAdicional"),
				'observacionAdicional' => $this->request->getPost("observacion"),
				'tipoPersona' => '1',
				'id_actaconteo' => $id_actaconteo,
				'id_periodo' => $acta->id_periodo,
				'recorrido' => $acta->recorrido,
				'id_contrato' => $acta->id_contrato
			);
			$fechas = $this->request->getPost("fecha");
			if(count($fechas) > 0) {
				$fechas = $this->conversiones->array_fechas(1, $fechas);
				$elementos['fechaInterventoria'] = $fechas;
			}
			$sql = $this->conversiones->multipleinsert("cob_actaconteo_persona", $elementos);
			$query = $db->query($sql);
			if (!$query) {
				foreach ($query->getMessages() as $message) {
					$this->flash->error($message);
				}
				return $this->response->redirect("cob_actaconteo/adicionales/$id_actaconteo");
			}
		}
		$this->flash->success("Los adicionales fueron actualizados exitosamente");
		return $this->response->redirect("cob_actaconteo/adicionales/$id_actaconteo");
	}

	/**
	* Guardar Adicionales
	*
	*/
	public function guardaradicionalescapturasAction($id_actaconteo)
	{
		if (!$this->request->isPost()) {
			return $this->response->redirect("cob_periodo/");
		}
		$db = $this->getDI()->getDb();
		$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta $id_actaconteo no existe");
			return $this->response->redirect("cob_periodo/");
		}
		$elementos = array(
			'id_actaconteo_persona' => $this->request->getPost("id_actaconteo_persona"),
			'urlAdicional' => $this->request->getPost("urlAdicional")
		);
		$sql = $this->conversiones->multipleupdate("cob_actaconteo_persona", $elementos, "id_actaconteo_persona");
		$query = $db->query($sql);
		if (!$query) {
			foreach ($query->getMessages() as $message) {
				$this->flash->error($message);
			}
			return $this->response->redirect("cob_actaconteo/adicionalescapturas/$id_actaconteo");
		}
		$this->flash->success("Las capturas de los adicionales fueron actualizadas exitosamente");
		return $this->response->redirect("cob_actaconteo/adicionalescapturas/$id_actaconteo");
	}

	/**
	* Beneficiarios
	*
	* @param int $id_actaconteo
	*/
	public function beneficiariosAction($id_actaconteo) {
		if (!$this->request->isPost()) {
			$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
			if (!$acta) {
				$this->flash->error("El acta no fue encontrada");
				return $this->response->redirect("cob_periodo/");
			}

			// Daniel Gallo - Validación 02/03/2017
			$cob_periodo = CobPeriodo::findFirstByid_periodo($acta->id_periodo);
			if (!$cob_periodo) {
				$this->flash->error("El periodo no existe");
				return $this->response->redirect("cob_periodo/");
			}
			$this->assets
			->addJs('js/parsley.min.js')
			->addJs('js/parsley.extend.js')
			->addJs('js/beneficiarios.js');
			$this->view->nombre = array();
			$this->view->acta = $acta;
			$this->view->beneficiarios = $acta->getCobActaconteoPersona(['tipoPersona = 0','order' => 'id_grupo, primerNombre asc']);
			$beneficiario_grupos = $acta->getCobActaconteoPersona(['group' => 'id_grupo']);
			$grupos = array();
			foreach($beneficiario_grupos as $row){
				$grupos[] = array("id_grupo" => $row->id_grupo, "nombre_grupo" => $row->grupo);
			}
			$this->view->grupos = $grupos;
			$this->view->id_actaconteo = $id_actaconteo;
			$this->view->asistencia = $this->elements->getSelect("asistencia");
			$this->view->asistenciaEC = $this->elements->getSelect("asistenciaEC");
			$this->view->acta = $acta;
			$this->view->periodo_tipo = $cob_periodo->tipo;
			$this->actaCerrada($acta, $this->user['nivel']);
		}
	}

	/**
	* Adicionales
	*
	* @param int $id_actaconteo
	*/
	public function adicionalesAction($id_actaconteo) {
		if (!$this->request->isPost()) {
			$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
			if (!$acta) {
				$this->flash->error("El acta no fue encontrada");
				return $this->response->redirect("cob_periodo/");
			}
			$this->assets
			->addJs('js/bootstrap-filestyle.min.js')
			->addJs('js/parsley.min.js')
			->addJs('js/parsley.extend.js')
			->addJs('js/jquery.autoNumeric.js')
			->addJs('js/adicionales.js');
			$ninos = $acta->getCobActaconteoPersona(['tipoPersona = 0', 'order' => 'grupo asc']);
			$array_ninos = array();
			foreach($ninos as $row){
				$array_ninos[] = $row->numDocumento;
			}
			$this->view->adicionales = $acta->getCobActaconteoPersona(['tipoPersona = 1', 'order' => 'grupo asc']);
			$this->view->listado_ninos = implode(",", $array_ninos);
			$this->view->id_actaconteo = $id_actaconteo;
			$this->view->asistencia = $this->elements->getSelect("asistencia");
			$this->view->asistenciaEC = $this->elements->getSelect("asistenciaEC");
			$this->view->acta = $acta;
			$this->actaCerrada($acta, $this->user['nivel']);
		}
	}

	/**
	* Adicionales
	*
	* @param int $id_actaconteo
	*/
	public function adicionalescapturasAction($id_actaconteo) {
		if (!$this->request->isPost()) {
			$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
			if (!$acta) {
				$this->flash->error("El acta no fue encontrada");
				return $this->response->redirect("cob_periodo/");
			}
			$this->assets
			->addJs('js/bootstrap-filestyle.min.js')
			->addJs('js/parsley.min.js')
			->addJs('js/parsley.extend.js')
			->addJs('js/jquery.autoNumeric.js')
			->addJs('js/adicionalescapturas.js');
			$this->view->adicionales = $acta->getCobActaconteoPersona(['tipoPersona = 1', 'order' => 'grupo asc']);
			$this->view->acta = $acta;
			$this->view->id_actaconteo = $id_actaconteo;
			$this->view->asistencia = $this->elements->getSelect("asistencia");
			$this->view->acta = $acta;
		}
	}

	/**
	* Subir adicional
	*
	*/
	public function subiradicionalAction($id_actaconteo) {
		$this->view->disable();
		$tipos = array("image/png", "image/jpeg", "image/jpg", "image/bmp", "image/gif");
		if ($this->request->isPost()) {
			if ($this->request->hasFiles() == true) {
				$uploads = $this->request->getUploadedFiles();
				$isUploaded = false;
				foreach($uploads as $upload){
					if(!$upload->getName()){
						continue;
					}
					if(in_array($upload->gettype(), $tipos)){
						$nombre = $id_actaconteo.date("ymdHis").".".$upload->getextension();
						$path = "files/adicionales/".$nombre;
						($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
					} else {
						echo "Tipo";
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
				return "Error";
			}
		}
	}

	/**
	* Deshabilita un acta
	*
	* @param int $id_actaconteo
	*/
	public function deshabilitarAction($id_actaconteo)
	{

		$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta no fue encontrada");
			return $this->response->redirect("cob_actaconteo/");
		}
		if ($acta->estado < 3) {
			$acta->estado = 5;
			if (!$acta->save()) {
				foreach ($acta->getMessages() as $message) {
					$this->flash->error($message);
				}
				return $this->response->redirect("cob_actaconteo/");
			}
			$this->flash->success("El acta fue desactivada correctamente");
			return $this->response->redirect("cob_actaconteo/");
		} else {
			$this->flash->error("El acta no puede ser deshabilitada porque ya fue consolidada");
		}

	}

	/**
	* Cierra un acta
	*
	* @param int $id_actaconteo
	*/
	public function cerrarAction($id_actaconteo)
	{
		if (!$this->request->isPost()) {
			return $this->response->redirect("cob_actaconteo/ver/$id_actaconteo");
		}
		$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta no fue encontrada");
			return $this->response->redirect("cob_actaconteo/");
		}
		$uri = $this->request->getPost("uri");
		$error = 0;
		if(!($acta->CobActaconteoDatos->fecha)){
			$this->flash->notice("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta no puede ser cerrada debido a que:");
			$this->flash->error("No han sido digitados los datos del acta.");
			$error = 1;
		}
		if($acta->CobActaconteoPersona[0]->asistencia == 0){
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
	public function abrirAction($id_actaconteo)
	{
		if (!$this->request->isPost()) {
			return $this->response->redirect("cob_actaconteo/ver/$id_actaconteo");
		}
		$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta no fue encontrada");
			return $this->response->redirect("cob_actaconteo/");
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
	public function duplicaractaAction($id_actaconteo){
		if (!$id_actaconteo) {
			return $this->response->redirect("cob_actaconteo/ver/$id_actaconteo");
		}
		$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta no fue encontrada");
			return $this->response->redirect("cob_actaconteo/ver/$id_actaconteo");
		}
		$cob_periodo = CobPeriodo::findFirstByid_periodo($acta->id_periodo);
		if (!$cob_periodo) {
			$this->flash->error("El periodo no existe");
			return $this->response->redirect("cob_actaconteo/ver/$id_actaconteo");
		}
		$duplicar = CobActaconteo::duplicarActa($acta, $cob_periodo);
		if($duplicar){
			$this->flash->success("Se duplicó exitosamente el acta");
		} else {
			$this->flash->error("No se duplicó el acta");
		}
		return $this->response->redirect("cob_actaconteo/ver/$id_actaconteo");
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
			$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>Cerrada por Auxiliar</b>, si desea realizar un cambio contacte con su coordinador.");
			return $this->response->redirect("cob_actaconteo/datos/$acta->id_actaconteo");
		} else if($acta->estado > 1){
			if($nivel == 3){
				$this->flash->error("<i class='glyphicon glyphicon-exclamation-sign'></i> El acta se encuentra en estado <b>Cerrada por Interventor</b>, si desea realizar un cambio contacte con su coordinador.");
				return $this->response->redirect("cob_actaconteo/datos/$acta->id_actaconteo");
			}
			return FALSE;
		} else {
			return FALSE;
		}
	}

	/**
	* Seguimiento a los profesionales de Buen Comienzo modalidad ECI
	*
	* @param int $id_actaconteo
	*/
	public function seguimientoitineranteAction($id_actaconteo) {
		$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta no fue encontrada");
			return $this->response->redirect("cob_periodo/");
		}
		$this->view->seguimiento = CobActaconteoEmpleadoitinerante::find(["id_actaconteo = $id_actaconteo", 'order' => 'id_actaconteo_empleadoitinerante asc']);
		$this->assets
		->addJs('js/parsley.min.js')
		->addJs('js/parsley.extend.js')
		->addJs('js/jquery.timepicker.min.js')
		->addJs('js/bootstrap-datepicker.min.js')
		->addJs('js/bootstrap-datepicker.es.min.js')
		->addJs('js/jquery.datepair.min.js')
		->addCss('css/jquery.timepicker.css')
		->addCss('css/bootstrap-datepicker.min.css')
		->addJs('js/seguimientoitinerante.js');
		$this->view->cargo = $this->elements->getSelect("cargoitinerante");
		$this->view->acta = $acta;
		$this->view->id_actaconteo = $id_actaconteo;
		$this->actaCerrada($acta, $this->user['nivel']);
	}

	/**
	* Guardar seguimientoitinerante
	*
	*/
	public function guardarseguimientoitineranteAction($id_actaconteo)
	{
		if (!$this->request->isPost()) {
			return $this->response->redirect("cob_periodo/");
		}
		$db = $this->getDI()->getDb();
		$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
		if (!$acta) {
			$this->flash->error("El acta $id_actaconteo no existe");
			return $this->response->redirect("cob_periodo/");
		}
		$this->guardarActaCerrada($acta, $this->user['nivel']);
		$eliminar_empleados = $this->request->getPost("eliminar_empleados");
		if($eliminar_empleados){
			$sql = $this->conversiones->multipledelete("cob_actaconteo_empleadoitinerante", "id_actaconteo_empleadoitinerante", $eliminar_empleados);
			$query = $db->query($sql);
		}
		if($this->request->getPost("numDocumento")){
			$elementos = array(
				'horaInicio' => $this->request->getPost("horaInicio"),
				'horaFin' => $this->request->getPost("horaFin"),
				'nombre' => $this->request->getPost("nombre"),
				'numDocumento' => $this->request->getPost("numDocumento"),
				'cargo' => $this->request->getPost("cargo"),
				'temaEncuentro' => $this->request->getPost("temaEncuentro"),
				'necesidades' => $this->request->getPost("necesidades"),
				'participantes' => $this->request->getPost("participantes"),
				'id_actaconteo' => $id_actaconteo

			);
			$fechas = $this->request->getPost("fecha");
			if(count($fechas) > 0) {
				$fechas = $this->conversiones->array_fechas(1, $fechas);
				$elementos['fecha'] = $fechas;
			}
			$sql = $this->conversiones->multipleinsert("cob_actaconteo_empleadoitinerante", $elementos);
			$query = $db->query($sql);
			if (!$query) {
				foreach ($query->getMessages() as $message) {
					$this->flash->error($message);
				}
				return $this->response->redirect("cob_actaconteo/seguimientoitinerante/$id_actaconteo");
			}
			$this->flash->success("Los empleados fueron guardados exitosamente");
			return $this->response->redirect("cob_actaconteo/seguimientoitinerante/$id_actaconteo");
		}
		$this->flash->success("Los empleados fueron eliminados exitosamente");
		return $this->response->redirect("cob_actaconteo/seguimientoitinerante/$id_actaconteo");
	}

	/**
	* index action
	*/
	public function cargaractasAction($id_actaconteo)
	{
		if (!$this->request->isPost()) {
			$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
			if (!$acta) {
				$this->flash->error("El acta no fue encontrada");
				return $this->response->redirect("cob_periodo/");
			}
			$this->persistent->parameters = null;
			$bc_carga_acta = BcCargaActa::find(array(
				"id_actaconteo = $id_actaconteo"
			));
			if (count($bc_carga_acta) == 0) {
				$this->flash->notice("No se ha agregado ninguna carga de acta hasta el momento");
				$bc_carga_acta = null;
			}
			$this->view->bc_carga_acta = $bc_carga_acta;
			$this->view->id_actaconteo = $id_actaconteo;
			$this->view->acta          = $acta;
		}
	}

	/**
	* Formulario para la relación de una nueva carga acta - plantillas
	*
	* @param int $id_actaconteo
	*/
	public function nuevoAction($id_actaconteo) {
		if (!$this->request->isPost()) {
			$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
			if (!$acta) {
				$this->flash->error("El acta no fue encontrada");
				return $this->response->redirect("cob_periodo/");
			}
			$this->assets
			->addJs('js/bootstrap-filestyle.min.js')
			->addJs('js/parsley.min.js')
			->addJs('js/parsley.extend.js')
			->addJs('js/jquery.autoNumeric.js')
			->addJs('js/adicionalescapturas.js');
			$this->view->id_actaconteo = $id_actaconteo;
			$this->view->acta = $acta;
		}
	}

	/**
	* Para crear una carga de actas - plantillas, aquí es a donde se dirige el formulario de crearAction
	*/
	public function crearAction($id_actaconteo)
	{
		if (!$this->request->isPost()) {
			return $this->response->redirect("cob_actaconteo/cargaractas/$id_actaconteo");
		}

		$bc_carga_acta                = new BcCargaActa();
		$bc_carga_acta->id_actaconteo = $id_actaconteo;
		$bc_carga_acta->mes           = (int)date('m');
		$bc_carga_acta->fecha         = date('Y-m-d H:i:s');
		$bc_carga_acta->id_usuario    = $this->session->auth['id_usuario'];

		if($this->request->hasFiles() == true){
			$uploads = $this->request->getUploadedFiles();
			$isUploaded = false;
			$i = 1;
			foreach($uploads as $upload){
				$path = "files/cob_bd/".$id_actaconteo."-".$upload->getname();
				$bc_carga_acta->nombreArchivo = $id_actaconteo."-".$upload->getname();

				($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
				$i++;
			}
			if($isUploaded){
				if (!$bc_carga_acta->save()) {
					foreach ($bc_carga_acta->getMessages() as $message) {
						$this->flash->error($message);
					}

					return $this->response->redirect("cob_actaconteo/nuevo/$id_actaconteo");
				}

				$this->flash->success("La carga de actas fue realizada exitosamente.");

				return $this->response->redirect("cob_actaconteo/cargaractas/$id_actaconteo");
			} else {
				$this->flash->error("Ocurrió un error al cargar el archivo");
				return $this->response->redirect("cob_actaconteo/nuevo/$id_actaconteo");
			}
		} else {
			$this->flash->error("Debes de seleccionar el archivo");
			return $this->response->redirect("cob_actaconteo/nuevo/$id_actaconteo");
		}
	}

	/**
	* Elimina una carga
	*
	*
	* @param string $id_carga
	*/
	public function eliminarAction($id_carga_acta)
	{
		if (!$this->request->isPost()) {
			return $this->response->redirect("cob_actaconteo/cargaractas/$id_actaconteo");
		}

		$bc_carga_acta = BcCargaActa::findFirstByid_carga($id_carga);
		if (!$bc_carga_acta) {
			$this->flash->error("Esta carga no fue encontrada");
			return $this->response->redirect("cob_actaconteo/");
		}

		if (!$bc_carga_acta->delete()) {

			foreach ($bc_carga_acta->getMessages() as $message) {
				$this->flash->error($message);
			}
			return $this->response->redirect("cob_actaconteo/");
		}

		$this->flash->success("La carga de acta fue eliminada exitosamente");
		return $this->response->redirect("cob_actaconteo/");
	}
}
