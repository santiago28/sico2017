<?php

class CobActaconteoMcb extends \Phalcon\Mvc\Model
{
    /**
     *
     * @var integer
     */
    public $id_actaconteo_mcb;

    /**
     *
     * @var integer
     */
    public $id_actaconteo;

    /**
     *
     * @var integer
     */
    public $numDocumento;

    /**
     *
     * @var string
     */
    public $primerNombre;

    /**
     *
     * @var string
     */
    public $segundoNombre;

    /**
     *
     * @var string
     */
    public $primerApellido;

    /**
     *
     * @var string
     */
    public $segundoApellido;

    /**
     * Retorna el nombre completo
     *
     * @return string
     */
    public function getNombrecompleto()
    {
      $nombre_completo = array($this->primerNombre, $this->segundoNombre, $this->primerApellido, $this->segundoApellido);
      return implode(" ", $nombre_completo);
    }
}
