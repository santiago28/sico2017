<?php
use Phalcon\DI\FactoryDefault;

class CobActaconteo extends \Phalcon\Mvc\Model
{

	/**
	*
	* @var integer
	*/
	public $id_actaconteo;

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
	public $id_sede_contrato;

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
		$this->belongsTo('id_actaconteo', 'CobActaconteoDatos', 'id_actaconteo', array(
			'reusable' => true
		));
		$this->belongsTo('id_actaconteo', 'CobActaconteoMcb', 'id_actaconteo', array(
			'reusable' => true
		));
		$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
			'reusable' => true
		));
		$this->belongsTo('estado', 'IbcReferencia', 'id_referencia', array(
			'reusable' => true
		));
		$this->hasMany("id_sede_contrato", "CobActaconteoPersonaFacturacion", "id_sede_contrato");
		$this->hasMany('id_actaconteo', 'CobActaconteoPersona', 'id_actaconteo', array(
			'foreignKey' => array(
				'message' => 'El acta no puede ser eliminada porque existen beneficiarios asociados a ésta'
			)
		));
		$this->hasMany('id_actaconteo', 'CobActaconteoEmpleado', 'id_actaconteo', array(
			'foreignKey' => array(
				'message' => 'El acta no puede ser eliminada porque existen empleados asociados a ésta'
			)
		));
	}

	public function generarActasRcarga($cob_periodo, $carga, $facturacion, $recorrido_anterior) {
		$recorrido = $recorrido_anterior + 1;
		$db = $this->getDI()->getDb();
		$config = $this->getDI()->getConfig();
		$timestamp = new DateTime();
		$tabla_mat = "m" . $timestamp->getTimestamp();
		$archivo_mat = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreMat;
		$db->query("CREATE TEMPORARY TABLE $tabla_mat (id_actaconteo INT, certificacionRecorridos INT, fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE, cuartoupaJI INT, codigoHCB BIGINT, nombreHCB VARCHAR(100), numeroDocumentoMCB VARCHAR(100), primerNombreMCB VARCHAR(20), segundoNombreMCB VARCHAR(20), primerApellidoMCB VARCHAR(20), segundoApellidoMCB VARCHAR(20), direccionHCB VARCHAR(100), comunaCorregimientoHCB VARCHAR(100) ) CHARACTER SET utf8 COLLATE utf8_bin");
		$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_mat FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\"), id_persona = @ID_PERSONA, numDocumento = @NUMERO_DOCUMENTO, primerNombre = TRIM(REPLACE(@PRIMER_NOMBRE, '\"',\"\")), segundoNombre = TRIM(REPLACE(@SEGUNDO_NOMBRE, '\"',\"\")), primerApellido = TRIM(REPLACE(@PRIMER_APELLIDO, '\"',\"\")), segundoApellido = TRIM(REPLACE(@SEGUNDO_APELLIDO, '\"',\"\")), id_grupo = @ID_GRUPO, grupo = REPLACE(@NOMBRE_GRUPO, '\"',\"\"), fechaInicioAtencion = @FECHA_INICIO_ATENCION, fechaRegistro = @FECHA_REGISTRO_MATRICULA, fechaRetiro = @FECHA_RETIRO, fechaNacimiento = @FECHA_NACIMIENTO, peso = @PESO, estatura = @ESTATURA, fechaControl = @FECHA_CONTROL, cuartoupaJI = @CUARTOUPA_JI, codigoHCB = @CODIGO_HCB, nombreHCB = @NOMBRE_HCB, numeroDocumentoMCB = @DOCUMENTO_MCB, primerNombreMCB = @PRIMER_NOMBRE_MCB, segundoNombreMCB = @SEGUNDO_NOMBRE_MCB, primerApellidoMCB = @PRIMER_APELLIDO_MCB, segundoApellidoMCB = @SEGUNDO_APELLIDO_MCB, direccionHCB = @DIRECCION_HCB, comunaCorregimientoHCB = @COMUNA_CORREGIMIENTO_HCB");

		//Inicio generar actas PP
		if($cob_periodo->tipo == 1){
			//Actualizar si cambia contrato de Mundo Mejor
			$id_contrato_mundomejor = 4600069619;
			$id_oferente_mundomejor = 9;
			$oferente_nombre_mundomejor = "MUNDO MEJOR - FUNDACION";
			$id_modalidad_mundomejor = 8;
			$modalidad_nombre_mundomejor = "PRESUPUESTO PARTICIPATIVO";
			$tabla_pp = "pp" . $timestamp->getTimestamp();
			$db->query("CREATE TEMPORARY TABLE $tabla_pp (certificacionRecorridos INT, fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE, otrosBeneficios VARCHAR(50)) CHARACTER SET utf8 COLLATE utf8_bin");
			$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_pp FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\"), id_persona = @ID_PERSONA, numDocumento = @NUMERO_DOCUMENTO, primerNombre = TRIM(REPLACE(@PRIMER_NOMBRE, '\"',\"\")), segundoNombre = TRIM(REPLACE(@SEGUNDO_NOMBRE, '\"',\"\")), primerApellido = TRIM(REPLACE(@PRIMER_APELLIDO, '\"',\"\")), segundoApellido = TRIM(REPLACE(@SEGUNDO_APELLIDO, '\"',\"\")), id_grupo = @ID_GRUPO, grupo = REPLACE(@NOMBRE_GRUPO, '\"',\"\"), fechaInicioAtencion = @FECHA_INICIO_ATENCION, fechaRegistro = @FECHA_REGISTRO_MATRICULA, fechaRetiro = @FECHA_RETIRO, fechaNacimiento = @FECHA_NACIMIENTO, peso = @PESO, estatura = @ESTATURA, fechaControl = @FECHA_CONTROL, otrosBeneficios = @OTROS_BENEFICIOS");
			$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios NOT LIKE 'PP%'");
			$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios LIKE '%R%'");
			$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios NOT LIKE '%ID%'");
			$db->query("UPDATE $tabla_pp SET id_sede = SUBSTRING_INDEX(otrosBeneficios,'ID',-1) WHERE 1");
			$db->query("UPDATE $tabla_pp, bc_sede_contrato SET $tabla_pp.id_sede_contrato = bc_sede_contrato.id_sede_contrato, $tabla_pp.sede_nombre = bc_sede_contrato.sede_nombre, $tabla_pp.sede_barrio = bc_sede_contrato.sede_barrio, $tabla_pp.sede_direccion = bc_sede_contrato.sede_direccion, $tabla_pp.sede_telefono = bc_sede_contrato.sede_telefono WHERE $tabla_pp.id_sede = bc_sede_contrato.id_sede AND bc_sede_contrato.id_contrato = $id_contrato_mundomejor");
			$db->query("DELETE FROM $tabla_mat WHERE id_modalidad = 8 AND id_contrato = $id_contrato_mundomejor");
			$db->query("INSERT IGNORE INTO $tabla_mat (id_contrato, id_sede_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, peso, estatura, fechaControl) SELECT $id_contrato_mundomejor, id_sede_contrato, $id_modalidad_mundomejor, '$modalidad_nombre_mundomejor', id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, $id_oferente_mundomejor, '$oferente_nombre_mundomejor', id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, peso, estatura, fechaControl FROM $tabla_pp");
		}//Fin generar actas PP //Inicio generar actas ENTORNO FAMILIAR
		else if($cob_periodo->tipo == 2){
			//Actualizar si cambia contrato de Mundo Mejor
			$id_contrato_mundomejor = 4600069619;
			$id_oferente_mundomejor = 9;
			$oferente_nombre_mundomejor = "MUNDO MEJOR - FUNDACION";
			$id_modalidad_mundomejor = 8;
			$modalidad_nombre_mundomejor = "PRESUPUESTO PARTICIPATIVO";
			$tabla_pp = "pp" . $timestamp->getTimestamp();
			$db->query("CREATE TEMPORARY TABLE $tabla_pp (certificacionRecorridos INT, fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE, otrosBeneficios VARCHAR(50)) CHARACTER SET utf8 COLLATE utf8_bin");
			$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_pp FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\"), id_persona = @ID_PERSONA, numDocumento = @NUMERO_DOCUMENTO, primerNombre = TRIM(REPLACE(@PRIMER_NOMBRE, '\"',\"\")), segundoNombre = TRIM(REPLACE(@SEGUNDO_NOMBRE, '\"',\"\")), primerApellido = TRIM(REPLACE(@PRIMER_APELLIDO, '\"',\"\")), segundoApellido = TRIM(REPLACE(@SEGUNDO_APELLIDO, '\"',\"\")), id_grupo = @ID_GRUPO, grupo = REPLACE(@NOMBRE_GRUPO, '\"',\"\"), fechaInicioAtencion = @FECHA_INICIO_ATENCION, fechaRegistro = @FECHA_REGISTRO_MATRICULA, fechaRetiro = @FECHA_RETIRO, fechaNacimiento = @FECHA_NACIMIENTO, peso = @PESO, estatura = @ESTATURA, fechaControl = @FECHA_CONTROL, otrosBeneficios = @OTROS_BENEFICIOS");
			$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios NOT LIKE 'PP%'");
			$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios LIKE '%R%'");
			$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios NOT LIKE '%ID%'");
			$db->query("UPDATE $tabla_pp SET id_sede = SUBSTRING_INDEX(otrosBeneficios,'ID',-1) WHERE 1");
			$db->query("UPDATE $tabla_pp, bc_sede_contrato SET $tabla_pp.id_sede_contrato = bc_sede_contrato.id_sede_contrato, $tabla_pp.sede_nombre = bc_sede_contrato.sede_nombre, $tabla_pp.sede_barrio = bc_sede_contrato.sede_barrio, $tabla_pp.sede_direccion = bc_sede_contrato.sede_direccion, $tabla_pp.sede_telefono = bc_sede_contrato.sede_telefono WHERE $tabla_pp.id_sede = bc_sede_contrato.id_sede AND bc_sede_contrato.id_contrato = $id_contrato_mundomejor");
			$db->query("DELETE FROM $tabla_mat WHERE id_modalidad = 8 AND id_contrato = $id_contrato_mundomejor");
			$db->query("INSERT IGNORE INTO $tabla_mat (id_contrato, id_sede_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, peso, estatura, fechaControl) SELECT $id_contrato_mundomejor, id_sede_contrato, $id_modalidad_mundomejor, '$modalidad_nombre_mundomejor', id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, $id_oferente_mundomejor, '$oferente_nombre_mundomejor', id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, peso, estatura, fechaControl FROM $tabla_pp");
		}

		// Para modalidad Itinerante
		if($cob_periodo->tipo == 4){
			$db->query("DELETE FROM $tabla_mat WHERE id_modalidad <> 12");
			$db->query("UPDATE $tabla_mat SET id_sede_contrato = CONCAT_WS('',codigoHCB,id_contrato), id_sede = codigoHCB, sede_nombre = nombreHCB, sede_direccion = direccionHCB, sede_barrio = comunaCorregimientoHCB WHERE 1");
		} else {
			$modalidades = "";
			foreach(CobActaconteo::find(array("id_periodo = $cob_periodo->id_periodo AND recorrido = $recorrido_anterior", "columns" => "id_modalidad", "group" => "id_modalidad"))->toArray() as $row){
				$modalidades = $modalidades . $row['id_modalidad'] . ",";
			}
			$modalidades = substr($modalidades, 0, -1);
			$db->query("DELETE FROM $tabla_mat WHERE id_modalidad NOT IN ($modalidades)");
		}

		if($facturacion == 1){
			$db->query("UPDATE $tabla_mat SET fechaRetiro = NULL WHERE fechaRetiro > '$cob_periodo->fecha'");
			$db->query("DELETE FROM $tabla_mat WHERE fechaRetiro > 0000-00-00 AND DATE_SUB('$cob_periodo->fecha', INTERVAL 30 DAY) > fechaRetiro OR '$cob_periodo->fecha' < fechaRetiro");
			$db->query("UPDATE $tabla_mat SET certificacionRecorridos = 2 WHERE fechaRetiro > 0000-00-00");
			$archivo_sed = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreSedes;
			$db->query("LOAD DATA INFILE '$archivo_sed' IGNORE INTO TABLE cob_periodo_contratosedecupos FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_SEDE_CONTRATO, @ID_OFERENTE, @RAZON_SOCIAL, @ID_SEDE, @NOMBRE_SEDE, @TELEFONO, @DIRECCION, @ID_BARRIO_VEREDA, @NOMBRE_BARRIO_VEREDA, @ID_COMUNA, @NOMBRE_COMUNA_CORREGIMIENTO, @ZONA_UBICACION, @FECHA_INICIO_ATENCION, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @CUPOS_SEDE, @CUPOS_EN_USO, @CUPOS_SOSTENIBILIDAD, @CUPOS_AMPLIACION, @TOTAL_CUPOS_CONTRATO, @COORDX, @COORDY, @COORDINADOR, @PROPIEDAD_INMUEBLE, @AREA, @CAPACIDAD_ATENCION, @GRUPOS_ACTIVOS, @FECHA_FIN_CONTRATO, @FECHA_ADICION_CONTRATO) SET id_periodo = $cob_periodo->id_periodo, id_sede_contrato = @ID_SEDE_CONTRATO, cuposSede = @CUPOS_SEDE, cuposSostenibilidad = @CUPOS_SOSTENIBILIDAD, cuposAmpliacion = @CUPOS_AMPLIACION, cuposTotal = @TOTAL_CUPOS_CONTRATO");
			$db->query("INSERT IGNORE INTO cob_actaconteo_persona_facturacion (id_periodo, id_sede_contrato, id_contrato, id_sede, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaInicioAtencion, fechaRegistro, fechaRetiro, fechaNacimiento, peso, estatura, fechaControl, certificacionRecorridos, certificacionFacturacion, cuartoupaJI) SELECT $cob_periodo->id_periodo, id_sede_contrato, id_contrato, id_sede, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaInicioAtencion, fechaRegistro, fechaRetiro, fechaNacimiento, peso, estatura, fechaControl, certificacionRecorridos, certificacionRecorridos, cuartoupaJI FROM $tabla_mat");
			$db->query("UPDATE cob_periodo SET id_carga_facturacion = $carga->id_carga WHERE id_periodo = $cob_periodo->id_periodo");
			$db->query("UPDATE cob_actaconteo_persona, cob_actaconteo_persona_facturacion SET cob_actaconteo_persona.id_actaconteo_persona_facturacion = cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion WHERE cob_actaconteo_persona.id_contrato = cob_actaconteo_persona_facturacion.id_contrato AND cob_actaconteo_persona.numDocumento = cob_actaconteo_persona_facturacion.numDocumento AND cob_actaconteo_persona.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $cob_periodo->id_periodo");
			$db->query("UPDATE cob_actaconteo_persona_facturacion, cob_actaconteo_persona SET cob_actaconteo_persona_facturacion.acta1 = cob_actaconteo_persona.id_actaconteo, cob_actaconteo_persona_facturacion.asistencia1 = cob_actaconteo_persona.asistencia, cob_actaconteo_persona_facturacion.id_actaconteo_persona1 = cob_actaconteo_persona.id_actaconteo_persona WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion AND cob_actaconteo_persona.recorrido = 1 AND cob_actaconteo_persona.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $cob_periodo->id_periodo");
			$db->query("UPDATE cob_actaconteo_persona_facturacion, cob_actaconteo_persona SET cob_actaconteo_persona_facturacion.acta2 = cob_actaconteo_persona.id_actaconteo, cob_actaconteo_persona_facturacion.asistencia2 = cob_actaconteo_persona.asistencia, cob_actaconteo_persona_facturacion.id_actaconteo_persona2 = cob_actaconteo_persona.id_actaconteo_persona WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion AND cob_actaconteo_persona.recorrido = 2 AND cob_actaconteo_persona.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $cob_periodo->id_periodo");
		}
		$db->query("DELETE FROM $tabla_mat WHERE fechaRetiro > 0000-00-00");
		if( $cob_periodo->tipo != 2 ) {
			$eliminar = CobActaconteoPersona::find(["id_periodo = $cob_periodo->id_periodo AND recorrido < $recorrido AND (asistencia = 1 OR asistencia = 7 OR asistencia = 9 OR asistencia = 10)"]);
		}
		else {
			$eliminar = CobActaconteoPersona::find(["id_periodo = $cob_periodo->id_periodo AND recorrido < $recorrido AND (asistencia = 1 OR asistencia = 4 OR asistencia = 5)"]);
		}
		if(count($eliminar) > 0){
			$sql = "DELETE FROM $tabla_mat WHERE CONCAT_WS('-',id_contrato,numDocumento) IN (";
			foreach($eliminar as $row){
				$sql .= "'$row->id_contrato-$row->numDocumento',";
			}
			$sql = substr($sql, 0, -1);
			$sql .= ")";
			$db->query($sql);
		}
		$db->query("INSERT IGNORE INTO cob_actaconteo (id_periodo, id_carga, recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre) SELECT $cob_periodo->id_periodo, $carga->id_carga, $recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre FROM $tabla_mat");
		$db->query("REPLACE INTO bc_sede_contrato (id_sede_contrato, id_oferente, oferente_nombre, id_contrato, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_modalidad, modalidad_nombre, estado) SELECT id_sede_contrato, id_oferente, oferente_nombre, id_contrato, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_modalidad, modalidad_nombre, '1' FROM $tabla_mat");
		$db->query("INSERT IGNORE INTO cob_actaconteo_persona (id_actaconteo, id_periodo, recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaNacimiento) SELECT (SELECT id_actaconteo FROM cob_actaconteo WHERE cob_actaconteo.id_sede_contrato = $tabla_mat.id_sede_contrato AND cob_actaconteo.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo.recorrido = $recorrido), $cob_periodo->id_periodo, $recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaNacimiento FROM $tabla_mat");
		//Si es Itinerante se graban las madres comunitarias
		if($cob_periodo->tipo == 4) {
			$db->query("UPDATE $tabla_mat, cob_actaconteo SET $tabla_mat.id_actaconteo = cob_actaconteo.id_actaconteo WHERE $tabla_mat.id_contrato = cob_actaconteo.id_contrato AND $tabla_mat.id_sede = cob_actaconteo.id_sede AND cob_actaconteo.id_periodo = $cob_periodo->id_periodo");
			$db->query("INSERT IGNORE INTO cob_actaconteo_mcb (id_actaconteo, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido) SELECT id_actaconteo, numeroDocumentoMCB, primerNombreMCB, segundoNombreMCB, primerApellidoMCB, segundoApellidoMCB FROM $tabla_mat");
		}
		$db->query("DROP TABLE $tabla_mat");
		$db->query("DROP TABLE $tabla_pp");
		return TRUE;
	}

	public function generarActasR1($cob_periodo, $carga, $modalidades, $facturacion) {
		$db = $this->getDI()->getDb();
		$config = $this->getDI()->getConfig();
		$timestamp = new DateTime();
		$tabla_mat = "m" . $timestamp->getTimestamp();
		$archivo_mat = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreMat;
		$db->query("CREATE TEMPORARY TABLE $tabla_mat (id_actaconteo INT, certificacionRecorridos INT, fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE, cuartoupaJI INT, codigoHCB BIGINT, nombreHCB VARCHAR(100), numeroDocumentoMCB VARCHAR(100), primerNombreMCB VARCHAR(20), segundoNombreMCB VARCHAR(20), primerApellidoMCB VARCHAR(20), segundoApellidoMCB VARCHAR(20), direccionHCB VARCHAR(100), comunaCorregimientoHCB VARCHAR(100) ) CHARACTER SET utf8 COLLATE utf8_bin");
		$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_mat FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\"), id_persona = @ID_PERSONA, numDocumento = @NUMERO_DOCUMENTO, primerNombre = TRIM(REPLACE(@PRIMER_NOMBRE, '\"',\"\")), segundoNombre = TRIM(REPLACE(@SEGUNDO_NOMBRE, '\"',\"\")), primerApellido = TRIM(REPLACE(@PRIMER_APELLIDO, '\"',\"\")), segundoApellido = TRIM(REPLACE(@SEGUNDO_APELLIDO, '\"',\"\")), id_grupo = @ID_GRUPO, grupo = REPLACE(@NOMBRE_GRUPO, '\"',\"\"), fechaInicioAtencion = @FECHA_INICIO_ATENCION, fechaRegistro = @FECHA_REGISTRO_MATRICULA, fechaRetiro = @FECHA_RETIRO, fechaNacimiento = @FECHA_NACIMIENTO, peso = @PESO, estatura = @ESTATURA, fechaControl = @FECHA_CONTROL, cuartoupaJI = @CUARTOUPA_JI, codigoHCB = @CODIGO_HCB, nombreHCB = @NOMBRE_HCB, numeroDocumentoMCB = @DOCUMENTO_MCB, primerNombreMCB = @PRIMER_NOMBRE_MCB, segundoNombreMCB = @SEGUNDO_NOMBRE_MCB, primerApellidoMCB = @PRIMER_APELLIDO_MCB, segundoApellidoMCB = @SEGUNDO_APELLIDO_MCB, direccionHCB = @DIRECCION_HCB, comunaCorregimientoHCB = @COMUNA_CORREGIMIENTO_HCB");
		//Inicio generar actas PP
		if($cob_periodo->tipo == 1 || $cob_periodo->tipo == 2){
			//Actualizar si cambia contrato de Mundo Mejor
			//$id_contrato_mundomejor = 4600064497;
			$id_contrato_mundomejor = 4600069619; // Se cambia el numero de contrato del año 2017
			$id_oferente_mundomejor = 9;
			$oferente_nombre_mundomejor = "MUNDO MEJOR - FUNDACION";
			$id_modalidad_mundomejor = 8;
			$modalidad_nombre_mundomejor = "PRESUPUESTO PARTICIPATIVO";
			$tabla_pp = "pp" . $timestamp->getTimestamp();
			$db->query("CREATE TEMPORARY TABLE $tabla_pp (certificacionRecorridos INT, fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE, otrosBeneficios VARCHAR(50)) CHARACTER SET utf8 COLLATE utf8_bin");
			$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_pp FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\"), id_persona = @ID_PERSONA, numDocumento = @NUMERO_DOCUMENTO, primerNombre = TRIM(REPLACE(@PRIMER_NOMBRE, '\"',\"\")), segundoNombre = TRIM(REPLACE(@SEGUNDO_NOMBRE, '\"',\"\")), primerApellido = TRIM(REPLACE(@PRIMER_APELLIDO, '\"',\"\")), segundoApellido = TRIM(REPLACE(@SEGUNDO_APELLIDO, '\"',\"\")), id_grupo = @ID_GRUPO, grupo = REPLACE(@NOMBRE_GRUPO, '\"',\"\"), fechaInicioAtencion = @FECHA_INICIO_ATENCION, fechaRegistro = @FECHA_REGISTRO_MATRICULA, fechaRetiro = @FECHA_RETIRO, fechaNacimiento = @FECHA_NACIMIENTO, peso = @PESO, estatura = @ESTATURA, fechaControl = @FECHA_CONTROL, otrosBeneficios = @OTROS_BENEFICIOS");
			$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios NOT LIKE 'PP%'");
			$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios LIKE '%R%'");
			$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios NOT LIKE '%ID%'");
			$db->query("UPDATE $tabla_pp SET id_sede = SUBSTRING_INDEX(otrosBeneficios,'ID',-1) WHERE 1");
			$db->query("UPDATE $tabla_pp, bc_sede_contrato SET $tabla_pp.id_sede_contrato = bc_sede_contrato.id_sede_contrato, $tabla_pp.sede_nombre = bc_sede_contrato.sede_nombre, $tabla_pp.sede_barrio = bc_sede_contrato.sede_barrio, $tabla_pp.sede_direccion = bc_sede_contrato.sede_direccion, $tabla_pp.sede_telefono = bc_sede_contrato.sede_telefono WHERE $tabla_pp.id_sede = bc_sede_contrato.id_sede AND bc_sede_contrato.id_contrato = $id_contrato_mundomejor");
			$db->query("DELETE FROM $tabla_mat WHERE id_modalidad = 8 AND id_contrato = $id_contrato_mundomejor");
			$db->query("INSERT IGNORE INTO $tabla_mat (id_contrato, id_sede_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, peso, estatura, fechaControl) SELECT $id_contrato_mundomejor, id_sede_contrato, $id_modalidad_mundomejor, '$modalidad_nombre_mundomejor', id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, $id_oferente_mundomejor, '$oferente_nombre_mundomejor', id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, peso, estatura, fechaControl FROM $tabla_pp");
		} //Fin generar actas PP
		/*else if($cob_periodo->tipo == 2){ //Inicio generar actas Entorno Familiar
		//Actualizar si cambia contrato de Mundo Mejor
		//$id_contrato_mundomejor = 4600064497;
		$id_contrato_mundomejor = 4600069619; // Se cambia el numero de contrato del año 2017
		$id_oferente_mundomejor = 9;
		$oferente_nombre_mundomejor = "MUNDO MEJOR - FUNDACION";
		$id_modalidad_mundomejor = 8;
		$modalidad_nombre_mundomejor = "PRESUPUESTO PARTICIPATIVO";
		$tabla_pp = "pp" . $timestamp->getTimestamp();
		$db->query("CREATE TEMPORARY TABLE $tabla_pp (certificacionRecorridos INT, fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE, otrosBeneficios VARCHAR(50)) CHARACTER SET utf8 COLLATE utf8_bin");
		$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_pp FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\"), id_persona = @ID_PERSONA, numDocumento = @NUMERO_DOCUMENTO, primerNombre = TRIM(REPLACE(@PRIMER_NOMBRE, '\"',\"\")), segundoNombre = TRIM(REPLACE(@SEGUNDO_NOMBRE, '\"',\"\")), primerApellido = TRIM(REPLACE(@PRIMER_APELLIDO, '\"',\"\")), segundoApellido = TRIM(REPLACE(@SEGUNDO_APELLIDO, '\"',\"\")), id_grupo = @ID_GRUPO, grupo = REPLACE(@NOMBRE_GRUPO, '\"',\"\"), fechaInicioAtencion = @FECHA_INICIO_ATENCION, fechaRegistro = @FECHA_REGISTRO_MATRICULA, fechaRetiro = @FECHA_RETIRO, fechaNacimiento = @FECHA_NACIMIENTO, peso = @PESO, estatura = @ESTATURA, fechaControl = @FECHA_CONTROL, otrosBeneficios = @OTROS_BENEFICIOS");
		$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios NOT LIKE 'PP%'");
		$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios LIKE '%R%'");
		$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios NOT LIKE '%ID%'");
		$db->query("UPDATE $tabla_pp SET id_sede = SUBSTRING_INDEX(otrosBeneficios,'ID',-1) WHERE 1");
		$db->query("UPDATE $tabla_pp, bc_sede_contrato SET $tabla_pp.id_sede_contrato = bc_sede_contrato.id_sede_contrato, $tabla_pp.sede_nombre = bc_sede_contrato.sede_nombre, $tabla_pp.sede_barrio = bc_sede_contrato.sede_barrio, $tabla_pp.sede_direccion = bc_sede_contrato.sede_direccion, $tabla_pp.sede_telefono = bc_sede_contrato.sede_telefono WHERE $tabla_pp.id_sede = bc_sede_contrato.id_sede AND bc_sede_contrato.id_contrato = $id_contrato_mundomejor");
		$db->query("DELETE FROM $tabla_mat WHERE id_modalidad = 8 AND id_contrato = $id_contrato_mundomejor");
		$db->query("INSERT IGNORE INTO $tabla_mat (id_contrato, id_sede_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, peso, estatura, fechaControl) SELECT $id_contrato_mundomejor, id_sede_contrato, $id_modalidad_mundomejor, '$modalidad_nombre_mundomejor', id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, $id_oferente_mundomejor, '$oferente_nombre_mundomejor', id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, peso, estatura, fechaControl FROM $tabla_pp");
	}*/
	//Fin generar actas Entorno Familiar

	// Para modalidad Itinerante
	if($cob_periodo->tipo == 4){
		$db->query("DELETE FROM $tabla_mat WHERE id_modalidad <> 12");
		$db->query("UPDATE $tabla_mat SET id_sede_contrato = CONCAT_WS('',codigoHCB,id_contrato), id_sede = codigoHCB, sede_nombre = nombreHCB, sede_direccion = direccionHCB, sede_barrio = comunaCorregimientoHCB WHERE 1");
	} else {
		$db->query("DELETE FROM $tabla_mat WHERE id_modalidad NOT IN ($modalidades)");
	}

	if($facturacion == 1){
		$db->query("UPDATE $tabla_mat SET fechaRetiro = NULL WHERE fechaRetiro > '$cob_periodo->fecha'");
		$db->query("DELETE FROM $tabla_mat WHERE fechaRetiro > 0000-00-00 AND DATE_SUB('$cob_periodo->fecha', INTERVAL 30 DAY) > fechaRetiro OR '$cob_periodo->fecha' < fechaRetiro");
		$db->query("UPDATE $tabla_mat SET certificacionRecorridos = 2 WHERE fechaRetiro > 0000-00-00");
		$archivo_sed = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreSedes;
		$db->query("LOAD DATA INFILE '$archivo_sed' IGNORE INTO TABLE cob_periodo_contratosedecupos FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_SEDE_CONTRATO, @ID_OFERENTE, @RAZON_SOCIAL, @ID_SEDE, @NOMBRE_SEDE, @TELEFONO, @DIRECCION, @ID_BARRIO_VEREDA, @NOMBRE_BARRIO_VEREDA, @ID_COMUNA, @NOMBRE_COMUNA_CORREGIMIENTO, @ZONA_UBICACION, @FECHA_INICIO_ATENCION, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @CUPOS_SEDE, @CUPOS_EN_USO, @CUPOS_SOSTENIBILIDAD, @CUPOS_AMPLIACION, @TOTAL_CUPOS_CONTRATO, @COORDX, @COORDY, @COORDINADOR, @PROPIEDAD_INMUEBLE, @AREA, @CAPACIDAD_ATENCION, @GRUPOS_ACTIVOS, @FECHA_FIN_CONTRATO, @FECHA_ADICION_CONTRATO) SET id_periodo = $cob_periodo->id_periodo, id_sede_contrato = @ID_SEDE_CONTRATO, cuposSede = @CUPOS_SEDE, cuposSostenibilidad = @CUPOS_SOSTENIBILIDAD, cuposAmpliacion = @CUPOS_AMPLIACION, cuposTotal = @TOTAL_CUPOS_CONTRATO");
		$db->query("INSERT IGNORE INTO cob_actaconteo_persona_facturacion (id_periodo, id_sede_contrato, id_contrato, id_sede, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaInicioAtencion, fechaRegistro, fechaRetiro, fechaNacimiento, peso, estatura, fechaControl, certificacionRecorridos, certificacionFacturacion, cuartoupaJI) SELECT $cob_periodo->id_periodo, id_sede_contrato, id_contrato, id_sede, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaInicioAtencion, fechaRegistro, fechaRetiro, fechaNacimiento, peso, estatura, fechaControl, certificacionRecorridos, certificacionRecorridos, cuartoupaJI FROM $tabla_mat");
		$db->query("UPDATE cob_periodo SET id_carga_facturacion = $carga->id_carga WHERE id_periodo = $cob_periodo->id_periodo");
		$db->query("UPDATE cob_actaconteo_persona, cob_actaconteo_persona_facturacion SET cob_actaconteo_persona.id_actaconteo_persona_facturacion = cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion WHERE cob_actaconteo_persona.id_contrato = cob_actaconteo_persona_facturacion.id_contrato AND cob_actaconteo_persona.numDocumento = cob_actaconteo_persona_facturacion.numDocumento AND cob_actaconteo_persona.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $cob_periodo->id_periodo");
		$db->query("UPDATE cob_actaconteo_persona_facturacion, cob_actaconteo_persona SET cob_actaconteo_persona_facturacion.acta1 = cob_actaconteo_persona.id_actaconteo, cob_actaconteo_persona_facturacion.asistencia1 = cob_actaconteo_persona.asistencia WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion AND cob_actaconteo_persona.recorrido = 1 AND cob_actaconteo_persona.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $cob_periodo->id_periodo");
		$db->query("UPDATE cob_actaconteo_persona_facturacion, cob_actaconteo_persona SET cob_actaconteo_persona_facturacion.acta2 = cob_actaconteo_persona.id_actaconteo, cob_actaconteo_persona_facturacion.asistencia2 = cob_actaconteo_persona.asistencia WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion AND cob_actaconteo_persona.recorrido = 2 AND cob_actaconteo_persona.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $cob_periodo->id_periodo");
	}
	$db->query("DELETE FROM $tabla_mat WHERE fechaRetiro > 0000-00-00");
	$db->query("REPLACE INTO bc_sede_contrato (id_sede_contrato, id_oferente, oferente_nombre, id_contrato, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_modalidad, modalidad_nombre, estado) SELECT id_sede_contrato, id_oferente, oferente_nombre, id_contrato, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_modalidad, modalidad_nombre, '1' FROM $tabla_mat");
	$db->query("INSERT IGNORE INTO cob_actaconteo (id_periodo, id_carga, recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre) SELECT $cob_periodo->id_periodo, $carga->id_carga, '1', id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre FROM $tabla_mat");
	$db->query("INSERT IGNORE INTO cob_actaconteo_persona (id_actaconteo, id_periodo, recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaNacimiento) SELECT (SELECT id_actaconteo FROM cob_actaconteo WHERE cob_actaconteo.id_sede_contrato = $tabla_mat.id_sede_contrato AND cob_actaconteo.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo.recorrido = 1), $cob_periodo->id_periodo, 1, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaNacimiento FROM $tabla_mat");
	//Si es Itinerante se graban las madres comunitarias
	if($cob_periodo->tipo == 4) {
		$db->query("UPDATE $tabla_mat, cob_actaconteo SET $tabla_mat.id_actaconteo = cob_actaconteo.id_actaconteo WHERE $tabla_mat.id_contrato = cob_actaconteo.id_contrato AND $tabla_mat.id_sede = cob_actaconteo.id_sede AND cob_actaconteo.id_periodo = $cob_periodo->id_periodo");
		$db->query("INSERT IGNORE INTO cob_actaconteo_mcb (id_actaconteo, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido) SELECT id_actaconteo, numeroDocumentoMCB, primerNombreMCB, segundoNombreMCB, primerApellidoMCB, segundoApellidoMCB FROM $tabla_mat");
	}
	$db->query("DROP TABLE $tabla_mat");
	return TRUE;
}

