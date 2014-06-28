<?php
session_start();
if (!empty($_POST)) {
//Inicializa objeto de la base de datos y captura el evento actual
    require_once '../../include/mySQLData.php';
    $base = new mySQLData();
    $evento = $_POST['evento'];
//Almacena los valores del post a variables limpiandolas 
    $nomb = trim($_POST["txtNombre"]);
    $marc = trim($_POST["cmbMarca"]);
    $cate = trim($_POST["cmbCategoria"]);
    switch ($evento) {
        case 'agregar':
//Se crea la sentencia de ingreso
            $ssql = "INSERT INTO `modelos`
                (`id_modelo`,
                `nombre_modelo`,
                `id_marca`,
                `id_categoria_equipo`)
                VALUES('','$nomb','$marc','$cate')";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaModelos.php', {}, function() {
                            $("#cargando").css("display", "none");
                        });
                    });
                </script>
                <?php
            }else {
                ?>
                <h2>Error al procesar</h2>
                <?php
            }
            break;

        case 'modificar':
            $id = $_POST['id'];
//Se crea la sentencia de modificacion
            $ssql = "UPDATE `modelos` SET
                `nombre_modelo` = '$nomb',
                `id_marca` = '$marc',
                `id_categoria_equipo` = '$cate'
                WHERE id_modelo='$id'";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaModelos.php', {}, function() {
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
                $ssql = "DELETE FROM modelos WHERE id_modelo = '$id'";
                $result = $base->consulta($ssql);
            }
            if ($result) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaModelos.php', {}, function() {
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
