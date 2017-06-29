<?php

class BcEmpleado extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_sede_contrato;

    /**
     *
     * @var string
     */
    public $nombre;

    /**
     *
     * @var integer
     */
    public $numDocumento;

    /**
     *
     * @var string
     */
    public $cargo;

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
     * @var string
     */
    public $diasLaborales;

    /**
     *
     * @var integer
     */
    public $estado;

}
