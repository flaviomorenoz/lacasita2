<?php
$tipo_doc 		= "";
$nroDoc 		= "";
$razon 			= "";
$ruc 			= "";
$fec_emi_doc 	= "";
$fec_venc_doc 	= "";
$cargo_servicio = "";
//$forma_pago 	= ""; // es tranca
$costo_tienda   = "";
$costo_banco 	= "";

//if (isset($token1) && strlen($token1)>0){
if($OPERACION == 'U'){
	
	$token = str_replace("_", "-", $token);
	//die("Mision:".$token1);
	$result = $this->db->select('*')
		->from('inv_movimientos')
		->where('token',$token)
		//->get_compiled_select();
		->get()->result_array();
	//die($result);
	

	foreach($result as $r){
		
		$tipo_doc 		= $r["tipoDoc"];
		$nroDoc 		= $r["nroDoc"];
		$razon 			= $r["razon"];
		$ruc 			= $r["ruc"];
		$fec_emi_doc 	= $r["fec_emi_doc"];
		$fec_venc_doc 	= $r["fec_venc_doc"];
		$cargo_servicio = $r["cargo_servicio"];
		//$forma_pago 	= $r["forma_pago"]; // es tranca
		$costo_tienda 	= $r["costo_tienda"];
		$costo_banco 	= $r["costo_banco"];
	}
}

?>
<style>
	* {
	  box-sizing: border-box;
	}

	/*the container must be positioned relative:*/
	.autocomplete {
	  /*position: relative;
	  display: inline-block;*/
	}

	input {
	  /*border: 1px solid transparent;
	  background-color: #f1f1f1;
	  padding: 10px;
	  font-size: 16px;*/
	}

	input[type=text] {
	  background-color: #f1f1f1;
	  width: 100%;
	}

	input[type=submit] {
	  background-color: DodgerBlue;
	  color: #fff;
	  cursor: pointer;
	}

	.autocomplete-items {
	  position: absolute;
	  border: 1px solid #d4d4d4;
	  border-bottom: none;
	  border-top: none;
	  z-index: 99;
	  /*position the autocomplete items to be the same width as the container:*/
	  top: 100%;
	  left: 0;
	  right: 0;
	}

	.autocomplete-items div {
	  padding: 10px;
	  cursor: pointer;
	  background-color: #fff; 
	  border-bottom: 1px solid #d4d4d4; 
	}

	/*when hovering an item:*/
	.autocomplete-items div:hover {
	  background-color: #e9e9e9; 
	}

	/*when navigating through the items using the arrow keys:*/
	.autocomplete-active {
	  background-color: DodgerBlue !important; 
	  color: #ffffff; 
	}

	.tandem{
		margin-left:10px;
		font-size:8px;
	}
	body{
		font-family:arial;
		color:rgb(20,20,90);
	}
	.gola{
		margin:20px;
	}
	.etiquetas{
		font-size:12px;
		padding: 7px 0px 0px 10px;
	}
	.xxxdiv{
		border-style:solid;
		border-color:black;
		border-width:1px;
	}

</style>

