<?php

class CobAjusteReportado extends \Phalcon\Mvc\Model
{
	/**
	 *
	 * @var integer
	 */
	public $id_ajuste_reportado;

    /**
     *
     * @var string
     */
    public $fecha;
    
    //Virtual Foreign Key para poder acceder a la fecha de corte del acta
    public function initialize()
    {
    	$this->hasMany('id_ajuste_reportado', 'CobAjuste', 'id_ajuste_reportado', array(
    			'foreignKey' => array(
    					'message' => 'La fecha no puede ser eliminada porque hay ajustes asignados a esta.'
    			)
    	));
    }
    
    /**
     * Returns a human representation of 'estado'
     *
     * @return string
     */
    public function getEstado()
    {
    	if ($this->estado == 1) {
    		return 'Habilitada';
    	} else if($this->estado == 2) {
    		return 'Deshabilitada';
    	}
    	return $this->estado;
    }

}
