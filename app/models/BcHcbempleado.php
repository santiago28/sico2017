<?php

class BcHcbempleado extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_hcbempleado;

    /**
     *
     * @var integer
     */
    public $id_oferente;

    /**
     *
     * @var string
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

    public function initialize()
    {
      $this->hasMany('id_hcbempleado', 'BcHcbempleadoSede', 'id_hcbempleado', array(
  				'reusable' => true
  		));
      $this->belongsTo('id_oferente', 'BcSedeContrato', 'id_oferente', array(
  				'reusable' => true
  		));
    }

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

    /**
     * Retorna el cargo del empleado
     *
     * @return string
     */
    public function getFechasmaniana($id_hcbempleado, $id_hcbperiodo, $id_sede_contrato)
    {
      $db = $this->getDI()->getDb();
      $id_hcbperiodo_empleado = $db->query("SELECT * FROM bc_hcbperiodo_empleado WHERE id_hcbempleado = $id_hcbempleado AND id_hcbperiodo = $id_hcbperiodo AND id_sede_contrato = $id_sede_contrato");
      $id_hcbperiodo_empleado->setFetchMode(Phalcon\Db::FETCH_OBJ);
      $id_hcbperiodo_empleado = $id_hcbperiodo_empleado->fetch()->id_hcbperiodo_empleado;
      $fechas_empleado = $db->query("SELECT * FROM bc_hcbperiodo_empleado_fecha WHERE id_hcbperiodo_empleado = $id_hcbperiodo_empleado AND jornada = 1");
      $fechas_empleado->setFetchMode(Phalcon\Db::FETCH_OBJ);
      $fechas = array();
      foreach($fechas_empleado->fetchAll() as $row){
        if($row->jornada == 1){
          $fechas[] = $row->fecha;
        }
      }
      $conversiones = $this->getDI()->getConversiones();
    	return implode(",", $conversiones->array_fechas(2, $fechas));
    }
    /**
     * Retorna el cargo del empleado
     *
     * @return string
     */
    public function getFechastarde($id_hcbempleado, $id_hcbperiodo, $id_sede_contrato)
    {
      $db = $this->getDI()->getDb();
      $id_hcbperiodo_empleado = $db->query("SELECT * FROM bc_hcbperiodo_empleado WHERE id_hcbempleado = $id_hcbempleado AND id_hcbperiodo = $id_hcbperiodo AND id_sede_contrato = $id_sede_contrato");
      $id_hcbperiodo_empleado->setFetchMode(Phalcon\Db::FETCH_OBJ);
      $id_hcbperiodo_empleado = $id_hcbperiodo_empleado->fetch()->id_hcbperiodo_empleado;
      $fechas_empleado = $db->query("SELECT * FROM bc_hcbperiodo_empleado_fecha WHERE id_hcbperiodo_empleado = $id_hcbperiodo_empleado AND jornada = 2");
      $fechas_empleado->setFetchMode(Phalcon\Db::FETCH_OBJ);
      $fechas = array();
      foreach($fechas_empleado->fetchAll() as $row){
        if($row->jornada == 2){
          $fechas[] = $row->fecha;
        }
      }
      $conversiones = $this->getDI()->getConversiones();
    	return implode(",", $conversiones->array_fechas(2, $fechas));
    }

}
