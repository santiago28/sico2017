<?php

class BcPermisoObservacion extends \Phalcon\Mvc\Model
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
    public $id_usuario;

    /**
     *
     * @var string
     */
    public $fecha_hora;


    /**
     *
     * @var integer
     */
    public $estado;

    /**
     *
     * @var string
     */
    public $observacion;
    
    public function initialize()
    {
    	$this->belongsTo('id_usuario', 'IbcUsuario', 'id_usuario', array(
    			'reusable' => true
    	));
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
    			return "Pendiente de revisión";
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
}
