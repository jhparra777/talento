@extends("admin.layout.master")
@section("contenedor")
    <style>
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .smk-error-msg{ display: none; }
        .smk-error-icon{ display: none; }

        .trumbowyg-box{ margin: 6px auto; }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h3>Nueva cláusula</h3>
            </div>
        </div>

        {!! Form::open(["id" => "frm_nueva_clausula", "data-smk-icon" => "fa fa-times-circle", "method" => "POST"]) !!}
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label" for="nombre_clausula">Nombre cláusula *</label>
                    {!! Form::text("nombre_clausula", null, [
                        "class" => "form-control",
                        "id" => "nombre_clausula",
                        "placeholder" => "Titulo que será mostrado",
                        "required" => "required"
                    ]); !!}
                </div>

                <div class="col-md-6">
                    <label class="control-label" for="estado_clausula">Estado cláusula *</label>
                    {!! Form::select("estado_clausula", ["" => "Seleccionar", 1 => "Activa", 0 => "Inactiva"], null, [
                        "class" => "form-control",
                        "id" => "estado_clausula",
                        "required" => "required"
                    ]); !!}
                </div>

                @if ($sitio_modulo->generador_firma_opcion == 'enabled')
                    <div class="col-md-12 mt-2">
                        <label class="control-label | tri-display--block" for="opcionFirma1">Tipo de firma *</label>

                        <label class="radio-inline">
                            <input type="radio" name="opcion_firma" id="opcionFirma1" value="firma_a"> Solo empleador
                        </label>

                        <label class="radio-inline">
                            <input type="radio" name="opcion_firma" id="opcionFirma2" value="firma_b"> Solo empleado
                        </label>

                        <label class="radio-inline">
                            <input type="radio" name="opcion_firma" id="opcionFirma3" value="firma_c" checked> Ambas firmas
                        </label>
                    </div>
                @endif
            </div>

            <div class="col-md-12 mt-3">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <b>Nota: Al crear el nuevo cuerpo de la cláusula NO es necesario que ingreses los espacios de firma del representante legal y el candidato, el sistema los genera automáticamente.</b>
                </div>
            </div>

            @include('admin.clausulas.include._buttons_informacion_generador')

            <div class="form-group">
                <div class="col-md-10 mt-1">
                    <label class="control-label" for="cargo_especifico">Contenido de la nueva cláusula *</label>

                    <div id="contenido_clausula" style="background-color: white;"></div>
                </div>
            </div>

            <div class="col-md-12 mt-2 text-right">
                <a href="{{ route('admin.clausulas.lista') }}" class="btn btn-warning">Volver</a>
                <button type="button" class="btn btn-info" id="guardar_clausula">Guardar</button>
            </div>
        {!! Form::close() !!}

        <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body" id="preview"></div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#contenido_clausula').trumbowyg({
                lang: 'es',
                btns: [
                    //['viewHTML'],
                    ['undo', 'redo'],
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    //['superscript', 'subscript'],
                    //['link'],
                    //['insertImage'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    //['fullscreen']
                    ['upload'],
                ],
                removeformatPasted: true,
                tagsToRemove: ['script', 'link'],
                plugins: {
                    upload: {
                        imageWidthModalEdit: true,
                        fileFieldName: 'imagen',
                        serverPath: window.location.origin.concat('/admin/enviar-imagen-generador'),
                        // success: (response) => {
                        // }
                    }
                }
            })
        })

        function addFlag(obj) {
            let flag = obj.dataset.flag

            var sel, range;

            if (window.getSelection) {
                // IE9 and non-IE
                sel = window.getSelection();
                if (sel.getRangeAt && sel.rangeCount) {
                    range = sel.getRangeAt(0);
                    range.deleteContents();

                    // Range.createContextualFragment() would be useful here but is
                    // non-standard and not supported in all browsers (IE9, for one)
                    var el = document.createElement("div");
                    el.innerHTML = "<b>"+flag+"</b>";

                    var frag = document.createDocumentFragment(), node, lastNode;
                    
                    while ( (node = el.firstChild) ) {
                        lastNode = frag.appendChild(node);
                    }
                    range.insertNode(frag);
                    
                    // Preserve the selection
                    if (lastNode) {
                        range = range.cloneRange();
                        range.setStartAfter(lastNode);
                        range.collapse(true);
                        sel.removeAllRanges();
                        sel.addRange(range);
                    }
                }
            }else if (document.selection && document.selection.type != "Control") {
                // IE < 9
                document.selection.createRange().pasteHTML("<b>"+flag+"</b>");
            }
        }

        let guardarClausula = document.querySelector('#guardar_clausula')

        guardarClausula.addEventListener('click', () => {
            if($('#frm_nueva_clausula').smkValidate()){
                let dataForm = $('#frm_nueva_clausula').serialize()

                $.ajax({
                    url: "{{ route('admin.guardar_nueva_clausula') }}",
                    type: 'POST',
                    data: dataForm,
                    beforeSend: function(){
                        $.smkAlert({
                            text: 'Guardando información ...',
                            type: 'info'
                        });

                        guardarClausula.disabled = true
                    },
                    success: function(response){
                        $.smkAlert({
                            text: 'Cláusula creada correctamente.',
                            type: 'success'
                        });

                        $.smkAlert({
                            text: 'Redireccionando ...',
                            type: 'info'
                        });

                        $('#preview').html(response.nuevo_cuerpo)

                        guardarClausula.disabled = false

                        let adicional_id = response.adicional_id

                        setTimeout(() => {
                            window.location.href = "{{ route('admin.clausulas.asociar_cargos', ":id") }}".replace(':id', adicional_id)
                        }, 2000)
                    },
                    error: function(response){
                        $.smkAlert({
                            text: 'Ha ocurrido un error, intente nuevamente.',
                            type: 'danger'
                        });
                    }
                });
            }
        })
    </script>
@stop