public function generarActasFacturacion($cob_periodo, $recorrido_anterior) {
	$recorrido = $recorrido_anterior + 1;
	$carga = BcCarga::findFirstByid_carga($cob_periodo->id_carga_facturacion);
	$db = $this->getDI()->getDb();
	$timestamp = new DateTime();
	$tabla_mat = "m" . $timestamp->getTimestamp();
	$db->query("CREATE TEMPORARY TABLE $tabla_mat (id_actaconteo INT, fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE) CHARACTER SET utf8 COLLATE utf8_bin");
	$rows = CobActaconteoPersona::find(["id_periodo = $cob_periodo->id_periodo AND recorrido = $recorrido_anterior AND (asistencia = 2 OR asistencia = 3 OR asistencia = 4 OR asistencia = 5 OR asistencia = 6 OR asistencia = 8)"]);
	if(count($rows) > 0){
		$sql = "INSERT INTO $tabla_mat (id_sede_contrato,id_contrato,id_modalidad,modalidad_nombre,id_sede,sede_nombre,sede_barrio,sede_direccion,sede_telefono,id_oferente,oferente_nombre,id_persona,numDocumento,primerNombre,segundoNombre,primerApellido,segundoApellido,id_grupo,grupo) VALUES ";
		foreach ($rows as $row) {
			$sql .= "(\"". $row->CobActaconteo->id_sede_contrato. "\",\"".$row->CobActaconteo->id_contrato."\",\"".$row->CobActaconteo->id_modalidad."\",\"".$row->CobActaconteo->modalidad_nombre."\",\"".$row->CobActaconteo->id_sede."\",\"".$row->CobActaconteo->sede_nombre."\",\"".$row->CobActaconteo->sede_barrio."\",\"".$row->CobActaconteo->sede_direccion."\",\"".$row->CobActaconteo->sede_telefono."\",\"".$row->CobActaconteo->id_oferente."\",\"".$row->CobActaconteo->oferente_nombre."\",\"".$row->id_persona."\",\"".$row->numDocumento."\",\"".$row->primerNombre."\",\"".$row->segundoNombre."\",\"".$row->primerApellido."\",\"".$row->segundoApellido."\",\"".$row->id_grupo."\",\"".$row->grupo."\"),";
		}
		$sql = substr($sql, 0, -1);
		$db->query($sql);
	}
	$db->query("INSERT IGNORE INTO cob_actaconteo (id_periodo, id_carga, recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre) SELECT $cob_periodo->id_periodo, $carga->id_carga, $recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre FROM $tabla_mat");
	$db->query("INSERT IGNORE INTO cob_actaconteo_persona (id_actaconteo, id_periodo, recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaNacimiento) SELECT (SELECT id_actaconteo FROM cob_actaconteo WHERE cob_actaconteo.id_sede_contrato = $tabla_mat.id_sede_contrato AND cob_actaconteo.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo.recorrido = $recorrido), $cob_periodo->id_periodo, $recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaNacimiento FROM $tabla_mat");
	$db->query("DROP TABLE $tabla_mat");
	return TRUE;
}

