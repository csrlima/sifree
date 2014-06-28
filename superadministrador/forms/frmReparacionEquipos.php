<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
//paso de id evento para su reenvio al script
$evento = $_POST['evento'];
$id = trim($_POST['id']);
echo "<script>id='$id'</script>";
echo "<script>evento='$evento'</script>";

?>
<!--se incluye el plugin de validacion y las validaciones-->
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/validaciones.js"></script>

<script type="text/javascript">
    //apertura del dialog
    $( "#dialog-modal" ).dialog({
        close: function () { $(this).remove() },
        modal: true,
        //tamanio del dialog
        height: 300,
        width: 700
    });
    //cerrado del dialog por medio del boton regresar
    $('.btn-regresar').click(function(){
        $('.ui-dialog-titlebar-close').click();
    })
    //funcion de envio para procesar la informacion
    function enviar(){ 
            var datos={
                id:id,
                evento:evento,
                txtDescripcion:$("#txtDescripcion").val(),
                cmbEstado:$("#cmbEstado").val()
            }
        
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/scripts/scReparacionEquipos.php', datos, function() {
            $("#cargando").css("display", "none");
            $('.ui-dialog-titlebar-close').click();
        });
    }
</script>
<!--contenedor del dialog-->
<div id="dialog-modal">
    <h2>Formulario de Reparación de Equipos</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <!--formulario con los controles-->
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <!--***cada contenedor form-group es un control***-->
        <div class="form-group">
            <label for="txtDescripcion" class="col-sm-2 control-label">Descripción Reparación</label>
            <div class="col-sm-4"> 
                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción"></textarea>
            </div>
        </div> 

        <div class="form-group">
            <label for="cmbEstado" class="col-sm-2 control-label">Estado Reparación</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbEstado" name="cmbEstado">
                    <option value="Exitosa">Exitosa (El Equipo se repararó correctamente)</option>
                    <option value="Pendiente">Pendiente (No se pudo reparar por el momento)</option>
                    <option value="Inutil">Inútil (El equipo es inservible)</option>
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
