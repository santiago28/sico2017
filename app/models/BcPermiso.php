<?php

class BcPermiso extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_permiso;

    /**
     *
     * @var integer
     */
    public $id_oferente;

    /**
     *
     * @var string
     */
    public $categoria;

    /**
     *
     * @var integer
     */
    public $id_sede_contrato;

    /**
     *
     * @var integer
     */
    public $id_sede;


    /**
     *
     * @var string
     */
    public $fecha;

    /**
     *
     * @var string
     */
    public $horaInicio;

    /**
     *
     * @var string
     */
    public $horaFin;

    /**
     *
     * @var string
     */
    public $titulo;

    /**
     *
     * @var string
     */
    public $observaciones;

    /**
     *
     * @var string
     */
    public $fechahora;

    /**
     *
     * @var string
     */
    public $fechaAprobacion;

    /**
     *
     * @var integer
     */
    public $estado;

    //Virtual Foreign Key para poder acceder a la fecha de corte del acta
    public function initialize()
    {
    	$this->belongsTo('id_permiso', 'BcPermisoGeneral', 'id_permiso', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_permiso', 'BcPermisoGeneralTransporte', 'id_permiso', array(
    			'reusable' => true
    	));
    	$this->belongsTo('id_sede_contrato', 'BcSedeContrato', 'id_sede_contrato', array(
    			'reusable' => true
    	));
    	$this->hasMany("id_permiso", "BcPermisoObservacion", "id_permiso");
      $this->hasMany("id_permiso", "BcPermisoParticipante", "id_permiso");
    }

    /**
     * Convierte en texto la categoría de los permisos
     *
     * @return string
     */
    public function getCategoria()
    {
    	switch ($this->categoria) {
    		case 1:
    			return "Incidente";
    			break;
    		case 2:
    			return "Salida Pedagógica";
    			break;
    		case 3:
    			return "Movilización Social";
    			break;
    		case 4:
    			return "Salida a Ludoteka";
    			break;
    		case 5:
    			return "Jornada de Planeación";
    			break;
        case 6:
    			return "Jornada de Formación";
    			break;
    	}
    }

    /**
     * Convierte en texto la categoría de los permisos
     *
     * @return string
     */
    public function getEstado()
    {
    	switch ($this->estado) {
    		case 0:
    			return "Pendiente de revisión y aprobación";
    			break;
    		case 1:
    			return "Revisado por Interventoría";
    			break;
    		case 2:
    			return "Aprobado por Buen Comienzo";
    			break;
    		case 3:
    			return "Anulado por Interventoría";
    			break;
    		case 4:
    			return "Anulado por Buen Comienzo";
    			break;
    		case 5:
    			return "Anulado por Prestador";
    			break;
    	}
    }

    /**
     * Coloca estilo visual a los estados
     *
     * @return string
     */
    public function getEstadoStyle()
    {
    	switch ($this->estado) {
    		case 0:
    			return "default";
    			break;
    		case 1:
    			return "info";
    			break;
    		case 2:
    			return "success";
    			break;
    		case 3:
    			return "danger";
    			break;
    		case 4:
    			return "danger";
    			break;
    		case 5:
    			return "danger";
    			break;
    	}
    }

    /**
     * Contar participantes
     *
     * @return string
     */
    public function countParticipantes()
    {
    	return BcPermisoParticipante::count("id_permiso = $this->id_permiso");
    }
}
