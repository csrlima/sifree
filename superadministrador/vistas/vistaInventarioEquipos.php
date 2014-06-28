<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
//se recibe el filtro
$filtroCategorias1 = trim($_POST["filtroCategorias1"]);
$filtroCategorias2 = trim($_POST["filtroCategorias2"]);
$filtroPaises = trim($_POST["filtroPaises"]);
$filtroCategorias3 = trim($_POST["filtroCategorias3"]);
$tab = trim($_POST["tab"]);

//llenado de combo filtro
function llenarCmbCategorias1($filtroCategorias1) {
    $base = new mySQLData;
    $result = $base->consulta("SELECT id_categoria_equipo,nombre_categoria_equipo FROM categorias_equipos
            WHERE componente_agente=0
            ORDER BY nombre_categoria_equipo");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
    ?>
    <!--se llena selecciona el elemento por el que se filtro la vista actual-->
    <script>
        $('#cmbFiltroCategorias1').val('<?php echo $filtroCategorias1; ?>');
    </script>
    <?php
}

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
        $('#cmbFiltroPaises').val('<?php echo $filtroPaises; ?>');
        if ('<?php echo $tab; ?>' == '1') {
            $('#tb2').click();
        }
    </script>
    <?php
}

function llenarCmbCategorias2($filtroCategorias2) {
    $base = new mySQLData;
    $result = $base->consulta("SELECT id_categoria_equipo,nombre_categoria_equipo FROM categorias_equipos
            WHERE componente_agente=0 ORDER BY nombre_categoria_equipo");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
    ?>
    <!--se llena selecciona el elemento por el que se filtro la vista actual-->
    <script>
        $('#cmbFiltroCategorias2').val('<?php echo $filtroCategorias2; ?>');
    </script>
    <?php
}

function llenarCmbCategorias3($filtroCategorias3) {
    $base = new mySQLData;
    $result = $base->consulta("SELECT id_categoria_equipo,nombre_categoria_equipo FROM categorias_equipos
            WHERE componente_agente=0 ORDER BY nombre_categoria_equipo");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
    ?>
    <!--se llena selecciona el elemento por el que se filtro la vista actual-->
    <script>
        $('#cmbFiltroCategorias3').val('<?php echo $filtroCategorias3; ?>');
    </script>
    <?php
}
?> 
<script>
    $(function() {
        $("#tabs").tabs();
    });
</script>
<script type="text/javascript">
    //aplicar el plugin datatables
    $('.table').dataTable({
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "aaSorting": [[1, "desc"]]
    });
    //cambio de tab segun parametro
    if ('<?php echo $tab; ?>' == '1') {
        $('#tb2').click();
    }
    if ('<?php echo $tab; ?>' == '2') {
        $('#tb3').click();
    }
//funcion para filtrar los resultados via combo
    function filtrarCategorias1() {
        var id = $('#cmbFiltroCategorias1').val();
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaInventarioEquipos.php',
                {filtroCategorias1: id, filtroPaises: '0', filtroCategorias2: '0', filtroCategorias3: '0', tab: '0'}, function() {
            $("#cargando").css("display", "none");
        });
    }
    function filtrarPaisCategorias() {
        var id = $('#cmbFiltroPaises').val();
        var id2 = $('#cmbFiltroCategorias2').val();
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaInventarioEquipos.php',
                {filtroCategorias1: '0', filtroPaises: id, filtroCategorias2: id2, filtroCategorias3: '0', tab: '1'}, function() {
            $("#cargando").css("display", "none");
        });
    }

    function filtrarCategorias3() {
        var id = $('#cmbFiltroCategorias3').val();
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaInventarioEquipos.php',
                {filtroCategorias1: '0', filtroPaises: '0', filtroCategorias2: '0', filtroCategorias3: id, tab: '2'}, function() {
            $("#cargando").css("display", "none");
        });
    }
//funcion que el descheka los chk al dar click el la tab
    $('.ui-tabs-anchor').click(function() {
        $('.chk').removeAttr('checked')
    });
