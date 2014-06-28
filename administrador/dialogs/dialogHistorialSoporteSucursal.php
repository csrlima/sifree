<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
$id = trim($_POST['id']);
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
            width: 750

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
    <h2 class="print-section1">Historial de Soporte en Sucursal</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <button type="button" id="btnImprimir" class="btn btn-default paginate_button_disabled" onclick="imprimir1()">
        <span class="glyphicon glyphicon-print"></span> Imprimir</button>
    <!--formulario con los controles-->
        <hr>
        <div>
            <div style="padding-bottom: 10px" class="print-section3">
                <!--area imprimible-->
                <table id="table2" class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <!--cabecera de tabla-->
                            <th>Tipo Soporte</th>
                            <th>Problema</th>
                            <th>Diagnóstico</th>
                            <th>Acciones</th>
                            <th style="width: 80px">Fecha Hora</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <!--generacion del cuerpo de la tabla-->
                        <?php
                        $base = new mySQLData();
                        $result = $base->consulta("SELECT tipo_soporte,nombre_problema,diagnostico_soporte,descrip_accion_soporte,fecha_inicio_soporte,hora_inicio_soporte
                    FROM soportes,problemas
                    WHERE problemas.id_problema=soportes.id_problema AND id_sucursal='$id'");
                        while ($row = mysql_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row[0]; ?></td>
                                <td><?php echo $row[1];?></td>  
                                <td><?php echo $row[2]; ?></td>
                                <td><?php echo $row[3]; ?></td>
                                <td><?php echo $row[4]. ' ' . $row[5]; ; ?></td>                                
                            </tr>  
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>

