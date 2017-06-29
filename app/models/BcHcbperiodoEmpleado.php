<?php
use Phalcon\DI\FactoryDefault;

class BcHcbperiodoEmpleado extends \Phalcon\Mvc\Model
{

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
    public $id_hcbempleado;

    /**
     *
     * @var integer
     */
    public $id_contratosede;

    public function initialize()
    {
    	$this->belongsTo('id_hcbperiodo', 'BcHcbperiodo', 'id_hcbperiodo', array(
    			'reusable' => true
    	));
      $this->belongsTo('id_hcbempleado', 'BcHcbempleado', 'id_hcbempleado', array(
    			'reusable' => true
    	));
      $this->belongsTo('id_sede_contrato', 'BcSedeContrato', 'id_sede_contrato', array(
    			'reusable' => true
    	));
      $this->hasMany('id_hcbperiodo_empleado', 'BcHcbperiodoEmpleadoFecha', 'id_hcbperiodo_empleado');
    }

    /**
     * Retorna el cargo del empleado
     *
     * @return string
     */
    public function getCategoria()
    {
    	switch ($this->cargo) {
    		case 0:
    			return "No Asignado";
    			break;
    		case 1:
    			return "Pedagogo";
    			break;
    		case 2:
    			return "Psicosocial";
    			break;
    		case 3:
    			return "Educador Físico";
    			break;
    		case 4:
    			return "Nutricionista";
    			break;
    	}
    }

}
