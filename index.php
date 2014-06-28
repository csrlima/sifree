<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!--<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">-->

        <title>SIFree</title>

        <!-- Bootstrap core tes CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <!--<link href="jumbotron.css" rel="stylesheet">-->

        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div id="section" class="container" >

                <h2>SIFree Versión en Desarrollo</h2> 


                <form id="formu" action="logear.php" method="POST" class="form-horizontal" role="form">

                    <div class="form-group">
                        <label for="txtNick" class="col-sm-1 control-label">Nick</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="txtNick" name="txtNick" placeholder="Nick">
                        </div>
                    </div> 

                    <div class="form-group">
                        <label for="txtPass" class="col-sm-1 control-label">Contraseña</label>
                        <div class="col-sm-2">
                            <input type="password" class="form-control" id="txtPass" name="txtPass" placeholder="Contraseña">
                        </div>
                    </div>
                    <!--<div class="form-group">-->
                    <img src="img/SIFreeLogo.png" style="width: 400px; height: auto; float: right; vertical-align: top;">
                    <!--</div>-->
                    <button type="submit" class="btn btn-success">Iniciar Sesión</button>
                </form>

            </div>
        </div>

        <footer>
            <p>&copy;2014</p>
        </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<!--    <script src="js/bootstrap.min.js"></script>-->
</body>
</html>
