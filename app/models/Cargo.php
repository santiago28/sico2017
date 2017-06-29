<?php
use Phalcon\DI\FactoryDefault;
class Cargo extends \Phalcon\Mvc\Model
{
  /**
   *
   * @var integer
   */
  public $id_cargo;

  /**
   *
   * @var string
   */
  public $nombre_cargo;

  /**
   *
   * @var string
   */
  public $codito_tipo_contrato;

  /**
   *
   * @var integer
   */
  public $base_salario_honorarios;

  /**
   *
   * @var integer
   */
  public $estado;

  public function initialize()
  {
    $this->setConnectionService('db_delfi');
  }
}
