<h2>Formulario de Sucursales</h2>
<button type="button" class="btn btn-default btn-regresar" style="float: right">
    <span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>
<form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="txtCorreo" class="col-sm-1 control-label">Correo</label>
        <div class="col-sm-3">
            <input type="email" class="form-control" id="txtCorreo" placeholder="Correo Electronico">
        </div>
    </div> 

    <div class="form-group">
        <label for="txtPass" class="col-sm-1 control-label">Password</label>
        <div class="col-sm-3">
            <input type="password" class="form-control" id="txtPass" placeholder="Password">
        </div>
    </div>
   <div class="form-group">
        <label for="txtPass" class="col-sm-1 control-label">Seleccion</label>
        <div class="col-sm-3"> 
            <select class="form-control" id="txtPass" placeholder="Seleccione una opcion">
                <option>Valor 1</option>
                <option>Valor 2</option>
            </select>
        </div>
    </div>



    <div class="form-group">
        <div class="col-sm-2">
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Remember me
                </label>
            </div>
        </div>
    </div>
    <div class="form-group"> 
        <div class="col-sm-2">
            <button type="submit" class="btn btn-success">
                <span class="glyphicon glyphicon-save"></span> Guardar</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('.btn-regresar').click(function(){
        window.location.reload()
    })
</script>