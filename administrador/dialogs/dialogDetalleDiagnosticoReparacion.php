<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
$id = trim($_POST['id']);
$base = new mySQLData();
$result = $base->consulta("SELECT id_equipo,nombre_tipo_danio,descrip_diagnostico_danio,descrip_reparacion_equipo,estado_reparacion
        FROM diagnostico_danios,tipos_danios,reparaciones_equipos
        WHERE reparaciones_equipos.id_diagnostico_danio=diagnostico_danios.id_diagnostico_danio
        AND diagnostico_danios.id_tipo_danio=tipos_danios.id_tipo_danio
        AND diagnostico_danios.id_diagnostico_danio='$id'");
$row = mysql_fetch_array($result);
?>
<script>
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
    function imprimir1() {
        $('.print-section1').printArea({mode: "popup", popWd: 700});
    } 
    $('.btn-regresar').click(function() {
        $('.ui-dialog-titlebar-close').click();
    })
</script>
<style>
    td{
        padding: 10px 2px;
    }
    span{
        font-weight: bold;
    }
</style>
<div id="dialog-modal">
    <h2 class="print-section1">Detalle Diagnóstico y Reparación de Equipo</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <button type="button" id="btnImprimir" class="btn btn-default paginate_button_disabled" onclick="imprimir1()">
        <span class="glyphicon glyphicon-print"></span> Imprimir</button>
    <!--formulario con los controles-->
    <div class="print-section1">
        <table>
            <thead>
                <tr>
                    <th style="width: 175px"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span>Equipo</span>
                    </td>
                    <td>
                        <?php echo $row[0]; ?>
                    </td>
                </tr>
                <tr>                
                    <td>
                        <span>Tipo Daño</span>
                    </td>
                    <td>
                        <?php echo $row[1]; ?>
                    </td>
                </tr>
                <tr>  
                    <td style="vertical-align: top">
                        <span>Descripción Diagnóstico</span>
                    </td>
                    <td>
                        <?php echo $row[2]; ?>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top">
                        <span>Descripción Reparación</span>
                    </td>
                    <td>
                        <?php echo $row[3]; ?>                   
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Estado Reparación</span>
                    </td>
                    <td>
                        <?php echo $row[4]; ?>
                    </td>                
                </tr>
            </tbody>
        </table>
    </div>
</div>

