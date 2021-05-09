<!--<h3><?= $titulo ?></h3>-->
<?php
	$cEstilo = "text-align:center;";
	
	echo "<table class=\"table-hover\"style=\"border-style:solid; border-width:2px;\">"; // table-condensed
	echo "<caption>$titulo</caption>";
	echo "<thead>";
	echo $this->fm->celda_h("nombreReceta");
	echo $this->fm->celda_h("idPro");
	echo $this->fm->celda_h("descPro");
	echo $this->fm->celda_h("unidadMedida");
	echo $this->fm->celda_h("cantidadReceta");
	echo "</thead>";
	echo "<tbody>";

	$total = 0;
	$verdeO = "rgb(0,100,0)"; $azulO = "rgb(0,0,150)"; $i = 0; $color = $verdeO;
	foreach($result as $r){
		$i++;
		if($i==1){ $nombreRef = $r->nombreReceta;}
		if($r->nombreReceta != $nombreRef){
			if($color == $verdeO){ $color = $azulO;}else{$color = $verdeO;}
			$nombreRef = $r->nombreReceta;
		}	
		echo "<tr style=\"height:20px; padding:1px; margin:1px; color:$color;\">";
		echo $this->fm->celda($r->nombreReceta);
		echo $this->fm->celda($r->idPro);
		echo $this->fm->celda($r->descPro);
		echo $this->fm->celda($r->unidadMedida);
		echo $this->fm->celda($r->cantidadReceta);
		//$total += $r->;
		echo "</tr>";
		
	}
	echo "</tbody>";

/*	echo "<tfoot>";
	echo $this->fm->celda_h(""); 
	echo $this->fm->celda_h("");
	echo $this->fm->celda_h("");
	echo $this->fm->celda_h("");
	echo $this->fm->celda_h("");
	echo $this->fm->celda_h(""); 
	echo $this->fm->celda_h(""); 
	echo $this->fm->celda_h("Total:",2,$cEstilo);
	echo $this->fm->celda_h($total,2,$cEstilo);
	echo "</tfoot>";*/
	echo "</table>";
?>