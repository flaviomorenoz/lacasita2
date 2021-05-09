<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database(); 
    }

    function agregar(){

    	$hasError = false;
    	$ar["error"] = false; $ar["message"] = "";

    	if(!(isset($_POST["idAlm"]) && strlen($_POST["idAlm"])>0)){
    		$hasError = true;
    		$ar["message"] .= "Hubo un problema en Almacen (1), ";
    	}

        if(!(isset($_POST["descPro"]) && strlen($_POST["descPro"])>0)){
            $hasError = true;
            $ar["message"] .= "Hubo un problema en Almacen (2), ";
        }

        $result = $this->db->select("inv_productos.descPro")->from("inv_productos")
            ->where("inv_productos.descPro",$_POST["descPro"])
            ->get()->result_array();
            //->get_compiled_select();

        //echo $result;

        $i=0;
        foreach($result as $r){
            $i++;
        }

        if($i > 0){
            $hasError = true;
            $ar["message"] .= "Ya existe un producto con esa descripcion";
        }

    	if(!$hasError){
	    	$data["idAlm"] 			= $_POST["idAlm"];
	    	$data["descPro"] 		= $_POST["descPro"];
	    	$data["stockInicial"] 	= $_POST["stockInicial"];
	    	$data["costo"] 			= $_POST["costo"];
            $data["unidad"]         = $_POST["unidad"];

            $this->db->insert("cr_inv_productos",$data);
            
            $ar["message"] = "Grabo correctamente.";	    	
            return json_encode($ar);
	    }else{
    		$ar["error"] = $hasError;
    		return json_encode($ar);
    	}
    }

    function modificar(){

        $hasError = false;
        $ar["error"] = false; $ar["message"] = "";

        if(!(isset($_POST["idAlm"]) && strlen($_POST["idAlm"])>0)){
            $hasError = true;
            $ar["message"] .= "Hubo un problema en Almacen (1), ";
        }

        if(!(isset($_POST["descPro"]) && strlen($_POST["descPro"])>0)){
            $hasError = true;
            $ar["message"] .= "Hubo un problema en Almacen (2), ";
        }
/*
        $result = $this->db->select("idPro, descPro")->from("inv_productos")
            ->where("inv_productos.descPro",$_POST["descPro"])
            ->get()->result_array();
            //->get_compiled_select();

        //echo $result;

        $i=0;
        foreach($result as $r){
            $i++;
            $idProX = $r["idPro"];
        }

        if($i > 0){
            //$hasError = true;
            //$ar["message"] .= "Ya existe un producto con esa descripcion";

        }
*/
        if(!$hasError){
            //$data["idAlm"]          = $_POST["idAlm"];
            $data["descPro"]        = $_POST["descPro"];
            $data["stockInicial"]   = $_POST["stockInicial"];
            $data["costo"]          = $_POST["costo"];
            $data["unidad"]         = $_POST["unidad"];

            $this->db->where("idPro",$_POST["idPro"]);
            $this->db->update("cr_inv_productos",$data);
            
            $ar["message"] = "Se actualiza correctamente.";            
            return json_encode($ar);
        }else{
            $ar["error"] = $hasError;
            return json_encode($ar);
        }
    }

    function combo_unidad(){

        $cad = "<select id=\"unidad\" name=\"unidad\" class=\"form-control\">";
        //$ar[] = "KILO";
        $ar[] = "UNIDAD";
        $ar[] = "LITRO";
        $ar[] = "GRAMOS";
        $nLim = count($ar);

        for($i=0; $i<$nLim; $i++){
            $cad .= $this->fm->option($ar[$i],$ar[$i]);
        }
        $cad .= "</select>";

        return $cad;
    }

    function combo_almacen(){

        $cad = "<select id=\"idAlm\" name=\"idAlm\">";
        $cSql = "select * from cr_inv_almacenes order by idAlm";
        //error_reporting(-1); ini_set('display_errors', 1);
        $result = $this->db->query($cSql)->result();

        foreach($result as $r){
            $cad .= $this->fm->option($r->idAlm, $r->nombreAlm);
        }
        $cad .= "</select>";

        return $cad;
    }

    function rep_productos(){
        $cSql = "select idPro, descPro, stockInicial, costo, unidad from cr_inv_productos order by idPro";
        $result = $this->db->query($cSql)->result();
        return $result;
    }

    function eliminar_producto($idProx){
        
        $result = $this->db->select("inv_movimientos.idPro")
            ->from("inv_movimientos")
            ->where("inv_movimientos.idPro",$idProx)
            //->get_compiled_select();
            ->get()->result_array();

        $can = count($result);

        if($can == 0){
            $this->db->where('idPro', $idProx);
            $this->db->delete('inv_productos');
            return true;
        }else{
            return false;
        }

    }
}
?>