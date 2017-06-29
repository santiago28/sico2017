<?php

class IbcMensajeComentario extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_mensaje;
    
    /**
     *
     * @var integer
     */
    public $id_usuario;

    /**
     *
     * @var string
     */
    public $comentario;
    
    public function initialize()
    {
    	$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
    			'reusable' => true
    	));
    }

}
