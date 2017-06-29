<?php

class BcPermisoGeneral extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_permiso;
    
    /**
     *
     * @var string
     */
    public $listadoNinios;

    /**
     *
     * @var string
     */
    public $actores;

    /**
     *
     * @var string
     */
    public $direccionEvento;

    /**
     *
     * @var string
     */
    public $personaContactoEvento;

    /**
     *
     * @var string
     */
    public $telefonoContactoEvento;
    
    /**
     *
     * @var string
     */
    public $emailContactoEvento;
    
    /**
     *
     * @var integer
     */
    public $requiereTransporte;

}
