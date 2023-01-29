<div class="modal-header">
 <button aria-label="Close" class="close" data-dismiss="modal" type="button">
   <span aria-hidden="true"> × </span> </button>
    <h4 class="modal-title" id="myModalLabel"> Cargar Certificado Experiencia </h4>
</div>
<div class="modal-body">
   {!! Form::open(["class"=>"form-horizontal", "role"=>"form","files"=>true,"id"=>"form_carga_certificado"]) !!}
    <input type="hidden" name="experiencia_id" value="{{$experiencia_id}}">
    <div class="row">
      <div class="col-md-12">
       <div class="col-md-4 set-general-font-bold set-fondo-detalle">
        <label> Adjuntar Certificado  (.PDF, .PNG, .JPG O .JPEG)  <span class="text text-danger">*</span></label>
       </div>
           
        <div class="col-md-8 set-general-font set-fondo-detalle">
         <input type="file" name="certificado" class="form-control"  accept=".jpg,.jpeg,.png,.pdf">
        </div>
      </div>
    </div>

        <br/>

        @if($certificados->count() <= 0)
         <div class="row">
          <div class="col-md-12">
           <h4> No se encontraron certificados. </h4>
          </div>
         </div>
        @else
          
            <div class="container">
             <div class="row col-md-6">
               <table class="table table-striped custab">
                <thead>
                 <tr>
                  <th><strong>#</strong></th>
                  <th><strong>Certificado</strong></th>
                  <th><strong>Fecha Cargado</strong></th>
                  <th class="text-center"><strong>Acción</strong></th>
                 </tr>
                </thead>
                
                @foreach($certificados as $count => $archivo)
                  
                  <tr>
                   <td><div class="col-md-1">{{ ++$count }}</div></td>
                   <td><div class="col-md-4">{{ $archivo->documento->descripcion_archivo }}</div></td>
                   <td>{{ $archivo->created_at }}</td>
                   <td class="text-center">
                    <a class='btn btn-info btn-xs ver_certificado' id="{{ $archivo->id }}" href="#" title="Ver">
                     <span class="glyphicon glyphicon-eye-open"></span>  
                    </a>

                    <a href="#" class="btn btn-danger btn-xs eliminar_certificado" id="{{ $archivo->id }}" type="button" title="Eliminar"> 
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>
                   </td>
                  </tr>
                @endforeach
               </table>
             </div>
            </div>
        @endif
    {!! Form::close() !!}
    
    <div class="modal-footer">
     <button class="btn btn-danger" data-dismiss="modal" type="button"> Cerrar </button>

     <button class="btn btn-primary" id="guardar_certificado" type="button"> Guardar </button>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        //Guardar archivo HV
        $("#guardar_certificado").on("click", function () {
            var formData = new FormData(document.getElementById("form_carga_certificado"));

            $.ajax({
                type: "POST",
                data: formData,
                url: "{{ route('guardar_certificado_experiencia') }}",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        swal({
                            text: "Se cargo el certificado correctamente.",
                            icon: "success",
                            buttons: false
                        })
                      location.reload();
                    }else{
                        swal({
                            text: "Ocurrio un problema al cargar el certificado.",
                            icon: "error"
                        })
                      
                    }
                }
            });
        });

        //Eliminar archiv HV
        $(".eliminar_certificado").on("click", function (e) {
            e.preventDefault();

            var row = $(this).parents('td').parents('tr');
            var id = $(this).attr("id");
            swal({
                title: "¿Desea eliminar este registro?",
                //content: "¿Desea eliminar este registro?",
                icon: "warning",
                buttons: true,
                buttons: ["Cancelar", "Aceptar"]
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        data: {id: id},
                        url: "{{ route('eliminar_certificado') }}",
                        success: function (response) {
                          if(response.success)
                          {
                            swal({
                                text: "Certificado eliminado correctamente.",
                                icon: "success"
                            })
                            row.remove();
                          }else{
                            swal({
                                text: "Ocurrio un problema al eliminar el certificado.",
                                icon: "error"
                            })
                                             
                          }
                        }
                    });
                }
            });
        });

        //Ver archivo HV
        $(".ver_certificado").on("click", function (e) {
            e.preventDefault();

            var data_id = $(this).attr("id");
            if (data_id) {
                $.ajax({
                    type: "POST",
                    data: {id: data_id},
                    url: "{{ route('ver_certificado') }}",
                    success: function (response) {
                        var url = response.ruta;
                        window.open(url);
                    }
                });
            }
        });
    });
</script>