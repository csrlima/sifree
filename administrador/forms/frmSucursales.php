<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
//paso de id evento para su reenvio al script
$evento = $_POST['evento'];
$id = trim($_POST['id']);
echo "<script>id='$id'</script>";
echo "<script>evento='$evento'</script>";

//funcion para llenar combo
function llenarCmbClientes() {
    $base = new mySQLData;
    $result = $base->consulta("SELECT id_cliente,nombre_cliente FROM clientes ORDER BY nombre_cliente");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
}

function llenarCmbProveedoresInternet() {
    $base = new mySQLData;
    $result = $base->consulta("SELECT id_proveedor_internet,nombre_proveedor_internet,nombre_pais
                            FROM proveedores_internet,paises
                            WHERE paises.id_pais=proveedores_internet.id_pais
                            ORDER BY nombre_proveedor_internet");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1] . ' - ' . $row[2]; ?></option>
        <?php
    }
}

if ($evento == 'modificar') {
    $base = new mySQLData();
    $result = $base->consulta("SELECT `id_cliente`,
        `codigo_sucursal`,
        `nombre_sucursal`,
        `encargado_sucursal`,
        `direccion_sucursal`,
        `telefono_sucursal`,
        `celular_sucursal`,
        `estado_sucursal`,
        `id_proveedor_internet`,
        `mac_hfc_codigo_t`
        FROM `sucursales`
        WHERE id_sucursal='$id'");
    while ($row = mysql_fetch_array($result)) {
        ?>
        <script>
            $("#cmbCliente").val("<?php echo $row[0] ?>");
            $("#txtCodigo").val("<?php echo $row[1] ?>");
            $("#txtNombre").val("<?php echo $row[2] ?>");
            $("#txtEncargado").val("<?php echo $row[3] ?>");
            $("#txtDireccion").val("<?php echo $row[4] ?>");
            $("#txtTelefono").val("<?php echo $row[5] ?>");
            $("#txtCelular").val("<?php echo $row[6] ?>");
            $("#cmbEstado").val("<?php echo $row[7] ?>");
            $("#cmbProveedor").val("<?php echo $row[8] ?>");
            $("#txtHfc").val("<?php echo $row[9] ?>");
        </script>
        <?php
    }
}
?>
<!--se incluye el plugin de validacion y las validaciones-->
<script type="text/javascript" src="js/validaciones.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>

<script type="text/javascript">
    var data = [];
<?php
$base = new mySQLData();
$result = $base->consulta("SELECT codigo_sucursal FROM sucursales");
while ($row = mysql_fetch_array($result)) {
    ?>
            data.push(['<?php echo $row[0]; ?>']);
    <?php
}
?>
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;
            matches = [];
            substrRegex = new RegExp(q, 'i');
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push({ value: str });
                }
            });
            cb(matches);
        };
    };
    $('#txtCodigo').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },{
        name: 'data',
        displayKey: 'value',
        source: substringMatcher(data)
    });
    /////************************************** FIN AUTOCOMPLETE***********************************/////////
    //apertura del dialog
    $("#dialog-modal").dialog({
        close: function() {
            $(this).remove()
        },
        modal: true,
        //tamanio del dialog
        height: 500,
        width: 700
    });
    //cerrado del dialog por medio del boton regresar
    $('.btn-regresar').click(function() {
        $('.ui-dialog-titlebar-close').click();
    })
    //funcion de envio para procesar la informacion
    function enviar() {
        if (evento == 'modificar') {
            var datos = {
                id: id,
                evento: evento,
                cmbCliente: $("#cmbCliente").val(),
                txtNombre: $("#txtNombre").val(),
                txtEncargado: $("#txtEncargado").val(),
                txtCodigo: $("#txtCodigo").val(),
                txtDireccion: $("#txtDireccion").val(),
                txtTelefono: $("#txtTelefono").val(),
                txtCelular: $("#txtCelular").val(),
                cmbEstado: $("#cmbEstado").val(),
                cmbProveedor: $("#cmbProveedor").val(),
                txtHfc: $("#txtHfc").val()
            }
        } else {
            var datos = {
                evento: evento,
                cmbCliente: $("#cmbCliente").val(),
                txtNombre: $("#txtNombre").val(),
                txtEncargado: $("#txtEncargado").val(),
                txtCodigo: $("#txtCodigo").val(),
                txtDireccion: $("#txtDireccion").val(),
                txtTelefono: $("#txtTelefono").val(),
                txtCelular: $("#txtCelular").val(),
                cmbEstado: $("#cmbEstado").val(),
                cmbProveedor: $("#cmbProveedor").val(),
                txtHfc: $("#txtHfc").val()
            }
        }
        $('#cargando').css("display", "block");
        $('#resultado').load('administrador/scripts/scSucursales.php', datos, function() {
            $("#cargando").css("display", "none");
            $('.ui-dialog-titlebar-close').click();
        });
    }
</script>
<!--contenedor del dialog-->
<div id="dialog-modal">
    <h2>Formulario de Sucursales</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <!--formulario con los controles-->
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <!--***cada contenedor form-group es un control***-->
        <div class="form-group">
            <label for="cmbCliente" class="col-sm-2 control-label">Cliente Sucursal</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbCliente" name="cmbCliente">
                    <?php llenarCmbClientes(); ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="txtCodigo" class="col-sm-2 control-label">Código Sucursal</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" placeholder="Código Sucursal">
            </div>
        </div>
        <div class="form-group">
            <label for="txtNombre" class="col-sm-2 control-label">Nombre Sucursal</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre Sucursal">
            </div>
        </div>

        <div class="form-group">
            <label for="txtEncargado" class="col-sm-2 control-label">Encargado Sucursal</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtEncargado" name="txtEncargado" placeholder="Encargado Sucursal">
            </div>
        </div>
        <div class="form-group">
            <label for="txtDireccion" class="col-sm-2 control-label">Dirección Sucursal</label>
            <div class="col-sm-4">
                <textarea class="form-control" id="txtDireccion" name="txtDireccion" placeholder="Dirección Sucursal"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="txtTelefono" class="col-sm-2 control-label">Teléfono Sucursal</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" placeholder="Teléfono Sucursal">
            </div>
        </div>
        <div class="form-group">
            <label for="txtCelular" class="col-sm-2 control-label">Celular Sucursal</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtCelular" name="txtCelular" placeholder="Celular Sucursal">
            </div>
        </div>
        <div class="form-group">
            <label for="cmbEstado" class="col-sm-2 control-label">Estado Sucursal</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbEstado" name="cmbEstado">
                    <option value="Activa">Activa</option>
                    <option value="Inactiva">Inactiva</option>
                </select>
            </div>
        </div> 
        <div class="form-group">
            <label for="cmbProveedor" class="col-sm-2 control-label">Proveedor Internet</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbProveedor" name="cmbProveedor">
                    <?php llenarCmbProveedoresInternet(); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="txtHfc" class="col-sm-2 control-label">Código de Enlace</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtHfc" name="txtHfc" placeholder="Código de Enlace">
            </div>
        </div>
        <!--boton de guardar-->
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
            </div>
        </div> 
    </form>
</div>
