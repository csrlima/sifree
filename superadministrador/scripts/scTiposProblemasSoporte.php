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
    $matriz = $_POST['matriz'];
    switch ($evento) {
        case 'agregar':
//Se crea la sentencia de ingreso
            $result = $base->consulta("INSERT INTO `problemas`
                (`id_problema`,
                `nombre_problema`,
                `descrip_problema`)
                VALUES('','$nomb','$desc')");

            $idProb = mysql_insert_id();

            foreach ($matriz as $value) {
                $result2 = $base->consulta("INSERT INTO `det_recomendaciones_problemas`
                        (`id_det_recomendaciones_problemas`,
                        `id_problema`,
                        `id_rec_accion_soporte`)
                        VALUES('','$idProb','$value')");
            }
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($result && $result2) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaTiposProblemasSoporte.php', {}, function() {
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
            //Se ejecuta y comprueba el estado de la consulta sql
            $result = $base->consulta("UPDATE `problemas` SET
                `nombre_problema` = '$nomb',
                `descrip_problema` = '$desc'
                WHERE id_problema = '$id'");

            $result2 = $base->consulta("DELETE FROM `det_recomendaciones_problemas` WHERE id_problema='$id'");
            foreach ($matriz as $value) {
                $result2 = $base->consulta("INSERT INTO `det_recomendaciones_problemas`
                        (`id_det_recomendaciones_problemas`,
                        `id_problema`,
                        `id_rec_accion_soporte`)
                        VALUES('','$id','$value')");
            }


            if ($result && $result2) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaTiposProblemasSoporte.php', {}, function() {
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
            $matrizEliminar = $_POST['matrizEliminar']; // recibe el id a eliminar
            //crea la consulta de eliminacion
            foreach ($matrizEliminar as $id) {
                $ssql = "DELETE FROM problemas WHERE id_problema = '$id'";
                $result = $base->consulta($ssql);
            }

            if ($result) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaTiposProblemasSoporte.php', {}, function() {
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
