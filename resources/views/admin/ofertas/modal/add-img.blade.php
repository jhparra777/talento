<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
        Cargar nueva imagen a la galería del cargo de esta oferta
    </h4>
</div>
<div class="modal-body">
    {!! Form::open(["class"=>"form-horizontal", "role"=>"form", "id"=>"fr_nueva_imagen_oferta", "files"=>true]) !!}
     {{ csrf_field() }}
     {!! Form::hidden("cargo_id",$cargo_id) !!}

        <p>La imagen debe ser de tipo png,jpg ó jpeg. Además, debe ser de dimensiones 190x190</p>
          <br>
        <div class="row">
          <div class="col-md-12">
           <div class="col-md-4 set-general-font-bold set-fondo-detalle">
            <label> Imagen <span class="text text-danger">*</span></label>
           </div>
               
            <div class="col-md-8 set-general-font set-fondo-detalle">
             <input type="file" name="imagen_oferta" class="form-control" accept=".png,.jpg,.jpeg" id="imagen_cargar">
            </div>
          </div>
        </div>
          
        
        
        {!! Form::close() !!}

     
  
  </div>
  <div class="modal-footer">

     <button type="button" class="btn btn-default" data-dismiss="modal"> Cerrar </button>
     <button type="button" class="btn btn-success" id="add-img-save"> Cargar </button>
     
     
  </div>

  <script type="text/javascript">
var banderaTamano = false;

function validar() {
  var o = document.getElementById('imagen_cargar');
  var foto = o.files[0];
  var c = 0;


  if (o.files.length == 0 || !(/\.(png|jpg|jpeg)$/i).test(foto.name)) {
    $.smkAlert({
        text: `Ingrese una imagen con formato .png,.jpg,.jpeg`,
        type: 'danger'
    })
    return false;

  }
  

  var img = new Image();
  img.src = URL.createObjectURL(foto);
  img.onload = function dimension() {
    if (this.width.toFixed(0) != 190 && this.height.toFixed(0) != 190) {
        $.smkAlert({
            text: `Las medidas deben ser: <b>190 x 190</b>`,
            type: 'danger'
        })

      
    } else {
      //alert('Imagen correcta :)');
      // El tamaño de la imagen fue validado
      banderaTamano = true;
      c=1;
      
      // Buscamos el formulario
      //var form = document.getElementById('fr_nueva_imagen_oferta');
      // Enviamos de nuevo el formulario con la bandera modificada.
      //form.submit();
    }
  };
  

  // Devolvemos false porque falta validar el tamaño de la imagen
  if(banderaTamano){

    return true;
  }
  else{
    return false;
  }
  
}
  </script>
  <script type="text/javascript">
      $(function(){
            $("#add-img-save").click(function(){
                if(validar()){
                var formData = new FormData(document.getElementById("fr_nueva_imagen_oferta"));
                $.ajax({
                    url: "{{ route('admin.oferta.add_img_save') }}",
                    type: "POST",
                    data:formData,
                     cache: false,
                    contentType: false,
                    processData: false,
                    /*beforeSend: function(){
                        //imagen de carga
                        $.blockUI({
                            message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                            css: {
                                border: "0",
                                background: "transparent"
                            },
                            overlayCSS:  {
                                backgroundColor: "#fff",
                                opacity:         0.6,
                                cursor:          "wait"
                            }
                        });
                    },*/
                    success: function(response) {
                        console.log(response.nombre_imagen);
                        
                        let ruta_img="{{asset('imagenes_cargos/')}}";
                        let otro=ruta_img.concat('/'+response.nombre_imagen);
                        $("#modal_peq").modal("hide");
                        $.smkAlert({
                                text: 'Imagen guardada con exito',

                                type: 'success',
                                position:'top-right',
                                time:3
                        });
                        $("#empty-message").hide();
                        $(".image-checkbox").each(function () {
     
                            $(this).removeClass('image-checkbox-checked');
                  
                        });

                        $('#container-img-oferta').append(`<div class='col-xs-4 col-sm-3 col-md-2 nopad text-center'><label class='image-checkbox image-checkbox-checked'><img class='img-responsive' src='${otro}' /><input type='radio' name='imagen' value='${response.id_imagen}' checked=true /><i class='fa fa-check hidden'></i></label></div>`

                        );

                        $(".image-checkbox").on("click", function (e) {

                            $(".image-checkbox").each(function () {
                 
                                $(this).removeClass('image-checkbox-checked');
                              
                            });
                          $(this).toggleClass('image-checkbox-checked');
                          var $checkbox = $(this).find('input[type="radio"]');
                          $checkbox.prop("checked",!$checkbox.prop("checked"))

                          e.preventDefault();
                        });

                    }
                });
            }
            });
      });
  </script>


