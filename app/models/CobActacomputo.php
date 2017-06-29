<?php
use Phalcon\DI\FactoryDefault;
class CobActacomputo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actacomputo;

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
    	$this->belongsTo('id_actacomputo', 'CobActacomputoDatos', 'id_actacomputo', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
    			'reusable' => true
    	));
    	$this->belongsTo('estado', 'IbcReferencia', 'id_referencia', array(
    			'reusable' => true
    	));
    }

    public function generarActa($id_actacomputo){
    	$acta = CobActacomputo::findFirstByid_actacomputo($id_actacomputo);
    	if(!$acta || $acta == NULL){
    		return FALSE;
    	}
    	$acta_id = "AVE-03-". date("Y") . sprintf('%05d', $acta->id_actacomputo);
    	$encabezado = "<div class='seccion encabezado'>
    	<div class='fila center'><div>ACTA DE VERIFICACIÓN FÍSICA DE EQUIPOS DE CÓMPUTO DE ACUERDO A LAS CÉD EN EL SIBC<br>INTERVENTORÍA BUEN COMIENZO</div></div>
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
    		<div class='fila observacion2'><div>3.1 OBSERVACIÓN DEL INTERVENTOR:<br>3.1.1 CANTIDAD DE EQUIPOS DE CÓMPUTO: __<br>3.1.2 LA SEDE CUENTA CON SERVICIO DE INTERNET: __</div></div>
    		<div class='fila observacion2'><div>3.2 OBSERVACIÓN DEL ENCARGADO DE LA SEDE:</div></div>
    		<div class='clear'></div>
    	</div>";
    	$html .= $pie_pagina;
    	$p = 1;
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
    	$db->query("CREATE TEMPORARY TABLE $tabla_mat (id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100)) CHARACTER SET utf8 COLLATE utf8_bin");
    	$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_mat FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\")");
    	$db->query("DELETE FROM $tabla_mat WHERE id_modalidad NOT IN ($modalidades)");
    	$db->query("INSERT IGNORE INTO cob_actacomputo (id_verificacion, id_carga, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre) SELECT $id_verificacion, $carga->id_carga, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre FROM $tabla_mat");
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
    	return "cob_actacomputo/ver/$this->id_actacomputo";
    }

    /**
     * Returns a human representation of 'id_actacomputo'
     *
     * @return string
     */
    public function getIdDetail()
    {
    	return "AVE-03-". date("Y") . sprintf('%05d', $this->id_actacomputo);
    }

    /**
     * Returns a human representation of 'id_actacomputo'
     *
     * @return string
     */
    public function getId()
    {
    	return $this->id_actacomputo;
    }

    /**
     * Contar beneficiarios
     *
     * @return string
     */
    public function countBeneficiarios()
    {
    	return 0;
    }
}
