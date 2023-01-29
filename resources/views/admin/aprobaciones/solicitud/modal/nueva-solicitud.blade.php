<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
        Nueva solicitud
    </h4>
</div>
<div class="modal-body">
    {!! Form::open(["class"=>"form-horizontal", "role"=>"form", "id"=>"fr_nuevaSolicitud", "files"=>true]) !!}
    <div class="row">
        <div class="col-md-6 form-group">
            <label class="col-sm-12 pull-left" for="inputEmail3">
                Sede trabajo @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif
            </label>
            <div class="col-sm-12">
                {!! Form::select("ciudad_id", $sede, null,["required","class"=>"
                form-control","id"=>"ciudad_id"]) !!}
            </div>
            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12 pull-left" for="inputEmail3">
                Area trabajo @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif
            </label>
            <div class="col-sm-12">
                {!! Form::select("area_id", $areaFunciones, null,["class"=>"form-control","id"=>"area_id"]) !!}
            </div>
                
                <label id="area_id" class="hidden text text-danger"> Este campo es Requerido</label>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12 pull-left" for="inputEmail3">
                Subarea @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
            </label>
            <div class="col-sm-12">
                {!! Form::select("subarea_id",$subArea,null, ["class"=>"form-control subarea_id","id"=>"subarea_id"]); !!}
            </div>
             <label id="subarea_id" class="hidden text text-danger"> Este campo es Requerido</label>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Nombre solicitante @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
            </label>
            <div class="col-sm-12">
                {!! Form::hidden("solicitado_por",$user->id,["id"=>"solicitado_por"]); !!}
                {!! Form::text("solicitado_por_txt",strtoupper($user->name),["class"=>"form-control","placeholder"=>"Solicitante","id"=>"solicitado_por_txt"]); !!}
            </div>

        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Centro beneficio  @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
            </label>
            <div class="col-sm-12">
                {!! Form::select("centro_beneficio_id",$centro_beneficio, null,["class"=>"form-control","id"=>"centro_beneficio_id"]); !!}
            </div>
            <label id="centro_beneficio_id" class="hidden text text-danger"> Este campo es Requerido</label>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                centro costo  @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
            </label>
            <div class="col-sm-12">
                {!! Form::select("centro_costo_id",$centro_costo,null,["class"=>"form-control","id"=>"centro_costo_id"]); !!}
            </div>
                        <label id="centro_costo_id" class="hidden text text-danger"> Este campo es Requerido</label>
        </div>
         
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Cargar archivo  @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
            </label>
            <div class="col-sm-12">
                {!! Form::file("archivo_documento",["class"=>"form-control","placeholder"=>"Archivo Documento"]) !!}
            </div>
            <label id="archivo_documento" class="hidden text text-danger"> Este campo es Requerido</label>
        </div>
        <div class="col-md-6 form-group">
            <label class="col-sm-12" for="inputEmail3">
                Cargo solicitado @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co") <span>*</span> @endif 
            </label>
            <div class="col-sm-12">
                {!! Form::select("cargo_especifico_id",$cargo_especifico,null,["class"=>"form-control","id"=>"cargo_especifico_id"]); !!}
            </div>
            <label id="archivo_documento" class="hidden text text-danger"> Este campo es Requerido</label>
        </div>
        @if( session()->has('return_from_post_req') )
                {!! session()->get('partial_html') !!}
        @else
        <div class="here-put-fields-from-ajax">
        </div>
        @endif
        {!! Form::close() !!}
    </div>
</div>
<div class="mensajeNuevaSolicitud" style="display: none;">
    <h1>
        Solicitud
    </h1>
    <span>
        Solicitud registrada!
    </span>
</div>
<script>
    $(function(){
        /**
         * Traer resto del formulario que ta en la vista admin.aprobaciones.solicitud.modal.ajax-solicitud-nueva
         **/
         $('#cargo_especifico_id').on("change", function (e) {
            var id = $(this).val();
            $.ajax({
                url: "{{ route('admin.solicitudAjaxSolicitud') }}",
                type: 'POST',
                data: {cargo_especifico_id: id}
            })
            .done(function (response) {
                $('.here-put-fields-from-ajax').html(response);
            });
        });


        /**
         * Al selccionar el area de trabajo traer el subarea relacionado
         **/
        $("#area_id").change(function(){
            var valor = $(this).val();
            $.ajax({
                url: "{{ route('admin.selctAreaTrabajo') }}",
                type: 'POST',
                data: {id: valor},
                success: function(response){
                    var data = response.subarea;
                    $('#subarea_id').empty();
                     $('#subarea_id').append("<option value=''>Seleccionar</option>");
                    $.each(data, function(key, element) {
                        $('#subarea_id').append("<option value='" + key + "'>" + element + "</option>");
                    });

                    $('#centro_beneficio_id').empty();
                    $('#centro_beneficio_id').append("<option value=''>Seleccionar</option>");

                    $('#centro_costo_id').empty();
                    $('#centro_costo_id').append("<option value=''>Seleccionar</option>");
                }
            });
        });

        /**
         * Al selccionar el subarea traer los beneficios relacionados
         **/
        $("#subarea_id").change(function(){
            var valor = $(this).val();
            $.ajax({
                url: "{{ route('admin.selctSubArea') }}",
                type: 'POST',
                data: {id: valor},
                success: function(response){
                    var data = response.subarea;
                    $('#centro_beneficio_id').empty();
                    $('#centro_beneficio_id').append("<option value=''>Seleccionar</option>");
                    $.each(data, function(key, element) {
                        $('#centro_beneficio_id').append("<option value='" + key + "'>" + element + "</option>");
                    });

                    $('#centro_costo_id').empty();
                    $('#centro_costo_id').append("<option value=''>Seleccionar</option>");
                }
            });
        });

        /**
         * Al selccionar el benficio traer los costos relacionados
         **/
        $("#centro_beneficio_id").change(function(){
            var valor = $(this).val();
            $.ajax({
                url: "{{ route('admin.selctCosto') }}",
                type: 'POST',
                data: {id: valor},
                success: function(response){
                    var data = response.subarea;
                    $('#centro_costo_id').empty();
                    $('#centro_costo_id').append("<option value=''>Seleccionar</option>");
                    $.each(data, function(key, element) {
                        $('#centro_costo_id').append("<option value='" + key + "'>" + element + "</option>");
                    });
                }
            });
        });


    })
</script>
