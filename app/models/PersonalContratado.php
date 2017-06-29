<?php
use Phalcon\DI\FactoryDefault;
class PersonalContratado extends \Phalcon\Mvc\Model
{
  /**
   *
   * @var integer
   */
  public $id;

  /**
   *
   * @var integer
   */
  public $id_contrato;

  /**
   *
   * @var integer
   */
  public $id_prestador;

  /**
   *
   * @var integer
   */
  public $id_modalidad;

  /**
   *
   * @var integer
   */
  public $cedula;

  /**
   *
   * @var string
   */
  public $primer_nombre;

  /**
   *
   * @var string
   */
  public $segundo_nombre;

  /**
   *
   * @var string
   */
  public $primer_apellido;

  /**
   *
   * @var string
   */
  public $segundo_apellido;

  /**
   *
   * @var string
   */
  public $formacion_academica;

  /**
   *
   * @var integer
   */
  public $id_cargo;

  /**
   *
   * @var integer
   */
  public $id_sede;

  /**
   *
   * @var string
   */
  public $fecha_ingreso;



  public function initialize()
  {
    $this->setConnectionService('db_delfi');
    $this->belongsTo('id_cargo', 'Cargo', 'id_cargo', array(
			'reusable' => true
		));
  }

  public function cargarBeneficiarios($id_verificacion, $id_mes)
  {
    //Carga de beneficiarios
    $id_contrato_arr = array();
    $id_sede_arr = array();
    $numDocumento_arr = array();
    $primerNombre_arr = array();
    $segundoNombre_arr = array();
    $primerApellido_arr = array();
    $segundoApellido_arr = array();
    $formacionAcademica_arr = array();
    $cargo_arr = array();
    $tipoContrato_arr = array();
    $baseSalario_arr = array();
    $porcentajeDedicacion_arr = array();
    $fechaIngreso_arr = array();
    foreach(PersonalContratado::find(["id_modalidad = 7"]) as $row){
      $fecha_retiro      = $row->fecha_retiro;
      $idSedePersonal    = (int)$row->id_sede;

      if( (is_null($fecha_retiro) || $fecha_retiro == '0000-00-00') && ( $idSedePersonal < 10000 || $idSedePersonal > 90000 ) )
      {
        $id_contrato_arr[] = $row->id_contrato;
        $id_sede_arr[] = $row->id_sede;
        $numDocumento_arr[] = $row->cedula;
        $primerNombre_arr[] = $row->primer_nombre;
        $segundoNombre_arr[] = $row->segundo_nombre;
        $primerApellido_arr[] = $row->primer_apellido;
        $segundoApellido_arr[] = $row->segundo_apellido;
        $formacionAcademica_arr[] = $row->formacion_academica;
        $cargo_arr[] = $row->Cargo->nombre_cargo;
        $tipoContrato_arr[] = $row->Cargo->codigo_tipo_contrato;
        //$baseSalario_arr[] = $row->Cargo->base_salario_honorarios;
        $baseSalario_arr[] = $row->base_salario_honorarios;
        $porcentajeDedicacion_arr[] = $row->porcentaje_dedicacion;
        $fechaIngreso_arr[] = $row->fecha_ingreso;
      }
    }
    $elementos = array(
        'id_contrato' => $id_contrato_arr,
        'id_sede' => $id_sede_arr,
        'id_verificacion' => $id_verificacion,
        'id_mes' => $id_mes,
        'numDocumento' => $numDocumento_arr,
        'primerNombre' => $primerNombre_arr,
        'segundoNombre' => $segundoNombre_arr,
        'primerApellido' => $primerApellido_arr,
        'segundoApellido' => $segundoApellido_arr,
        'formacionAcademica' => $formacionAcademica_arr,
        'cargo' => $cargo_arr,
        'tipoContrato' => $tipoContrato_arr,
        'baseSalario' => $baseSalario_arr,
        'porcentajeDedicacion' => $porcentajeDedicacion_arr,
        'fechaIngreso' => $fechaIngreso_arr
    );
    $db = $this->getDI()->getDb();
    $sql = $this->conversiones->multipleinsert("cob_actath_persona", $elementos);
    $query = $db->query($sql);
    if (!$query) {
      return FALSE;
    }
    //Carga de actas
    $elementos = array(
        'id_contrato' => $id_contrato_arr,
        'id_sede' => $id_sede_arr,
        'id_verificacion' => $id_verificacion,
        'id_mes' => $id_mes
    );
    $sql = $this->conversiones->multipleinsert("cob_actath", $elementos);
    $query = $db->query($sql);
    if (!$query) {
      return FALSE;
    }
    //$db->query("UPDATE cob_actath, cob_actaconteo SET cob_actath.id_sede_contrato = cob_actaconteo.id_sede_contrato, cob_actath.id_modalidad = cob_actaconteo.id_modalidad, cob_actath.modalidad_nombre = cob_actaconteo.modalidad_nombre, cob_actath.sede_nombre = cob_actaconteo.sede_nombre, cob_actath.sede_barrio = cob_actaconteo.sede_barrio, cob_actath.sede_direccion = cob_actaconteo.sede_direccion, cob_actath.sede_telefono = cob_actaconteo.sede_telefono, cob_actath.id_oferente = cob_actaconteo.id_oferente, cob_actath.oferente_nombre = cob_actaconteo.oferente_nombre WHERE cob_actath.id_contrato = cob_actaconteo.id_contrato AND cob_actath.id_sede = cob_actaconteo.id_sede AND cob_actath.id_verificacion = $id_verificacion AND cob_actaconteo.id_periodo = (SELECT MAX(id_periodo) FROM cob_periodo WHERE tipo = 1)");
    $db->query("UPDATE cob_actath, cob_actaconteo SET cob_actath.id_sede_contrato = cob_actaconteo.id_sede_contrato, cob_actath.id_modalidad = cob_actaconteo.id_modalidad, cob_actath.modalidad_nombre = cob_actaconteo.modalidad_nombre, cob_actath.sede_nombre = cob_actaconteo.sede_nombre, cob_actath.sede_barrio = cob_actaconteo.sede_barrio, cob_actath.sede_direccion = cob_actaconteo.sede_direccion, cob_actath.sede_telefono = cob_actaconteo.sede_telefono, cob_actath.id_oferente = cob_actaconteo.id_oferente, cob_actath.oferente_nombre = cob_actaconteo.oferente_nombre WHERE cob_actath.id_contrato = cob_actaconteo.id_contrato AND cob_actath.id_sede = cob_actaconteo.id_sede AND cob_actath.id_verificacion = $id_verificacion AND cob_actaconteo.id_periodo = (SELECT MIN(id_periodo) FROM cob_periodo WHERE tipo = 1 AND MONTH(fecha) = MONTH(NOW()))");
    $db->query("UPDATE cob_actath_persona, cob_actath SET cob_actath_persona.id_actath = cob_actath.id_actath WHERE cob_actath_persona.id_contrato = cob_actath.id_contrato AND cob_actath_persona.id_sede = cob_actath.id_sede AND cob_actath_persona.id_verificacion = $id_verificacion AND cob_actath.id_verificacion = $id_verificacion");
    return TRUE;
  }
}
