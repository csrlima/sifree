<?php
session_start();
require_once "include/mySQLData.php";
$base = new mySQLData;
date_default_timezone_set("America/El_Salvador");
//se extrae el dia
$dia = date("Y-m-d");
?>
<style>
    div.mini-container{
        font-size: 12px;
        width: 150px;
        border-radius: 5px;
        height: 100px; 
        background-color: #f8f8f8; 
        padding: 3px; 
        margin: 10px;
        color: #03a1b2;
        display: inline-block;
        border: 2px solid #39b3d7;
        vertical-align: middle;
        text-align: center;

    }
    div.mini-container:hover{
        border: 3px solid #47a447;
        cursor: pointer;
    }

    div.mini-container a{
        color: #c62828;
        margin-top:-17%;
        display: block;
        font-size: 4em;
    }
    div.mini-container a:hover{
        text-decoration: none;
    }
</style>
<script type="text/javascript">
    function irSoportesObservacion() {
        $('#cargando').css("display", "block");
        $('#section').load('administrador/vistas/vistaSoporteTecnico.php', {filtroPaises: '0', filtroClientes: '0', opcion: 'observacion'}, function() {
            $("#cargando").css("display", "none");
        });
    }
    function irSoportesLLamadasCaducadas() {
        $('#cargando').css("display", "block");
        $('#section').load('administrador/vistas/vistaSoporteProgramado.php', {filtroPaises: '0', filtroClientes: '0', opcion: 'llamadasCaducadas'}, function() {
            $("#cargando").css("display", "none");
        });
    }
    function irSoportesVisitasCaducadas() {
        $('#cargando').css("display", "block");
        $('#section').load('administrador/vistas/vistaSoporteProgramado.php', {filtroPaises: '0', filtroClientes: '0', opcion: 'visitasCaducadas'}, function() {
            $("#cargando").css("display", "none");
        });
    }
    function irSoportesLLamadasPendientes() {
        $('#cargando').css("display", "block");
        $('#section').load('administrador/vistas/vistaSoporteTecnico.php', {filtroPaises: '0', filtroClientes: '0', opcion: 'llamadasPendientes'}, function() {
            $("#cargando").css("display", "none");
        });
    }
    function irSoportesVisitasPendientes() {
        $('#cargando').css("display", "block");
        $('#section').load('administrador/vistas/vistaSoporteTecnico.php', {ffiltroPaises: '0', filtroClientes: '0', opcion: 'visitasPendientes'}, function() {
            $("#cargando").css("display", "none");
        });
    }

</script>
<div style="float: left; margin-top: 10px"> 
    <h2>Bienvenido a SIFree</h2>
    <h4>Usuario: <span class="alert" style="margin-right: 20px;"><?php echo $_SESSION['nick']; ?></span> Acesso: <span class="alert"><?php echo $_SESSION['rol']; ?></span></h4>
</div>
<img src="img/market_beat.png" style="float: right; margin-top: 40px; height: 60px; width: auto; vertical-align: top;">
<div style="clear: both"></div>
<div style="display: inline-block; margin-right: 40px">
    <h3>Soportes</h3>
    <div class="mini-container" title='Acceso a Soportes en estado de "Observación".'>
        Soportes en Observación
        <a onclick="irSoportesObservacion()">
            <?php
            $result = $base->consulta("SELECT COUNT(id_soporte) FROM soportes WHERE estado_soporte='Observacion'");
            $row = mysql_fetch_array($result);
            echo $row[0];
            ?>
        </a>
    </div>
    <div class="mini-container" title='Acceso a Soporte Técnico de Lamadas en estado "Pendiente".'>
        LLamadas Pendientes
        <a onclick="irSoportesLLamadasPendientes()"> 
            <?php
            $result = $base->consulta("SELECT COUNT(id_soporte) FROM soportes WHERE tipo_soporte='Llamada' AND estado_soporte='Pendiente'");
            $row = mysql_fetch_array($result);
            echo $row[0];
            ?>
        </a>
    </div>
    <div class="mini-container" title='Acceso a Soporte Técnico de Visitas en estado "Pendiente".'>
        Visitas Pendientes
        <a onclick="irSoportesVisitasPendientes()">
            <?php
            $result = $base->consulta("SELECT COUNT(id_soporte) FROM soportes WHERE tipo_soporte='Visita' AND estado_soporte='Pendiente'");
            $row = mysql_fetch_array($result);
            echo $row[0];
            ?>
        </a>
    </div>
</div>
<div style="display: inline-block">
    <h3>Soportes Programados</h3>
    <div class="mini-container" title='Acceso a Soporte Programado de Llamadas "Caducadas".'>
        LLamadas Caducadas
        <a onclick="irSoportesLLamadasCaducadas()">
            <?php
            $result = $base->consulta("SELECT COUNT(id_soporte_programado) FROM soportes_programados WHERE fecha_soporte_programado < '$dia' AND tipo_soporte_programado='Llamada'");
            $row = mysql_fetch_array($result);
            echo $row[0];
            ?>
        </a>
    </div>

    <div class="mini-container" title='Acceso a Soporte Programado de Visitas "Caducadas".'>
        Visitas Caducadas
        <a onclick="irSoportesVisitasCaducadas()">
            <?php
            $result = $base->consulta("SELECT COUNT(id_soporte_programado) FROM soportes_programados WHERE fecha_soporte_programado < '$dia' AND tipo_soporte_programado='Visita'");
            $row = mysql_fetch_array($result);
            echo $row[0];
            ?>
        </a>
    </div>
</div>

