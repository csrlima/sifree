<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
date_default_timezone_set("America/El_Salvador");
$base = new mySQLData();
$fecha = mysql_real_escape_string(trim($_POST["fecha"]));
$fecha2 = mysql_real_escape_string(trim($_POST["fecha2"]));
if ($fecha == '') {
    $fecha = date("Y-m-d");
    $fecha2 = date("Y-m-d");
}
?>
<script>
    var mUsuarios = [];
    var mLlamadas = [];
    var mVisitas = [];
    $('#txtFecha').val('<?php echo $fecha; ?>');
    $('#txtFecha2').val('<?php echo $fecha2; ?>');
</script>
<?php
//********CONSULTA A LA BASE DE DATOS Y LLENADO DE LAS MATRICES CON LA DATA Y LA FECHA*******//
$ssql = "SELECT id_usuario,nombre_usuario FROM usuarios ORDER BY nombre_usuario";
$result = $base->consulta($ssql);
while ($row = mysql_fetch_array($result)) {
    ?>
    <script>
        mUsuarios.push('<?php echo $row[1]; ?>');
    </script> 
    <?php
    $result1 = $base->consulta("SELECT COUNT(id_soporte) FROM soportes
        WHERE fecha_inicio_soporte BETWEEN '$fecha' AND '$fecha2'
        AND tipo_soporte='Llamada' AND id_usuario=$row[0]");
    $row1 = mysql_fetch_array($result1);
    ?>
    <script>
        mLlamadas.push(parseFloat('<?php echo $row1[0]; ?>'));
    </script> 
    <?php
    $result2 = $base->consulta("SELECT COUNT(id_soporte) FROM soportes
     WHERE fecha_inicio_soporte BETWEEN '$fecha' AND '$fecha2'
    AND tipo_soporte='Visita' AND id_usuario=$row[0]");
    $row2 = mysql_fetch_array($result2);
    ?>
    <script>
        mVisitas.push(parseFloat('<?php echo $row2[0]; ?>'));
    </script> 
    <?php
}
?>
<script src="highcharts/js/modules/exporting.js"></script>
<script type="text/javascript">

        $(function() {
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Soportes Atendidos'
                },
                subtitle: {
                    text: 'SIFree Market Beat'
                },
                xAxis: {
                    categories: mUsuarios,
                    labels: {
                        rotation: -45,
                        align: 'right',
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Cantidad de Soportes'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} Soportes</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                        name: 'Llamadas',
                        data: mLlamadas

                    }, {
                        name: 'Visitas',
                        data: mVisitas
                    }]
            });
        });
        $(function() {
            $("#txtFecha").datepicker({
                dateFormat: 'yy-mm-dd',
                onClose: function(selectedDate) {
                    $("#txtFecha2").datepicker("option", "minDate", selectedDate);
                }
            });
            $("#txtFecha2").datepicker({
                dateFormat: 'yy-mm-dd',
                onClose: function(selectedDate) {
                    $("#txtFecha").datepicker("option", "maxDate", selectedDate);
                }
            });

        });
        //funcion para filtrar los resultados via combo
        function filtrar() {
            var fecha = $('#txtFecha').val();
            var fecha2 = $('#txtFecha2').val();
            $('#cargando').css("display", "block");
            $('#section').load('superadministrador/graficos/grSoportesAtendidosUsuarios.php', {fecha: fecha, fecha2: fecha2}, function() {
                $("#cargando").css("display", "none");
            });
        }
</script>
<div  style="float: right" class="container-top" id="container-top-right">  
    <form class="form-inline">            
        <div style="padding-right: 6px" class="form-group">
            <h4>Desde: </h4>
        </div>                 
        <div class="form-group" style="width: 95px">
            <div>
                <input type="text" class="form-control date-picker" id="txtFecha" name="txtFecha"/>
            </div>
        </div>
        <div style="padding-right: 6px" class="form-group">
            <h4>Hasta: </h4>
        </div> 
        <div class="form-group" style="width: 95px">
            <div>
                <input type="text" class="form-control date-picker" id="txtFecha2" name="txtFecha2"/>
            </div>
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-default" onclick="filtrar()">
                <span class="glyphicon glyphicon-search"></span> Filtrar</button> 
        </div>
    </form>
</div>
<!--contenedor superior-->
<div class="container-top"> 
    <div class="print-section">
        <!--area imprimible-->
        <h2>Gráfico de Soportes Atendidos por Usuarios</h2> 
    </div>

</div>
<hr>
<div>

    <div id="container" style="min-width: 500px; height: 400px; margin: 0 auto"></div>


</div>
