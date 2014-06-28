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
                    <a class="navbar-brand nav-inicio" href="homeSuperAdministrador.php?op=panel" title='Muestra la pantalla de bienvenida y tipos de Soportes con fines informativos.'>SIFree</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li id="nav-panel" ><a href="homeSuperAdministrador.php?op=panel" title='Muestra la pantalla de bienvenida y tipos de Soportes con fines informativos.'>Panel principal</a></li>
                        <li id="nav-soporteTecnico"> <a href="homeSuperAdministrador.php?op=soporteTecnico" title='Administra los Soportes Técnicos y Programados.'>Soporte Técnico</a></li>
                        <li id="nav-clientes"> <a href="homeSuperAdministrador.php?op=clientes" title='Se muestra información de los Clientes.'>Clientes</a></li>
                        <li id="nav-sucursales"> <a href="homeSuperAdministrador.php?op=sucursales" title='Muestra información de las Sucursales, Así también acceso a Soportes.'>Sucursales</a></li>
                        <li id="nav-estadisticas"> <a href="homeSuperAdministrador.php?op=estadisticas" title='Muestra acceso a Estadísticas de Soporte Técnico y Control de Equipos.'>Estadisticas</a></li>
                        <li id="nav-controlEquipos"> <a href="homeSuperAdministrador.php?op=controlEquipos" title='Acceso a la Administración de Inventario.'>Control de Equipos</a></li>
                        <li class="dropdown" id="nav-opcionesSistema" ><a class="dropdown-toggle" data-toggle="dropdown" href="#" title='Acceso a Preferencias del Sistema y Cierre de Sesión.'>Opciones del Sistema <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li> <a href="homeSuperAdministrador.php?op=opcionesSistema" title='Acceso a Administración del Sistema y de Soporte.'>Preferencias</a></li>
                                <li> <a href="logout.php" title='Cierre de Sesión de Usuario.'>Cerrar Sesión</a>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.navbar-collapse -->
            </div>
        </div>
        <div class="jumbotron">
            <div id="cargando"></div>
            <div id="resultado" style="display: none;"></div>
            <div id="section" class="container">
                <?php
                $modulo = "superadministrador";
                switch ($_REQUEST['op']) {
                    case 'panel':
                        $pantalla = "panel";
                        break;
                    case 'soporteTecnico':
                        $pantalla = "soporteTecnico";
                        break;
                    //case a agregar segun el filtro
                    case 'observacion':
                        echo "<h1>" . $_REQUEST['op'] . "</h1>";
                        $pantalla = "soporteTecnico";
                        break;
                    //fin del case
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
                    case 'opcionesSistema':
                        $pantalla = "opcionesSistema";
                        break;
                    default:
                        break;
                }

                require_once $modulo . '/' . $pantalla . '.php';
                ?>
            </div>
        </div>
        <footer>
            <p>&copy;2014</p>
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
