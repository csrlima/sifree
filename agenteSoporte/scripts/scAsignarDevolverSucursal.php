<?php
session_start();
$idSucursal = trim($_POST["id"]);
echo "<script>idSucursal='$idSucursal'</script>";
//echo "<script>idEquipo='$idEquipo'</script>";
if (!empty($_POST)) {
//Inicializa objeto de la base de datos y captura el evento actual
    require_once '../../include/mySQLData.php';
    $base = new mySQLData();
    $evento = $_POST['evento'];
    //Almacena los valores del post a variables limpiandolas 
    $idEquipo = trim($_POST["cmbEquipo"]);
    date_default_timezone_set("America/El_Salvador");
    //se extrae el dia
    $dia = date("Y-m-d");
    switch ($evento) {
        case 'agregar':
//Se crea el vinculo del equipo con la sucursal
            $ssql = "INSERT INTO `det_equipos_sucursales`
                (`id_det_equipo_sucursal`,
                `id_equipo`,
                `id_sucursal`)
                VALUES('','$idEquipo','$idSucursal')";
            //se crea el historial con la fecha de incio del vinculo y la fecha fin como vacia
            $ssql2 = "INSERT INTO `historial_equipos_sucursales`
                (`id_historial_equipo_sucursal`,
                `id_equipo`,
                `id_sucursal`,
                `fecha_inicio`,
                `fecha_fin`)
                VALUES('','$idEquipo','$idSucursal','$dia','')";


            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql) && $base->consulta($ssql2)) {
                $ssql = "UPDATE `equipos` SET
                `actividad_equipo` = 'Instalado'
                    WHERE `id_equipo` = '$idEquipo'";
                $base->consulta($ssql);
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cont3').load('agenteSoporte/vistas/vistaEquiposEnSucursales.php', {id: id});
                    });
                </script>
                <?php
            } else {
                ?>
                <h2>Error al procesar</h2>
                <?php
            }
            break;
        case 'devolver':
            $matriz = $_POST['matriz']; // recibe el id 
            //crea la consulta de eliminacion
            foreach ($matriz as $id) {
//Se crea la sentencia de
                $ssql = "DELETE FROM det_equipos_sucursales WHERE id_equipo='$id' AND id_sucursal='$idSucursal'";

                $ssql2 = "UPDATE `equipos` SET
                    `actividad_equipo` = 'Stock'
                    WHERE `id_equipo` = '$id'";
                
                 $ssql3 = "UPDATE `historial_equipos_sucursales` SET
                    `fecha_fin` = '$dia'
                  WHERE id_equipo='$id' AND id_sucursal='$idSucursal' AND fecha_fin = '0000-00-00'";
                 
                //Se ejecuta y comprueba el estado de la consulta sql
                if ($base->consulta($ssql) && $base->consulta($ssql2) && $base->consulta($ssql3)) {
                    ?>
                    <script>
                        smoke.alert("Procesado exitosamente", function(e) {
                            $('#cont3').load('agenteSoporte/vistas/vistaEquiposEnSucursales.php', {id: idSucursal});
                        });
                    </script>
                    <?php
                } else {
                    ?>
                    <h2>Error al procesar</h2>
                    <?php
                }
            }
            break;
    }
}
?>
