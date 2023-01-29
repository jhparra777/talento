@extends("cv.layouts.master")

<?php
    $porcentaje = FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
?>

@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')
    <style>
        select option { text-transform: uppercase; }

        .btn-quote:disabled {
            cursor: not-allowed;
            background: gray;
        }
        .error{
            margin: 0;
        }
    </style>

    <div class="col-right-item-container">
        <div class="container-fluid">
            <div class="col-md-12 all-categorie-list-title bt_heading_3">
                <h1>Mis Documentos</h1>

                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>

            <div id="container_documentos">
                {!! Form::open(["class" => "form-datos-basicos", "role" => "form", "files" => true, "id" => "fr_documento"]) !!}
                    <input type="hidden" name="id" id="id-document">

                    <div class="row">
                        {{-- Instrucciones --}}
                        <div class="col-md-12">
                            <p class="text-primary set-general-font-bold">
                                En este módulo usted debe cargar los documentos básicos para que se ejecute un proceso de selección. Entre estos documentos le recomendamos que cargue la copia de su documento de identidad, diploma de su último año escolar cursado, (por ejemplo, el diploma de bachiller). Posteriormente haga clic en Guardar.
                                <br>
                                <span class='text-danger'>* El sistema soporta imágenes o preferiblemente en PDF; recuerda tener en cuenta los siguientes tips de ayuda en el cargue de tus documentos.</span>
                            </p>
                            
                            <p class="direction-botones-left">
                                <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i> Mis Documentos</a>
                            </p>
                        </div>

                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-sm-6 col-lg-6" style="text-align: initial;">
                                        <div class="form-group">
                                            <label for="tipo_documento" class="control-label">Tipo documento:<span class='text-danger sm-text-label'>*</span></label>

                                            {!! Form::select("tipo_documento_id", $tipoDocumento, null, ["class" => "form-control", "id" => "tipo_documento", "required" => "required"]) !!}
                                            <span class="error text-danger direction-botones-center tipo_documento_id"></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6" style="text-align: initial;">
                                        <div class="form-group">
                                            <label for="archivo_documento" class="control-label">
                                                Archivo documento (jpg,png,pdf):<span class='text-danger sm-text-label'>*</span>
                                            </label>

                                            <input 
                                                type="file" 
                                                class="form-control" 
                                                name="archivo_documento" 
                                                id="archivo-documento" 
                                                accept=".jpg,.png,.pdf,.jpeg" 
                                                required
                                            >
                                            <p class="error text-danger direction-botones-center archivo_documento"></p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6" style="text-align: initial;">
                                        <div class="form-group">
                                            <label for="descripcion_documentos" class="control-label">Descripción:<span class='text-danger sm-text-label'>*</span> </label>

                                            {!! Form::text("descripcion_archivo", null, ["class" => "form-control", "placeholder" => "Descripción documento", "id" => "descripcion_documento", "required" => "required"]) !!}
                                            <p class="error text-danger direction-botones-center descripcion_archivo"></p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6" style="text-align: initial;">
                                        <div class="form-group">
                                            <label for="fecha_vencimiento" class="control-label">
                                                Fecha vencimiento:
                                            </label>

                                            {!! Form::text("fecha_vencimiento", null, ["class" => "form-control", "id" => "fecha_vencimiento", "placeholder" => "Fecha vencimiento"]) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="alert alert-info alert-dismissible" role="alert" id="preview-documento-box" hidden>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            
                                            <h4>Foto final del documento</h4>
                
                                            <img src="#" alt="Preview foto documento" id="preview-documento">
            
                                            <p>
                                                <strong>Recuerda que debes finalizar el guardado del documento.</strong>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-right">
                                        <button class="btn-quote" type="button" id="tomar-foto" style="display: initial;" data-toggle="modal" data-target="#fotoDocumentoModal">
                                            <i class="fa fa-camera" aria-hidden="true"></i> Tomar foto
                                        </button>

                                        {{--  --}}
                                        <div class="display-contents" id="save-document-box" style="width: 164px;">
                                            <button class="btn-quote" type="button" id="guardar_documento" style="display: initial;">
                                                <i class="fa fa-floppy-o"></i> Guardar
                                            </button>
                                        </div>

                                        {{--  --}}
                                        <div id="edit-document-box" style="width: 300 px;" hidden>
                                            <button class="btn-quote" type="button" id="cancelar_documento" style="background: #d9534f; display: initial;">
                                                Cancelar
                                            </button>
    
                                            <button class="btn-quote" type="button" id="actualizar_documento" style="display: initial;">
                                                <i class="fa fa-floppy-o"></i> Actualizar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>

            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(["id" => "grilla-datos", "data-smk-icon" => "glyphicon-remove-sign"]) !!}
                        <p class="direction-botones-left">
                            <button type="button" class="btn btn-primario btn-peq" id="editar_documento"><i class="fa fa-pen"></i>Editar</button>
                            {{--<button type="button" class="btn btn-defecto btn-peq" id="ver_documento" ><i class="fa fa-eye"></i>Ver documento</button>--}}
                            <button type="button" class="btn btn-danger-t3 btn-peq" id="eliminar_documento"><i class="fa fa-trash"></i>Eliminar</button>
                        </p>

                        <div class="grid-container table-responsive">
                            <table class="table table-striped" id="tbl_documentos">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Documento</th>
                                        <th>Descripción</th>
                                        <th>Fecha creación</th>
                                        <th>Fecha vencimiento</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($documentos as $documento)
                                        <?php $pos = strpos($documento->descripcion_archivo, 'firmado'); ?>

                                        @if($pos === false)
                                            <tr id="tr_{{ $documento->id }}">
                                                <td scope="row"><input type="radio" value="{{ $documento->id }}" name="id" /></td>
                                                <td>
                                                    <a href='{{ route("view_document_url", encrypt("recursos_documentos/"."|".$documento->nombre_archivo."|"."$documento->tipo_documento_id")) }}' class="btn btn-defecto btn-peq text-primary" target="_blank">
                                                        {{ $documento->tipo_doc }}
                                                    </a>
                                                </td>
                                                <td>{{ $documento->descripcion_archivo }}</td>
                                                <td>{{ $documento->created_at }}</td>
                                                <td>{{ $documento->fecha_vencimiento }}</td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr id="no_registros">
                                            <td colspan="5">No hay registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>								
                            </table>
                        </div>
                    {!! Form::close() !!}
                </div>

                @if (route('home') == 'https://gpc.t3rsc.co')
                    <a class="btn btn-warning pull-right" href="{{route('cv.idiomas')}}" type="button">&nbsp;Siguiente</a>
                @else
                    <a class="btn btn-warning pull-right" href="{{route('video_perfil')}}" type="button">&nbsp;Siguiente</a>
                @endif
            </div>
        </div>

        {{-- Modal tomar foto --}}
        @include('cv.includes.documentos._modal_foto_documento')
    </div>

    <style>
        .display-contents{
            display: contents;
        }

        @media (max-width: 824px) {
            .modal-photo-custom {
                width: 680px !important;
            }
        }

        @media (max-width: 712px) {
            .modal-photo-custom {
                width: 600px !important;
            }

            .webcam-video {
                width: 567px !important;
                height: 335px !important;
            }
        }

        @media (max-width: 600px) {
            .modal-photo-custom {
                width: 560px !important;
            }

            .webcam-video {
                width: 528px !important;
                height: 380px !important;
            }
        }

        @media (max-width: 550px) {
            .modal-photo-custom {
                width: 500px !important;
            }

            .webcam-video {
                width: 468px !important;
                height: 352px !important;
            }
        }

        @media (max-width: 500px) {
            .modal-photo-custom {
                width: 466px !important;
            }

            .webcam-video {
                width: 434px !important;
                height: 336px !important;
            }
        }

        @media (max-width: 440px) {
            .modal-photo-custom {
                width: 428px !important;
            }

            .webcam-video {
                width: 397px !important;
                height: 312px !important;
            }
        }

        @media (max-width: 400px) {
            .modal-photo-custom {
                width: 350px !important;
            }

            .webcam-video {
                width: 318px !important;
                height: 250px !important;
            }
        }

        @media (max-width: 320px) {
            .modal-photo-custom {
                width: 320px !important;
            }

            .webcam-video {
                width: 292px !important;
                height: 292px !important;
            }
        }
    </style>

    <script src="{{ asset('js/cv/documentos/foto-cortar.js') }}"></script>

    <script>
        $(function () {
            var confDatepicker = {
                altFormat: "yy-mm-dd",
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                buttonImage: "img/gifs/018.gif",
                buttonImageOnly: true,
                autoSize: true,
                dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
                monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                yearRange: "1930:2050"
            };

            $(document).on("click", "input[name=id]", function () {
                $("#tbl_documentos tbody tr").removeClass("oferta_aplicada");
                if ($(this).prop("checked")) {
                    $(this).parents("tr").addClass("oferta_aplicada");
                }
            });

            $("#fecha_vencimiento").datepicker(confDatepicker);

            $(document).on("click", "#guardar_documento", function (e) {
                if($('form').smkValidate()) {
                    e.preventDefault();
                    $(this).prop("disabled", true);

                    let formData = new FormData(document.getElementById("fr_documento"));

                    //Validación si se toma foto y no se carga documento
                    if (finalPicture != 0) {
                        formData.append('foto-documento', finalPicture, 'foto-documento.png');
                    }

                    $.ajax({
                        type: "POST",
                        data: formData,
                        url: "{{ route('guardar_documento') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        error: function(response) {
                            if(response.status == 500) {
                                swal("Aviso", "Ha ocurrido un error, intenta nuevamente", "error", {
                                    button: {
                                        text: "Cerrar",
                                        closeModal: true,
                                    },
                                    animation: false
                                })
                            }else {
                                let errors = response.responseJSON.errors

                                for (const key in errors) {
                                    document.querySelector(`.${key}`).textContent = errors[key][0]
                                }

                                document.querySelector('#guardar_documento').removeAttribute('disabled')
                            }
                        }
                    }).done(function (response, data) {
                        if (response.success) {
                            var campos = response.documento;
                            $("#no_registros").remove();

                            var tr = $("<tr id='tr_" + campos.id + "' ></tr>");
                            tr.append($("<td></td>").append($("<input />", {type: "radio", name: "id", value: campos.id})));
                            tr.append($("<td></td>", {text: campos.tipo_doc}));
                            tr.append($("<td></td>", {text: campos.descripcion_archivo}));
                            tr.append($("<td></td>", {text: campos.created_at}));
                            tr.append($("<td></td>", {text: campos.fecha_vencimiento}));
                            $("#tbl_documentos tbody").append(tr);

                            $(document).scrollTop(0);

                            swal("Nuevo documento guardado", " ¿Desea agregar otro documento?", "info", {
                                buttons: {
                                    agregar: { text: "Agregar", className:'btn btn-success' },
                                    siguiente: { text: "Siguiente", className:'btn btn-warning' },
                                },
                            }).then((value) => {
                                switch (value) {
                                    case "agregar":
                                        setTimeout(() => {
                                            location.reload(true)
                                        }, 1000)
                                    break;

                                    case "siguiente":
                                        window.location.href = '{{ route('video_perfil').'#gum' }}'
                                    break;
                                }
                            })
                        }
                    }).fail(function (xhr, textStatus, thrownError) {
                        $.each($.parseJSON(xhr.responseText), function (ind, elem) { 
                            $('.'+ind).html(elem); 
                        })
                    })
                }
            });

            $("#editar_documento").on("click", function () {
                $("#eliminar_documento").prop("disabled", true);

                if (seleccionarLista("id") ) {
                    $.ajax({
                        type: "POST",
                        data: $("#grilla-datos").serialize(),
                        url: "{{ route('editar_documento') }}",
                        success: function (response) {
                            document.querySelector('#tipo_documento').value = response.data.tipo_documento_id
                            document.querySelector('#descripcion_documento').value = response.data.descripcion_archivo
                            document.querySelector('#fecha_vencimiento').value = response.data.fecha_vencimiento

                            document.querySelector('#id-document').value = response.data.id
                            document.querySelector('#id-document').removeAttribute('readonly')

                            //
                            document.querySelector('#save-document-box').setAttribute('hidden', 'hidden')
                            document.querySelector('#save-document-box').classList.remove('display-contents')
                            
                            document.querySelector('#edit-document-box').removeAttribute('hidden')
                            document.querySelector('#edit-document-box').classList.add('display-contents')
                        }
                    });
                }
            });

            $(document).on("click", "#actualizar_documento", function () {
                if($('form').smkValidate()) {
                    $("#eliminar_documento").prop("disabled", false);
                    let formData = new FormData(document.getElementById("fr_documento"));

                    //Validación si se toma foto y no se carga documento
                    if (finalPicture != 0) {
                        formData.append('foto-documento', finalPicture, 'foto-documento.png');
                    }

                    $.ajax({
                        type: "POST",
                        data: formData,
                        url: "{{ route('actualizar_documento') }}",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swal("Documento editado", "El documento se edito con éxito", "success");

                            setTimeout(() => {
                                location.reload(true)
                            }, 2000)
                        },
                        error: function(response) {
                            if(response.status == 500) {
                                swal("Aviso", "Ha ocurrido un error, intenta nuevamente", "error", {
                                    button: {
                                        text: "Cerrar",
                                        closeModal: true,
                                    },
                                    animation: false
                                })
                            }else {
                                let errors = response.responseJSON.errors

                                for (const key in errors) {
                                    document.querySelector(`.${key}`).textContent = errors[key][0]
                                }

                                document.querySelector('#guardar_documento').removeAttribute('disabled')
                            }
                        }
                    })
                }
            })

            $(document).on("click", "#cancelar_documento", function () {
                $("#eliminar_documento").prop("disabled", false);

                document.querySelector('#tipo_documento').value = ''
                document.querySelector('#descripcion_documento').value = ''
                document.querySelector('#fecha_vencimiento').value = ''

                document.querySelector('#id-document').value = ''
                document.querySelector('#id-document').setAttribute('readonly', true)

                //
                document.querySelector('#save-document-box').removeAttribute('hidden')
                document.querySelector('#save-document-box').classList.add('display-contents')
                
                document.querySelector('#edit-document-box').setAttribute('hidden', 'hidden')
                document.querySelector('#edit-document-box').classList.remove('display-contents')
            });

            $("#eliminar_documento").on("click", function () {
                if (seleccionarLista("id") && confirm("Desea eliminar este registro?")) {
                    $.ajax({
                        type: "POST",
                        data: $("#grilla-datos").serialize(),
                        url: "{{ route('eliminar_documento') }}",
                        success: function (response) {
                            $("#tr_" + response.id).remove();
                            alert("Se ha eliminado el registro.");
                        }
                    });
                }
            });

            $("#ver_documento").on("click", function () {
                if (seleccionarLista("id")) {
                    $.ajax({
                        type: "POST",
                        data: $("#grilla-datos").serialize(),
                        url: "{{ route('ver_file_documento') }}",
                        success: function (response) {
                            var campos = response.documento;
                            window.open("{{ url('recursos_documentos/') }}/" + campos.nombre_archivo);
                        }
                    });
                }
            });

            $(document).on("change","#tipo_documento",function(){
                $("#descripcion_documento").val($("#tipo_documento").find("option:selected").text())
            });
        });
    </script>
@stop