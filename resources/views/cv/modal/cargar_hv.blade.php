<div class="modal-header">
 <button aria-label="Close" class="close" data-dismiss="modal" type="button">
   <span aria-hidden="true"> × </span> </button>
    <h4 class="modal-title" id="myModalLabel"> Cargar Hoja de Vida @if(route("home") != "https://gpc.t3rsc.co") (Obligatorio) @endif </h4>
</div>
<div class="modal-body">
   {!! Form::open(["class"=>"form-horizontal", "role"=>"form","files"=>true,"id"=>"form_carga_hv"]) !!}
    <div class="row">
      <div class="col-md-12">
       <div class="col-md-4 set-general-font-bold set-fondo-detalle">
        <label> Adjuntar Archivo @if(route("home") == "https://gpc.t3rsc.co") (.PDF,.DOC o .DOCX) @endif <span class="text text-danger">*</span></label>
       </div>
           
        <div class="col-md-8 set-general-font set-fondo-detalle">
         <input type="file" name="archivo_hv" class="form-control" @if(route("home") != "https://gpc.t3rsc.co") accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" @else accept=".pdf,.doc,.docx" @endif >
        </div>
      </div>
    </div>

        <br/>

        @if($archivos->count() <= 0)
         <div class="row">
          <div class="col-md-12">
           <h4> No se encontraron archivos. </h4>
          </div>
         </div>
        @else
          
            <div class="container">
             <div class="row col-md-6">
               <table class="table table-striped custab">
                <thead>
                 <tr>
                  <th><strong>#</strong></th>
                  <th><strong>Archivo HV</strong></th>
                  <th><strong>Fecha Cargado</strong></th>
                  <th class="text-center"><strong>Acción</strong></th>
                 </tr>
                </thead>
                
                @foreach($archivos as $count => $archivo)
                  
                  <tr>
                   <td><div class="col-md-1">{{$count +1}}</div></td>
                   <td><div class="col-md-4">Documento {{$count+1}}</div></td>
                   <td>{{ $archivo->created_at }}</td>
                   <td class="text-center">
                    {{--<a class='btn btn-info btn-xs ver_hv' id="{{ $archivo->id }}" href="#">
                     <span class="glyphicon glyphicon-edit"></span> Ver </a>--}}

                     <a class='btn btn-info btn-xs' id="{{ $archivo->id }}" href='{{ route("view_document_url", encrypt("archivo_hv/"."|".$archivo->archivo)) }}' target="_blank">
                     <span class="glyphicon glyphicon-edit"></span> Ver </a>

                    <a href="#" class="btn btn-danger btn-xs eliminar_hv" id="{{ $archivo->id }}" type="button"> <span class="glyphicon glyphicon-remove"></span> Eliminar
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

     <button class="btn btn-primary" id="save_file_hv" type="button"> Guardar </button>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        //Guardar archivo HV
        $("#save_file_hv").on("click", function () {
            var formData = new FormData(document.getElementById("form_carga_hv"));

            $.ajax({
                type: "POST",
                data: formData,
                url: "{{ route('guardar_hv') }}",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                      alert("Se cargo la hoja de vida.");
                      location.reload();
                    }else{
                      if(response.errors){
                        alert("Problemas al cargar el documento.");
                      }
                    }
                }
            });
        });

        //Eliminar archiv HV
        $(".eliminar_hv").on("click", function (e) {
            e.preventDefault();

            var row = $(this).parents('td').parents('tr');
            var id = $(this).attr("id");
            if (confirm("Desea eliminar este registro?")) {
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "{{ route('eliminar_hv') }}",
                    success: function (response) {
                      if(response.success)
                      {
                        alert("Documento eliminado correctamente.");
                        row.remove();
                      }else{
                        if(response.errors)
                        {
                          alert("problemas al guardar.");
                        }                   
                      }
                    }
                });
            }
        });

        //Ver archivo HV
        $(".ver_hv").on("click", function (e) {
            e.preventDefault();

            var data_id = $(this).attr("id");
            if (data_id) {
                $.ajax({
                    type: "POST",
                    data: {id: data_id},
                    url: "{{ route('ver_hv') }}",
                    success: function (response) {
                        var campos = response.archivo;
                        window.open("{{ url('archivo_hv/') }}/" + campos.archivo);
                    }
                });
            }
        });
    });
</script>