<?php
use Phalcon\DI\FactoryDefault;
class BcHcbperiodo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_hcbperiodo;

    /**
     *
     * @var integer
     */
    public $id_oferente;

    public function initialize()
    {
    	$this->belongsTo('id_hcbperiodo', 'BcHcbperiodoEmpleado', 'id_hcbperiodo', array(
    			'reusable' => true
    	));
    }

    /**
     * Returns a human representation of 'fecha'
     *
     * @return string
     */
    public function getMes()
    {
    	$conversiones = $this->getDI()->getConversiones();
    	return $conversiones->fecha(11, $this->id_hcbperiodo);
    }
}
