<?php
session_start();
if (!empty($_POST)) {
//Inicializa objeto de la base de datos y captura el evento actual
    require_once '../../include/mySQLData.php';
    $base = new mySQLData();
    $evento = $_POST['evento'];
//Almacena los valores del post a variables limpiandolas 
    $cate = trim($_POST["cmbCategoria"]);
    $esta = trim($_POST["cmbEstado"]);
    $acti = 'Stock';
    $cost = trim($_POST["txtCosto"]);
    $mode = trim($_POST["cmbModelo"]);

    date_default_timezone_set("America/El_Salvador");
    //se extrae el dia
    $dia = date("Y-m-d");
    switch ($evento) {
        case 'agregar':
            //busca el prefigo de la categoria del equipo a ingresar
            $result = $base->consulta("SELECT prefijo_id_categoria_equipo FROM categorias_equipos WHERE id_categoria_equipo='$cate'");
            $row = mysql_fetch_array($result);
            $cate = $row[0] . '-';
            //inicializa el id a utilizar.
            $idComp = 0;
            //consulta los id que contengan el prefijo del equipo a ingresar
            $result = $base->consulta("SELECT id_com_agente FROM componentes_agentes WHERE id_com_agente LIKE '" . $cate . "%'");
            //busca el id mayor eliminando todos los caracteres
            while ($row = mysql_fetch_array($result)) {
//              echo "<h2>$row[0]</h2>";
                $idTemp = preg_replace("/[^0-9\s]/", "", $row[0]);
//                $idTemp=preg_replace("-", "", $idTemp);
//                echo "<h2>$idTemp</h2>";
                if ($idTemp > $idComp) {
                    $idComp = $idTemp;
                }
            }
            //regerera el id con formato y le aumenta un valor para su ingreso
            $idComp = $cate . str_pad(++$idComp, 4, "0", STR_PAD_LEFT);
//            echo "<h2>$idComp</h2>";
//Se crea la sentencia de ingreso
            $ssql = "INSERT INTO `componentes_agentes`
                (`id_com_agente`,
                `fecha_ingreso_com_agente`,
                `estado_com_agente`,
                `actividad_com_agente`,
                `costo_com_agente`,
                `id_modelo`)

                VALUES('$idComp','$dia','$esta','$acti','$cost','$mode')";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('administrador/vistas/vistaComponentesAgentes.php', {}, function() {
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
            $ssql = "UPDATE `componentes_agentes` SET
                `estado_com_agente` = '$esta',
                `actividad_com_agente` = '$acti',
                `costo_com_agente` = '$cost',
                `id_modelo` = '$mode'
                WHERE id_com_agente='$id'";
            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('administrador/vistas/vistaComponentesAgentes.php', {}, function() {
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
                $ssql = "DELETE FROM componentes_agentes WHERE id_com_agente = '$id'";
                $result = $base->consulta($ssql);
            }

            if ($result) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('administrador/vistas/vistaComponentesAgentes.php', {}, function() {
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
