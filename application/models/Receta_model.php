<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receta_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database(); 
    }

    function rep_recetas($nomRec = ""){
    	/*$query = $this->db->select("idReceta, nombreReceta, idPro, unidadMedida, cantidadReceta")
    		->from("cr_inv_recetas")
    		->order_by("nombreReceta","asc");*/
    		
        $query = $this->db->select("inv_recetas.idReceta, inv_recetas.nombreReceta, inv_recetas.idPro, inv_productos.descPro, inv_recetas.unidadMedida, inv_recetas.cantidadReceta")
            ->from("inv_recetas")
            ->join("inv_productos","inv_recetas.idPro = inv_productos.idPro")
            ->order_by("nombreReceta","asc");

        if(strlen($nomRec)>0){
            $this->db->where("nombreReceta =",$nomRec);
            //die("Vamos por aqui:".$nomRec);
        }
        
        $result = $this->db->get()->result();

    	/*if(!$query){
    		die(($this->db->error())["message"]);
    	}else{
    		$result = $query->result();
    	}*/

    	return $result;
    }

    function rep_recetas_json(){
        return json_encode($this->rep_recetas());
    }

    function combo_producto(){
        $cSql = "select * from cr_inv_productos order by descPro";
        $result = $this->db->query($cSql)->result();
        $cad = "<select id=\"idPro\" name=\"idPro\" class=\"form-control\" placeholder=\"producto\">";
        foreach($result as $r){
            $cad .= $this->fm->option($r->idPro,$r->descPro);
        }
        $cad .= "</select>";
        return $cad;
    }

    function agregar_receta($ar){
        if(!$this->db->insert("inv_recetas", $ar)){
            $ar_error = $this->db->error();
            //return $ar_error["message"];
            $ar_rpta["rpta"]    = false;
            $ar_rpta["message"] = $ar_error["message"];

        }else{
            $ar_rpta["rpta"]    = true;
            $ar_rpta["message"] = "Grabaccion Correcta!";
        }
        return json_encode($ar_rpta);

    }
}
?>