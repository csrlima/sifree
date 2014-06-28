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
<script type="text/javascript">

    /*****NUEVA PARTE*********/
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
        $('#section').load('agenteSoporte/vistas/vistaClientes.php', {filtro:id}, function() {
            $("#cargando").css("display", "none");
        });
    }
    /****************/
    //funcion de generacion de reportes
    function imprimir() {
        $('.print-section').printArea({mode: "popup", popWd: 700});
    }
    //llamado al form agregar nuevo registro
    function nuevo() {
        //llamado al form por ajax
        $('#cargando').css("display", "block");
        $('#resultado').load('agenteSoporte/forms/frmClientes.php', {evento: 'agregar'}, function() {
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
                $('#resultado').load('agenteSoporte/forms/frmClientes.php', {evento: 'modificar', id: id}, function() {
                    $("#cargando").css("display", "none");
                });
                return;
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
                    break;
                case 0:
                    estateButton('#btnEditar', false);
                    break;
                default:
                    estateButton('#btnEditar', false);
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
<div class="container-top" id="container-top-right">  
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
<!--******************-->
<!--contenedor superior-->
<div class="container-top"> 
    <div class="print-section">
        <!--area imprimible-->
        <h2>Vista de Clientes</h2> 
    </div>
    <!--botonera de opciones-->
    <button type="button" class="btn btn-default" onclick="nuevo()">
        <span class="glyphicon glyphicon-plus-sign"></span> Nuevo Cliente</button>
    <button type="button" id="btnEditar" class="btn btn-default paginate_button_disabled" onclick="editar()" disabled>
        <span class="glyphicon glyphicon-edit"></span> Editar</button>
    <!--este div es el que inserta el separador-->
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
                    <th style="width:35px"></th>
                    <th>País</th>
                    <th>Cliente</th>
                    <th>Descripción</th>
                    <th style="width: 145px">Sucursales Cliente</th>
                </tr>
            </thead>
            <tbody>
                <!--generacion del cuerpo de la tabla-->
                <?php
                $base = new mySQLData();
                $ssql = "SELECT id_cliente,nombre_pais,nombre_cliente,descrip_cliente FROM paises,clientes
                    WHERE clientes.id_pais=paises.id_pais";
                if ($filtro != 0) {
                    $ssql = $ssql . " AND clientes.id_pais='$filtro'";
                }
                $result = $base->consulta($ssql);
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><input type="checkbox" class="chk" id="chk<?php echo $row[0]; ?>" onclick="revisarCheckados()" /></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td> 
                        <td><?php
                $result1 = $base->consulta("SELECT COUNT(id_sucursal) FROM sucursales
                                WHERE id_cliente=$row[0]");
                $row1 = mysql_fetch_array($result1);
                echo $row1[0];
                    ?>
                        </td> 
                    </tr>  
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
