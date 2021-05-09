<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('inventario_model');
        //session_start();
        $this->load->library('pagination');
        //per page limit
        $this->perPage = 7;
        //die("Paso por qui");       
    }
   
    function index(){
        if(isset($_SESSION["USUARIO"])){
            if(strlen($_SESSION["USUARIO"])>0){
                $this->data['content']  = "inventario_stock";
                $this->load->view('inv_templo', $this->data);
            }else{
                sleep(2);
                //die("Acceso denegado");
                $this->data["nada"] = "";
                $this->load->view('inv_login', $this->data);
            }
        }else{
            sleep(2);
            //die("Acceso denegado");
            $this->data["nada"] = "";
            $this->load->view('inv_login', $this->data);
        }
    }

    function stock(){
        if(!(isset($_SESSION["USUARIO"]) && strlen($_SESSION["USUARIO"])>0)){
            $this->salir();
        }else{
            $this->data['content']          = "inventario_stock";
            $this->load->view('inv_templo', $this->data);
        }
    }

    function login(){
        
        if(isset($_POST["usuario"])){
            if(strlen($_POST["usuario"])>0){
                //if($_POST["usuario"] == 'admin' && $_POST["pass"] == 'bien'){                
                    sleep(1);
                    
                    $this->load->model("usuario_model");

                    $mi_almacen = "";
                    $mi_desc_almacen = "";
                    $idUsuario = $this->usuario_model->verifica_usuario($_POST["usuario"],$_POST["pass"],$mi_almacen,$mi_desc_almacen);

                    if($idUsuario > 0){

                        $_SESSION["USUARIO"]        = $_POST["usuario"];
                        
                        if($_SESSION["USUARIO"] == "admin"){
                            $_SESSION["ALMACEN"]        = $_POST['almacen'];
                            $_SESSION["DESC_ALMACEN"]   = $_POST["desc_almacen"];
                        }else{
                            $_SESSION["ALMACEN"]        = $mi_almacen;
                            $_SESSION["DESC_ALMACEN"]   = $mi_desc_almacen;
                        }
                        $_SESSION["ID_USUARIO"]     = $idUsuario;
                        $_SESSION["IGV"]            = 0.18;
                        
                        $this->data['content']  = "inventario_stock";
                        $this->load->view('inv_templo', $this->data);
                    }else{                        
                        $this->salir('Usuario no encontrado o clave incorrecta');
                    }

            }else{
                $this->salir('Verifique su usuario o password');
            }
        }else{
            $this->salir('Ingrese su usuario');
        }
    }

    function salir($message=""){
        sleep(1);
        session_destroy();
        $this->data["message"] = $message;
        $this->load->view('inv_login', $this->data);
        //exit;
    }


    function magregar_detalle(){
        
        $subtotal = 0;
        $var1 = $this->inventario_model->agregar_detalle($subtotal);

        
        $rpta = array();
        if(strlen($var1)>0){
            $rpta["token"] = $var1;
            $rpta["subtotal"] = $subtotal;
            $rpta["mensaje"] = "Todo super OK.";
            $rpta["error"] = false;
        }else{
            $rpta["mensaje"] = "No ha podido grabar detalle.";
            $rpta["error"] = true;
        }
        
        echo json_encode($rpta);
    }

    function agregar(){
        
        //die("Llego aqui");
        $operar = false;  // si operar = false entonces es grabacion //
        if (isset($_POST) && count($_POST) > 0){
            
            if(!isset($_POST["OPERACION"])){
                $data = array();

                $rpta = "";
                $hasError = false;
                $data["idAlm"]        = $_POST["idAlm"];
                $data["accionMov"]    = $_POST["accionMov"];
                
                $data["tipodoc"]      = $_POST["tipodoc"];
                $data["idPro"]        = $_POST["idPro"];
                $data["cantidadMov"]  = $_POST["cantidadMov"];
                $data["nroDoc"]       = $_POST["nroDoc"];
                $data["ruc"]          = $_POST["ruc"];
                
                if(strlen($data["accionMov"]) == 0){
                    $hasError = true;
                    $rpta .= $this->fm->message("Debe ingresar la Accion!",2);
                }

                //die("tipodoc:" . $data["tipodoc"]);
                if($data["tipodoc"] == "F" || $data["tipodoc"] == "B"){
                    //die("entro aqui");
                    if(strlen($_POST["razon"])==0){
                        $hasError = true;
                        $rpta .= $this->fm->message("Debe ingresar la Razon Social! ",2);
                    }

                    if(strlen($_POST["ruc"])!=11){
                        $hasError = true;
                        $rpta .= $this->fm->message("Debe ingresar RUC correctamente! ",2);
                    }

                    if(strlen($_POST["nroDoc"])==0){
                        $hasError = true;
                        $rpta .= $this->fm->message("Debe ingresar Nro. documento! ",2);
                    }
                }

                $data["razon"]        = $_POST["razon"];
                $data["fec_emi_doc"]  = $_POST["fec_emi_doc"];
                $data["fec_venc_doc"]  = $_POST["fec_venc_doc"];
                $data["motivo"]       = $_POST["motivo"];
                $data["cargo_servicio"] = $_POST["cargo_servicio"];
                $data["costo"]          = $_POST["costo"];
                $data["idUsuario"]      = $_POST["idUsuario"];
                $data["token"]          = $_POST["token"];
                //$data["forma_pago"]     = $_POST["forma_pago"];
                $data["costo_tienda"]   = $_POST["costo_tienda"];
                $data["costo_banco"]    = $_POST["costo_banco"];
                
                //if(strlen($data["costo"]) == 0 || $data["costo"]*1 == 0){
                //    $hasError = true;
                //    $rpta .= $this->fm->message("Debe ingresar el costo!",2);
                //}

                if(!$hasError){
                    $rpta = $this->inventario_model->grabar($data);
                }
                $ar['error'] = $hasError;
                $ar['message'] = $rpta;
                echo json_encode($ar);
            }else{
                $operar = true;
            }
        }else{
            $operar = true;
        }
        
        if($operar){  // preparar el nuevo documento
            $this->data['content']          = "inventario_agregar";
            
            if(isset($_POST["token"])){
                if(strlen($_POST["token"])>0){
                    $this->data['token']           = $_POST["token"];
                }else{
                    $this->data['token']            = date("Ymd-His");
                }
            }else{
                $this->data['token']            = date("Ymd-His");
            }

            if(isset($_POST["OPERACION"])){
                $this->data['OPERACION']        = $_POST["OPERACION"];
            }else{
                $this->data['OPERACION']        = "I";
            }
            $this->load->view('inv_templo', $this->data);
        }
        
    }

    function obtener_ruc(){
        $data['razon'] = $_POST["razon"];
        echo $this->load->view("inventario_ruc",$data);
    }

    function rep_entradas(){

        if( !(isset($_SESSION["USUARIO"]) && strlen($_SESSION["USUARIO"])>0) ){
            $this->salir();
        }else{
            if(isset($_POST["desde"])){
                $data = array();
                if(!isset($_POST["opcion"])){
                    $data["opcion"] = "1";
                }else{
                    $data["opcion"] = $_POST["opcion"];
                    $data["token"]  = $_POST["token"];
                    $data["nroDoc"] = $_POST["nroDoc"];
                }

                $data["desde"] = $_POST["desde"];
                $data["hasta"] = $_POST["hasta"];
                $data["orden"] = $_POST["orden"];

                $data["titulo"] = "Compras &nbsp;&nbsp;" . $this->fm->ymd_dmy($data["desde"]) . " hasta " . $this->fm->ymd_dmy($data["hasta"]);
                
                $data["result"]     = $this->inventario_model->reporte($data);

                $this->load->view("inventario_reporte1", $data);  // lo devuelve por Ajax
            }else{
                $data["titulo"] = "Reporte de Entradas ";
                $data['content'] = "inventario_rep_entradas";

               $this->load->view('inv_templo', $data);
            }
        }
    }

    function agregar_producto(){
        if(!(isset($_SESSION["USUARIO"]) && strlen($_SESSION["USUARIO"])>0)){
            $this->salir();
        }else{
        
            $this->load->model('producto_model');
            
            
            if(isset($_POST["descPro"]) && strlen($_POST["descPro"])>0){
                
                if(strlen($_POST["idPro"])==0){ // Insertar 
                    echo $this->producto_model->agregar();
                }else{
                    echo $this->producto_model->modificar();
                }
                
            }else{
                $this->data['content']          = "producto_agregar"; // se carga en un view
                $this->data['tabla_producto']   = $this->producto_model->rep_productos();
                $this->load->view('inv_templo', $this->data);
            }
        }
        
    }

    function rep_productos(){
        if(!(isset($_SESSION["USUARIO"]) && strlen($_SESSION["USUARIO"])>0)){$this->salir();}

        $this->load->model('producto_model');
        $result = $this->producto_model->rep_productos();        
        
        $this->data["content"] = "inventario_rep_producto1";
        $this->data["result"] = $result;
        $this->data["titulo"] = "Lista de Productos";

        $this->load->view('inv_templo', $this->data);
    }


    function rep_recetas(){
        if(!(isset($_SESSION["USUARIO"]) && strlen($_SESSION["USUARIO"])>0)){$this->salir();}

        $this->load->model('receta_model');
        $result = $this->receta_model->rep_recetas();        
        
        $this->data["content"] = "inventario_rep_receta1";
        $this->data["result"] = $result;
        $this->data["titulo"] = "Lista de Recetas";

        $this->load->view('inv_templo', $this->data);
    }

    function rep_recetas_json(){
        if(!(isset($_SESSION["USUARIO"]) && strlen($_SESSION["USUARIO"])>0)){$this->salir();}

        $this->load->model('receta_model');
        
        $nomRec = $_POST["nomRec"]; 
        $result = $this->receta_model->rep_recetas($nomRec);        
        
        $this->data["result"] = $result;
        $this->data["titulo"] = "Lista de Recetas";
        $this->load->view("inventario_rep_receta1",$this->data);
    }

    function prueba(){
        $this->inventario_model->carga_producto();
    }

    function entradas(){ // para cargar la parte inferior de Pantalla Movimiento
        $data["almacen"] = $_SESSION["ALMACEN"];
        $this->load->view("inventario_entradas",$data);
    }

    function detalle(){ // para cargar la parte inferior de Pantalla Movimiento
        //die("Hola");
        $token = $_POST["token"];
        
        //die("token en detalle:".$token);
        $result = $this->inventario_model->carga_detalle($token);
        
        $query = $this->db->select("inv_detalles.id, inv_productos.descPro, inv_detalles.cantidad, inv_detalles.subtotal")
            ->from("inv_detalles")
            ->join("inv_productos","inv_detalles.idPro = inv_productos.idPro")
            ->where("token=",$token)
            //->get()->result_array();
            ->get_compiled_select();

        //die($query);
        $data["result"] = $result;
        $data["query"]  = $query;
        $this->load->view("inventario_detalle",$data);  // lo llama por Ajax
    }

    function agregar_receta(){
        $this->load->model('receta_model');
        $ar = array();
        $ar["nombreReceta"]     = $_POST["nombreReceta"]; 
        $ar["costoReceta"]      = $_POST["costo"]; 
        $ar["idPro"]            = $_POST["idPro"]; 
        $ar["cantidadReceta"]   = $_POST["cantidadReceta"]; 
        $ar["unidadMedida"]     = $_POST["unidadMedida"];

        echo $this->receta_model->agregar_receta($ar);
    }

    function eliminar_detalles(){
        
        $id = $_POST["id"];

        // Averiguando el token:
        $token = "0";
        //$oso = $this->db->select("token")
        //    ->where("id",$id)->get_compiled_select("inv_detalles");

        $result = $this->db->select("token")
            ->where("id",$id)->get("inv_detalles")->result_array();

        foreach($result as $r){ $token = $r["token"]; }

        // Eliminando:
        
        $cSql = "delete from cr_inv_detalles where id = $id";
        if($this->db->query($cSql)){
            $rpta = true;
        }else{
            $rpta = false;
        }

        // Averiguando el subtotal
        $subtotal = 0;
        if($token != "0"){
            $this->db->select_sum('subtotal');
            $this->db->where("token",$token);
            $result = $this->db->get('inv_detalles')->result_array();
            foreach($result as $r){ $subtotal = $r["subtotal"]; }
        }        

        $ar = array();
        $ar["rpta"]         = $rpta;
        $ar["subtotal"]     = $subtotal;
        echo json_encode($ar);
    }

    function eliminar_producto(){
        $this->load->model("producto_model");
        $idPro = $_POST["idPro"];
        $rpta = $this->producto_model->eliminar_producto($idPro);
        $ar = array();
        $ar["error"] = false;
        if($rpta){
            $ar["message"] = "Se eliminó correctamente el Producto";
        }else{
            $ar["message"] = "No se puede eliminar el Producto.";
            $ar["error"] = true;
        }
        echo json_encode($ar);
    }

    function mostrar_movimientos(){
        $data = array();
        
        //error_reporting(E_ALL & ~E_NOTICE);
        //ini_set('display_errors', '1');

        //get rows count
        $conditions['returnType'] = 'count';

        $cSql = "select count(a.token) cantidad from (select token from `cr_inv_movimientos` where idAlm = 1 group by token) a";
        $result = $this->db->query($cSql)->result_array();
        $totalRec = 0;
        foreach($result as $r){ $totalRec = $r["cantidad"]*1; }

        //$totalRec = 6; //$this->inventario_model->getRows($conditions);
        //die("TotalRec:" . $totalRec . "<br>");
        
        //pagination config
        $config['base_url']    = base_url().'inventario/mostrar_movimientos/';  // 'posts/index/'
        $config['uri_segment'] = 3;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        
        //styling
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['next_tag_open'] = '<li class="pg-next">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="pg-prev">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        

        //initialize pagination library

        $this->pagination->initialize($config);
        
        //define offset
        $page = $this->uri->segment(3);
        $offset = !$page?0:$page;
        

        //get rows
        $conditions['returnType'] = '';
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $conditions['almacen'] = $_SESSION["ALMACEN"];
        
        $data['posts'] = $this->inventario_model->getRows($conditions);
        
        //print_r($data['posts']);
        //die();
        
        $data['content'] = "inventario_movimientos";
        $this->load->view('inv_templo', $data);
    }

    function actualiza_movimientos(){
        $data = array();
        
        //get rows count
        $conditions['returnType'] = 'count';

        $cSql = "select count(a.token) cantidad from (select token from `cr_inv_movimientos` where idAlm = 1 group by token) a";
        $result = $this->db->query($cSql)->result_array();
        $totalRec = 0;
        foreach($result as $r){ $totalRec = $r["cantidad"]*1; }
        
        //pagination config
        $config['base_url']    = base_url().'inventario/mostrar_movimientos/';  // 'posts/index/'
        $config['uri_segment'] = 3;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        
        //styling
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['next_tag_open'] = '<li class="pg-next">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="pg-prev">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        

        //initialize pagination library

        $this->pagination->initialize($config);
        
        //define offset
        $page = $this->uri->segment(3);
        $offset = !$page?0:$page;
        

        //get rows
        $conditions['returnType'] = '';
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $conditions['almacen'] = $_SESSION["ALMACEN"];
        
        $data['posts'] = $this->inventario_model->getRows($conditions);
        
        //print_r($data['posts']);
        //die();
        //$data['content'] = "inventario/movimientos";
        //$this->view('inv_templo', $data);
        $this->load->view("inventario_movimientos",$data);
    }

    function eliminar_movimientos(){
        
        $ar = array();
        $token = $_POST["token"];

        $this->db->where("token",$token);
        
        //$ar["message"] = $this->db->get_compiled_delete("inv_movimientos");
        //$ar["rpta"] = true;
        
        $respuesta = $this->db->delete("inv_movimientos");

        if($respuesta){
            $ar["message"] = "Se elimina correctamente";
            $ar["rpta"] = true;
        }else{
            $ar["message"] = "No se puedo eliminar";
            $ar["rpta"] = false;
        }
        echo json_encode($ar);
    }

}
?>