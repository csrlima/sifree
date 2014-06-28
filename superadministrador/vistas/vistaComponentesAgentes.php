<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
//se recibe el filtro
$filtro = trim($_POST["filtro"]);

//llenado de combo filtro
function llenarCmb($filtro) {
    $base = new mySQLData;
    $result = $base->consulta("SELECT id_categoria_equipo,nombre_categoria_equipo FROM categorias_equipos WHERE componente_agente=1
            ORDER BY nombre_categoria_equipo");
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
        "aaSorting": [[ 1, "desc" ]]
    });
        
    //funcion para filtrar los resultados via combo
    function filtrar(){
        var id = $('#cmbFiltro').val();
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaComponentesAgentes.php', {filtro:id}, function() {
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
        $('#resultado').load('superadministrador/forms/frmComponentesAgentes.php', {evento: 'agregar'}, function() {
            $("#cargando").css("display", "none");
        });
    }
    //llamado al form para editar un registro
    function editar() {
        $('.chk').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('id').replace('chk', '').trim();
                //llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/forms/frmComponentesAgentes.php', {evento: 'modificar', id: id}, function() {
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
                        var id = $(this).attr('id').replace('chk', '').trim();
                        matrizEliminar[cont] = id;
                        cont++;
                    }
                });
                //llamado al script por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/scripts/scComponentesAgentes.php', {evento: 'eliminar', matrizEliminar: matrizEliminar}, function() {
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
        <h4>Filtrar por Categoría</h4>
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
        <h2>Vista de Componentes de Agentes</h2> 
    </div>
    <!--botonera de opciones-->
    <button type="button" class="btn btn-default" onclick="nuevo()">
        <span class="glyphicon glyphicon-plus-sign"></span> Nuevo Componente</button>
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
                    <th></th>
                    <th>Código</th>
                    <th>Categoría</th>
                    <th>Marca</th>                    
                    <th>Modelo</th>
                    <th>Estado</th>
                    <th>Actividad - Agente</th>
                    <th>Costo</th>
                </tr>
            </thead>
            <tbody>
                <!--generacion del cuerpo de la tabla-->
                <?php
                $base = new mySQLData();
                 $ssql = "SELECT id_com_agente,nombre_categoria_equipo,nombre_marca,nombre_modelo,estado_com_agente,costo_com_agente
                            FROM componentes_agentes,marcas,modelos,categorias_equipos
                            WHERE componentes_agentes.id_modelo=modelos.id_modelo 
                            AND marcas.id_marca=modelos.id_marca
                            AND categorias_equipos.id_categoria_equipo=modelos.id_categoria_equipo";
                if ($filtro != 0) {
                    $ssql = $ssql . " AND modelos.id_categoria_equipo='$filtro'";
                }
                $result = $base->consulta($ssql);
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><input type="checkbox" class="chk" id="chk<?php echo $row[0] ?>" onclick="revisarCheckados()" /></td>
                        <td><?php echo $row[0]; ?></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2]; ?></td> 
                        <td><?php echo $row[3]; ?></td>
                        <td><?php echo $row[4]; ?></td>
                        <td>
						<?php
                        $result2 = $base->consulta("SELECT id_equipo FROM det_componentes_agentes WHERE id_com_agente='$row[0]'");
						$row2 = mysql_fetch_array($result2);
						if($row2[0]==""){
							echo "En Stock";
						}else{
							echo $row2[0];
						}
						
                        ?>
                        </td>
                        <td>$<?php echo $row[5]; ?></td>   
                    </tr>  
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
