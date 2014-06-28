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
    $usu = trim($_POST["cmbUsuario"]);
    $tipo = trim($_POST["cmbSoporte"]);
    $fecha = trim($_POST["txtFecha"]);
    $prio = trim($_POST["cmbPrioridad"]);
    switch ($evento) {
        case 'agregar':
//Se crea la sentencia de ingreso
            $ssql = "INSERT INTO `soportes_programados`
                (`id_soporte_programado`,
                `fecha_soporte_programado`,
                `prioridad_soporte_programado`,
                `tipo_soporte_programado`,
                `id_sucursal`,
                `id_usuario`)
                VALUES('','$fecha','$prio','$tipo','$id','$usu')";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaSoporteProgramado', {filtroPaises: '0', filtroClientes: '0', opcion: ''}, function() {
                            $("#cargando").css("display", "none");
                        });
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
            $ssql = "UPDATE `soportes_programados` SET
                `fecha_soporte_programado` = '$fecha',
                `prioridad_soporte_programado` = '$prio',
                `tipo_soporte_programado` = '$tipo',
                `id_usuario` = '$usu'
                WHERE id_soporte_programado='$idSop'";

            //   echo "<h1>$idSop - $id</h1>";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaSoporteProgramado', {filtroPaises: '0', filtroClientes: '0', opcion: ''}, function() {
                            $("#cargando").css("display", "none");
                        });
                    });
                </script>
                <?php
            } else {
                ?>
                <h2>Error al procesar</h2>
                <?php
            }
            break;
        case 'eliminar':
            $id = $_POST['id']; //id del soporte
            echo $id;
            $matrizEliminar = $_POST['matrizEliminar']; // recibe el id a eliminar
            //crea la consulta de eliminacion
            foreach ($matrizEliminar as $id) {
                $ssql = "DELETE FROM soportes_programados WHERE id_soporte_programado = '$id'";
                $result = $base->consulta($ssql);
            }
            if ($result) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaSoporteProgramado', {filtroPaises: '0', filtroClientes: '0', opcion: ''}, function() {
                            $("#cargando").css("display", "none");
                        });
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
