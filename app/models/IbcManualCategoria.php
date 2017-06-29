<?php

class IbcManualCategoria extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_manual_categoria;

    /**
     *
     * @var integer
     */
    public $id_manual_categoria_padre;

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
     * @var string
     */
    public $nombre;

}
