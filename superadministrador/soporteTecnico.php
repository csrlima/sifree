<!--ARCHIVO DE NAVEGACION, LLAMA A LA VISTA CON EL FILTRO POR DEFECTO-->
<script>
    $(document).ready(function(){
        $('#cargando').css("display", "block");
        $('#section').load('superadministrador/vistas/vistaSoporteTecnico.php', {filtroPaises: '0',filtroClientes: '0',opcion:''}, function() {
            $("#cargando").css("display", "none");
        });
    });
</script>
