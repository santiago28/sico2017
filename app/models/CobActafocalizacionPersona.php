<?php

class CobActafocalizacionPersona extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actafocalizacion_persona;

    /**
     *
     * @var integer
     */
    public $id_actafocalizacion;

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
    public $numDocumento;

    /**
     *
     * @var string
     */
    public $primerNombre;

    /**
     *
     * @var string
     */
    public $segundoNombre;

    /**
     *
     * @var string
     */
    public $primerApellido;

    /**
     *
     * @var string
     */
    public $segundoApellido;

    /**
     *
     * @var integer
     */
    public $encuestaSisben;

    /**
     *
     * @var string
     */
    public $puntajeSisben;

    /**
     *
     * @var integer
     */
    public $sisbenMedellin;

    /**
     *
     * @var integer
     */
    public $continuidad2015;

    /**
     *
     * @var string
     */
    public $oficioAutorizacion;

    /**
     *
     * @var string
     */
    public $observacion;

    /**
     * Returns a human representation of 'estado'
     *
     * @return string
     */
    public function getsinonaDetail($value)
    {
    	switch ($value) {
    		case 2:
    			return " class='danger'";
    			break;
    		case 3:
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
