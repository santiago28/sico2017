<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class BcOferente extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_oferente;

    /**
     *
     * @var string
     */
    public $nombre;

    /**
     *
     * @var string
     */
    public $abreviacion;

    /**
     *
     * @var string
     */
    public $direccion;

    /**
     *
     * @var string
     */
    public $telefonos;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var integer
     */
    public $estado;
    public function validation()
    {

        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}
