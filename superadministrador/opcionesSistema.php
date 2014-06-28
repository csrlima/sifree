<script>
    function irUsuarios() {
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaUsuarios.php', {}, function() {
            $("#cargando").css("display", "none");
        });
    }
    function irProveedoresInternet() {
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaProveedoresInternet.php', {filtro:'0'}, function() {
            $("#cargando").css("display", "none");
        });
    }
        function irTiposProblemasSoporte() {
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaTiposProblemasSoporte.php', {}, function() {
            $("#cargando").css("display", "none");
        });
    }
    function irPaises() {
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaPaises.php', {}, function() {
            $("#cargando").css("display", "none");
        });
    }
    function irRecomendaciones() {
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaRecomendacionesAccionesSoporte.php', {}, function() {
            $("#cargando").css("display", "none");
        });
    }
</script>


<h2>Preferencias del Sistema</h2>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">Administración del Sistema</span>
    </div>
    <div class="list-group" >
        <a onclick="irUsuarios()" class="list-group-item" title='Muestra la información de los Usuarios del Sistema.'><span class="glyphicon glyphicon-user"></span> Usuarios del Sistema</a>
        <a onclick="irPaises()" class="list-group-item" title='Se muestra el número de Sucursales de cada País.'><span class="glyphicon glyphicon-globe"></span> Países</a>
        <a onclick="irProveedoresInternet()" class="list-group-item" title='Muestra los Proveedores de internet contratados en cada País.'><span class="glyphicon glyphicon-cloud"></span> Proveedores de Internet</a>
    </div>
</div>


<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">Administración de Soporte</span>
    </div>
    <div class="list-group" >
        <a onclick="irTiposProblemasSoporte()" class="list-group-item" title='Se describen los posibles Tipos de Problemas en los Equipos.'><span class="glyphicon glyphicon-tags"></span> Tipos Problemas de Soporte</a>
        <a onclick="irRecomendaciones()" class="list-group-item" title='Se describen las posibles Acciones recomendadas ante Tipos de Problemas en los Equipos.'><span class="glyphicon glyphicon-heart"></span> Recomendaciones Acciones de Soporte</a>
    </div>
</div>
