<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";

function dif($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return $diff;
}

/* * ****** NUEVA PARTE******* */
//se recibe el filtro
$opcion = trim($_POST["opcion"]);
$filtroTipo = trim($_POST["filtroTipo"]);
$filtroClientes = trim($_POST["filtroClientes"]);
$fecha = trim($_POST["fecha"]);

function llenarCmbClientes($filtroClientes, $filtroTipo, $fecha) {
    $base = new mySQLData;
    $result = $base->consulta("SELECT * FROM paises
            ORDER BY nombre_pais");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <optgroup label="<?php echo $row[1]; ?>">
            <?php
            $result2 = $base->consulta("SELECT id_cliente,nombre_cliente FROM clientes WHERE id_pais='$row[0]'
            ORDER BY nombre_cliente");
            while ($row2 = mysql_fetch_array($result2)) {
                ?> 
                <option value="<?php echo $row2[0]; ?>"><?php echo $row2[1]; ?></option>
                <?php
            }
            ?>
        </optgroup>
        <?php
    }
    ?>
    <!--se llena selecciona el elemento por el que se filtro la vista actual-->
    <script>
        $('#cmbFiltroClientes').val('<?php echo $filtroClientes; ?>');
        $('#cmbFiltroTipo').val('<?php echo $filtroTipo; ?>');
        $('#txtFecha').val('<?php echo $fecha; ?>');
    </script>
    <?php
}
?> 
<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<script type="text/javascript">
    /*****NUEVA PARTE*********/
    //aplicar el plugin datatables
    $('.table').dataTable({
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "aaSorting": [[1, "desc"]]
    });

    //funcion para filtrar los resultados via combo
    function filtrar() {
        var idCliente = $('#cmbFiltroClientes').val();
        var tipo = $('#cmbFiltroTipo').val();
        var fecha = $('#txtFecha').val();
        $('#cargando').css("display", "block");
        $('#section').load('administrador/vistas/vistaListaTiempoRespuesta.php', {filtroTipo: tipo, filtroClientes: idCliente, fecha: fecha}, function() {
            $("#cargando").css("display", "none");
        });
    }

    /****************/
    //funcion de generacion de reportes
    function imprimirXls() {
        var idCliente = $('#cmbFiltroClientes').val();
        var tipo = $('#cmbFiltroTipo').val();
        var fecha = $('#txtFecha').val();
        window.location = "administrador/graficos/grxlsListaSucursales.php?filtroTipo=" + tipo + "&filtroClientes=" + idCliente + "&fecha=" + fecha;
    }

    //llamado al form agregar nuevo registro
    function nuevoSop() {
        //llamado al form por ajax
        $('.chkSop').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('alt').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('administrador/forms/frmSoportes.php', {evento: 'agregar', id: id}, function() {
                    $("#cargando").css("display", "none");
                });
                return;
            }
        });
    }
    //llamado al form para editar un registro
    function editarSop() {
        $('.chkSop').each(function() {
            if ($(this).is(':checked')) {
                var idSop = $(this).attr('id').replace(/\D/g, '');
                var idSuc = $(this).attr('alt').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('administrador/forms/frmSoportes.php', {evento: 'modificar', id: idSuc, idSop: idSop}, function() {
                    $("#cargando").css("display", "none");
                });
                return;
            }
        });
    }
    //llamado al script para eliminar registros
    function eliminarSop() {
        smoke.confirm('¿Esta seguro que desea eliminar el (los) elemento(s)?', function(event) {
            if (event) {
                var cont = 0;
                var matrizEliminar = new Array();
                //recorre todos los check para obtener los que se van a eliminar
                $('.chkSop').each(function() {
                    if ($(this).is(':checked')) {
                        //extrate el id sin caracteres y lo almacena el la matriz
                        var id = $(this).attr('id').replace(/\D/g, '');
                        matrizEliminar[cont] = id;
                        cont++;
                    }
                });
                //llamado al script por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('administrador/scripts/scSoportes.php', {evento: 'eliminar', matrizEliminar: matrizEliminar}, function() {
                    $("#cargando").css("display", "none");
                });

            }
        });
    }
    //revisa los elementos checkados para modificar la disponibilidad de los botones de accion
    function revisarCheckados() {
        var nCheckados = 0;
        $('.chkSop').each(function() {
            if ($(this).is(':checked')) {
                nCheckados++;
            }
            switch (nCheckados) {
                case 1:
                    estateButton('#btnEditar', true);
                    estateButton('#btnEliminar', true);
                    break;
                case 0:
                    estateButton('#btnEditar', false);
                    estateButton('#btnEliminar', false);
                    break;
                default:
                    estateButton('#btnEditar', false);
                    estateButton('#btnEliminar', true);
                    break;
            }
        });
    }
    //cambia el estado de enabled y disabled de los botones
    function estateButton(button, estate) {
        if (estate) {
            $(button).removeAttr('disabled');
            $(button).removeClass("paginate_button_disabled");
        } else {
            $(button).attr('disabled', 'true');
            $(button).addClass("paginate_button_disabled");
        }
    }

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
</script>
<!--***********NUEVA PARTE**********-->
<div  style="float: right" class="container-top" id="container-top-right">  
    <form class="form-inline">
        <div style="padding-right: 6px" class="form-group">
            <h4>Filtrar po Tipo</h4>
        </div>                
        <div style="padding-right: 6px" class="form-group">
            <select class="form-control" id="cmbFiltroTipo" name="cmbFiltroTipo">
                <option value="0">Todos</option>
                <option value="Llamada">Llamada</option>
                <option value="Visita">Visita</option>

            </select>
        </div>                
        <div style="padding-right: 6px" class="form-group">
            <h4>Filtrar por Clientes</h4>
        </div>                 
        <div class="form-group">
            <select class="form-control" id="cmbFiltroClientes" name="cmbFiltroClientes">
                <option value="0">Todos</option>
                <?php
                llenarCmbClientes($filtroClientes, $filtroTipo, $fecha);
                ?>
            </select>
        </div>

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
<!--******************-->
<!--contenedor superior-->
<div class="container-top" style="min-width: 200px"> 
    <div class="print-section">
        <!--area imprimible-->
        <h2>
            Tiempo Respuesta Soporte Técnico 
            <?php
            echo $opcion;
            ?>
        </h2> 
    </div>
