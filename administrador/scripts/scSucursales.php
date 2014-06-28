<?php
session_start();
if (!empty($_POST)) {
//Inicializa objeto de la base de datos y captura el evento actual
    require_once '../../include/mySQLData.php';
    $base = new mySQLData();
    $evento = $_POST['evento'];
//Almacena los valores del post a variables limpiandolas 
    $clie = trim($_POST["cmbCliente"]);
    $nomb = trim($_POST["txtNombre"]);
    $enca = trim($_POST["txtEncargado"]);
    $codi = trim($_POST["txtCodigo"]);
    $dire = trim($_POST["txtDireccion"]);
    $tele = trim($_POST["txtTelefono"]);
    $celu = trim($_POST["txtCelular"]);
    $esta = trim($_POST["cmbEstado"]);
    $prov = trim($_POST["cmbProveedor"]);
    $enla = trim($_POST["txtHfc"]);

    switch ($evento) {
        case 'agregar':
            date_default_timezone_set("America/El_Salvador");
            //se extrae el dia
            $dia = date("Y-m-d");
//Se crea la sentencia de ingreso
            $ssql = "INSERT INTO `sucursales`
                (`id_sucursal`,
                `codigo_sucursal`,
                `nombre_sucursal`,
                `encargado_sucursal`,
                `direccion_sucursal`,
                `telefono_sucursal`,
                `celular_sucursal`,
                `estado_sucursal`,
                `mac_hfc_codigo_t`,
                `id_cliente`,
                `id_proveedor_internet`,
                fecha_ingreso)
                VALUES('','$codi','$nomb','$enca','$dire','$tele','$celu','$esta','$enla','$clie','$prov','$dia')";
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
            $id = $_POST['id'];
//Se crea la sentencia de modificacion
            $ssql = "UPDATE `sucursales` SET
                `codigo_sucursal` = '$codi',
                `nombre_sucursal` = '$nomb',
                `encargado_sucursal` = '$enca',
                `direccion_sucursal` = '$dire',
                `telefono_sucursal` = '$tele',
                `celular_sucursal` = '$celu',
                `estado_sucursal` = '$esta',
                `mac_hfc_codigo_t` = '$enla',
                `id_cliente` = '$clie',
                `id_proveedor_internet` = '$prov'
                WHERE id_sucursal='$id'";
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

        case 'eliminar':
            $id = $_POST['id'];
            $matrizEliminar = $_POST['matrizEliminar']; // recibe el id a eliminar
            //crea la consulta de eliminacion
            foreach ($matrizEliminar as $id) {
                $ssql = "DELETE FROM sucursales WHERE id_sucursal = '$id'";
                $result = $base->consulta($ssql);
            }

            if ($result) {
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
    }
}
?>
