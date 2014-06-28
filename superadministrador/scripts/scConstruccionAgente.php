<?php
session_start();
$idEquipo = $_POST['id'];
echo "<script>idEquipo='$idEquipo'</script>";
if (!empty($_POST)) {
//Inicializa objeto de la base de datos y captura el evento actual
    require_once '../../include/mySQLData.php';
    $base = new mySQLData();
    $evento = $_POST['evento'];
    switch ($evento) {
        case 'agregar':
            //Almacena los valores del post a variables limpiandolas 

            $idComp = trim($_POST["cmbComponente"]);

//Se crea la sentencia de ingreso
            $ssql = "INSERT INTO `det_componentes_agentes`
                (`id_det_com_agente`,
                `id_equipo`,
                `id_com_agente`)
                VALUES('','$idEquipo','$idComp')";


            //Se ejecuta y comprueba el estado de la consulta sql
            if ($base->consulta($ssql)) {

                $ssql = "UPDATE `componentes_agentes` SET
                    `actividad_com_agente` = 'Activo'
                    WHERE `id_com_agente` = '$idComp'";
                $base->consulta($ssql);
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaIndividualComponentesAgente.php', {filtro:idEquipo}, function() {
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
            $matrizEliminar = $_POST['matrizEliminar']; // recibe el id a eliminar
            //crea la consulta de eliminacion
            foreach ($matrizEliminar as $id) {
                $ssql = "DELETE FROM det_componentes_agentes WHERE id_equipo='$idEquipo' AND id_com_agente = '$id'";
                $result = $base->consulta($ssql);
                
                $ssql = "UPDATE `componentes_agentes` SET
                    `actividad_com_agente` = 'Inactivo'
                    WHERE `id_com_agente` = '$id'";
                $base->consulta($ssql);
            }

            if ($result) {
                ?>
                <script>
                    smoke.alert("Procesado exitosamente", function(e) {
                        $('#cargando').css("display", "block");
                        $('#section').load('superadministrador/vistas/vistaIndividualComponentesAgente.php', {filtro:idEquipo}, function() {
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
