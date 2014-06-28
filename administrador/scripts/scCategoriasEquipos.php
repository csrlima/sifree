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
    $pref = trim($_POST["txtPrefijo"]);
    $comp = trim($_POST["chkComp"]);
    if (!$comp == 1) {
        $comp = 0;
    }
    switch ($evento) {
        case 'agregar':
//Se crea la sentencia de ingreso
            $ssql = "INSERT INTO `categorias_equipos`
                (`id_categoria_equipo`,
                `nombre_categoria_equipo`,
                `descrip_categoria_equipo`,
                `prefijo_id_categoria_equipo`,
                `componente_agente`)
                VALUES('','$nomb','$desc','$pref','$comp')";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('administrador/vistas/vistaCategoriasEquipos.php', {}, function() {
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
            $ssql = "UPDATE `categorias_equipos` SET
                `nombre_categoria_equipo` = '$nomb',
                `descrip_categoria_equipo` = '$desc',
                `prefijo_id_categoria_equipo` = '$pref',
                `componente_agente` = '$comp'
                WHERE id_categoria_equipo='$id'";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('administrador/vistas/vistaCategoriasEquipos.php', {}, function() {
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
                $ssql = "DELETE FROM categorias_equipos WHERE id_categoria_equipo = '$id'";
                $result = $base->consulta($ssql);
            }
            if ($result) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('administrador/vistas/vistaCategoriasEquipos.php', {}, function() {
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
