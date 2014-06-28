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
        $result = $base->consulta("SELECT id_categoria_equipo,nombre_categoria_equipo FROM categorias_equipos WHERE componente_agente=0
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
    $result = $base->consulta("SELECT modelos.id_categoria_equipo,equipos.id_modelo,estado_equipo,costo_equipo
                FROM equipos,marcas,modelos,categorias_equipos
                WHERE equipos.id_modelo=modelos.id_modelo 
                AND marcas.id_marca=modelos.id_marca
                AND categorias_equipos.id_categoria_equipo=modelos.id_categoria_equipo
                AND id_equipo='$id'");
    while ($row = mysql_fetch_array($result)) {
        $idCat=$row[0];
        ?>
        <script>
            $("#cmbCategoria").val("<?php echo $row[0] ?>")
            $("#cmbModelo").val("<?php echo $row[1] ?>")
            $("#cmbEstado").val("<?php echo $row[2] ?>")
            $("#txtCosto").val("<?php echo $row[3] ?>")
                                    
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
        height: 380,
        width: 700
    });
    //cerrado del dialog por medio del boton regresar
    $('.btn-regresar').click(function() {
        $('.ui-dialog-titlebar-close').click();
    })
    
    if (evento == 'modificar') {
        $('#cmbModelo').removeAttr('disabled');
        $('#cmbModelo').removeClass("paginate_button_disabled");
        
        $('#cmbCategoria').attr('disabled', 'true');
        $('#cmbCategoria').addClass("paginate_button_disabled");
    }
    
  
    //funcion de envio para procesar la informacion
    function enviar() {
        if (evento == 'modificar') {
            var datos = {
                id: id,
                evento: evento,
                cmbModelo: $("#cmbModelo").val(),
                cmbEstado: $("#cmbEstado").val(),
                txtCosto: $("#txtCosto").val()
            }
        } else {
            var datos = {
                evento: evento,
                cmbCategoria: $("#cmbCategoria").val(),
                cmbModelo: $("#cmbModelo").val(),
                cmbEstado: $("#cmbEstado").val(),
                txtCosto: $("#txtCosto").val()
            }
        }
        $('#cargando').css("display", "block");
        $('#resultado').load('administrador/scripts/scEquipos.php', datos, function() {
            $("#cargando").css("display", "none");
            $('.ui-dialog-titlebar-close').click();
        });
    }

    $("#cmbCategoria").change(function(ev) {
        var id = $(this).val();
        $('#cargando').css("display", "block");
        $('#contModelo').load('include/scControlesDinamicos.php', {op: 'modelosxcategoria', id: id}, function() {
            $("#cargando").css("display", "none");
        });
    });
</script>
<!--contenedor del dialog-->
<div id="dialog-modal">
    <h2>Formulario de Equipos</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <!--formulario con los controles-->
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <!--***cada contenedor form-group es un control***-->
        <!--        <div class="form-group">
                    <label for="cmbFecha" class="col-sm-2 control-label">Fecha Ingreso</label>
                    <div class="col-sm-3"> 
                        <select class="form-control" id="cmbFecha" name="cmbFecha">
        <?php // llenarCmb(); ?>
                        </select>
                    </div>
                </div>-->

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
                        <?php
                        if ($evento == 'modificar') {
                            llenarCmbMarcasModelos("$idCat");
                        }
                        ?>
                    </select>
                </div>

            </div>
        </div>

        <!--        <div class="form-group">
                    <label for="cmbModelo" class="col-sm-2 control-label">Modelo</label>
                    <div class="col-sm-3"> 
                        <select class="form-control" id="cmbModelo" name="cmbModelo">
                        </select>
                    </div>
                </div>-->

        <div class="form-group">
            <label for="cmbEstado" class="col-sm-2 control-label">Estado</label>
            <div class="col-sm-3"> 
                <select class="form-control" id="cmbEstado" name="cmbEstado">
                    <option value="Correcto">Correcto</option>
                    <option value="Defectuoso">Defectuoso</option>
                    <option value="Inservible">Inservible</option>
                </select>
            </div>
        </div>

        <!--        <div class="form-group">
                    <label for="cmbActividad" class="col-sm-2 control-label">Actividad</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="cmbActividad" name="cmbActividad">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>-->

        <div class="form-group">
            <label for="txtCosto" class="col-sm-2 control-label">Costo</label>
            <div class="col-sm-1">
                <input type="text" class="form-control" id="txtCosto" name="txtCosto" placeholder="00.00">
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
