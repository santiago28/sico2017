<?php

class CobActaconteoEmpleadoitinerante extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actaconteo_empleadoitinerante;

    /**
     *
     * @var integer
     */
    public $id_actaconteo;

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
    public $nombre;

    /**
     *
     * @var string
     */
    public $numDocumento;

    /**
     *
     * @var integer
     */
    public $cargo;

    /**
     *
     * @var string
     */
    public $temaEncuentro;

    /**
     *
     * @var string
     */
    public $necesidades;

    /**
     *
     * @var integer
     */
    public $participantes;

    /**
     * Retorna cargo empleado en texto
     *
     * @return string
     */
    public function getCargoEmpleado()
    {
    	if ($this->cargo == 1) {
    		return "Auxiliar Educativo";
    	} else if ($this->cargo == 2){
    		return "Docente";
    	}
    }

    /**
     * Retorna el cargo del empleado
     *
     * @return string
     */
    public function getCategoria()
    {
    	switch ($this->cargo) {
    		case 0:
    			return "No Asignado";
    			break;
    		case 1:
    			return "Pedagogo";
    			break;
    		case 2:
    			return "Psicosocial";
    			break;
    		case 3:
    			return "Educador Físico";
    			break;
    		case 4:
    			return "Nutricionista";
    			break;
    	}
    }

}
