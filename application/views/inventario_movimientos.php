
    <div class="panel panel-default" style="margin:10px">
        <div class="panel-body">
            <form name="form1" method="post" action="<?= base_url("inventario/agregar") ?>">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha<br>Registro</th>
                        <th>Nro. Doc</th>
                        <th>Razon Social</th>
                        <th>Tipo<br>Doc.</th>
                        <th>Fecha<br>Emision</th>
                        <th>fecha<br>Recepcion</th>
                        <th>Forma<br>Pago</th>
                        <th>SubTotal</th>
                        <th>.</th>
                    </tr>
                </thead>
                <tbody id="userData">
                    <?php if(!empty($posts)): foreach($posts as $post): ?>
                    <tr>
                        <!-- a.token, a.fechaMov fechas, a.nroDoc, concat(a.ruc,'-',a.razon) cruc, a.accionMov, 
                        a.tipoDoc, a.fec_emi_doc, a.fec_venc_doc, a.forma_pago, sum(a.costo) total, count(*) cuantos -->
                        <!--<td><?= '#'.$post['token'] ?></td>  -->
                        <td><?= $post['fechaMov'] ?></td>
                        <td><?= $post['nroDoc'] ?></td>
                        <td><?= $post['razon'] ?></td>
                        <td><?= $post['tipoDoc'] ?></td>
                        <td><?= $post['fec_emi_doc'] ?></td>
                        <td><?= $post['fec_venc_doc'] ?></td>
                        <td><?= $post['forma_pago'] ?></td>
                        <td><?= $post['total_sin_igv'] ?></td>
                        <td>
                            <a href="#" id="enlace_corto" onclick="modificar_movimientos('<?= $post['token'] ?>')">
                                <span class="glyphicon glyphicon-edit iconos"></span>
                            </a>&nbsp;&nbsp;
                            <a href='#' id="enlace_corto" onclick="eliminar_movimientos('<?= $post['token'] ?>')">
                                <span class="glyphicon glyphicon-remove iconos"></span>
                            </a>
                        </td>
                        <td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="3">Post(s) not found......</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <input type="hidden" name="token" id="token">
            <input type="hidden" name="OPERACION" id="OPERACION" value="U">
            </form>
        </div>
    </div>
    <!-- render pagination links -->
    <ul class="pagination pull-right">
        <?php echo $this->pagination->create_links(); ?>
    </ul>

<script>
        function eliminar_movimientos(token1){
            //document.getElementById("botoncito").click()
            if(confirm("Confirma que desea eliminar?")){

                var parametros = {
                    token : token1
                }
                $.ajax({
                    data        : parametros,
                    url         : '<?= base_url("inventario/eliminar_movimientos") ?>',
                    type        : 'post',
                    success     : function(response){
                        let ar = JSON.parse(response)
                        console.log(ar['message'])
                        
                        //alert(ar['message'])

                        actualiza_movimientos('<?= $_SESSION['ALMACEN'] ?>')
                    }
                })

            }
        }

        function actualiza_movimientos(idAlm){
            var parametros = {
                idAlm : idAlm
            }
            $.ajax({
                data        : parametros,
                url         : '<?= base_url("inventario/actualiza_movimientos") ?>',
                type        : 'post',
                success     : function(response){
                    console.log("Al fin en actualiza_movimientos")
                    //let ar = JSON.parse(response)
                    //console.log(ar['message'])
                    //alert(ar['message'])

                    document.getElementById('page-wrapper').innerHTML = response
                }
            })
        }

        function modificar_movimientos(token1){
            document.getElementById("token").value = token1
            document.form1.submit()
        }
</script>   