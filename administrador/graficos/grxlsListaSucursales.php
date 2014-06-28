<?php
$a_tofind = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'à', 'á', 'â', 'ã', 'ä', 'å'
   , 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø'
   , 'È', 'É', 'Ê', 'Ë', 'è', 'é', 'ê', 'ë', 'Ç', 'ç'
   , 'Ì', 'Í', 'Î', 'Ï', 'ì', 'í', 'î', 'ï'
   , 'Ù', 'Ú', 'Û', 'Ü', 'ù', 'ú', 'û', 'ü', 'ÿ', 'Ñ', 'ñ');
$a_replac = array('A', 'A', 'A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a', 'a'
   , 'O', 'O', 'O', 'O', 'O', 'O', 'o', 'o', 'o', 'o', 'o', 'o'
   , 'E', 'E', 'E', 'E', 'e', 'e', 'e', 'e', 'C', 'c'
   , 'I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'
   , 'U', 'U', 'U', 'U', 'u', 'u', 'u', 'u', 'y', 'N', 'n');

date_default_timezone_set("America/El_Salvador");
require_once('../../include/mySQLData.php');
$base = new mySQLData();
//se extrae el dia
$dia = date("Y-m-d");
$hora = date("H:i:s");
$filtroTipo = trim($_GET["filtroTipo"]);
$filtroClientes = trim($_GET["filtroClientes"]);
$fecha = trim($_GET["fecha"]);
//******************************TOP DEL INFORME********************************//
$cont='';
$top ="
<html> 
    <head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
  </head>

    <body>
        <h2>Lista de Soportes</h2>
        <table>
        <tr>
                    <th>Sucursal</th>                    
                    <th>Tipo Soporte</th>
                    <th>Problema</th>
                    <th>Diagnostico</th>
                    <th>Accion</th>
                    <th>Fecha Soporte</th>
        </tr>";        


//******************************CONTENIDO CENTRAL (TABLA)********************************//

            $ssql="SELECT 
                    `codigo_sucursal`,
                    `tipo_soporte`,
                    `nombre_problema`,
                    `diagnostico_soporte`,
                    `descrip_accion_soporte`,
                    `fecha_inicio_soporte`
                    FROM soportes,sucursales,clientes,paises,problemas
                    WHERE soportes.id_sucursal=sucursales.id_sucursal
                    AND sucursales.id_cliente=clientes.id_cliente
                    AND clientes.id_pais=paises.id_pais
                    AND problemas.id_problema=soportes.id_problema
                    AND clientes.id_cliente=sucursales.id_cliente";   
                if ($filtroTipo != '0') {
                    $ssql = $ssql . " AND tipo_soporte='$filtroTipo'";
                }
                if ($filtroClientes != 0) {
                    $ssql = $ssql . " AND clientes.id_cliente='$filtroClientes'";
                }
                if ($fecha != '') {
                    $ssql = $ssql . " AND fecha_inicio_soporte LIKE '$fecha%'";
                }
                
                $result = $base->consulta($ssql);
            while ($row = mysql_fetch_array($result)) {
                $cont=$cont. "
                <tr>
                        <td>$row[0] </td>
                        <td>$row[1] </td>
                        <td>$row[2] </td>
                        <td>$row[3] </td>
                        <td>$row[4] </td>
                        <td>$row[5] </td>
                </tr>
                    ";

            }

//******************************PIE DEL INFORME********************************//
          
            
   $button="
              </table>
                <div style='height: 10px'></div>
                <hr>
                <div style='height: 30px'></div>
                <p>Fecha de emision: $dia
                <br>
                Hora: $hora  </p>

</body>
</html>";

//SE CONCATENAN TODAS LAS PARTES Y SE GENERA EL PDF
$html=$top.$cont.$button;
header('Content-type: application/vnd.ms-excel; charset=iso-8859-1');
header('Content-Disposition: attachment; filename=reporte.xls');
header('Pragma: no-cache');
header('Expires: 0');
echo str_replace($a_tofind, $a_replac, $html);
