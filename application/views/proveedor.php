<style type="text/css">
	.tandem{
		margin-left:10px;
		font-size:8px;
	}
	#oso{
		height:20px;
		padding:2px;
	}
</style>

<div id="page-wrapper">
            
    <div class="row">
        <div class="col-md-12">
		</div><!-- fin de col -->
	
	</div><!-- fin de row -->


	<div class="row">
		<div class="col-xs-12 col-sm-10 col-lg-6">

			<?php
				$simboloMon = "S/&nbsp;&nbsp;";
				$cEstilo = "max-width:70px;height:20px;padding:6px 18px;";
				$cEstiloN = "max-width:60px;padding:18px;margin:8px;";
			
				echo "<table class=\"table-hover\" style=\"border-style:solid; border-color:gray; border-width:1px;\">";
				echo "<caption>Proveedores:</caption>";
				echo "<thead>";
				// idProv
				$ar_campos = array("ruc","razon","telefono","banco1","nro_cta1","banco2","nro_cta2","banco3","nro_cta3","persona_contacto");
				$ar_tit = array("Ruc","Razon Social","Telefono","Banco1","nro_cta1","Banco2","nro_cta2","Banco3","nro_cta3","Persona_contacto");
				$nCampos = count($ar_campos);

				// TITULOS
				foreach($result as $r) {
					echo "<tr>";
					for($i=0;$i<$nCampos;$i++){
						echo $this->fm->celda_h($ar_tit[$i]);
					}
					echo "</tr>";
				}
				echo "</thead>";

				// FILAS
				echo "<tbody>";
				foreach($result as $r) {
					echo "<tr>";
					for($i=0;$i<$nCampos;$i++){
						echo $this->fm->celda($r[$ar_campos[$i]]);
					}
					echo "</tr>";
				}
				echo "</tbody>";

				echo "</table>";

			?>
		</div>
	</div>
</div>