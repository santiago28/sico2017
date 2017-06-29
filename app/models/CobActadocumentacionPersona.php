<?php

class CobActadocumentacionPersona extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actadocumentacion_persona;

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
     * @var string
     */
    public $grupo;

    /**
     *
     * @var integer
     */
    public $id_persona;

    /**
     *
     * @var string
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
     * @var string
     */
    public $beneficiarioTelefono;

    /**
     *
     * @var integer
     */
    public $nombreCedulaSibc;

    /**
     *
     * @var integer
     */
    public $telefonoSibc;
    
    /**
     *
     * @var integer
     */
    public $certificadoSgs;
    
    /**
     *
     * @var integer
     */
    public $certificadoSisben;
    
    /**
     *
     * @var integer
     */
    public $matriculaFirmada;
    
    /**
     *
     * @var integer
     */
    public $fechaMatricula;
    
    //Virtual Foreign Key para poder acceder a la fecha de corte del acta
    public function initialize()
    {
    	$this->belongsTo('id_actadocumentacion', 'CobActadocumentacion', 'id_actadocumentacion', array(
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

}
