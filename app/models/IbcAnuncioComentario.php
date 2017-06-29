<?php

class IbcAnuncioComentario extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_anuncio_comentario;

    /**
     *
     * @var integer
     */
    public $id_anuncio;

    /**
     *
     * @var integer
     */
    public $id_usuario;

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
