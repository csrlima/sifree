<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
/* * ****** NUEVA PARTE******* */
//se recibe el filtro
$opcion = trim($_POST["opcion"]);
$filtroPaises = trim($_POST["filtroPaises"]);
$filtroClientes = trim($_POST["filtroClientes"]);

switch ($opcion) {
    case 'observacion':
        $filtroPanel = " AND estado_soporte='Observacion'";
        $opcion = " en Observación";
        break;
    case 'llamadasPendientes':
        $filtroPanel = " AND tipo_soporte='LLamada' AND estado_soporte='Pendiente'";
        $opcion = " LLamadas Pendientes";
        break;
    case 'visitasPendientes':
        $filtroPanel = " AND tipo_soporte='Visita' AND estado_soporte='Pendiente'";
        $opcion = " Visitas Pendientes";
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

    function irSoporteProgramado() {
        $('#cargando').css("display", "block");
        $('#section').load('agenteSoporte/vistas/vistaSoporteProgramado.php', {filtroPaises: '0', filtroClientes: '0', opcion: ''}, function() {
            $("#cargando").css("display", "none");
        });
    }
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
        $('#section').load('agenteSoporte/vistas/vistaSoporteTecnico.php', {filtroPaises: idPais, filtroClientes: idCliente}, function() {
            $("#cargando").css("display", "none");
        });
    }

    /****************/
    //funcion de generacion de reportes
    function imprimir() {
        $('.print-section').printArea({mode: "popup", popWd: 700});
    }


    //llamado al form para editar un registro
    function detalles(id) {
        //llamado al dialog por ajax
        $('#cargando').css("display", "block");
        $('#resultado').load('agenteSoporte/dialogs/dialogDetalleSoporteTecnico.php', {id: id}, function() {
            $("#cargando").css("display", "none");
        });
    }

    //llamado al form agregar nuevo registro
    function nuevoSop() {
        //llamado al form por ajax
        $('.chkSop').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('alt').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('agenteSoporte/forms/frmSoportes.php', {evento: 'agregar', id: id}, function() {
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
                $('#resultado').load('agenteSoporte/forms/frmSoportes.php', {evento: 'modificar', id: idSuc, idSop: idSop}, function() {
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
                    estateButton('#btnSoporte', true);
                    break;
                case 0:
                    estateButton('#btnEditar', false);
                    estateButton('#btnSoporte', false);
                    break;
                default:
                    estateButton('#btnEditar', false);
                    estateButton('#btnSoporte', false);
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
            <h4> País</h4>
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
            <h4> Clientes</h4>
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
        <h2>Vista de Soporte Técnico<?php echo $opcion; ?></h2> 
    </div>
    <!--botonera de opciones-->
    <button type="button" id="btnSoporte" class="btn btn-default paginate_button_disabled" onclick="nuevoSop()" disabled>
        <span class="glyphicon glyphicon-plus-sign"></span> Nuevo Soporte Técnico</button>
    <button type="button" id="btnEditar" class="btn btn-default paginate_button_disabled" onclick="editarSop()" disabled>
        <span class="glyphicon glyphicon-edit"></span> Editar</button>
    <!--este div es el que inserta el separador-->
    <div class="divider-vertical"></div>
    <button type="button" id="btnEliminar" class="btn btn-default paginate_button_disabled" onclick="imprimir()">
        <span class="glyphicon glyphicon-print"></span> Imprimir</button>
    <!--este div es el que inserta el separador-->
    <div class="divider-vertical"></div>
    <button type="button" class="btn btn-default paginate_button_disabled" onclick="irSoporteProgramado()" >
        <span class="glyphicon glyphicon-list-alt"></span> Soportes Programados</button>

</div>
<hr>
<div>
    <div class="print-section">
        <!--area imprimible-->
        <table  class="table table-condensed table-striped">
            <thead>
                <tr>
                    <!--cabecera de tabla-->
                    <th style="width: 40px"></th>
                    <th style="width: 110px">País</th>
                    <th>Cliente</th>
                    <th>Sucursal</th>                    
                    <th style="width: 110px">Tipo Soporte</th>
                    <th style="width: 110px">Fecha Soporte</th>
                    <th style="width: 110px">Hora Soporte</th>
                    <th style="width: 95px">Prioridad</th>
                    <th style="width: 85px">Estado</th>
                </tr>
            </thead>
            <tbody>
                <!--generacion del cuerpo de la tabla-->
                <?php
                $base = new mySQLData();
                $ssql = "SELECT `id_soporte`,
                    `nombre_pais`,
                    `nombre_cliente`,
                    `nombre_sucursal`,
                    `tipo_soporte`,
                    `fecha_inicio_soporte`,
                    `hora_inicio_soporte`,
                    `prioridad_soporte`,
                    `estado_soporte`,
                    soportes.id_sucursal
                    FROM soportes,sucursales,clientes,paises
                    WHERE soportes.id_sucursal=sucursales.id_sucursal
                    AND sucursales.id_cliente=clientes.id_cliente
                    AND clientes.id_pais=paises.id_pais
                    AND clientes.id_cliente=sucursales.id_cliente";
                if ($filtroPaises != 0) {
                    $ssql = $ssql . " AND clientes.id_pais='$filtroPaises'";
                }
                if ($filtroClientes != 0) {
                    $ssql = $ssql . " AND clientes.id_cliente='$filtroClientes'";
                }
                //filtro del panel
                $ssql = $ssql . $filtroPanel.' ORDER BY id_soporte DESC';
                $result = $base->consulta($ssql);
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <tr class="onFocus">
                        <td><input type="checkbox" class="chkSop" id="chk<?php echo $row[0]; ?>" alt="suc<?php echo $row[9]; ?>" onclick="revisarCheckados()" /></td>
                        <td onclick="detalles('<?php echo $row[0]; ?>')"><?php echo $row[1]; ?></td>
                        <td onclick="detalles('<?php echo $row[0]; ?>')"><?php echo $row[2] ?></td>
                        <td onclick="detalles('<?php echo $row[0]; ?>')"><?php echo $row[3] ?></td>
                        <td onclick="detalles('<?php echo $row[0]; ?>')"><?php echo $row[4] ?></td>
                        <td onclick="detalles('<?php echo $row[0]; ?>')"><?php echo $row[5] ?></td>
                        <td onclick="detalles('<?php echo $row[0]; ?>')"><?php echo $row[6] ?></td>
                        <td onclick="detalles('<?php echo $row[0]; ?>')">
                            <?php
                            switch ($row[7]) {
                                case 'Alto':
                                    echo "<b style='color:red'>$row[7]</b>";
                                    break;
                                case 'Moderado':
                                    echo "<b style='color:orange'>$row[7]</b>";
                                    break;
                                case 'Bajo':
                                    echo "<b style='color:green'>$row[7]</b>";
                                    break;
                            }
                            ?>
                        </td>
                        <td onclick="detalles('<?php echo $row[0]; ?>')"><?php echo $row[8] ?></td>
                    </tr>  
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
