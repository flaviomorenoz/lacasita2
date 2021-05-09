<?php
//die("llego aqui sp");
$this->load->model("usuario_model");
?>
<style>
  .dropbtn {
    background-color: transparent;
    color: white;
    padding: 8px;
    font-size: 16px;
    border: none;
    cursor: pointer;
  }

  .dropbtn:hover, .dropbtn:focus {
    background-color: transparent;
  }

  .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 6px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown a:hover {background-color: #ddd;}

  .show {display: block;}

  .iconos{
    font-size:16px;
  }
</style>
<section class="navbar-side" style="background-color: rgb(250,150,0); 
    border-style: solid; 
    border-width: 4px; 
    border-color:rgb(250,250,250); 
    border-radius: 10px; 
    margin-top: 10px;
    text-align:left;">
   <ul class="nav crunchy-navigation sidebar-menu" style="margin-left:10px;">
   
      <!--DASHBOARD-->
      <li><a class="fuerte" href="<?= base_url("inventario/agregar_producto"); ?>" title="Ver Productos">
            <!--<i class="fa fa-dashboard fa-1x"></i>-->
            <span class="glyphicon glyphicon-wrench iconos"></span>
            &nbsp;&nbsp;Productos
         </a>
         
      </li>

      <li>
        <div class="fuerte" style="padding-left: 15px">
          <!--<i class="fa fa-dashboard fa-1x"></i>-->
          <span class="glyphicon glyphicon-briefcase iconos"></span>
          <button onclick="myFunction2()" class="dropbtn" style="color:rgb(60,60,60);font-weight: bold; font-size:14px">Compras</button>
          <div id="myDropdown2" class="dropdown-content">
            <a href="<?= base_url("inventario/agregar"); ?>">Agregar</a>
            <a href="<?= base_url("inventario/mostrar_movimientos"); ?>">Modificar</a>
          </div>
        </div>
      </li>

      <li>
         <div class="fuerte" style="padding-left: 15px">
           <!--<i class="fa fa-dashboard fa-1x"></i>-->
           <span class="glyphicon glyphicon-book iconos"></span>
           <button onclick="myFunction()" class="dropbtn" style="color:rgb(60,60,60);font-weight: bold; font-size:14px">Reportes</button>
           <div id="myDropdown" class="dropdown-content">
             <a href="<?= base_url("inventario/rep_entradas"); ?>">Compras</a>
             <a href="<?= base_url("inventario/rep_productos"); ?>">Productos</a>
             <a href="<?= base_url("inventario/rep_recetas"); ?>">Recetas</a>
           </div>
         </div>
      </li>
      
      <li><a class="fuerte" href="<?= base_url("inventario/stock"); ?>">
         <!--<i class="fa fa-dashboard fa-1x"></i>-->
        <span class="glyphicon glyphicon-dashboard iconos"></span>
          &nbsp;&nbsp;Stock Actual
        </a>
      </li>
      
      <li>
        <a class="fuerte" href="<?= base_url("proveedor/agregar_proveedor"); ?>" title="Ver Proveedores">
          <!--<i class="fa fa-dashboard fa-1x"></i>-->
          <span class="glyphicon glyphicon-user iconos"></span>
          &nbsp;&nbsp;Proveedores
        </a>
      </li>

      <li>
        <a class="fuerte" href="<?= base_url("inventario/salir"); ?>" title="Ver Recetas">
          <!--<i class="fa fa-dashboard fa-1x"></i>-->
          <span class="glyphicon glyphicon-log-out iconos"></span>
          &nbsp;&nbsp;Salir
         </a>
      </li>

      <li><a class="fuerte" href="<?= base_url("inventario/prueba"); ?>" title="">
           &nbsp;&nbsp;.
         </a>
      </li>

   </ul>
</section>
<script src="<?php echo JS_ADMIN_SIDEBAR_MENU;?>"></script>
<script>
   $.sidebarMenu($('.sidebar-menu'))

   /* When the user clicks on the button, 
   toggle between hiding and showing the dropdown content */
   function myFunction() {
     document.getElementById("myDropdown").classList.toggle("show");
   }

   function myFunction2() {
     document.getElementById("myDropdown2").classList.toggle("show");
   }

   // Close the dropdown if the user clicks outside of it
   window.onclick = function(event) {
     if (!event.target.matches('.dropbtn')) {
       var dropdowns = document.getElementsByClassName("dropdown-content");
       var i;
       for (i = 0; i < dropdowns.length; i++) {
         var openDropdown = dropdowns[i];
         if (openDropdown.classList.contains('show')) {
           openDropdown.classList.remove('show');
         }
       }
     }
   }
</script>