<?php
class Fm{
	function conectar(){
		$usuario 	= "root";
		$clave 		= "jakamoto";
		$dbname 	= "db_catalogo2";
		$conn 		= new PDO("mysql:host=localhost;dbname=$dbname", $usuario);

		/*$usuario 	= "c1980893_base2";
		$clave 		= "82gakoTIpe";
		$dbname 	= "c1980893_base2";
		$conn 		= new PDO("mysql:host=localhost;dbname=$dbname", $usuario, $clave); */

		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	}

	function validacion($conn, $usuario, $clave, &$tipo_usuario){
	 // ESTO ES LA VALIDACION ORIGINAL ==========================

	/*
		$cSql = "select * from usuarios where u_correo = ?";
		$pdo = $conn->prepare($cSql);
		$pdo->bindParam(1,$usuario);
		$pdo->execute();
		$result = $pdo->fetchAll();
		$tipo_usuario 	= "ESTUDIANTE";
		$id_usuario 	= "";
		foreach($result as $r){
			$tipo_usuario 	= $r["u_tipo_usuario"];
			$id_usuario 	= $r["id_usuario"];
			return true;
		}
		return false;
	*/

		if($usuario == "" and $clave==""){
			$tipo_usuario = "ADMINISTRADOR";
			return true;
		}else{
			sleep(2);
			return false;
		}
	}

	function menus($tipo_usuario = "ESTUDIANTE"){
		$cad = "";
		if($tipo_usuario == "ESTUDIANTE" or $tipo_usuario == "PROFESOR" or $tipo_usuario == "ADMINISTRADOR"){
			$cad .= "<a href=\"main.php?accion=INICIO\">Inicio</a>&nbsp;&nbsp;";
		}

		if($tipo_usuario == "PROFESOR" or $tipo_usuario == "ADMINISTRADOR"){
			$cad .= "<a href=\"main.php?accion=PREGUNTAS\">Preguntas</a>&nbsp;&nbsp;";
			$cad .= "<a href=\"main.php?accion=LISTAR_PREGUNTAS\">Listar Preguntas</a>&nbsp;&nbsp;";
			$cad .= "<a href=\"main.php?accion=LISTAR_RESPUESTAS\">Listar Respuestas</a>&nbsp;&nbsp;";
			$cad .= "<a href=\"main.php?accion=GENERAR_CODE\">Generar Code</a>&nbsp;&nbsp;";
		}

		if($tipo_usuario == "ADMINISTRADOR"){
			$cad .= "<a href=\"main.php?accion=AGREGAR_USUARIO\">Usuarios</a>&nbsp;&nbsp;";
			$cad .= "<a href=\"main.php?accion=LISTAR_USUARIO\">Listar Usuarios</a>&nbsp;&nbsp;";
		}
		return $cad;
	}

	function celda_simple($dato = "&nbsp;"){
		return "<td>" . $dato . "</td>";
	}

	function celda($dato="", $centrar=0, $estilo="", $cAtributo=""){
		if($dato=='0'){
			$dato = "<span style=\"color:#cccccc;\">0</span>";
		}

		$cad = "";

		$cEstilo = "";
		if(strlen($estilo)>0)
			$cEstilo = "style=\"$estilo\"";

		if($centrar==1)
			$cad .= "<td align=\"center\" $cEstilo $cAtributo>$dato</td>";
		elseif($centrar==2)
			$cad .= "<td align=\"right\" $cEstilo $cAtributo>$dato</td>";
		else
			$cad .= "<td align=\"left\" $cEstilo $cAtributo>$dato</td>";
		
		return $cad;
	}

	function  fila($cad=""){
		return "<tr>" . $cad . "</tr>";
	}

	function celda_h($dato="",$centrar=0,$estilo=""){
		$cad = "";
		
		$cEstilo = "";
		if(strlen($estilo)>0)
			$cEstilo = "style=\"$estilo\"";

		if($centrar==1){
			$cad .= "<th align=\"center\" $cEstilo>$dato</th>";
		}elseif($centrar==2){
			$cad .= "<th align=\"right\" $cEstilo>$dato</th>"; // style=\"$estilo\"
		}else{
			$cad .= "<th align=\"left\" $cEstilo>$dato</th>";
		}
		
		return $cad;
	}

