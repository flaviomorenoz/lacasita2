<h3><?= $titulo ?></h3>
<?php
	$cEstilo = "text-align:center;";
	
	echo "<table class=\"table-condensed\"style=\"border-style:solid; border-width:2px;\"><thead>";
	echo $this->fm->celda_h("idPro");
	echo $this->fm->celda_h("descPro");
	//echo $this->fm->celda_h("stockInicial",2,$cEstilo);
	//echo $this->fm->celda_h("costo");
	echo $this->fm->celda_h("unidad");
	echo "</thead>";
	echo "<tbody>";

	$total = 0;
	foreach($result as $r){
		echo "<tr>";
		echo $this->fm->celda($r->idPro);
		echo $this->fm->celda($r->descPro);
		//echo $this->fm->celda($r->stockInicial,2,$cEstilo);
		//echo $this->fm->celda($r->costo);
		echo $this->fm->celda($r->unidad);
		$total += $r->costo;
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