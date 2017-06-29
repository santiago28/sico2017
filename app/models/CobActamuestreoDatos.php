<?php

class CobActamuestreoDatos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actamuestreo;

    /**
     *
     * @var string
     */
    public $correccionDireccion;

    /**
     *
     * @var string
     */
    public $direccionCorregida;

    /**
     *
     * @var integer
     */
    public $pendonClasificacion;
    
    /**
     *
     * @var integer
     */
    public $instalacionesDomiciliarias;
    
    /**
     *
     * @var integer
     */
    public $condicionesSeguridad;

    /**
     *
     * @var string
     */
    public $nombreEncargado;

    /**
     *
     * @var string
     */
    public $observacionEncargado;

    /**
     *
     * @var string
     */
    public $observacionUsuario;
    
    /**
     *
     * @var string
     */
    public $fecha;

    /**
     *
     * @var string
     */
    public $horaInicio;

    /**
     *
     * @var string
     */
    public $horaFin;

}
