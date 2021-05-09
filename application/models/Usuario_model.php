<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model{

    public function __construct(){
        
        parent::__construct();
        $this->load->database();
        
    }

    public function verifica_usuario($nombreUsu,$clave,&$mi_almacen,&$mi_desc_almacen){
        //die("Todo bien...");
        // Obteniendo el id:
        /*$query = $this->db->select("inv_usu_modulos.idUsuario")
            ->from("inv_usu_modulos")
            ->join("inv_usuarios","inv_usu_modulos.idUsuario = inv_usuarios.idUsuario")
            ->where("inv_usuarios.nomUsuario=", $nombreUsu)
            ->where("inv_usuarios.activo=","1")
            ->get_compiled_select();

        die($query);*/

        $query = $this->db->select("inv_usu_modulos.idUsuario, inv_usuarios.idAlm")
            ->from("inv_usu_modulos")
            ->join("inv_usuarios","inv_usu_modulos.idUsuario = inv_usuarios.idUsuario")
            ->where("inv_usuarios.nomUsuario=", $nombreUsu)
            ->where("inv_usuarios.clave=", $clave)
            ->where("inv_usuarios.activo=","1")
            ->get_compiled_select();

        //echo($query);

        $result = $this->db->select("inv_usu_modulos.idUsuario, inv_usuarios.idAlm")
            ->from("inv_usu_modulos")
            ->join("inv_usuarios","inv_usu_modulos.idUsuario = inv_usuarios.idUsuario")
            ->where("inv_usuarios.nomUsuario=", $nombreUsu)
            ->where("inv_usuarios.clave=", $clave)
            ->where("inv_usuarios.activo=","1")
            ->get()->result();
            //->get_compiled_select();



        $idUsuario = -1;
        foreach($result as $r){
            $idUsuario = $r->idUsuario;
            $mi_almacen = $r->idAlm;
        }

        $result = null;
        $result = $this->db->select("nombreAlm")
            ->from("inv_almacenes")
            ->where("idAlm",$mi_almacen)
            ->get()->result_array();
        $mi_desc_almacen = "";
        foreach($result as $r){
            $mi_desc_almacen = $r["nombreAlm"];
        }
        /*
        $query = $this->db->select("inv_usu_modulos.idUsuario")->from("inv_usu_modulos")
            ->join("inv_usuarios","inv_usu_modulos.idUsuario = inv_usuarios.idUsuario")
            ->where("inv_usuarios.nomUsuario=", $_POST["usuario"])->get();
        
        if($query){
            $nItem=0;
            foreach($query->result() as $r){
                $nItem++;
            }
        }*/
        return $idUsuario;
    }

    public function verifica_acceso($id_user, $modulo){
        /*select a.* from cr_inv_usu_modulos a
        inner join cr_inv_modulos b on a.idMod = b.idMod
        where a.idUsuario = 1 and b.descMod = 'RECETAS';*/

        $result = $this->db->select("inv_usu_modulos.idUsuario")
            ->from("inv_usu_modulos")
            ->join("inv_modulos","inv_usu_modulos.idMod = inv_modulos.idMod")
            ->where("inv_usu_modulos.idUsuario =",$id_user)
            ->where("inv_modulos.descMod =",$modulo)
            ->get()->result();

        foreach($result as $r){
            return true;
        }
        return false;
    }
}
?>