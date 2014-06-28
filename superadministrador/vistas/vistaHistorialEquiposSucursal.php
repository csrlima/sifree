<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
//paso de id
$id = trim($_POST['id']);
echo "<script>id='$id'</script>";
?>
<script type="text/javascript">
    //apertura del dialog
    $("#dialog-modal").dialog({
        close: function() {
            $(this).remove()
        },
        modal: true,
        //tamanio del dialog
        height: 400,
        width: 800
    });
    //aplica el plugin de datatables a la tabla
    $('#table2').dataTable({
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10
    });
    //funcion de generacion de reportes
    function imprimir3() {
        $('.print-section3').printArea({mode: "popup", popWd: 700});
    }
    //cerrado del dialog por medio del boton regresar
    $('.btn-regresar').click(function() {
        $('.ui-dialog-titlebar-close').click();
    })
</script>

<!--contenedor del dialog-->
<div id="dialog-modal">
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <!--formulario con los controles-->
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <!--***cada contenedor form-group es un control***-->
        <div class="container-top"> 
            <div class="print-section">
                <!--area imprimible-->
                <h2 class="print-section3">Vista de Historial de Equipo en Sucursales</h2> 
            </div>

            <!--botonera de opciones-->
            <button type="button" id="btnImprimir" class="btn btn-default paginate_button_disabled" onclick="imprimir3()">
                <span class="glyphicon glyphicon-print"></span> Imprimir</button>
        </div>
        <hr>
        <div>
            <div style="padding-bottom: 10px" class="print-section3">
                <!--area imprimible-->
                <table id="table2" class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <!--cabecera de tabla-->
                            <th>Cliente</th>
                            <th>Código -- Sucursal</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--generacion del cuerpo de la tabla-->
                        <?php
                        $base = new mySQLData();
                        $result = $base->consulta("SELECT nombre_cliente,codigo_sucursal,nombre_sucursal,fecha_inicio,fecha_fin
                    FROM sucursales,clientes,historial_equipos_sucursales
                    WHERE clientes.id_cliente=sucursales.id_cliente
                    AND historial_equipos_sucursales.id_sucursal=sucursales.id_sucursal
                    AND id_equipo='$id'");
                        while ($row = mysql_fetch_array($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row[0]; ?></td>
                                <td><?php echo $row[1] . ' -- ' . $row[2]; ?></td>  
                                <td><?php echo $row[3]; ?></td>
                                <td>
                                    <?php
                                    if ($row[4] == '0000-00-00') {
                                        echo 'Actualidad';
                                    } else {
                                        echo $row[4];
                                    }
                                    ?>
                                </td>
                            </tr>  
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
