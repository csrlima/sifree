<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
?>
<script>
    var mEquipos = [];
    var mLlamadas = [];
    var mVisitas = [];
</script>
<?php
date_default_timezone_set("America/El_Salvador");
$mes = date("Y-m-");
$base = new mySQLData();
$ssql = "SELECT id_cliente,nombre_cliente FROM clientes";
$result = $base->consulta($ssql);
while ($row = mysql_fetch_array($result)) {
    ?>
    <script>
        mEquipos.push('<?php echo $row[1]; ?>');
    </script> 
    <?php
    $result1 = $base->consulta("SELECT COUNT(id_soporte) FROM soportes,sucursales
        WHERE soportes.id_sucursal=sucursales.id_sucursal
        AND fecha_inicio_soporte LIKE '$mes%'
        AND tipo_soporte='Llamada' AND id_cliente=$row[0]");
    $row1 = mysql_fetch_array($result1);
    ?>
    <script>
        mLlamadas.push(parseFloat('<?php echo $row1[0]; ?>'));
    </script> 
    <?php
    $result2 = $base->consulta("SELECT COUNT(id_soporte) FROM soportes,sucursales
    WHERE soportes.id_sucursal=sucursales.id_sucursal
    AND fecha_inicio_soporte LIKE '$mes%'
    AND tipo_soporte='Visita' AND id_cliente=$row[0]");
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
                    text: 'Soportes de Mes Actual por Cliente'
                },
                subtitle: {
                    text: 'SIFree Market Beat'
                },
                xAxis: {
                    categories: mEquipos
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
                            '<td style="padding:0"><b>{point.y:.1f} Equipos</b></td></tr>',
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

</script>

<!--******************-->
<!--contenedor superior-->
<div class="container-top"> 
    <div class="print-section">
        <!--area imprimible-->
        <h2>Gráfico Soportes del Mes Actual</h2> 
    </div>

</div>
<hr>
<div>

    <div id="container" style="min-width: 500px; height: 400px; margin: 0 auto"></div>


</div>
