<?php
use Phalcon\DI\FactoryDefault;

class CobActamuestreo extends \Phalcon\Mvc\Model
{

	/**
     *
     * @var integer
     */
    public $id_actamuestreo;

    /**
     *
     * @var integer
     */
    public $id_periodo;

    /**
     *
     * @var integer
     */
    public $id_carga;

    /**
     *
     * @var integer
     */
    public $recorrido;

    /**
     *
     * @var integer
     */
    public $id_contrato;

    /**
     *
     * @var integer
     */
    public $id_modalidad;

    /**
     *
     * @var string
     */
    public $modalidad_nombre;

    /**
     *
     * @var integer
     */
    public $id_sede;

    /**
     *
     * @var string
     */
    public $sede_nombre;

    /**
     *
     * @var string
     */
    public $sede_barrio;

    /**
     *
     * @var string
     */
    public $sede_comuna;

    /**
     *
     * @var string
     */
    public $sede_direccion;

    /**
     *
     * @var string
     */
    public $sede_telefono;

    /**
     *
     * @var integer
     */
    public $id_oferente;

    /**
     *
     * @var string
     */
    public $oferente_nombre;

    /**
     *
     * @var integer
     */
    public $id_usuario;

    /**
     *
     * @var integer
     */
    public $estado;


    //Virtual Foreign Key para poder acceder a la fecha de corte del acta
	public function initialize()
	{
		$this->belongsTo('id_periodo', 'CobPeriodo', 'id_periodo', array(
			'reusable' => true
		));
		$this->belongsTo('id_actamuestreo', 'CobActamuestreoDatos', 'id_actamuestreo', array(
				'reusable' => true
		));
		$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
				'reusable' => true
		));
		$this->belongsTo('estado', 'IbcReferencia', 'id_referencia', array(
				'reusable' => true
		));
		$this->hasMany('id_actamuestreo', 'CobActamuestreoPersona', 'id_actamuestreo', array(
				'reusable' => true
		));
	}

	public function muestra($id_periodo){
		/**Autores: Lina Hurtado y Julián Marín**/
		// Población
		$N = count(CobActamuestreoPersonaFacturacion::find(["id_periodo = $id_periodo"]));
		// Nivel de confianza del 99%
		$Z = 2.58;
		// Porcentaje de error del 3%
		$d = 0.03;
		// Proporción de la variable p 50%
		$p = 0.5;
		// Proporción de la variable q 50%
		$q = 0.5;
		$muestra = ($N * ($Z * $Z) * $p * $q) / (($d * $d) * ($N - 1) + ($Z * $Z) * $p * $q);
		$condicion_muestra = $muestra / $N;
		if($condicion_muestra > 0.05){
			$muestra2 = $muestra / (1 + ($muestra / $N));
			return round($muestra2, 0);
		}
		return round($muestra, 0);
	}

    public function generarActasRcarga($cob_periodo, $carga, $recorrido_anterior) {
      //Datos de METROSALUD
      $id_contrato_metro = 4600063786;
      $id_oferente_metro = 26;
      $oferente_nombre_metro = "METROSALUD";
      $id_modalidad_metro = 5;
      $modalidad_nombre_metro = "ENTORNO FAMILIAR";

      $recorrido = $recorrido_anterior + 1;
    	$db = $this->getDI()->getDb();
    	$config = $this->getDI()->getConfig();
    	$timestamp = new DateTime();
    	$tabla_mat = "m" . $timestamp->getTimestamp();
      $tabla_sed = "s" . $timestamp->getTimestamp();
    	$archivo_mat = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreMat;
      $archivo_sed = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreSedes;
      $db->query("CREATE TEMPORARY TABLE $tabla_mat (tipoParticipante VARCHAR(20), tipoEncuentro VARCHAR(20), fechaEncuentro DATE, horaEncuentro TIME, id_contrato BIGINT, id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_comuna VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_persona VARCHAR(100), numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), grupo VARCHAR(80), fechaNacimiento DATE) CHARACTER SET utf8 COLLATE utf8_bin");
      $db->query("CREATE TEMPORARY TABLE $tabla_sed (grupo VARCHAR(80), tipoParticipante VARCHAR(20), tipoEncuentro VARCHAR(20), fechaEncuentro DATE, horaEncuentro TIME, id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_comuna VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80)) CHARACTER SET utf8 COLLATE utf8_bin");
    	$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_mat FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@id_persona, @numDocumento, @primerNombre, @segundoNombre, @primerApellido, @segundoApellido, @fechaNacimiento, @grupo) SET id_persona = @id_persona, numDocumento = @numDocumento, primerNombre = @primerNombre, segundoNombre = @segundoNombre, primerApellido = @primerApellido, segundoApellido = @segundoApellido, fechaNacimiento = @fechaNacimiento, grupo = @grupo");
      $db->query("LOAD DATA INFILE '$archivo_sed' IGNORE INTO TABLE $tabla_sed FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@idCalendario, @gestorZonal, @tipoEncuentro, @novedad, @fechaEncuentro, @horaEncuentro, @grupo, @tipoGrupo, @id_sede, @sede_telefono, @sede_telefono2, @sede_comuna, @sede_barrio, @tipoParticipante, @sede_nombre, @sede_direccion) SET grupo = @grupo, tipoParticipante = @tipoParticipante, tipoEncuentro = @tipoEncuentro, fechaEncuentro = @fechaEncuentro, horaEncuentro = @horaEncuentro, id_sede = @id_sede, sede_nombre = @sede_nombre, sede_barrio = @sede_barrio, sede_comuna = @sede_comuna, sede_direccion = @sede_direccion, sede_telefono = @sede_telefono");
      //Elimino los grupos que no se cargan
      $db->query("DELETE FROM $tabla_sed WHERE tipoEncuentro != 'NP' AND tipoEncuentro != 'LS' AND tipoEncuentro != 'MIXTO'");
      //Cruzo el horario con los participantes
      $db->query("UPDATE $tabla_mat, $tabla_sed SET $tabla_mat.tipoParticipante = $tabla_sed.tipoParticipante, $tabla_mat.tipoEncuentro = $tabla_sed.tipoEncuentro, $tabla_mat.fechaEncuentro = $tabla_sed.fechaEncuentro, $tabla_mat.horaEncuentro = $tabla_sed.horaEncuentro, $tabla_mat.id_contrato = $id_contrato_metro, $tabla_mat.id_sede = $tabla_sed.id_sede, $tabla_mat.sede_nombre = $tabla_sed.sede_nombre, $tabla_mat.sede_barrio = $tabla_sed.sede_barrio, $tabla_mat.sede_comuna = $tabla_sed.sede_comuna, $tabla_mat.sede_direccion = $tabla_sed.sede_direccion, $tabla_mat.sede_telefono = $tabla_sed.sede_telefono WHERE $tabla_mat.grupo LIKE CONCAT('%', $tabla_sed.grupo, '%')");
      //Elimino los participantes que no cruzaron con el horario
      $db->query("DELETE FROM $tabla_mat WHERE id_sede IS NULL OR id_sede = 0");
      //Creo actas de conteo
      $db->query("INSERT IGNORE INTO cob_actamuestreo (id_periodo, id_carga, recorrido, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_comuna, sede_direccion, sede_telefono, id_oferente, oferente_nombre) SELECT $cob_periodo->id_periodo, $carga->id_carga, $recorrido, $id_contrato_metro, $id_modalidad_metro, '$modalidad_nombre_metro', id_sede, sede_nombre, sede_barrio, sede_comuna, sede_direccion, sede_telefono, $id_oferente_metro, '$oferente_nombre_metro' FROM $tabla_mat");
    	$db->query("INSERT IGNORE INTO cob_actamuestreo_persona (id_actamuestreo, id_periodo, recorrido, id_sede, grupo, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, tipoParticipante, tipoEncuentro, fechaEncuentro, horaEncuentro) SELECT (SELECT id_actamuestreo FROM cob_actamuestreo WHERE cob_actamuestreo.id_sede = $tabla_mat.id_sede AND cob_actamuestreo.id_periodo = $cob_periodo->id_periodo AND cob_actamuestreo.recorrido = $recorrido), $cob_periodo->id_periodo, $recorrido, id_sede, grupo, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, tipoParticipante, tipoEncuentro, fechaEncuentro, horaEncuentro FROM $tabla_mat");
    	$db->query("DROP TABLE $tabla_mat");
      $db->query("DROP TABLE $tabla_sed");
    	return TRUE;
    }

    //Verificar este proceso
    public function generarActasFacturacion($cob_periodo, $recorrido_anterior) {
    	$recorrido = $recorrido_anterior + 1;
    	$carga = BcCarga::findFirstByid_carga($cob_periodo->id_carga_facturacion);
    	$db = $this->getDI()->getDb();
    	$timestamp = new DateTime();
    	$tabla_mat = "m" . $timestamp->getTimestamp();
    	$db->query("CREATE TEMPORARY TABLE $tabla_mat (fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE) CHARACTER SET utf8 COLLATE utf8_bin");
    	$rows = CobActaconteoPersona::find(["id_periodo = $cob_periodo->id_periodo AND recorrido = $recorrido_anterior AND (asistencia = 2 OR asistencia = 3 OR asistencia = 4 OR asistencia = 6 OR asistencia = 8)"]);
    	if(count($rows) > 0){
    	$sql = "INSERT INTO $tabla_mat (id_sede_contrato,id_contrato,id_modalidad,modalidad_nombre,id_sede,sede_nombre,sede_barrio,sede_direccion,sede_telefono,id_oferente,oferente_nombre,id_persona,numDocumento,primerNombre,segundoNombre,primerApellido,segundoApellido,id_grupo,grupo) VALUES ";
    		foreach ($rows as $row) {
    			$sql .= "(\"". $row->CobActaconteo->id_sede_contrato. "\",\"".$row->CobActaconteo->id_contrato."\",\"".$row->CobActaconteo->id_modalidad."\",\"".$row->CobActaconteo->modalidad_nombre."\",\"".$row->CobActaconteo->id_sede."\",\"".$row->CobActaconteo->sede_nombre."\",\"".$row->CobActaconteo->sede_barrio."\",\"".$row->CobActaconteo->sede_direccion."\",\"".$row->CobActaconteo->sede_telefono."\",\"".$row->CobActaconteo->id_oferente."\",\"".$row->CobActaconteo->oferente_nombre."\",\"".$row->id_persona."\",\"".$row->numDocumento."\",\"".$row->primerNombre."\",\"".$row->segundoNombre."\",\"".$row->primerApellido."\",\"".$row->segundoApellido."\",\"".$row->id_grupo."\",\"".$row->grupo."\"),";
    		}
    		$sql = substr($sql, 0, -1);
    		$db->query($sql);
    	}
    	$db->query("INSERT IGNORE INTO cob_actaconteo (id_periodo, id_carga, recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre) SELECT $cob_periodo->id_periodo, $carga->id_carga, $recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre FROM $tabla_mat");
    	$db->query("INSERT IGNORE INTO cob_actaconteo_persona (id_actaconteo, id_periodo, recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo) SELECT (SELECT id_actaconteo FROM cob_actaconteo WHERE cob_actaconteo.id_sede_contrato = $tabla_mat.id_sede_contrato AND cob_actaconteo.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo.recorrido = $recorrido), $cob_periodo->id_periodo, $recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo FROM $tabla_mat");
    	$db->query("DROP TABLE $tabla_mat");
    	return TRUE;
    }

    public function cerrarPeriodo($id_periodo) {
    	$rows = CobActaconteoPersona::find(["id_periodo = $id_periodo AND (asistencia = 1 OR asistencia = 7)"]);
    	if(count($rows) > 0){
    		$sql = "INSERT INTO $tabla_mat (id_sede_contrato,id_contrato,id_modalidad,modalidad_nombre,id_sede,sede_nombre,sede_barrio,sede_direccion,sede_telefono,id_oferente,oferente_nombre,id_persona,numDocumento,primerNombre,segundoNombre,primerApellido,segundoApellido,id_grupo,grupo) VALUES ";
    		foreach ($rows as $row) {
    			$sql .= "(\"". $row->CobActaconteo->id_sede_contrato. "\",\"".$row->CobActaconteo->id_contrato."\",\"".$row->CobActaconteo->id_modalidad."\",\"".$row->CobActaconteo->modalidad_nombre."\",\"".$row->CobActaconteo->id_sede."\",\"".$row->CobActaconteo->sede_nombre."\",\"".$row->CobActaconteo->sede_barrio."\",\"".$row->CobActaconteo->sede_direccion."\",\"".$row->CobActaconteo->sede_telefono."\",\"".$row->CobActaconteo->id_oferente."\",\"".$row->CobActaconteo->oferente_nombre."\",\"".$row->id_persona."\",\"".$row->numDocumento."\",\"".$row->primerNombre."\",\"".$row->segundoNombre."\",\"".$row->primerApellido."\",\"".$row->segundoApellido."\",\"".$row->id_grupo."\",\"".$row->grupo."\"),";
    		}
    		$sql = substr($sql, 0, -1);
    		$db->query($sql);
    	}
    	$db->query("INSERT IGNORE INTO cob_actaconteo (id_periodo, id_carga, recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre) SELECT $cob_periodo->id_periodo, $carga->id_carga, $recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre FROM $tabla_mat");
    	$db->query("INSERT IGNORE INTO cob_actaconteo_persona (id_actaconteo, id_periodo, recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo) SELECT (SELECT id_actaconteo FROM cob_actaconteo WHERE cob_actaconteo.id_sede_contrato = $tabla_mat.id_sede_contrato AND cob_actaconteo.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo.recorrido = $recorrido), $cob_periodo->id_periodo, $recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo FROM $tabla_mat");
    	$db->query("DROP TABLE $tabla_mat");
    	return TRUE;
    }

    public function generarActa($id_actamuestreo){
    	$acta = CobActamuestreo::findFirstByid_actamuestreo($id_actamuestreo);
    	if(!$acta || $acta == NULL){
    		return FALSE;
    	}
    	$conversiones = $this->getDI()->getConversiones();
    	$encabezado = "<div class='seccion encabezado'>
    		<div class='fila center'><div>ACTA DE MUESTREO DE VERIFICACIÓN FÍSICA DE LA ATENCIÓN DE LOS BENEFICIARIOS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE METROSALUD<br>INTERVENTORÍA BUEN COMIENZO - <em>FECHA DE REPORTE ".$conversiones->fecha(2, $acta->CobPeriodo->fecha)." (RECORRIDO $acta->recorrido)</em></div></div>
    		<div class='fila col3 center'><div>Código: F-ITBC-GC-001</div><div>&nbsp;&nbsp;</div><div></div></div>
    		<div class='fila col3e'>
    			<div>ACTA: <span style='font-weight: normal;'>".$acta->getIdDetail()."</span></div>
    			<div class='col2da'>NÚMERO DE CONTRATO: <span style='font-weight: normal;'>$acta->id_contrato</span></div>
    			<div>MODALIDAD: <span style='font-weight: normal;'>$acta->modalidad_nombre</span></div>
    		</div>
    		<div class='fila col3e'>
    			<div>RUTA: <span style='font-weight: normal;'>".$acta->IbcUsuario->usuario."</span></div>
    			<div class='col2da'>PRESTADOR: <span style='font-weight: normal;'>".substr($acta->oferente_nombre, 0, 35)."</span></div>
    			<div>SEDE: <span style='font-weight: normal;'>$acta->sede_nombre</span></div>
    		</div>
    		<div class='fila col3e'>
    			<div>TELÉFONO: <span style='font-weight: normal;'>$acta->sede_telefono</span></div>
    			<div class='col2da'>DIRECCIÓN: <span style='font-weight: normal;'>$acta->sede_direccion</span></div>
    			<div>BARRIO/VEREDA: <span style='font-weight: normal;'>$acta->sede_barrio</span></div>
    		</div>
    		<div class='clear'></div>
    	</div>";
    	$pie_pagina = "<div id='pie_pagina'>
	    	<div class='pull-left' style='padding-left: 60px; width: 50%; text-align: center; float: left;'>________________________________________________<br>FIRMA PERSONA ENCARGADA DE LA SEDE</div>
	    	<div class='pull-right' style='padding-right: 60px; width: 50%; text-align: center; float: left;'>________________________________________________<br>FIRMA PERSONA ENCARGADA DE INTERVENTORÍA<br></div>
    		<div class='clear'></div>
    	</div>";
    	$totalizacion_asistencia = "<div class='seccion' id='totalizacion_asistencia'>
    		<div class='fila center bold'><div style='border:none; width: 100%'>1. TOTALIZACIÓN DE ASISTENCIA</div></div>
	    	<div class='fila'><div>1.1 ASISTE</div></div>
	    	<div class='fila'><div>1.4 RETIRADO</div></div>
	    	<div class='fila'><div>1.6 AUSENTE QUE NO PRESENTA EXCUSA EL DÍA DEL REPORTE</div></div>
	    	<div class='fila'><div>1.7 CON EXCUSA MÉDICA MAYOR O IGUAL A 15 DIAS</div></div>
	    	<div class='fila'><div>1.8 CON EXCUSA MÉDICA MENOR A 15 DIAS</div></div>
    		<div class='clear'></div>
    	</div>";
    	$datos_acta = array();
    	$datos_acta['datos'] = $acta;
    	$html = "";
    	$html .= "<div id='imprimir'>"; // <acta>
    	//Página Prestador
    	$html .= $encabezado;
    	$html .= $totalizacion_asistencia;
    	$html .= "
    	<div class='seccion' id='datos_generales'>
    		<div class='fila center bold'><div style='border:none; width: 100%'>2. DATOS GENERALES</div></div>
	    	<div class='fila col3'><div>2.1 FECHA INTERVENTORÍA:</div><div>2.2 HORA INICIO INTERVENTORÍA:</div><div>2.3 HORA FIN INTERVENTORÍA:</div></div>
    		<div class='clear'></div>
    	</div>";
    	$html .= $pie_pagina;
    	$html .= "<div class='paginacion'>PÁGINA DEL PRESTADOR</div>";
      //Página en blanco para impresión a doble cara
      $html .= "<div class='seccion encabezado' style='border: none'></div>";
    	//Página 1
    	$html .= $encabezado;
    	$html .= $totalizacion_asistencia;
    	$html .= "
    	<div class='seccion' id='datos_generales'>
    		<div class='fila center bold'><div style='border:none; width: 100%'>2. DATOS GENERALES</div></div>
	    	<div class='fila col3'>
    			<div>2.1 FECHA INTERVENTORÍA:</div>
    			<div>2.2 HORA INICIO INTERVENTORÍA:</div>
    			<div>2.3 HORA FIN INTERVENTORÍA:</div>
    		</div>
    		<div class='fila col2'>
    			<div style='width: 55%;'>2.4 NOMBRE ENCARGADO DE LA SEDE:</div>
    			<div style='width: 40%;'>2.5 NOMBRE INTERVENTOR:</div>
    		</div>
    		<div class='fila col2'>
    			<div>2.6 CUENTA CON PENDÓN DE IDENTIFICACIÓN:</div>
    			<div>2.7 CORRECCIÓN DIRECCIÓN:</div>
    		</div>
    		<div class='clear'></div>
    	</div>
    	<div class='seccion' id='observaciones'>
    		<div class='fila center bold'><div style='border:none; width: 100%'>3. OBSERVACIONES AL MOMENTO DE LA INTERVENTORÍA</div></div>
    		<div class='fila observacion'><div>3.1 OBSERVACIÓN DEL INTERVENTOR:<br>3.1.1 Cuenta con servicio sanitario, lavamanos, energía eléctrica y agua potable: __<br>3.1.2 Cuenta con las condiciones mínimas de seguridad de conformidad con el Plan de Ordenamiento Territorial (POT): __</div></div>
    		<div class='fila observacion'><div>3.2 OBSERVACIÓN DEL ENCARGADO DE LA SEDE:</div></div>
    		<div class='clear'></div>
    	</div>";
    	$html .= $pie_pagina;
    	$p = 1;
    	$html .= "<div class='paginacion'>PÁGINA $p</div>";
  		$i = 1;
  		$j = 1;
  		/*
  		 * Si el acta está en la modalidad Entorno Comunitario, Entorno Familiar o Jardines Infantiles
  		 * se imprimen las actas con la casilla de fecha de visita, de lo contrario la fecha se omite
  		 */
  		$fecha_lista = "";
  		$fecha_encabezado = "";
  		$fecha_encabezado2 = "";
  		if($acta->id_modalidad == 3 || $acta->id_modalidad == 5 || $acta->id_modalidad == 7){
  			$fecha_encabezado = "<div>4.5 FECHA VISITA</div>";
  			$fecha_encabezado2 = "<div>5.5 FECHA VISITA</div>";
  			$fecha_lista =  "<div></div>";
  		}
  		$encabezado_beneficiarios = "<div class='seccion' id='listado_beneficiarios'>
    		<div class='fila center bold'><div style='border:none; width: 100%'>4. LISTADO DE BENEFICIARIOS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE METROSALUD</div></div>
    		<div class='fila colb2'><div style='width: 5%;'>#</div><div style='width: 10%;'>4.1 DOCUMENTO</div><div style='width: 24%'>4.2 NOMBRE COMPLETO</div><div style='width: 8%'>4.3 GRUPO</div><div style='width: 10%;'>4.4 FECHA ENCUENTRO</div><div style='width: 10%;'>4.5 HORA ENCUENTRO</div><div style='width: 10%'>4.6 CICLO VITAL</div><div style='width: 10%'>4.7 COMPL ALIMIENTARIO</div><div style='width: 10%'>4.8 ASISTENCIA</div></div>";
  		$html .= $encabezado;
  		$html .= $encabezado_beneficiarios;
  		foreach($acta->getCobActamuestreoPersona(['order' => 'grupo, primerNombre asc']) as $row){
  			$nombre_completo = array($row->primerNombre, $row->segundoNombre, $row->primerApellido, $row->segundoApellido);
  			$nombre_completo = implode(" ", $nombre_completo);
  			$i = ($i<10) ? "0" .$i : $i;
  			if($j == 31){
  				$j = 1;
  				$p++;
  				$html .= "<div class='clear'></div></div>" . $pie_pagina;
  				$html .= "<div class='paginacion'>PÁGINA $p</div>";
  				$html .= $encabezado;
  				$html .= $encabezado_beneficiarios;
  			}
  		$html .="<div class='fila colb'><div style='width: 5%;'>$i</div><div style='width: 10%;'>$row->numDocumento</div><div style='width: 24%'>$nombre_completo</div><div style='width: 8%;'>$row->grupo</div><div style='width: 10%;'>".$conversiones->fecha(2, $row->fechaEncuentro)."</div><div style='width: 10%;'>$row->horaEncuentro</div><div style='width: 10%'>&nbsp;&nbsp;</div><div style='width: 10%'>&nbsp;&nbsp;</div><div style='width: 10%'></div></div>";
  			$i++;
  			$j++;
  		}
  		$p++;
  		$html .= "<div class='clear'></div></div>" . $pie_pagina;
  		$html .= "<div class='paginacion'>PÁGINA $p</div>";
  		$html .= "<div class='clear'></div>"; // </acta>
    	$datos_acta['html'] = $html;
    	return $datos_acta;
    }

    /**
     * Returns a human representation of 'estado'
     *
     * @return string
     */
    public function getEstadoDetail()
    {
    	switch ($this->estado) {
    		case 0:
    			return "Inactiva";
    			break;
    		case 1:
    			return "Activa";
    			break;
    		case 2:
    			return "Cerrada por Interventor";
    			break;
    		case 3:
    			return "Cerrada por Auxiliar";
    			break;
    		case 4:
    			return "Consolidada";
    			break;
    		case 5:
    			return "Periodo cerrado";
    			break;
    	}
    }

    /**
     * Returns a human representation of 'id_actamuestreo'
     *
     * @return string
     */
    public function getIdDetail()
    {
    	return "AMU-03-". date("Y") . sprintf('%05d', $this->id_actamuestreo);
    }

    /**
     * Returns a human representation of 'id_actamuestreo'
     *
     * @return string
     */
    public function getId()
    {
    	return $this->id_actamuestreo;
    }

    /**
     * Contar beneficiarios
     *
     * @return string
     */
    public function countBeneficiarios()
    {
    	return count($this->CobActamuestreoPersona);
    }

    /**
     * Returns a human representation of 'cicloVital'
     *
     * @return string
     */
    public function getCicloVitalDetail()
    {
    switch ($this->cicloVital) {
    		case 0:
    			return "";
    		case 1:
    			return "G";
    			break;
    		case 2:
    			return "L";
    			break;
    		case 3:
    			return "GL";
    			break;
    		case 4:
    			return "N";
    			break;
    		case 5:
    			return "NM";
    			break;
    		case 6:
    			return "NC";
    			break;
    		case 7:
    			return "GLN";
    			break;
    	}
    }

    /**
     * Returns a human representation of 'url'
     *
     * @return string
     */
    public function getUrlDetail()
    {
    	return "cob_actamuestreo/ver/$this->id_actamuestreo";
    }
}
