<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
date_default_timezone_set("America/El_Salvador");
//paso de id evento para su reenvio al script
$evento = $_POST['evento'];
$id = trim($_POST['id']); //id de la sucursal
$diaInicio = date("Y-m-d");
$horaInicio = date("H:i:s");
echo "<script>id='$id'</script>";
echo "<script>evento='$evento'</script>";
echo "<script>diaInicio='$diaInicio'</script>";
echo "<script>horaInicio='$horaInicio'</script>";

//funcion para llenar combo
function llenarCmb() {
    $base = new mySQLData;
    $result = $base->consulta("SELECT * FROM problemas ORDER BY nombre_problema");
    while ($row = mysql_fetch_array($result)) {
        ?> 
        <option title="<?php echo $row[2]; ?>" value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
        <?php
    }
}

if ($evento == 'modificar') {
    $idSop = trim($_POST['idSop']); //id de soporte tecnico
    echo "<script>idSop='$idSop'</script>";
    $base = new mySQLData();
    $result = $base->consulta("SELECT 
                diagnostico_soporte,
                descrip_accion_soporte,
                estado_soporte,
                prioridad_soporte,
                tipo_soporte,
                id_problema
                FROM soportes WHERE id_soporte='$idSop'");
    while ($row = mysql_fetch_array($result)) {
        ?>
        <script>
            $("#txtDiagnostico").val("<?php echo $row[0] ?>");
            $("#txtAcciones").val("<?php echo $row[1] ?>");
            $("#cmbEstado").val("<?php echo $row[2] ?>");
            $("#cmbPrioridad").val("<?php echo $row[3] ?>");
            $("#cmbSoporte").val("<?php echo $row[4] ?>");
            $("#cmbProblema").val("<?php echo $row[5] ?>");
            var val = $('#cmbEstado').val();
            if (val !== 'Terminado') {
                $('#prioridad').show();
            }
        </script>
        <?php
    }
}
?>
<!--se incluye el plugin de validacion y las validaciones-->
<!--<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/validaciones.js"></script>-->

<script type="text/javascript">
    //llamado al form agregar nuevo registro
    function nuevoProg() {
        //llamado al form por ajax
        // $('.chkSop').each(function() {
        // if ($(this).is(':checked')) {
        // var id = $(this).attr('alt').replace(/\D/g, '');
        //llamado al form por ajax
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/forms/frmSoporteProgramado.php', {evento: 'agregar', id: ''}, function() {
            $("#cargando").css("display", "none");
        });
        //return;
    }
    // });
    //}
    //apertura del dialog
    $("#dialog-modal").dialog({
        close: function() {
            $(this).remove()
        },
        modal: true,
        //tamanio del dialog
        height: 500,
        width: 800
    });

    $('#cmbEstado').change(function() {
        $('#prioridad').hide()
        var val = $('#cmbEstado').val();
        if (val !== 'Terminado') {
            $('#prioridad').show();
        }
    });

    //cerrado del dialog por medio del boton regresar
    $('.btn-regresar').click(function() {
        $('.ui-dialog-titlebar-close').click();
    })

    //    llamado de tabs
    $(function() {
        $("#tabs").tabs();
    });


    $('#tab3').click(function() {
        $('#cont3').load('superadministrador/vistas/vistaEquiposEnSucursales.php', {id: id});
    })
    $('#tab4').click(function() {
        var id = $("#cmbProblema").val();
        $('#cont4').load('superadministrador/vistas/vistaRecomendacionesPorProblema.php', {id: id});
    })

    $('#cont3').load('superadministrador/vistas/vistaEquiposEnSucursales.php', {id: id});

//    //funcion de generacion de reportes
//    function imprimir() {
//        $('.print-section').printArea({mode: "popup", popWd: 700});
//    }


    //    //llamado al form agregar nuevo registro
    //    function nuevo() {
    //        //llamado al form por ajax
    //        $('#cargando').css("display", "block");
    //        $('#resultado').load('superadministrador/forms/frmSoportes.php', {evento: 'agregar'}, function() {
    //            $("#cargando").css("display", "none");
    //        });
    //    }
    //llamado al form para editar un registro
