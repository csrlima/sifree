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
function llenarCmb() {
    $base = new mySQLData;
    $result = $base->consulta("SELECT * FROM paises");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
}

if ($evento == 'modificar') {
    $base = new mySQLData();
    $result = $base->consulta("SELECT * FROM clientes
            WHERE id_cliente='$id'");
    while ($row = mysql_fetch_array($result)) {
        ?>
        <script>
            $("#txtNombre").val("<?php echo $row[1] ?>");
            $("#txtDescripcion").val("<?php echo $row[2] ?>");
            $("#cmbPais").val("<?php echo $row[3] ?>");
        </script>
        <?php
    }
}
?>
<!--se incluye el plugin de validacion y las validaciones-->
<script type="text/javascript" src="js/validaciones.js"></script>

<script type="text/javascript">
    //apertura del dialog
    $("#dialog-modal").dialog({
        close: function() {
            $(this).remove()
        },
        modal: true,
        //tamanio del dialog
        height: 350,
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
                txtNombre: $("#txtNombre").val(),
                txtDescripcion: $("#txtDescripcion").val(),
                cmbPais: $("#cmbPais").val()
            }
        } else {
            var datos = {
                evento: evento,
                txtNombre: $("#txtNombre").val(),
                txtDescripcion: $("#txtDescripcion").val(),
                cmbPais: $("#cmbPais").val()
            }
        }
        $('#cargando').css("display", "block");
        $('#resultado').load('administrador/scripts/scClientes.php', datos, function() {
            $("#cargando").css("display", "none");
            $('.ui-dialog-titlebar-close').click();
        });
    }
</script>
<!--contenedor del dialog-->
<div id="dialog-modal">
    <h2>Formulario de Clientes</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <!--formulario con los controles-->
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <!--***cada contenedor form-group es un control***-->
        <div class="form-group">
            <label for="txtNombre" class="col-sm-2 control-label">Nombre Cliente</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre Cliente">
            </div>
        </div>

        <div class="form-group">
            <label for="cmbPais" class="col-sm-2 control-label">País Cliente</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbPais" name="cmbPais">
                    <?php llenarCmb(); ?>
                </select>
            </div>
        </div> 


        <div class="form-group">
            <label for="txtDescripcion" class="col-sm-2 control-label">Descripción</label>
            <div class="col-sm-4"> 
                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción"></textarea>
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
