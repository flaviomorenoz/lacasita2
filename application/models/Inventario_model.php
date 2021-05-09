<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//error_reporting(E_ALL & ~E_NOTICE);
//ini_set('display_errors', '1');

class inventario_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    function carga_inventario($idAlm){
    	$cSql = "select a.idPro, a.descPro, a.unidad, b.cantidad as total_Stock
			from cr_inv_productos a
			left join (
					select idPro, sum(if(accionMov = 'E',cantidadMov,(-1)*cantidadMov)) cantidad 
					from cr_inv_movimientos
					where idAlm = $idAlm
					group by idPro
			) b on a.idPro = b.idPro";
		
		$result = $this->db->query($cSql)->result_array();
		return $result;
	}

    
    function carga_inventario_entradas($almacen){
    	$cSql = "select 
			a.idMov, concat(a.fechaMov, ' ',a.horaMov) fechas, a.idPro, b.descPro, a.cantidadMov, concat(a.ruc,'-',a.razon) cruc, a.accionMov, a.tipoDoc, a.nroDoc, a.fec_emi_doc, a.costo
			from cr_inv_movimientos a
			left join cr_inv_productos b on a.idPro = b.idPro
			where a.idAlm = $almacen
			order by a.idMov desc limit 300";

		$result = $this->db->query($cSql)->result_array();
		return $result;
	}

	function combo_almacen($valor=""){
		$cSql = "select * from cr_inv_almacenes order by idAlm";
		$result = $this->db->query($cSql)->result();
		$cad = "<select id=\"almacen\" name=\"almacen\" class=\"form-control\">";
		//$cad = "";
		$n=0;
		foreach($result as $r){
			$n++;
			if($n == 1){
				$cad .= $this->fm->option("0","",$valor);
			}
			$cad .= $this->fm->option($r->idAlm,$r->nombreAlm,$valor);
		}
		$cad .= "</select>";
		return $cad;
	}

	function combo_accion(){
		$cad = "<select id=\"accion\" name=\"accion\" class=\"form-control\">";
		$cad .= $this->fm->option("E","Entrada");
		$cad .= $this->fm->option("S","Salida");
		$cad .= "</select>";
		return $cad;
	}

	function combo_producto(){
		$cSql = "select * from cr_inv_productos order by descPro";
		$result = $this->db->query($cSql)->result();
		$cad = "<select id=\"productos\" name=\"productos\" class=\"form-control\">";
		foreach($result as $r){
			$cad .= $this->fm->option($r->idPro,$r->descPro . "&nbsp;&nbsp;&nbsp;(" . strtolower($r->unidad) . ")");
		}
		$cad .= "</select>";
		return $cad;
	}

	function grabar($data){
		//error_reporting(E_ALL & ~E_NOTICE & ~E_PARSE & ~E_WARNING);
		//ini_set('display_errors', '1');

		if($data["fec_emi_doc"] == ''){
			$data["fec_emi_doc"] = null;
		}

		if($data["fec_venc_doc"] == ''){
			$data["fec_venc_doc"] = null;
		}

		if ($data["accionMov"] == "S"){
			if (!$this->verifica_en_receta($data["idPro"])){
				
				$this->db->insert("cr_inv_movimientos",$data);
			
			}else{  // PRODUCTO COMPUESTO

	        	//echo "Olav<br>";
	        	$productoCompuesto 	= $data["idPro"];
	        	$cantidadMov 		= $data["cantidadMov"];
	        	$result = $this->db->query("select * from cr_inv_productos where idPro = " . $productoCompuesto)->result();
	        	$cBusq = "";
	        	foreach($result as $r){ $cBusq = $r->descPro; }
	        	

	        	$result = $this->db->select('idPro, unidadMedida, cantidadReceta')
	        		->from('inv_recetas')
	        		->where('nombreReceta',$cBusq)
	        		->get()->result();

	        	foreach($result as $r){
	        		//echo "Hola<br>";
	        		$data["idPro"] 			= $r->idPro;
	        		$data["cantidadMov"] 	= 1 * $r->cantidadReceta * $cantidadMov;
	        		$data["compuesto"] 		= $productoCompuesto;
	        		$data["costo"] 			= 0;

	        		//unidadMedidaProducto
	        		//unidadMedidaReceta($data["idPro"])

	        		$this->db->insert("cr_inv_movimientos",$data);
	        	}
	        }
	    }else{
	    	
	    	// Antes que todo hay que borrar en inv_movimientos
	    	$this->db->where("token",$data["token"]);
	    	$this->db->delete("inv_movimientos");

			$result2 = $this->db->select("idPro, cantidad, subtotal")
				->from("inv_detalles")
				->where("token",$data["token"])
				->get()->result_array();

			$query = $this->db->select("idPro, cantidad, subtotal")
				->from("inv_detalles")
				->where("token",$data["token"])
				->get_compiled_select();

			foreach($result2 as $r){
				$data["idPro"] 			= $r["idPro"];
				$data["cantidadMov"] 	= $r["cantidad"];
				$data["costo"] 			= $r["subtotal"];
				$this->db->insert("cr_inv_movimientos",$data);
			}

	    }
		return $this->fm->message("Documento registrado correctamente",0);
	}

    function verifica_en_receta($producto){

        $result = $this->db->query("select * from cr_inv_productos where idPro = $producto")->result();
        $cBusq = "";
        foreach($result as $r){$cBusq = $r->descPro;}
        
        $cQuery = "select * from cr_inv_recetas where nombreReceta = '$cBusq'";
        if(!$this->db->query($cQuery)){
        	die(($this->db->error)["message"]);
        }else{
        	$num = $this->db->count_all_results();
        }
        
        if($num > 0){
            return true;
        }else{
            return false;
        }
    }

	function combo_TipoDoc($defecto=""){
		//$cad = $defecto;
		
		$cad = "<select id=\"tipodoc\" name=\"tipodoc\" class=\"form-control\">";
		$cad .= $this->fm->option('F','Factura',$defecto);
		$cad .= $this->fm->option('B','Boleta',$defecto);
		$cad .= $this->fm->option('G','Guia Interna',$defecto);
		$cad .= "</select>";
		
		return $cad;
	}

    function razon(){
        $cSql = "select * from inv_proveedores order by idProv desc limit 50";
        $result = $this->db->query($cSql)->result();
        $cad = "";
        foreach($result as $r){
            $cad .= "'" . $r->razon . "',";
            //$cad .= "'" . 'paraiso' . "',";
        }
        return substr($cad,0,strlen($cad)-1);
    }

    function obtener_razon($desc = ""){
        $cSql = "select ruc from inv_proveedores where razon = '$desc'";
        $result = $this->db->query($cSql)->result();
        $cad = "";
        foreach($result as $r){
            $cad .= $r->ruc;
		}
		return $cad;	    	
	}

	function reporte($ar_datos){
		
		$desde = $ar_datos["desde"];
		$hasta = $ar_datos["hasta"];
		$orden = $ar_datos["orden"];

		if($ar_datos["opcion"] == "1"){  // Entradas desde hasta
			
			$cSql = "select a.token, a.fechaMov fechas, a.nroDoc, concat(a.ruc,'-',a.razon) cruc, a.accionMov, 
			a.tipoDoc, a.fec_emi_doc, a.fec_venc_doc, a.forma_pago, sum(a.costo) total, count(*) cuantos,
				a.costo_tienda, a.costo_banco
				from cr_inv_movimientos a
				left join cr_inv_productos b on a.idPro = b.idPro
				where a.accionMov='E' and a.fechaMov between '$desde' and '$hasta' and a.idAlm = " . $_SESSION["ALMACEN"] .
				" group by a.token, a.fechaMov, a.nroDoc, concat(a.ruc,'-',a.razon), a.accionMov, a.tipoDoc, a.fec_emi_doc, a.fec_venc_doc, a.forma_pago, a.costo_tienda, a.costo_banco 
					order by " . $orden . ",a.idMov limit 700";

			$result = $this->db->query($cSql)->result_array();
			return $result;
		
		}elseif($ar_datos["opcion"] == "2"){

			$token = $ar_datos["token"];

			$cSql = "select a.idMov, a.token, concat(a.fechaMov, ' ',a.horaMov) fechas, a.nroDoc, a.idPro, b.descPro, a.cantidadMov, 
				concat(a.ruc,'-',a.razon) cruc, a.accionMov, a.tipoDoc, a.fec_emi_doc, a.costo, a.cargo_servicio,
				q.total, q.cuantos
				from cr_inv_movimientos a
				left join cr_inv_productos b on a.idPro = b.idPro
				left join (
					select p.token, sum(p.costo) total, count(*) cuantos from cr_inv_movimientos p
					where p.token is not null
					group by p.token
				) q on a.token = q.token
				where a.accionMov='E' and a.fechaMov between '$desde' and '$hasta' and a.idAlm = " . $_SESSION["ALMACEN"] . 
				" and a.token = '$token'";
				
			$result = $this->db->query($cSql)->result_array();
			return $result;

		}

	}

	function carga_producto(){
		$this->db->select("idPro, descPro")
			->from("cr_inv_productos")
			->limit(5,5);

		$result = $this->db->get()->result();
		
		$cad = "<table>";
		foreach($result as $r){
			$cad .= "<tr>";
			$cad .= $this->fm->celda($r->idPro);
			$cad .= $this->fm->celda($r->descPro);
			$cad .= "</tr>";
		}
		$cad .= "</table>";

		echo $cad;
		
		// ->db->where();
		// ->db->from()
		// ->db->get();
		// ->db->numrows();
		// ->db->data_seek(id);
		// ->db->error();

		// $array = array('name' => $name, 'title' => $title, 'status' => $status);
		// $this->db->where($array);

		// $this->db->where('name !=', $name);
		// $this->db->or_where('id >', $id);
		
		// $this->limit(10, 20)  // 20 is a offset

		// Este comando se usa reemplazando ->get() por ->get_compiled_select()
		// ->get_compiled_select();

		// ->get_compiled_insert('mytable');  // te genera el query en string

		// ->db->replace('table', $data);  // comando replace into() values()

		//    $this->db->set('name', $name);
		//    $this->db->insert('mytable');

		// $this->db->where('id', $id);
		// $this->db->update('mytable', $data);

		//$this->db->delete('mytable', array('id' => $id));  // Produces: // DELETE FROM mytable  // WHERE id = $id

		// PERMITE RESETEAR EL CONSTRUCTOR DE QUERY //
		//$this->db->reset_query()

		// get_compiled_delete()

		//$this->db->select_sum('age');
		//$query = $this->db->get('members'); // Produces: SELECT SUM(age) as age FROM members
	}

	function agregar_detalle(&$subtotal){
		// token, accion, idPro, cantidad, subtotal
		$bandera = false;
		if(isset($_POST["token"])){
			if(strlen($_POST["token"])>0){
				$bandera = true;
			}
		}
		
		if($bandera == false){
			$token = date("Ymd-His");
		}else{
			$token = $_POST["token"];
		}

		$data["token"] 			= $token;
		$data["idPro"] 			= $_POST["idPro"];
		$data["cantidad"] 		= $_POST["cantidad"]; // $_POST[""];
		$data["subtotal"] 		= $_POST["costo"];
		$data["accion"] 		= $_POST["accion"];

		// Obteniendo el monto total del token

		if($this->db->insert("inv_detalles",$data)){
			
			/*$this->db->select_sum('subtotal');
			$this->db->where("token",$token);
			$subtotal = $this->db->get_compiled_select('inv_detalles');*/

			$this->db->select_sum('subtotal');
			$this->db->where("token",$token);
			$result = $this->db->get('inv_detalles')->result_array();
			$subtotal = 0;
			foreach($result as $r){ $subtotal = $r["subtotal"]; }

			return $token;
		}else{
			return "";
		}
	}

	function carga_detalle($token){
		$result = $this->db->select("inv_detalles.id, inv_productos.descPro, inv_detalles.cantidad, inv_detalles.subtotal")
			->from("inv_detalles")
			->join("inv_productos","inv_detalles.idPro = inv_productos.idPro")
			->where("token=",$token)
			->get()->result_array();
		return $result;
	}

    function getRows($params = array()){
        
		// $_SESSION["ALMACEN"]
		$desde = "2021-04-01"; //$params["desde"];
		$almacen = $params["almacen"];

        // Ruc-Razon  Documento  Fec. Registro  Tipo Doc  Emision  Vcmto  Forma-P  Items  Total
        $cSql = $this->db->select("token, fechaMov, nroDoc, razon, tipoDoc, fec_emi_doc, fec_venc_doc, forma_pago, sum(costo) total_sin_igv")
        	->from("inv_movimientos")
        	->where("accionMov=","E")
        	->where("fechaMov>=",$desde)
        	->where("idAlm=",$almacen)
        	->group_by(array("token", "fechaMov", "nroDoc", "razon", "tipoDoc", "fec_emi_doc", "fec_venc_doc", "forma_pago"));
        	//->get_compiled_select();
        //echo $cSql;

        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }

        //return fetched data
        return $result;
    }    
}
?>