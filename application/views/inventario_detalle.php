<style type="text/css">
	.subtotales{
		align:right; 
		height:23px; 
		padding:0px; 
		margin:5px;
		background-color:rgb(200,200,180)
	}
</style>
<div id="page-wrapper" style="padding-top:0px; margin-top: 0px;">
            
	<!--<div class="row">
		<div id="pizarra1" class="col-xs-12 col-sm-12">
			<h3>Registro en Almac&eacute;n</h3>
		</div>
	</div>-->
	
	<div class="row">
		<div id="pizarra1" class="col-xs-12 col-sm-10 col-md-8">
<?php
	//error_reporting(E_ALL & ~E_NOTICE);
	//ini_set('display_errors', '1');
	//echo $query;

			echo "<table class=\"table-hover\" border=\"0\">";
			echo "<thead>";
			echo "<tr>";
			
			echo $this->fm->celda_h("Producto",1,"padding:6px;"); 
			echo $this->fm->celda_h("Cantidad",1,"padding:6px;");
			echo $this->fm->celda_h("SubTotal",1,"padding:6px;");
			echo $this->fm->celda_h("-",1,"padding:6px;");
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			
			$verdeO = "rgb(0,70,0)"; $azulO = "rgb(0,0,150)"; $i = 0; $color = $verdeO;
			$suma = 0;
			foreach($result as $r){
				$i++;
				//if($i==1){ $nombreRef = $r['accionMov'];}
				//if($r['accionMov'] != $nombreRef){
				//	if($color == $verdeO){ $color = $azulO;}else{$color = $verdeO;}
				//	$nombreRef = $r['accionMov'];
				//}
				$boton = "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"eliminar(" . $r["id"] . ")\" style=\"height:28px;font-size:10px;\">Eliminar</button>";

				echo "<tr>";
				echo $this->fm->celda($r["descPro"],1,"padding:3px;");
				echo $this->fm->celda($r["cantidad"],1,"padding:3px;text-align:left;");
				echo $this->fm->celda($r["subtotal"],1,"padding:3px;text-align:left;");
				echo $this->fm->celda($boton,1,"padding:3px;");
				echo "</tr>";

				$suma += 1 * $r["subtotal"];
			}
			

			// Suma al final
			if($i>0){
				echo "<tr style=\"\">";
				echo "<th style=\"padding:0px\">&nbsp;</th>";
				echo "<th class=\"subtotales\" style=\"padding-left:10px\">Subtotal :</th>";
				echo "<th class=\"subtotales\">" . number_format($suma,2) . "</th>";
				echo "<th style=\"padding:0px\">&nbsp;</th>";
				echo "</tr>";

				echo "<tr style=\"\">";
				echo "<th style=\"padding:0px\">&nbsp;</th>";
				echo "<th class=\"subtotales\" style=\"padding-left:10px\">Igv :</th>";
				echo "<th class=\"subtotales\">" . number_format($suma*IGV,2) . "</th>";
				echo "<th style=\"padding:0px\">&nbsp;</th>";
				echo "<th style=\"padding:0px\">&nbsp;</th>";
				echo "</tr>";

				echo "<tr style=\"\">";
				echo "<th style=\"padding:0px\">&nbsp;</th>";
				echo "<th class=\"subtotales\" style=\"padding-left:10px\">Total :</th>";
				$total = $suma + ($suma*IGV);
				echo "<th class=\"subtotales\">" . number_format($total,2) . "</th>";
				echo "<th style=\"padding:0px\"></th>";
				
				echo "</tr>";
			}
			echo "</tbody></table>";
				
?>

		</div>
	</div>
</div>