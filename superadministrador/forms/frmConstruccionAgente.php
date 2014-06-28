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
function llenarCmbCategorias() {
    $base = new mySQLData;
    $result = $base->consulta("SELECT id_categoria_equipo,nombre_categoria_equipo FROM categorias_equipos WHERE componente_agente=1
            ORDER BY nombre_categoria_equipo");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
}

//funcion para llenar combo
function llenarCmbMarcasModelos($id) {
    $base = new mySQLData;
    $result = $base->consulta("SELECT modelos.id_modelo,nombre_marca,nombre_modelo FROM marcas,modelos 
WHERE marcas.id_marca=modelos.id_marca AND id_categoria_equipo='$id'");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1] . ' -- ' . $row[2]; ?></option>
        <?php
    }
}

if ($evento == 'modificar') {
    $base = new mySQLData();
    $result = $base->consulta("");
    while ($row = mysql_fetch_array($result)) {
        ?>
        <script>
            $("#txt").val("<?php echo $row[1] ?>")
            $("#txt").val("<?php echo $row[2] ?>")
            $("#cmb").val("<?php echo $row[3] ?>")
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
        modal: true,
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
        if(evento=='agregar'){
            var datos={
                id:id,
                evento:evento,
                cmbComponente:$("#cmbComponente").val()
            }
            $('#cargando').css("display", "block");
            $('#resultado').load('superadministrador/scripts/scConstruccionAgente.php', datos, function() {
                $("#cargando").css("display", "none");
                $('.ui-dialog-titlebar-close').click();
            });
        }
    }
    $("#cmbCategoria").change(function(ev) {
        var id = $(this).val();
        $('#cargando').css("display", "block");
        $('#contModelo').load('include/scControlesDinamicos.php', {op: 'modelosxcategoriaevent', id: id}, function() {
            $("#cargando").css("display", "none");
        });
    });
    
    
    
    function updatecmbEquipos(){
        var id = $("#cmbModelo").val();
        $('#cargando').css("display", "block");
        $('#contComponente').load('include/scControlesDinamicos.php', {op: 'componentesxmodelos', id: id}, function() {
            $("#cargando").css("display", "none");
        });
    }
</script>
<!--contenedor del dialog-->
<div id="dialog-modal">
    <h2>Formulario Agregar Componente a <?php echo $id;?></h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <!--formulario con los controles-->
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <!--***cada contenedor form-group es un control***-->
        <div class="form-group">
            <label for="cmbCategoria" class="col-sm-2 control-label">Categoría</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbCategoria" name="cmbCategoria">
                    <option value="0">Seleccione una opción</option>
                    <?php llenarCmbCategorias(); ?>
                </select>
            </div>
        </div>
        <div class="form-group">

            <label for="cmbModelo" class="col-sm-2 control-label">Marca y Modelo</label>
            <div class="col-sm-3">
                <div id="contModelo">
                    <select class="form-control paginate_button_disabled" id="cmbModelo" name="cmbModelo" disabled>

                    </select>
                </div>

            </div>
        </div>



        <div class="form-group">
            <label for="cmbComponente" class="col-sm-2 control-label">Componente</label>
            <div class="col-sm-3"> 
                <div id="contComponente">
                    <select class="form-control paginate_button_disabled" id="cmbComponente" name="cmbComponente" disabled>

                    </select>
                </div>
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
