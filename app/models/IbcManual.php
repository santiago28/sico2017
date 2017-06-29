<?php

class IbcManual extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_manual;

    /**
     *
     * @var integer
     */
    public $id_manual_categoria;

    /**
     *
     * @var integer
     */
    public $id_usuario;

    /**
     *
     * @var string
     */
    public $titulo;

    /**
     *
     * @var string
     */
    public $contenido;

    /**
     *
     * @var string
     */
    public $fechahora;

}
