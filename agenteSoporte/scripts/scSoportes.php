<?php
session_start();
if (!empty($_POST)) {
    date_default_timezone_set("America/El_Salvador");
//Inicializa objeto de la base de datos y captura el evento actual
    require_once '../../include/mySQLData.php';
    $base = new mySQLData();
    $evento = $_POST['evento'];
//Almacena los valores del post a variables limpiandolas 
    $id = $_POST['id']; //id de la sucursal
    $diaInicio = trim($_POST["diaInicio"]);
    $horaInicio = trim($_POST["horaInicio"]);
    $tipo = trim($_POST["cmbSoporte"]);
    $prob = trim($_POST["cmbProblema"]);
    $diag = trim($_POST["txtDiagnostico"]);
    $acci = trim($_POST["txtAcciones"]);
    $esta = trim($_POST["cmbEstado"]);
    $prio = trim($_POST["cmbPrioridad"]);
    $idUsuario = $_SESSION['id_usuario'];
    if ($esta == 'Terminado') {
        $prio = '';
        $diaTerminado = date("Y-m-d");
        $horaTerminado = date("H:i:s");
    }
    switch ($evento) {
        case 'agregar':
//Se crea la sentencia de ingreso
            $ssql = "INSERT INTO `soportes`
                (`id_soporte`,
                `fecha_inicio_soporte`,
                `hora_inicio_soporte`,
                `fecha_fin_soporte`,
                `hora_fin_soporte`,
                `diagnostico_soporte`,
                `descrip_accion_soporte`,
                `estado_soporte`,
                `prioridad_soporte`,
                `tipo_soporte`,
                `id_sucursal`,
                `id_problema`,
                `id_usuario`)      
                VALUES('','$diaInicio','$horaInicio','$diaTerminado','$horaTerminado','$diag','$acci','$esta','$prio','$tipo','$id','$prob','$idUsuario')";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        location.reload();
                    });
                </script>
                <?php
            } else {
                ?>
                <h2>Error al procesar</h2>
                <?php
            }
            break;

        case 'modificar':
            $idSop = $_POST['idSop']; //id del soporte
//Se crea la sentencia de modificacion
            $ssql = "UPDATE `soportes` SET
        `fecha_fin_soporte` = '$diaTerminado',
        `hora_fin_soporte` = '$horaTerminado',
        `diagnostico_soporte` = '$diag',
        `descrip_accion_soporte` = '$acci',
        `estado_soporte` = '$esta',
        `prioridad_soporte` = '$prio',
        `tipo_soporte` = '$tipo',
        `id_sucursal` = '$id',
        `id_problema` = '$prob'
        WHERE id_soporte='$idSop'";

            //   echo "<h1>$idSop - $id</h1>";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente ed", function(e) {
                        $('#cargando').css("display", "block");
                        location.reload();
                    });
                </script>
                <?php
            } else {
                ?>
                <h2>Error al procesar</h2>
                <?php
            }
            break;
    }
}
?>
