<?php
session_start();
if (!empty($_POST)) {
//Inicializa objeto de la base de datos y captura el evento actual
    require_once '../../include/mySQLData.php';
    $base = new mySQLData();

    $evento = $_POST['evento'];
//Almacena los valores del post a variables limpiandolas 
    $nick = trim($_POST["txtNick"]);
    $pass = trim($_POST["txtPass"]);
    $rol = trim($_POST["cmbRol"]);
    $pais = trim($_POST["cmbPais"]);
    $nomb = trim($_POST["txtNombre"]);
    $carg = trim($_POST["txtCargo"]);
    $tele = trim($_POST["txtTelefono"]);
    $corr = trim($_POST["txtCorreo"]);

    switch ($evento) {
        case 'agregar':

//Se crea la sentencia de ingreso
            $ssql = "INSERT INTO `usuarios`
            (`id_usuario`,
            `nick_usuario`,
            `contrasenia_usuario`,
            `nombre_usuario`,
            `cargo_usuario`,
            `telefono_usuario`,
            `correo_usuario`,
            `id_rol`,
            `id_pais`)       
            VALUES('','$nick','$pass','$nomb','$carg','$tele','$corr','$rol','$pais')";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaUsuarios.php', {}, function() {
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
            $ssql = "UPDATE `usuarios` SET
            `nick_usuario` = '$nick',
            `contrasenia_usuario` = '$pass',
            `nombre_usuario` = '$nomb',
            `cargo_usuario` = '$carg',
            `telefono_usuario` = '$tele',
            `correo_usuario` = '$corr',
            `id_rol` = '$rol',
            `id_pais` = '$pais'
            WHERE id_usuario='$id'";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaUsuarios.php', {}, function() {
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
                $ssql = "DELETE FROM usuarios WHERE id_usuario = '$id'";
                $result = $base->consulta($ssql);
            }

            if ($result) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaUsuarios.php', {}, function() {
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
