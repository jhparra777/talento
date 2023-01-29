<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
        Configurar Informe Preliminar al @if(route("home")=="https://gpc.t3rsc.co") Proceso @else Requerimiento @endif <strong>{{$requerimiento_id}}</strong>
    </h4>
</div>
<div class="modal-body">
    @if($valida == true)
        {!! Form::hidden("requerimiento_id", $requerimiento_id) !!}
        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-gears">
                </i>
                <h3 class="box-title">
                    ¿Cambiar Configuración Informe Preliminar?.
                </h3>
            </div>
            <div class="box-body">
                Este requerimiento ya fue configurado, donde ya se realizarón calificaciones algunos candidatos, si deseas configurar nuevamente el informe preliminar dar click en el boton "configurar nuevamente", <strong>se eliminaran todas las calificaciones que se le han realizado a los candidatos hasta el momento en el requerimiento.</strong>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-default pull-left" data-dismiss="modal" type="button">
                Cerrar
            </button>
            <button class="btn btn-warning" id="eliminar_informe_preliminar_evaluados" type="button">
                Configurar Nuevamente
                <i class="fa fa-arrow-circle-right">
                </i>
            </button>
        </div>
    @else
       
       <div class="box box-info">
        <div class="box-header">
         <i class="fa fa-gears"></i>
          <h3 class="box-title">
           Check a items que queremos aplicar en el @if(route("home")=="https://gpc.t3rsc.co") proceso @else requerimiento. No olvide agregar el ideal para cada competencia. @endif
          </h3>
        </div>
         
         <div class="box-body">
          <div class="search">
           <input type="text" id="busqueda" placeholder="Buscar ...">
            <i class="fa fa-search"></i>
          </div>
             
            {!! Form::open(["id"=>"fr_configuracion_informe_preliminar_requerimiento"]) !!}
            {!! Form::hidden("requerimiento_id", $requerimiento_id) !!}
                
                @foreach($transversal as $index => $item)
                  <div class="checkbox">
                   <div class="col-md-12">

                    {{--<table class="table table-stripped">
                      <tr>
                        <td>
                          {!! Form::checkbox("configuracion[]",$item->id,null,["class"=>"padre","data-id"=>$item->id]) !!} {{$item->descripcion}}
                        </td>
                        <td style="text-align: right;">
                          {!!Form::select("empresa_contrata",$criterios,["class"=>"form-control"]);!!}
                        </td>
                      </tr>

                    </table>--}}

                    <ul style="list-style-type: none;" id="lista_competencias">
                     <li> 
                      <div class="row">
                        <div class="col-sm-6">
                           {!! Form::checkbox("configuracion[]",$item->id,null,["class"=>"padre","data-id"=>$item->id]) !!} {{$item->descripcion}} 
                        </div>
                       <div class="pull-right valor">
                        <label style="color: green;">Ideal:</label>
                          {!!Form::select("criterios[$item->id]",$criterios,["class"=>"form-control"]);!!}

                       </div>
                    </div>

                     </li>
                    </ul>
                   </div>
                  </div>
                @endforeach
                {!!Form::close()!!}
            </div>
        </div>
        <div class="modal-footer">
         
         <button class="btn btn-default pull-left" data-dismiss="modal" type="button"> Cerrar </button>
         <button class="btn btn-primary" id="guardar_configuracion_informe_preliminar_requerimiento" type="button"> Guardar <i class="fa fa-arrow-circle-right"> </i> </button>
        </div>
    @endif
</div>

<script>

$(document).ready(function(){
  $("#lista_competencias .valor").hide();
  $("#lista_competencias .valor input").hide();
  $(".valor").hide();
  var busqueda = $('#busqueda'),
  titulo = $('#lista_competencias li');
 
 $(titulo).each(function(){

    var li = $(this);
    //si presionamos la tecla
    $(busqueda).keyup(function(){
    //cambiamos a minusculas
    this.value = this.value.toLowerCase();
    //
    var clase = $('.search i');
    if($(busqueda).val() != ''){
    $(clase).attr('class', 'fa fa-times');
    }else{
    $(clase).attr('class', 'fa fa-search');
    }
    if($(clase).hasClass('fa fa-times')){
    $(clase).click(function(){
    //borramos el contenido del input
    $(busqueda).val('');
    //mostramos todas las listas
    $(li).parent().show();
    //volvemos a añadir la clase para mostrar la lupa
    $(clase).attr('class','fa fa-search');
    });
    }
    //ocultamos toda la lista
    $(li).parent().hide();
    //valor del h3
    var txt = $(this).val();
    //si hay coincidencias en la búsqueda cambiando a minusculas
    if($(li).text().toLowerCase().indexOf(txt) > -1){
    //mostramos las listas que coincidan
      $(li).parent().show();
    }
    });
  });

 $(".padre").change(function(){

    if($(this).prop("checked")){
      $(this).parent().parent().find("div.valor").show();
    }
    else{
      $(this).parent().parent().find("div.valor").hide();
    }
   
  });
  
 
 
});

</script>

