<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
//paso de id evento para su reenvio al script
$evento = $_POST['evento'];
$id = trim($_POST['id']);
echo "<script>id='$id'</script>";
echo "<script>evento='$evento'</script>";

if ($evento == 'modificar') {
    $base = new mySQLData();
    $result = $base->consulta("SELECT * FROM categorias_equipos WHERE id_categoria_equipo='$id'");
    while ($row = mysql_fetch_array($result)) {
        ?>
        <script>
            $("#txtNombre").val("<?php echo $row[1] ?>");
            $("#txtDescripcion").val("<?php echo $row[2] ?>");
            $("#txtPrefijo").val("<?php echo $row[3] ?>");

        </script>

        <?php
        if ($row[4] == 1) {
            echo "<script>$('#chkComp').attr('checked', 'true')</script>";
        }
    }
}
?>
<!--se incluye el plugin de validacion y las validaciones-->
<script type="text/javascript" src="js/validaciones.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
<script type="text/javascript">
            /////************************************** FIN AUTOCOMPLETE***********************************/////////
            var data = [];
<?php
$base = new mySQLData();
$result = $base->consulta("SELECT prefijo_id_categoria_equipo FROM categorias_equipos");
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
                            matches.push({value: str});
                        }
                    });
                    cb(matches);
                };
            };
            $('#txtPrefijo').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
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
                height: 400,
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
                        txtPrefijo: $("#txtPrefijo").val(),
                        txtNombre: $("#txtNombre").val(),
                        txtDescripcion: $("#txtDescripcion").val(),
                        chkComp: $('#chkComp:checked').val()
                    }
                } else {
                    var datos = {
                        evento: evento,
                        txtPrefijo: $("#txtPrefijo").val(),
                        txtNombre: $("#txtNombre").val(),
                        txtDescripcion: $("#txtDescripcion").val(),
                        chkComp: $('#chkComp:checked').val()
                    }
                }
                $('#cargando').css("display", "block");
                $('#resultado').load('administrador/scripts/scCategoriasEquipos.php', datos, function() {
                    $("#cargando").css("display", "none");
                    $('.ui-dialog-titlebar-close').click();
                });
            }
</script>
<!--contenedor del dialog-->
<div id="dialog-modal">
    <h2>Formulario de Categorías de Equipos</h2>
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <!--formulario con los controles-->
    <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
        <!--***cada contenedor form-group es un control***-->
        <div class="form-group">
            <label for="txtPrefijo" class="col-sm-2 control-label">Prefijo</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtPrefijo" name="txtPrefijo" placeholder="Prefijo">
            </div>
        </div>

        <div class="form-group">
            <label for="txtNombre" class="col-sm-2 control-label">Nombre Categoría</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre Categoría">
            </div>
        </div>        

        <div class="form-group">
            <label for="txtDescripcion" class="col-sm-2 control-label">Descripción Categoría</label>
            <div class="col-sm-4"> 
                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción"></textarea>
            </div>
        </div> 


        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="chkComp" name="chkComp" value="1" > <b>Componente de Agente</b>
                    </label>
                </div>
            </div>
        </div>

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
