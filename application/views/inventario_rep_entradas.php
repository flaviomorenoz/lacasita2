<style type="text/css">
	.tandem{
		margin-left:10px;
		font-size:8px;
	}

	table, th, td{ 
		border: 0.5px solid rgb(130,130,130); 
		border-collapse: collapse; 
		background-color: rgb(240,240,230);
	}

	th{
		border: 0.5px solid rgb(130,130,130); 
		border-collapse: collapse; 
		background-color: rgb(250,150,0);
	}

</style>

<script>
	function reporte(){
		var parametros = {
			desde:document.getElementById('desde').value,
			hasta:document.getElementById('hasta').value,
			orden:document.getElementById('sel_orden').value
		}
		$.ajax({
			data 	: parametros,
			url 	: '<?= base_url('inventario/rep_entradas') ?>',
			type	: 'post',
			success : function(response){
				document.getElementById("pizarra1").innerHTML = response
			}
		})
	}

	function ver(token1,nroDoc1){ // Muestra el detalle del Documento
		let parametros = {
			desde :document.getElementById('desde').value,
			hasta :document.getElementById('hasta').value,
			orden :document.getElementById('sel_orden').value,
			token : token1,
			opcion: 2,
			nroDoc: nroDoc1
		}
		$.ajax({
			data 	: parametros,
			url 	: '<?= base_url('inventario/rep_entradas') ?>',
			type 	: 'post',
			success : function(response){
				console.log("en regreso del detalle")
				//console.log(response)
				let ar = JSON.parse(response)
				document.getElementById("myModalLabel").innerHTML		= ar[2]
				document.getElementById("pizarra_detalle").innerHTML 	= ar[1]
				document.getElementById("botoncito").click()
			}
		})
	}
</script>
<div id="page-wrapper">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
	      </div>
	      <div id="pizarra_detalle" class="modal-body">
	        ...
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
	      </div>
	    </div>
	  </div>
	</div>

	<?php
	$fecha_actual 	= date("Y-m-d");
	$fecha_desde 	= date("Y-m-d",strtotime($fecha_actual."- 1 days")); 
	?>
    <div class="row" style="margin-top:15px">
        <div class="col-xs-6 col-sm-3">
			desde:<input type="date" name="desde" id="desde" class="form-control" value="<?= $fecha_desde ?>">
		</div>

		<div class="col-xs-6 col-sm-3">
			hasta:<input type="date" name="hasta" id="hasta" class="form-control" value="<?= $fecha_actual ?>">
		</div>

		<div class="col-xs-6 col-sm-3">
			Ordenado por:
			<select id="sel_orden" name="sel_orden" class="form-control">
				<option value="a.fechaMov">Fecha de Registro</option>
				<option value="a.fec_emi_doc">Fecha de Emision</option>
				<option value="a.fec_venc_doc">Fecha de Vencimiento</option>
				<option value="a.accionMov">Accion</option>
				<option value="a.ruc">Ruc</option>
				<option value="a.razon">Razon Social</option>
				<option value="a.tipoDoc">Tipo Doc</option>
				<option value="a.nroDoc">Nro Doc</option>
				<option value="a.idAlm">Almacen</option>
				<option value="a.cargo_servicio">Cargo Servicio</option>
				<option value="total">Total</option>
				<option value="a.token">Token</option>
			</select>
		</div>
		
		<div class="col-xs-6 col-sm-3">
			<br><button class="btn btn-success" onclick="reporte()">Aceptar</button>
		</div>

	</div><!-- fin de row -->
<!--
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<table class="table-condensed" border="0">
				<tr>
-->
<?php
/*
					$cEstilo_cab 	= "text-align:center";					
					echo $this->fm->celda_h("Ruc-Razon",1,$cEstilo_cab);
					echo $this->fm->celda_h("Documento",1,$cEstilo_cab);
					echo $this->fm->celda_h("Fec. Registro",1,$cEstilo_cab); 
					echo $this->fm->celda_h("Tipo Doc",1,$cEstilo_cab);
					echo $this->fm->celda_h("Emision",1,$cEstilo_cab);
					echo $this->fm->celda_h("Vcmto.",1,$cEstilo_cab);
					echo $this->fm->celda_h("Forma-P",1,$cEstilo_cab);
					echo $this->fm->celda_h("Items",1,$cEstilo_cab);
					echo $this->fm->celda_h("Total",1,$cEstilo_cab);
					echo $this->fm->celda_h(".",1,$cEstilo_cab);
*/
?>
<!--				</tr>
				<td>
					<th><input type="text" name="ruc_razon" id="ruc_razon"></th>
					<th><input type="text" name="documento" id="documento"></th>
					<th><input type="text" name="fec_registro" id="fec_registro"></th>
					<th><input type="text" name="tipo_doc" id="tipo_doc"></th>
					<th><input type="text" name="fec_emi_doc" id="fec_emi_doc"></th>
					<th><input type="text" name="fec_venc_doc" id="fec_venc_doc"></th>
					<th><input type="text" name="" id=""></th>
					<th><input type="text" name="" id=""></th>
					<th><input type="text" name="" id=""></th>
				</td>
			</table>
		</div>
	</div>
-->
	<div class="row">
		<div id="pizarra1" class="col-xs-12 col-sm-12">

		</div>
	</div>
</div>
<span id="botoncito" data-toggle="modal" data-target="#myModal">
  .
</span>