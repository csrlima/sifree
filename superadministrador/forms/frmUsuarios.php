<?php
session_start();
require_once "../../include/mySQLData.php";
//paso de id evento para su reenvio al script
$evento = $_POST['evento'];
$id = trim($_POST['id']);
echo "<script>id='$id'</script>";
echo "<script>evento='$evento'</script>";

function llenarCmb() {
    $base = new mySQLData;
    $result = $base->consulta("SELECT * FROM roles");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
}
function llenarCmbPaises() {
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
    $result = $base->consulta("SELECT * FROM usuarios WHERE id_usuario=$id");
    while ($row = mysql_fetch_array($result)) {
        ?>
        <script>
            $("#txtNick").val("<?php echo $row[1] ?>")
            $("#txtPass").val("<?php echo $row[2] ?>")
            $("#txtPass2").val("<?php echo $row[2] ?>")
            $("#txtNombre").val("<?php echo $row[3] ?>")
            $("#txtCargo").val("<?php echo $row[4] ?>")
            $("#txtTelefono").val("<?php echo $row[5] ?>")
            $("#txtCorreo").val("<?php echo $row[6] ?>")
            $("#cmbRol").val("<?php echo $row[7] ?>")
            $("#cmbPais").val("<?php echo $row[8] ?>")
        </script>
        <?php
    }
}
?>
<!--SE INCLUYE EL PLUGIN DE VALIDACION, MAS EL ARCHIVO CON LAS VALIDACIONES -->
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/validaciones.js"></script>

<script type="text/javascript">
    //apertura del dialog
    $( "#dialog-modal" ).dialog({
        close: function () { $(this).remove() },
        modal: true,
        height: 500,
        width: 700

    });
    //cerrado del dialog por medio del boton regresar
    $('.btn-regresar').click(function(){
        $('.ui-dialog-titlebar-close').click();
    })
    
    //funcion de envio para procesar la informacion
    function enviar(){ 
        if(evento=='modificar'){
            var datos={
                id:id,
                evento:evento,
                txtNick:$("#txtNick").val(),
                txtPass:$("#txtPass").val(),
                cmbRol:$("#cmbRol").val(),
                txtNombre:$("#txtNombre").val(),
                cmbPais:$("#cmbPais").val(),
                txtCargo:$("#txtCargo").val(),
                txtTelefono:$("#txtTelefono").val(),
                txtCorreo:$("#txtCorreo").val()
            }
        }else{
            var datos={
                evento:evento,
                txtNick:$("#txtNick").val(),
                txtPass:$("#txtPass").val(),
                cmbRol:$("#cmbRol").val(),
                txtNombre:$("#txtNombre").val(),
                cmbPais:$("#cmbPais").val(),
                txtCargo:$("#txtCargo").val(),
                txtTelefono:$("#txtTelefono").val(),
                txtCorreo:$("#txtCorreo").val()
            }
        }
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/scripts/scUsuarios.php', datos, function() {
            $("#cargando").css("display", "none");
            $('.ui-dialog-titlebar-close').click();
        });
    }
</script>

<div id="dialog-modal">
    <h2>Formulario de Usuarios</h2>
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <div class="form-group">
            <label for="txtNick" class="col-sm-2 control-label">Nick Usuario</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtNick" name="txtNick" placeholder="Nick Usuario">
            </div>
        </div> 
        <div class="form-group">
            <label for="txtPass" class="col-sm-2 control-label">Password Usuario</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" id="txtPass" name="txtPass" placeholder="Password Usuario">
            </div>
        </div>
        <div class="form-group">
            <label for="txtPass2" class="col-sm-2 control-label">Repetir Password Usuario</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" id="txtPass2" name="txtPass2" placeholder="Repetir Password Usuario">
            </div>
        </div>
        <div class="form-group">
            <label for="cmbRol" class="col-sm-2 control-label">Rol Usuario</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbRol" name="cmbRol">
                    <?php llenarCmb(); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="txtNombre" class="col-sm-2 control-label">Nombre Usuario</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre Usuario">
            </div>
        </div> 
        <div class="form-group">
            <label for="cmbPais" class="col-sm-2 control-label">País Usuario</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbPais" name="cmbPais">
                    <?php llenarCmbPaises(); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="txtCargo" class="col-sm-2 control-label">Cargo Usuario</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtCargo" name="txtCargo" placeholder="Cargo Usuario">
            </div>
        </div> 
        <div class="form-group">
            <label for="txtTelefono" class="col-sm-2 control-label">Teléfono Usuario</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" placeholder="Teléfono Usuario">
            </div>
        </div> 
        <div class="form-group">
            <label for="txtCorreo" class="col-sm-2 control-label">Correo Usuario</label>
            <div class="col-sm-3">
                <input type="email" class="form-control" id="txtCorreo" name="txtCorreo" placeholder="Correo Usuario">
            </div>
        </div> 
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
            </div>
        </div> 
    </form>
</div>


