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
function llenarCmbEquipos() {
    $base = new mySQLData;
    $result = $base->consulta("SELECT id_equipo FROM equipos ORDER BY id_equipo");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
        <?php
    }
}

function llenarCmbTiposDanios() {
    $base = new mySQLData;
    $result = $base->consulta("SELECT * FROM tipos_danios");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
}

if ($evento == 'modificar') {
    $base = new mySQLData();
    $result = $base->consulta("SELECT equipos.id_equipo,id_tipo_danio,descrip_diagnostico_danio,estado_equipo 
        FROM diagnostico_danios,equipos
        WHERE diagnostico_danios.id_equipo=equipos.id_equipo 
        AND id_diagnostico_danio='$id'");
    while ($row = mysql_fetch_array($result)) {
        ?>
        <script>
            $("#cmbEquipo").val("<?php echo $row[0] ?>")
            $("#cmbTipo").val("<?php echo $row[1] ?>")
            $("#txtDescripcion").val("<?php echo $row[2] ?>")
            $("#cmbEstado").val("<?php echo $row[3] ?>")
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
    $( "#dialog-modal" ).dialog({
        close: function () { $(this).remove() },
        //        modal: true,
        //tamanio del dialog
        height: 350,
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
                cmbEquipo:$("#cmbEquipo").val(),
                txtDescripcion:$("#txtDescripcion").val(),
                cmbTipo:$("#cmbTipo").val(),
                cmbEstado:$("#cmbEstado").val()
            }
        }else{
            var datos={
                evento:evento,
                cmbEquipo:$("#cmbEquipo").val(),
                txtDescripcion:$("#txtDescripcion").val(),
                cmbTipo:$("#cmbTipo").val(),
                cmbEstado:$("#cmbEstado").val()
            }
        }
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/scripts/scDiagnosticoEquipos.php', datos, function() {
            $("#cargando").css("display", "none");
            $('.ui-dialog-titlebar-close').click();
        });
    }
</script>
<!--contenedor del dialog-->
<div id="dialog-modal">
    <h2>Formulario de Diagnóstico de Equipos</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <!--formulario con los controles-->
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <!--***cada contenedor form-group es un control***-->
        <div class="form-group">
            <label for="cmbEquipo" class="col-sm-2 control-label">Equipo</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbEquipo" name="cmbEquipo">
<?php llenarCmbEquipos(); ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="cmbTipo" class="col-sm-2 control-label">Tipo Daño</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbTipo" name="cmbTipo">
<?php llenarCmbTiposDanios(); ?>
                </select>
            </div>
        </div>        

        <div class="form-group">
            <label for="txtDescripcion" class="col-sm-2 control-label">Descripción Diagnóstico</label>
            <div class="col-sm-4"> 
                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="cmbEstado" class="col-sm-2 control-label">Estado del Equipo (Luego del diagnóstico)</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbEstado" name="cmbEstado">
                    <option value="Correcto">Correcto</option>
                    <option value="Defectuoso">Defectuoso</option>
                    <option value="Inservible">Inservible</option>
                </select>
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
