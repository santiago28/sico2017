<?php

class CobActaconteoPersona extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actaconteo_persona;

    /**
     *
     * @var integer
     */
    public $id_actaconteo;

    /**
     *
     * @var integer
     */
    public $id_periodo;

    /**
     *
     * @var integer
     */
    public $recorrido;

    /**
     *
     * @var integer
     */
    public $id_contrato;

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
     * @var integer
     */
    public $id_grupo;

    /**
     *
     * @var string
     */
    public $grupo;

    /**
     *
     * @var string
     */
    public $fechaInterventoria;

    /**
     *
     * @var integer
     */
    public $tipoPersona;

    /**
     *
     * @var integer
     */
    public $asistencia;

    //Virtual Foreign Key para poder acceder a la fecha de corte del acta
    public function initialize()
    {
    	$this->belongsTo('id_actaconteo_persona', 'CobActaconteoPersonaExcusa', 'id_actaconteo_persona', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_actaconteo_persona', 'CobActaconteoPersonaFacturacion', 'id_actaconteo_persona', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_actaconteo', 'CobActaconteo', 'id_actaconteo', array(
    			'reusable' => true
    	));
    }

    /**
     * Returns a human representation of 'estado'
     *
     * @return string
     */
    public function getAsistenciaDetail()
    {
    	switch ($this->asistencia) {
    		case 6:
    			return " class='warning'";
    			break;
    		case 4:
    			return " class='warning'";
    			break;
    		case 5:
    			return " class='warning'";
    			break;
    		default:
    			return "";
    			break;
    	}
    }

    /**
     * Returns a human representation of 'estado'
     *
     * @return string
     */
    public function getAsistenciaDetail2()
    {
    	switch ($this->asistencia) {
    		case 2:
    			return " class='warning'";
    			break;
    		case 3:
    			return " class='warning'";
    			break;
    		case 5:
    			return " class='success'";
    			break;
        case 7:
          return " class='info'";
          break;
    		default:
    			return "";
    			break;
    	}
    }

}
