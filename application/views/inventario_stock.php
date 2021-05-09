<style type="text/css">
	.tandem{
		margin-left:10px;
		font-size:8px;
	}
</style>

<div id="page-wrapper">
            
    <div class="row">
        <div class="col-md-12">
		</div><!-- fin de col -->
	
	</div><!-- fin de row -->

<style type="text/css">
	#oso{
		height:20px;
		padding:2px;
	}
</style>

	<div class="row">
		<div class="col-xs-12 col-sm-10 col-lg-6">

			<?php
				$simboloMon = "S/&nbsp;&nbsp;";
				$cEstilo = "max-width:70px;height:20px;padding:6px 18px;";
				$cEstiloN = "max-width:60px;padding:18px;margin:8px;";
			
				$result = $this->inventario_model->carga_inventario($_SESSION["ALMACEN"]);
				
				//die("Hasta aqui todo bien");
				echo "<table class=\"table-hover\" style=\"border-style:solid; border-color:gray; border-width:1px;\">";
				echo "<caption>Stock Actual</caption>";
				echo "<thead>";
				echo $this->fm->celda_h("ID",1,$cEstiloN); 
				echo $this->fm->celda_h("PRODUCTO",1,$cEstiloN); 
				//echo $this->fm->celda_h("Stock Inicial<br>en gramos",2,$cEstiloN."text-align:right;"); 
				echo $this->fm->celda_h("Unidad de<br>Medida",0,$cEstiloN); 
				echo $this->fm->celda_h("Stock Actual",2,$cEstiloN."text-align:right;"); 
				echo "</thead><tbody>";
				
				foreach($result as $r){
					echo "<tr>";
					echo $this->fm->celda($r["idPro"],0,$cEstilo);
					echo $this->fm->celda($r["descPro"],0,$cEstilo);
					//echo $this->fm->celda(number_format($r["stockInicial"]),2,$cEstilo);
					echo $this->fm->celda($r["unidad"],0,$cEstilo);
					echo $this->fm->celda(number_format($r["total_Stock"]),2,$cEstilo);
					echo "</tr>";
				}
				echo "</tbody></table>";
			?>
			
		</div>
		
	</div>

</div>