<script type="text/javascript">
	var IGV = 0.18
	function grabar_inventario(){

		console.log("Ingresando a grabar_inventario")
		token = document.getElementById('token').value
		if(token.length == 0){
			alert("No puede grabar, ingrese items")
			return false;
		}
		
		let temo = document.getElementById("fec_emi_doc").value
		if(temo.length == 0 && (document.getElementById("tipodoc").value=='F' || document.getElementById("tipodoc").value=='B')){
			alert("Ingrese fecha de Emision")
			return false
		}

		temo = document.getElementById("fec_venc_doc").value
		if(temo.length == 0 && (document.getElementById("tipodoc").value=='F' || document.getElementById("tipodoc").value=='B')){
			alert("Ingrese fecha de Vencimiento")
			return false
		}

		if(document.getElementById("tipodoc").value=='F' || document.getElementById("tipodoc").value=='B'){
			fec_venc 	= document.getElementById("fec_venc_doc").value
			fec_emi 	= document.getElementById("fec_emi_doc").value
			if (fec_emi > fec_venc){
				alert("'Fecha de Emisión es mayor que Fecha de Vencimiento'")
				return false
			}
		}

		// Cargo > cero
		let cargo = document.getElementById("cargo_servicio").value
		if (cargo.length > 0){
			if(cargo * 1 < 0){
				alert("Cargo por Servicio debe ser mayor a cero")
				return false
			}
		}

		cargo = cargo * 1
		let costo_subTotal = document.getElementById("txt_subtotal").value * 1
		let el_igv = costo_subTotal * IGV
		
		let monto_total = costo_subTotal + el_igv + cargo 
		let costo_t = document.getElementById("costo_tienda").value
		let costo_b = document.getElementById("costo_banco").value

		if(monto_total != (costo_t*1) + (costo_b*1)){
			alert("El monto total ("+monto_total+") no coincide con los de tienda y banco")
			return false
		}

		var parametros = {
			"idAlm" 		:<?= $_SESSION["ALMACEN"] ?>, //document.getElementById('almacen').value,
			"accionMov"		:'E', //document.getElementById('accion').value,
			
			"tipodoc" 		:document.getElementById('tipodoc').value,
			"nroDoc" 		:document.getElementById('nroDoc').value,
			"idPro" 		:document.getElementById('productos').value,
			"cantidadMov" 	:document.getElementById('cantidad').value,
			"ruc" 			:document.getElementById('ruc').value,
			"razon"			:document.getElementById('razon').value,
			"fec_emi_doc" 	:document.getElementById('fec_emi_doc').value,
			"fec_venc_doc" 	:document.getElementById('fec_venc_doc').value,
			"motivo" 		:'PROVISION', //document.getElementById('motivo').value,
			"cargo_servicio":document.getElementById('cargo_servicio').value,
			"costo" 		:document.getElementById('costo').value,
			"idUsuario" 	: <?= $_SESSION["ID_USUARIO"] ?>,
			"token" 		:document.getElementById('token').value,
			//"forma_pago" 	:document.getElementById('forma_pago').value,
			"costo_tienda"	:document.getElementById('costo_tienda').value,
			"costo_banco"	:document.getElementById('costo_banco').value
		}
		
		$.ajax({
			data 	: parametros,
			url 	: '<?= base_url('inventario/agregar') ?>',
			type 	: 'post',
			success :function(response){
				ar = JSON.parse(response)
				if(ar["error"]){
					// nothing
				}else{
					document.getElementById('token').value = "";

					document.getElementById('pizarra2').innerHTML = "";
					limpiar_cab()
					limpiar_det()
				}
				document.getElementById('pizarra1').innerHTML = ar["message"];
			}
		})

	}

	function magregar_detalle(){
		console.log("Ingresando a magregar_detalle")
		
		var parametros = {		
			"token" 		:document.getElementById('token').value,
			"idPro" 		:document.getElementById('productos').value,
			"cantidad" 		:document.getElementById('cantidad').value,
			"costo" 		:document.getElementById('costo').value,
			"accion" 		:'E' //document.getElementById('accion').value
		}
		
		$.ajax({
			data 	:parametros,
			url 	:'<?= base_url('inventario/magregar_detalle') ?>',
			type 	:'post',
			success :function(response){
				
				//console.log(response);

				ar = JSON.parse(response)
				if(ar["error"]==true){
					console.log(ar["error"])

				}else{
					console.log("Retorno de detalle")
					
					document.getElementById("token").value = ar["token"]

					//console.log(ar["token"])
					//console.log("Subtotal:" + ar["subtotal"])
					document.getElementById("txt_subtotal").value = ar["subtotal"]

					actualizaVistaDetalle() // ar["token"]

					limpiar_det()
				}
				console.log(ar["mensaje"])
			}
		})
	}


	function actualizaVistaMov(){
		parametros = {visualizacion:2}
		$.ajax({
			data: parametros,
			type: 'post',
			url : '<?= base_url('/inventario/entradas') ?>',
			success: function(response){
				document.getElementById("pizarra2").innerHTML = response
			}
		})
	}

	function actualizaVistaDetalle(){
		//console.log("Entrando a actualizaVistaDetalle")
		parametros = {token:document.getElementById("token").value}
		//console.log("El token es:"+document.getElementById("token").value)
		$.ajax({
			data: parametros,
			type: 'post',
			url : '<?= base_url('/inventario/detalle') ?>',
			success: function(response){
				document.getElementById("pizarra2").innerHTML = response
			}
		})
	}

	function eliminar(valor){
		console.log("Eliminando...")
		let parametros = {id: valor}
		$.ajax({
			data: parametros,
			type: 'post',
			url:'inventario/eliminar_detalles',
			success:function(response){
				actualizaVistaDetalle()
				console.log("Se elimina...")
				//console.log(response)
				let ar = JSON.parse(response)
				document.getElementById("txt_subtotal").value = ar["subtotal"]
			}
		})
	}

	setTimeout("console.log('INI');actualizaVistaDetalle();console.log('Fini')",1500);
