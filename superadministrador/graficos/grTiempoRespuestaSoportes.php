<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
function dif($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    // echo "<h3>$start_ts --- $end_ts</h3>";
    return ($diff / 60);
//    $minutos = number_format($diff / 60, 0);
//    $segundos = $diff % 60;
//    return $minutos . '.' . $segundos;
}

date_default_timezone_set("America/El_Salvador");
$base = new mySQLData();
$mes = mysql_real_escape_string(trim($_POST["fecha"]));
if ($mes == '') {
    //   $mes = date("2014-04");
    $mes = date("Y-m");
}
?>
<script>
    var mClientes = [];
    var mLlamadas = [];
    var mVisitas = [];
    $('#txtFecha').val('<?php echo $mes; ?>');
</script>
<?php
$ssql = "SELECT id_cliente,nombre_cliente FROM clientes ORDER BY nombre_cliente";
$result = $base->consulta($ssql);
while ($row = mysql_fetch_array($result)) {
    $cont1 = 0;
    $cont2 = 0;
    $tiempo1 = 0;
    $tiempo2 = 0;
    ?>
    <script>
        mClientes.push('<?php echo $row[1]; ?>');
    </script> 
    <?php
    $result1 = $base->consulta("SELECT fecha_inicio_soporte, hora_inicio_soporte, fecha_fin_soporte, hora_fin_soporte  FROM soportes,sucursales
            WHERE soportes.id_sucursal=sucursales.id_sucursal 
            AND fecha_inicio_soporte LIKE '$mes%'
            AND tipo_soporte='Llamada'
            AND id_cliente='$row[0]'");
    while ($row1 = mysql_fetch_array($result1)) {
        if ($row1[2] != '0000-00-00') {
            $tiempo1 += dif("$row1[0] $row1[1]", "$row1[2] $row1[3]");
            $cont1+=1;
        }
    }
    $tiempo1 = ($tiempo1 == '') ? 0 : $tiempo1 / $cont1;
    ?>
    <script>
        mLlamadas.push(parseFloat('<?php echo $tiempo1 ?>'));
    </script> 
    <?php
    $result2 = $base->consulta("SELECT fecha_inicio_soporte, hora_inicio_soporte, fecha_fin_soporte, hora_fin_soporte  FROM soportes,sucursales
            WHERE soportes.id_sucursal=sucursales.id_sucursal 
            AND fecha_inicio_soporte LIKE '$mes%'
            AND tipo_soporte='Visita'
            AND id_cliente='$row[0]'");
    while ($row2 = mysql_fetch_array($result2)) {
        if ($row2[2] != '0000-00-00') {
            $tiempo2 += dif("$row2[0] $row2[1]", "$row2[2] $row2[3]");
            $cont2+=1;
        }
    }
    $tiempo2 = ($tiempo2 == '') ? 0 : $tiempo2 / $cont2;
    ?>
    <script>
        mVisitas.push(parseFloat('<?php echo $tiempo2 ?>'));
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
                text: 'Tiempo Promedio de Respuesta de Soportes Atendidos'
            },
            subtitle: {
                text: 'SIFree Market Beat'
            },
            xAxis: {
                categories: mClientes,
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '10px'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Tiempo Promedio en Minutos'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} Minutos</b></td></tr>',
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
        $('.date-picker').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'yy-mm',
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });
    });
    //funcion para filtrar los resultados via combo
    function filtrar() {
        var fecha = $('#txtFecha').val();
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/graficos/grSoportesAtendidosSucursales.php', {fecha: fecha}, function() {
            $("#cargando").css("display", "none");
        });
    }
</script>
<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<div style="float: right; padding-top: 60px;" class="container-top" id="container-top-right">  
    <form class="form-inline">            
        <div style="padding-right: 6px" class="form-group">
            <h4>Filtrar por Fecha</h4>
        </div>                 
        <div class="form-group" style="width: 90px">
            <div>
                <input type="text" class="form-control date-picker" id="txtFecha" name="txtFecha"/>
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
        <h2>Gráfico de Soportes Atendidos</h2> 
    </div>

</div>
<hr>
<div>

    <div id="container" style="min-width: 500px; height: 400px; margin: 0 auto"></div>


</div>
