<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
$id = trim($_POST['id']);
$base = new mySQLData();
$result = $base->consulta("SELECT nombre_sucursal,nombre_pais,nombre_cliente,tipo_soporte,fecha_inicio_soporte,
                    hora_inicio_soporte,fecha_fin_soporte,hora_fin_soporte,nombre_problema,diagnostico_soporte,
                    descrip_accion_soporte,prioridad_soporte,estado_soporte
                    FROM soportes,sucursales,clientes,paises,problemas
                    WHERE soportes.id_sucursal=sucursales.id_sucursal
                    AND soportes.id_problema=problemas.id_problema
                    AND sucursales.id_cliente=clientes.id_cliente
                    AND clientes.id_pais=paises.id_pais
                    AND clientes.id_cliente=sucursales.id_cliente
                    AND id_soporte='$id'");
$row = mysql_fetch_array($result);
?>
<style>
    span{
        font-weight: bold;
    }
</style>
<script type="text/javascript">
    $('.btn-regresar').click(function() {
        $('.ui-dialog-titlebar-close').click();
    });
    $(function() {
        $("#dialog-modal").dialog({
            close: function() {
                $(this).remove()
            },
            position: 'center',
            modal: true,
            height: 450,
            width: 600

        });
    });
</script>
<div id="dialog-modal">
    <h2 style="float:left" >Detalle Soporte Técnico</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right;margin-top: 25px;">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <?php $id ?>
    <!--formulario con los controles-->
    <!--***cada contenedor form-group es un control***-->        
    <table>
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
                <td style="width: 200px; padding: 10px 2px">
                    <span>Nombre Sucursal</span>                      
                </td>
                <td>
                    <?php echo $row[0]; ?>
                </td>
            </tr>
            <tr>
                <td style="width: 200px; padding: 10px 2px">
                    <span>Nombre Pais</span>                      
                </td>
                <td>
                    <?php echo $row[1]; ?>
                </td>
            </tr>
            <tr>
                <td style="width: 200px; padding: 10px 2px">
                    <span>Nombre Cliente</span>                      
                </td>
                <td>
                    <?php echo $row[2]; ?>
                </td>
            </tr>
            <tr>
                <td style="width: 200px; padding: 10px 2px">
                    <span>Tipo Soporte</span>                      
                </td>
                <td>
                    <?php echo $row[3]; ?>
                </td>
            </tr>
            <tr>
                <td style="width: 200px; padding: 10px 2px">
                    <span>Fecha / Hora Inicio Soporte</span>                      
                </td>
                <td>
                    <?php echo $row[4] . ' - ' . $row[5]; ?>
                </td>
            </tr>
            <tr>
                <td style="width: 200px; padding: 10px 2px">
                    <span>Fecha / Hora Fin Soporte</span>                      
                </td>
                <td>
                    <?php echo $row[6] . ' - ' . $row[7]; ?>
                </td>
            </tr>
            <tr>
                <td style="width: 200px; padding: 10px 2px">
                    <span>Problema</span>                      
                </td>
                <td>
                    <?php echo $row[8]; ?>
                </td>
            </tr>
             <tr>
                <td style="width: 200px; padding: 10px 2px">
                    <span>Diagnóstico</span>                      
                </td>
                <td>
                    <?php echo $row[9]; ?>
                </td>
            </tr>
             <tr>
                <td style="width: 200px; padding: 10px 2px">
                    <span>Descripción</span>                      
                </td>
                <td>
                    <?php echo $row[10]; ?>
                </td>
            </tr>
             <tr>
                <td style="width: 200px; padding: 10px 2px">
                    <span>Prioridad</span>                      
                </td>
                <td>
                    <?php echo $row[11]; ?>
                </td>
            </tr>
             <tr>
                <td style="width: 200px; padding: 10px 2px">
                    <span>Estado</span>                      
                </td>
                <td>
                    <?php echo $row[12]; ?>
                </td>
            </tr>
        </tbody>
    </table>



