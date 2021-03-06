<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
//paso de id evento para su reenvio al script
$evento = $_POST['evento'];
$id = trim($_POST['id']);
echo "<script>id='$id'</script>";
echo "<script>evento='$evento'</script>";
$base = new mySQLData();

if ($evento == 'modificar') {
    $base = new mySQLData();
    $result = $base->consulta("SELECT * FROM problemas 
            WHERE id_problema='$id'");
    while ($row = mysql_fetch_array($result)) {
        ?>
        <script>
            $("#txtNombre").val("<?php echo $row[1] ?>")
            $("#txtDescripcion").val("<?php echo $row[2] ?>")
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
        height: 500,
        width: 700
    });
    //cerrado del dialog por medio del boton regresar
    $('.btn-regresar').click(function() {
        $('.ui-dialog-titlebar-close').click();
    })
    //funcion de envio para procesar la informacion
    function enviar() {
        var matriz = [];
        $('.chkop').each(function() {
            if ($(this).is(':checked')){
                var id = $(this).val();
                matriz.push(id);
                // alert(id)
            }
        });
        if (evento == 'modificar') {
            var datos = {
                id: id,
                evento: evento,
                txtNombre: $("#txtNombre").val(),
                txtDescripcion: $("#txtDescripcion").val(),
                matriz: matriz
            }
        } else {
            var datos = {
                evento: evento,
                txtNombre: $("#txtNombre").val(),
                txtDescripcion: $("#txtDescripcion").val(),
                matriz: matriz
            }
        }
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/scripts/scTiposProblemasSoporte.php', datos, function() {
            $("#cargando").css("display", "none");
            $('.ui-dialog-titlebar-close').click();
        });
    }
</script>
<!--contenedor del dialog-->
<div id="dialog-modal">
    <h2>Formulario de Tipos de Problemas de Soporte</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <!--formulario con los controles-->
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <!--***cada contenedor form-group es un control***-->
        <div class="form-group">
            <label for="txtNombre" class="col-sm-2 control-label">Nombre Tipo Problema</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre Tipo Problema">
            </div>
        </div>

        <div class="form-group">
            <label for="txtDescripcion" class="col-sm-2 control-label">Descripción Tipo Problema</label>
            <div class="col-sm-4"> 
                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción"></textarea>
            </div>
        </div> 
        <h3>Recomendaciones de Acciones para este Problema</h3>
        <div>
            <?php
            $base = new mySQLData();
            $result = $base->consulta("SELECT * FROM recomendaciones_acciones_soportes");
            while ($row = mysql_fetch_array($result)) {
                ?>

                <label style="display: inline-block; margin-right: 20px;">
                    <input style="margin-right: 5px;" type="checkbox" id="chkop<?php echo $row[0]; ?>" class="chkop" value="<?php echo $row[0]; ?>"
                           /><span><?php echo $row[1]; ?></span>
                </label>

                <?php
            }
            ?>
        </div>
        <div style="height: 20px"></div>
        <!--        boton de guardar-->
        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
            </div>
        </div> 
    </form>
</div>

<?php
if ($evento == 'modificar') {
    $base = new mySQLData();
    $result = $base->consulta("SELECT id_rec_accion_soporte FROM det_recomendaciones_problemas
        WHERE id_problema='$id'");
    while ($row = mysql_fetch_array($result)) {
        ?>
        <script>
            $("#chkop<?php echo $row[0]; ?>").attr('checked', true)
        </script>
        <?php
    }
}
?>
