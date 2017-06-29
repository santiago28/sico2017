<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;

class IbcUsuario extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_usuario;

    /**
     *
     * @var integer
     */
    public $id_componente;

    /**
     *
     * @var string
     */
    public $usuario;

    /**
     *
     * @var string
     */
    public $nombre;

    /**
     *
     * @var integer
     */
    public $telefono;

    /**
     *
     * @var integer
     */
    public $celular;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var integer
     */
    public $id_usuario_cargo;

    /**
     *
     * @var string
     */
    public $foto;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var integer
     */
    public $estado;
    
    public function initialize()
    {
    	$this->belongsTo('id_usuario_cargo', 'IbcUsuarioCargo', 'id_usuario_cargo', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_componente', 'IbcComponente', 'id_componente', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_usuario', 'IbcUsuarioOferente', 'id_usuario', array(
    			'reusable' => true
    	));
    }
    
    public function validation()
    {
        $this->validate(new EmailValidator(array(
            'field' => 'email'
        )));
        $this->validate(new UniquenessValidator(array(
            'field' => 'email',
            'message' => 'Sorry, The email was registered by another user'
        )));
        $this->validate(new UniquenessValidator(array(
            'field' => 'usuario',
            'message' => 'Sorry, That username is already taken'
        )));
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}