public function generarActasItinerante($cob_periodo, $recorrido_anterior) {
	$recorrido = $recorrido_anterior + 1;
	$carga = BcCarga::findFirstByid_carga($cob_periodo->id_periodo);
	$db = $this->getDI()->getDb();
	$timestamp = new DateTime();
	$tabla_mat_actas = "actas" . $timestamp->getTimestamp();
	$tabla_mat_personas = "personas" . $timestamp->getTimestamp();
	$db->query("CREATE TEMPORARY TABLE $tabla_mat_actas (id_actaconteo INT, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100)) CHARACTER SET utf8 COLLATE utf8_bin");
	$db->query("CREATE TEMPORARY TABLE $tabla_mat_personas (id_actaconteo INT, id_contrato BIGINT, id_sede INT, id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE) CHARACTER SET utf8 COLLATE utf8_bin");
	$db->query("INSERT IGNORE INTO $tabla_mat_actas (id_actaconteo) SELECT id_actaconteo FROM cob_actaconteo_datos WHERE cob_actaconteo_datos.estadoVisita = 2");
	$db->query("DELETE FROM $tabla_mat_actas WHERE $tabla_mat_actas.id_actaconteo NOT IN (SELECT cob_actaconteo.id_actaconteo FROM cob_actaconteo WHERE cob_actaconteo.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo.recorrido = $recorrido_anterior)");
	$db->query("UPDATE $tabla_mat_actas, cob_actaconteo SET $tabla_mat_actas.id_sede_contrato = cob_actaconteo.id_sede_contrato, $tabla_mat_actas.id_contrato = cob_actaconteo.id_contrato, $tabla_mat_actas.id_modalidad = cob_actaconteo.id_modalidad, $tabla_mat_actas.modalidad_nombre = cob_actaconteo.modalidad_nombre, $tabla_mat_actas.id_sede = cob_actaconteo.id_sede, $tabla_mat_actas.sede_nombre = cob_actaconteo.sede_nombre, $tabla_mat_actas.sede_direccion = cob_actaconteo.sede_direccion, $tabla_mat_actas.sede_barrio = cob_actaconteo.sede_barrio, $tabla_mat_actas.sede_telefono = cob_actaconteo.sede_telefono, $tabla_mat_actas.id_oferente = cob_actaconteo.id_oferente, $tabla_mat_actas.oferente_nombre = cob_actaconteo.oferente_nombre WHERE $tabla_mat_actas.id_actaconteo = cob_actaconteo.id_actaconteo");
	$db->query("INSERT IGNORE INTO $tabla_mat_personas (id_actaconteo, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaNacimiento) SELECT id_actaconteo, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaNacimiento FROM cob_actaconteo_persona WHERE cob_actaconteo_persona.id_actaconteo IN (SELECT id_actaconteo FROM $tabla_mat_actas WHERE 1)");
	$db->query("UPDATE $tabla_mat_personas, $tabla_mat_actas SET $tabla_mat_personas.id_sede = $tabla_mat_actas.id_sede WHERE $tabla_mat_personas.id_actaconteo = $tabla_mat_actas.id_actaconteo");
	$db->query("INSERT IGNORE INTO cob_actaconteo (id_periodo, id_carga, recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre) SELECT $cob_periodo->id_periodo, $carga->id_carga, $recorrido, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre FROM $tabla_mat_actas");
	$db->query("UPDATE $tabla_mat_personas, cob_actaconteo SET $tabla_mat_personas.id_actaconteo = cob_actaconteo.id_actaconteo WHERE cob_actaconteo.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo.recorrido = $recorrido AND $tabla_mat_personas.id_contrato = cob_actaconteo.id_contrato AND $tabla_mat_personas.id_sede = cob_actaconteo.id_sede");
	$db->query("INSERT IGNORE INTO cob_actaconteo_persona (id_actaconteo, id_periodo, recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaNacimiento) SELECT id_actaconteo, $cob_periodo->id_periodo, $recorrido, id_contrato, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaNacimiento FROM $tabla_mat_personas");
	$db->query("DROP TABLE $tabla_mat_personas");
	$db->query("DROP TABLE $tabla_mat_actas");
	return TRUE;
}

