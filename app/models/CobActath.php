<?php
use Phalcon\DI\FactoryDefault;

class CobActath extends \Phalcon\Mvc\Model
{

	 /**
     *
     * @var integer
     */
    public $id_actath;

    /**
     *
     * @var integer
     */
    public $id_verificacion;

    /**
     *
     * @var integer
     */
    public $id_mes;

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
    	$this->belongsTo('id_actath', 'CobActathDatos', 'id_actath', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
    			'reusable' => true
    	));
    	$this->hasMany('id_actath', 'CobActathPersona', 'id_actath', array(
    			'foreignKey' => array(
    					'message' => 'El acta no puede ser eliminada porque existen empleados asociados a ésta'
    			)
    	));
    }

    public function generarActa($id_actath){
    	$acta = CobActath::findFirstByid_actath($id_actath);
    	if(!$acta || $acta == NULL){
    		return FALSE;
    	}
    	$acta_id = "ATH-03-". date("Y") . sprintf('%05d', $acta->id_actath);
    	$encabezado = "<div class='seccion encabezado'>
    	<div class='fila center'><div>ACTA DE VERIFICACIÓN FÍSICA DE LA ATENCIÓN DEL 100% DEL TALENTO HUMANO REPORTADO EN EL SIST. INFORMACIÓN DELFI<br>INTERVENTORÍA BUEN COMIENZO</div></div>
    	<div class='fila col3 center'><div>Código: F-ITBC-GC-001</div><div>&nbsp;&nbsp;</div><div>&nbsp;&nbsp;</div></div>
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
	    	<div style='width: 100%; text-align: center; float: left;'>________________________________________________<br>FIRMA PERSONA ENCARGADA DE INTERVENTORÍA<br></div>
    		<div class='clear'></div>
    	</div>";
      $pie_pagina2 = "<div id='pie_pagina'>
    	<div class='pull-left' style='padding-left: 60px; width: 50%; text-align: center; float: left;'>________________________________________________<br>FIRMA PERSONA ENCARGADA DE LA SEDE</div>
	    	<div class='pull-right' style='padding-right: 60px; width: 50%; text-align: center; float: left;'>________________________________________________<br>FIRMA PERSONA ENCARGADA DE INTERVENTORÍA<br></div>
    		<div class='clear'></div>
    	</div>";
		/*
		<div class='fila'><div>1.2 AUSENTE CON EXCUSA FÍSICA</div></div>
	    	<div class='fila'><div>1.3 AUSENTE CON EXCUSA TELEFÓNICA</div></div>
	    	<div class='fila'><div>1.4 RETIRADO ANTES DEL DÍA DE CORTE DE PERIODO</div></div>
			DESPUES DEL DÍA DE CORTE DE PERIODO
			QUE NO PRESENTA EXCUSA EL DÍA DEL REPORTE
			<div class='fila'><div>1.7 CON EXCUSA MÉDICA MAYOR O IGUAL A 15 DIAS</div></div>
		*/
      $totalizacion_asistencia = "<div class='seccion' id='totalizacion_asistencia'>
    		<div class='fila center bold'><div style='border:none; width: 100%'>1. TOTALIZACIÓN DE ASISTENCIA</div></div>
	    	<div class='fila'><div>1.1 ASISTE</div></div>
	    	<div class='fila'><div>1.5 RETIRADO</div></div>
	    	<div class='fila'><div>1.6 AUSENTE EL DIA DE LA INTERVENTORIA</div></div>
	    	<div class='fila'><div>1.7 AUSENTE EN LA SEDE POR REPORTE MEDICO</div></div>
	    	<div class='fila'><div>1.8 AUSENTE EN LA SEDE POR REUNIÓN</div></div>
    		<div class='clear'></div>
    	</div>";
    	$datos_acta = array();
    	$datos_acta['datos'] = $acta;
    	$html = "";
    	$html .= "<div id='imprimir'>"; // <acta>
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
      			<div class='fila center bold'><div style='border:none; width: 100%'>4. LISTADO DE TALENTO HUMANO REPORTADO EN EL SIST. DE INFORMACIÓN DELFI</div></div>
      			<div class='fila colb2 encabezadodoc'><div style='width: 4%;'>#</div><div style='width: 8%;'>4.1 DOCUMENTO</div><div style='width: 8%'>4.2 NOMBRE COMPLETO</div><div style='width: 8%'>4.3 FORMACIÓN ACADÉMICA</div><div style='width: 8%'>4.4 CARGO</div><div style='width: 6%'>4.5 TIPO CONTR.</div><div style='width: 10%'>4.6 BASE SALARIO</div><div style='width: 8%'>4.7  PCT DEDIC.</div><div style='width: 10%;'>4.8  FECHA INGRESO</div><div style='width: 10%;'>4.9 FECHA RETIRO</div><div style='width: 4%;'>4.10 ASISTE</div><div style='width: 10%'>4.11 OBSERVACIONES</div><div style='width: 4%'>4.12 FIRMA</div></div>";
      			$html .= $encabezado;
      			$html .= $encabezado_talentohumano;
      			foreach($acta->getCobActathPersona(['tipoPersona = 0', 'order' => 'id_sede asc']) as $row){
      			$nombre_completo = array($row->primerNombre, $row->segundoNombre, $row->primerApellido, $row->segundoApellido);
      			$nombre_completo = strtoupper(implode(" ", $nombre_completo));
      			$i = ($i<10) ? "0" .$i : $i;
      			if($j == 7){
      			$j = 1;
      					$p++;
      					$html .= "<div class='clear'></div></div>VL: Vinculación laboral - Salario<br>PS: Prestación de servicios - Honorarios" . $pie_pagina;
      					$html .= "<div class='paginacion'>PÁGINA $p</div>";
  				      $html .= $encabezado;
      					$html .= $encabezado_talentohumano;
      			}
      					$html .="<div class='fila colb2'><div style='width: 4%;'>$i</div><div style='width: 8%;'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p>$row->numDocumento</div><div style='width: 8%'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p>$nombre_completo</div><div style='width: 8%;'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p>$row->formacionAcademica</div><div style='width: 8%; padding-left: 0 !important; padding-right: 0 !important'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p>$row->cargo</div><div style='width: 6%; padding-left: 0 !important; padding-right: 0 !important'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p>$row->tipoContrato</div><div style='width: 10%; padding-left: 0 !important; padding-right: 0 !important;'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p>$ ".number_format ($row->baseSalario, 0, ',', '.')."</div><div style='width: 8%; padding-left: 0 !important; padding-right: 0 !important'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p>".$row->porcentajeDedicacion * 100 ." %</div><div style='width: 10%; padding-left: 0 !important; padding-right: 0 !important'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p>".$this->conversiones->fecha(2, $row->fechaIngreso)."</div><div style='width: 10%'></div><div style='width: 4%'></div><div style='width: 10%'></div><div style='width: 4%'></div></div>";
      					$i++;
      					$j++;
      			}
      			$p++;
      			$html .= "<div class='clear'></div></div>VL: Vinculación laboral - Salario<br>PS: Prestación de servicios - Honorarios" . $pie_pagina;
            $html .= "<div class='paginacion'>PÁGINA $p</div>";
            $i = 1;
            $j = 1;
            $encabezado_talentohumano_adicional = "<div class='seccion'>
            <div class='fila center bold'><div style='border:none; width: 100%'>4. LISTADO DE TALENTO HUMANO ADICIONAL AL REPORTADO EN EL SIST. DE INFORMACIÓN DELFI</div></div>
            <div class='fila colb2 encabezadodoc'><div style='width: 4%;'>#</div><div style='width: 8%;'>4.1 DOCUMENTO</div><div style='width: 8%'>4.2 NOMBRE COMPLETO</div><div style='width: 8%'>4.3 FORMACIÓN ACADÉMICA</div><div style='width: 8%'>4.4 CARGO</div><div style='width: 6%'>4.5 TIPO CONTR.</div><div style='width: 10%'>4.6 BASE SALARIO</div><div style='width: 8%'>4.7  PCT DEDIC.</div><div style='width: 10%;'>4.8  FECHA INGRESO</div><div style='width: 10%;'>4.9 FECHA RETIRO</div><div style='width: 4%;'>4.10 ASISTE</div><div style='width: 10%'>4.11 OBSERVACIONES</div><div style='width: 4%'>4.12 FIRMA</div></div>";
            $html .= $encabezado;
            $html .= $encabezado_talentohumano_adicional;
            $i = ($i<10) ? "0" .$i : $i;
            for($i = 1; $i <= 6; $i++){
  					$html .="<div class='fila colb2'><div style='width: 4%;'>$i</div><div style='width: 8%;'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p></div><div style='width: 8%'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p></div><div style='width: 8%;'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p></div><div style='width: 8%; padding-left: 0 !important; padding-right: 0 !important'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p></div><div style='width: 6%; padding-left: 0 !important; padding-right: 0 !important'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p></div><div style='width: 10%; padding-left: 0 !important; padding-right: 0 !important;'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p></div><div style='width: 8%; padding-left: 0 !important; padding-right: 0 !important'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p></div><div style='width: 10%; padding-left: 0 !important; padding-right: 0 !important'><p><span class='label label-default'>SÍ</span><span class='label label-default'>NO</span><span class='label label-default'>N/A</span></p></div><div style='width: 10%'></div><div style='width: 4%'></div><div style='width: 10%'></div><div style='width: 4%'></div></div>";
            }
            $p++;
          	$html .= "<div class='clear'></div></div>" . $pie_pagina;
            $html .= "<div class='paginacion'>PÁGINA $p</div>";
            //Inicio Hojas para el prestador
            $i = 1;
            $j = 1;
            $encabezado_talentohumano = "<div class='seccion'>
      			<div class='fila center bold'><div style='border:none; width: 100%'>4. LISTADO DE TALENTO HUMANO REPORTADO EN EL SIST. DE INFORMACIÓN DELFI</div></div>
      			<div class='fila colb2 encabezadodoc'><div style='width: 5%;'>#</div><div style='width: 20%;'>4.1 DOCUMENTO</div><div style='width: 30%'>4.2 NOMBRE COMPLETO</div><div style='width: 30%;'>4.10 ASISTENCIA</div><div style='width: 10%'>4.12 FIRMA</div></div>";
      			$html .= $encabezado;
      			$html .= $encabezado_talentohumano;
      			foreach($acta->getCobActathPersona(['tipoPersona = 0', 'order' => 'id_sede asc']) as $row){
      			$nombre_completo = array($row->primerNombre, $row->segundoNombre, $row->primerApellido, $row->segundoApellido);
      			$nombre_completo = strtoupper(implode(" ", $nombre_completo));
      			$i = ($i<10) ? "0" .$i : $i;
      			if($j == 7){
      			$j = 1;
      					$p++;
      					$html .= "<div class='clear'></div></div>" . $pie_pagina2;
      					$html .= "<div class='paginacion'>PÁGINA $p</div>";
  				      $html .= $encabezado;
      					$html .= $encabezado_talentohumano;
      			}
      					$html .="<div class='fila colb2'><div style='width: 5%;'>$i</div><div style='width: 20%;'>$row->numDocumento</div><div style='width: 30%'>$nombre_completo</div><div style='width: 30%;'></div><div style='width: 10%'></div></div>";
      					$i++;
      					$j++;
      			}
      			$p++;
      			$html .= "<div class='clear'></div></div>" . $pie_pagina2;
            $html .= "<div class='paginacion'>PÁGINA $p</div>";
            $i = 1;
            $j = 1;
            $encabezado_talentohumano_adicional = "<div class='seccion'>
            <div class='fila center bold'><div style='border:none; width: 100%'>4. LISTADO DE TALENTO HUMANO ADICIONAL AL REPORTADO EN EL SIST. DE INFORMACIÓN DELFI</div></div>
            <div class='fila colb2 encabezadodoc'><div style='width: 5%;'>#</div><div style='width: 20%;'>4.1 DOCUMENTO</div><div style='width: 30%'>4.2 NOMBRE COMPLETO</div><div style='width: 30%;'>4.10 ASISTENCIA</div><div style='width: 10%'>4.12 FIRMA</div></div>";
            $html .= $encabezado;
            $html .= $encabezado_talentohumano_adicional;
            $i = ($i<10) ? "0" .$i : $i;
            for($i = 1; $i <= 6; $i++){
  					$html .="<div class='fila colb2'><div style='width: 5%;'>$i</div><div style='width: 20%;'></div><div style='width: 30%'></div><div style='width: 30%;'></div><div style='width: 10%'></div></div>";
            }
            $p++;
          	$html .= "<div class='clear'></div></div>" . $pie_pagina2;
            $html .= "<div class='paginacion'>PÁGINA $p</div>";
            ////Fin Hojas para el prestador
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
    	return "cob_actath/ver/$this->id_actath";
    }

    /**
     * Returns a human representation of 'id_actath'
     *
     * @return string
     */
    public function getIdDetail()
    {
    	return "ATH-03-". date("Y") . sprintf('%05d', $this->id_actath);
    }

    /**
     * Returns a human representation of 'id_actath'
     *
     * @return string
     */
    public function getId()
    {
    	return $this->id_actath;
    }

    /**
     * Contar beneficiarios
     *
     * @return string
     */
    public function countBeneficiarios()
    {
    	return count($this->CobActathPersona);
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
