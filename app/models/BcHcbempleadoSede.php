<?php

class BcHcbempleadoSede extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_hcbempleado_sede;

    /**
     *
     * @var integer
     */
    public $id_hcbempleado;

    /**
     *
     * @var integer
     */
    public $id_sede_contrato;

    public function initialize()
    {
      $this->belongsTo('id_sede_contrato', 'BcSedeContrato', 'id_sede_contrato', array(
  				'reusable' => true
  		));
      $this->belongsTo('id_hcbempleado', 'BcHcbempleado', 'id_hcbempleado', array(
  				'reusable' => true
  		));
    }

}
