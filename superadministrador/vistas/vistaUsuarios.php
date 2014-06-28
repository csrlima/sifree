<?php
session_start();
require_once "../../include/mySQLData.php";
?>
<script type="text/javascript">
    $('.table').dataTable({ 
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10
    });
    
    function imprimir(){
        $('.print-section').printArea({mode: "popup",popWd:700});  
    }
    
    function nuevo(){
        $('#cargando').css("display", "block");
        $('#resultado').load('superadministrador/forms/frmUsuarios.php', {evento:'agregar'}, function() {
            $("#cargando").css("display", "none");
        });
    }

    function editar(){
        $('.chk').each(function(){
            if($(this).is(':checked')){
                var id=$(this).attr('id').replace(/\D/g,'');
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/forms/frmUsuarios.php', {evento:'modificar', id:id}, function() {
                    $("#cargando").css("display", "none");
                });
                return;
            }
        });  
 
      
    }
                
    function eliminar(){
        smoke.confirm('¿Esta seguro que desea eliminar el (los) elemento(s)?',function(event){
            if (event){
                var cont=0;
                var matrizEliminar=new Array();
                //recorre todos los check para obtener los que se van a eliminar
                $('.chk').each(function(){
                    if($(this).is(':checked')){
                        //extrate el id sin caracteres y lo almacena el la matriz
                        var id=$(this).attr('id').replace(/\D/g,'');
                        matrizEliminar[cont]=id;
                        cont++;
                    }
                });  
               
                $('#cargando').css("display", "block");
                $('#resultado').load('superadministrador/scripts/scUsuarios.php', {evento:'eliminar',matrizEliminar:matrizEliminar}, function() {
                    $("#cargando").css("display", "none");
                }); 
                
            }
        });

                  
    }
    
    function revisarCheckados(){
        var nCheckados=0;
        $('.chk').each(function(){
            if($(this).is(':checked')){
                nCheckados++;
            }
            switch (nCheckados){
                case 1:
                    estateButton('#btnEditar',true);  
                    estateButton('#btnEliminar',true);
                    break;
                case 0:
                    estateButton('#btnEditar',false); 
                    estateButton('#btnEliminar',false);
                    break;
                default:
                    estateButton('#btnEditar',false);
                    estateButton('#btnEliminar',true);
                    break;
            }
        });
    }
    
    //cambia el estado de enabled y disabled del botton editar    
    function estateButton(button,estate){
        if(estate){
            $(button).removeAttr('disabled');
            $(button).removeClass("paginate_button_disabled");
        }else{
            $(button).attr('disabled', 'true');
            $(button).addClass("paginate_button_disabled");
        }
    }
    
    
    
</script>



<div class="container-top"> 
    <div class="print-section">
        <h2>Vista de Usuarios</h2> 
    </div>
    <button type="button" class="btn btn-default" onclick="nuevo()">
        <span class="glyphicon glyphicon-plus-sign"></span>  Nuevo Usuario</button>
    <button type="button" id="btnEditar" class="btn btn-default paginate_button_disabled" onclick="editar()" disabled>
        <span class="glyphicon glyphicon-edit"></span> Editar</button>
    <button type="button" id="btnEliminar" class="btn btn-default paginate_button_disabled" onclick="eliminar()" disabled>
        <span class="glyphicon glyphicon-trash"></span> Eliminar</button>
        <!--este div es el que inserta el separador-->
    <div class="divider-vertical"></div>
    <button type="button" id="btnImprimir" class="btn btn-default paginate_button_disabled" onclick="imprimir()">
        <span class="glyphicon glyphicon-print"></span> Imprimir</button>
</div>

<hr>
<div>

    <div class="print-section">
        <table  class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Nick Acceso</th>
                    <th>Nombre Usuario</th>
                    <th>Cargo</th>
                    <th>Rol Usuario</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $base = new mySQLData();
                $result = $base->consulta("SELECT usuarios.id_usuario,nick_usuario,nombre_usuario,cargo_usuario,nombre_rol,telefono_usuario,correo_usuario 
                FROM usuarios,roles
                WHERE roles.id_rol=usuarios.id_rol
                ORDER BY usuarios.id_usuario");
                while ($row = mysql_fetch_array($result)) {
                    ?>
                    <tr>
                        <th><input type="checkbox" onclick="revisarCheckados()" class="chk" id="chk<?php echo $row[0] ?>"/></th>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td>
                        <td><?php echo $row[4] ?></td>
                        <td><?php echo $row[5] ?></td>
                        <td><?php echo $row[6] ?></td>
                    </tr>  

                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
