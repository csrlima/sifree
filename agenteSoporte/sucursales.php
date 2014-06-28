<!--ARCHIVO DE NAVEGACION, LLAMA A LA VISTA CON EL FILTRO POR DEFECTO-->
<script>
    $(document).ready(function(){
        $('#cargando').css("display", "block");
        $('#section').load('agenteSoporte/vistas/vistaSucursales.php', {filtro:'0'}, function() {
            $("#cargando").css("display", "none");
        });
    });
</script>
