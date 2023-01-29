<div class="col-md-12">
    <div class="page-header">
        <h4 class="tri-fw-600">
            DATOS PARA CONTRATACIÓN
        </h4>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="inputEmail3" class="control-label">Fecha Ingreso</label>
        <input type="date" name="fecha_inicio_contratos" value="" class="form-control fechas_ingresos | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="fecha_inicio_contratos">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="inputEmail3" class="control-label">Hora Ingreso</label>
        <input type="time" name="hora_ingreso" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="hora_ingreso">
    </div>
</div>
                        
<div class="col-md-6">
    <div class="form-group">
        <label class="control-label" for="inputEmail3">Tipo Ingreso *</label>
        <select class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="tipo_ingreso" name="tipo_ingreso">
            <option selected="">Seleccionar</option>
            <option value="1">Nuevo</option>
            <option value="2">Reingreso</option>
        </select>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="inputEmail3" class="control-label">Observaciones</label>
        <textarea name="observacionesContra" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" rows="2"></textarea>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="inputEmail3" class="control-label">Auxilio de Transporte *</label>
        <select name="auxilio_transporte" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">
            <option selected="">Seleccionar</option>
            <option value="No se Paga">No se paga</option>
            <option value="Total">Total</option>
            <option value="Mitad">Mitad</option>
        </select>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="control-label" for="inputEmail3">ARL *</label>
        {!!Form::text("arl","Colpatria",["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"arl","readonly"=>"readonly"])!!}
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="control-label" for="inputEmail3">Fecha Fin Contrato *</label>
        {!! Form::date("fecha_fin_contrato",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"fecha_fin_contrato"]) !!}
    </div>
</div>