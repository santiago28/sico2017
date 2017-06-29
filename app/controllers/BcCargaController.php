<?php

use Phalcon\Mvc\Model\Criteria;

class BcCargaController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle("Carga");
        $auth = $this->session->get('auth');
        parent::initialize();
    }

    /**
     * index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
        $bc_carga = BcCarga::find();
        if (count($bc_carga) == 0) {
            $this->flash->notice("No se ha agregado ninguna carga hasta el momento");
            $bc_carga = null;
        }
        $this->view->bc_carga = $bc_carga;
    }

    /**
     * Formulario para la reación deuna carga
     */
    public function nuevoAction()
    {
    	$this->view->meses = $this->elements->getSelect("meses");
    }

    /**
     * Formulario para la reación deuna carga
     */
    public function nuevoindividualAction()
    {
    	$this->view->meses = $this->elements->getSelect("meses");
    }

    /**
     * Para crear una carga, aquí es a donde se dirige el formulario de nuevoAction
     */
    public function crearAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_carga/");
    	}

    	$bc_carga = new BcCarga();
    	$bc_carga->mes = $this->request->getPost("mes");
    	$bc_carga->fecha = date('Y-m-d H:i:s');

    	if($this->request->hasFiles() == true){
    		$uploads = $this->request->getUploadedFiles();
    		$isUploaded = false;
    		$i = 1;
    		foreach($uploads as $upload){
    			$path = "files/bc_bd/".$upload->getname();
    			if($i == 1){
    				$bc_carga->nombreMat = $upload->getname();
    			} else {
    				$bc_carga->nombreSedes = $upload->getname();
    			}
    			($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
    			$i++;
    		}
    		if($isUploaded){
    			if (!$bc_carga->save()) {
    				foreach ($bc_carga->getMessages() as $message) {
    					$this->flash->error($message);
    				}

    				return $this->response->redirect("bc_carga/nuevo");
    			}

    			$this->flash->success("La carga fue realizada exitosamente.");

    			return $this->response->redirect("bc_carga/");
    		} else {
    			$this->flash->error("Ocurrió un error al cargar los archivos");
    			return $this->response->redirect("bc_carga/nuevo");
    		}
    	}else{
    	    	$this->flash->error("Debes de seleccionar los archivos");
    			return $this->response->redirect("bc_carga/nuevo");
    	}
    }

    /**
     * Para crear una carga, aquí es a donde se dirige el formulario de nuevoAction
     */
    public function crearindividualAction()
    {
    	if (!$this->request->isPost()) {
    		return $this->response->redirect("bc_carga/");
    	}

    	$bc_carga = new BcCarga();
    	$bc_carga->mes = $this->request->getPost("mes");
    	$bc_carga->fecha = date('Y-m-d H:i:s');

    	if($this->request->hasFiles() == true){
    		$uploads = $this->request->getUploadedFiles();
    		$isUploaded = false;
    		foreach($uploads as $upload){
    			$path = "files/bc_bd/".$upload->getname();
    			$bc_carga->nombreMat = $upload->getname();
    			($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
    		}
    		if($isUploaded){
    			if (!$bc_carga->save()) {
    				foreach ($bc_carga->getMessages() as $message) {
    					$this->flash->error($message);
    				}
    				return $this->response->redirect("bc_carga/nuevoindividual");
    			}

    			$this->flash->success("La carga fue realizada exitosamente.");

    			return $this->response->redirect("bc_carga/");
    		} else {
    			$this->flash->error("Ocurrió un error al cargar los archivos");
    			return $this->response->redirect("bc_carga/nuevo");
    		}
    	}else{
    	    	$this->flash->error("Debes de seleccionar el archivo");
    			return $this->response->redirect("bc_carga/nuevoindividual");
    	}
    }

    /**
     * Elimina una carga
     *
     *
     * @param string $id_carga
     */
    public function eliminarAction($id_carga)
    {

        $bc_carga = BcCarga::findFirstByid_carga($id_carga);
        if (!$bc_carga) {
            $this->flash->error("Esta carga no fue encontrada");
            return $this->response->redirect("bc_carga/");
        }

        if (!$bc_carga->delete()) {

            foreach ($bc_carga->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect("bc_carga/");
        }

        $this->flash->success("La carga fue eliminada exitosamente");
        return $this->response->redirect("bc_carga/");
    }

}