</script>
<style type="text/css">
</style>

<div id="page-wrapper">
            
    <div style="border-style:solid; border-color:gray; border-width: 1px; margin:20px 20px 5px 20px; padding:5px 10px;">
        <div class="row espaciado">

	        <div class="col-sm-2">
		        <div class="form-group">
		        	<label for="tipodoc">Tipo Doc.</label>
		        	<?php 
		        	//echo $tipo_doc;
		        	echo $this->inventario_model->combo_TipoDoc($tipo_doc); 
		        	?>
		        </div>
		    </div>

	        <div class="col-sm-3">
	        	<label for="nroDoc">Nro. Docu:</label>
	        	<input name="nroDoc" id="nroDoc" class="form-control" value="<?= $nroDoc ?>" placeholder="Nro. Docu">
	        </div>

	        <div class="col-sm-4">
				<div class="autocomplete"> 
					<div class="form-group">
						<label for="razon">Razon Social:</label>
				    	<input id="razon" type="text" name="razon" value="<?= $razon ?>" class="form-control" placeholder="Razon Social" onblur="obtener_ruc(this)">
				    </div>
				</div>
	        </div>

	        <div class="col-sm-3">
				<div class="form-group">
					<label for="ruc">Ruc:</label>	        	
					<input type="text" name="ruc" id="ruc" value="<?= $ruc ?>" class="form-control" maxlength="11">
				</div>
	        </div>

	    </div>

        <div class="row" style="margin-bottom: 0px;">
	        <div class="col-sm-3">
	        	<div class="form-group">
					<label for="fec_emi_doc">Fec_emi:</label>
	        		<input type="date" id="fec_emi_doc" name="fec_emi_doc" value="<?= $fec_emi_doc ?>" class="form-control" size="10">
	        	</div>
	        </div>

	        <div class="col-sm-3">
	        	<div class="form-group">
					<label for="fec_venc_doc">Fec_venc:</label>
	        		<input type="date" id="fec_venc_doc" name="fec_venc_doc" value="<?= $fec_venc_doc ?>" class="form-control">
	        	</div>
	    	</div>	    

	        <div class="col-sm-3">
	        	<div class="form-group">
					<label for="cargo_servicio">Cargo x Servicio:</label>
	        		<input type="text" id="cargo_servicio" name="cargo_servicio" value="<?= $cargo_servicio ?>" class="form-control" placeholder="S/">
	        		<input type="hidden" id="token" name="token" value="<?= $token ?>">
	        	</div>
	        </div>


	        <div class="col-sm-3">
	        	<!--<div class="form-group">
	        		<label for="forma_pago">Forma de Pago:</label>
		        	<select id="forma_pago" name="forma_pago" class="form-control">
		        		<option value="CAJATIENDA" <?= ($forma_pago == 'CAJATIENDA' ? 'SELECTED' : '') ?>>Caja Tienda</option>
		        		<option value="CUENTABANCO" <?= ($forma_pago == 'CUENTABANCO' ? 'SELECTED' : '') ?>>Cuenta Banco</option>
		        	</select>
		        </div>-->
	        	
	        </div>
	    </div>
    </div>
	<script>
		function limpiar_cab(){
			document.getElementById('ruc').value = "";
			document.getElementById('razon').value = "";
			document.getElementById('nroDoc').value = "";
			document.getElementById('ruc').value = "";
			document.getElementById('fec_emi_doc').value = "";
			document.getElementById('fec_venc_doc').value = "";
			//document.getElementById('motivo').value = "provision";
			document.getElementById('cargo_servicio').value = "";
			document.getElementById('costo').value = "0";
			document.getElementById('costo_tienda').value = "";
			document.getElementById('costo_banco').value = "";
		}

		function limpiar_det(){
			document.getElementById('productos').value 	= "";
			document.getElementById('cantidad').value 	= "";
			document.getElementById('costo').value 		= "";
		}

		function obtener_ruc(obj){
			console.log("en obtener_ruc:" + obj.value)
			var parametros = {
				razon:obj.value
			}
			$.ajax({
				data 	: parametros,
				url 	: '<?= base_url('inventario/obtener_ruc') ?>',
				type	: 'post',
				success : function(response){
					document.getElementById("ruc").value = response
				}
			})
			
		}
	</script>

    <div class="row" style="border-style:solid; border-color:gray; border-width: 1px; margin:5px 20px 5px 20px; padding:4px 0px;">
        <div class="col-sm-12 col-12">

        	<div class="row" style="margin:8px;">
	        	
	        	<div class="col-sm-3" style="margin:0px;">
					<div class="form-group">
		        		<label for="">Producto</label>
	        			<?= $this->inventario_model->combo_producto() ?>
	        		</div>
	        	</div>

	        	<div class="col-sm-2" style="margin:0px 0px; padding:0px 10px;">
	        		<div class="form-group">
		        		<label for="cantidad">Cantidad:</label>
	        			<input type="text" name="cantidad" id="cantidad" class="form-control" size="5" placeholder="">
	        		</div>
	        	</div>
	        

				<div class="col-sm-2" style="margin:0px;padding:0px 15px;">
		        	<div class="form-group">
						<label for="costo">Costo:</label>		        		
		        		<input type="text" name="costo" id="costo" class="form-control" size="8" value="">
		        	</div>
		        </div>

				<div class="col-sm-1" style="padding-top:17px;">
					<button type="button" class="btn btn-alert btn-sm" onclick="magregar_detalle()">Agregar</button>
				</div>

				<div class="col-sm-4" style="padding-top:15px; font-size:14px; margin:0px;">
    				
    			</div>
			</div>

        </div>

        <!--<div class="col-sm-12" id="pizarra1" style="font-size:14px; margin:10px;">
    	</div>-->

    </div>

    <!-- SE VISUALIZA DETALLE DE ULTIMOS MOVIMIENTOS -->
    <div id="pizarra2" class="row" style="border-style:solid; border-color:gray; border-width: 1px; margin:5px 20px 20px 20px; padding:1px 10px 10px 10px;">
    	<?php 
    		/*
    		if(strlen($token1)>0){
    			$arr = array();
    			$arr["result"] = $this->inventario_model->carga_detalle($token1);
    			$this->load->view("inventario/detalle", $arr);
    		}*/
    	?>
    </div>

    <div class="row" style="border-style:solid; border-color:gray; border-width: 1px; margin:5px 20px 5px 20px; padding:2px 2px 2px 10px;">

        <div class="col-sm-4 col-md-6" id="pizarra1" style="font-size:16px; text-align: right; margin:20px 0px;">
    		Forma de Pago:	
    	</div>

        <div class="col-sm-4 col-md-2">
     		<label for="costo_tienda">Subtotal (CajaTienda)</label>
       		<input type="text" name="costo_tienda" id="costo_tienda" class="form-control" size="8" value="<?= $costo_tienda ?>">
       	</div>
		<div class="col-sm-4 col-md-2">       	
			<label for="costo_banco">Subtotal (CajaBanco)</label>
		    <input type="text" name="costo_banco" id="costo_banco" class="form-control" size="8" value="<?= $costo_banco ?>">        	
        </div>
        <div class="col-sm-4 col-md-2">
        	<label for="costo_banco">&nbsp;</label><br>
        	<button type="button" class="btn btn-success" onclick="grabar_inventario()">&nbsp;Grabar&nbsp;</button>
        </div>
    		
    </div>

