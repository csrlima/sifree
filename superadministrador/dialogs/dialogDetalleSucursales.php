<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
$id = trim($_POST['id']);
$base = new mySQLData();
$result = $base->consulta("SELECT `nombre_cliente`,`codigo_sucursal`,`mac_hfc_codigo_t`,`nombre_sucursal`,`encargado_sucursal`,`direccion_sucursal`,
                    `telefono_sucursal`,`celular_sucursal`,`estado_sucursal`,`nombre_proveedor_internet`
                    FROM `sucursales`,`clientes`,proveedores_internet
                    WHERE clientes.id_cliente=sucursales.id_cliente
                    AND sucursales.id_proveedor_internet=proveedores_internet.id_proveedor_internet
                    AND id_sucursal='$id'");
$row = mysql_fetch_array($result);
?>
<script type="text/javascript">
    $('.btn-regresar').click(function(){
        $('.ui-dialog-titlebar-close').click();
    })
</script>



<script>
    $(function() {
        $( "#dialog-modal" ).dialog({
            close: function () { $(this).remove() },
            position: 'center',
            modal: true,
            height: 450,
            width: 700

        });
    });
</script>
<div id="dialog-modal">
    <h2 style="float:left" >Detalle Sucursal <?php echo $row[3]; ?></h2>
        <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right;margin-top: 25px;">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
        <div style="clear: both"></div>
    <!--formulario con los controles-->
        <!--***cada contenedor form-group es un control***-->        
    
        <table style="display: inline-block">
            <thead>
            <tr>
                <th>
                    
                </th>
                <th>
                    
                </th>          
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 150px; padding: 5px 2px">
                        <label for="txtCliente">Cliente Sucursal</label>                      
                    </td>
                    <td>
                             <?php echo $row[0]; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px 2px">
                       <label for="txtCodigo">Código Sucursal</label>                        
                    </td>                
                    <td>
                       <?php echo $row[1]; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px 2px">
                       <label for="txtNombre" >Nombre Sucursal</label>                     
                    </td>
                    <td>
                  <?php echo $row[3]; ?>
                    </td>
                </tr>                
                <tr>
                    <td style="padding: 5px 2px">
                       <label for="txtNombre" >Código de Enlace</label>                     
                    </td>
                    <td>
                  <?php echo $row[2]; ?>
                    </td>
                </tr> 
                <tr>
                    <td style="padding: 5px 2px">
                       <label for="txtTelefono" >Proveedor Sucursal</label>                      
                    </td>
                    <td>
                       <?php echo $row[9]; ?>
                    </td>
                </tr>                
                <tr>
                    <td style="padding: 5px 2px">
                       <label for="txtEncargado" >Encargado Sucursal</label>                     
                    </td>
                    <td>
                       <?php echo $row[4]; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px 2px; vertical-align: top">
                       <label for="txtDireccion" >Dirección Sucursal</label>                     
                    </td>
                    <td style="max-width: 225px">
                        <?php echo $row[5]; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px 2px">
                       <label for="txtCodigo">Telefono  Sucursal</label> 
                       
                    </td>
                    <td>
                        <?php echo $row[6]; ?>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px 2px">
                       <label for="txtEstado" >Celular Sucursal</label>                      
                    </td>
                    <td>
                        <?php echo $row[7]; ?>
                    </td>
                </tr>                
                <tr>
                    <td style="padding: 5px 2px">
                       <label for="txtEstado" >Estado Sucursal</label>                      
                    </td>
                    <td>
                        <?php echo $row[8]; ?>
                    </td>
                </tr>
            </tbody>
            </table>
         <ul style="display: inline-block; vertical-align: top; margin-top: 28px; list-style: none">
            <li><b>Equipos Instalados</b></li>
              <?php
                $result2 = $base->consulta("SELECT equipos.id_equipo,nombre_marca,nombre_modelo
                                FROM equipos,marcas,modelos,det_equipos_sucursales
                                WHERE equipos.id_modelo=modelos.id_modelo 
                                AND marcas.id_marca=modelos.id_marca
                                AND det_equipos_sucursales.id_equipo=equipos.id_equipo                            
                                AND actividad_equipo='Instalado' 
                                AND id_sucursal='$id'");
                while ($row2 = mysql_fetch_array($result2)) {
                    ?>
                        <li><?php echo $row2[0] .' -- '.$row2[1] .' -- '.$row2[2]; ?></li>
                    <?php
                }
                ?>
        </ul>                       
</div>