//Esta función se utiliza cuando por error no fue seleccionada como BD de facturación un recorrido
public function generarFacturacion($cob_periodo, $carga) {
	$db = $this->getDI()->getDb();
	$config = $this->getDI()->getConfig();
	$timestamp = new DateTime();
	$tabla_mat = "m" . $timestamp->getTimestamp();
	$archivo_mat = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreMat;
	$db->query("CREATE TEMPORARY TABLE $tabla_mat (certificacionRecorridos INT, fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE, cuartoupaJI INT, codigoHCB BIGINT, nombreHCB VARCHAR(100), direccionHCB VARCHAR(100), comunaCorregimientoHCB VARCHAR(100) ) CHARACTER SET utf8 COLLATE utf8_bin");
	$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_mat FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\"), id_persona = @ID_PERSONA, numDocumento = @NUMERO_DOCUMENTO, primerNombre = TRIM(REPLACE(@PRIMER_NOMBRE, '\"',\"\")), segundoNombre = TRIM(REPLACE(@SEGUNDO_NOMBRE, '\"',\"\")), primerApellido = TRIM(REPLACE(@PRIMER_APELLIDO, '\"',\"\")), segundoApellido = TRIM(REPLACE(@SEGUNDO_APELLIDO, '\"',\"\")), id_grupo = @ID_GRUPO, grupo = REPLACE(@NOMBRE_GRUPO, '\"',\"\"), fechaInicioAtencion = @FECHA_INICIO_ATENCION, fechaRegistro = @FECHA_REGISTRO_MATRICULA, fechaRetiro = @FECHA_RETIRO, fechaNacimiento = @FECHA_NACIMIENTO, peso = @PESO, estatura = @ESTATURA, fechaControl = @FECHA_CONTROL, cuartoupaJI = @CUARTOUPA_JI, codigoHCB = @CODIGO_HCB, nombreHCB = @NOMBRE_HCB, direccionHCB = @DIRECCION_HCB, comunaCorregimientoHCB = @COMUNA_CORREGIMIENTO_HCB");
	if($cob_periodo->tipo == 4){
		$db->query("UPDATE $tabla_mat SET id_sede_contrato = CONCAT_WS('',codigoHCB,id_contrato), id_sede = codigoHCB, sede_nombre = nombreHCB, sede_direccion = direccionHCB, sede_barrio = comunaCorregimientoHCB, sede_telefono = NULL WHERE 1");
	}
	//Inicio generar actas PP
	//Actualizar si cambia contrato de Mundo Mejor
	$id_contrato_mundomejor = 4600064497;
	$id_oferente_mundomejor = 9;
	$oferente_nombre_mundomejor = "MUNDO MEJOR - FUNDACION";
	$id_modalidad_mundomejor = 8;
	$modalidad_nombre_mundomejor = "PRESUPUESTO PARTICIPATIVO";
	$tabla_pp = "pp" . $timestamp->getTimestamp();
	$db->query("CREATE TEMPORARY TABLE $tabla_pp (certificacionRecorridos INT, fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE, otrosBeneficios VARCHAR(50)) CHARACTER SET utf8 COLLATE utf8_bin");
	$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_pp FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\"), id_persona = @ID_PERSONA, numDocumento = @NUMERO_DOCUMENTO, primerNombre = TRIM(REPLACE(@PRIMER_NOMBRE, '\"',\"\")), segundoNombre = TRIM(REPLACE(@SEGUNDO_NOMBRE, '\"',\"\")), primerApellido = TRIM(REPLACE(@PRIMER_APELLIDO, '\"',\"\")), segundoApellido = TRIM(REPLACE(@SEGUNDO_APELLIDO, '\"',\"\")), id_grupo = @ID_GRUPO, grupo = REPLACE(@NOMBRE_GRUPO, '\"',\"\"), fechaInicioAtencion = @FECHA_INICIO_ATENCION, fechaRegistro = @FECHA_REGISTRO_MATRICULA, fechaRetiro = @FECHA_RETIRO, fechaNacimiento = @FECHA_NACIMIENTO, peso = @PESO, estatura = @ESTATURA, fechaControl = @FECHA_CONTROL, otrosBeneficios = @OTROS_BENEFICIOS");
	$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios NOT LIKE 'PP%'");
	$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios LIKE '%R%'");
	$db->query("DELETE FROM $tabla_pp WHERE otrosBeneficios NOT LIKE '%ID%'");
	$db->query("UPDATE $tabla_pp SET id_sede = SUBSTRING_INDEX(otrosBeneficios,'ID',-1) WHERE 1");
	$db->query("UPDATE $tabla_pp, bc_sede_contrato SET $tabla_pp.id_sede_contrato = bc_sede_contrato.id_sede_contrato, $tabla_pp.sede_nombre = bc_sede_contrato.sede_nombre, $tabla_pp.sede_barrio = bc_sede_contrato.sede_barrio, $tabla_pp.sede_direccion = bc_sede_contrato.sede_direccion, $tabla_pp.sede_telefono = bc_sede_contrato.sede_telefono WHERE $tabla_pp.id_sede = bc_sede_contrato.id_sede AND bc_sede_contrato.id_contrato = $id_contrato_mundomejor");
	$db->query("DELETE FROM $tabla_mat WHERE id_modalidad = 8 AND id_contrato = $id_contrato_mundomejor");
	$db->query("INSERT IGNORE INTO $tabla_mat (id_contrato, id_sede_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, peso, estatura, fechaControl) SELECT $id_contrato_mundomejor, id_sede_contrato, $id_modalidad_mundomejor, '$modalidad_nombre_mundomejor', id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, $id_oferente_mundomejor, '$oferente_nombre_mundomejor', id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, fechaNacimiento, peso, estatura, fechaControl FROM $tabla_pp");
	//Fin generar actas PP
	$db->query("DELETE FROM $tabla_mat WHERE id_oferente = 0");
	$db->query("UPDATE $tabla_mat SET fechaRetiro = NULL WHERE fechaRetiro > '$cob_periodo->fecha'");
	$db->query("DELETE FROM $tabla_mat WHERE fechaRetiro > 0000-00-00 AND DATE_SUB('$cob_periodo->fecha', INTERVAL 30 DAY) > fechaRetiro OR '$cob_periodo->fecha' < fechaRetiro");
	$db->query("UPDATE $tabla_mat SET certificacionRecorridos = 2 WHERE fechaRetiro > 0000-00-00");
	$archivo_sed = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreSedes;
	$db->query("LOAD DATA INFILE '$archivo_sed' IGNORE INTO TABLE cob_periodo_contratosedecupos FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_SEDE_CONTRATO, @ID_OFERENTE, @RAZON_SOCIAL, @ID_SEDE, @NOMBRE_SEDE, @TELEFONO, @DIRECCION, @ID_BARRIO_VEREDA, @NOMBRE_BARRIO_VEREDA, @ID_COMUNA, @NOMBRE_COMUNA_CORREGIMIENTO, @ZONA_UBICACION, @FECHA_INICIO_ATENCION, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @CUPOS_SEDE, @CUPOS_EN_USO, @CUPOS_SOSTENIBILIDAD, @CUPOS_AMPLIACION, @TOTAL_CUPOS_CONTRATO, @COORDX, @COORDY, @COORDINADOR, @PROPIEDAD_INMUEBLE, @AREA, @CAPACIDAD_ATENCION, @GRUPOS_ACTIVOS, @FECHA_FIN_CONTRATO, @FECHA_ADICION_CONTRATO) SET id_periodo = $cob_periodo->id_periodo, id_sede_contrato = @ID_SEDE_CONTRATO, cuposSede = @CUPOS_SEDE, cuposSostenibilidad = @CUPOS_SOSTENIBILIDAD, cuposAmpliacion = @CUPOS_AMPLIACION, cuposTotal = @TOTAL_CUPOS_CONTRATO");
	$db->query("INSERT IGNORE INTO cob_actaconteo_persona_facturacion (id_periodo, id_sede_contrato, id_contrato, id_sede, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaInicioAtencion, fechaRegistro, fechaRetiro, fechaNacimiento, peso, estatura, fechaControl, certificacionRecorridos, certificacionFacturacion, cuartoupaJI) SELECT $cob_periodo->id_periodo, id_sede_contrato, id_contrato, id_sede, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, id_grupo, grupo, fechaInicioAtencion, fechaRegistro, fechaRetiro, fechaNacimiento, peso, estatura, fechaControl, certificacionRecorridos, certificacionRecorridos, cuartoupaJI FROM $tabla_mat");
	$db->query("UPDATE cob_periodo SET id_carga_facturacion = $carga->id_carga WHERE id_periodo = $cob_periodo->id_periodo");
	$db->query("UPDATE cob_actaconteo_persona, cob_actaconteo_persona_facturacion SET cob_actaconteo_persona.id_actaconteo_persona_facturacion = cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion WHERE cob_actaconteo_persona.id_contrato = cob_actaconteo_persona_facturacion.id_contrato AND cob_actaconteo_persona.numDocumento = cob_actaconteo_persona_facturacion.numDocumento AND cob_actaconteo_persona.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $cob_periodo->id_periodo");
	$db->query("UPDATE cob_actaconteo_persona_facturacion, cob_actaconteo_persona SET cob_actaconteo_persona_facturacion.acta1 = cob_actaconteo_persona.id_actaconteo, cob_actaconteo_persona_facturacion.asistencia1 = cob_actaconteo_persona.asistencia, cob_actaconteo_persona_facturacion.id_actaconteo_persona1 = cob_actaconteo_persona.id_actaconteo_persona WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion AND cob_actaconteo_persona.recorrido = 1 AND cob_actaconteo_persona.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $cob_periodo->id_periodo");
	$db->query("UPDATE cob_actaconteo_persona_facturacion, cob_actaconteo_persona SET cob_actaconteo_persona_facturacion.acta2 = cob_actaconteo_persona.id_actaconteo, cob_actaconteo_persona_facturacion.asistencia2 = cob_actaconteo_persona.asistencia, cob_actaconteo_persona_facturacion.id_actaconteo_persona2 = cob_actaconteo_persona.id_actaconteo_persona WHERE cob_actaconteo_persona_facturacion.id_actaconteo_persona_facturacion = cob_actaconteo_persona.id_actaconteo_persona_facturacion AND cob_actaconteo_persona.recorrido = 2 AND cob_actaconteo_persona.id_periodo = $cob_periodo->id_periodo AND cob_actaconteo_persona_facturacion.id_periodo = $cob_periodo->id_periodo");
	$db->query("DROP TABLE $tabla_mat");
	return TRUE;
}

