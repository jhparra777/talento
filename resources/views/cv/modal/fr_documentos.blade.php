
{!! Form::model($campos,["class"=>"form-horizontal form-datos-basicos", "role"=>"form","files"=>true,"id"=>"fr_documento"]) !!}
{!! Form::hidden("id") !!}
<div class="row">
    <h3 class="header-section-form">Documentos <span class='text-danger sm-text'> Campos con asterisco(*) son obligatorios</span></h3>
    <div class="col-md-12">
        <p class="text-primary set-general-font-bold">
            Por medio de esta pantalla usted podrá enviarnos un soporte de todos los documentos que acreditan cada uno de sus estudios, documento de identidad etc.
            Es opcional pero en caso de que sea llamado a un proceso, estos documentos pueden agilizar su contratación.
            <br/>
            Para incluir otro documento; llene los campos y haga clic en el botón "Guardar".<br/>
            <span class='text-danger'>* El sistema solo soporta imágenes.</span>
        </p>
        <p class="direction-botones-left">
            <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Documentos</a>
        </p>
    </div>
  
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="tipo_documento" class="col-md-4 control-label">Tipo Documento:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-6">
                {!! Form::select("tipo_documento_id",$tipoDocumento,null,["class"=>"form-control","id"=>"tipo_documento"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_documento_id",$errors) !!}</p>
    </div>

    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="archivo_documento" class="col-md-4 control-label">Archivo Documento (jpg,png,pdf,gif):<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::file("archivo_documento",["class"=>"form-control","placeholder"=>"Archivo Documento"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("archivo_documento",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="descripcion_documentos" class="col-md-4 control-label">Descripción:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::text("descripcion_archivo",null,["class"=>"form-control","placeholder"=>"Descripción Documento","id"=>"descripcion_documento"]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion_archivo",$errors) !!}</p>
    </div>
    <div class="col-sm-6 col-lg-12">
        <div class="form-group">
            <label for="fecha_vencimiento" class="col-md-4 control-label">Fecha Vencimiento:<span class='text-danger sm-text-label'>*</span> </label>
            <div class="col-md-6">
                {!! Form::text("fecha_vencimiento",null,["class"=>"form-control","id"=>"fecha_vencimiento","placeholder"=>"Fecha Vencimiento"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_vencimiento",$errors) !!}</p>
    </div>
</div><!-- fin row -->
<div class="col-md-12 separador"></div>
<p class="direction-botones-center set-margin-top">
    @if(isset($editar))
    <button class="btn btn-danger btn-gra" type="button" id="cancelar_documento"><i class="fa fa-floppy-o"></i>&nbsp;Cancelar</button>
    <button class="btn-quote" type="button" id="actualizar_documento"><i class="fa fa-floppy-o"></i>&nbsp;Actualizar</button>
    @else
    <button class="btn btn-primario btn-gra" type="button" id="guardar_documento"><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
    @endif
</p>
{!! Form::close() !!}<!-- /.fin form -->
<script>
    $(function () {
        $("#fecha_vencimiento").datepicker(confDatepicker);
    });
</script>