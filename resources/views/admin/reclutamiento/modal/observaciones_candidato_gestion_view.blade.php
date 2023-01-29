<style>
     .modd{
         height: 400px;
         overflow-y: auto;
     }

     .text-center { text-align: center; }
</style>
<div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h3>Observaciones <b>{{ $candidato->nombres . ' ' . $candidato->primer_apellido }}</b></h3>
</div>
<div class="modal-body modd">
     <div class="clearfix"></div>
     <div class="tabla table-responsive">
          <table class="table table-bordered table-hover ">
               <thead>
                    <tr>
                         <th class="text-center">N°</th>
                         <th class="text-center">Descripción</th>
                         <th class="text-center">Motivo descarte</th>
                         <th class="text-center">Usuario gestionó</th>
                         <th class="text-center">Fecha Creación</th>
                    </tr>
               </thead>
               <tbody>
                    @forelse($observaciones as $key => $obs)
                         <tr>
                              <td class="text-center">{{++$key}}</td>
                              <td class="text-center">{{$obs->observacion}}</td>
                              <td class="text-center">
                                   @if ($obs->motivo_descarte_id != null)
                                        {{ $obs->motivo_descarte->descripcion }}
                                   @endif
                              </td>
                              <td class="text-center">{{$obs->nombre}}</td>
                              <td class="text-center">{{$obs->created_at}}</td>   
                         </tr>
                    @empty
                         <tr>
                              <td colspan="4">No se encontraron registros</td>
                         </tr>
                    @endforelse
               </tbody>
          </table>
     </div>
     <div class="clearfix"></div>
</div>
<div class="modal-footer">
     <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>
