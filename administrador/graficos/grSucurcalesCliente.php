<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
?>
<script src="highcharts/js/modules/exporting.js"></script>
<script type="text/javascript">

    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Sucursales por Clientes'//Titulo del grafico
            },
            subtitle: {
                text: 'SIFree Market Beat'
            },
            xAxis: {
                //texto del  button del grafico
                type: 'category',
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                //texto del side left
                min: 0,
                title: {
                    text: 'Cantidad de Sucursales'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Cantidad : <b>{point.y:.1f} sucursales</b>'
            },
            series: [{
                    name: 'Cantidad de Sucursales',
                    //apartado donde se carga la data del grafico con la base de  datos
                    data: (function() {
                        // generate an array of random data
                        var data = [];
                <?php
                $base = new mySQLData();
                $ssql = "SELECT id_cliente,nombre_pais,nombre_cliente,descrip_cliente FROM paises,clientes
                            WHERE clientes.id_pais=paises.id_pais";
                $result = $base->consulta($ssql);
                while ($row = mysql_fetch_array($result)) {
                $result1 = $base->consulta("SELECT COUNT(id_sucursal) FROM sucursales
                                    WHERE id_cliente=$row[0]");
                $row1 = mysql_fetch_array($result1);
                ?>
                                data.push(['<?php echo $row[2]; ?>',parseFloat('<?php echo $row1[0]; ?>')]);
                    <?php } ?>
                        return data;
                    })(),
                    //fin de carga de datos
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        x: 4,
                        y: 10,
                        style: {
                            fontSize: '15px',
                            fontFamily: 'Verdana, sans-serif',
                            textShadow: '0 0 5px black'
                        }
                    }
                }]
        });
    });
        
  
</script>

<!--******************-->
<!--contenedor superior-->
<div class="container-top"> 
    <div class="print-section">
        <!--area imprimible-->
        <h2>Gráfico de Clientes</h2> 
    </div>

</div>
<hr>
<div>

    <div id="container" style="min-width: 500px; height: 400px; margin: 0 auto"></div>


</div>