</div>
<input type="hidden" name="txt_subtotal" id="txt_subtotal">
<script type="text/javascript">
	function autocomplete(inp, arr) {
	  /*the autocomplete function takes two arguments,
	  the text field element and an array of possible autocompleted values:*/
	  var currentFocus;
	  /*execute a function when someone writes in the text field:*/
	  inp.addEventListener("input", function(e) {
	      var a, b, i, val = this.value;
	      /*close any already open lists of autocompleted values*/
	      closeAllLists();
	      if (!val) { return false;}
	      currentFocus = -1;

	      /*create a DIV element that will contain the items (values):*/
	      a = document.createElement("DIV");
	      a.setAttribute("id", this.id + "autocomplete-list");
	      a.setAttribute("class", "autocomplete-items");
	      /*append the DIV element as a child of the autocomplete container:*/
	      this.parentNode.appendChild(a);
	      /*for each item in the array...*/
	      for (i = 0; i < arr.length; i++) {
	        /*check if the item starts with the same letters as the text field value:*/
	        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
	          /*create a DIV element for each matching element:*/
	          b = document.createElement("DIV");
	          /*make the matching letters bold:*/
	          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
	          b.innerHTML += arr[i].substr(val.length);
	          /*insert a input field that will hold the current array item's value:*/
	          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
	          /*execute a function when someone clicks on the item value (DIV element):*/
	          b.addEventListener("click", function(e) {
	              /*insert the value for the autocomplete text field:*/
	              inp.value = this.getElementsByTagName("input")[0].value;
	              /*close the list of autocompleted values,
	              (or any other open lists of autocompleted values:*/
	              closeAllLists();
	          });
	          a.appendChild(b);
	        }
	      }
	  });
	  /*execute a function presses a key on the keyboard:*/
	  inp.addEventListener("keydown", function(e) {
	      var x = document.getElementById(this.id + "autocomplete-list");
	      if (x) x = x.getElementsByTagName("div");
	      if (e.keyCode == 40) {
	        /*If the arrow DOWN key is pressed,
	        increase the currentFocus variable:*/
	        currentFocus++;
	        /*and and make the current item more visible:*/
	        addActive(x);
	      } else if (e.keyCode == 38) { //up
	        /*If the arrow UP key is pressed,
	        decrease the currentFocus variable:*/
	        currentFocus--;
	        /*and and make the current item more visible:*/
	        addActive(x);
	      } else if (e.keyCode == 13) {
	        /*If the ENTER key is pressed, prevent the form from being submitted,*/
	        e.preventDefault();
	        if (currentFocus > -1) {
	          /*and simulate a click on the "active" item:*/
	          if (x) x[currentFocus].click();
	        }
	      }
	  });
	  function addActive(x) {
	    /*a function to classify an item as "active":*/
	    if (!x) return false;
	    /*start by removing the "active" class on all items:*/
	    removeActive(x);
	    if (currentFocus >= x.length) currentFocus = 0;
	    if (currentFocus < 0) currentFocus = (x.length - 1);
	    /*add class "autocomplete-active":*/
	    x[currentFocus].classList.add("autocomplete-active");
	  }
	  function removeActive(x) {
	    /*a function to remove the "active" class from all autocomplete items:*/
	    for (var i = 0; i < x.length; i++) {
	      x[i].classList.remove("autocomplete-active");
	    }
	  }
	  function closeAllLists(elmnt) {
	    /*close all autocomplete lists in the document, except the one passed as an argument:*/
	    var x = document.getElementsByClassName("autocomplete-items");
	    for (var i = 0; i < x.length; i++) {
	      if (elmnt != x[i] && elmnt != inp) {
	        x[i].parentNode.removeChild(x[i]);
	      }
	    }
	  }
	  /*execute a function when someone clicks in the document:*/
	  document.addEventListener("click", function (e) {
	      closeAllLists(e.target);
	  });
	}

	/*An array containing all the country names in the world:*/
	var countries = [<?= $this->inventario_model->razon(); ?>];

	/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
	autocomplete(document.getElementById("razon"), countries);
	
</script>