//funcion de generacion de reportes
    function imprimir() {
        $('.print-section').printArea({mode: "popup", popWd: 700});
    }
    function imprimir1() {
        $('.print-section1').printArea({mode: "popup", popWd: 700});
    }
    function imprimir2() {
        $('.print-section2').printArea({mode: "popup", popWd: 700});
    }
//llamado al form agregar nuevo registro
    function nuevo() {
//llamado al form por ajax
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/forms/frmEquipos.php', {evento: 'agregar'}, function() {
            $("#cargando").css("display", "none");
        });
    }
    function historial() {
//llamado al form por ajax

        $('.chk').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).attr('id').replace('chk', '').trim();
//llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/vistas/vistaHistorialEquiposSucursal.php', {id: id}, function() {
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
                var id = $(this).attr('id').replace('chk', '').trim();
//llamado al form por ajax
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/forms/frmEquipos.php', {evento: 'modificar', id: id}, function() {
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
                $('#resultado').load('superadministrador/scripts/scEquipos.php', {evento: 'eliminar', matrizEliminar: matrizEliminar}, function() {
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
                    estateButton('#btnAsignar', true);
                    estateButton('#btnHistorial', true);
                    estateButton('#btnHistorial2', true);
                    break;
                case 0:
                    estateButton('#btnEditar', false);
                    estateButton('#btnEliminar', false);
                    estateButton('#btnAsignar', false);
                    estateButton('#btnHistorial', false);
                    estateButton('#btnHistorial2', false);
                    break;
                default:
                    estateButton('#btnEditar', false);
                    estateButton('#btnEliminar', true);
                    estateButton('#btnAsignar', false);
                    estateButton('#btnHistorial', false);
                    estateButton('#btnHistorial2', false);
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

<div style="clear:both; height: 20px"></div>
<h2 style="float: left; margin-top: 0">Inventario de Equipos</h2>
<button style="float:right" type="button" class="btn btn-default" onclick="nuevo()">
    <span class="glyphicon glyphicon-plus-sign"></span>  Nuevo Equipo</button>                
<div style="clear:both;height: 10px"></div>         
<div id="tabs">
    <ul>
        <li><a class="print-section" id="tb1" href="#tabs-1">Inventarios</a></li>
        <li><a class="print-section1" id="tb2" href="#tabs-2">Equipos Instalados</a></li>
        <li><a class="print-section2" id="tb3" href="#tabs-3">Equipos en Stock</a></li>
    </ul>
    <div style="padding-bottom: 30px" id="tabs-1">
        <!--************TAB 1************-->
        <!--        filtro de busqueda-->
        <div style="padding-top: 0px" style="float: right" class="container-top" id="container-top-right">  
            <form class="form-inline">
                <div style="padding-right: 6px" class="form-group">
                    <h4>Categorías</h4>
                </div>                
                <div class="form-group">
                    <select class="form-control" id="cmbFiltroCategorias1" name="cmbFiltroCategorias1">
                        <option value="0">Todos</option>
                        <?php
                        llenarCmbCategorias1($filtroCategorias1);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-default" onclick="filtrarCategorias1()">
                        <span class="glyphicon glyphicon-search"></span> Filtrar</button> 
                </div>
            </form>
        </div>
        <!--        <div style="clear:both;height: 10px"></div>-->
        <div class="container-top"> 
            <!--botonera de opciones-->             
            <button type="button" id="btnImprimir" class="btn btn-default paginate_button_disabled" onclick="imprimir()">
                <span class="glyphicon glyphicon-print"></span> Imprimir</button>
        </div>
        <hr>
        <div style="clear:both;height: 10px"></div>        
        <div>
            <div class="print-section">
                <!--area imprimible-->
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <!--cabecera de tabla-->
                            <th>Categoría Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th style="width: 150px">Equipos Instalados</th>
                            <th style="width: 150px">Equipos En Stock</th>
                            <th style="width: 140px">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--generacion del cuerpo de la tabla-->
                        <?php
                        $base = new mySQLData();
                        $ssql = "SELECT nombre_categoria_equipo,nombre_marca,nombre_modelo,id_modelo
                            FROM marcas,modelos,categorias_equipos
                            WHERE marcas.id_marca=modelos.id_marca
                            AND componente_agente=0 AND categorias_equipos.id_categoria_equipo=modelos.id_categoria_equipo";
                        if ($filtroCategorias1 != 0 && $tab == '0') {
                            $ssql = $ssql . " AND modelos.id_categoria_equipo='$filtroCategorias1'";
                        }
                        $result = $base->consulta($ssql);
                        $totalGlobal = 0;
                        
                        while ($row = mysql_fetch_array($result)) {
                            $total = 0;
                            ?>
                            <tr>
                                <td><?php echo $row[0]; ?></td>
                                <td><?php echo $row[1]; ?></td>
                                <td><?php echo $row[2]; ?></td>  
                                <td>
                                    <?php
                                    $result1 = $base->consulta("SELECT COUNT(id_equipo) FROM equipos WHERE actividad_equipo='Instalado' AND id_modelo=$row[3]");
                                    $row1 = mysql_fetch_array($result1);
                                    echo $row1[0];
                                    $total += $row1[0];
                                    $totalGlobal += $row1[0];
                                    ?>
                                </td> 
                                <td>
                                    <?php
                                    $result1 = $base->consulta("SELECT COUNT(id_equipo) FROM equipos WHERE actividad_equipo='Stock' AND id_modelo=$row[3]");
                                    $row1 = mysql_fetch_array($result1);
                                    echo $row1[0];
                                    $total += $row1[0];
                                    $totalGlobal += $row1[0];
                                    ?>
                                </td>
                                <td><?php echo $total; ?></td>
                            </tr>  
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <span class="alert" style="font-size: 20px">Total de Equipos: <?php echo $totalGlobal; ?></span>
            </div>
        </div>
    </div>

    <div style="padding-bottom: 30px" id="tabs-2">
        <!--************TAB 2************-->
        <!--        filtro de busqueda-->               
        <div style="padding-top: 0px" style="float: right" class="container-top" id="container-top-right">  
            <form class="form-inline">
                <div style="padding-right: 6px" class="form-group">
                    <h4>Países</h4>
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
                    <h4>Categorías</h4>
                </div>                
                <div class="form-group">
                    <select class="form-control" id="cmbFiltroCategorias2" name="cmbFiltroCategorias2">
                        <option value="0">Todos</option>
                        <?php
                        llenarCmbCategorias2($filtroCategorias2);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-default" onclick="filtrarPaisCategorias()">
                        <span class="glyphicon glyphicon-search"></span> Filtrar</button> 
                </div>
            </form>
        </div>

        <div class="container-top"> 
            <!--botonera de opciones-->             
            <button type="button" id="btnHistorial" class="btn btn-default paginate_button_disabled" onclick="historial()"disabled>
                <span class="glyphicon glyphicon-list-alt"></span>  Historial Equipos en Sucursales</button> 
            <div class="divider-vertical"></div>
            <button type="button" id="btnImprimir" class="btn btn-default paginate_button_disabled" onclick="imprimir1()">
                <span class="glyphicon glyphicon-print"></span> Imprimir</button>
        </div>
        <hr>
        <div>
            <div class="print-section1">
                <!--area imprimible-->
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <!--cabecera de tabla-->
                            <th style="width: 15px"></th>
                            <th style="width: 120px">Código Equipo</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Cliente</th>
                            <th>Sucursal</th>
                            <th style="width: 80px">Estado</th>
                            <th style="width: 80px">Costo</th>                            
                        </tr>
                    </thead> 
                    <tbody>
                        <!--generacion del cuerpo de la tabla-->
                        <?php
                        $ssql = "SELECT equipos.id_equipo,nombre_categoria_equipo,nombre_marca,nombre_modelo,nombre_cliente,nombre_sucursal,estado_equipo,costo_equipo 
                            FROM equipos,marcas,modelos,categorias_equipos,det_equipos_sucursales,sucursales,clientes
                            WHERE equipos.id_modelo=modelos.id_modelo 
                            AND marcas.id_marca=modelos.id_marca
                            AND categorias_equipos.id_categoria_equipo=modelos.id_categoria_equipo
                            AND det_equipos_sucursales.id_equipo=equipos.id_equipo
                            AND det_equipos_sucursales.id_sucursal=sucursales.id_sucursal
                            AND clientes.id_cliente=sucursales.id_cliente
                            AND actividad_equipo='Instalado'";
                        if ($filtroCategorias2 != 0 && $tab == '1') {
                            $ssql = $ssql . " AND modelos.id_categoria_equipo='$filtroCategorias2'";
                        }
                        if ($filtroPaises != 0 && $tab == '1') {
                            $ssql = $ssql . " AND id_pais='$filtroPaises'";
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
                                <td><?php echo $row[4] ?></td>
                                <td><?php echo $row[5] ?></td>
                                <td><?php echo $row[6]; ?></td>
                                <td>$<?php echo $row[7]; ?></td>                                
                            </tr>  
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="padding-bottom: 30px" id="tabs-3">
        <!--************TAB 3************************************************************-->
        <!--        filtro de busqueda-->               
        <div style="padding-top: 0px" style="float: right" class="container-top" id="container-top-right">  
            <form class="form-inline">
                <div style="padding-right: 6px" class="form-group">
                    <h4>Categorías</h4>
                </div>                
                <div class="form-group">
                    <select class="form-control" id="cmbFiltroCategorias3" name="cmbFiltroCategorias3">
                        <option value="0">Todos</option>
                        <?php
                        llenarCmbCategorias3($filtroCategorias3);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-default" onclick="filtrarCategorias3()">
                        <span class="glyphicon glyphicon-search"></span> Filtrar</button> 
                </div>
            </form>
        </div>

        <div class="container-top"> 
            <!--botonera de opciones-->                           
            <button type="button" id="btnEditar" class="btn btn-default paginate_button_disabled" onclick="editar()" disabled>
                <span class="glyphicon glyphicon-edit"></span> Editar</button>
            <button type="button" id="btnEliminar" class="btn btn-default paginate_button_disabled" onclick="eliminar()" disabled>
                <span class="glyphicon glyphicon-trash"></span> Eliminar</button>
            <div class="divider-vertical"></div>                
            <button type="button" id="btnImprimir" class="btn btn-default paginate_button_disabled" onclick="imprimir2()">
                <span class="glyphicon glyphicon-print"></span> Imprimir</button>                
            <div class="divider-vertical"></div>                
            <button type="button" id="btnHistorial2" class="btn btn-default paginate_button_disabled" onclick="historial()"disabled>
                <span class="glyphicon glyphicon-list-alt"></span>  Historial Equipos en Sucursales</button> 
        </div>

        <hr>         
        <div>
            <div class="print-section2">                
                <!--area imprimible-->
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                            <!--cabecera de tabla-->
                            <th style="width: 15px"></th>
                            <th style="width: 120x">Código Equipo</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th style="width: 80px">Estado</th>
                            <th style="width: 80px">Costo</th>                     
                        </tr>
                    </thead>
                    <tbody>
                        <!--generacion del cuerpo de la tabla-->
                        <?php
                        $ssql = "SELECT id_equipo,nombre_categoria_equipo,nombre_marca,nombre_modelo,estado_equipo,costo_equipo
                            FROM equipos,marcas,modelos,categorias_equipos
                            WHERE equipos.id_modelo=modelos.id_modelo 
                            AND marcas.id_marca=modelos.id_marca
                            AND categorias_equipos.id_categoria_equipo=modelos.id_categoria_equipo
                            AND actividad_equipo='Stock'";
                        if ($filtroCategorias3 != 0 && $tab == '2') {
                            $ssql = $ssql . " AND modelos.id_categoria_equipo='$filtroCategorias3'";
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
                                <td>$<?php echo $row[5]; ?></td>                               
                            </tr>  
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
