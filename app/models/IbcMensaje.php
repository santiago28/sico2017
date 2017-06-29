<?php

class IbcMensaje extends \Phalcon\Mvc\Model
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
    public $mensaje;
    
    /**
     *
     * @var integer
     */
    public $tipo;
    
    public function initialize()
    {
    	$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
    			'reusable' => true
    	));
    	$this->hasMany('id_mensaje', 'IbcMensajeComentario', 'id_mensaje');
    	$this->hasMany('id_mensaje', 'IbcMensajeUsuario', 'id_mensaje');
    	$this->belongsTo('destinatario', 'IbcMensajeDestinatario', 'id_mensaje_destinatario', array(
    			'reusable' => true
    	));
    }

}
