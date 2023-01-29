<div class="modal-header">
 <button aria-label="Close" class="close" data-dismiss="modal" type="button">
   <span aria-hidden="true"> × </span> </button>
    <h4 class="modal-title" id="myModalLabel"> Cargar Documentos Grupo Familiar</h4>
</div>
<div class="modal-body">
   {!! Form::open(["class"=>"form-horizontal", "role"=>"form","files"=>true,"id"=>"form_carga_documento"]) !!}

   {!! Form::hidden("grupo_familiar_id",$grupo_familiar_id) !!}
    <div class="row">
      <div class="col-12">
          <div class="form-group">
            <div class="col-md-4 set-general-font-bold set-fondo-detalle">
              <label>
                Tipo Documento:
                <span class='text text-danger'>*</span>
              </label>
            </div>
                        
            <div class="col-md-7 set-general-font set-fondo-detalle">
              {!!Form::select("tipo_documento_id",$tiposDocumentos,null,["class"=>"form-control","id"=>"tipo_documentos_id"]) !!}
            </div>
          </div>
      </div>

      <div class="col-12">
        <div class="form-group">
         <div class="col-md-4 set-general-font-bold set-fondo-detalle">
          <label>Documento:
            <span class="text text-danger">*</span>
          </label>
         </div>
             
          <div class="col-md-7 set-general-font set-fondo-detalle">
           <input type="file" name="documento" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <div class="col-md-4 set-general-font-bold set-fondo-detalle">
            <label>Descripción:<span class='text-danger sm-text-label'>*</span> </label>
          </div>
          <div class="col-md-7">
            {!! Form::text("descripcion",null,["class"=>"form-control","placeholder" => "Descripción documento","id"=>"descripcion_documento"]) !!}
          </div>
        </div>
      </div>
    </div>

        <br/>

        @if($documentos->count() <= 0)
         <div class="row">
          <div class="col-12">
           <h4> No se encontraron documentos. </h4>
          </div>
         </div>
        @else
          
        <div class="row">
          <div class="col-12">
              <table class="table table-striped custab">
                <thead>
                  <tr>
                    <th class="text-left"><strong>#</strong></th>
                    <th class="text-center"><strong>Tipo Documento</strong></th>
                    <th class="text-center"><strong>Descripción</strong></th>
                    <th class="text-center"><strong>Fecha Cargado</strong></th>
                    <th class="text-center"><strong>Acción</strong></th>
                  </tr>
                </thead>
                  <tbody>
                  @foreach($documentos as $count => $documento)
                    
                    <tr id="{{ $documento->id }}">
                     <td class="text-left">{{ ++$count }}</td>
                     <td class="text-center">{{ $documento->tipoDocumento->descripcion }}</td>
                     <td class="text-center">{{ $documento->descripcion }}</td>
                     <td class="text-center">{{ $documento->created_at }}</td>
                     <td class="text-center">
                      <a class='btn btn-info btn-sm ver_documento' id="edit-documento-{{ $documento->id }}" href="#">
                       <span class="glyphicon glyphicon-eye-open"></span></a>

                      <a href="#" class="btn btn-danger btn-sm eliminar_documento" id="delete-documento-{{ $documento->id }}" type="button"> <span class="glyphicon glyphicon-remove"></span>
                      </a>
                     </td>
                    </tr>
                  @endforeach
                  </tbody>
                 </table>
            </div>
          </div>
        @endif
    {!! Form::close() !!}
    
    <div class="modal-footer">
     <button class="btn btn-danger" data-dismiss="modal" type="button"> Cerrar </button>

     <button class="btn btn-primary" id="guardar_documento" type="button"> Guardar </button>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        //Guardar archivo HV
        $("#guardar_documento").on("click", function () {
            var formData = new FormData(document.getElementById("form_carga_documento"));
            
            $.ajax({
                type: "POST",
                data: formData,
                url: "{{ route('guardar_documento_familiar') }}",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                  console.log(response)
                    if (response.success) {
                      mensaje_success(response.mensaje);
                      location.reload();
                    }else{
                        mensaje_danger(response.mensaje);
                      
                    }
                },
                errors: function(error) {
                  console.log(error)
                }
            });
        });

        //Eliminar archiv HV
        $(".eliminar_documento").on("click", function (e) {
            e.preventDefault();

            let row = $(this).parents('td').parents('tr');
            let id = row.attr("id");

            if (confirm("Desea eliminar este documento?")) {
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "{{ route('eliminar_documento_familiar') }}",
                    success: function (response) {
                      if(response.success)
                      {
                        mensaje_success("Documento eliminado correctamente.");
                        row.remove();

                      }else{
                          mensaje_danger("problemas al eliminar el documento.");
                      }
                    }
                });
            }
        });

        //Ver archivo HV
        $(".ver_documento").on("click", function (e) {
            e.preventDefault();

            let row = $(this).parents('td').parents('tr');
            let id = row.attr("id");
            if (id) {
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "{{ route('ver_documento_familiar') }}",
                    success: function (response) {
                        var campos = response.documento;
                        window.open("{{ url('documentos_grupo_familiar/') }}/" + campos.nombre);
                    }
                });
            }
        });
    });
</script>