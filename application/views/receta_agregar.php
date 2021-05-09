<script>
	function grabar_receta(){
		console.log("inicia grabar_receta")
		parametros = {
			nombreReceta 	: $("#nombreReceta").val(),
			costo 			: $("#costo").val(),
			idPro 			: $("#idPro").val(),
			cantidadReceta 	: $("#cantidadReceta").val(),
			unidadMedida 	: 'GRAMO'
		}
		$.ajax({
			data 	:parametros,
			url 	:'<?= base_url("/inventario/agregar_receta") ?>',
			type 	:'post',
			success :function(response){
				//console.log("Irnos");
				console.log(response)
				ar = JSON.parse(response)
				//document.getElementById('pizarra1').style.display = "block"
				if(ar['rpta']){
					document.getElementById('pizarra1').innerHTML = "<div class=\"alert alert-success\">" + ar["message"] + "</div>"
				}else{
				 	document.getElementById('pizarra1').innerHTML = "<div class=\"alert alert-danger\">" + ar["message"] + "</div>"
				}
			
				ver_recetas($("#nombreReceta").val())				
			}
		})
	}

	function ver_recetas(nombre){
		parametros = {nomRec : nombre}
		$.ajax({
			data 	: parametros,
			url 	:'<?= base_url("/inventario/rep_recetas_json") ?>',
			type 	:'post',
			success :function(response){
				document.getElementById('pizarra2').innerHTML = response
			}
		})
	}

	function limpiar_cab(){
		//document.getElementById('ruc').value = "";
	}

</script>
<div id="page-wrapper">
            
	<h2>Recetas</h2>

    <!-- CABECERA : -->
    <div style="border-style:solid; border-color:gray; border-width: 1px; margin:20px; padding:10px;">
        <div class="row espaciado">
	        <div class="col-sm-2">
	        	Nombre Receta:
	        </div>

	        <div class="col-sm-3">
	        	<input type="text" id="nombreReceta" name="nombreReceta" size="30" class="form-control" placeholder="nombre Receta">
	        </div>
	    </div>

	    <div class="row espaciado">
	        <div class="col-sm-2">
	        	Costo:
	        </div>

	        <div class="col-sm-3">
	        	<input type="text" id="costo" name="costo" size="10" class="form-control" placeholder="costo">
	        </div>
	    </div>
	</div>

	<!-- DETALLE : -->
	<div style="border-style:solid; border-color:gray; border-width: 1px; margin:20px; padding:10px;">

	    <div class="row">
	        <div class="col-sm-1">
	        	Producto:
	        </div>

	        <div class="col-sm-3">
	        	<?= $this->receta_model->combo_producto() ?>
	        </div>

	        <div class="col-sm-1">
	        	Cantidad:
	        </div>

	        <div class="col-sm-2">
	        	<input type="text" id="cantidadReceta" name="cantidadReceta" size="10" class="form-control" placeholder="cantidad">
	        </div>

	        <div class="col-sm-2">
	        	<button class="btn btn-info" type="button" onclick="grabar_receta()">Agregar Producto</button>
	        </div>

	    </div>

	    <div class="row" style="padding-top:8px">
	    	<div class="col-sm-12" id="pizarra1">
	    	</div>
	    </div>

	</div>

	<div style="border-style:solid; border-color:gray; border-width: 1px; margin:20px; padding:10px;">
		<div class="row" style="padding:1px;">
	    	<div class="col-xs-12 col-sm-12" id="pizarra2">

	    	</div>
		</div>
	</div>

</div>