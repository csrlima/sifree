<!--ARCHIVO DE NAVEGACION, LLAMA A LA VISTA CON EL FILTRO POR DEFECTO-->
<script>

    function irSucursalesClientes(){
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/graficos/grSucurcalesCliente.php', {}, function() {
            $("#cargando").css("display", "none");
        });
    }
    
    function irListaSoportes(){
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaListaSoportes.php', {filtroTipo: '0',filtroClientes: '0'}, function() {
            $("#cargando").css("display", "none");
        });
    }    
    
    function irSoportesMesActual(){
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/graficos/grSoportesMesActual.php', {}, function() {
            $("#cargando").css("display", "none");
        });
    }    
    
    function irSoportesAtendidosSucursales(){
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/graficos/grSoportesAtendidosSucursales.php', {filtroClientes: '0', fecha: ''}, function() {
            $("#cargando").css("display", "none");
        });
    }  
    
    function irSoportesAtendidosUsuarios(){
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/graficos/grSoportesAtendidosUsuarios.php', {fecha: ''}, function() {
            $("#cargando").css("display", "none");
        });
    }    
    
    function irTiempoRespuestaSoportes(){
        $('#cargando').css("display", "block");
      $('#section').load('superadministrador/vistas/vistaListaTiempoRespuesta.php', {filtroTipo: '0',filtroClientes: '0'}, function() {
            $("#cargando").css("display", "none");
        });
    }    
    
    function irActividadEquiposCategoria(){
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/graficos/grActividadEquiposCategoria.php', {}, function() {
            $("#cargando").css("display", "none");
        });
    }    
    
    function irEstadoEquiposCategoria(){
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/graficos/grEstadoEquiposCategoria.php', {}, function() {
            $("#cargando").css("display", "none");
        });
    }

</script>
<h2>Estadísticas</h2>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">Estadísticas de Soporte Técnico</span>
    </div>
    <div class="list-group" >
        <a onclick="irSucursalesClientes()" class="list-group-item" title='En el Gráfico de Clientes se muestra el total de Sucursales que posee cada Cliente.'><span class="glyphicon glyphicon-stats"></span> Sucursales por Clientes</a>
        <a onclick="irSoportesMesActual()" class="list-group-item" title='Se muestra el total de Soportes del mes actual en Visitas y Llamadas realizados a cada Cliente.'><span class="glyphicon glyphicon-stats"></span> Soportes del Mes Actual</a>
        <a onclick="irSoportesAtendidosSucursales()" class="list-group-item" title='Se muestra los Soporte atendidos a un Cliente especifico en fechas determinadas según el filtro de busqueda seleccionado por el Usuario.'><span class="glyphicon glyphicon-stats"></span> Soportes Atendidos por Sucursales</a>
        <a onclick="irSoportesAtendidosUsuarios()" class="list-group-item" title='Se muestran los Soportes atendidos por Usuarios en fechas determinadas según el filtro de busqueda seleccionado.'><span class="glyphicon glyphicon-stats"></span> Soportes Atendidos por Usuarios</a>
        <a onclick="irListaSoportes()" class="list-group-item" title='Se listan los Soportes realizados con sus respectivas características, el filtro de busqueda puede ser por Tipo de Soporte, Clientes y por fecha.'><span class="glyphicon glyphicon-list"></span> Lista de Soportes</a>
        <a onclick="irTiempoRespuestaSoportes()" class="list-group-item" title='Se listan los Soportes realizados con sus respectivo Tiempo de Respuesta, el filtro de busqueda puede ser por Tipo de Soporte, Clientes y por fecha.'><span class="glyphicon glyphicon-list"></span> Tiempo de Respuesta a Soportes</a>
    </div>
</div>


<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">Estadísticas de Control de Equipos</span>
    </div>
    <div class="list-group" >
        <a onclick="irActividadEquiposCategoria()" class="list-group-item" title='El Gráfico muestra el total de los Equipos "Activos" o "Inactivos" por Categoría.'><span class="glyphicon glyphicon-stats"></span> Actividad de Equipos por Categoría</a>
        <a onclick="irEstadoEquiposCategoria()" class="list-group-item" title='El Gráfico muestra el total de los Equipos en Estado "Correctos", "Inservibles" o "Defectuoso" por Categoría.'><span class="glyphicon glyphicon-stats"></span> Estado de Equipos por Categoría</a>
    </div>
</div>
