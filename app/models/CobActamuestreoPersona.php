<?php

class CobActamuestreoPersona extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actamuestreo_persona_facturacion;

    /**
     *
     * @var integer
     */
    public $id_actamuestreo;
    
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
     * @var string
     */
    public $fechaEncuentro;
    
    /**
     *
     * @var string
     */
    public $horaEncuentro;
    
    /**
     *
     * @var integer
     */
    public $cicloVital;
    
    /**
     *
     * @var integer
     */
    public $complAlimentario;

    /**
     *
     * @var integer
     */
    public $asistencia;
    
    //Virtual Foreign Key para poder acceder a la fecha de corte del acta
    public function initialize()
    {
    	$this->belongsTo('id_actamuestreo_persona', 'CobActamuestreoPersonaFacturacion', 'id_actamuestreo_persona', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_actamuestreo', 'CobActamuestreo', 'id_actamuestreo', array(
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
    			return " class='danger'";
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

}
