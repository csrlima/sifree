<!DOCTYPE html>
<html lang="es"> 
    <head>
        <meta charset="utf-8">
        <!--<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">-->

        <title>SIFree</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/jquery-ui-1.10.3.custom.css" rel="stylesheet">

       </head>

    <body>
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">

                    <a class="navbar-brand nav-inicio" href="homeTecnico.php?op=inicio">SIFree</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li id="nav-panel" ><a href="homeTecnico.php?op=panel">Panel principal</a></li>
                        <li id="nav-sucursales"> <a href="homeTecnico.php?op=sucursales">Sucursales</a></li>

                    </ul>
                    <!--          <form class="navbar-form navbar-right" role="form">
                                <div class="form-group">
                                  <input type="text" placeholder="Email" class="form-control">
                                </div>
                                <div class="form-group">
                                  <input type="password" placeholder="Password" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-success">Sign in</button>
                              </form>-->
                </div><!--/.navbar-collapse -->
            </div>
        </div>

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div id="cargando"></div>
            <div id="resultado"></div>
            <div id="section" class="container">

            <?php
            $modulo = "tecnico";
            switch ($_REQUEST['op']) {
                case 'inicio':
                    $pantalla = "inicio";
                    break;
                case 'panel':
                    $pantalla = "panel";
                    break;
                case 'sucursales':
                    $pantalla = "sucursales";
                    break;
                default:
                    break;
            }

            require_once $modulo . '/' . $pantalla . '.php';
            ?>
        </div>
        </div>






    <!--
             Botón normal 
            <button type="button" class="btn btn-default">Normal</button>
    
             Muestra el botón de forma destacada para descubrir fácilmente
                 el botón principal dentro de un grupo de botones 
            <button type="button" class="btn btn-primary">Destacado</button>
    
             Indica una acción exitosa o positiva 
            <button type="button" class="btn btn-success">Éxito</button>
    
             Botón pensado para los mensajes con alertas informativas 
            <button type="button" class="btn btn-info">Información</button>
    
             Indica que hay que tener cuidado con la acción asociada al botón 
            <button type="button" class="btn btn-warning">Advertencia</button>
    
             Indica una acción negativa o potencialmente peligrosa 
            <button type="button" class="btn btn-danger">Peligro</button>
    
             Resta importancia al botón haciéndolo parecer un simple enlace,
                 aunque conserva tu comportamiento original de botón 
            <button type="button" class="btn btn-link">Enlace</button>
    
    
    
            <button type="button" class="btn btn-xs btn-primary">  
                <span class="glyphicon glyphicon-earphone"></span>Contacto</button>
    -->

    <footer>
        <p>&copy; Market Beat S.A. de C.V. 2014</p>
    </footer>
</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>

<script>
    $(document).ready(function() {
        $('.table').dataTable({ 
            "sPaginationType": "full_numbers"
        });
        
        
        $("#nav-<?php echo $_REQUEST['op'] ?>").addClass('active');
    } );    
</script>

</body>
</html>
