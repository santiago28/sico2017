<?php

class BcHcbperiodoEmpleadoFecha extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_hcbperiodo_empleado_fecha;

    /**
     *
     * @var integer
     */
    public $id_hcbperiodo_empleado;

    /**
     *
     * @var integer
     */
    public $id_hcbperiodo;

    /**
     *
     * @var integer
     */
    public $id_sede_contrato;

    /**
     *
     * @var integer
     */
    public $fecha;

    /**
     *
     * @var integer
     */
    public $jornada;

    /**
     *
     * @var string
     */
    public $fechahoraCreacion;

    /**
     *
     * @var string
     */
    public $fechahoraCancelacion;

    /**
     *
     * @var string
     */
    public $observacionCancelacion;

    /**
     *
     * @var integer
     */
    public $estado;

    //Virtual Foreign Key para poder acceder a la fecha de corte del acta
    public function initialize()
    {
    	$this->belongsTo('id_hcbperiodo_empleado', 'BcHcbperiodoEmpleado', 'id_hcbperiodo_empleado', array(
    			'reusable' => true
    	));
      $this->belongsTo('id_sede_contrato', 'BcSedeContrato', 'id_sede_contrato', array(
    			'reusable' => true
    	));
    }

    /**
     * Retorna la jornada del empleado
     *
     * @return string
     */
    public function getJornada()
    {
    	switch ($this->jornada) {
    		case 0:
    			return "";
    			break;
    		case 1:
    			return "M";
    			break;
    		case 2:
    			return "T";
    			break;
    	}
    }

    /**
     * Retorna la jornada del empleado
     *
     * @return string
     */
    public function labelEstado()
    {
    	switch ($this->estado) {
    		case 0:
    			return "primary";
    			break;
    		case 1:
    			return "danger";
    			break;
    		case 2:
    			return "success";
    			break;
    	}
    }

    /**
     * Retorna la jornada del empleado
     *
     * @return string
     */
    public function getEstado()
    {
    	switch ($this->estado) {
    		case 0:
    			return "Visita";
    			break;
    		case 1:
    			return "Visita Cancelada";
    			break;
    		case 2:
    			return "Visita Nueva";
    			break;
    	}
    }
}
