<?php
session_start();
if (!empty($_POST)) {
    date_default_timezone_set("America/El_Salvador");
    $dia = date("Y-m-d");
//Inicializa objeto de la base de datos y captura el evento actual
    require_once '../../include/mySQLData.php';
    $base = new mySQLData();
    $evento = $_POST['evento'];
//Almacena los valores del post a variables limpiandolas 
    $id = $_POST['id'];
    $desc = trim($_POST["txtDescripcion"]);
    $esta = trim($_POST["cmbEstado"]);
    if ($esta == 'Exitosa') {
        $esta2 = 'Correcto';
    } else if ($esta == 'Inutil') {
        $esta2 = 'Inservible';
    }else{
        $esta2 = 'Defectuoso';
    }
    switch ($evento) {
        case 'agregar':
//Se crea la sentencia de ingreso
            $ssql = "INSERT INTO `reparaciones_equipos`
                (`id_reparacion_equipo`,
                `descrip_reparacion_equipo`,
                `estado_reparacion`,
                `id_diagnostico_danio`)
                VALUES('','$desc','$esta','$id')";

            $result2 = $base->consulta("SELECT id_equipo FROM diagnostico_danios WHERE id_diagnostico_danio='$id'");
            while ($row = mysql_fetch_array($result2)) {
                $ssql2 = "UPDATE `equipos` SET
                `estado_equipo` = '$esta2'
                WHERE id_equipo='$row[0]'";
            }


            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql) && $base->consulta($ssql2)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('administrador/vistas/vistaDiagnosticoReparacionEquipos.php', {}, function() {
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
            $id = $_POST['id'];
//Se crea la sentencia de modificacion
            $ssql = "UPDATE `diagnostico_danios` SET
                    `id_equipo`='$equi', 
                    `descrip_diagnostico_danio` = '$desc',
                    `id_tipo_danio` = '$tipo'
                    WHERE id_diagnostico_danio='$id'";


            $ssql2 = "UPDATE `equipos` SET
                `estado_equipo` = '$esta'
                WHERE id_equipo='$equi'";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql) && $base->consulta($ssql2)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('administrador/vistas/vistaDiagnosticoReparacionEquipos.php', {}, function() {
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
            $id = $_POST['id'];
            echo $id;
            $matrizEliminar = $_POST['matrizEliminar']; // recibe el id a eliminar
            //crea la consulta de eliminacion
            foreach ($matrizEliminar as $id) {
                $ssql = "DELETE FROM diagnostico_danios WHERE id_diagnostico_danio = '$id'";
                $result = $base->consulta($ssql);
            }
            if ($result) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('administrador/vistas/vistaDiagnosticoReparacionEquipos.php', {}, function() {
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
