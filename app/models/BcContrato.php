<?php

class BcContrato extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_contrato;

    /**
     *
     * @var integer
     */
    public $id_oferente;

    /**
     *
     * @var integer
     */
    public $id_modalidad;

    /**
     *
     * @var string
     */
    public $fechaInicio;

    /**
     *
     * @var string
     */
    public $fechaFin;

    /**
     *
     * @var integer
     */
    public $estado;

}