//Verificar este proceso
public function duplicarActa($acta, $cob_periodo) {
	$recorrido = $acta->recorrido + 1;
	$carga = BcCarga::findFirstByid_carga($cob_periodo->id_carga_facturacion);
	$db = $this->getDI()->getDb();
	$timestamp = new DateTime();
	$tabla_mat = "m" . $timestamp->getTimestamp();
	$db->query("CREATE TEMPORARY TABLE $tabla_mat (fechaInicioAtencion DATE, fechaRetiro DATE, fechaRegistro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), id_grupo BIGINT, grupo VARCHAR(80), fechaNacimiento DATE, peso VARCHAR(10), estatura VARCHAR(10), fechaControl DATE) CHARACTER SET utf8 COLLATE utf8_bin");
	$rows = CobActaconteoPersona::find(["id_actaconteo = $acta->id_actaconteo AND tipoPersona = 0 AND (asistencia = 2 OR asistencia = 3 OR asistencia = 4 OR asistencia = 5 OR asistencia = 6 OR asistencia = 8)"]);
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

public function generarActa($id_actaconteo){
	$acta = CobActaconteo::findFirstByid_actaconteo($id_actaconteo);
	if(!$acta || $acta == NULL){
		return FALSE;
	}
	$acta_id = "ACO-03-". date("Y") . sprintf('%05d', $acta->id_actaconteo);
	$nombre_mcb = "";
	if($acta->id_modalidad == 12){
		$nombre_mcb = array($acta->CobactaconteoMcb->primerNombre, $acta->CobactaconteoMcb->segundoNombre, $acta->CobactaconteoMcb->primerApellido, $acta->CobactaconteoMcb->segundoApellido, "-", $acta->CobactaconteoMcb->numDocumento);
		$nombre_mcb = implode(" ", $nombre_mcb);
		$nombre_mcb = "MADRE COMUNITARIA: <span style='font-weight: normal; font-size: 8px;'>" . $nombre_mcb . "</span>";
	}
	/*if ($acta->recorrido == '1') {*/
		$encabezado = "<div class='seccion encabezado'>
		<div class='fila center'><div>ACTA DE CONTEO VERIFICACIÓN FÍSICA DE LA ATENCIÓN DEL 100% DE LOS BENEFICIARIOS REPORTADOS EN EL SIBC<br>INTERVENTORÍA BUEN COMIENZO - <em>(RECORRIDO $acta->recorrido)</em></div></div>
		<div class='fila col2 center'><div>Código: F-ITBC-GC-001</div><div>$nombre_mcb</div></div>
		<div class='fila col3e'>
		<div>ACTA: <span style='font-weight: normal;'>$acta_id</span></div>
		<div class='col2da'>NÚMERO DE CONTRATO: <span style='font-weight: normal;'>$acta->id_contrato</span></div>
		<div>MODALIDAD: <span style='font-weight: normal;'>$acta->modalidad_nombre</span></div>
		</div>
		<div class='fila col3e'>
		<div>RUTA: <span style='font-weight: normal;'>".$acta->IbcUsuario->usuario."</span></div>
		<div class='col2da'>PRESTADOR: <span style='font-weight: normal;'>".substr($acta->oferente_nombre, 0, 34)."</span></div>
		<div>SEDE: <span style='font-weight: normal;'>$acta->sede_nombre</span></div>
		</div>
		<div class='fila col3e'>
		<div>TELÉFONO: <span style='font-weight: normal;'>$acta->sede_telefono</span></div>
		<div class='col2da'>DIRECCIÓN: <span style='font-weight: normal;'>$acta->sede_direccion</span></div>
		<div>BARRIO/VEREDA: <span style='font-weight: normal;'>$acta->sede_barrio</span></div>
		</div>
		<div class='clear'></div>
		</div>";
	/*}else {
		$encabezado = "";
	}*/

	if ($acta->recorrido == '1') {
		$pie_pagina = "<div id='pie_pagina'>
		<div class='pull-left' style='padding-left: 60px; width: 50%; text-align: center; float: left;'>________________________________________________<br>FIRMA PERSONA ENCARGADA DE LA SEDE</div>
		<div class='pull-right' style='padding-right: 60px; width: 50%; text-align: center; float: left;'>________________________________________________<br>FIRMA PERSONA ENCARGADA DE INTERVENTORÍA<br></div>
		<div class='clear'></div>
		</div>";
	}else {
		$pie_pagina = "<div id='pie_pagina'>
		<div class='' style='text-align: center;'>________________________________________________<br>FIRMA PERSONA ENCARGADA DE INTERVENTORÍA<br></div>
		<div class='clear'></div>
		</div>";
	}

	/*<div class='fila'><div>1.5 LLAMADA TELEFÓNICA PRECERTIFICADA</div></div>
	<div class='fila'><div>1.6 LLAMADA TELEFÓNICA NO CERTIFICADA</div></div>*/
	if($acta->id_modalidad == 5){ // ENTORNO FAMILIAR
		$totalizacion_asistencia = "<div class='seccion' id='totalizacion_asistencia'>
		<div class='fila center bold'><div style='border:none; width: 100%'>1. TOTALIZACIÓN DE ASISTENCIA</div></div>
		<div class='fila'><div>1.1 ASISTE</div></div>
		<div class='fila'><div>1.2 RETIRADO</div></div>
		<div class='fila'><div>1.3 AUSENTE</div></div>
		<div class='fila'><div>1.4 BENEFICIARIO CON EXCUSA VALIDA</div></div>
		<div class='fila'><div>1.5 GESTIÓN TELEFÓNICA CERTIFICADA</div></div>
		<div class='clear'></div>
		</div>";
	}
	else {
		$totalizacion_asistencia = "<div class='seccion' id='totalizacion_asistencia'>
		<div class='fila center bold'><div style='border:none; width: 100%'>1. TOTALIZACIÓN DE ASISTENCIA</div></div>
		<div class='fila'><div>1.1 ASISTE</div></div>
		<div class='fila'><div>1.2 AUSENTE CON EXCUSA FÍSICA</div></div>
		<div class='fila'><div>1.3 AUSENTE CON EXCUSA TELEFÓNICA</div></div>
		<div class='fila'><div>1.4 RETIRADO ANTES DEL DÍA DE CORTE DE PERIODO</div></div>
		<div class='fila'><div>1.5 RETIRADO DESPUES DEL DÍA DE CORTE DE PERIODO</div></div>
		<div class='fila'><div>1.6 AUSENTE QUE NO PRESENTA EXCUSA EL DÍA DEL REPORTE</div></div>
		<div class='fila'><div>1.7 CON EXCUSA MÉDICA MAYOR O IGUAL A 15 DIAS</div></div>
		<div class='fila'><div>1.8 CON EXCUSA MÉDICA MENOR A 15 DIAS</div></div>
		<div class='clear'></div>
		</div>";
	}
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
	$aiepi = "";
	//Si el acta es I8H, LDK, PP ó JI se coloca el mensaje AIEPI
	if($acta->id_modalidad == 1 || $acta->id_modalidad == 6 || $acta->id_modalidad == 7 || $acta->id_modalidad == 8){
		$aiepi = "<br>SE ENCONTRARON ____ BENEFICIARIOS ATENDIDOS POR ____ DOCENTES Y ____ AUXILIARES DOCENTES.<br>SE PRESENTARON FORMATOS AIEPI DE LOS NIÑOS AUSENTES PARA SER REVISADOS POR LA INTERVENTORIA: <u>SÍ</u> - <u>NO</u><br>FIRMA RESPONSABLE DE LA SEDE ________________________________________";
	} else if ($acta->id_modalidad == 3){
		$aiepi = "<br>____/____/________ ASISTEN ____ GRUPOS, ATENDIDOS POR ____ DOCENTES<br>____/____/________ ASISTEN ____ GRUPOS, ATENDIDOS POR ____ DOCENTES<br>____/____/________ ASISTEN ____ GRUPOS, ATENDIDOS POR ____ DOCENTES<br>____/____/________ ASISTEN ____ GRUPOS, ATENDIDOS POR ____ DOCENTES<br>SE PRESENTARON FORMATOS AIEPI DE LOS NIÑOS AUSENTES PARA SER REVISADOS POR LA INTERVENTORIA: <u>SÍ</u> - <u>NO</u><br>FIRMA RESPONSABLE DE LA SEDE ________________________________________";
	} else if ($acta->id_modalidad == 12){
		$aiepi = "<br>SE ACORDÓ PREVIAMENTE VISITA CON LA MADRE COMUNITARIA: <u>SÍ</u> - <u>NO</u><br>SE ENTREGA FORMATO DE PLANILLA DE SEGUIMIENTO PARA VISITA DE PROFESIONALES: <u>SÍ</u> - <u>NO</u><br>SE VERIFICA PLANILLA DE SEGUIMIENTO DE VISITA DE PROFESIONALES: <u>SÍ</u> - <u>NO</u><br>NÚMERO DE ENCUENTROS EVIDENCIADOS AL MOMENTO DE LA VISITA ___";
	}
	$html .= $encabezado;
	$html .= $totalizacion_asistencia;

	if($acta->id_modalidad == 5){ // ENTORNO FAMILIAR
		$html .= "
		<div class='seccion' id='datos_generales'>
		<div class='fila center bold'><div style='border:none; width: 100%'>2. DATOS GENERALES</div></div>
		<div class='fila col3'>
		<div>2.1 FECHA INTERVENTORÍA:</div>
		<div>2.2 HORA INICIO INTERVENTORÍA:</div>
		<div>2.3 HORA FIN INTERVENTORÍA:</div>
		</div>
		<div class='fila col2'>
		<div style='width: 55%;'>2.4 NOMBRE ENCARGADO DEL ENCUENTRO:</div>
		<div style='width: 40%;'>2.5 NOMBRE INTERVENTOR:</div>
		</div>
		<div class='fila col2'>
		<div>2.6 CUENTA CON VALLA DE IDENTIFICACIÓN:</div>
		<div>2.7 CORRECCIÓN DIRECCIÓN:</div>
		</div>
		<div class='clear'></div>
		</div>
		<div class='seccion' id='observaciones'>
		<div class='fila center bold'><div style='border:none; width: 100%'>3. OBSERVACIONES AL MOMENTO DE LA INTERVENTORÍA</div></div>
		<div class='fila observacion'><div>3.1 OBSERVACIÓN DEL INTERVENTOR:$aiepi</div></div>
		<div class='fila observacion'><div>3.2 OBSERVACIÓN DEL ENCARGADO DE LA SEDE:</div></div>
		<div class='clear'></div>
		</div>";
	}
	else
	{
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
		<div>2.6 CUENTA CON VALLA DE IDENTIFICACIÓN:</div>
		<div>2.7 CORRECCIÓN DIRECCIÓN:</div>
		</div>
		<div class='fila col2'>
		<div>2.8 CUENTA CON REGISTRO FOTOGRÁFICO FÍSICO:</div>
		<div>2.9 CUENTA CON REGISTRO FOTOGRÁFICO DIGITAL:</div>
		</div>
		<div class='clear'></div>
		</div>
		<div class='seccion' id='observaciones'>
		<div class='fila center bold'><div style='border:none; width: 100%'>3. OBSERVACIONES AL MOMENTO DE LA INTERVENTORÍA</div></div>
		<div class='fila observacion'><div>3.1 OBSERVACIÓN DEL INTERVENTOR:$aiepi</div></div>
		<div class='fila observacion'><div>3.2 OBSERVACIÓN DEL ENCARGADO DE LA SEDE:</div></div>
		<div class='clear'></div>
		</div>";
	}
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
	//   		if($acta->id_modalidad == 3 || $acta->id_modalidad == 5 || $acta->id_modalidad == 7){
	//   			$fecha_encabezado = "<div>4.5 FECHA VISITA</div>";
	//   			$fecha_encabezado2 = "<div>5.5 FECHA VISITA</div>";
	//   			$fecha_lista =  "<div></div>";
	//   		}

	if($acta->id_modalidad == 5){ // ENTORNO FAMILIAR
		$encabezado_beneficiarios = "<div class='seccion' id='listado_beneficiarios'>
		<div class='fila center bold'><div style='border:none; width: 100%'>4. LISTADO DE BENEFICIARIOS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE BUEN COMIENZO</div></div>
		<div class='fila colb'><div style='width: 5%;'>#</div><div style='width: 15%;'>4.1 DOCUMENTO</div><div style='width: 30%'>4.2 NOMBRE COMPLETO</div><div style='width: 10%'>4.3 GRUPO</div><div style='width: 10%'><span style='font-size: 8px !important;'>4.4 ASISTENCIA</span></div><div style='width: 10%'><span style='font-size: 8px !important;'>4.5 EXCUSA</span></div><div style='width: 10%'><span style='font-size: 8px !important;'>4.6 FECHA VISITA</span></div></div>";
	}
	else
	{
		$encabezado_beneficiarios = "<div class='seccion' id='listado_beneficiarios'>
		<div class='fila center bold'><div style='border:none; width: 100%'>4. LISTADO DE BENEFICIARIOS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE BUEN COMIENZO</div></div>
		<div class='fila colb'><div style='width: 5%;'>#</div><div style='width: 15%;'>4.1 DOCUMENTO</div><div style='width: 30%'>4.2 NOMBRE COMPLETO</div><div style='width: 30%'>4.3 GRUPO</div><div style='width: 10%'>4.4 ASISTENCIA</div>$fecha_encabezado</div>";
	}
	$html .= $encabezado;
	$html .= $encabezado_beneficiarios;
	if($acta->id_modalidad == 12){
		foreach($acta->getCobActaconteoPersona(["tipoPersona = 0", 'order' => 'id_grupo, primerNombre asc']) as $row){
			$mayor5 = "";
			$mayor_5 = "";
			if($row->fechaNacimiento){
				$edad_nacimiento = date_create($row->fechaNacimiento);
				$fecha_corte = date_create($acta->CobPeriodo->fecha);
				$interval = date_diff($edad_nacimiento, $fecha_corte);
				if ($interval->format('%y') >= 6){
					$mayor5 = " style='font-weight:bold'";
					$mayor_5 = "*";
				}
			}
			$nombre_completo = array($row->primerNombre, $row->segundoNombre, $row->primerApellido, $row->segundoApellido);
			$nombre_completo = implode(" ", $nombre_completo);
			$i = ($i<10) ? "0" .$i : $i;
			$html .="<div class='fila colb'$mayor5><div style='width: 5%;'>$i</div><div style='width: 15%;'>$row->numDocumento</div><div style='width: 30%;'>$mayor_5$nombre_completo</div><div style='width: 30%;'>$row->grupo</div><div style='width: 10%;'>&nbsp;</div>$fecha_lista</div>";
			$i++;
			$j++;
		}
		$html .= "
		<div class='fila center bold'><div style='border:none; width: 100%'>5. LISTADO DE BENEFICIARIOS ADICIONALES A LOS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE BUEN COMIENZO</div></div>
		<div class='fila colb'><div style='width: 5%;'>#</div><div style='width: 15%;'>5.1 DOCUMENTO</div><div style='width: 30%;'>5.2 NOMBRE COMPLETO</div><div style='width: 30%;'>5.3 GRUPO</div><div style='width: 10%;'>5.4 ASISTENCIA</div>$fecha_encabezado2</div>";
		for($i = 1; $i <= 15; $i++){
			$html .="<div class='fila colb'><div style='width: 5%;'>$i</div><div style='width: 15%;'>&nbsp;&nbsp;</div><div style='width: 30%;'>&nbsp;&nbsp;</div><div style='width: 30%;'>&nbsp;&nbsp;</div><div style='width: 10%;'>&nbsp;&nbsp;</div>$fecha_lista</div>";
		}
		$p++;
		$html .= "<div class='clear'></div></div>* Niños mayores o iguales a 5 años" . $pie_pagina;
		$html .= "<div class='paginacion'>PÁGINA $p</div>";
	} else {
		foreach($acta->getCobActaconteoPersona(["tipoPersona = 0", 'order' => 'id_grupo, primerNombre asc']) as $row){
			$mayor5 = "";
			$mayor_5 = "";
			if($row->fechaNacimiento){
				$edad_nacimiento = date_create($row->fechaNacimiento);
				$fecha_corte = date_create($acta->CobPeriodo->fecha);
				$interval = date_diff($edad_nacimiento, $fecha_corte);
				if ($interval->format('%y') >= 6){
					$mayor5 = " style='font-weight:bold'";
					$mayor_5 = "*";
				}
			}
			$nombre_completo = array($row->primerNombre, $row->segundoNombre, $row->primerApellido, $row->segundoApellido);
			$nombre_completo = implode(" ", $nombre_completo);
			$i = ($i<10) ? "0" .$i : $i;
			if($j == 31){
				$j = 1;
				$p++;
				$html .= "<div class='clear'></div></div>* Niños mayores o iguales a 5 añoss" . $pie_pagina;
				$html .= "<div class='paginacion'>PÁGINA $p</div>";
				$html .= $encabezado;
				$html .= $encabezado_beneficiarios;
			}
			if($acta->id_modalidad == 5){ // ENTORNO FAMILIAR
				//$excusa = new CobActaconteoPersonaExcusa();
				$query = $this->modelsManager->createQuery("SELECT *
					FROM CobActaconteoPersonaExcusa
					WHERE id_actaconteo_persona = :id_actaconteo_persona:");
					$cob_actaconteo_persona_excusa  = $query->execute(
						array(
							'id_actaconteo_persona' => "$row->id_actaconteo_persona"
						)
					);
					$excusa = "";
					foreach ($cob_actaconteo_persona_excusa as $row1 ) {
						$excusa = $row1->motivo;
					}
					$html .="<div class='fila colb'$mayor5><div style='width: 5%;'>$i</div><div style='width: 15%;'>$row->numDocumento</div><div style='width: 30%;'>$mayor_5$nombre_completo</div><div style='width: 10%;'>$row->grupo&nbsp;</div><div style='width: 10%;'>$row->asistencia&nbsp;</div><div style='width: 10%; height: auto;'>$excusa&nbsp;</div><div style='width: 10%;'>$row->fechaInterventoria&nbsp;</div></div>";
				}
				else
				{
					$html .="<div class='fila colb'$mayor5><div style='width: 5%;'>$i</div><div style='width: 15%;'>$row->numDocumento</div><div style='width: 30%;'>$mayor_5$nombre_completo</div><div style='width: 30%;'>$row->grupo&nbsp;</div><div style='width: 10%;'></div>$fecha_lista</div>";
				}
				$i++;
				$j++;
			}
			$p++;
			$html .= "<div class='clear'></div></div>* Niños mayores o iguales a 5 años" . $pie_pagina;
			$html .= "<div class='paginacion'>PÁGINA $p</div>";
			//Si es el recorrido 1 se muestran los niños adicionales y lista para rellenar empleados:
			if($acta->recorrido == 1){
				$html .= $encabezado;
				if($acta->id_modalidad == 5){ // ENTORNO FAMILIAR
					$html .= "<div class='seccion' id='listado_beneficiarios'>
					<div class='fila center bold'><div style='border:none; width: 100%'>5. LISTADO DE BENEFICIARIOS ADICIONALES A LOS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE BUEN COMIENZO</div></div>
					<div class='fila colb'><div style='width: 5%;'>#</div><div style='width: 15%;'>5.1 DOCUMENTO</div><div style='width: 30%;'>5.2 NOMBRE COMPLETO</div><div style='width: 10%;'>5.3 GRUPO</div><div style='width: 10%;'><span style='font-size: 8px !important;'>5.4 FECHA ENCUENTRO</span></div><div style='width: 10%;'><span style='font-size: 8px !important;'>5.5 HORA ENCUENTRO</span></div><div style='width: 10%;'><span style='font-size: 8px !important;'>5.6 TIPO ENCUENTRO</span></div><div style='width: 10%;'>5.7 ASISTENCIA</div>$fecha_encabezado2</div>";
				}
				else
				{
					$html .= "<div class='seccion' id='listado_beneficiarios'>
					<div class='fila center bold'><div style='border:none; width: 100%'>5. LISTADO DE BENEFICIARIOS ADICIONALES A LOS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE BUEN COMIENZO</div></div>
					<div class='fila colb'><div style='width: 5%;'>#</div><div style='width: 15%;'>5.1 DOCUMENTO</div><div style='width: 30%;'>5.2 NOMBRE COMPLETO</div><div style='width: 30%;'>5.3 GRUPO</div><div style='width: 10%;'>5.4 ASISTENCIA</div>$fecha_encabezado2</div>";
				}

				for($i = 1; $i <= 30; $i++){
					if($acta->id_modalidad == 5){ // ENTORNO FAMILIAR
						$html .="<div class='fila colb'><div style='width: 5%;'>$i</div><div style='width: 15%;'>&nbsp;</div><div style='width: 30%;'>&nbsp;</div><div style='width: 10%;'>&nbsp;</div><div style='width: 10%;'>&nbsp;</div><div style='width: 10%;'>&nbsp;</div><div style='width: 10%;'>&nbsp;</div><div style='width: 10%;'>&nbsp;</div>$fecha_lista</div>";
					}
					else
					{
						$html .="<div class='fila colb'><div style='width: 5%;'>$i</div><div style='width: 15%;'>&nbsp;</div><div style='width: 30%;'>&nbsp;</div><div style='width: 30%;'>&nbsp;</div><div style='width: 10%;'>&nbsp;</div>$fecha_lista</div>";
					}
				}
				$p++;
				$html .= "<div class='clear'></div></div>" . $pie_pagina;
				$html .= "<div class='paginacion'>PÁGINA $p</div>";
			}
		}

		// if($acta->id_modalidad == 12){
		//   $html .= $encabezado;
		// 	$html .= "<div class='seccion' id='listado_beneficiarios'>
		// 	<div class='fila center bold horiziontal'><div style='border:none; width: 100%'>6. SEGUIMIENTO DE ENCUENTROS EDUCATIVOS - MODALIDAD ENTORNO COMUNITARIO ITINERANTE PROGRAMA BUEN COMIENZO</div></div>
		// 	<div class='fila colb'><div style='width: 20px;'>#</div><div style='width: 50px;'>FECHA 1</div><div style='width: 50px'>6.2 HORA INICIO</div><div style='width: 50px'>6.3 HORA FIN</div><div style='width: 70px'>6.4 NOMBRE COMPLETO DEL OPERADOR</div><div style='width: 70px'>6.4 DOCUMENTO DEL OPERADOR</div><div style='width: 70px'>6.4 CARGO DEL OPERADOR</div><div style='width: 70px'>6.5 TEMA ABORDADO EN EL ENCUENTRO</div><div style='width: 70px'>6.6 NECESIDADES, EXPECTATIVAS E INTERESES INDENTIFICADOS EN LAS MADRES COMUNITARIAS, NIÑOS Y NIÑAS</div><div style='width: 70px'>6.5 NIÑOS PARTICIPANTES</div><div style='width: 70px'>6.5 FIRMA OPERADOR BUEN COMIENZO</div><div style='width: 70px'>6.5 FIRMA MADRE COMUNITARIA</div></div>";
		// 	for($i = 1; $i <= 30; $i++){
		// 		$html .="<div class='fila colb'><div style='width: 20px;'>$i</div><div style='width: 50px;'></div><div style='width: 50px'></div><div style='width: 50px;'></div><div style='width: 70px'></div><div style='width: 70px'></div><div style='width: 70px'></div><div style='width: 70px'></div><div style='width: 70px'></div><div style='width: 70px'></div><div style='width: 70px'></div><div style='width: 70px'></div></div>";
		// 	}
		// 	$p++;
		// 	$html .= "<div class='clear'></div></div>" . $pie_pagina;
		// 	$html .= "<div class='paginacion'>PÁGINA $p</div>";
		// }
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
	* Returns a human representation of 'id_actaconteo'
	*
	* @return string
	*/
	public function getIdDetail()
	{
		return "ACO-03-". date("Y") . sprintf('%05d', $this->id_actaconteo);
	}

	/**
	* Returns a human representation of 'id_actamuestreo'
	*
	* @return string
	*/
	public function getId()
	{
		return $this->id_actaconteo;
	}

	/**
	* Contar beneficiarios
	*
	* @return string
	*/
	public function countBeneficiarios()
	{
		return count($this->CobActaconteoPersona);
	}

	/**
	* Returns a human representation of 'url'
	*
	* @return string
	*/
	public function getUrlDetail()
	{
		return "cob_actaconteo/ver/$this->id_actaconteo";
	}

}
