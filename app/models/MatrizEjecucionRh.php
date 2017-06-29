<?php
use Phalcon\DI\FactoryDefault;
class MatrizEjecucionRh extends \Phalcon\Mvc\Model
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
  public $id_modalidad;

  /**
   *
   * @var integer
   */
  public $id_ano;

  /**
   *
   * @var integer
   */
  public $id_mes;

  /**
   *
   * @var integer
   */
  public $id_categoria;

  /**
   *
   * @var integer
   */
  public $id_concepto;

  /**
   *
   * @var integer
   */
  public $cedula;

  /**
   *
   * @var integer
   */
  public $id_cargo;

  public function initialize()
  {
    $this->setConnectionService('db_delfi');
    $this->belongsTo(array('cedula', 'id_contrato'), 'PersonalContratado', array('cedula', 'id_contrato'));
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
    $fechaActual = date('Y-m-d');
    foreach(MatrizEjecucionRh::find(["id_mes = $id_mes"]) as $row){
      $fecha_retiro      = $row->PersonalContratado->fecha_retiro;
      $idSedePersonal    = (int)$row->PersonalContratado->id_sede;
      $id_modalidad      = $row->PersonalContratado->id_modalidad;
      //Daniel Gallo 24/03/2017 5 = entorno familiar
      if( (is_null($fecha_retiro) || $fecha_retiro == '0000-00-00') && ( $idSedePersonal < 10000 || $idSedePersonal > 90000 ) && ( $id_modalidad != 5 ) && ( $id_modalidad != 0 ) )
      {
        $id_contrato_arr[] = $row->PersonalContratado->id_contrato;
        $id_sede_arr[] = $row->PersonalContratado->id_sede;
        $numDocumento_arr[] = $row->PersonalContratado->cedula;
        $primerNombre_arr[] = $row->PersonalContratado->primer_nombre;
        $segundoNombre_arr[] = $row->PersonalContratado->segundo_nombre;
        $primerApellido_arr[] = $row->PersonalContratado->primer_apellido;
        $segundoApellido_arr[] = $row->PersonalContratado->segundo_apellido;
        $formacionAcademica_arr[] = $row->PersonalContratado->formacion_academica;
        $cargo_arr[] = $row->PersonalContratado->Cargo->nombre_cargo;
        $tipoContrato_arr[] = $row->PersonalContratado->Cargo->codigo_tipo_contrato;
        //$baseSalario_arr[] = $row->PersonalContratado->Cargo->base_salario_honorarios;	base_salario_honorarios
        $baseSalario_arr[] = $row->PersonalContratado->base_salario_honorarios;
        $porcentajeDedicacion_arr[] = $row->PersonalContratado->porcentaje_dedicacion;
        $fechaIngreso_arr[] = $row->PersonalContratado->fecha_ingreso;
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
    //Daniel Gallo 27/03/2017
    $db->query("UPDATE cob_actath, cob_actaconteo SET cob_actath.id_sede_contrato = cob_actaconteo.id_sede_contrato, cob_actath.id_modalidad = cob_actaconteo.id_modalidad, cob_actath.modalidad_nombre = cob_actaconteo.modalidad_nombre, cob_actath.sede_nombre = cob_actaconteo.sede_nombre, cob_actath.sede_barrio = cob_actaconteo.sede_barrio, cob_actath.sede_direccion = cob_actaconteo.sede_direccion, cob_actath.sede_telefono = cob_actaconteo.sede_telefono, cob_actath.id_oferente = cob_actaconteo.id_oferente, cob_actath.oferente_nombre = cob_actaconteo.oferente_nombre WHERE cob_actath.id_contrato = cob_actaconteo.id_contrato AND cob_actath.id_sede = cob_actaconteo.id_sede AND cob_actath.id_verificacion = $id_verificacion AND cob_actaconteo.id_periodo = (SELECT MIN(id_periodo) FROM cob_periodo WHERE tipo = 1 AND MONTH(fecha) = MONTH(NOW()))");
    $db->query("UPDATE cob_actath_persona, cob_actath SET cob_actath_persona.id_actath = cob_actath.id_actath WHERE cob_actath_persona.id_contrato = cob_actath.id_contrato AND cob_actath_persona.id_sede = cob_actath.id_sede AND cob_actath_persona.id_verificacion = $id_verificacion AND cob_actath.id_verificacion = $id_verificacion");
    return TRUE;
  }
}
