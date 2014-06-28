<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
/* * ****** NUEVA PARTE******* */
//se recibe el filtro
$filtro = trim($_POST["filtro"]);

//llenado de combo filtro
function llenarCmb($filtro) {
    $base = new mySQLData;
    $result = $base->consulta("SELECT * FROM paises");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
    ?>
    <!--se llena selecciona el elemento por el que se filtro la vista actual-->
    <script>
        $('#cmbFiltro').val('<?php echo $filtro; ?>')
    </script>
    <?php
}

/* * ************* */
?>
<style>
    @media (max-width: 1200px) {
        .container-top{
            max-width: 450px;
        }
        .container-top .btn-default{
            margin-top: 5px;
        }  
    }
</style>
<script type="text/javascript">
    //funcion para ir a detalle
    function irDetalle(id) {
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/dialogs/dialogDetalleSucursales.php', {id: id}, function() {
            $("#cargando").css("display", "none");
        });

    }
    //llamado al form agregar nuevo registro
    function nuevoProg() {
        //llamado al form por ajax
        $('.chk').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('id').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/forms/frmSoporteProgramado.php', {evento: 'agregar', id: id}, function() {
                    $("#cargando").css("display", "none");
                });
                return;
            }
        });
    }

    /*****NUEVA PARTE*********/
    //aplicar el plugin datatables
    $('.table').dataTable({
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "aaSorting": [[1, "desc"]]
    });

    //funcion para filtrar los resultados via combo
    function filtrar() {
        var id = $('#cmbFiltro').val();
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaSucursales.php', {filtro: id}, function() {
            $("#cargando").css("display", "none");
        });
    }
    //funcion de generacion de reportes
    function imprimir() {
        $('.print-section').printArea({mode: "popup", popWd: 700});
    }
    //llamado al form agregar nuevo registro
    function nuevo() {
        //llamado al form por ajax
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/forms/frmSucursales.php', {evento: 'agregar'}, function() {
            $("#cargando").css("display", "none");
        });
    }
    //llamado al form agregar nuevo registro
    function nuevoSoporte() {
        $('.chk').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('id').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/forms/frmSoportes.php', {evento: 'agregar', id: id}, function() {
                    $("#cargando").css("display", "none");
                });
                return;
            }
        });
    }
    function historialSoporte() {
        $('.chk').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('id').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/dialogs/dialogHistorialSoporteSucursal.php', {evento: 'agregar', id: id}, function() {
                    $("#cargando").css("display", "none");
                });
                return;
            }
        });
    }
    //llamado al form para editar un registro
    function editar() {
        $('.chk').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('id').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/forms/frmSucursales.php', {evento: 'modificar', id: id}, function() {
                    $("#cargando").css("display", "none");
                });
                return;
            }
        });
    }
    //llamado al script para eliminar registros
    function eliminar() {
        smoke.confirm('¿Esta seguro que desea eliminar el (los) elemento(s)?', function(event) {
            if (event) {
                var cont = 0;
                var matrizEliminar = new Array();
                //recorre todos los check para obtener los que se van a eliminar
                $('.chk').each(function() {
                    if ($(this).is(':checked')) {
                        //extrate el id sin caracteres y lo almacena el la matriz
                        var id = $(this).attr('id').replace(/\D/g, '');
                        matrizEliminar[cont] = id;
                        cont++;
                    }
                });
                //llamado al script por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/scripts/scSucursales.php', {evento: 'eliminar', matrizEliminar: matrizEliminar}, function() {
                    $("#cargando").css("display", "none");
                });

            }
        });
    }
    //revisa los elementos checkados para modificar la disponibilidad de los botones de accion
    function revisarCheckados() {
        var nCheckados = 0;
        $('.chk').each(function() {
            if ($(this).is(':checked')) {
                nCheckados++;
            }
            switch (nCheckados) {
                case 1:
                    estateButton('#btnEditar', true);
                    estateButton('#btnNuevoSoporte', true);
                    estateButton('#btnEliminar', true);
                    estateButton('#btnNuevoSoporteProgramado', true);
                    estateButton('#btnHisorialSoporte', true);
                    break;
                case 0:
                    estateButton('#btnEditar', false);
                    estateButton('#btnNuevoSoporte', false);
                    estateButton('#btnEliminar', false);
                    estateButton('#btnNuevoSoporteProgramado', false);
                    estateButton('#btnHisorialSoporte', false);
                    break;
                default:
                    estateButton('#btnEditar', false);
                    estateButton('#btnNuevoSoporte', false);
                    estateButton('#btnEliminar', true);
                    estateButton('#btnNuevoSoporteProgramado', false);
                    estateButton('#btnHisorialSoporte', false);
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
<div style="min-width: 200px" class="container-top" id="container-top-right">  
    <form class="form-inline">
        <h4>Filtrar por País</h4>
        <div class="form-group">
            <select class="form-control" id="cmbFiltro" name="cmbFiltro">
                <option value="0">Todos</option>
                <?php
                llenarCmb($filtro);
                ?>
            </select>
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
        <h2>Vista de Sucursales</h2> 
    </div>
    <!--botonera de opciones-->
    <button type="button" class="btn btn-default" onclick="nuevo()">
        <span class="glyphicon glyphicon-plus-sign"></span> Nueva Sucursal</button>
    <button type="button" id="btnEditar" class="btn btn-default paginate_button_disabled" onclick="editar()" disabled>
        <span class="glyphicon glyphicon-edit"></span> Editar</button>
    <button type="button" id="btnEliminar" class="btn btn-default paginate_button_disabled" onclick="eliminar()" disabled>
        <span class="glyphicon glyphicon-trash"></span> Eliminar</button>
    <!--este div es el que inserta el separador-->
    <div class="divider-vertical"></div>
    <button type="button" id="btnEliminar" class="btn btn-default paginate_button_disabled" onclick="imprimir()">
        <span class="glyphicon glyphicon-print"></span> Imprimir</button>
    <!--este div es el que inserta el separador-->
    <div class="divider-vertical"></div>
    <button type="button" id="btnNuevoSoporte" class="btn btn-default paginate_button_disabled" onclick="nuevoSoporte()" disabled>
        <span class="glyphicon glyphicon-plus-sign"></span> Nuevo Soporte</button>
    <button type="button" id="btnHisorialSoporte" class="btn btn-default paginate_button_disabled" onclick="historialSoporte()" disabled>
        <span class="glyphicon glyphicon-list-alt"></span> Historial Soportes</button>    
    <div class="divider-vertical"></div>
    <button type="button" id="btnNuevoSoporteProgramado" class="btn btn-default paginate_button_disabled" onclick="nuevoProg()" disabled>
        <span class="glyphicon glyphicon-plus-sign"></span> Nuevo Soporte Programado</button>
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
                    <th style="width: 140px">Código Sucursal</th>
                    <th>Cliente</th>
                    <th>Sucursal</th>
                    <th>Encargado</th>
                    <th style="width: 120px">Teléfono</th>
                    <th style="width: 100px">Estado</th>                    
                </tr>
            </thead>
            <tbody>
                <!--generacion del cuerpo de la tabla-->
                <?php
                $base = new mySQLData();
                $ssql = "SELECT `id_sucursal`,`codigo_sucursal`,`nombre_cliente`,`nombre_sucursal`,`encargado_sucursal`,`telefono_sucursal`,`estado_sucursal`
                    FROM `sucursales`,`clientes`
                    WHERE clientes.id_cliente=sucursales.id_cliente";
                if ($filtro != 0) {
                    $ssql = $ssql . " AND clientes.id_pais='$filtro'";
                }
                $result = $base->consulta($ssql);
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <tr class='onFocus'>
                        <td><input type="checkbox" class="chk" id="chk<?php echo $row[0]; ?>" onclick="revisarCheckados()" /></td>
                        <td onclick="irDetalle('<?php echo $row[0] ?>')"><?php echo $row[1]; ?></td>
                        <td onclick="irDetalle('<?php echo $row[0] ?>')"><?php echo $row[2] ?></td>
                        <td onclick="irDetalle('<?php echo $row[0] ?>')"><?php echo $row[3] ?></td> 
                        <td onclick="irDetalle('<?php echo $row[0] ?>')"><?php echo $row[4] ?></td> 
                        <td onclick="irDetalle('<?php echo $row[0] ?>')"><?php echo $row[5] ?></td> 
                        <td onclick="irDetalle('<?php echo $row[0] ?>')"><?php echo $row[6] ?></td> 
                    </tr>  
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
