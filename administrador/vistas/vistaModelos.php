<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
//se recibe el filtro
$filtro = trim($_POST["filtro"]);

//llenado de combo filtro
function llenarCmb($filtro) {
    $base = new mySQLData;
    $result = $base->consulta("SELECT * FROM marcas ORDER BY nombre_marca");
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
?> 
<script type="text/javascript">
        //aplicar el plugin datatables
    $('.table').dataTable({ 
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "aaSorting": [[ 2, "asc" ]]
    });
        
    //funcion para filtrar los resultados via combo
    function filtrar(){
        var id = $('#cmbFiltro').val();
        $('#cargando').css("display", "block");
        $('#section').load('administrador/vistas/vistaModelos.php', {filtro:id}, function() {
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
        $('#resultado').load('administrador/forms/frmModelos.php', {evento: 'agregar'}, function() {
            $("#cargando").css("display", "none");
        });
    }
    //llamado al form para editar un registro
    function editar() {
        $('.chk').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('id').replace(/\D/g, '');
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('administrador/forms/frmModelos.php', {evento: 'modificar', id: id}, function() {
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
                $('#resultado').load('administrador/scripts/scModelos.php', {evento: 'eliminar', matrizEliminar: matrizEliminar}, function() {
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
</script>
<div class="container-top" id="container-top-right">  
    <form class="form-inline">
        <h4>Filtrar por Marca</h4>
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
        <h2>Vista de Modelos</h2> 
    </div>
    <!--botonera de opciones-->
    <button type="button" class="btn btn-default" onclick="nuevo()">
        <span class="glyphicon glyphicon-plus-sign"></span> Nuevo Modelo</button>
    <button type="button" id="btnEditar" class="btn btn-default paginate_button_disabled" onclick="editar()" disabled>
        <span class="glyphicon glyphicon-edit"></span> Editar</button>
    <button type="button" id="btnEliminar" class="btn btn-default paginate_button_disabled" onclick="eliminar()" disabled>
        <span class="glyphicon glyphicon-trash"></span> Eliminar</button>
    <div class="divider-vertical"></div>
    <button type="button" id="btnImprimir" class="btn btn-default paginate_button_disabled" onclick="imprimir()">
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
                    <th style="width: 40px"></th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Correcto</th>                    
                    <th>Defectuoso</th>
                    <th>Inservible</th>
                    <th style="width: 85px">Total</th>
                </tr>
            </thead>
            <tbody>
                <!--generacion del cuerpo de la tabla-->
                <?php
                $base = new mySQLData();
                 $ssql = "SELECT id_modelo,nombre_marca,nombre_modelo FROM modelos,marcas
                    WHERE modelos.id_marca=marcas.id_marca";
                if ($filtro != 0) {
                    $ssql = $ssql . " AND marcas.id_marca='$filtro'";
                }
                $result = $base->consulta($ssql);
                while ($row = mysql_fetch_array($result)) {
                    $total=0;
                    ?>
                    <tr>
                        <td><input type="checkbox" class="chk" id="chk<?php echo $row[0]; ?>" onclick="revisarCheckados()" /></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2] ?></td>
                            <td><?php 
                        $result1 = $base->consulta("SELECT COUNT(id_equipo) FROM equipos,modelos
                            WHERE equipos.id_modelo=modelos.id_modelo 
                            AND estado_equipo='Correcto'
                            AND modelos.id_modelo=$row[0]");
                            $row1 = mysql_fetch_array($result1);
                            echo $row1[0]; 
                            $total+=$row1[0];
                        ?>
                        </td>
                        <td><?php 
                        $result1 = $base->consulta("SELECT COUNT(id_equipo) FROM equipos,modelos
                            WHERE equipos.id_modelo=modelos.id_modelo 
                            AND estado_equipo='Inservible'
                            AND modelos.id_modelo=$row[0]");
                            $row1 = mysql_fetch_array($result1);
                            echo $row1[0]; 
                            $total+=$row1[0];
                        ?>
                        </td>
                        <td><?php 
                        $result1 = $base->consulta("SELECT COUNT(id_equipo) FROM equipos,modelos
                            WHERE equipos.id_modelo=modelos.id_modelo 
                            AND estado_equipo='Defectuoso'
                            AND modelos.id_modelo=$row[0]");
                            $row1 = mysql_fetch_array($result1);
                            echo $row1[0]; 
                            $total+=$row1[0];
                        ?>
                        </td>
                        <td><?php echo $total; ?></td>
                    </tr>  
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
