//Genera la previsualización del contrato
const generateContractPreview = (route) => {
	let newRoute = route.concat("?preview=true")
    window.open(newRoute, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=600")
}

//Petición para consulta en truora
const generateTruora = (user_id, req_id, route) => {
    $.ajax({
        type: "POST",
        data: {
         	user_id : user_id,
          	req_id : req_id
        },
        url: route,
        success: function(response) {
            if(response.success == true) {
                if (response.instancia == 1) {
                    mensaje_success('La consulta está en proceso. Puede tardar unos minutos hasta que TRUORA termine, posteriormente puedes consultar el resultado en el bóton "ESTATUS" del candidato. <br> <strong>Si el estado es "Generando" intenta abriendo nuevamente el botón "ESTATUS".</strong>')
                }                    
            }else{
                mensaje_danger('Ha ocurrido un error, intenta nuevamente.')
            }
        }
    })
}

//Tusdatos.co
function enviarTusDatos(user_id, req_id, route) {
    $.ajax({
        type: "POST",
        url: route,
        data: {
            user_id: user_id,
            req_id: req_id
        },
        success: function(response) {
            if (response.limite) {
                $.smkAlert({text: 'Se ha llegado al límite de consultas establecido.', type: 'danger', permanent: true})
            }else {
                if (response.success) {
                    //Insertar modal devuelto en el div
                    document.querySelector('#modalAjaxBox').innerHTML = response.view
                    $('#consultarTusDatosModal').modal('show')
                }else {
                    $.smkAlert({
                        text: 'La/el candidata/o debe tener un <b>tipo de documento</b> y <b>fecha de expedición</b> definido antes de consultar.',
                        type: 'danger'
                    });
                }
            }
        }
    })
}

function consultarTusDatos(user_id, req_id, route, tipoDoc, fechaExp) {
    if ($('#formTusdatos').smkValidate()) {
        $.ajax({
            type: "POST",
            data: {
                user_id : user_id,
                req_id : req_id,
                tipo_documento: tipoDoc,
                fecha_expedicion: fechaExp
            },
            url: route,
            beforeSend: function() {
                $.smkAlert({text: 'Consultando ...', type: 'info'})
            },
            success: function(response) {
                if(response.success == true) {
                    $.smkAlert({text: 'La consulta está en proceso. Puede tardar unos minutos hasta que la consulta termine, posteriormente puedes consultar el resultado en el bóton "ESTATUS" del candidato.', type: 'success', permanent: true})

                    document.getElementById('enviarTusdatos').setAttribute('disabled', 'disabled');

                    setTimeout(() => {
                        $('#consultarTusDatosModal').modal('hide')
                    }, 1000);

                    setTimeout(() => {
                        location.reload()
                    }, 2000);
                }else {
                    if (response.error) {
                        $.smkAlert({text: response.msg, type: 'danger', permanent: true})

                        setTimeout(() => {
                            $('#consultarTusDatosModal').modal('hide')
                        }, 1000);
                    }else {
                        $.smkAlert({text: 'Ha ocurrido un error, intenta nuevamente.', type: 'danger'})
                    }
                }
            }
        })
    }
}
//

//Cargar modal con horarios reservados para las citas del requerimiento
const loadReservedTimes = (obj, route) => {
    const reqId = obj.dataset.reqid

    $.ajax({
        type: "POST",
        url: route,
        data: {
            req_id: reqId
        },
        success: function(response){
            //Insertar modal devuelto en el div
            document.querySelector('#modalAjaxBox').innerHTML = response
            $('#horariosReservadosModal').modal('show')
        }
    })
}

//Mostrar modal de configuración BRYG
const configurarBRYG = (obj, route) => {
    const reqId = obj.dataset.reqid

    $.ajax({
        type: "POST",
        url: route,
        data: {
            req_id: reqId
        },
        success: function(response){
            if (response.configuracion != null) {
                document.querySelector('#radical').value = response.configuracion.radical
                document.querySelector('#genuino').value = response.configuracion.genuino
                document.querySelector('#garante').value = response.configuracion.garante
                document.querySelector('#basico').value = response.configuracion.basico

                valoresGrafico.radical = response.configuracion.radical
                valoresGrafico.genuino = response.configuracion.genuino
                valoresGrafico.garante = response.configuracion.garante
                valoresGrafico.basico = response.configuracion.basico

                panelDescripcionPerfil.innerHTML = `<span class="badge text-uppercase" style="font-size: 15px !important; background-color: gray;">${response.configuracion.perfil}</span>`
                panelDescripcionPerfil.removeAttribute('hidden')

                generarRadarBRYG()
            }

            $('#brygConfiguracionCuadrantes').modal('show')

            //document.querySelector('#guardarConfiguracionBryg').dataset.tipo = "requerimiento"
        }
    })
}

//Guardar configuración BRYG
const guardarConfiguracionBryg = (obj, route) => {
    const reqId = obj.dataset.reqid

    $.ajax({
        type: "POST",
        url: route,
        data: {
            req_id: reqId,
            radical: valoresGrafico.radical,
            genuino: valoresGrafico.genuino,
            garante: valoresGrafico.garante,
            basico: valoresGrafico.basico,
            perfil: perfilGlobal
        },
        beforeSend: function() {
            obj.setAttribute('disabled', true)
        },
        success: function(response) {
            $.smkAlert({text: 'Configuración guardada con éxito.', type: 'success'})
            obj.removeAttribute('disabled')

            setTimeout(() => {
                $('#brygConfiguracionCuadrantes').modal('hide')
            }, 800)
        }
    })
}

//Pruebas técnicas js
/*const pruebasTecnicas = (obj, route) => {
    let candidatoReq = obj.dataset.candidato_req
    let clienteId = obj.dataset.cliente

    $.ajax({
        type: 'POST',
        data: {
            candidato_req: candidatoReq
        },
        url: route,
        success: function(response) {
            $("#modal_peq").find(".modal-content").html(response);
            $("#modal_peq").modal("show");
        }
    });
}*/

/*
const confirmarPruebasTecnicas = (obj, route) => {
    if ($('#pruebaDigitacion').is(':checked')) {
        obj.setAttribute('disabled', true)

        $.ajax({
            type: 'POST',
            data: $("#frmPruebasTecnicas").serialize(),
            url: route,
            beforeSend: function() {
                obj.textContent = "Enviando ..."
            },
            success: function(response) {
                obj.removeAttribute('disabled')
                obj.textContent = "Confirmar"

                //Si el cargo o req no tiene configuración de la digitación
                if (response.configuracion) {
                    $.smkAlert({text: 'No hay configuraciones definidas para la prueba de digitación, debes crear una configuración para enviar candidatos.', type:'danger'})
                }

                if(response.success) {
                    $("#modal_peq").modal("hide");

                    mensaje_success("El(la) candidato(a) se ha enviado a pruebas.");

                    setTimeout(() => {
                        window.location.reload(true)
                    }, 1500)
                }
            },
            error: function() {
                $.smkAlert({text: 'Ha ocurrido un error, intenta nuevamente.', type:'danger'})
            }
        });
    }else {
        $.smkAlert({
            text: 'Debes seleccionar una prueba a enviar.',
            type: 'danger'
        })
    }
}
*/

//Mostrar modal de configuración Digitación
const configurarDigitacion = (obj, route) => {
    const reqId = obj.dataset.reqid

    $.ajax({
        type: "POST",
        url: route,
        data: {
            req_id: reqId
        },
        success: function(response) {
            $("#modal_peq").find(".modal-content").html(response);
            $("#modal_peq").modal("show");
        }
    })
}

//Guardar configuración Digitación
const guardarConfiguracionDigitacion = (obj, route) => {
    $.ajax({
        type: "POST",
        url: route,
        data: $('#frmConfiguracionReq').serialize(),
        beforeSend: function() {
            obj.setAttribute('disabled', true)
        },
        success: function(response) {
            $.smkAlert({text: 'Configuración guardada con éxito.', type: 'success'})
            obj.removeAttribute('disabled')

            setTimeout(() => {
                $('#modal_peq').modal('hide')
            }, 800)
        }
    })
}

//Mostrar modal de configuración Competencias
const configurarCompetencias = (obj, route) => {
    const reqId = obj.dataset.reqid

    $.ajax({
        type: "POST",
        url: route,
        data: {
            req_id: reqId
        },
        success: function(response) {
            $("#modal_gr").find(".modal-content").html(response);
            $("#modal_gr").modal("show");
        }
    })
}

//Guardar configuración Competencias
const guardarConfiguracionCompetencias = (obj, route) => {
    $.ajax({
        type: "POST",
        url: route,
        data: $('#frmConfiguracionCompetencias').serialize(),
        beforeSend: function() {
            obj.setAttribute('disabled', true)
        },
        success: function(response) {
            $.smkAlert({text: 'Configuración guardada con éxito.', type: 'success'})
            obj.removeAttribute('disabled')

            setTimeout(() => {
                $('#modal_gr').modal('hide')
            }, 800)
        }
    })
}

//Consulta de seguridad ventana
const consultaSeguridad = (route, routeTwo, a, b, c, d) => {
    // user_id -> b
    // req_id -> c

    $.ajax({
        type: "POST",
        data: "b=" + b + "&c=" + c,
        url: route,
        success: function(response) {
            if(response.limite === true) {
                $.smkAlert({text: 'Has alcanzado el limite máximo de consultas, contacta con el administrador del sistema.', type: 'danger', permanent: true})
            }else if(response.success === true) {
                $.smkConfirm({
                    text:'Este candidato ya fue consultado, ¿Deseas continuar?',
                    accept:'Aceptar',
                    cancel:'Cancelar'
                },function(res){
                    // Code here
                    if (res) {
                        const url = routeTwo;
                        const urldef = url.concat("?a="+a+"&b="+b+"&c="+c+"&d="+d);
                        window.open(urldef, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=600");
                    }else {
                        $.smkAlert({text: 'Consulta cancelada.', type: 'success'})
                    }
                });
            }else {
                const url = routeTwo;
                const urldef = url.concat("?a="+a+"&b="+b+"&c="+c+"&d="+d);
                window.open(urldef, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=600");
            }
        }
    })
}

const consultaSeguridadCore = (opcion, route, routeTwo, a, b, c, d) => {
    // cedula -> a
    // user_id -> b
    // req_id -> c
    // cliente -> d

    $.ajax({
        type: "POST",
        data: {
            numero_id: a,
            b: b,
            c: c,
            opcion: opcion
        },
        url: route,
        success: function(response) {
            if(response.limite === true) {
                $.smkAlert({text: 'Has alcanzado el limite máximo de consultas, contacta con el administrador del sistema.', type: 'danger', permanent: true})
            }else if(response.success === true) {
                $.smkConfirm({
                    text:'Este candidato ya fue consultado, ¿Deseas continuar?',
                    accept:'Aceptar',
                    cancel:'Cancelar'
                },function(res){
                    // Code here
                    if (res) {
                        $.ajax({
                            type: "POST",
                            url: routeTwo,
                            data: {
                                a: a,
                                b: b,
                                c: c,
                                d: d,
                                opcion: opcion
                            },
                            beforeSend: function() {
                                $.smkAlert({text: 'Consultando documento...', type: 'info'})
                            },
                            success: function (response) {
                                $.smkAlert({text: 'Consulta finalizada.', type: 'success', time: 3})

                                window.open(response.url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=600")
                            }
                        })
                    }else {
                        $.smkAlert({text: 'Consulta cancelada.', type: 'success'})
                    }
                });
            }else {
                $.ajax({
                    type: "POST",
                    url: routeTwo,
                    data: {
                        a: a,
                        b: b,
                        c: c,
                        d: d,
                        opcion: opcion
                    },
                    beforeSend: function() {
                        $.smkAlert({text: 'Consultando documento...', type: 'info'})
                    },
                    success: function (response) {
                        $.smkAlert({text: 'Consulta finalizada.', type: 'success', time: 3})

                        window.open(response.url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=600")
                    }
                })
            }
        }
    })
}

const exportarExcel = (route) => {
    window.open(route, "_blank")
}

const configurarExcel = (obj, route) => {
    const reqId = obj.dataset.reqid

    $.ajax({
        type: "POST",
        url: route,
        data: {
            req_id: reqId
        },
        success: function (response) {
            $("#modal_gr").find(".modal-content").html(response);
            $("#modal_gr").modal("show");
        }
    });
}

const configurarEV = (obj, route) => {
    const reqId = obj.dataset.reqid

    $.ajax({
        type: "POST",
        url: route,
        data: {
            req_id: reqId
        },
        success: function (response) {
            $("#modal_gr").find(".modal-content").html(response);
            $("#modal_gr").modal("show");
        }
    });
}

const comenzarFirmaContrato = (route) => {
    $('#btnIrFirmaContrato').attr('href', route);
    $('#modal_gr_local').modal({ backdrop: 'static', keyboard: false });
    //$("#modal_gr_local").modal("show");
}