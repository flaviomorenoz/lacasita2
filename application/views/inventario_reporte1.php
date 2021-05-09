<?php
$simboloMon 	= "S/&nbsp;&nbsp;";
$cEstilo 		= "text-align:right;";
$cEstilo_cab 	= "text-align:center";

if($opcion == "1"){	
	echo "<h3>" . $titulo . "</h3>";
	echo "<table class=\"table-condensed\" border=\"0\"><thead>";

	echo $this->fm->celda_h("Ruc-Razon",1,$cEstilo_cab);
	echo $this->fm->celda_h("Documento",1,$cEstilo_cab);
	echo $this->fm->celda_h("Fec. Registro",1,$cEstilo_cab); 
	echo $this->fm->celda_h("Tipo Doc",1,$cEstilo_cab);
	echo $this->fm->celda_h("Emision",1,$cEstilo_cab);
	echo $this->fm->celda_h("Vcmto.",1,$cEstilo_cab);
	echo $this->fm->celda_h("Items",1,$cEstilo_cab);
	echo $this->fm->celda_h("costo_Tda",1,$cEstilo_cab);
	echo $this->fm->celda_h("costo_Bco",1,$cEstilo_cab);
	

	echo $this->fm->celda_h("Total",1,$cEstilo_cab);
	echo $this->fm->celda_h(".",1,$cEstilo_cab);
	echo "</thead>";
	echo "<tbody>";
	
	$total = 0; $total_tienda = 0; $total_banco = 0;
	$verdeO = "rgb(0,70,0)"; $azulO = "rgb(0,0,150)"; $i = 0; $color = $verdeO;
	$con = 0;

	foreach($result as $r){
		$i++;
		if($i==1){ $nombreRef = $r['accionMov'];}
		if($r['accionMov'] != $nombreRef){
			if($color == $verdeO){ $color = $azulO;}else{$color = $verdeO;}
			$nombreRef = $r['accionMov'];
		}

		$con++;
		$token = $r["token"];
		$cuantos = $r["cuantos"];

		echo "<tr style=\"color:$color\">";
		echo $this->fm->celda($r["cruc"]);
		echo $this->fm->celda($r["nroDoc"]);
		echo $this->fm->celda(substr($this->fm->ymd_dmy($r["fechas"]),0,10));
		echo $this->fm->celda(($r["tipoDoc"] == 'F' ? 'Factura' : ($r["tipoDoc"] == 'B' ? 'Boleta' : 'Guia') ));

		echo $this->fm->celda($this->fm->ymd_dmy($r["fec_emi_doc"]));
		echo $this->fm->celda($this->fm->ymd_dmy($r["fec_venc_doc"]));
		echo $this->fm->celda($r["cuantos"]);
		echo $this->fm->celda($r["costo_tienda"],1,"text-align:right;padding-right:20px");
		echo $this->fm->celda($r["costo_banco"],1,"text-align:right;padding-right:20px");
		
		echo $this->fm->celda($r["total"],1,"text-align:right;padding-right:20px");
		
		echo $this->fm->celda("<button class=\"btn btn-xs\" style=\"height:24px;padding-top:2px\" onclick=\"ver('" . $r["token"] . "','" . $r["nroDoc"] . "')\">Ver</button>");

		//echo $this->fm->celda("<button onclick=\"ver('" . $r["token"] . "','" . $r["nroDoc"] . "') class=\"btn btn-primary btn-lg\" data-toggle=\"modal\" data-target=\"#myModal\">Ver</button>");
		
		//$total = "";
		//if($con == $cuantos){
		$total += $r["total"] * 1;
		$total_tienda += $r["costo_tienda"] * 1;
		$total_banco += $r["costo_banco"] * 1;
		//	$con = 0;
		//}

		//echo $this->fm->celda($total);
		echo "</tr>";

	}
	echo "</tbody>";

	echo "<tfooter>";
	echo "<tr>";
	echo "<th colspan=\"7\" style=\"text-align:right\">Total :</th>";
	echo $this->fm->celda_h("<span style=\"color:darkred\">" .SIMBOLO_MONEDA . "</span> " . number_format($total_tienda,2),2);
	echo $this->fm->celda_h("<span style=\"color:darkred\">" .SIMBOLO_MONEDA . "</span> " . number_format($total_banco,2),2);
	echo $this->fm->celda_h("<span style=\"color:darkred\">" .SIMBOLO_MONEDA . "</span> " . number_format($total,2),2);
	echo "<th></th>";
	echo "</tr>";
	echo "</tfooter>";

	echo "</table>";

}elseif($opcion == "2"){

	$tabla = "<table class=\"table-condensed\" border=\"1\"><thead>";
	$tabla .= "<caption>Documento " . $nroDoc . ":</caption>";
	$tabla .= "<th>Id</th>";   // idMov
	$tabla .= $this->fm->celda_h("Tipo Doc"); // tipoDoc
	//echo $this->fm->celda_h("Documento");  // nroDoc
	//echo $this->fm->celda_h("Ruc-Razon"); // cruc
	$tabla .= $this->fm->celda_h("Emision"); // fec_emi_doc
	$tabla .= $this->fm->celda_h("Producto"); // ?
	$tabla .= $this->fm->celda_h("Cantidad",2,$cEstilo); // cantidadMov
	$tabla .= $this->fm->celda_h("SubTotal",2,$cEstilo); // costo
	//echo $this->fm->celda_h("Total",2,$cEstilo);  // acumulable
	$tabla .= "</thead>";
	$tabla .= "<tbody>";
	
	$total = 0;
	$verdeO = "rgb(0,70,0)"; $azulO = "rgb(0,0,150)"; $i = 0; $color = $verdeO;
	$con = 0;
	$cargo = 0;
	$titulo = "";

	foreach($result as $r){
		$i++;
		if($i==1){ $nombreRef = $r['accionMov'];}
		if($r['accionMov'] != $nombreRef){
			if($color == $verdeO){ $color = $azulO;}else{$color = $verdeO;}
			$nombreRef = $r['accionMov'];
		}

		$titulo = $r["cruc"];

		$con++;
		$token = $r["token"];
		$cuantos = $r["cuantos"];
		$cargo = $r["cargo_servicio"];

		$tabla .= "<tr style=\"color:$color\">";
		$tabla .= $this->fm->celda($r["idMov"]);
		$tabla .= $this->fm->celda(($r["tipoDoc"] == 'F' ? 'Factura' : ($r["tipoDoc"] == 'B' ? 'Boleta' : 'Guia') ));
		//echo $this->fm->celda($r["nroDoc"]);
		//echo $this->fm->celda($r["cruc"]);
		$tabla .= $this->fm->celda($r["fec_emi_doc"]);
		$tabla .= $this->fm->celda($r["descPro"]);
		$tabla .= $this->fm->celda(number_format($r["cantidadMov"]),2,$cEstilo);
		$tabla .= $this->fm->celda($simboloMon . number_format($r["costo"],2),2,$cEstilo);
		
		$total = "";
		if($con == $cuantos){
			$total = $r["total"];
			$con = 0;
		}

		$tabla .= "</tr>";

	}
	$estilo = "border-top: 0px; border-right: 1px solid gray; border-bottom:0px; border-left: 0px;";

	// la fila Subtotal
	$tabla .= "<tr><th colspan='4' style=\"\"></th><th style=\"text-align:right;\">Subtotal</th><th style=\"text-align:right;border-color:gray;\">" . $simboloMon . number_format($total,2) . "</th></tr>";

	// fila IGV
	$el_igv = $total*$_SESSION["IGV"]*1;
	$tabla .= "<tr><th colspan='4' style=\"$estilo\"></th><th style=\"text-align:right;\">Igv</th><th style=\"text-align:right\">" . $simboloMon . number_format($el_igv,2) . "</th></tr>";

	// Fila Cargo
	$tabla .= "<tr><th colspan='4' style=\"$estilo\"></th><th style=\"text-align:right;\">Cargo:</th><th style=\"text-align:right\">" . $simboloMon . number_format($cargo,2) . "</th></tr>";	

	// La fila Super-Total
	$el_total = $total + $el_igv + ($cargo*1);
	$tabla .= "<tr><th colspan='4' style=\"$estilo\"></th><th style=\"text-align:right;\">Total</th><th style=\"text-align:right\">" . $simboloMon . number_format($el_total,2) . "</th></tr>";

	$tabla .= "</tbody>";
	$tabla .= "</table>";

	$ar = array();
	$ar[1] = $tabla;
	$ar[2] = $titulo;
	echo json_encode($ar);
}
?>