//    function editar() {
//        $('.chk').each(function() {
//            if ($(this).is(':checked')) {
//                var id = $(this).attr('id').replace(/\D/g, '');
//                //llamado al form por ajax
//                $('#cargando').css("display", "block");
//                $('#resultado').load('superadministrador/forms/frmSoportes.php', {evento: 'modificar', id: id}, function() {
//                    $("#cargando").css("display", "none");
//                });
//                return;
//            }
//        });
//    }
//    //llamado al script para eliminar registros
//    function eliminar() {
//        smoke.confirm('¿Esta seguro que desea eliminar el (los) elemento(s)?', function(event) {
//            if (event) {
//                var cont = 0;
//                var matrizEliminar = new Array();
//                //recorre todos los check para obtener los que se van a eliminar
//                $('.chk').each(function() {
//                    if ($(this).is(':checked')) {
//                        //extrate el id sin caracteres y lo almacena el la matriz
//                        var id = $(this).attr('id').replace(/\D/g, '');
//                        matrizEliminar[cont] = id;
//                        cont++;
//                    }
//                });
//                //llamado al script por ajax
//                $('#cargando').css("display", "block");
//                $('#resultado').load('superadministrador/scripts/scSoportes.php', {evento: 'eliminar', matrizEliminar: matrizEliminar}, function() {
//                    $("#cargando").css("display", "none");
//                });
//            }
//        });
//    }
//
//    //revisa los elementos checkados para modificar la disponibilidad de los botones de accion
//    function revisarCheckados() {
//        var nCheckados = 0;
//        $('.chk').each(function() {
//            if ($(this).is(':checked')) {
//                nCheckados++;
//            }
//            switch (nCheckados) {
//                case 1:
//                    estateButton('#btnEditar', true);
//                    estateButton('#btnEliminar', true);
//                    break;
//                case 0:
//                    estateButton('#btnEditar', false);
//                    estateButton('#btnEliminar', false);
//                    break;
//                default:
//                    estateButton('#btnEditar', false);
//                    estateButton('#btnEliminar', true);
//                    break;
//            }
//        });
//    }
//    //cambia el estado de enabled y disabled de los botones
//    function estateButton(button, estate) {
//        if (estate) {
//            $(button).removeAttr('disabled');
//            $(button).removeClass("paginate_button_disabled");
//        } else {
//            $(button).attr('disabled', 'true');
//            $(button).addClass("paginate_button_disabled");
//        }
//    }
//

    //funcion de envio para procesar la informacion
    function enviar() {
        if (evento == 'modificar') {
            var datos = {
                idSop: idSop,
                id: id,
                evento: evento,
                cmbSoporte: $("#cmbSoporte").val(),
                cmbProblema: $("#cmbProblema").val(),
                txtDiagnostico: $("#txtDiagnostico").val(),
                txtAcciones: $("#txtAcciones").val(),
                cmbEstado: $("#cmbEstado").val(),
                cmbPrioridad: $("#cmbPrioridad").val()
            }
        } else {
            var datos = {
                id: id,
                evento: evento,
                diaInicio: diaInicio,
                horaInicio: horaInicio,
                cmbSoporte: $("#cmbSoporte").val(),
                cmbProblema: $("#cmbProblema").val(),
                txtDiagnostico: $("#txtDiagnostico").val(),
                txtAcciones: $("#txtAcciones").val(),
                cmbEstado: $("#cmbEstado").val(),
                cmbPrioridad: $("#cmbPrioridad").val()
            }
        }
        //alert(idSop+' '+id)
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/scripts/scSoportes.php', datos, function() {
            $("#cargando").css("display", "none");
            $('.ui-dialog-titlebar-close').click();
        });
    }
