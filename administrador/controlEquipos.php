<script>
    function irInventarioEquipos() {
            $('#cargando').css("display", "block");
            $('#section').load('administrador/vistas/vistaInventarioEquipos.php',
                    {filtroCategorias1: '0', filtroPaises: '0', filtroCategorias2: '0', filtroCategorias3: '0', tab: '0'}, function() {
                $("#cargando").css("display", "none");
            });
        }
        function irComponentesAgentes() {
            $('#cargando').css("display", "block");
            $('#section').load('administrador/vistas/vistaComponentesAgentes.php', {filtro: '0'}, function() {
                $("#cargando").css("display", "none");
            });
        }
        function irMarcas() {
            $('#cargando').css("display", "block");
            $('#section').load('administrador/vistas/vistaMarcas.php', {}, function() {
                $("#cargando").css("display", "none");
            });
        }
        function irModelos() {
            $('#cargando').css("display", "block");
            $('#section').load('administrador/vistas/vistaModelos.php', {filtro: '0'}, function() {
                $("#cargando").css("display", "none");
            });
        }
        function irCategoriasEquipos() {
            $('#cargando').css("display", "block");
            $('#section').load('administrador/vistas/vistaCategoriasEquipos.php', {}, function() {
                $("#cargando").css("display", "none");
            });
        }
        function irTiposDaniosEquipos() {
            $('#cargando').css("display", "block");
            $('#section').load('administrador/vistas/vistaTiposDaniosEquipos.php', {}, function() {
                $("#cargando").css("display", "none");
            });
        }
        function irDiagnosticoReparacionEquipos() {
            $('#cargando').css("display", "block");
            $('#section').load('administrador/vistas/vistaDiagnosticoReparacionEquipos.php', {}, function() {
                $("#cargando").css("display", "none");
            });
        }
        function irIndividualComponentesAgente() {
            $('#cargando').css("display", "block");
            $('#section').load('administrador/vistas/vistaIndividualComponentesAgente.php', {filtro: '0'}, function() {
                $("#cargando").css("display", "none");
            });
        }   
</script>
<h2>Control de Equipos</h2>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">Administración de Inventario</span>
    </div>
    <div class="list-group" >
        <a onclick="irInventarioEquipos()" class="list-group-item" title='Muestra el Inventerio de los equipos en general, los que se encuentran Instalados y los que estan en Stock.'><span class="glyphicon glyphicon-book"></span> Inventario y Equipos</a>
        <a onclick="irComponentesAgentes()" class="list-group-item" title='Muestra información detallada de los componentes que pasan a formar un Agente.'><span class="glyphicon glyphicon-th"></span> Componentes de Agentes</a>
        <a onclick="irIndividualComponentesAgente()" class="list-group-item" title='Se debe seleccionar un Agente específico para conocer la información de los componentes que posee.'><span class="glyphicon glyphicon-th-large"></span> Detalle Componentes de un Agente</a>
        <a onclick="irMarcas()" class="list-group-item" title='Se Muestra la Marca de los productos que se usan, para conocer su calidad.'><span class="glyphicon glyphicon-star"></span> Marcas</a>
        <a onclick="irModelos()" class="list-group-item" title='Muestra el Modelo de los productos, para conocer la calidad de la Marca que se usa.'><span class="glyphicon glyphicon-adjust"></span> Modelos</a>
        <a onclick="irCategoriasEquipos()" class="list-group-item" title='Muestra los Equipos y Componentes en relación a la Categoría de los productos.'><span class="glyphicon glyphicon-th"></span> Categorias de Equipos y Componentes</a>
        <a onclick="irDiagnosticoReparacionEquipos()" class="list-group-item" title='Muestra información básica del Equipo en relación a Diagnóstico y Reparación del mismo.'><span class="glyphicon glyphicon-wrench"></span> Daños y Reparaciones de Equipos</a>
        <a onclick="irTiposDaniosEquipos()" class="list-group-item" title='Lista los Tipos de Daños y el número de Equipos según daños afines.'><span class="glyphicon glyphicon-warning-sign"></span> Tipos de Daños</a>
    </div>
</div>