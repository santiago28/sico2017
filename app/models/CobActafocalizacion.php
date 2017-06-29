<?php
use Phalcon\DI\FactoryDefault;

class CobActafocalizacion extends \Phalcon\Mvc\Model
{

	 /**
     *
     * @var integer
     */
    public $id_actafocalizacion;

    /**
     *
     * @var integer
     */
    public $id_verificacion;

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
    	$this->belongsTo('id_actafocalizacion', 'CobActafocalizacionDatos', 'id_actafocalizacion', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
    			'reusable' => true
    	));
    	$this->hasMany('id_actafocalizacion', 'CobActafocalizacionPersona', 'id_actafocalizacion', array(
    			'foreignKey' => array(
    					'message' => 'El acta no puede ser eliminada porque existen empleados asociados a ésta'
    			)
    	));
    }

    public function generarActa($id_actafocalizacion){
    	$acta = CobActafocalizacion::findFirstByid_actafocalizacion($id_actafocalizacion);
    	if(!$acta || $acta == NULL){
    		return FALSE;
    	}
    	$acta_id = "AFC-03-". date("Y") . sprintf('%05d', $acta->id_actafocalizacion);
    	$encabezado = "<div class='seccion encabezado'>
    	<div class='fila center'><div>ACTA DE VERIFICACIÓN FÍSICA DE FOCALIZACIÓN DE LOS BENEFICIARIOS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE BUEN COMIENZO<br>INTERVENTORÍA BUEN COMIENZO</div></div>
    	<div class='fila col3 center'><div>Código: F-ITBC-GC-001</div><div></div><div></div></div>
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
      			$encabezado_talentohumano = "<div class='seccion'>
      			<div class='fila center bold'><div style='border:none; width: 100%'>4. LISTADO DE BENEFICIARIOS REPORTADOS EN EL SISTEMA DE INFORMACIÓN DE BUEN COMIENZO</div></div>
      			<div class='fila colb2 encabezadodoc'><div style='width: 20px;'>#</div><div style='width: 60px;'>4.1 DOCUMENTO</div><div style='width: 100px'>4.2 NOMBRE COMPLETO</div><div style='width: 80px'>4.3 SOLICITUD ENCUESTA SISBEN</div><div style='width: 80px'>4.4 PUNTAJE SISBEN V3</div><div style='width: 90px'>4.5 CIUDAD SISBEN V3</div><div style='width: 65px'>4.6 CONTINUIDAD AÑO 2015</div><div style='width: 60px'>4.7  OFICIO DE AUTORIZACIÓN</div><div style='width: 85px;'>4.8 OBSERVACIONES</div></div>";
      			$html .= $encabezado;
      			$html .= $encabezado_talentohumano;
      			foreach($acta->getCobactafocalizacionPersona(['order' => 'primerNombre asc']) as $row){
      			$nombre_completo = array($row->primerNombre, $row->segundoNombre, $row->primerApellido, $row->segundoApellido);
      			$nombre_completo = implode(" ", $nombre_completo);
      			$i = ($i<10) ? "0" .$i : $i;
      			if($j == 7){
      			$j = 1;
      					$p++;
      					$html .= "<div class='clear'></div></div>" . $pie_pagina;
      					$html .= "<div class='paginacion'>PÁGINA $p</div>";
  				      $html .= $encabezado;
      					$html .= $encabezado_talentohumano;
      			}
      					$html .="<div class='fila colb2'><div style='width: 20px;'>$i</div><div style='width: 60px;'>$row->numDocumento</div><div style='width: 100px'>$nombre_completo</div><div style='width: 80px;'></div><div style='width: 80px'></div><div style='width: 90px'></div><div style='width: 65px'></div><div style='width: 60px'></div><div style='width: 85px'></div></div>";
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

    public function cargarBeneficiarios($carga, $id_verificacion)
    {
    	$db = $this->getDI()->getDb();
    	$config = $this->getDI()->getConfig();
    	$timestamp = new DateTime();
    	$tabla_mat = "m" . $timestamp->getTimestamp();
    	$archivo_mat = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreMat;
    	$db->query("CREATE TEMPORARY TABLE $tabla_mat (id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20)) CHARACTER SET utf8 COLLATE utf8_bin");
    	$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_mat FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@id_contrato, @id_sede, @numDocumento, @primerNombre, @segundoNombre, @primerApellido, @segundoApellido) SET id_contrato = @id_contrato, id_sede = @id_sede, numDocumento = @numDocumento, primerNombre = @primerNombre, segundoNombre = @segundoNombre, primerApellido = @primerApellido, segundoApellido = @segundoApellido");
    	$db->query("INSERT IGNORE INTO cob_actafocalizacion (id_verificacion, id_carga, id_contrato, id_sede) SELECT $id_verificacion, $carga->id_carga, id_contrato, id_sede FROM $tabla_mat");
      $db->query("UPDATE cob_actafocalizacion, cob_actaconteo SET cob_actafocalizacion.id_sede_contrato = cob_actaconteo.id_sede_contrato, cob_actafocalizacion.id_modalidad = cob_actaconteo.id_modalidad, cob_actafocalizacion.modalidad_nombre = cob_actaconteo.modalidad_nombre, cob_actafocalizacion.sede_nombre = cob_actaconteo.sede_nombre, cob_actafocalizacion.sede_barrio = cob_actaconteo.sede_barrio, cob_actafocalizacion.sede_direccion = cob_actaconteo.sede_direccion, cob_actafocalizacion.sede_telefono = cob_actaconteo.sede_telefono, cob_actafocalizacion.id_oferente = cob_actaconteo.id_oferente, cob_actafocalizacion.oferente_nombre = cob_actaconteo.oferente_nombre WHERE cob_actafocalizacion.id_sede = cob_actaconteo.id_sede AND cob_actafocalizacion.id_contrato = cob_actaconteo.id_contrato AND cob_actafocalizacion.id_verificacion = $id_verificacion");
    	$db->query("INSERT IGNORE INTO cob_actafocalizacion_persona (id_actafocalizacion, id_contrato, id_sede, id_verificacion, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido) SELECT (SELECT id_actafocalizacion FROM cob_actafocalizacion WHERE cob_actafocalizacion.id_contrato = $tabla_mat.id_contrato AND cob_actafocalizacion.id_sede = $tabla_mat.id_sede AND cob_actafocalizacion.id_verificacion = $id_verificacion), id_contrato, id_sede, $id_verificacion, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido FROM $tabla_mat");
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
    	return "cob_actafocalizacion/ver/$this->id_actafocalizacion";
    }

    /**
     * Returns a human representation of 'id_actafocalizacion'
     *
     * @return string
     */
    public function getIdDetail()
    {
    	return "AFC-03-". date("Y") . sprintf('%05d', $this->id_actafocalizacion);
    }

    /**
     * Returns a human representation of 'id_actafocalizacion'
     *
     * @return string
     */
    public function getId()
    {
    	return $this->id_actafocalizacion;
    }

    /**
     * Contar beneficiarios
     *
     * @return string
     */
    public function countBeneficiarios()
    {
    	return count($this->CobactafocalizacionPersona);
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
