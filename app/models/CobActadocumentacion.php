<?php
use Phalcon\DI\FactoryDefault;
class CobActadocumentacion extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actadocumentacion;

    /**
     *
     * @var integer
     */
    public $id_verificacion;

    /**
     *
     * @var integer
     */
    public $id_carga;

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
    	$this->belongsTo('id_verificacion', 'CobVerificacion', 'id_verificacion', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_actadocumentacion', 'CobActadocumentacionDatos', 'id_actadocumentacion', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
    			'reusable' => true
    	));
    	$this->belongsTo('estado', 'IbcReferencia', 'id_referencia', array(
    			'reusable' => true
    	));
    	$this->hasMany('id_actadocumentacion', 'CobActadocumentacionPersona', 'id_actadocumentacion', array(
    			'foreignKey' => array(
    					'message' => 'El acta no puede ser eliminada porque existen beneficiarios asociados a ésta'
    			)
    	));
    }

    public function generarActa($id_actadocumentacion){
    	$acta = CobActadocumentacion::findFirstByid_actadocumentacion($id_actadocumentacion);
    	if(!$acta || $acta == NULL){
    		return FALSE;
    	}
    	$acta_id = "AVD-03-". date("Y") . sprintf('%05d', $acta->id_actadocumentacion);
    	$encabezado = "<div class='seccion encabezado'>
    	<div class='fila center'><div style='margin-left:20%'>ACTA DE VERIFICACIÓN FÍSICA DE LAS CARPETAS DE LOS BENEFICIARIOS REPORTADOS EN EL SIBC<br>INTERVENTORÍA BUEN COMIENZO</div></div>
    	<div class='fila col3 center'><div>Código: F-ITBC-GC-001</div><div></div><div></div></div>
    	<div class='fila col3e'>
    	<div>ACTA: <span style='font-weight: normal;'>$acta_id</span></div>
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
    	<div class='pull-left' style='padding-left: 60px; width: 300px; text-align: center; float: left;'>________________________________________________<br>FIRMA PERSONA ENCARGADA DE LA SEDE</div>
	    	<div class='pull-right' style='padding-right: 60px; width: 300px; text-align: center; float: left;'>________________________________________________<br>FIRMA PERSONA ENCARGADA DE INTERVENTORÍA<br></div>
    		<div class='clear'></div>
    	</div>";
    	$datos_acta = array();
    	$datos_acta['datos'] = $acta;
    	$html = "";
    			$html .= "<div id='imprimir'>"; // <acta>
        	//Página 1
        	$html .= $encabezado;
    	$html .= "
        	<div class='seccion' id='datos_generales'>
        	<div class='fila center bold'><div style='border:none; width: 100%'>2. DATOS GENERALES</div></div>
	    	<div class='fila col3'>
    			<div>2.1 FECHA INTERVENTORÍA:</div>
    			<div>2.2 HORA INICIO INTERVENTORÍA:</div>
    			<div>2.3 HORA FIN INTERVENTORÍA:</div>
    		</div>
    		<div class='fila col2'>
    			<div>2.4 NOMBRE ENCARGADO DE LA SEDE:</div>
    			<div>2.5 NOMBRE INTERVENTOR:</div>
    		</div>
    		<div class='clear'></div>
    	</div>
    	<div class='seccion' id='observaciones'>
    		<div class='fila center bold'><div style='border:none; width: 100%'>3. OBSERVACIONES AL MOMENTO DE LA INTERVENTORÍA</div></div>
    		<div class='fila observacion2'><div>3.1 OBSERVACIÓN DEL INTERVENTOR:</div></div>
    		<div class='fila observacion2'><div>3.2 OBSERVACIÓN DEL ENCARGADO DE LA SEDE:</div></div>
    		<div class='clear'></div>
    	</div>";
    	$html .= $pie_pagina;
    	$p = 1;
    	$html .= "<div class='paginacion'>PÁGINA $p</div>";
        $i = 1;
        $j = 1;
      			$encabezado_beneficiarios = "<div class='seccion' id='listado_beneficiarios'>
      			<div class='fila center bold'><div style='border:none; width: 100%'>4. LISTADO DE BENEFICIARIOS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE BUEN COMIENZO</div></div>
      			<div class='fila colb2 encabezadodoc'><div style='width: 2%;'>#</div><div style='width: 8%; font-size: 0.7em;'>4.1 DOCUMENTO</div><div style='width: 17%; font-size: 0.7em;'>4.2 NOMBRE COMPLETO</div><div style='width: 10%; font-size: 0.7em;'>4.3 GRUPO</div><div style='width: 10%; font-size: 0.7em;'>4.4 TELÉFONO O CELULAR</div><div style='width: 9%; font-size: 0.7em;'>4.5 Nombre y Nuip coinciden con SIBC</div><div style='width: 9%; font-size: 0.7em;'>4.6 Teléfono o Celular coincide con SIBC</div><div style='width: 9%; font-size: 0.7em;'>4.7  Certificado Sistema General Salud</div><div style='width: 9%; font-size: 0.7em;'>4.8  Certificado Sisben</div><div style='width: 9%; font-size: 0.7em;'>4.9 Certificado Formato Matrícula Firmada</div><div style='width: 8%; font-size: 0.7em;'>4.10 Fecha Matrícula Diligenciada</div></div>";
      			$html .= $encabezado;
      			$html .= $encabezado_beneficiarios;
      			foreach($acta->getCobActadocumentacionPersona(['order' => 'grupo, primerNombre asc']) as $row){
      			$nombre_completo = array($row->primerNombre, $row->segundoNombre, $row->primerApellido, $row->segundoApellido);
      			$nombre_completo = implode(" ", $nombre_completo);
      			if($row->beneficiarioTelefono){
      				$espacio = "&nbsp;";
      			} else {
      				$espacio = "";
      			}
      			$i = ($i<10) ? "0" .$i : $i;
      			if($j == 31){
      			$j = 1;
      					$p++;
      					$html .= "<div class='clear'></div></div>" . $pie_pagina;
      						$html .= "<div class='paginacion'>PÁGINA $p</div>";
  				$html .= $encabezado;
      						$html .= $encabezado_beneficiarios;
      					}
      					$html .="<div class='fila colb2'><div style='width: 2%;'>$i</div><div style='width: 8%; font-size: 0.8em;'>$row->numDocumento</div><div style='width: 17%; font-size: 0.8em;'>$nombre_completo</div><div style='width: 10%; font-size: 0.8em;'>$row->grupo</div><div style='width: 10%; font-size: 0.8em;'>$row->beneficiarioTelefono $espacio $row->beneficiarioCelular</div><div style='width: 9%'></div><div style='width: 9%'></div><div style='width: 9%'></div><div style='width: 9%'></div><div style='width: 9%'></div><div style='width: 8%'></div></div>";
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

    public function cargarBeneficiarios($carga, $modalidades, $id_verificacion)
    {
    	$db = $this->getDI()->getDb();
    	$config = $this->getDI()->getConfig();
    	$timestamp = new DateTime();
    	$tabla_mat = "m" . $timestamp->getTimestamp();
    	$archivo_mat = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreMat;
    	$db->query("CREATE TEMPORARY TABLE $tabla_mat (fechaRetiro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), telefonoBeneficiario VARCHAR(50), celularBeneficiario VARCHAR(50), grupo VARCHAR(80)) CHARACTER SET utf8 COLLATE utf8_bin");
    	$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_mat FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET fechaRetiro = @FECHA_RETIRO, id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\"), id_persona = @ID_PERSONA, numDocumento = @NUMERO_DOCUMENTO, primerNombre = TRIM(REPLACE(@PRIMER_NOMBRE, '\"',\"\")), segundoNombre = TRIM(REPLACE(@SEGUNDO_NOMBRE, '\"',\"\")), primerApellido = TRIM(REPLACE(@PRIMER_APELLIDO, '\"',\"\")), segundoApellido = TRIM(REPLACE(@SEGUNDO_APELLIDO, '\"',\"\")), telefonoBeneficiario = @TELEFONO_BENEFICIARIO, celularBeneficiario = @CELULAR_BENEFICIARIO, grupo = REPLACE(@NOMBRE_GRUPO, '\"',\"\")");
    	$db->query("DELETE FROM $tabla_mat WHERE id_modalidad NOT IN ($modalidades)");
    	if (in_array(8, $modalidades)) {
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
    	}
    	$db->query("DELETE FROM $tabla_mat WHERE fechaRetiro > 0000-00-00");
    	$db->query("INSERT IGNORE INTO cob_actadocumentacion (id_verificacion, id_carga, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre) SELECT $id_verificacion, $carga->id_carga, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre FROM $tabla_mat");
    	$db->query("INSERT IGNORE INTO cob_actadocumentacion_persona (id_actadocumentacion, id_verificacion, grupo, id_persona, id_contrato, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, beneficiarioTelefono, beneficiarioCelular) SELECT (SELECT id_actadocumentacion FROM cob_actadocumentacion WHERE cob_actadocumentacion.id_sede_contrato = $tabla_mat.id_sede_contrato AND cob_actadocumentacion.id_verificacion = $id_verificacion), $id_verificacion, grupo, id_persona, id_contrato, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, telefonoBeneficiario, celularBeneficiario FROM $tabla_mat");
    	$db->query("DROP TABLE $tabla_mat");
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
    			return "Verificación cerrada";
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
    	return "cob_actadocumentacion/ver/$this->id_actadocumentacion";
    }

    /**
     * Returns a human representation of 'id_actaconteo'
     *
     * @return string
     */
    public function getIdDetail()
    {
    	return "AVD-03-". date("Y") . sprintf('%05d', $this->id_actadocumentacion);
    }

    /**
     * Returns a human representation of 'id_actamuestreo'
     *
     * @return string
     */
    public function getId()
    {
    	return $this->id_actadocumentacion;
    }

    /**
     * Contar beneficiarios
     *
     * @return string
     */
    public function countBeneficiarios()
    {
    	return count($this->CobActadocumentacionPersona);
    }

    /**
     * Returns a human representation of 'estado'
     *
     * @return string
     */
    public function getsinonareDetail($value)
    {
    	switch ($value) {
    		case 2:
    			return " class='warning'";
    			break;
    		case 3:
    			return " class='warning'";
    			break;
    		case 4:
    			return " class='warning'";
    			break;
    		default:
    			return "";
    			break;
    	}
    }
}
