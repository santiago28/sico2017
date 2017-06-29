<?php

class BcCargaActa extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_carga_acta;

    /**
     *
     * @var integer
     */
    public $id_actaconteo;

    /**
     *
     * @var string
     */
    public $nombreArchivo;

    /**
     *
     * @var string
     */
    public $mes;

    /**
     *
     * @var string
     */
    public $fecha;

    /**
     *
     * @var integer
     */
    public $id_usuario;

    public function initialize()
    {
    	$this->belongsTo('id_actaconteo', 'CobActaconteo', 'id_actaconteo', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
    			'reusable' => true
    	));
    }

}