</script>
<!--contenedor del dialog-->
<div id="dialog-modal">
    <!--boton regresar-->
    <button type="button" class="btn btn-default btn-regresar" style="float: right">
        <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
    <button type="button" class="btn btn-default" style="float: right; margin-right: 20px;" onclick="nuevoProg()">
        <span class="glyphicon glyphicon-plus-sign"></span> Nuevo Soporte Programado</button>


    <h2 style="float: left;margin-top: 0px">Formulario de Soporte</h2>

    <div style="clear: both"></div>
    <p>
        <?php
        $base = new mySQLData;
        $result = $base->consulta("SELECT nombre_pais,nombre_cliente,codigo_sucursal,nombre_sucursal,
                    encargado_sucursal,telefono_sucursal,celular_sucursal,nombre_proveedor_internet,mac_hfc_codigo_t	
                    FROM sucursales,clientes,proveedores_internet,paises
                    WHERE clientes.id_cliente=sucursales.id_cliente
                    AND paises.id_pais=clientes.id_pais
                    AND proveedores_internet.id_proveedor_internet=sucursales.id_proveedor_internet
                    AND sucursales.id_sucursal='$id'");
        while ($row = mysql_fetch_array($result)) {
            echo "<b>País: </b> $row[0] <b>| Cliente: </b> $row[1] <b>| Sucursal: </b> $row[2] --  $row[3] <b>| Encargado: </b> $row[4] <b> <br> Teléfono: </b> $row[5] <b>| Celular: </b> $row[6] <b>| Proveedor Internet: </b> $row[7] <b>| Código Enlace: </b> $row[8]";
        }
        ?>


    </p>
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Nuevo Soporte</a></li>
            <li><a href="#tabs-2">Historial Soporte</a></li>  
            <li id="tab3"><a href="#tabs-3">Equipos Instalados</a></li>  
            <li id="tab4"><a href="#tabs-4">Recomendaciones</a></li>  
        </ul>
        <div id="tabs-1">
            <!--formulario con los controles-->
            <form class="form-horizontal" role="form" action="javascript:enviar();" method="POST">
                <!--***cada contenedor form-group es un control***-->
                <div class="form-group">
                    <label for="cmbSoporte" class="col-sm-2 control-label">Tipo Soporte</label>
                    <div class="col-sm-2"> 
                        <select class="form-control" id="cmbSoporte" name="cmbSoporte">
                            <option value="Llamada">Llamada</option>
                            <option value="Visita">Visita</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="cmbProblema" class="col-sm-2 control-label">Tipo de Problema</label>
                    <div class="col-sm-3"> 
                        <select class="form-control" id="cmbProblema" name="cmbProblema">
                            <?php llenarCmb(); ?>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="txtDiagnostico" class="col-sm-2 control-label">Diagnóstico del Problema</label>
                    <div class="col-sm-6"> 
                        <textarea class="form-control" id="txtDiagnostico" name="txtDiagnostico" placeholder="Diagnostico"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="txtAcciones" class="col-sm-2 control-label">Acciones Realizadas para Solucionar Problema</label>
                    <div class="col-sm-6"> 
                        <textarea class="form-control" id="txtAcciones" name="txtAcciones" placeholder="Acciones"></textarea>
                    </div>
                </div>       
                <div class="form-group">
                    <label for="cmbEstado" class="col-sm-2 control-label">Estado del Soporte</label>
                    <div class="col-sm-2"> 
                        <select class="form-control" id="cmbEstado" name="cmbEstado">
                            <option value="Terminado">Terminado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Observacion">Observación</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group" id="prioridad" style="display: none">
                    <label for="cmbPrioridad" class="col-sm-2 control-label">Prioridad del Soporte</label>
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
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                    </div>
                </div> 
            </form>
        </div>   


        <div id="tabs-2">
            <div class="container-top"> 
                <div class="print-section">
                    <!--                    area imprimible-->
                    <h2 style="margin-top: 0; margin-bottom: 0">Últimos Soportes Realizados</h2> 
                </div>

            </div>
            <hr>
            <div>
                <div class="print-section">
                    <!--area imprimible-->
                    <table id="table2"  class="table table-condensed table-striped">

                        <thead>
                            <tr>
                                <!--cabecera de tabla-->
                                <th style="width: 84px">Tipo Soporte</th>
                                <th style="width: 120px">Problema</th>
                                <th>Diagnóstico</th>                    
                                <th>Acciones</th>
                                <th style="width: 85px">Fecha Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--generacion del cuerpo de la tabla-->
                            <?php
                            $base = new mySQLData();
                            $result = $base->consulta("SELECT tipo_soporte,nombre_problema,diagnostico_soporte,descrip_accion_soporte,fecha_inicio_soporte,hora_inicio_soporte
                    FROM soportes,problemas
                    WHERE problemas.id_problema=soportes.id_problema AND id_sucursal='$id' LIMIT 5");
                            while ($row = mysql_fetch_array($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row[0]; ?></td>
                                    <td><?php echo $row[1]; ?></td>
                                    <td><?php echo $row[2]; ?></td>
                                    <td><?php echo $row[3]; ?></td>
                                    <td><?php echo $row[4] . ' ' . $row[5]; ?></td>
                                </tr> 
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div id="tabs-3">
            <div id="cont3">

            </div>
        </div>


        <div id="tabs-4">
            <div id="cont4">

            </div>
        </div>
    </div>



</div> 

</div>
