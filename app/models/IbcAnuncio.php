<?php

class IbcAnuncio extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_anuncio;

    /**
     *
     * @var integer
     */
    public $id_componente;

    /**
     *
     * @var integer
     */
    public $id_grupo;

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
