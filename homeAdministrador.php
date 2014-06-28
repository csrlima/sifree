<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es"> 
    <head>
        <meta charset="utf-8">
        <!--<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">-->
        <title>SIFree</title>
        <!--******COMPILACION DE CSS Y JAVASCRIPT PARA MEJORAR EL RENDIMIENTO :)*******-->
        <link type="text/css" rel="stylesheet" href="css/printbootstrap.css" media="print"/>  
        <link type="text/css" rel="stylesheet" href="css/CSS3Compilation.css" media="screen"/>
        <script src="js/JSCompilation.js"></script>
    </head>

    <body>
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">

                    <a class="navbar-brand nav-inicio" href="homeAdministrador.php?op=panel" title='Muestra la pantalla de bienvenida y tipos de Soportes con fines informativos.'>SIFree</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li id="nav-panel" ><a href="homeAdministrador.php?op=panel" title='Muestra la pantalla de bienvenida y tipos de Soportes con fines informativos.'>Panel principal</a></li>
                        <li id="nav-soporteTecnico"> <a href="homeAdministrador.php?op=soporteTecnico" title='Administra los Soportes Técnicos y Programados.'>Soporte Técnico</a></li>
                        <li id="nav-clientes"> <a href="homeAdministrador.php?op=clientes" title='Se muestra información de los Clientes.'>Clientes</a></li>
                        <li id="nav-sucursales"> <a href="homeAdministrador.php?op=sucursales" title='Muestra información de las Sucursales, Así también acceso a Soportes.'>Sucursales</a></li>
                        <li id="nav-estadisticas"> <a href="homeAdministrador.php?op=estadisticas" title='Muestra acceso a Estadísticas de Soporte Técnico y Control de Equipos.'>Estadisticas</a></li>
                        <li id="nav-controlEquipos"> <a href="homeAdministrador.php?op=controlEquipos" title='Acceso a la Administración de Inventario.'>Control de Equipos</a></li>
                        <li id="nav-controlEquipos"> <a href="logout.php" title='Cierre de Sesión de Usuario.'>Cerrar Sesión</a></li>
                    </ul>

                </div><!--/.navbar-collapse -->
            </div>
        </div>

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div id="cargando"></div>
            <div style="display: none" id="resultado"></div>
            <div id="section" class="container">

                <?php
                $modulo = "administrador";
                switch ($_REQUEST['op']) { 
                    case 'panel':
                        $pantalla = "panel";
                        break;
                    case 'soporteTecnico':
                        $pantalla = "soporteTecnico";
                        break;
                    case 'clientes':
                        $pantalla = "clientes";
                        break;
                    case 'sucursales':
                        $pantalla = "sucursales";
                        break;
                    case 'estadisticas':
                        $pantalla = "estadisticas";
                        break;
                    case 'controlEquipos':
                        $pantalla = "controlEquipos";
                        break;
                    default:
                        break;
                }

                require_once $modulo . '/' . $pantalla . '.php';
                ?>
            </div>
        </div>
        <footer>
            <p>&copy; Market Beat S.A. de C.V. 2014</p>
        </footer>
    </div> <!-- /container -->

    <script>
        $("#nav-<?php echo $_REQUEST['op'] ?>").addClass('active');
        //verifica que la sesion actual este activa
        function revisarSesion() {
            $.post("revisarSesion.php", {}, function(data) {
                if (data == "0") {
                    smoke.alert("La session ha expirado...\n Por favor inicie sesion nuevamente");
                    window.location.href = "http://127.0.0.1/soporte/";
                }
            });
        }
        revisarSesion();
        setInterval(revisarSesion, 60000);
    </script>
</body>
</html>
