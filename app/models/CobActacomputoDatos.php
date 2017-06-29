<?php

class CobActacomputoDatos extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actacomputo;

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
    
    /**
     *
     * @var integer
     */
    public $cantidadEquipos;
    
    /**
     *
     * @var integer
     */
    public $servicioInternet;

}
