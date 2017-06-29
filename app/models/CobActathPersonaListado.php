<?php

class CobActathPersonaListado extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actath_persona;

    /**
     *
     * @var integer
     */
    public $id_actath;

    /**
     *
     * @var integer
     */
    public $id_contrato;

    /**
     *
     * @var integer
     */
    public $id_sede;

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
    public $numDocumento;

    /**
     *
     * @var string
     */
    public $fechaRetiro;

    /**
     *
     * @var integer
     */
    public $asistencia;

    /**
     *
     * @var string
     */
    public $observacion;

    /**
     *
     * @var integer
     */
    public $cedulaCoincide;

    /**
     *
     * @var integer
     */
    public $nombreCoincide;

    /**
     *
     * @var integer
     */
    public $formacionacademicaCoincide;

    /**
     *
     * @var integer
     */
    public $cargoCoincide;

    /**
     *
     * @var integer
     */
    public $sedeCoincide;

    /**
     *
     * @var integer
     */
    public $tipocontratoCoincide;

    /**
     *
     * @var integer
     */
    public $salarioCoincide;

    /**
     *
     * @var integer
     */
    public $dedicacionCoincide;

    /**
     *
     * @var integer
     */
    public $fechaingresoCoincide;

    /**
     *
     * @var integer
     */
    public $tipoPersona;

    //Virtual Foreign Key para poder acceder a la fecha de corte del acta
    public function initialize()
    {
    	$this->belongsTo('id_verificacion', 'CobVerificacion', 'id_verificacion', array(
    			'reusable' => true
    	));
      $this->belongsTo('id_actath_persona', 'CobActathPersona', 'id_actath_persona', array(
    			'reusable' => true
    	));
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
    			return " class='danger'";
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
    /**
     * Returns a human representation of 'fechaRetiro'
     *
     * @return string
     */
    public function getFechaRetiro()
    {
      $conversiones = $this->getDI()->getConversiones();
    	if(!($this->fechaRetiro) || $this->fechaRetiro == "0000-00-00"){
        return FALSE;
      } else {
        return $conversiones->fecha(2, $this->fechaRetiro);
      }
    }
}