</div>
<hr>
<div>
    <div class="print-section">
        <!--area imprimible-->
        <table  class="table table-condensed table-striped">
            <thead>
                <tr>
                    <!--cabecera de tabla-->
                    <th style="width: 85px">Sucursal</th>                    
                    <th >Tipo Soporte</th>
                    <th >Problema</th>
                    <th style="width: 165px">Fecha/Hora Inicio</th>
                    <th style="width: 165px">Fecha/Hora Fin</th>
                    <th style="width: 80px">Tiempo</th>
                    <th style="width: 80px">Estado</th>
                </tr>
            </thead>
            <tbody>
                <!--generacion del cuerpo de la tabla-->
                <?php
                $cont = 0;
                $tiempoTotal = 0;

                $base = new mySQLData();
                $ssql = "SELECT codigo_sucursal,tipo_soporte,nombre_problema,
                            fecha_inicio_soporte, hora_inicio_soporte, fecha_fin_soporte, hora_fin_soporte,estado_soporte
                            FROM soportes,sucursales,clientes,paises,problemas
                            WHERE soportes.id_sucursal=sucursales.id_sucursal
                            AND sucursales.id_cliente=clientes.id_cliente
                            AND clientes.id_pais=paises.id_pais
                            AND problemas.id_problema=soportes.id_problema
                            AND clientes.id_cliente=sucursales.id_cliente";
                
                if ($filtroTipo != '0') {
                    $ssql = $ssql . " AND tipo_soporte='$filtroTipo'";
                }
                if ($filtroClientes != 0) {
                    $ssql = $ssql . " AND clientes.id_cliente='$filtroClientes'";
                }
                if ($fecha != '') {
                    $ssql = $ssql . " AND fecha_inicio_soporte LIKE '$fecha%'";
                }
                //filtro del panel
//                $ssql = $ssql . $filtroPanel;
                $result = $base->consulta($ssql);
                while ($row = mysql_fetch_array($result)) {
                    $tiempo = '';
                    if ($row[5] != '0000-00-00') {
                        //$tiempoTotal+="$row[3] $row[4]";
                        $tiempo = date('z:H:i:s', dif("$row[3] $row[4]", "$row[5] $row[6]"));
                        $tiempoTotal+=dif("$row[3] $row[4]", "$row[5] $row[6]");
                        $cont+=1;
                    }
                    //$tiempo1 = ($tiempo1 == '') ? 0 : $tiempo1 / $cont1;
                    ?>
                    <tr>
                        <td><?php echo $row[0]; ?></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] . ' / ' . $row[4] ?></td>
                        <td><?php echo $row[5] . ' / ' . $row[6] ?></td>
                        <td><?php echo $tiempo ?></td>
                        <td><?php echo $row[7] ?></td>
                    </tr>  
                    <?php
                }
                ?>
            </tbody>
        </table>
        <span class="alert" style="font-size: 20px">Tiempo Promedio: 
            <?php
            $tiempoTotal /=$cont;
            echo date('z:H:i:s', $tiempoTotal); 
            ?>
        </span>
        <br>
        (Formato= dias:horas:minutos:segundos)
    </div>
</div>
