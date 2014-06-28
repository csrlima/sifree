<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
?>
<script type="text/javascript">
    //aplicar el plugin datatables
    $('.table').dataTable({
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "aaSorting": [[1, "desc"]]
    });
    function irDetalle(id) {
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/dialogs/dialogDetalleDiagnosticoReparacion.php', {id: id}, function() {
            $("#cargando").css("display", "none");
        });

    }
    //funcion para filtrar los resultados via combo
    function filtrar() {
        var id = $('#cmbFiltro').val();
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaDiagnosticoReparacionEquipos.php', {filtro: id}, function() {
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
        $('#resultado').load('superadministrador/forms/frmDiagnosticoEquipos.php', {evento: 'agregar'}, function() {
            $("#cargando").css("display", "none");
        });
    }
    function nuevoReparacion() {
        $('.chk').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('id').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/forms/frmReparacionEquipos.php', {evento: 'agregar', id: id}, function() {
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
                $('#resultado').load('superadministrador/forms/frmDiagnosticoEquipos.php', {evento: 'modificar', id: id}, function() {
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
                $('#resultado').load('superadministrador/scripts/scDiagnosticoEquipos.php', {evento: 'eliminar', matrizEliminar: matrizEliminar}, function() {
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
                    estateButton('#btnEliminar', true);
                    estateButton('#btnHistorial', true);
                    estateButton('#btnNuevoReparacion', true);
                    break;
                case 0:
                    estateButton('#btnEditar', false);
                    estateButton('#btnEliminar', false);
                    estateButton('#btnHistorial', false);
                    estateButton('#btnNuevoReparacion', false);
                    break;
                default:
                    estateButton('#btnEditar', false);
                    estateButton('#btnEliminar', true);
                    estateButton('#btnHistorial', false);
                    estateButton('#btnNuevoReparacion', false);
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
<!--contenedor superior-->
<div class="container-top"> 
    <div class="print-section">
        <!--area imprimible-->
        <h2>Vista de Diagnóstico y Reparación de Equipos</h2> 
    </div>
    <!--botonera de opciones-->
    <button type="button" class="btn btn-default" onclick="nuevo()">
        <span class="glyphicon glyphicon-plus-sign"></span> Nuevo Diagnóstico</button>
    <button type="button" id="btnEditar" class="btn btn-default paginate_button_disabled" onclick="editar()" disabled>
        <span class="glyphicon glyphicon-edit"></span> Editar</button>
    <button type="button" id="btnEliminar" class="btn btn-default paginate_button_disabled" onclick="eliminar()" disabled>
        <span class="glyphicon glyphicon-trash"></span> Eliminar</button>
    <div class="divider-vertical"></div>
    <button type="button" id="btnImprimir" class="btn btn-default paginate_button_disabled" onclick="imprimir()">
        <span class="glyphicon glyphicon-print"></span> Imprimir</button>    
    <div class="divider-vertical"></div>    
    <button type="button" id="btnNuevoReparacion" class="btn btn-default paginate_button_disabled" onclick="nuevoReparacion()"disabled="">
        <span class="glyphicon glyphicon-plus-sign"></span> Nueva Reparación</button>     
</div>
<hr>
<div>
    <div class="print-section">
        <!--area imprimible-->
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <!--cabecera de tabla-->
                    <th style="width: 40px"></th>
                    <th style="width: 130px">Código Equipo</th>
                    <th>Tipo Daño</th>
                    <th>Diagnóstico</th>                    
                    <th style="width: 140px">Estado Reparación</th>
                </tr>
            </thead>
            <tbody>
                <!--generacion del cuerpo de la tabla-->
                <?php
                $base = new mySQLData();
                $ssql = "SELECT id_diagnostico_danio,id_equipo,nombre_tipo_danio,descrip_diagnostico_danio FROM diagnostico_danios,tipos_danios
                                WHERE diagnostico_danios.id_tipo_danio=tipos_danios.id_tipo_danio";
                $result = $base->consulta($ssql);
                while ($row = mysql_fetch_array($result)) {
                    $result1 = $base->consulta("SELECT estado_reparacion FROM reparaciones_equipos
                                WHERE id_diagnostico_danio=$row[0]");
                    if (mysql_num_rows($result1) < 1) {
                        $estado = "No Realizada";
                        $on = " ";
                        $on2 = " ";
                    } else {
                        $row1 = mysql_fetch_array($result1);
                        $estado = $row1[0];
                        $on = "onclick=\"irDetalle('$row[0]')\"";
                        $on2 = "class='onFocus'";
                    }
                    echo "<tr $on2 >";
                    echo "<td><input type='checkbox' class='chk' id='chk<?php echo $row[0]; ?>' onclick='revisarCheckados()' /></td>";
                    echo "<td $on>$row[1]</td>";
                    echo "<td $on>$row[2]</td>";
                    echo "<td $on>$row[3]</td>";
                    echo "<td $on>$estado</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
