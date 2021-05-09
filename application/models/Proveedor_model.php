<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//error_reporting(E_ALL & ~E_NOTICE);
//ini_set('display_errors', '1');


class Proveedor_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function listar_proveedores(){
    	$result = $this->db->select("*")
    		->from("inv_proveedores")
    		//->order_by(array("razon"))
    		->get()->result_array();
    	return $result;
    }
}