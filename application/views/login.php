<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
		<link href="<?php echo CSS_FRONT_MAIN;?>" rel="stylesheet">
	<link href="<?php echo CSS_CHOSEN_MIN;?>" rel="stylesheet" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/css/font-pizzaro.css" media="all" />
	<link rel="stylesheet" type="text/css" href="assets/css/style.css" media="all" />
	<link rel="stylesheet" type="text/css" href="assets/css/colors/red.css" media="all" />
	<link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.min.css" media="all" />
	<!-- Demo Purpose Only. Should be removed in production -->
	<link rel="stylesheet" href="assets/css/config.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CYanone+Kaffeesatz:200,300,400,700" rel="stylesheet" />

	<!-- <script type="text/javascript" src="assets/js/jquery.min.js"></script> -->
   	<!-- PNOTIFY CSS-->
    <link href="<?php echo PNOTIFY_ALL_CSS;?>" rel="stylesheet" />
    <script src="<?php echo JS_FRONT_JQUERY_MIN;?>"></script>
    <style type="text/css">
    	body{
    		background-color: rgb(250,180,50);
    	}
    </style>
</head>
<body>
<script type="text/javascript">
	function activacion(){
		if (document.getElementById("usuario").value == "admin"){
			document.getElementById("el_almacen").style.display = "block"
		}else{
			document.getElementById("el_almacen").style.display = "none"
		}
	}
</script>
<div class="container">
	<!--<div style="border-style:solid; border-width:2px; border-color: gray; display:flex;">-->

	<div class="row" style="display:flex; padding-top:20px;">
		<div class="col-xs-12 col-sm-6" style="border-style: solid; border-color:rgb(255,255,255); margin:auto; border-radius: 15px">

			<form id="form_login" name="form_login" method="post" action="<?= base_url() . "inventario/login" ?>">
			<div class="row" style="display:flex;">

				<div class="col-xs-12 col-sm-8" style="margin:auto;">

					<div id="login1" style="border-style:none; border-color:red; text-align:center; margin:10px;">

						<h2 style="color:rgb(100,100,100)">M&oacutedulo de Inventario</h2>
						Login:<br><input type="text" name="usuario" id="usuario" class="form-control" value=""
						onblur="activacion()">

					</div>

				</div>

			</div>


			<div class="row" style="display:flex;">

				<div class="col-12 col-sm-8" style="margin:auto;">

					<div id="login1" style="text-align:center; margin:10px;">

						Password:<br><input type="password" name="pass" id="pass" class="form-control" value="">

					</div>

				</div>

			</div>


			<div class="row" style="display:flex;">

				<div class="col-12 col-sm-5" style="margin:auto;">

					<div id="el_almacen" style="text-align:center; margin:10px; display:none;">

						<!--Almac&eacute;n:<br><input type="password" name="almacen" id="almacen">-->
						Almacen:<br>
						<?= $this->inventario_model->combo_almacen() ?>
						<input type="hidden" name="desc_almacen" id="desc_almacen">

					</div>

				</div>

			</div>

			<div class="row" style="display:flex;">

				<div class="col-12 col-sm-6" style="margin:auto;">

					<div id="login1" style="text-align:center; margin:10px;">

						<button type="button" class="btn btn-success" onclick="ir()">Aceptar</button>

					</div>

				</div>

			</div>
			</form>

			<script>
				$(document).on('change', '#almacen', function(event) {
			    	$('#desc_almacen').val($("#almacen option:selected").text());
				});

				function ir(){
					//console.log(ss + "," + obj.length)
					//if(document.getElementById('almacen').value != '0'){
						document.getElementById('form_login').submit();
					//}else{
					//	alert("Ingrese Almacen")
					//}
				}
			</script>

			<div class="row" style="display:flex;">

				<div class="col-12 col-sm-6" style="margin:auto;">

					<div id="login1" style="text-align:center; margin:10px;">

						<?php 
						if(isset($message)){
							if(strlen($message)>0){
								echo $message;
							}
						}
						?>

					</div>

				</div>

			</div>

		</div> <!-- columna La Inicial -->
	</div><!-- Fin de fila La Inicial -->

	<div id="div_footer" style="display:flex; padding-top:150px;">
		<table width="100%">
			<td width="33%" style="text-align:center">
				Pol&iacute;ticas y t&eacute;rminos 2021
			</td>
			<td width="33%" style="text-align:center">
				<a href="lacasitadelassalchipapas.com.pe">La casita de las Salchipapas.</a>
			</td>
			<td width="33%" style="text-align:center">Locales: San Miguel, Surquillo, Surco.</td>
		</table>
	</div>
</div>

<script>
	function tamVentana() {
	  var tam = [0, 0];
	  if (typeof window.innerWidth != 'undefined')
	  {
	    tam = [window.innerWidth,window.innerHeight];
	  }
	  else if (typeof document.documentElement != 'undefined'
	      && typeof document.documentElement.clientWidth !=
	      'undefined' && document.documentElement.clientWidth != 0)
	  {
	    tam = [
	        document.documentElement.clientWidth,
	        document.documentElement.clientHeight
	    ];
	  }
	  else   {
	    tam = [
	        document.getElementsByTagName('body')[0].clientWidth,
	        document.getElementsByTagName('body')[0].clientHeight
	    ];
	  }
	  return tam;
	}

	//var tamanito = tamVentana()
	//document.getElementById("div_footer").style.top = (tamanito[1] - 60) + "px"

</script>

<a href="http://localhost/varios/qsystem/lacasita/inventario/stock">Ir a Stock</a>

</body>
</html>