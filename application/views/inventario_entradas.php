<?php
$result = $this->inventario_model->carga_inventario_entradas($almacen);
?>

<div id="page-wrapper" style="padding-top:0px; margin-top: 0px;">
            
	<!--<div class="row">
		<div id="pizarra1" class="col-xs-12 col-sm-12">
			<h3>Registro en Almac&eacute;n</h3>
		</div>
	</div>-->
	
	<div class="row">
		<div id="pizarra1" class="col-xs-12 col-sm-12">

<?php
				//idMov, concat(a.fechaMov, ' ',a.horaMov) fechas, a.idPro, b.descPro, a.cantidadMov, concat(a.ruc,'-',a.razon) cruc
				//
				echo "<table class=\"table-hover\">";
				//echo "<caption>Registro en Almac&eacute;n</caption>";
				echo "<thead>";
				//echo $this->fm->celda_h("Id"); 
				echo $this->fm->celda_h("Fechas"); 
				echo $this->fm->celda_h("Producto"); 
				echo $this->fm->celda_h("Cantidad");
				//echo $this->fm->celda_h("Tipo-Doc");
				//echo $this->fm->celda_h("Nro-Doc");
				//echo $this->fm->celda_h("Ruc-Razon");
				//echo $this->fm->celda_h("Emision");
				//echo $this->fm->celda_h("Accion");
				echo $this->fm->celda_h("SubTotal");
				echo $this->fm->celda_h("Opciones");
				echo "</thead>";
				echo "<tbody>";
				
				$verdeO = "rgb(0,70,0)"; $azulO = "rgb(0,0,150)"; $i = 0; $color = $verdeO;
				foreach($result as $r){
					$i++;
					if($i==1){ $nombreRef = $r['accionMov'];}
					if($r['accionMov'] != $nombreRef){
						if($color == $verdeO){ $color = $azulO;}else{$color = $verdeO;}
						$nombreRef = $r['accionMov'];
					}
					$boton = "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"eliminar(" . $r["idMov"] . ")\" style=\"height:28px;font-size:10px;\">Eliminar</button>";

					echo "<tr style=\"color:$color\">";
					//echo $this->fm->celda($r["idMov"]);
					echo $this->fm->celda($r["fechas"]);
					echo $this->fm->celda($r["descPro"]);
					echo $this->fm->celda($r["cantidadMov"]);
					//echo $this->fm->celda($r["tipoDoc"]);
					//echo $this->fm->celda($r["nroDoc"]);
					//echo $this->fm->celda($r["cruc"]);
					//echo $this->fm->celda($r["fec_emi_doc"]);
					//echo $this->fm->celda($r['accionMov']);
					echo $this->fm->celda($r["costo"]);
					echo $this->fm->celda($boton);
					echo "</tr>";
				}
				echo "</tbody></table>";
?>
		</div>
	</div>
</div>