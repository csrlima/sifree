<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
/* * ****** NUEVA PARTE******* */
//se recibe el filtro
$opcion = trim($_POST["opcion"]);
$filtroPaises = trim($_POST["filtroPaises"]);
$filtroClientes = trim($_POST["filtroClientes"]);
date_default_timezone_set("America/El_Salvador");
$dia = date("Y-m-d");
switch ($opcion) {
    case 'llamadasCaducadas':
        $filtroPanel = " AND fecha_soporte_programado < '$dia' AND tipo_soporte_programado ='LLamada'";
        $opcion = " LLamadas Caducadas";
        break;
    case 'visitasCaducadas':
        $filtroPanel = " AND fecha_soporte_programado < '$dia' AND tipo_soporte_programado ='Visita'";
        $opcion = " Visitas Caducadas";
        break;
    default:
        $filtroPanel = '';
        break;
}

//llenado de combo filtro
function llenarCmbPaises($filtroPaises) {
    $base = new mySQLData;
    $result = $base->consulta("SELECT * FROM paises
            ORDER BY nombre_pais");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
    ?>
    <!--se llena selecciona el elemento por el que se filtro la vista actual-->
    <script>
        $('#cmbFiltroPaises').val('<?php echo $filtroPaises; ?>')
    </script>
    <?php
}

/* * ************* */

function llenarCmbClientes($filtroClientes) {
    $base = new mySQLData;
    $result = $base->consulta("SELECT id_cliente,nombre_cliente FROM clientes
            ORDER BY nombre_cliente");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
    ?>
    <!--se llena selecciona el elemento por el que se filtro la vista actual-->
    <script>
        $('#cmbFiltroClientes').val('<?php echo $filtroClientes; ?>')
    </script>
    <?php
}
?> 

<script type="text/javascript">
    /*****NUEVA PARTE*********/
    //aplicar el plugin datatables
    $('.table').dataTable({
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10
    });

    //funcion para filtrar los resultados via combo
    function filtrar() {
        var idCliente = $('#cmbFiltroClientes').val();
        var idPais = $('#cmbFiltroPaises').val();
        $('#cargando').css("display", "block");
        $('#section').load('agenteSoporte/vistas/vistaSoporteProgramado.php', {filtroPaises: idPais, filtroClientes: idCliente}, function() {
            $("#cargando").css("display", "none");
        });
    }

    /****************/
    //funcion de generacion de reportes
    function imprimir() {
        $('.print-section').printArea({mode: "popup", popWd: 700});
    }
    //llamado al form agregar nuevo registro
    function nuevoProg() {
        //llamado al form por ajax
        $('.chkSop').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('alt').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('agenteSoporte/forms/frmSoporteProgramado.php', {evento: 'agregar', id: id}, function() {
                    $("#cargando").css("display", "none");
                });
                return;
            }
        });
    }
    //llamado al form para editar un registro
    function editarProg() {
        $('.chkSop').each(function() {
            if ($(this).is(':checked')) {
                var idSop = $(this).attr('id').replace(/\D/g, '');
                var idSuc = $(this).attr('alt').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('agenteSoporte/forms/frmSoporteProgramado.php', {evento: 'modificar', id: idSuc, idSop: idSop}, function() {
                    $("#cargando").css("display", "none");
                });
                return;
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
                    estateButton('#btnnuevoProg', true);
                    break;
                case 0:
                    estateButton('#btnEditar', false);
                    estateButton('#btnnuevoProg', false);
                    break;
                default:
                    estateButton('#btnEditar', false);
                    estateButton('#btnnuevoProg', false);
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
</script>
<!--***********NUEVA PARTE**********-->
<div style="margin-top: 30px" style="float: right" class="container-top" id="container-top-right">  
    <form class="form-inline">
        <div style="padding-right: 6px" class="form-group">
            <h4>Filtrar por País</h4>
        </div>                
        <div style="padding-right: 6px" class="form-group">
            <select class="form-control" id="cmbFiltroPaises" name="cmbFiltroPaises">
                <option value="0">Todos</option>
                <?php
                llenarCmbPaises($filtroPaises);
                ?>
            </select>
        </div>                
        <div style="padding-right: 6px" class="form-group">
            <h4>Filtrar por Clientes</h4>
        </div>                
        <div class="form-group">
            <select class="form-control" id="cmbFiltroClientes" name="cmbFiltroClientes">
                <option value="0">Todos</option>
                <?php
                llenarCmbClientes($filtroClientes);
                ?>
            </select>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-default" onclick="filtrar()">
                <span class="glyphicon glyphicon-search"></span> Filtrar</button> 
        </div>
    </form>
</div>
<!--******************-->
<!--contenedor superior-->
<div class="container-top"> 
    <div class="print-section">
        <!--area imprimible-->
        <h2>Vista de Soporte Programado<?php echo $opcion; ?></h2> 
    </div>
    <!--botonera de opciones-->
    <button type="button" id="btnnuevoProg" class="btn btn-default paginate_button_disabled" onclick="nuevoProg()" disabled>
        <span class="glyphicon glyphicon-plus-sign"></span> Nuevo Soporte Programado</button>
    <button type="button" id="btnEditar" class="btn btn-default paginate_button_disabled" onclick="editarProg()" disabled>
        <span class="glyphicon glyphicon-edit"></span> Editar</button>
    <!--este div es el que inserta el separador-->
    <div class="divider-vertical"></div>
    <button type="button" id="btnEliminar" class="btn btn-default paginate_button_disabled" onclick="imprimir()">
        <span class="glyphicon glyphicon-print"></span> Imprimir</button>
</div>
<hr>
<div>
    <div class="print-section">
        <!--area imprimible-->
        <table  class="table table-condensed table-striped">
            <thead>
                <tr>
                    <!--cabecera de tabla-->
                    <th></th>
                    <th>Cliente</th>
                    <th>Sucursal</th>
                    <th style="width: 125px">Tipo Soporte</th>
                    <th style="width: 125px">Fecha Soporte</th>
                    <!--<th style="width: 125px">Hora Soporte</th>-->
                    <th style="width: 125px">Prioridad Soporte</th>
                    <th>Asignado</th>
                </tr>
            </thead>
            <tbody>
                <!--generacion del cuerpo de la tabla-->
                <?php
                $base = new mySQLData();
                $ssql = "SELECT id_soporte_programado,nombre_cliente,nombre_sucursal,tipo_soporte_programado,
                    fecha_soporte_programado,prioridad_soporte_programado,sucursales.id_sucursal,nombre_usuario
                    FROM soportes_programados,clientes,sucursales,usuarios
                    WHERE soportes_programados.id_sucursal=sucursales.id_sucursal
                    AND sucursales.id_cliente=clientes.id_cliente
                    AND usuarios.id_usuario=soportes_programados.id_usuario";
                if ($filtroPaises != 0) {
                    $ssql = $ssql . " AND clientes.id_pais='$filtroPaises'";
                }
                if ($filtroClientes != 0) {

                    $ssql = $ssql . " AND clientes.id_cliente='$filtroClientes'";
                }
                //  filtro del panel
                $ssql = $ssql . $filtroPanel . ' ORDER BY id_soporte_programado DESC';
                $result = $base->consulta($ssql);
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><input type="checkbox" class="chkSop" id="chk<?php echo $row[0]; ?>" alt="suc<?php echo $row[6]; ?>" onclick="revisarCheckados()" /></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td>
                        <td><?php echo $row[4] ?></td>
                        <td>
                            <?php
                            switch ($row[5]) {
                                case 'Alto':
                                    echo "<b style='color:red'>$row[5]</b>";
                                    break;
                                case 'Moderado':
                                    echo "<b style='color:orange'>$row[5]</b>";
                                    break;
                                case 'Bajo':
                                    echo "<b style='color:green'>$row[5]</b>";
                                    break;
                            }
                            ?>
                        </td>
                        <td><?php echo $row[7] ?></td>
                    </tr>  
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
