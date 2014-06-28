<?php
//abre la sesion en el script, seguridad
session_start();
require_once "../../include/mySQLData.php";
$id = trim($_POST['id']);
?>
<div class="container-top"> 
    <h2 style="margin-top: 0; margin-bottom: 0">Recomendaciones</h2> 
</div>
<hr>
<div>
    <table id="table4"  class="table table-condensed table-striped">

        <thead>
            <tr>
                <!--cabecera de tabla-->
                <th>Recomendación</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <!--generacion del cuerpo de la tabla-->
            <?php
            $base = new mySQLData;
            $result = $base->consulta("SELECT nombre_rec_accion_soporte,descripcion_rec_accion_soporte FROM recomendaciones_acciones_soportes,det_recomendaciones_problemas
                        WHERE det_recomendaciones_problemas.id_rec_accion_soporte=recomendaciones_acciones_soportes.id_rec_accion_soporte
                        AND id_problema='$id'");
            while ($row = mysql_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row[0]; ?></td>
                    <td><?php echo $row[1]; ?></td>
                </tr> 
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
