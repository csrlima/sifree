<?php
//inicio la sesion para tener acceso a la creacion de las variables de sesion
session_start();

//recibo el nombre y la contraseña ingresados por el usuario en el formulario de logeo o el relogin
$usuario = trim($_POST["txtNick"]);
$pass = trim($_POST["txtPass"]);

// importo la clase conexion
require_once "include/mySQLData.php";
//inicializo la clase para acceder a sus atributos atravez del objeto "base"
$base = new mySQLData();

//ejecuto la consulta buscando el nombre y la contraseña ingresados por el usuario
$result = $base->consulta("SELECT usuarios.id_usuario,nick_usuario,roles.id_rol,nombre_rol FROM usuarios,roles
WHERE roles.id_rol=usuarios.id_rol
AND nick_usuario='$usuario' AND contrasenia_usuario='$pass'");

//almaceno en "arreglo" en los resultados
while ($row = mysql_fetch_array($result)) {
//si los resultados son igual a 1 (solo puede haber un usuario con el mismo usuario y contraseña)
    if (mysql_num_rows($result) == 1) {
        //creo las variables de sesion tipo y usuario con los valores obtenidos en la consulta sql
        $_SESSION["nick"] = $row['nick_usuario'];
        $_SESSION["rol"] = $row['nombre_rol'];
        $_SESSION["id_rol"] = $row['id_rol'];
        $_SESSION["id_usuario"] = $row['id_usuario'];
        /* me redirecciono al index nuevamente pero en esta ocasion ya se ha creado la sesion 
          por lo que se autenticara con el scrip del index y mostrara la pantalla de bienvenida al usuario
         */
        switch ($_SESSION['id_rol']) {
            case '1' :
                header("location:homeSuperAdministrador.php?op=panel");
                break;
            case '2' :
                header("location:homeAdministrador.php?op=panel");
                break;
            case '3' :
                header("location:homeAgenteSoporte.php?op=panel");
                break;
            default :
                continue;
                break;
        }
    } else {
        ?>
        <h1>Datos erroneos!!!!!<h1>
                <!--Una alerta para indicar al usuario que ha cometido un error de logeo
                IMPORTANTE: EN ESTA OCASION LA REDIRECCION LA HAGO CON JAVASCRIPT PARA QUE PUEDA 
                MOSTRAR EL ALERT CON EL ERROR, SI LO HAGO CON PHP EL ALERT NO FUNCIONA
                -->
                <script language="javascript" type="text/javascript">
                    alert('Sus Datos son Incorrectos. Intente nuevamente');
                    document.location.href = "index.php";
                </script>
                <?php
            }
        }
        ?>
        <h1>Datos erroneos!!!!!</h1>