	function espacio($n){
		$cad = "";
		for($i=0; $i < $n; $i++){
			$cad .= "&nbsp;";
		}
		return $cad;
	}

	function mostrado($msg,$bandera){
		if($bandera){
			echo $msg . "<br>";
		}
	}

	function traer_campo($conn, $table, $campo, $where){
		$cSql = "select $campo from $table where $where";
		$pdo = $conn->prepare($cSql);
		$pdo->execute();
		$result = $pdo->fetchAll();
		foreach($result as $r){
			return $r[$campo];
		}
		return "";
	}

	function traer_campo2($conn, $cSql, $campo){
		$pdo = $conn->prepare($cSql);
		$pdo->execute();
		$result = $pdo->fetchAll();
		foreach($result as $r){
			return $r[$campo];
		}
		return "";
	}

	function result($conn, $cSql, $var1=null){
		$pdo = $conn->prepare($cSql);
		$pdo->bindParam(1,$var1);
		$pdo->execute();
		return $pdo->fetchAll();
	}

	function alertas($mensaje="",$tipo_alerta="success"){
		$mensaje = "<div class=\"alert alert-$tipo_alerta\">$mensaje</div>";
		return $mensaje;
	}

	function obtener_ip(){
		if(getenv('HTTP_CLIENT_IP')){
			$ip = getenv('HTTP_CLIENT_IP');
		}elseif(getenv('HTTP_X_FORWARDED_FOR')){
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}elseif(getenv('HTTP_X_FORWARDED')){
			$ip = getenv('HTTP_X_FORWARDED');
		}elseif(getenv('HTTP_FORWARDED_FOR')){
			$ip = getenv('HTTP_FORWARDED_FOR');
		}elseif(getenv('HTTP_FORWARDED')){
			$ip = getenv('HTTP_FORWARDED');
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	function guardar_ip($conn, $mi_ip, $padre, $hijo){
		$mi_fecha = date("Y-m-d H:i:s");
		$cSql = "insert into visitas(padre, hijo, ip, fecha) values('$padre','$hijo','$mi_ip','$mi_fecha')";
		$pdo = $conn->prepare($cSql);
		$pdo->execute();
	}

	function casilla($nombre, $valor_default, $size=10){
		$cad = "<input type='text' id='" . $nombre . "' name='" . $nombre . "' value='" . $valor_default . "' size='" . $size . "'>";
		return $cad;
	}

	function query_a_array($result,$key,$valor){
	    $ar = array();
	    foreach($result as $r){
	        $ar[$r[$key]] = $r[$valor];
	    }
	    return $ar;
	}

	function option($id, $cad="vacio", $valor=""){
		$selected = ""; //$codo = "";
		if(strlen($valor)>0){
			//$codo .= "valor: $valor = id: $id";
			if($valor == $id){
				$selected = " selected";
			}
		}
		return "<option value=\"$id\" " . $selected . ">" . $cad . "</option>";
	}

	function message($cad="", $alerta=0){
		if ($alerta == 0){
			$class = "success";
			$color = "rgb(250,255,230)";
		}elseif($alerta == 1){
			$class = "warning";
			$color = "rgb(255,255,225)";
		}elseif($alerta == 2){
			$class = "danger";
			$color = "rgb(255,160,140)";
		}else{
			$class = "cualquiera";
			$color = "rgb(240,240,255)";
		}
		return "<div class=\"alert-$class\" style=\"height:40px;background-color:$color;padding:9px\"><strong>" . $cad . "</strong></div>";
	}

    function ymd_dmy($cad=""){
        $n = strlen($cad);
        if($n >= 10){
            return substr($cad,8,2) . "-" . substr($cad,5,2) . "-" . substr($cad,0,4) . substr($cad,10);
        }else{
            return "vacio";
        }
    }
}
?>