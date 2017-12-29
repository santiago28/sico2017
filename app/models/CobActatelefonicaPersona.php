<?php

class CobActatelefonicaPersona extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_actatelefonica_persona;

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
     * @var string
     */
    public $grupo;

    /**
     *
     * @var integer
     */
    public $id_persona;

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

    /**
     *
     * @var string
     */
    public $beneficiarioTelefono;

    /**
     *
     * @var string
     */
    public $beneficiarioCelular;

    /**
     *
     * @var string
     */
    public $personaContesta;

    /**
     *
     * @var string
     */
    public $parentesco;

    /**
     *
     * @var string
     */
    public $observacion;

    //Virtual Foreign Key para poder acceder a la fecha de corte del acta
    public function initialize()
    {
    	$this->belongsTo('id_actatelefonica', 'CobActatelefonica', 'id_actatelefonica', array(
    			'reusable' => true
    	));
    }

    public function getTelefonoBeneficiario()
    {
      $db = $this->getDI()->getDb();
  		$config = $this->getDI()->getConfig();
      $info_beneficiario = $db->query("SELECT cob_actaconteo_persona_excusa.telefono FROM cob_actaconteo_persona_excusa, cob_actaconteo_persona WHERE cob_actaconteo_persona.id_actaconteo_persona =  cob_actaconteo_persona_excusa.id_actaconteo_persona and cob_actaconteo_persona.id_persona = '$this->id_persona'");
      $info_beneficiario->setFetchMode(Phalcon\Db::FETCH_OBJ);
      $telefono = '';
      foreach ($info_beneficiario->fetchAll() as $key => $row) {
        $telefono = $row->telefono;
      }
      return $telefono;
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
    			return " class='danger'";
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
