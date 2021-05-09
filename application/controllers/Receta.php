<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(E_ALL & ~E_NOTICE & ~E_PARSE & ~E_WARNING & ~E_ERROR);
//ini_set('display_errors', '1');

class Receta extends MY_Controller{

    function __construct(){
        //die("Dua Lipa");
        parent::__construct();
        $this->load->model('receta_model');
    }

    function agregar(){
    	//die("Flavio");
    	if(isset($_POST) && count($_POST) > 0){
    		echo "Flavio Moreno";
    	}else{
            $this->data['content']         	= "receta/agregar";
	        $this->_render_page('inventario/inv_templo', $this->data);
		}
    }

}
?>