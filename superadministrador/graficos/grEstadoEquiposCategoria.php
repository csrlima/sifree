<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
?>
<script>
    var mEquipos = [];
    var mCorrectos = [];
    var mInservibles = [];
    var mDefectuosos = [];
</script>
<?php
$base = new mySQLData();
$ssql = "SELECT id_categoria_equipo,nombre_categoria_equipo FROM categorias_equipos";
$result = $base->consulta($ssql);
while ($row = mysql_fetch_array($result)) {
    ?>
    <script>
        mEquipos.push('<?php echo $row[1]; ?>');
    </script> 
    <?php
    $result1 = $base->consulta("SELECT COUNT(id_equipo)FROM equipos,modelos
        WHERE equipos.id_modelo=modelos.id_modelo AND estado_equipo='Correcto'
        AND id_categoria_equipo=$row[0]");
    $row1 = mysql_fetch_array($result1);
    ?>
    <script>
        mCorrectos.push(parseFloat('<?php echo $row1[0]; ?>'));
    </script> 
    <?php
    $result2 = $base->consulta("SELECT COUNT(id_equipo)FROM equipos,modelos
        WHERE equipos.id_modelo=modelos.id_modelo AND estado_equipo='Inservible'
        AND id_categoria_equipo=$row[0]");
    $row2 = mysql_fetch_array($result2);
    ?>
    <script>
        mInservibles.push(parseFloat('<?php echo $row2[0]; ?>'));
    </script>
    <?php
    $result3 = $base->consulta("SELECT COUNT(id_equipo)FROM equipos,modelos
        WHERE equipos.id_modelo=modelos.id_modelo AND estado_equipo='Inservible'
        AND id_categoria_equipo=$row[0]");
    $row3 = mysql_fetch_array($result3);
    ?>
    <script>
        mDefectuosos.push(parseFloat('<?php echo $row3[0]; ?>'));
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
                    text: 'Estado de Equipos por Categoría'
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
                        text: 'Cantidad de Equipos'
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
                        name: 'Correctos',
                        data: mCorrectos

                    }, {
                        name: 'Inservibles',
                        data: mInservibles
                    }, {
                        name: 'Defectuosos',
                        data: mDefectuosos
                    }]
            });
        });

</script>

<!--******************-->
<!--contenedor superior-->
<div class="container-top"> 
    <div class="print-section">
        <!--area imprimible-->
        <h2>Gráfico Estado de Equipos por Categoría</h2> 
    </div>

</div>
<hr>
<div>

    <div id="container" style="min-width: 500px; height: 400px; margin: 0 auto"></div>


</div>
