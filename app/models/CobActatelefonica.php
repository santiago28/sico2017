<?php
use Phalcon\DI\FactoryDefault;
class CobActatelefonica extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actatelefonica;

    /**
     *
     * @var integer
     */
    public $id_verificacion;

    /**
     *
     * @var integer
     */
    public $id_carga;

    /**
     *
     * @var integer
     */
    public $id_sede_contrato;

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
     * @var string
     */
    public $modalidad_nombre;

    /**
     *
     * @var integer
     */
    public $id_sede;

    /**
     *
     * @var string
     */
    public $sede_nombre;

    /**
     *
     * @var string
     */
    public $sede_barrio;

    /**
     *
     * @var string
     */
    public $sede_comuna;

    /**
     *
     * @var string
     */
    public $sede_direccion;

    /**
     *
     * @var string
     */
    public $sede_telefono;

    /**
     *
     * @var integer
     */
    public $id_oferente;

    /**
     *
     * @var string
     */
    public $oferente_nombre;

    /**
     *
     * @var integer
     */
    public $id_usuario;

    /**
     *
     * @var integer
     */
    public $estado;

    //Virtual Foreign Key para poder acceder a la fecha de corte del acta
    public function initialize()
    {
    	$this->belongsTo('id_verificacion', 'CobVerificacion', 'id_verificacion', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_actatelefonica', 'CobActatelefonicaDatos', 'id_actatelefonica', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
    			'reusable' => true
    	));
    	$this->belongsTo('estado', 'IbcReferencia', 'id_referencia', array(
    			'reusable' => true
    	));
    	$this->hasMany('id_actatelefonica', 'CobActatelefonicaPersona', 'id_actatelefonica', array(
    			'foreignKey' => array(
    					'message' => 'El acta no puede ser eliminada porque existen beneficiarios asociados a ésta'
    			)
    	));
    }

    public function cargarBeneficiarios($carga, $modalidades, $id_verificacion)
    {
    	$db = $this->getDI()->getDb();
    	$config = $this->getDI()->getConfig();
    	$timestamp = new DateTime();
    	$tabla_mat = "m" . $timestamp->getTimestamp();
    	$archivo_mat = $config->application->basePath . "public/files/bc_bd/" . $carga->nombreMat;
    	$db->query("CREATE TEMPORARY TABLE $tabla_mat (fechaRetiro DATE, id_sede_contrato BIGINT, id_contrato BIGINT, id_modalidad INT, modalidad_nombre VARCHAR(50), id_sede INT, sede_nombre VARCHAR(80), sede_barrio VARCHAR(80), sede_direccion VARCHAR(80), sede_telefono VARCHAR(80), id_oferente INT, oferente_nombre VARCHAR(100), id_persona INT, numDocumento VARCHAR(100), primerNombre VARCHAR(20), segundoNombre VARCHAR(20), primerApellido VARCHAR(20), segundoApellido VARCHAR(20), telefonoBeneficiario VARCHAR(50), grupo VARCHAR(80)) CHARACTER SET utf8 COLLATE utf8_bin");
    	$db->query("LOAD DATA INFILE '$archivo_mat' IGNORE INTO TABLE $tabla_mat FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (@ID_MATRICULA, @FECHA_INICIO_ATENCION, @FECHA_RETIRO, @MOTIVO_RETIRO, @FECHA_REGISTRO_MATRICULA, @ID_PRESTADOR, @PRESTADOR_SERVICIO, @NUMERO_CONTRATO, @ID_MODALIDAD_ORIGEN, @NOMBRE_MODALIDAD, @ID_SEDE, @NOMBRE_SEDE, @ID_BARRIO_SEDE, @NOMBRE_BARRIO_SEDE, @DIRECCION_SEDE, @TELEFONO_SEDE, @ID_SEDE_CONTRATO, @COORDINADOR_MODALIDAD, @ID_GRUPO, @NOMBRE_GRUPO, @AGENTE_EDUCATIVO, @ID_PERSONA, @TIPO_DOCUMENTO, @NUMERO_DOCUMENTO, @PRIMER_NOMBRE, @SEGUNDO_NOMBRE, @PRIMER_APELLIDO, @SEGUNDO_APELLIDO, @FECHA_NACIMIENTO, @GENERO, @ZONA_BENEFICIARIO, @DIRECCION_BENEFICIARIO, @ID_BARRIO_BENEFICIARIO, @NOMBRE_BARRIO_BENEFICIARIO, @TELEFONO_BENEFICIARIO, @CELULAR_BENEFICIARIO, @PUNTAJE_SISBEN, @NUMERO_FICHA, @VICTIMA_CA, @ESQUEMA_VACUNACION, @TIPO_DISCAPACIDAD, @CAPACIDAD_EXCEPCIONAL, @AFILIACION_SGSSS, @ENTIDAD_SALUD, @ASISTE_CXD, @NOMBRE_ETNIA, @OTROS_BENEFICIOS, @RADICADO, @AUTORIZADO, @FECHA_RADICADO, @CICLO_VITAL_MADRE, @EDAD_GESTACIONAL, @PESO, @ESTATURA, @FECHA_CONTROL, @OBSERVACION, @FECHA_DIGITACION_SEG, @FECHA_MODIFICACION_SEG, @USUARIO_REGISTRO_SEG, @TIPO_BENEFICIARIO, @FECHA_REGISTRO_BENEFICIARIO, @ID_CIERRE_GRUPO, @EN_EDUCATIVO, @FECHA_CIERRE_GRUPO, @CODIGO_HCB, @NOMBRE_HCB, @DOCUMENTO_MCB, @PRIMER_NOMBRE_MCB, @SEGUNDO_NOMBRE_MCB, @PRIMER_APELLIDO_MCB, @SEGUNDO_APELLIDO_MCB, @DIRECCION_HCB, @BARRIO_VEREDA_HCB, @COMUNA_CORREGIMIENTO_HCB, @ZONA_HCB, @CENTRO_ZONAL_HCB, @NOMBRE_ASOCIACION, @CUARTOUPA_JI) SET fechaRetiro = @FECHA_RETIRO, id_sede_contrato = @ID_SEDE_CONTRATO, id_contrato = @NUMERO_CONTRATO, id_modalidad = @ID_MODALIDAD_ORIGEN, modalidad_nombre = @NOMBRE_MODALIDAD, id_sede = @ID_SEDE, sede_nombre = REPLACE(@NOMBRE_SEDE, '\"',\"\"), sede_barrio = @NOMBRE_BARRIO_SEDE, sede_direccion = @DIRECCION_SEDE, sede_telefono = @TELEFONO_SEDE, id_oferente = @ID_PRESTADOR, oferente_nombre = REPLACE(@PRESTADOR_SERVICIO, '\"',\"\"), id_persona = @ID_PERSONA, numDocumento = @NUMERO_DOCUMENTO, primerNombre = TRIM(REPLACE(@PRIMER_NOMBRE, '\"',\"\")), segundoNombre = TRIM(REPLACE(@SEGUNDO_NOMBRE, '\"',\"\")), primerApellido = TRIM(REPLACE(@PRIMER_APELLIDO, '\"',\"\")), segundoApellido = TRIM(REPLACE(@SEGUNDO_APELLIDO, '\"',\"\")), telefonoBeneficiario = @TELEFONO_BENEFICIARIO, grupo = REPLACE(@NOMBRE_GRUPO, '\"',\"\")");
    	$db->query("INSERT IGNORE INTO cob_actatelefonica (id_verificacion, id_carga, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre) SELECT $id_verificacion, $carga->id_carga, id_sede_contrato, id_contrato, id_modalidad, modalidad_nombre, id_sede, sede_nombre, sede_barrio, sede_direccion, sede_telefono, id_oferente, oferente_nombre FROM $tabla_mat");
    	$db->query("INSERT IGNORE INTO cob_actatelefonica_persona (id_actatelefonica, id_verificacion, grupo, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, beneficiarioTelefono) SELECT (SELECT id_actatelefonica FROM cob_actatelefonica WHERE cob_actatelefonica.id_sede_contrato = $tabla_mat.id_sede_contrato AND cob_actatelefonica.id_verificacion = $id_verificacion), $id_verificacion, grupo, id_persona, numDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, telefonoBeneficiario FROM $tabla_mat");
    	$db->query("DROP TABLE $tabla_mat");
    }

    /**
     * Returns a human representation of 'estado'
     *
     * @return string
     */
    public function getEstadoDetail()
    {
    	switch ($this->estado) {
    		case 0:
    			return "Inactiva";
    			break;
    		case 1:
    			return "Activa";
    			break;
    		case 2:
    			return "Cerrada por Interventor";
    			break;
    		case 3:
    			return "Cerrada por Auxiliar";
    			break;
    		case 4:
    			return "Consolidada";
    			break;
    		case 5:
    			return "Verificación cerrada";
    			break;
    	}
    }

    /**
     * Returns a human representation of 'url'
     *
     * @return string
     */
    public function getUrlDetail()
    {
    	return "cob_actatelefonica/ver/$this->id_actatelefonica";
    }

    /**
     * Returns a human representation of 'id_actaconteo'
     *
     * @return string
     */
    public function getIdDetail()
    {
    	return "AVD-03-". date("Y") . sprintf('%05d', $this->id_actatelefonica);
    }

    /**
     * Returns a human representation of 'id_actamuestreo'
     *
     * @return string
     */
    public function getId()
    {
    	return $this->id_actatelefonica;
    }

    /**
     * Contar beneficiarios
     *
     * @return string
     */
    public function countBeneficiarios()
    {
    	return count($this->CobActatelefonicaPersona);
    }

    /**
     * Returns a human representation of 'estado'
     *
     * @return string
     */
    public function getsinonareDetail($value)
    {
    	switch ($value) {
    		case 2:
    			return " class='warning'";
    			break;
    		case 3:
    			return " class='warning'";
    			break;
    		case 4:
    			return " class='warning'";
    			break;
    		default:
    			return "";
    			break;
    	}
    }
}
