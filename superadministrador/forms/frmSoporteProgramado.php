<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
//paso de id evento para su reenvio al script
$evento = $_POST['evento'];
$id = trim($_POST['id']); //id de la sucursal
echo "<script>id='$id'</script>";
echo "<script>evento='$evento'</script>";

//funcion para llenar combo
function llenarCmb() {
    $base = new mySQLData;
    $result = $base->consulta("SELECT id_usuario,nombre_usuario FROM usuarios
            ORDER BY nombre_usuario");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
}

if ($evento == 'modificar') {
    $idSop = trim($_POST['idSop']); //id de soporte tecnico
    echo "<script>idSop='$idSop'</script>";
    $base = new mySQLData();
    $result = $base->consulta("SELECT id_usuario,tipo_soporte_programado,
           fecha_soporte_programado,prioridad_soporte_programado 
            FROM soportes_programados
            WHERE id_soporte_programado='$idSop'");
    while ($row = mysql_fetch_array($result)) {
        ?>
        <script>
            $("#cmbUsuario").val("<?php echo $row[0] ?>");
            $("#cmbSoporte").val("<?php echo $row[1] ?>");
            $("#txtFecha").val("<?php echo $row[2] ?>");
            $("#cmbPrioridad").val("<?php echo $row[3] ?>");
        </script>
        <?php
    }
}
?>
<!--se incluye el plugin de validacion y las validaciones-->
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/validaciones.js"></script>

<script type="text/javascript">
            //apertura del dialog
            $("#dialog-modal").dialog({
                close: function() {
                    $(this).remove()
                },
                modal: true,
                //tamanio del dialog
                height: 400,
                width: 600
            });
            //cerrado del dialog por medio del boton regresar
            $('.btn-regresar').click(function() {
                $('.ui-dialog-titlebar-close').click();
            })

            //formato y validacion de datepicker y timepicker
            $(function() {

                $("#txtFecha").datepicker({
                    dateFormat: 'yy-mm-dd'
                });
            });

            //funcion de envio para procesar la informacion
            function enviar() {
                if (evento == 'modificar') {
                    var datos = {
                        idSop: idSop,
                        id: id,
                        evento: evento,
                        cmbUsuario: $("#cmbUsuario").val(),
                        cmbSoporte: $("#cmbSoporte").val(),
                        txtFecha: $("#txtFecha").val(),
                        cmbPrioridad: $("#cmbPrioridad").val()
                    }
                } else {
                    var datos = {
                        id: id,
                        evento: evento,
                        cmbUsuario: $("#cmbUsuario").val(),
                        cmbSoporte: $("#cmbSoporte").val(),
                        txtFecha: $("#txtFecha").val(),
                        cmbPrioridad: $("#cmbPrioridad").val()
                    }
                }
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/scripts/scSoportesProgramados.php', datos, function() {
                    $("#cargando").css("display", "none");
                    $('.ui-dialog-titlebar-close').click();
                });
            }
</script>
<!--contenedor del dialog-->
<div id="dialog-modal">
    <h2>Formulario de Soporte Programado</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <!--formulario con los controles-->
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <!--***cada contenedor form-group es un control***-->
        <div class="form-group">
            <label for="cmbUsuario" class="col-sm-3 control-label">Asignar a</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbUsuario" name="cmbUsuario">
                    <?php llenarCmb(); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="cmbSoporte" class="col-sm-3 control-label">Tipo Soporte</label>
            <div class="col-sm-2"> 
                <select class="form-control" id="cmbSoporte" name="cmbSoporte">
                    <option value="Llamada">Llamada</option>
                    <option value="Visita">Visita</option>
                </select>
            </div>
        </div> 
        <div class="form-group">
            <label for="txtFecha" class="col-sm-3 control-label">Fecha Soporte Programado</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="txtFecha" name="txtFecha" placeholder="Fecha Soporte">
            </div>
        </div>
        <div class="form-group">
            <label for="cmbPrioridad" class="col-sm-3 control-label">Prioridad del Soporte</label>
            <div class="col-sm-2"> 
                <select class="form-control" id="cmbPrioridad" name="cmbPrioridad">
                    <option value="Alto">Alto</option>
                    <option value="Moderado">Moderado</option>
                    <option value="Bajo">Bajo</option>
                </select>
            </div>
        </div>
        <!--boton de guardar-->
        <div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
            </div>
        </div> 
    </form>
</div>
