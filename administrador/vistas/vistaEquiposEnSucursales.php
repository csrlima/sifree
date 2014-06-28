<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
$id = trim($_POST['id']);
?>
<div id="resultado2"></div>
<script>
  //llamado al form agregar nuevo registro
    function asignar() {
        //llamado al form por ajax
        $('#cargando').css("display", "block");
        $('#resultado2').load('administrador/forms/frmAsignarEquipoSucursal.php', {evento: 'agregar',id:id}, function() {
            $("#cargando").css("display", "none");
        });
    }
    
        
    //llamado al script para eliminar registros
    function devolver() {
        smoke.confirm('¿Esta seguro que desea DEVOLVER AL INVENTARIO el (los) elemento(s)?', function(event) {
            if (event) {
                var cont = 0;
                var matriz = new Array();
                //recorre todos los check para obtener los que se van a eliminar
                $('.chkSu').each(function() {
                    if ($(this).is(':checked')) {
                        //extrate el id sin caracteres y lo almacena el la matriz
                        var id = $(this).attr('id').replace('chkSu', '').trim();
                        matriz[cont] = id;
                        cont++;
                    }
                });
                //llamado al script por ajax
                $('#cargando').css("display", "block");
                $('#resultado2').load('administrador/scripts/scAsignarDevolverSucursal.php', {evento: 'devolver',id: id, matriz: matriz}, function() {
                    $("#cargando").css("display", "none");
                });
            }
        });
    }

</script>
<div class="container-top"> 
    <div class="print-section">
        <!--area imprimible-->
        <h2 style="margin-top: 0; margin-bottom: 0">Equipos Actualmente Instalados</h2> 
    </div>
    <button type="button" id="btnAsignar" class="btn btn-default " onclick="asignar()">
        <span class="glyphicon glyphicon-plus-sign"></span>  Asignar a Sucursal</button>   
    <button type="button" class="btn btn-default" onclick="devolver()">
        <span class="glyphicon glyphicon-collapse-down"></span>  Devolver al Inventario</button>  
</div>
<hr>
<div>
    <div class="print-section">
        <!--area imprimible-->
        <table id="table3"  class="table table-condensed table-striped">

            <thead>
                <tr>
                    <!--cabecera de tabla-->
                    <th style="width: 40px"></th>
                    <th style="width: 135px">Código Equipo</th>
                    <th>Categoría</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th style="width: 100px">Estado</th> 
                </tr>
            </thead>
            <tbody>
                <!--generacion del cuerpo de la tabla-->
                <?php
                $base = new mySQLData;
                $result = $base->consulta("SELECT equipos.id_equipo,nombre_categoria_equipo,nombre_marca,nombre_modelo,estado_equipo 
                                FROM equipos,marcas,modelos,categorias_equipos,det_equipos_sucursales
                                WHERE equipos.id_modelo=modelos.id_modelo 
                                AND marcas.id_marca=modelos.id_marca
                                AND categorias_equipos.id_categoria_equipo=modelos.id_categoria_equipo
                                AND det_equipos_sucursales.id_equipo=equipos.id_equipo                            
                                AND actividad_equipo='Instalado' 
                                AND id_sucursal='$id'");
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><input type="checkbox" class="chkSu" id="chkSu<?php echo $row[0] ?>" onclick="revisarCheckados()" /></td>
                        <td><?php echo $row[0]; ?></td>
                        <td><?php echo $row[1]; ?></td>
                        <td><?php echo $row[2]; ?></td>  
                        <td><?php echo $row[3]; ?></td>
                        <td><?php echo $row[4]; ?></td> 
                    </tr> 
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
