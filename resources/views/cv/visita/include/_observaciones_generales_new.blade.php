<div class="panel panel-default item">
    <div class="panel-heading">
        <h3>Observaciones generales de la visita</h3>
    </div>
    <div class="panel-body">    
        <br>
        <form id="form-11" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Link de la visita virtual: <span class='text-danger sm-text-label'></span></label>
                        <input 
                        name="link_visita_virtual"
                        type="url"
                        class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                        value="{{ $candidatos->link_visita_virtual }}"
                        >
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Concepto General: <span class='text-danger sm-text-label'>*</span></label>
                        {!! Form::textarea("concepto_general_visita",
                        $candidatos->concepto_general_visita,
                        ["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "maxlength"=>"1500",
                        'rows' => 3,
                        "required"=>true,
                        "placeholder"=>""]); !!}
                    </div>
                </div>
                
            </div>
        </form>
    </div>
</div>


