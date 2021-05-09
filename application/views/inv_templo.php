<?php
	$pagetitle = "La Casita de las Salchipapas";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
		<link href="<?php echo CSS_FRONT_MAIN;?>" rel="stylesheet">
	<link href="<?php echo CSS_CHOSEN_MIN;?>" rel="stylesheet" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?= SITEURL ?>assets/css/font-pizzaro.css" media="all" />
	<link rel="stylesheet" type="text/css" href="<?= SITEURL ?>assets/css/style.css" media="all" />
	<link rel="stylesheet" type="text/css" href="<?= SITEURL ?>assets/css/colors/red.css" media="all" />
	<link rel="stylesheet" type="text/css" href="<?= SITEURL ?>assets/css/jquery.mCustomScrollbar.min.css" media="all" />
	<!-- Demo Purpose Only. Should be removed in production -->
	<link rel="stylesheet" href="<?= SITEURL ?>assets/css/config.css" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CYanone+Kaffeesatz:200,300,400,700" rel="stylesheet" />

	<!-- <script type="text/javascript" src="assets/js/jquery.min.js"></script> -->
   	<!-- PNOTIFY CSS-->
    <link href="<?php echo PNOTIFY_ALL_CSS;?>" rel="stylesheet" />
    <script src="<?php echo JS_FRONT_JQUERY_MIN;?>"></script>
    <script src="<?php echo SITEURL; ?>assets/front/js/bootstrap.js"></script>

	<style type="text/css">
		body{
			background-color:#FFD68A;
			font-size:10px;
		}
		table{
			font-size:12px;
		}
		.fuerte{
			font-size:14px;
			color:rgb(60,60,60);
			font-weight: bold;
		}
		.espaciado{
			margin-bottom:7px;
		}

		#enlace_corto{
			color : rgb(100,150,230);
			font-weight : bold;
			text-decoration : underline;
		}

		
	</style>
</head>

<body>

	<div class="row" style="display:flex; background-color: rgb(250,150,0);">
		
		<div class="col-sm-3" style="border-style: none; margin:auto;">
			<div style="text-align: center; font-size: 14px; font-weight: bold">
				<?= date("d-m-Y") ?>
			</div>
		</div>
		<div class="col-sm-6" style="border-style: none; margin:auto;">
			<div style="text-align: center; font-size: 18px; font-weight: bold">
				Registro de Compras
			</div>
			<!--<h3 style="font-weight:bold; color:rgb(90,90,90); text-align: center;border-style: solid;">
				Registro de Compras
			</h3>-->
		</div>
		<div class="col-sm-1" style="border-style: none; margin:auto;">
			<br><img src="<?= base_url("images/logo.png") ?>" style="height:55px">
		</div>
		<div class="col-sm-2" style="border-style: none; margin:auto;">
			<div style="text-align: center; font-size: 14px; font-weight: bold">
			<?php
			if(isset($_SESSION["USUARIO"])){
				echo "<STRONG>".$_SESSION["USUARIO"]."<br>".$_SESSION["DESC_ALMACEN"]."</STRONG>";
			}
			?>
			</div>
		</div>
	</div>

	<div class="row" style="margin-left: -10px;">
		<div class="col-xs-12 col-sm-2">
			<?php 
				$this->load->view('inv_navigation'); 
			?>
		</div>
		<div class="col-xs-12 col-sm-10">
			<div id="page-wrapper" class="bg-silver">

				<?php 
					$this->load->view($content); 
				?>
				
			</div>
		</div>
	</div>

</body>
</html>
