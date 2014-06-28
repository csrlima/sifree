<?php
session_start();
if (!empty($_POST)) {
//Inicializa objeto de la base de datos y captura el evento actual
    require_once '../../include/mySQLData.php';
    $base = new mySQLData();
    $evento = $_POST['evento'];
//Almacena los valores del post a variables limpiandolas 
    $nomb = trim($_POST["txtNombre"]);
    $desc = trim($_POST["txtDescripcion"]);

    switch ($evento) {
        case 'agregar':
//Se crea la sentencia de ingreso
            $ssql = "INSERT INTO `recomendaciones_acciones_soportes`
                (`id_rec_accion_soporte`,
                `nombre_rec_accion_soporte`,
                `descripcion_rec_accion_soporte`)
                VALUES('','$nomb','$desc')";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaRecomendacionesAccionesSoporte.php', {}, function() {
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
            $ssql = "UPDATE `recomendaciones_acciones_soportes` SET
                    `nombre_rec_accion_soporte` = '$nomb',
                    `descripcion_rec_accion_soporte` = '$desc'
                    WHERE id_rec_accion_soporte='$id'";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaRecomendacionesAccionesSoporte.php', {}, function() {
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
                $ssql = "DELETE FROM recomendaciones_acciones_soportes WHERE id_rec_accion_soporte = '$id'";
                $result = $base->consulta($ssql);
            }
            if ($result) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaRecomendacionesAccionesSoporte.php', {}, function() {
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
