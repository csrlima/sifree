<?php
class mySQLData {
    private $con;
    //funcion de conexión a la base de datos
    public function conectar() {
        //se define los parámetros de conexión. (modificarlos según la configuración de nuestra pc)
        $host="127.0.0.1";
        $usuario="root";
        $password="";
        $base="dbsifreev1";
        //se inicializa el objeto de conexión a la base de datos.
        $this->con = mysql_connect($host,$usuario,$password)
                //mensaje a mostrar en caso de error
                or die("Error al conectarse con la base de datos");
        //se selecciona la base de datos a conectar
        mysql_select_db($base)
                or die("Error al seleccionar la base de datos");
        return $this->con;
    }

    //funcion para realizar las consultas a la base de datos
    public function consulta($sentenciaSql) {
        //ejecucion de la sentencia sql recibida como parámetro.
        $query = mysql_query($sentenciaSql, $this->conectar());
        return $query;
    }

}
?>
