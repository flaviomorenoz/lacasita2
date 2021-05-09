<div>
            
    <div id="agregar_producto" style="border-style:solid; border-color:gray; border-width: 1px; margin:20px; padding:10px;">
        <div class="row" style="margin-top:5px;">
	        <div class="col-sm-2">
	        	Nombre Producto:
	        </div>

	        <div class="col-sm-3">
	        	<input type="text" id="descPro" name="descPro" size="30" class="form-control" placeholder="Nombre Producto">
	        	<input type="hidden" id="idPro" name="idPro">
	        </div>
	    </div>

	    <div class="row" style="margin-top:5px;">
	        <div class="col-sm-2">
	        	Unidad de medida:
	        </div>

	        <div class="col-sm-3">
	        	<?= $this->producto_model->combo_unidad(); ?>
	        </div>
	    </div>
	    
	    <div class="row" style="margin-top:5px;">
	        <div class="col-sm-2">
   				<div class="col-sm-2" style="margin:20px;">
					<button class="btn btn-success" onclick="grabar_producto()">Grabar</button>
				</div>
			</div>
		</div>

        <div class="row" style="margin-top:5px;">
	        <div id="pizarra1" class="col-sm-12">
	        </div>
	    </div>

	</div>

	<script>
		function limpiar_cab(){
			//document.getElementById('ruc').value = "";
		}

		function grabar_producto(){

			var parametros = {
				idAlm 		: '<?= $_SESSION["ALMACEN"] ?>', //document.getElementById('idAlm').value,
				descPro 	: document.getElementById('descPro').value,
				stockInicial: 0,
				costo 		: 0,
				unidad 		: document.getElementById('unidad').value,
				idPro 		: document.getElementById('idPro').value
			}
			//console.log("inicia grabar producto")
			$.ajax({
				data 	:parametros,
				url 	:'<?= base_url('inventario/agregar_producto') ?>',
				type 	:'post',
				success :function(response){
					console.log(response)
					ar = JSON.parse(response)
					document.getElementById('pizarra1').innerHTML = ar['message']
					console.log("termina grabar producto")
				}
			})
			document.getElementById("agregar_producto").style.backgroundColor = "#FFD68A"

		}

		function eliminar_producto(idProx){
			var parametros = {
				idPro : idProx,
			}
			console.log("inicia Eliminar producto")
			$.ajax({
				data 	: parametros,
				url 	:'<?= base_url('inventario/eliminar_producto') ?>',
				type 	:'post',
				success :function(response){
					ar = JSON.parse(response)
					console.log(ar)
					alert(ar['message'])
				}
			})

		}

		function modificar_producto(idProx, descProx, unidadx){
			document.getElementById("idPro").value 		= idProx
			document.getElementById("descPro").value 	= descProx
			document.getElementById("unidad").value 	= unidadx
			document.getElementById("agregar_producto").style.backgroundColor = "white"
		}
	</script>

    <div class="row" style="border-style:solid; border-color:gray; border-width: 1px; margin:20px; padding:0px;">
    	<div class="col-sm-12" id="pizarra2">

    		<?php 
    			$result = $tabla_producto;
				//echo "<h3>" . $titulo . "</h3>";

				$cEstilo = "text-align:center;";
				
				echo "<table class=\"table-condensed\"style=\"border-style:solid; border-width:0px;\"><thead>";
				echo $this->fm->celda_h("idPro");
				echo $this->fm->celda_h("descPro");
				echo $this->fm->celda_h("unidad");
				echo $this->fm->celda_h(".");
				echo "</thead>";
				echo "<tbody>";

				$total = 0;
				foreach($result as $r){
					//$boton = "<button type=\"button\" class=\"btn btn-danger btn-xs\" style=\"height:25px;padding-top:3px\" onclick=\"eliminar_producto(" . $r->idPro . ")\">Eliminar</button>";
					//$boton_mod = "<button type=\"button\" class=\"btn btn-primary btn-xs\" style=\"height:25px;padding-top:3px\" onclick=\"modificar_producto(" . $r->idPro . ",'" . $r->descPro . "','" . $r->unidad . "')\">Modificar</button>";
					
					$btn_ini = "<button type=\"button\" class=\"btn btn-danger btn-xs\" style=\"height:30px;padding-top:3px\"";
					
					$boton_mod = $btn_ini . " onclick=\"modificar_producto(" . $r->idPro . ",'" . $r->descPro . "','" . $r->unidad . "')\""  . "><span class=\"glyphicon glyphicon-edit iconos\"></span></button>"; 
					$boton = $btn_ini . " onclick=\"eliminar_producto(" . $r->idPro . ")\"" . "><span class=\"glyphicon glyphicon-remove iconos\"></span></button>"; 

					echo "<tr>";
					echo $this->fm->celda($r->idPro);
					echo $this->fm->celda($r->descPro);
					echo $this->fm->celda($r->unidad);
					echo $this->fm->celda($boton_mod . " " .$boton);
					$total += $r->costo;
					echo "</tr>";
				}
				echo "</tbody>";
				echo "</table>";
    		?>
    	</div>
    </div>

</div>