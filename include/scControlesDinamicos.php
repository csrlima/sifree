<?php
session_start();
if ($_SERVER['HTTP_REFERER'] == "") {
    header('Location: http://www.radiomarketbeat.com/soporte');
    exit;
}
if (!empty($_POST)) {
//Inicializa objeto de la base de datos y captura el evento actual
    require_once 'mySQLData.php';
    $base = new mySQLData();
    $op = $_POST['op'];
    $id = $_POST['id'];

    switch ($op) {
        case 'modelosxcategoria':
            $result = $base->consulta("SELECT modelos.id_modelo,nombre_marca,nombre_modelo FROM marcas,modelos 
                WHERE marcas.id_marca=modelos.id_marca
                AND id_categoria_equipo='$id'");
            ?> 
            <select class="form-control" id="cmbModelo" name="cmbModelo">
                <option value="0">Seleccione una opción</option>
                <?php
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <option value="<?php echo $row[0]; ?>"><?php echo $row[1] . ' -- ' . $row[2]; ?></option>
                    <?php
                }
                ?> 
            </select>
            <?php
            break;
        case 'modelosxcategoriaevent':
            $result = $base->consulta("SELECT modelos.id_modelo,nombre_marca,nombre_modelo FROM marcas,modelos 
                WHERE marcas.id_marca=modelos.id_marca
                AND id_categoria_equipo='$id'");
            ?> 
            <select class="form-control" id="cmbModelo" name="cmbModelo" onchange="updatecmbEquipos()">
                <option value="0">Seleccione una opción</option>
                <?php
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <option value="<?php echo $row[0]; ?>"><?php echo $row[1] . ' -- ' . $row[2]; ?></option>
                    <?php
                }
                ?> 
            </select>
            <?php
            break;
        case 'componentesxmodelos':

            $result = $base->consulta("SELECT id_com_agente FROM componentes_agentes
                    WHERE estado_com_agente='Correcto' AND actividad_com_agente='Stock'
                    AND id_modelo='$id'");
            ?> 
            <select class="form-control" id="cmbComponente" name="cmbComponente">
                <?php
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                    <?php
                }
                ?> 
            </select>
            <?php
            break;
        case 'equiposxmodelos':

            $result = $base->consulta("SELECT id_equipo FROM equipos
                    WHERE estado_equipo='Correcto' AND actividad_equipo='Stock'
                    AND id_modelo='$id'");
            ?> 
            <select class="form-control" id="cmbEquipo" name="cmbEquipo">
                <?php
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                    <?php
                }
                ?> 
            </select>
            <?php
            break;
    }
}
?>