<?php
use App\Models\User;
use App\Models\AgenciaUsuario;
use App\Models\Requerimiento;
use App\Models\OfertaUser;
use App\Models\RequerimientoContratoCandidato;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

Route::get('test', ["uses" => "HomeController@testFunction"]);

Route::get("files/{slug}",["as" => "view_document_url", "uses" => "DocumentosController@viewDocument"]);
Route::post("presenta-encuesta-timer", ["as" => "admin.presenta_encuesta_timer", "uses" => "EncuestaController@presenta_encuesta_timer"]);
Route::get("gestionar-solicitud-referencia-de-estudio/{id}", ["as" => "admin.gestionar_solicitud_referencia_academica", "uses" => "ReclutamientoController@gestionar_solicitud_referencia_estudio"]);
Route::post("guardar-verificacion-referencia-estudio", ["as" => "admin.guarda_verificacion_referencia_estudio", "uses" => "ReclutamientoController@guardar_verificacion_referencia_estudio"]);
//Nuevas Rutas para Evaluacion SST Induccion
Route::post("enviar-evaluacion-sst", ["as" => "enviar_evaluacion_sst", "uses" => "ReclutamientoController@enviar_evaluacion_sst"]);

Route::post("confirmar-envio-evaluacion-sst", ["as" => "confirmar_envio_evaluacion_sst", "uses" => "ReclutamientoController@confirmar_envio_evaluacion_sst"]);

Route::get("realizar-evaluacion-sst/{req_id}", ["as" => "realizar_evaluacion_induccion_sst", "uses" => "EvaluacionSstController@realizar_evaluacion_sst"]);

Route::post("guardar-evaluacion-sst", ["as" => "save_evaluacion_sst", "uses" => "EvaluacionSstController@guardar_evaluacion_sst"]);

Route::post("firma-evaluacion-sst", ["as" => "save_firma_evaluacion_sst", "uses" => "EvaluacionSstController@guardar_firma_sst"]);

Route::post("guardar-fotos-sst", ["as" => "save_fotos_sst", "uses" => "EvaluacionSstController@guardar_fotos_sst"]);

Route::get("pdf-evaluacion-sst/{req_cand_id}", ["as" => "pdf_evaluacion_sst", "uses" => "EvaluacionSstController@pdf_evaluacion_sst"]);

Route::post("enviar-evaluacion-sst-masivo", ["as" => "admin.enviar_evaluacion_sst_masivo_view", "uses" => "ReclutamientoController@enviar_evaluacion_sst_masivo_view"]);

Route::post("confirmar-envio-evaluacion-sst-masivo", ["as" => "admin.confirmar_evaluacion_sst_masivo", "uses" => "ReclutamientoController@confirmar_envio_evaluacion_sst_masivo"]);
//Fin nuevas rutas para Evaluacion SST Induccion

//pre-form-visita
    Route::get("pre-form-visita/{visita_id}", ["as" => "realizar_form_visita_domiciliaria", "uses" => "VisitasDomiciliariasController@realizarPreFormVisita"]);
    Route::post("guardar-pre-visita", ["as" => "save_pre_visita", "uses" => "VisitasDomiciliariasController@guardarPreVisita"]);
    Route::post("guardar-images-pre-visita", ["as" => "save_images_pre_visita", "uses" => "VisitasDomiciliariasController@guardarImagesPreVisita"]);
    Route::post("firma-pre-form-visita", ["as" => "save_firma_pre_form_visita", "uses" => "VisitasDomiciliariasController@guardarFirmaPreForm"]);
//

Route::get("consentimientos-permisos-adicionales/{req_id}", [
    "as" => "completar_consentimiento_permisos_adic",
    "uses" => "ConsentimientosPermisosAdicionalesController@completar_consentimiento_permisos_adic"
]);

Route::post("guardar-consentimiento-permiso-adicional", [
    "as" => "guardar_consentimiento_permisos_adic",
    "uses" => "ConsentimientosPermisosAdicionalesController@guardar_consentimiento_permisos_adic"
]);

Route::get("documento-consentimientos-informados/{id_consentimiento}", [
    "as" => "pdf_consentimiento_permisos_adic", 
    "uses" => "ConsentimientosPermisosAdicionalesController@pdf_consentimiento_permisos_adic"
]);

Route::get("elempleo_carga_candidatos", ["as" => "elempleo_carga_candidatos", "uses" => "ElEmpleoController@getInfoApplyCandidatesEE"]);

Route::get("autocomplete_cuidades_all", ["as" => "autocomplete_cuidades_all", "uses" => "DatosBasicosController@autocomplete_cuidades_all"]);

Route::get("generar_carnet_general/{id}", ["as" => "generar_carnet_general", "uses" => "ReclutamientoController@generar_carnet_general"]);

//Rutas cierres mensuales
Route::get("cierre_mensual_eficacia", ["as" => "cierre_mensual_efica", "uses" => "ReportesController@cierre_mensual_eficacia"]);
Route::get("cierre_mensual_cancelaciones", ["as" => "cierre_mensual_cancel", "uses" => "ReportesController@cierre_mensual_cancelaciones"]);
Route::get("cierre_mensual_eficacia_llamada", ["as" => "cierre_mensual_llamad", "uses" => "ReportesController@cierre_mensual_eficacia_llamada"]);
//
Route::get("consulta", ["as" => "consulta", "uses" => "AdminController@consulta"]);
Route::get("orden_contratacion/{req}", ["as" => "orden_contratacion", "uses" => "ReclutamientoController@pdf_orden_contratacion"]);
Route::get("periodo_de_prueba", ["as" => "periodo_prueba", "uses" => "AdminController@periodo_prueba"]);

Route::get("generar-css-home", ["as" => "generar_css_home", "uses" => "CssController@cssHome"]);
Route::get("generar-css-cv", ["as" => "generar_css_cv", "uses" => "CssController@cssCv"]);

//Error Pagina
Route::get("pagenotfound", ["as" => "notfound", "uses" => "HomeController@pagenotfound"]);

Route::get("/", ["as" => "home", "uses" => "HomeController@index"]);
Route::get("/detalle/{oferta_id}", ["as" => "home.detalle_oferta", "uses" => "HomeController@detalle"]);


Route::get("/detalle_mensaje/{oferta_id}/{numero_id}/{llamada_id}", ["as" => "home.detalle_oferta_mensaje", "uses" => "HomeController@detalle_oferta_mensaje"]);

Route::get("habeas-pdf/{req_can_id}", ["as" => "home.habeas", "uses" => "ReclutamientoController@pdf_habeas"]);

Route::get("prueba-video-entrevista/{numero_id}/{req_id}", ["as"=>"home.video_entrevista", "uses"=>"HomeController@video_entrevista_candidato"]);

Route::get("responder_pregunta_entrevista", ["as" => "responder_pregunta_entre", "uses" => "EntrevistaController@responder_entre_pregu"]);

Route::get("renviar_email_asignacion", ["as" => "renviar_email_asignacion", "uses" => "ReportesController@correo_asignacion"]);

//Contratación virtual - Vista firma
Route::get("firma-contrato-laboral/{user_id}/{req_id}/{modulo}", [
	"as" => "home.firma-contrato-laboral", "uses" => "ContratacionVirtualController@firmaContratoCandidato"
]);

//Contratación virtual - Vista firma de documentos adicionales
Route::get("confirmar-documentos-adicionales/{user_id}/{contrato_id}/{modulo}",[
    "as" => "home.confirmar-documentos-adicionales", "uses" => "ContratacionVirtualController@confirmar_documentos_adicionales"
]);

//Contratación virtual - Guarda firma
Route::post("guardar-firma", ["as" => "home.guardar-firma", "uses" => "ContratacionVirtualController@guardarFirma"]);

//Contratación virtual - Guarda firma de de documentos adicionales
Route::post("guardar-firma-adicional", ["as" => "home.guardar-firma-adicional", "uses" => "ContratacionVirtualController@guardarFirmaAdicional"]);

//Contratación virtual - Vista videos
Route::get("confirmar-contratacion-video/{user_id}/{contrato_id}/{modulo}",[
	"as" => "home.confirmar-contratacion-video", "uses" => "ContratacionVirtualController@confirmar_contratacion_video"
]);

Route::post("guardar-firma-manual", ["as" => "home.guardar-firma-manual", "uses" => "ContratacionVirtualController@guardar_confirmacion_manual"]);

//confirmacion manuel de contratacion
//Contratación virtual - Vista videos
Route::get("confirmacion-manual-contratacion/{user_id}/{contrato_id}",[
	"as" => "home.confirmar-sin-video", "uses" => "ContratacionVirtualController@confirmar_sin_video"
]);

Route::post("guardar-firma-fotos", ["as" => "home.guardar_firma_fotos", "uses" => "ContratacionVirtualController@guardar_fotos"]);

Route::post("guardar-fotos-proceso-contrato", ["as" => "contratacion.virtual.foto.store", "uses" => "ContratacionVirtual\ContratacionVirtualFotoController@store"]);

Route::get("video-entrevista-virtual/{user_id}/{req_id}", ["as"=>"home.video_entrevista_virtual", "uses"=>"HomeController@video_entrevista_virtual_candidato"]);

//--- Prueba idioma
Route::get("prueba-idioma-virtual/{user_id}/{req_id}", ["as"=>"home.prueba-idioma-virtual", "uses"=>"HomeController@video_prueba_idioma_candidato"]);
Route::get("responder_pregunta_idioma", ["as" => "responder_pregunta_idioma", "uses" => "PruebasIdiomasController@responder_idioma_pregu"]);
Route::post("guardar_respuesta_idioma", ["as" => "admin.guardar_respuesta_idioma", "uses" => "PruebasIdiomasController@guardar_respu_idioma"]);
//-----

Route::post("guardar_respuesta_entrevista", ["as" => "admin.guardar_respuesta_entre", "uses" => "EntrevistaController@guardar_respu_pregu"]);

Route::post("responder_pregunta_entrevista_prueba", ["as" => "home.responder_pregunta_entre_prueba", "uses" => "HomeController@responder_entre_pregu"]);

Route::post("guardar_asistencia", ["as" => "home.guardar_asistencia_candidato", "uses" => "HomeController@guardar_asistencia_candidato"]);

Route::post("guardar_inasistencia", ["as" => "home.guardar_inasistencia_candidato", "uses" => "HomeController@guardar_inasistencia_candidato"]);

Route::post("guardar_respuesta_entrevista_prueba", ["as" => "home.guardar_respuesta_entre_prueba", "uses" => "HomeController@guardar_respu_pregu"]);

Route::get("aplicar_oferta/{req_id}", ["as" => "home.aplicar_oferta", "uses" => "HomeController@aplicar_oferta"]);

Route::get("preguntas-aplica-oferta/{req_id}/{cargo_id}", [
    "as" =>"home.responder_preguntas",
    "uses" => "HomeController@responder_preguntas_filtro"
]);

Route::get("preguntas-aplica-oferta-cv/{req_id}/{cargo_id}", [
    "as" => "home.responder_preguntas_oferta",
    "uses" => "HomeController@responder_preguntas_puntaje"
]);

Route::post("guardar_respuestas", ["as" =>"home.guardar_respuestas","uses" => "HomeController@guardar_respuestas"]);

Route::post("guardar_respuestas_puntaje", ["as" =>"home.guardar_respuestas_puntaje","uses" => "HomeController@guardar_respuestas_puntaje"]);

Route::get("preguntas_prueba_idioma/{id}/{cargo_id}", ["as" =>"home.responder_preguntas_prueba_idioma","uses" => "HomeController@responder_preguntas_prueba_idioma"]);
Route::post("guardar_respuestas_prueba_idioma", ["as" =>"home.guardar_respuestas_prueba_idioma","uses" => "HomeController@guardar_respuestas_prueba_idioma"]);
Route::post("pregunta_modal_idioma", ["as" => "admin.pregunta_modal_idioma", "uses" => "HomeController@responder_pregunta_idioma_oferta_view"]);
//--


Route::get("entrevista-multiple/{entrevista_id}", ["as" => "admin.ver_entrevista_multiple", "uses" => "EntrevistaMultipleController@ver_entrevista_multiple"]);

Route::get("buscar_empleo", ["as" => "empleos", "uses" => "HomeController@empleos"]);
Route::get("ver_videoperfil/{candidato}", ["as" => "ver_videoperfil", "uses" => "HomeController@ver_videoperfil"]);

Route::get("enviar_email/{oferta_id}", ["as" => "enviar_email", "uses" => "HomeController@getEmail"]);
Route::post('enviar_email2', ['as' => 'enviar_email2', 'uses' => 'HomeController@postEmail']);

//Generar pdf truora
Route::get("truora-pdf", ["as" => "ver_pdf_truora", "uses" => "Integrations\TruoraIntegrationController@ver_pdf_truora"]);

//Generar pdf tusdatos.co
Route::get("tri-reporte-generado", ["as" => "tusdatos_reporte", "uses" => "Integrations\TusDatosIntegrationController@consultarReportePdf"]);

//Generar pdf tusdatos.co para Estudio Virtual de Seguridad
Route::get("tri-reporte-generado-evs", ["as" => "tusdatos_reporte_evs", "uses" => "Integrations\TusDatosEvsIntegrationController@consultarReportePdfEvs"]);

//Validar edad de los hijos
Route::post('validar_edad', ['as' => 'edad_hijos', 'uses' => 'GrupoFamiliarController@ValidaEdad']);

/* ruta para buscar un candidato */
Route::post("buscar-candidato-por-cedula", ["as" => "ajaxBuscarCandidatoPorCedula", "uses" => "ReclutamientoController@buscarCandidatoPorCedula"]);

//recuperar contraseña
Route::get("recuperar_contrasena_cv", ["as" => "recuperar_contrasena_cv", "uses" => "LoginController@recuperar_contrasena_cv"]);

Route::get("informacion-del-trabajador/{id}", ["as" => "informacionTrabajador", "uses" => "HomeController@informacionTrabajador"]);

//Cancelar suscripción (correos)
Route::get("cancelar-suscripcion/{user_id}", ["as" => "cancelar_suscripcion", "uses" => "GestionCorreosController@cancelarSuscripcion"]);
Route::post('cancelar-suscripcion-post', ["uses" => "GestionCorreosController@cancelarSuscripcionProceso"])->name('cancelar_suscripcion_post');

//
Route::post('listar-clausulas-cargo', ["uses" => "ClausulaController@listar_clausulas_cargo"])->name('listar_clausulas_cargo_post');

//Excel lista usuarios sistema
Route::get("lista-usuarios-excel", [
    'as'   => 'admin.reportes.lista_usuarios_sistema',
    'uses' => 'ReporteListaUsuariosController@lista_usuarios_excel'
]);

Route::group(['prefix' => 'cv'], function () {
    //Aceptar políticas de privacidad
    Route::post("accept-privacy",["as" => "cv.privacyAccept", "uses" => "CvController@privacyAccept"]);

    Route::get("politica-de-tratamiento-de-datos-personales", [ "as" => "cv.tratamientoDatosPersonales", "uses" => "CvController@politicaTratamientoDatosPersonalesPDF"]);

    //Documentos contratacion
    Route::post("cv-buscar-dpto",["as" => "cv.selctDptos", "uses" => "DatosBasicosController@buscar_dptos"]);
    Route::post("cv-buscar-ciudades",["as" => "cv.selctCiudades", "uses" => "DatosBasicosController@buscar_ciudades"]);
    Route::post("verificar_codigo_contrato",["as"=>"verificar_codigo_contrato","uses"=>"HomeController@verificar_codigo_contrato"]);

    Route::post("verificar_codigo_contrato_async",["as"=>"verificar_codigo_contrato_async","uses"=>"HomeController@verificar_codigo_contrato_async"]);

    Route::post("codigo_firma_contrato",["as"=>"codigo_firma_contrato_view","uses"=>"HomeController@codigo_firma_contrato_view"]);
    Route::post("confirmacion_asistencia_contratacion", [
    	"as" => "confirmacion_asistencia_contratacion",
    	"uses" => "ContratacionController@confirmacion_asisntecia_contratacion"
    ]);
    Route::get("carga-documentos-contratacion", ["as" => "admin.carga_archivos_contratacion", "uses" => "ContratacionController@carga_documentos"]);
    Route::post("modal_documento_contratacion", ["as" => "admin.cargarDocumentoContratacion", "uses" => "ContratacionController@cargar_documento"]);

    Route::post("guardar-encuesta-sociodemografica", ["as" => "cv.guardar_encuesta_sociodemografica", "uses" => "ContratacionController@guardar_encuesta_sociodemografica"]);

    //Descargar contrato
    Route::get("contrato-laboral-recurso/{user_id}/{req_id}/{email?}", [
        "as" => "home.contrato-laboral-recurso", "uses" => "ContratacionVirtualController@generateContract"
    ]);

    //Prueba brig - Rutas
    Route::get('prueba-inicio', ['as' => 'cv.prueba_inicio', 'uses' => 'PruebaPerfilController@index']);

    Route::get('prueba-perfilamiento', ['as' => 'cv.prueba_perfilamiento', 'uses' => 'PruebaPerfilController@start']);
    Route::get('prueba-perfilamiento/siguiente', ['as' => 'cv.prueba_perfilamiento_siguiente', 'uses' => 'PruebaPerfilController@set_content']);

    Route::post('prueba_perfilamiento_save', ['as' => 'cv.prueba_perfilamiento_save', 'uses' => 'PruebaPerfilController@save_result']);

    Route::post('prueba-bryg-guardar-fotos', ['as' => 'cv.prueba_bryg_guardar_fotos', 'uses' => 'PruebaPerfilController@guardar_fotos']);

    //Prueba Excel Basico
    Route::get('prueba-excel-basico/{req_id}', ['as' => 'cv.prueba_excel_basico', 'uses' => 'PruebaExcelController@index_basico']);

    Route::post('prueba_excel_basico_save', ['as' => 'cv.prueba_excel_basico_save', 'uses' => 'PruebaExcelController@save_result_basico']);

    //Prueba Excel Intermedio
    Route::get('prueba-excel-intermedio/{req_id}', ['as' => 'cv.prueba_excel_intermedio', 'uses' => 'PruebaExcelController@index_intermedio']);

    Route::post('prueba_excel_intermedio_save', ['as' => 'cv.prueba_excel_intermedio_save', 'uses' => 'PruebaExcelController@save_result_intermedio']);

    Route::get('resultados-prueba/{user_id}/{req_id}/{resp_user_id}', ['as' => 'cv.ver_resultados_prueba', 'uses' => 'PruebaExcelController@verResultados']);
    //Fin rutas Excel

    //Prueba de Valores 1
    Route::get('prueba-ethical-values/{req_id}', ['as' => 'cv.prueba_valores_1', 'uses' => 'PruebaValoresController@index_prueba']);

    Route::post('prueba_valores_1_save', ['as' => 'cv.prueba_valores_1_save', 'uses' => 'PruebaValoresController@save_result_valores']);

    /* Cargar Archivo Hoja de Vida*/
    Route::post("cargar-hoja-vida", ["as" => "cargar_hv", "uses" => "CvController@cargar_hv"]);
    Route::post("guardar-hv-pdf", ["as" => "guardar_hv", "uses" => "CvController@guardar_hv"]);
    Route::post("eliminar-hv-pdf", ["as" => "eliminar_hv", "uses" => "CvController@eliminar_hv"]);
    Route::post("var-hv-pdf", ["as" => "ver_hv", "uses" => "CvController@ver_hv"]);

    /*
     * Prueba digitación CV
    */

    Route::get('digitacion-inicio', ['as' => 'cv.digitacion_inicio', 'uses' => 'PruebaDigitacionController@index']);
    Route::get('prueba-digitacion', ['as' => 'cv.prueba_digitacion', 'uses' => 'PruebaDigitacionController@start']);

    Route::post('prueba-digitacion-guardar', ['as' => 'cv.prueba_digitacion_guardar', 'uses' => 'PruebaDigitacionController@store']);

    /*
     * Prueba competencias CV
    */

    Route::get('competencias-inicio', ['as' => 'cv.competencias_inicio', 'uses' => 'PruebaCompetenciasController@index']);
    Route::get('prueba-competencias', ['as' => 'cv.prueba_competencias', 'uses' => 'PruebaCompetenciasController@start']);

    Route::post('prueba-competencias-guardar', ['as' => 'cv.prueba_competencias_guardar', 'uses' => 'PruebaCompetenciasController@store']);

    Route::post('prueba-competencias-guardar-fotos', ['as' => 'cv.prueba_competencias_guardar_fotos', 'uses' => 'PruebaCompetenciasController@guardar_fotos']);

    /* certificados */
    Route::post("certificados-estudios", ["as" => "certificados_estudios", "uses" => "CertificadoController@certificados_estudios"]);
    Route::post("certificados-experiencias", ["as" => "certificados_experiencias", "uses" => "CertificadoController@certificados_experiencias"]);
    Route::post("guardar-certificado-estudio", ["as" => "guardar_certificado_estudio", "uses" => "CertificadoController@guardar_certificado_estudio"]);
    Route::post("guardar-certificado-experiencia", ["as" => "guardar_certificado_experiencia", "uses" => "CertificadoController@guardar_certificado_experiencia"]);
    Route::post("ver-certificado", ["as" => "ver_certificado", "uses" => "CertificadoController@show"]);
    Route::post("eliminar-certificado", ["as" => "eliminar_certificado", "uses" => "CertificadoController@destroy"]);
    /* fin certificados */

    /* cargar documento grupo familiar */
    Route::get("cargar-documento-grupo-familiar", ["as" => "cargar_documento_grupo_familiar", "uses" => "GrupoFamiliarController@cargarDocumentoGrupoFamiliar"]);

    Route::post("guardar-documento-familiar", ["as" => "guardar_documento_familiar", "uses" => "DocumentoFamiliarController@store"]);

    Route::post("editar-documento-familiar", ["as" => "editar_documento_familiar", "uses" => "DocumentoFamiliarController@edit"]);

    Route::post("actualizar-documento-familiar", ["as" => "actualizar_documento_familiar", "uses" => "DocumentoFamiliarController@update"]);

    Route::post("eliminar-documento-familiar", ["as" => "eliminar_documento_familiar", "uses" => "DocumentoFamiliarController@destroy"]);

    Route::post("ver-documento-familiar", ["as" => "ver_documento_familiar", "uses" => "DocumentoFamiliarController@show"]);
    
    /* Login */
    Route::get('/', ['as' => 'login2', 'uses' => 'AuthController@getLogin']);
    Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
    //Route::get('login-poder', ['as' => 'login_poder', 'uses' => 'AuthController@getLogin_poder']);
    Route::post('login', ['as' => 'process_login', 'uses' => 'AuthController@postLogin']);
    //Route::post('login', ['as' => 'process_login_respu', 'uses' => 'AuthController@postLogin_respu']);
    Route::get('logout', ['as' => 'logout_cv', 'uses' => 'LoginController@logout']);

    Route::get("autocomplete_cargos", ["as" => "autocomplete_cargos", "uses" => "EstudiosController@autocomplete_cargos"]);

    //Adelantos de nomina (Candidato CartaApp)
    Route::get('adelanto-nomina', ['as' => 'cv.adelantos_nomina', 'uses' => 'CartaAppController@adelanto_nomina']);
    Route::post('codigo-adelanto-nomina', ['as' => 'codigo_adelanto_nomina', 'uses' => 'CartaAppController@codigo_adelanto_nomina']);
    
    Route::post("verificar-codigo-adelanto-nomina-async",["as"=>"verificar_codigo_adelanto_nomina_async","uses"=>"CartaAppController@verificar_codigo_adelanto_nomina_async"]);

    Route::post("save-solicitud-adelanto-nomina", ["as" => "save_solicitud_adelanto_nomina", "uses" => "CartaAppController@save_solicitud_adelanto_nomina"]);
    Route::post("completar-solicitud-adelanto-nomina", ["as" => "completar_solicitud_adelanto_nomina", "uses" => "CartaAppController@completar_solicitud_adelanto_nomina"]);
    
    //Redes Sociales
    Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
    Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

    /* Registro */
    Route::get('registro', ['as' => 'registrarse', 'uses' => 'AuthController@getRegister']);
    Route::get('registro-poder', ['as' => 'registrarse_poder', 'uses' => 'AuthController@getRegister_poder']);
    Route::post('registro', ['as' => 'process_registro', 'uses' => 'AuthController@postRegister']);
    //Route::post('registro-poder', ['as' => 'process_registro_poder', 'uses' => 'AuthController@postRegister_poder']);

    //Recordar contraseña envío email
    Route::get('recordar/email', ['as' => 'recordar_email', 'uses' => 'AuthController@getEmail']);
    Route::get('recordar/email-poder', ['as' => 'recordar_email_poder', 'uses' => 'AuthController@getEmail_poder']);
    Route::post('recordar/email', ['as' => 'recordar_email2', 'uses' => 'AuthController@postEmail']);
    Route::post('recordar/email-poder', ['as' => 'recordar_email2_poder', 'uses' => 'AuthController@postEmail_poder']);

    //Recordar contraseña actualizar clave
    Route::get('recordar/contrasena/{token}', ['as' => 'recordar_contrasena', 'uses' => 'AuthController@getReset']);
    Route::get('recordar/contrasena-poder/{token}', ['as' => 'recordar_contrasena_poder', 'uses' => 'AuthController@getReset_poder']);
    Route::post('recordar/contrasena', ['as' => 'recordar_contrasena2', 'uses' => 'AuthController@postReset']);
    Route::get('verificar_cuenta', ['as' => 'verificar_cuenta', 'uses' => 'LoginController@verificar_cuenta']);
    Route::get("termina_registro", ['middleware' => ['valida_cv'], "as" => "cv.termina_registro", "uses" => "CvController@termina_registro"]);
    Route::post("guardar_nuevo", ['middleware' => ['valida_cv'], "as" => "cv.guardar_nuevo", "uses" => "DatosBasicosController@nuevo_datos_basicos"]);

    // modulo ṕara gpc
     Route::get("autoentrevista", ["as" => "cv.autoentrevista", "uses" => "DatosBasicosController@autoentrevista"]);

     Route::get("guardar_autoentrevista", ["as" => "cv.guarda_autoentrevista", "uses" => "DatosBasicosController@autoentrevista"]);
    
    //Rutas para idioma
    Route::get("idiomas", ["as" => "cv.idiomas", "uses" => "DatosBasicosController@Idiomas"]);
    Route::post("guardar_idioma", ["as" => "guardar_idioma", "uses" => "DatosBasicosController@GuardarIdioma"]);   
    Route::get("autocompletar_idiomas", ["as" => "autocompletar_idiomas", "uses" => "DatosBasicosController@AutocompleteIdioma"]);        
    Route::post("editar_idioma", ["as" => "editar_idioma", "uses" => "DatosBasicosController@EditIdioma"]);
	Route::post("eliminar_idioma", ["as" => "eliminar_idioma", "uses" => "DatosBasicosController@EliminarIdioma"]);
	Route::post("actualizar_idioma", ["as" => "actualizar_idioma", "uses" => "DatosBasicosController@EditarIdioma"]);

    Route::group(['middleware' => ['valida_cv', "sesion_datos_basicos", "valida_datos_basicos"]], function () {
        Route::get("video-entrevista/{req_id}", ["as"=>"cv.video_entrevista", "uses"=>"EntrevistaController@video_entrevista_candidato"]);
        
        Route::get("dashboard", ["as" => "dashboard", "uses" => "CvController@index"]);
        Route::get("datos-basicos", ["as" => "datos_basicos", "uses" => "DatosBasicosController@datos_basicos"]);

        Route::get("video-perfil", ["as" => "video_perfil", "uses" => "DatosBasicosController@video_perfil"]);
        Route::post("ver_video_perfi", ["as" => "ver_video_perfil", "uses" => "DatosBasicosController@video_perfil_modal"]);

        Route::get("perfilamiento", ["as" => "perfilamiento", "uses" => "PerfilamientoController@index"]);
        Route::get("experiencia", ["as" => "experiencia", "uses" => "ExperienciasController@index"]);
        Route::get("estudios", ["as" => "estudios", "uses" => "EstudiosController@index"]);
        Route::get("referencias_personales", ["as" => "referencias_personales", "uses" => "ReferenciasPersonalesController@index"]);
        Route::get("grupo_familiar", ["as" => "grupo_familiar", "uses" => "GrupoFamiliarController@index"]);
        Route::get("documentos", ["as" => "documentos", "uses" => "DocumentosController@index"]);
        Route::get("cambiar_clave", ["as" => "cambiar_clave", "uses" => "LoginController@cambiar_clave"]);
        Route::post("actualizar_contrasena", ["as" => "actualizar_contrasena", "uses" => "LoginController@actualizar_contrasena"]);

        Route::post("guardar-datos-basicos", ["as" => "guardar_datos_basicos", "uses" => "DatosBasicosController@guardar_datos_basicos"]);

        Route::post("guardar-autoentrevista", ["as" => "guardar_autoentrevistas", "uses" => "DatosBasicosController@guardar_autoentrevista"]);

        Route::post("guardar-pregs-val", ["as" => "guardar_preguntas_val", "uses" => "DatosBasicosController@guardar_preguntas_val"]);
        Route::post("guardar-video-descripcion", ["as" => "guardar_video_descripcion", "uses" => "DatosBasicosController@guardar_video_descripcion"]);

        //Contratación virtual - Guarda confirmación de videos y contrato
        Route::post("guardar-confirmacion-contratacion", [
            "as" => "guardar_confirmacion_contratacion", "uses" => "ContratacionVirtualController@guardar_confirmacion_contratacion"
        ]);

        //Contratación virtual - Cancela contratación
        Route::post("cancelar-contratacion-candidato", [ "as" => "cancelar_contratacion_candidato", "uses" => "ContratacionVirtualController@cancelar_contratacion_candidato"]);

        Route::post("guardar_experiencia", ["as" => "guardar_experiencia", "uses" => "ExperienciasController@guardar_experiencia"]);
        Route::post("editar_experiencia", ["as" => "editar_experiencia", "uses" => "ExperienciasController@editar_experiencia"]);
        Route::post("actualizar_experiencia", ["as" => "actualizar_experiencia", "uses" => "ExperienciasController@actualizar_experiencia"]);
        Route::post("eliminar_experiencia", ["as" => "eliminar_experiencia", "uses" => "ExperienciasController@eliminar_experiencia"]);
        Route::post("cancelar_experiencia", ["as" => "cancelar_experiencia", "uses" => "ExperienciasController@cancelar_experiencia"]);

        Route::post("guardar_estudios", ["as" => "guardar_estudios", "uses" => "EstudiosController@guardar_estudios"]);
        Route::post("editar_estudio", ["as" => "editar_estudio", "uses" => "EstudiosController@editar_estudio"]);
        Route::post("actualizar_estudios", ["as" => "actualizar_estudios", "uses" => "EstudiosController@actualizar_estudios"]);
        Route::post("eliminar_estudio", ["as" => "eliminar_estudio", "uses" => "EstudiosController@eliminar_estudio"]);
        Route::post("cancelar_estudio", ["as" => "cancelar_estudio", "uses" => "EstudiosController@cancelar_estudio"]);

        Route::post("guardar_referencia", ["as" => "guardar_referencia", "uses" => "ReferenciasPersonalesController@guardar_referencia"]);
        Route::post("editar_referencia", ["as" => "editar_referencia", "uses" => "ReferenciasPersonalesController@editar_referencia"]);
        Route::post("cancelar_referencia", ["as" => "cancelar_referencia", "uses" => "ReferenciasPersonalesController@cancelar_referencia"]);
        Route::post("actualizar_referencia", ["as" => "actualizar_referencia", "uses" => "ReferenciasPersonalesController@actualizar_referencia"]);
        Route::post("eliminar_referencia_hv", ["as" => "eliminar_referencia_hv", "uses" => "ReferenciasPersonalesController@eliminar_referencia"]);

        Route::post("guardar_familia", ["as" => "guardar_familia", "uses" => "GrupoFamiliarController@guardar_familia"]);
        Route::post("editar_familiar", ["as" => "editar_familiar", "uses" => "GrupoFamiliarController@editar_familiar"]);
        Route::post("actualizar_familiar", ["as" => "actualizar_familiar", "uses" => "GrupoFamiliarController@actualizar_familiar"]);
        Route::post("eliminar_familiar", ["as" => "eliminar_familiar", "uses" => "GrupoFamiliarController@eliminar_familiar"]);
        Route::post("cancelar_familiar", ["as" => "cancelar_familiar", "uses" => "GrupoFamiliarController@cancelar_familiar"]);

        Route::post("guardar_documento", ["as" => "guardar_documento", "uses" => "DocumentosController@guardar_documento"]);
        Route::post("editar_documento", ["as" => "editar_documento", "uses" => "DocumentosController@editar_documento"]);
        Route::post("actualizar_documento", ["as" => "actualizar_documento", "uses" => "DocumentosController@actualizar_documento"]);
        Route::post("cancelar_documento", ["as" => "cancelar_documento", "uses" => "DocumentosController@cancelar_documento"]);
        Route::post("eliminar_documento", ["as" => "eliminar_documento", "uses" => "DocumentosController@eliminar_documento"]);
        Route::post("ver_file_documento", ["as" => "ver_file_documento", "uses" => "DocumentosController@ver_file_documento"]);

        Route::get("hv_pdf", ["as" => "cv.hv_pdf", "uses" => "CvController@pdf_hv"]);

        Route::post("guardar_perfilamiento", ["as" => "guardar_perfilamiento", "uses" => "PerfilamientoController@guardar_perfilamiento"]);
        Route::post("busqueda_perfilamiento", ["as" => "busqueda_pefilamiento", "uses" => "PerfilamientoController@busqueda_pefilamiento"]);

        Route::post("select_perfilamiento", ["as" => "select_pefilamiento", "uses" => "PerfilamientoController@select_pefilamiento"]);

        Route::post("detalle_oferta_modal", ["as" => "detalle_oferta_modal", "uses" => "OfertaController@detalle_oferta_modal"]);
        Route::post("aplicar_oferta", ["as" => "aplicar_oferta_post", "uses" => "OfertaController@aplicar_oferta"]);
        Route::post("verificar_oferta", ["as" => "verificar_oferta", "uses" => "OfertaController@verificar_oferta"]);
        Route::get("mis-ofertas", ["as" => "mis_ofertas", "uses" => "OfertaController@mis_ofertas"]);

        Route::get("mis-procesos", ["as" => "cv.mis_procesos_cv", "uses" => "MisProcesosController@lista_procesos"]);

        //Agendamiento rutas
        Route::post("reservar-horario-cita", ["as" => "cv.reservar_horario_cita_candidato", "uses" => "AgendamientoCitasController@reserva_cita_candidato_modal"]);

        Route::post("guardar-reserva-cita", ["as" => "cv.guardar_reservar_cita_candidato", "uses" => "AgendamientoCitasController@guardar_reserva_cita_candidato"]);
    });


    Route::get("autocomplete_cargo_desempenado", ["as" => "autocomplete_cargo_desempenado", "uses" => "ExperienciasController@autocomplete_cargo_desempenado"]);

    Route::get("autocomplete_cuidades", ["as" => "autocomplete_cuidades", "uses" => "DatosBasicosController@autocomplete_cuidades"]);
    
    Route::get("autocomplete_cuidades_all", ["as" => "autocomplete_cuidades_all", "uses" => "DatosBasicosController@autocomplete_cuidades_all"]);

    Route::get("autocomplete_universidades", ["as" => "autocomplete_universidades", "uses" => "DatosBasicosController@autocomplete_universidades"]);

    Route::get("autocomplete_usuarios", ["as" => "autocomplete_usuarios", "uses" => "ClientesController@autocomplete_usuarios"]);

    Route::get("autocomplete_cargos", ["as" => "autocomplete_cargos", "uses" => "PerfilamientoController@autocomplete_cargos"]);
});
Route::get("ver-video-perfil", ["as" => "ver_video_perfil_admin", "uses" => "DatosBasicosController@ver_video_perfil"]);

Route::get("autocomplete_cuidades", ["as" => "autocomplete_cuidades2", "uses" => "DatosBasicosController@autocomplete_cuidades"]);

Route::get("autocomplete_cuidades_all", ["as" => "autocomplete_cuidades_all", "uses" => "DatosBasicosController@autocomplete_cuidades_all"]);

Route::group(['prefix' => 'req'], function () {
    Route::post("observacion_gestion", ["as" => "req.observaciones_req", "uses" => "ReclutamientoController@observaciones_gestion"]);
	Route::post("guardar_observacion_gestion", ["as" => "req.guardar_observaciones_gestion", "uses" => "ReclutamientoController@guardar_observaciones_gestion"]);

    Route::get('/', ['as' => 'login_req_view2', 'uses' => 'LoginController@view_login_req']);
    Route::get("login", ["as" => "login_req_view", "uses" => "LoginController@view_login_req"]);
    Route::post("login-req", ["as" => "login_req", "uses" => "LoginController@login_req"]);
    Route::get("index", ["as" => "permiso_negado", "uses" => "RequerimientoController@index"]);

    Route::get("logout", ["as" => "req_logout", "uses" => "LoginController@req_logout"]);
    Route::get("cambiar-contrasena", ["as" => "req_cambiar_pass", "uses" => "LoginController@req_cambiar_pass"]);
	Route::get("informe-seleccion-req/{user_id}", ["as" => "req.informe_seleccion", "uses" => "ReclutamientoController@pdf_informe_seleccion"]);

    Route::post("rechazar_candidato_cliente", ["as" => "req.rechazar_candidato_cliente", "uses" => "ReclutamientoController@rechazar_candidato_cliente"]);

    //Esto se debe solucionar
    Route::post("candidatos_no_aprobar_cliente_view", [
    	"as" => "req.candidatos_no_aprobar_cliente_view",
    	"uses" => "RequerimientoController@candidatos_no_aprobar_cliente_view"
    ]);

	//REPORTE CONTRATADOS CLIENTE
    Route::post("crear_observacion", ["as" => "req.crear_observacion", "uses" => "ReclutamientoController@crear_observacion"]);
    
    Route::post("enviar_contratar_req", ["as" => "req.enviar_contratar_req", "uses" => "ReclutamientoController@enviar_contratar_req"]);
    
    //Aquí va no aprobado
    Route::post("contratar_masivo_cliente", ["as" => "req.contratar_masivo_cliente", "uses" => "ReclutamientoController@contratar_masivo_cliente"]);
	Route::post("contratar_masivo_cli", ["as" => "req.contratar_masivo_cli", "uses" => "ReclutamientoController@enviar_a_contratar_cliente_req_masivo"]);
    Route::post("enviar_contratar2_req", ["as" => "req.enviar_contratar2_req", "uses" => "ReclutamientoController@enviar_contratar2_req"]);

    Route::post("cargar_submenu", ["as" => "req.cargar_menu", "uses" => "MenuController@submenu"]);
    Route::post("recordar-contrasena", ["as" => "req.recordar_email2", "uses" => "LoginController@enviar_email_req_contrasena"]);
    Route::post("recordar_contrasena2", ["as" => "req.recordar_contrasena2", "uses" => "LoginController@recordar_contrasena2"]);
    Route::get("detalle-requisicion/{req_id}", ["as" => "req.detalle_requerimiento", "uses" => "RequerimientoController@detalle_requerimiento"]);
    Route::get("olvido-contrasena", ["as" => "req.olvido_contrasena", "uses" => "LoginController@olvido_contrasena_req"]);
    Route::get("recuperar_contrasena", ["as" => "req.recuperar_contrasena", "uses" => "LoginController@recuperar_contrasena"]);
    Route::post("cargo_especifico_ajax", ["as" => "req.cargo_especifico_ajax", "uses" => "RequerimientoController@cargo_especifico_ajax"]);
    
    Route::get("hv_pdf/{user_id}", ["as" => "hv_pdf", "uses" => "ReclutamientoController@pdf_hv"]);

    Route::post("cambia_estado_aprobacion_cliente", [
    	"as" => "req.cambia_estado_aprobacion_cliente",
    	"uses" => "RequerimientoController@cambia_estado_aprobacion_cliente"
    ]);

    //Marzo 07 de 2017
    Route::post('ajax-get-cargo-especifico-dependientes', [
        "as"   => "req.ajaxgetcargoespecificodependientes",
        "uses" => "RequerimientoController@getCargoEspecificoDependientes",
    ]);

    Route::post('ajax-get-fecha-segun-cargo', [
        "as"   => "req.ajaxgetfechaSegunCargo",
        "uses" => "RequerimientoController@calculo_ans_segun_cargo",
    ]);

	//Para tiempos calculo ans
    Route::post('ajax_calculo_ans', [
        "as"   => "req.ajax_calculo_ans",
        "uses" => "RequerimientoController@calculo_ans",
    ]);

    Route::get("autocomplete_cliente", ["as" => "autocomplete_cliente", "uses" => "ClientesController@autocomplete_cliente"]);
    
    //Routes for req module
    Route::post("aprobar_cliente_view_req", ["as" => "req.aprobar_cliente_view_req", "uses" => "RequerimientoController@candidatos_aprobar_cliente_view_req"]);
	Route::post("enviar_a_contratar_cliente_req", [
		"as" => "req.enviar_a_contratar_cliente_req",
		"uses" => "ReclutamientoController@enviar_a_contratar_cliente_req"
	]);

	Route::post("guardar_observacion", ["as" => "req.guardar_observacion", "uses" => "ReclutamientoController@guardar_observacion"]);
	Route::post("trazabilidad_candidato_cliente", ["as" => "req.trazabilidad_candidato", "uses" => "RequerimientoController@trazabilidad_cliente"]);
  	Route::get("reporte-detalles-excel-req", [
        'as'   => 'req.reportes.reportes_detalles_excel_req',
        'uses' => 'ReportesController@reportesDetallesExcelReq',
    ]);

	Route::post("crear_cita_cliente", ["as" => "req.crear_cita_cliente", "uses" => "ReclutamientoController@crear_cita_cliente"]);
	Route::post("guardar_cita_cliente", ["as" => "req.guardar_cita_cliente", "uses" => "ReclutamientoController@guardar_cita_cliente"]);

    //Contratados
        Route::get("mis-contratados", ["as" => "req.mis_contratados", "uses" => "ClienteContratadosController@index"]);
        Route::post("ver_orden_contratacion_req", ["as" => "req.contratacion.detalle_orden", "uses" => "ContratacionController@ver_orden_contratacion"]);
        Route::get("gestion-contratacion-req/{candidato}/{req}", ["as" => "req.gestion_contratacion", "uses" => "ClienteContratadosController@gestionar_candidato_req"]);
        Route::get("documentos_seleccion/{candidato}/{req}/{req_can}", ["as" => "req.documentos_seleccion", "uses" => "ClienteContratadosController@documentos_seleccion"]);
        Route::get("documentos_contratacion/{candidato}/{req}", ["as" => "req.documentos_contratacion", "uses" => "ClienteContratadosController@documentos_contratacion"]);

        Route::post("modal_documento_req_seleccion", ["as" => "req.cargarDocumentoReqSeleccion", "uses" => "ClienteContratadosController@cargar_documento_req_seleccion"]);
        Route::post("guardar_documento_req_seleccion", ["as" => "req.guardar_documento_asistente_seleccion", "uses" => "ContratacionController@guardar_documento_asistente_seleccion"]);

	Route::group(['middleware' => ['valida_req', "sesion_req"]], function () {
    	Route::get("index2", ["as" => "req_index", "uses" => "RequerimientoController@index"]);

    	Route::get("clientes", ["as" => "req.mostrar_clientes", "uses" => "ClientesController@clientes"]);
    	Route::get("datos-empresa/{cliente_id}", ["as" => "req.datos.empresa", "uses" => "ClientesController@editar_cliente"]);
    	Route::get("usuarios", ["as" => "req.usuarios", "uses" => "RequerimientoController@usuarios"]);
    
    	Route::get("consultar-negocio", ["as" => "req.consultar_negocio", "uses" => "RequerimientoController@consultar_negocio"]);
    	Route::get("mis-requerimientos", ["as" => "req.mis_requerimiento", "uses" => "RequerimientoController@mis_requerimientos"]);
        Route::get("lista_requerimientos", ["as" => "req.lista_requerimientos", "uses" => "RequerimientoController@lista_requerimientos_cliente"]);
    	Route::get("nueva-requisicion/{cliente_id}/{negocio_id}", ["as" => "req.nuevo_requerimiento", "uses" => "RequerimientoController@nuevo_requerimiento"]);

    	Route::get("requerimientos", ["as" => "req.requerimiento", "uses" => "RequerimientoController@requerimientos"]);
    	Route::get("reporte", ["as" => "req.reporte", "uses" => "ReportesController@reportesDetallesReq"]);
    
        /*Route::get("reporte-detalles-excel-req", [
            'as'   => 'req.reportes.reportes_detalles_excel_req',
            'uses' => 'ReportesController@reportesDetallesExcelReq',
        ]);*/

    	Route::get("reporte-contratados-cliente", [
        	"as"   => "req.reporte_contratados_cliente",
        	"uses" => "ReportesController@reportesContratadoCliente",
    	]);
    	
    	Route::get("indicadores-eficacia-cliente", [
        	"as"   => "req.indicadores_eficacia_cliente",
        	"uses" => "ReportesController@indicador_eficacia_cliente",
    	]);
		
	    Route::get("nuevo-user", ["as" => "req.nuevo_user", "uses" => "ClientesController@nuevo_user_cliente"]);
	    Route::get("editar-user/{user_id}", ["as" => "req.editar_user", "uses" => "ClientesController@editar_user_cliente"]);
	    Route::post("guardar-user", ["as" => "req.guardar_user", "uses" => "ClientesController@guardar_user_cliente"]);
	    Route::post("actualizar_datos", ["as" => "req.actualizar_datos", "uses" => "ClientesController@actualizar_datos"]);
	    Route::post("actualizar_usuario", ["as" => "req.actualizar_usuario", "uses" => "ClientesController@actualizar_user_cliente"]);
	    Route::post("guardar-requerimiento", ["as" => "req.guardar_requerimiento", "uses" => "RequerimientoController@guardar_requerimiento"]);
        Route::get("editar-requerimiento/{req_id}", ["as" => "req.editar_requerimiento", "uses" => "RequerimientoController@editar_requerimiento_cliente"]);  
        Route::post("guardar_requerimiento", ["as" => "req.actualizar_requerimiento", "uses" => "RequerimientoController@actualizar_requerimiento"]);

    	Route::post("candidatos_aprobar_cliente_view", [
    		"as" => "req.candidatos_aprobar_cliente_view",
    		"uses" => "RequerimientoController@candidatos_aprobar_cliente_view"
    	]);

    	Route::post("enviar_documentos_contratacion", [
    		"as" => "req.documento_contratacion_enviar",
    		"uses" => "ReclutamientoController@enviar_documentos_contratacion"
    	]);
	});
});

Route::group(['middleware' => ['valida_admin', 'sesion_ajax']], function () {
    Route::post("validar_sesion", ["as" => "admin.validar_sesion", "uses" => "AuthController@validar_sesion"]);
});

Route::group(['prefix' => 'admin'], function () {
    /*
        * REVISAR EL ARCHIVO "RUTASNOVALIDAS" PARA MIRAR QUE RUTAS NO NECESITAN PERMISO PERO QUE SI
        * NECESITAN SER VALIDADAS POR EL LOGIN
    */
   
    /*
        Route::get('examenes_medicos',['as' => 'admin.examenes_medicos'],function(){
            return "hola";
        });
    */

         
    // ElEmpleo
    Route::post("aplicados_ee", ["as" => "admin.aplicados_ee", "uses" => "ElEmpleoController@getApplyCandidatesEE"]);
    //---

    //Asistente de contratacion
    Route::group(['middleware' => ['valida_admin','sesion_admin']], function () {
       Route::get("cambiar-contrasena-admin", ["as" => "admin_cambiar_pass", "uses" => "LoginController@admin_cambiar_pass"]);
        Route::get("material-ayuda-ad", ["as" => "home.ayuda_admin", "uses" => "HomeController@temas_ayuda_admin"]);
	    Route::get("asistente-contratacion", ["as" => "admin.asistente_contratacion", "uses" => "ContratacionController@index"]);
        Route::get("afiliaciones", ["as" => "admin.afiliaciones", "uses" => "AfiliacionesController@index"]);
        Route::get("afiliaciones-gestionadas/{candidato}/{req}/{contrato_id}", ["as" => "admin.afiliaciones_gestionadas", "uses" => "AfiliacionesController@gestionar"]);
        Route::get("reporte-confirmacion-afiliaciones-excel", [
            'as'   => 'admin.reporte_confirmacion_afiliaciones_excel',
            'uses' => 'AfiliacionesController@reporte_confirmacion_afiliaciones',
        ]);
        Route::post("guardar-observacion-afiliaciones", ["as" => "admin.guardar_observacion_afiliaciones", "uses" => "AfiliacionesController@guardar_observacion_afiliaciones"]);

	    Route::get("gestion-contratacion/{candidato}/{req}", ["as" => "admin.gestion_contratacion", "uses" => "ContratacionController@gestionar_candidato"]);

		Route::get("documentos_seleccion/{candidato}/{req}/{req_can}", ["as" => "admin.documentos_seleccion", "uses" => "ContratacionController@documentos_seleccion"]);
		Route::get("documentos_contratacion/{candidato}/{req}", ["as" => "admin.documentos_contratacion", "uses" => "ContratacionController@documentos_contratacion"]);
		Route::get("documentos-confidenciales/{candidato}/{req}", ["as" => "admin.documentos_confidenciales", "uses" => "ContratacionController@documentos_confidenciales"]);

        Route::post("modal-enviar-carta-terminacion-contrato", ["as" => "admin.modal_enviar_carta_terminacion_contrato", "uses" => "NotificacionTerminacionContratoController@modal_enviar_carta_terminacion_contrato"]);
         Route::post("enviar-carta-terminacion-contrato", ["as" => "admin.envio_carta_terminacion_contrato", "uses" => "NotificacionTerminacionContratoController@envio_carta_terminacion_contrato"]);

        Route::post("eliminar-documento", ["as" => "admin.eliminar_documento", "uses" => "DocumentosController@eliminar_documento_admin"]);
    });

    Route::get("documentos_seleccion_cliente/{candidato}/{req}/{req_can}", ["as" => "req.documentos_seleccion_cliente", "uses" => "ContratacionController@documentos_seleccion_cliente"]);
    Route::get("documentos_contratacion_cliente/{candidato}/{req}", ["as" => "req.documentos_contratacion_cliente", "uses" => "ContratacionController@documentos_contratacion_cliente"]);

    //Modulo gestion documental
    Route::group(['middleware' => ['valida_admin','sesion_admin']], function () {
        Route::get("gestion-documental-index", ["as" => "admin.gestion_documental.index", "uses" => "GestionDocumentalController@index"]);

        Route::get("gestion-documental-indicadores", ["as" => "admin.gestion_documental.indicadores", "uses" => "GestionDocumentalController@reportesValidacionDocumental"]);

        Route::get("gestion-documental-indicadores-excel", [
            'as'   => 'admin.gestion_documental.indicadores_excel',
            'uses' => 'GestionDocumentalController@reportesValidacionDocumentalExcel',
        ]);

        Route::get("gestion-documental-clientes", ["as" => "admin.gestion_documental.clientes", "uses" => "GestionDocumentalController@clientes"]);

        Route::get("download-carpeta/{folder?}", ["as" => "admin.gestion_documental.download_carpeta", "uses" => "GestionDocumentalController@downloadCarpeta"]);

        Route::get("gestionar-cliente-gestion-documental/{cliente_id}", ["as" => "admin.gestion_documental.gestion_cliente", "uses" => "GestionDocumentalController@gestionarCliente"]);

        Route::get("gestionar-candidato-gestion-documental/{candidato}/{req}", ["as" => "admin.gestion_documental.gestion_contratacion", "uses" => "GestionDocumentalController@gestionar_candidato"]);

        //Gestiondocumental clientes

        Route::get("listado-documentos-clientes/{categoria}/{cliente}", ["as" => "admin.gestion_documental.listado_documentos_clientes", "uses" => "GestionDocumentalController@listadoDocumentosClientes"]);

        Route::get("configuracion-tipos-documentos-clientes", ["as" => "admin.gestion_documental.clientes.tipos_documentos.index", "uses" => "TipoDocumentoClienteController@index"]);

        Route::get("nuevo-tipo-documento-cliente", ["as" => "admin.gestion_documental.clientes.tipos_documentos.create", "uses" => "TipoDocumentoClienteController@create"]);

        Route::post("guardar-tipo-documento-cliente", ["as" => "admin.gestion_documental.clientes.tipos_documentos.store", "uses" => "TipoDocumentoClienteController@store"]);

        Route::get("editar-tipo-documento-cliente/{id}", ["as" => "admin.gestion_documental.clientes.tipos_documentos.edit", "uses" => "TipoDocumentoClienteController@edit"]);

        Route::post("actualizar-tipo-documento-cliente", ["as" => "admin.gestion_documental.clientes.tipos_documentos.update", "uses" => "TipoDocumentoClienteController@update"]);

        Route::post("modal_documento_gd_cliente", ["as" => "admin.gestion_documental.cargarDocumentoCliente", "uses" => "GestionDocumentalController@cargarDocumentoCliente"]);

        Route::post("guardar-documento_gd_cliente", ["as" => "admin.gestion_documental.guardar_documento_cliente", "uses" => "GestionDocumentalController@guardarDocumentoCliente"]);
        //Fin gestion documental clientes

        Route::get("documentos-seleccion-gd/{candidato}/{req}/{req_can}", ["as" => "admin.gestion_documental.documentos_seleccion_gd", "uses" => "GestionDocumentalController@documentos_seleccion"]);
        Route::get("documentos-contratacion-gd/{candidato}/{req}", ["as" => "admin.gestion_documental.documentos_contratacion_gd", "uses" => "GestionDocumentalController@documentos_contratacion"]);
        Route::get("documentos-confidenciales-gd/{candidato}/{req}", ["as" => "admin.gestion_documental.documentos_confidenciales_gd", "uses" => "GestionDocumentalController@documentos_confidenciales"]);

        Route::get("documentos-post-gd/{candidato}/{req}", ["as" => "admin.gestion_documental.documentos_post_gd", "uses" => "GestionDocumentalController@documentos_post"]);

        Route::post("close-folder-gestion", ["as" => "admin.gestion_documental.close_folder_gestion", "uses" => "GestionDocumentalController@closeFolderGestion"]);

    });
     
   
    
    Route::post("guardar_documento_contratacion", ["as" => "admin.guardar_documento_contratacion", "uses" => "ContratacionController@guardar_documento"]);
     Route::post("cambiar-status-carpeta", ["as" => "admin.contratacion.status_carpetas", "uses" => "ContratacionController@cerrar_carpetas"]);

    
    Route::get("documentos_post/{candidato}/{req}", ["as" => "admin.documentos_post", "uses" => "ContratacionController@documentos_post"]);
    Route::get("documentos_beneficiarios/{candidato}/{req}", ["as" => "admin.documentos_beneficiarios", "uses" => "ContratacionController@documentos_beneficiarios"]);
    Route::post("info-orden-contratacion", ["as" => "admin.contratacion_detalle_orden", "uses" => "ContratacionController@info_orden"]);
    Route::get('salud-ocupacional', ['as' => 'admin.salud_ocupacional', 'uses' => 'ContratacionController@salud_ocupacional']);
    Route::get('gestion_salud_ocupacional/{orden}', ['as' => 'admin.gestion_salud_ocupacional', 'uses' => 'ContratacionController@gestion_salud_ocupacional']);
	Route::post("cambiar_estado_salud", ["as" => "admin.cambiar_estado_salud", "uses" => "ContratacionController@cambiar_estado_salud"]);
	Route::post("ver_orden_contratacion", ["as" => "admin.contratacion.detalle_orden", "uses" => "ContratacionController@ver_orden_contratacion"]);
	Route::post("confirmar_contratacion_asistente", [
		"as" => "admin.contratacion.confirmacion_contratacion_asistente",
		"uses" => "ContratacionController@confirmar_contratacion"
	]);

    //Descargar archivo asistente
    Route::get('descarga_recurso/{folder}/{file}', ['as' => 'admin.descargar_recurso', 'uses' => 'ContratacionController@descargar_archivo']);

    Route::get('aceptacion-de-politica-tratamiento-de-datos/{politica_id}/{user_id?}', [
        'as'   => 'admin.aceptacionPoliticaTratamientoDatos', 
        'uses' => 'ContratacionController@aceptacionPoliticaTratamientoDatos']);
        
	Route::post("cancelar_contratacion_asistente", [
		"as" => "admin.contratacion.cancelar_contratacion_asistente",
		"uses" => "ContratacionController@cancelar_contratacion"
	]);

	Route::post("confirmar-cancelar_contratacion_asistente", [
		"as" => "admin.contratacion.confirmar_cancelar_contratacion_asistente",
		"uses" => "ContratacionController@confirmar_cancelar_contratacion"
	]);
    Route::post("encuesta-admin", ["as" => "admin.guardar_encuesta", "uses" => "EncuestaController@guardar"]);
    Route::post("presenta-encuesta", ["as" => "admin.presenta_encuesta", "uses" => "EncuestaController@presenta_encuesta"]);
    //Route::post("presenta-encuesta-timer", ["as" => "admin.presenta_encuesta_timer", "uses" => "EncuestaController@presenta_encuesta_timer"]);
	Route::post("reabrir_req", ["as" => "admin.reabrir_req", "uses" => "ReclutamientoController@reabrir_req"]);
	Route::post("eliminar_proceso", ["as" => "admin.eliminar_proceso", "uses" => "ReclutamientoController@eliminar_proceso"]);
	Route::post("comfirmar_eliminar_proceso", ["as" => "admin.confirmar_eliminar_proceso", "uses" => "ReclutamientoController@confirmar_eliminar_proceso"]);
	Route::post("reabrir_proceso", ["as" => "admin.reabrir_proceso", "uses" => "ReclutamientoController@reabrir_proceso"]);
	Route::post("comfirmar_reabrir_proceso", ["as" => "admin.confirmar_reabrir_proceso", "uses" => "ReclutamientoController@confirmar_reabrir_proceso"]);
	Route::post("cambiar_estado_asistencia", ["as" => "admin.contratacion.cambiar estado_asistencia", "uses" => "ContratacionController@cambiar_estado_asistencia"]);
	Route::post("confirmar_cambio_estado_asistencia", [
		"as" => "admin.contratacion.confirmar_cambio estado_asistencia",
		"uses" => "ContratacionController@confirmar_cambio_estado_asistencia"
	]);
      
	Route::post("finalizar_contratacion_asistente", [
		"as" => "admin.contratacion.finalizar_contratacion_asistente",
		"uses" => "ContratacionController@finalizar_contratacion"
	]);

	Route::post("ver_status_contratacion", ["as" => "admin.contratacion.status_contratacion", "uses" => "ContratacionController@ver_status_contratacion"]);
	Route::get("lista-proveedores",["as" => "admin.contratacion.lista_proveedores", "uses" => "ProveedorController@index"]);
	Route::post("editar-proveedor",["as" => "admin.contratacion.editar-proveedor", "uses" => "ProveedorController@edit"]);
	Route::post("confirmar-editar-proveedor",["as" => "admin.contratacion.confirmar-editar-proveedor", "uses" => "ProveedorController@update"]);

	Route::post("nuevo-proveedor",["as" => "admin.contratacion.nuevo-proveedor", "uses" => "ProveedorController@create"]);
	Route::post("guardar-proveedor",["as" => "admin.contratacion.guardar-proveedor", "uses" => "ProveedorController@store"]);

	//Administracion de examenes medicos
	Route::get("lista-examenes",["as" => "admin.contratacion.lista_examenes", "uses" => "ExamenController@index"]);
	Route::post("nuevo-examen",["as" => "admin.contratacion.nuevo-examen", "uses" => "ExamenController@create"]);
	Route::post("guardar-examen",["as" => "admin.contratacion.guardar-examen", "uses" => "ExamenController@store"]);
	Route::post("editar-examen",["as" => "admin.contratacion.editar-examen", "uses" => "ExamenController@edit"]);
	Route::post("confirmar-editar-examen",["as" => "admin.contratacion.confirmar-editar-examen", "uses" => "ExamenController@update"]);
	//Fin administracon examenes medicos
     
    Route::get("cargo-dependiente-cliente",["as"=>"admin.cargos_dependiendo_cliente","uses"=>"ReportesController@cargo_especifico_cliente"]);
    
    Route::get('login', ['as' => 'admin.login', 'uses' => 'AuthController@login_admin']);
    Route::post('login_post', ['as' => 'admin.login_post', 'uses' => 'AuthController@login_admin_post']);
    //Route::get('login_post_2', ['as' => 'admin.login_post_2', 'uses' => 'AuthController@login_admin_post']);
    Route::get("olvido-contrasena", ["as" => "admin.olvido_contrasena", "uses" => "LoginController@olvido_contrasena_admin"]);
    Route::get("recuperar_contrasena", ["as" => "admin.recuperar_contrasena", "uses" => "LoginController@recuperar_contrasena_admin"]);
    Route::post("recordar-contrasena", ["as" => "admin.recordar_email", "uses" => "LoginController@enviar_email_admin_contrasena"]);
    Route::post("recupera_contrasena", ["as" => "admin.recupera_contrasena", "uses" => "LoginController@cambia_contrasena_recuperacion"]);

    Route::get("autocompletar_cargo_generico", ["as" => "admin.autocompletar_cargo_generico", "uses" => "AdminController@autocompletar_cargo_generico"]);
    //Route::get("reportes-admin",["as"=>"admin.reportes_admin","uses"=>"ReportesController@reporte"]);
    
    //Clausulas
    Route::post('get_cargos_especificos_clausula', ['as' => 'admin.get_cargos_especificos_clausulas', 'uses' => 'ClausulaController@getCargosEspecificos']);

    Route::get('visualizar_clausula/{adicional_id}', ['as' => 'admin.visualizar_clausula', 'uses' => 'ClausulaController@getClausulaView']);

    Route::post('asociar_clausula_todos', ['as' => 'admin.clausulas.asociar_todos', 'uses' => 'ClausulaController@asociarTodos']);
    //Fin Clausulas

    // Cargo Especifico
    Route::post('listar-adicionales-cliente', ['as' => 'admin.listar_adicionales_cliente', 'uses' => 'CargosEspecificosController@get_adicionales_cliente']);

    //Ruta sin proteccion de Middleware
    Route::get("informe-preliminar", ["as" => "admin.getinforme_preliminar", "uses" => "InformePreliminarController@pdf_informe_preliminar"]);
    //Fin Rutas sin proteccion de Middleware

    Route::group(['middleware' => ['valida_admin', 'sesion_admin']], function () {
        //Clausulas
        Route::get('lista-clausulas', ['as' => 'admin.clausulas.lista', 'uses' => 'ClausulaController@index']);
        Route::get('crear-clausula', ['as' => 'admin.clausulas.crear', 'uses' => 'ClausulaController@create']);
        Route::get('editar-clausula/{adicional_id}', ['as' => 'admin.clausulas.editar', 'uses' => 'ClausulaController@edit']);
        Route::get('asociar-clausula-cargos/{adicional_id}', ['as' => 'admin.clausulas.asociar_cargos', 'uses' => 'ClausulaController@asociar_view']);

	    Route::post('asociar_clausula', ['as' => 'admin.clausulas.asociar', 'uses' => 'ClausulaController@asociar']);
	    Route::post('borrar_asociar_clausula', ['as' => 'admin.clausulas.asociar.borrar', 'uses' => 'ClausulaController@asociar_borrar']);
	    Route::post('estado_asociar_clausula', ['as' => 'admin.clausulas.asociar.estado', 'uses' => 'ClausulaController@asociar_estado']);

	    Route::post('guardar_clausula_nueva', ['as' => 'admin.guardar_nueva_clausula', 'uses' => 'ClausulaController@save']);
	    Route::post('actualizar_clausula', ['as' => 'admin.actualizar_clausula', 'uses' => 'ClausulaController@update']);

        Route::post('enviar-imagen-generador', ['as' => 'admin.generador.subir_imagen', 'uses' => 'ClausulaController@imagen_generador']);
	    //Fin Clausulas

	    /**
	     *BTN aprobar
	     **/
	    Route::get('btn-compensar', ['as' => 'admin.btn-compensar']);
        Route::get('btn-aprobar', ['as' => 'admin.btn-aprobar']);

        //Backups
        Route::get("backups", ["as" => "admin.backups", "uses" => "AdminController@backups"]);

	    /**
	     * Aprobaciones
	     **/

	    //Solicitud
	    Route::get("admin-solicitud/{id?}", ["as" => "admin.solicitud", "uses" => "SolicitudController@index"]);
	    Route::post("admin-nueva-solicitud", ["as" => "admin.nuevaSolicitud", "uses" => "SolicitudController@nuevaSolicitud"]);
	    Route::post("admin-guardar-solicitud", ["as" => "admin.solicitudGuardar", "uses" => "SolicitudController@guardarSolicitud"]);
	    Route::post("admin-ajax-solicitud-nueva", ["as" => "admin.solicitudAjaxSolicitud", "uses" => "SolicitudController@ajaxSolicitudNueva"]);

	    Route::post("admin-compensar-solicitud", ["as" => "admin.compensarSolicitud", "uses" => "SolicitudController@compensarSolicitud"]);
	    Route::post("admin-actualizar-solicitud", ["as" => "admin.actualizarSolicitud", "uses" => "SolicitudController@actualizarSolicitud"]);
	    Route::post("admin-modal-aprobar-solicitud", ["as" => "admin.modalAprobarSolicitud", "uses" => "SolicitudController@modalAprobarSolicitud"]);
	    Route::post("admin-modal-detalle-solicitud", ["as" => "admin.modalDetalleSolicitud", "uses" => "SolicitudController@modalDetalleSolicitud"]);
	    Route::post("admin-aprobar-solicitud", ["as" => "admin.aprobarSolicitud", "uses" => "SolicitudController@aprobarSolicitud"]);
	    Route::post("admin-pendiente-solicitud", ["as" => "admin.pendienteSolicitud", "uses" => "SolicitudController@pendienteSolicitud"]);
	    Route::post("admin-liberado-solicitud", ["as" => "admin.liberarSolicitud", "uses" => "SolicitudController@liberarSolicitud"]);
	    Route::post("admin-rechazar-solicitud", ["as" => "admin.rechazarSolicitud", "uses" => "SolicitudController@rechazarSolicitud"]);
    
	    //Ajax, cuando se sleccione l area de trabajo traer subarea relacionado
	    Route::post("admin-subarea-relaciondo-area",["as" => "admin.selctAreaTrabajo", "uses" => "SolicitudController@selectSubArea"]);
	    //ajax, cuando se selecciona el jefe para traer el email en la nueva solicitud
	    Route::post("admin-jefe-inmediato",["as" => "admin.selectEmailJefe", "uses" => "SolicitudController@selectEmailJefe"]);
   
	    Route::post("admin-benficio-relaciondo-subarea",["as" => "admin.selctSubArea", "uses" => "SolicitudController@selctbenficio"]);
	    Route::post("admin-costo-relaciondo-beneficio",["as" => "admin.selctCosto", "uses" => "SolicitudController@selctCosto"]);
        
	    /*Compensaciones*/
	    Route::get("compensaciones", ["as" => "admin.compensaciones", "uses" => "CompensacionesController@index"]);
        Route::get("editar_compensacion/{req_id}", ["as" => "admin.editar_compensacion", "uses" => "CompensacionesController@editar_compensacion"]);
        Route::post("no_asignar", ["as" => "admin.no_asignar", "uses" => "CompensacionesController@no_asignar"]);
        Route::post("guardar_compensacion", ["as" => "admin.actualizar_compensacion", "uses" => "CompensacionesController@actualizar_compensacion"]);
        
        Route::get("indicadores-reclutamiento", [
            "as"   => "admin.reporte.indicadores_reclutamiento",
            "uses" => "IndicadorController@indicadores_reclutamiento",
        ]);

        Route::get("indicadores-seleccion", [
            "as"   => "admin.reporte.indicador_seleccion",
            "uses" => "IndicadorController@indicadorSeleccion",
        ]);

        Route::post("indicadores-seleccion-search", [
            "as"   => "admin.reporte.indicador_seleccion.search",
            "uses" => "IndicadorController@indicadorSeleccionSearch",
        ]);

         Route::get("indicador-dashboard", [
            "as"   => "admin.reporte.indicador_dashboard",
            "uses" => "ReportesController@indicador_dashboard",
        ]);

         Route::get("indicador-indice-cancelaciones", [
            "as"   => "admin.reporte.indicador_indice_cancelaciones",
            "uses" => "ReportesController@indicador_indice_cancelaciones",
        ]);

        Route::get("indicadores-cierre-mensual", [
            "as"   => "admin.cierre_mensual",
            "uses" => "ReportesController@cierre_mensual",
        ]);

        Route::get("indicadores-eficacia", [
            "as"   => "admin.reporte.indicadores_eficacia",
            "uses" => "IndicadorController@indicador_eficacia",
        ]);
        
        Route::get("indicadores-cierre", [
            "as"   => "admin.reporte.indicador_cierre",
            "uses" => "ReportesController@indicador_cierre",
        ]);

        Route::get("indicadores-eficacia-reclu", [
            "as"   => "admin.reporte.indicadores_eficacia_reclu",
            "uses" => "ReportesController@indicador_eficacia_reclu",
        ]);

        Route::get("indicadores-eficacia-llamada", [
            "as"   => "admin.reporte.indicadores_eficacia_llamada",
            "uses" => "ReportesController@indicador_eficacia_llamada",
        ]);

        Route::get("indicadores-eficacia-tiempos", [
            "as"   => "admin.reporte.indicadores_eficacia_tiempos",
            "uses" => "ReportesController@indicador_tiempos",
        ]);
        
        Route::get("indicadores-cancelados", [
            "as"   => "admin.reporte.indicadores_cancelacion",
            "uses" => "ReportesController@indicador_cancelados",
        ]);

        //indicadores oportunidad
        Route::get("indicadores-oportunidad", [
            "as"   => "admin.reporte.indicadores_oportunidad",
            "uses" => "IndicadorController@indicador_oportunidad",
        ]);
        Route::get("indicador-oportunidad", [
            "as"   => "admin.reporte.indicadores_oportunidad_2",
            "uses" => "ReportesController@indicador_oportunidad_2",
        ]);
        Route::get("distribucion_perfilamiento", [
            "as"   => "admin.distribucion_perfilamiento",
            "uses" => "ReportesController@distribucion_perfilamiento",
        ]);

         Route::get("distribucion_perfilamiento-excel", [
            "as"   => "admin.distribucion_perfilamiento_excel",
            "uses" => "ReportesController@distribucion_perfilamiento_excel",
        ]);
         Route::get("cierres_mensuales", [
            "as"   => "admin.reporte.cierres_mensuales",
            "uses" => "ReportesController@cierres_mensuales",
        ]);

        //Indicadores de estado requerimientos
        Route::get("indicador_estados", [
            "as"   => "admin.reporte.indicadores_estado_req",
            "uses" => "ReportesController@indicador_estado_req",
        ]);

        //Indicador de 
        Route::get("indicador_cumplimiento_ans", [
            "as"   => "admin.reporte.indicador_cumplimiento",
            "uses" => "ReportesController@indicadorcumplimientoANS",
        ]);

        Route::get("indicador-tipo-proceso", [
            "as"   => "admin.reporte.indicador_tipo_proceso",
            "uses" => "IndicadorController@indicadorTipoProceso",
        ]);

        Route::get("indicador-vencidos", [
            "as"   => "admin.reporte.indicador_vencido_estado",
            "uses" => "IndicadorController@indicadorVencido",
        ]);

        Route::get("indicador-seguimiento", [
            "as"   => "admin.reporte.indicador_seguimiento",
            "uses" => "IndicadorController@indicadorSeguimiento",
        ]);

        //Enviar a video entrevista
        Route::post("enviar-video-entrevista", ["as"=>"admin.video_entrevista", "uses"=>"ReclutamientoController@video_entrevista"]);

        //Configurar informe preliminar, mostrar modal para la configuración
        Route::post("configurar-informe-preliminar", [
        	"as" => "configurar_informe_preliminar_requerimiento",
        	"uses" => "InformePreliminarController@configurar_informe_preliminar_por_requerimiento"
        ]);

        //Guardar condiguración del informe preliminar por requerimiento
        Route::post("guardar-configuracion-informe-preliminar-requerimiento", [
        	"as" => "admin.guardar_configuracion_informe_preliminar_requerimiento",
        	"uses" => "InformePreliminarController@guardar_configuracion_informe_preliminar_requerimiento"
        ]);

        //Eliminar informe preliminar del requerimiento actual
        Route::post("eliminar-informe-preliminar-realizados-requerimiento", [
        	"as" => "admin.eliminar_informe_preliminar_requerimiento",
        	"uses"=> "InformePreliminarController@eliminar_informe_preliminar_candidato_requerimiento"
        ]);

        //Construir email candidato modulo gestion requerimiento
        Route::post("construir-email-candiato-gestion-requerimiento", [
        	"as" => "admin.construir_email_gestion_req",
        	"uses" => "ReclutamientoController@construir_email_candidato_vinculado"
        ]);

        //Enviar email al candidato, en el modulo gestionar requerimiento
        Route::post("enviar-email-candidato-gestion-requerimiento", [
        	"as" => "admin.enviar_email_gestion_req",
        	"uses" => "ReclutamientoController@enviar_email_candidato_vinculado"
        ]);
        
        //Configuracion del SITIO
        Route::get("configuracion-sitio", ["as" => "admin.configurar_sitio", "uses" => "SitioController@index"]);
        Route::post("guardar-configuracion-sitio", ["as" => "admin.guardar_configuracion_sitio", "uses" => "SitioController@create"]);

        Route::get("demostraciones", ["as" => "admin.demostraciones", "uses" => "SitioController@demostraciones"]);
        Route::post("ver_observacion", ["as" => "admin.ver_observacion", "uses" => "ReclutamientoController@ver_observacion"]);
        Route::post("crear_observacion_admin", ["as" => "admin.crear_observacion", "uses" => "ReclutamientoController@crear_observacion"]);
        Route::post("crear_observacion_hv", ["as" => "admin.crear_observacion_hv", "uses" => "CvController@crear_observacion_hv"]);
        Route::post("guardar_observacion_hv", ["as" => "admin.guardar_observacion_hv", "uses" => "CvController@guardar_observacion_hv"]);
        Route::post("guardar_observacion_admin", ["as" => "admin.guardar_observacion", "uses" => "ReclutamientoController@guardar_observacion_admin"]);

        Route::get("demostracion_video_entrevista", ["as" => "admin.demostracion_video_entrevista", "uses" => "SitioController@demostracion_video_entrevista"]);
        Route::get("demostracion_video_entrevista_respuestas", [
        	"as" => "admin.demostracion_video_entrevista_respuestas",
        	"uses" => "SitioController@demostracion_video_entrevista_respuestas"
        ]);

        Route::post("video_respuesta_demo", ["as" => "admin.video_respuesta_demo", "uses" => "SitioController@video_respuesta_demostracion"]);
        Route::post("enviar_video_entrevista", ["as" => "admin.enviar_video_entrevista", "uses" => "SitioController@envio_video_entrevista"]);
        Route::get("demostracion_llamada_mensaje", ["as" => "admin.demostracion_llamada_mensaje", "uses" => "SitioController@demostracion_llamada_mensaje"]);
        Route::post("enviar_llamada_mensaje_admin", ["as" => "admin.enviar_llamada_mensaje", "uses" => "SitioController@envio_llamada_mensaje"]);
        Route::post("contratar_masivo_cliente_admin", ["as" => "admin.contratar_masivo_cliente", "uses" => "ReclutamientoController@contratar_masivo_cliente_admin"]);
        Route::post("contratar_masivo_cli_admin", ["as" => "admin.contratar_masivo_cli", "uses" => "ReclutamientoController@enviar_a_contratar_cliente_req_masivo_admin"]);

        Route::get("lista-permiso-adelanto-nomina", ["as" => "admin.lista_adelanto_nomina", "uses" => "CartappPermisoSolicitudController@listado_permisos_cartapp"]);

        Route::post("agregar-cedula-adelanto-nomina", ["as" => "admin.agregar_cedula_adelanto_nomina", "uses" => "CartappPermisoSolicitudController@agregar_cedula_adelanto_nomina"]);

        //Gestionar solicitudes Adelanto de nomina
        Route::get("admin-solicitudes-cartapp", ['as' => 'admin.solicitudes_cartapp', 'uses' => 'CartappSolicitudController@solicitudes_cartapp']);

        Route::get("lista-solicitudes-adelanto-nomina", ["as" => "admin.lista_solicitudes_adelanto_nomina", "uses" => "CartappSolicitudController@listado_solicitudes_cartapp"]);

        Route::post("gestion-solicitud-adelanto-nomina-view", ["as" => "admin.gestion_solicitud_cartapp_view", "uses" => "CartappSolicitudController@gestion_solicitud_cartapp_view"]);

        Route::post("gestionar-solicitud-adelanto-nomina", ["as" => "admin.gestionar_solicitud_cartapp", "uses" => "CartappSolicitudController@gestionar_solicitud_cartapp"]);

        Route::get("reporte-solicitud-adelanto-nomina-excel", [
            'as'   => 'admin.reporte_solicitudes_adelanto_excel',
            'uses' => 'CartappSolicitudController@reporte_solicitudes_adelanto_excel',
        ]);

        //Cargar usuarios maxivos
        Route::get("cargar-usuarios-masivo", ["as" => "admin.cargar_usuario_masivo", "uses" => "CargaMasivaUsuariosController@index"]);
        Route::post("procesar-carga-masiva-usuarios", ["as" => "admin.procesar_archivo_cmu", "uses" => "CargaMasivaUsuariosController@cargar_usuarios_masivos"]);

        //Reporte Candidatos Enviados al Cliente
        Route::get("reporte-enviados-cliente", [
            'as'   => 'admin.reporte_enviados_cliente',
            'uses' => 'ReporteEnviadosClienteController@enviadosCliente',
        ]);
        Route::get("reporte-enviados-cliente-excel", [
            'as'   => 'admin.reporte_enviados_cliente_excel',
            'uses' => 'ReporteEnviadosClienteController@enviadosClienteExcel',
        ]);

        Route::get("lista-especial", ["as" => "admin.lista_negra", "uses" => "ListaNegraController@index"]);

        Route::post("agregar-cedula-lista-negra", ["as" => "admin.agregar_cedula_lista_negra", "uses" => "ListaNegraController@agregar_cedula_lista_negra"]);

        Route::post("agregar-cedula-lista-negra-masivo", ["as" => "admin.agregar_cedula_lista_negra_masivo", "uses" => "ListaNegraController@agregar_cedula_lista_negra_masivo"]);

		//Reporte Candidatos
        Route::get("reportes-candidatos", [
            'as'   => 'admin.reportes_candidatos',
            'uses' => 'ReportesController@reportesDetallesCandi',
        ]);
        Route::get("reporte-detalles-candi-excel", [
            'as'   => 'admin.reportes.reportes_detalles_candi_excel',
            'uses' => 'ReportesController@reportesDetallesCandiExcel',
        ]);

        //Reporte Mineria Hojas
        Route::get("reportes-mineria", [
            'as'   => 'admin.reportes_mineria',
            'uses' => 'ReportesController@reportesDetallesMine',
        ]);
        Route::get("reporte-detalles-mine-excel", [
            'as'   => 'admin.reportes.reportes_detalles_mine_excel',
            'uses' => 'ReportesController@reportesDetallesMineExcel',
        ]);

        //Reporte Tempo
        Route::get("reporte-rendimiento", [
            'as'   => 'admin.reportes_tempo',
            'uses' => 'ReportesController@reportesDetallesTempo',
        ]);
        Route::get("reporte-detalles-tempo-excel", [
            'as'   => 'admin.reportes.reportes_detalles_tempo_excel',
            'uses' => 'ReportesController@reportesDetallesTempoExcel',
        ]);

        //Reporte Asistencia
        Route::get("reporte-llamada", [
            'as'   => 'admin.reportes_llamadas_hechas',
            'uses' => 'ReportesController@reportesLlamadas',
        ]);
        Route::get("reporte-llamada-excel", [
            'as'   => 'admin.reportes.reportes_llamada_excel',
            'uses' => 'ReportesController@reportesLlamadaExcel',
        ]);

        //Reporte Asistencia
        Route::get("reporte-asistencia", [
            'as'   => 'admin.reportes_asistencia',
            'uses' => 'ReportesController@reportesAsistencias',
        ]);
        Route::get("reporte-asistencia-excel", [
            'as'   => 'admin.reportes.reportes_asistencia_excel',
            'uses' => 'ReportesController@reportesAsistenciaExcel',
        ]);

        //Reporte detalle recltamiento
        Route::get("reportes-reclutamiento", [
            'as'   => 'admin.reportes_reclutamientos',
            'uses' => 'ReportesController@reportesDetallesReclu',
        ]);

        //Reporte Documentos Cargados por los Candidatos
        Route::get("reportes-documentos-cargados", [
            'as'   => 'admin.reportes_documentos_candidatos',
            'uses' => 'ReportesController@reportesDocumentosCandidato',
        ]);

        //Reporte Documentos Cargados por los Candidatos
        Route::get("reportes-documentos-cargados-excel", [
            'as'   => 'admin.reportes_documentos_candidatos_excel',
            'uses' => 'ReportesController@reportesDocumentosCandidatoExcel',
        ]);

        //Reporte Candidatos Enviados a Examenes Medicos
        Route::get("reportes-candidatos-exam-med", [
            'as'   => 'admin.reportes_enviados_exam_medicos',
            'uses' => 'ReportesController@reportesEnviadosExamMedicos',
        ]);

        //Reporte Candidatos Enviados a Examenes Medicos Excel
        Route::get("reportes-candidatos-exam-med-excel", [
            'as'   => 'admin.reportes_enviados_exam_medicos_excel',
            'uses' => 'ReportesController@reportesEnviadosExamMedicosExcel',
        ]);

        //Reporte Validacion Documental Cargados por los Candidatos
        Route::get("reportes-validacion-documental", [
            'as'   => 'admin.reportes_validacion_documental',
            'uses' => 'ReportesController@reportesValidacionDocumental',
        ]);

        //Reporte Validacion Documental Cargados por los Candidatos
        Route::get("reportes-validacion-documental-excel", [
            'as'   => 'admin.reportes_validacion_documental_excel',
            'uses' => 'ReportesController@reportesValidacionDocumentalExcel',
        ]);

        //Reporte No Continuidad Candidatos
        Route::get("reporte-no-continuidad", [
            'as'   => 'admin.reporte_no_continuidad',
            'uses' => 'ReporteNoContinuidadController@noContinuidadIndex',
        ]);

        //Reporte No Continuidad Candidatos Excel
        Route::get("reporte-no-continuidad-excel", [
            'as'   => 'admin.reporte_no_continuidad_excel',
            'uses' => 'ReporteNoContinuidadController@noContinuidadExcel',
        ]);

        //Reporte Entidades
        Route::get("reportes-entidades", [
            'as'   => 'admin.reportes_entidades',
            'uses' => 'ReportesController@reportesEntidades',
        ]);

        //Reporte Entidades Excel
        Route::get("reportes-entidades-excel", [
            'as'   => 'admin.reportes_entidades_excel',
            'uses' => 'ReportesController@reportesEntidadesExcel',
        ]);

        //Reporte ARL SURA
        Route::get("reportes-arl-sura", [
            'as'   => 'admin.reportes_arl_sura',
            'uses' => 'ReportesController@reportesARL',
        ]);

        //Reporte ARL SURA Excel
        Route::get("reportes-arl-excel", [
            'as'   => 'admin.reportes_arl_sura_excel',
            'uses' => 'ReportesController@reportesARLExcel',
        ]);

        //reporte ministerio
        Route::get("reportes-ministerio", [
            'as'    =>  'admin.reporte_ministerio',
            'uses'  =>  'ReportesController@reporteMinisterio'
        ]);

        Route::get("reportes-ministerio-excel", [
            'as'   => 'admin.reporte_ministerio_excel',
            'uses' => 'ReportesController@reporteMinisterioExcel',
        ]);


        //Reporte Constructora Bolivar
        Route::get("reportes-constructora-bolivar", [
            'as'   => 'admin.reportes_constructora_bolivar',
            'uses' => 'ReportesController@reportesConstructoraBol',
        ]);

        Route::get("reportes-constructora-bolivar-excel", [
            'as'   => 'admin.reportes_constructora_bolivar_excel',
            'uses' => 'ReportesController@reportesConstructoraBolExcel',
        ]);

         Route::get("reportes-diarios", [
            'as'   => 'admin.reportes_diario_seleccion',
            'uses' => 'ReportesController@reportesDiarioSeleccion',
        ]);

         Route::get("reportes-diarios-excel", [
            'as'   => 'admin.reportes_diarios_excel',
            'uses' => 'ReportesController@reportesDiarioSeleccionExcel',
        ]);
         

        Route::get("reportes-contratacion", [
            'as'   => 'admin.reportes_contratacion',
            'uses' => 'ReportesController@reportesDetallesContratacion',
        ]);

		Route::get("reportes-informe-crecimiento", [
            'as'   => 'admin.reportes_informe_crecimiento',
            'uses' => 'ReportesController@reportesInformeCrecimiento',
        ]);

		Route::get("reporte-informe-crecimiento-excel", [
            'as'   => 'admin.reportes.reportes_informe_crecimiento_excel',
            'uses' => 'ReportesController@reportesInformeCrecimientoExcel',
        ]);

        Route::get("reporte-detalles-reclu-excel", [
            'as'   => 'admin.reportes.reportes_detalles_reclu_excel',
            'uses' => 'ReportesController@reportesDetallesRecluExcel',
        ]);

        Route::get("reporte-detalles-contratacion-excel", [
            'as'   => 'admin.reportes.reportes_detalles_contratacion_excel',
            'uses' => 'ReportesController@reportesDetallesContratacionExcel',
        ]);

		Route::get("reportes-reporte-indicador", [
            'as'   => 'admin.reportes_reporte_indicador',
            'uses' => 'ReportesController@reportesReporteIndicador',
        ]);

		Route::get("reportes-reporte-indicador_excel", [
            'as'   => 'admin.reportes_reporte_indicador_excel',
            'uses' => 'ReportesController@reportesReporteIndicadorExcel',
        ]);

        //Reporte detalle requerimientos
        Route::get("reportes-detalles", [
            'as'   => 'admin.reportes_detalles',
            'uses' => 'ReportesController@reportesDetalles',
        ]);

        //Reporte seguimiento 1 a 1
        Route::get("reportes-seguimiento", [
            'as'   => 'admin.seguimiento_1',
            'uses' => 'ReportesController@reportesSeguimiento',
        ]);

		Route::get("reportes-examenes-medicos", [
            'as'   => 'admin.reportes_examenes_medicos',
            'uses' => 'ReportesController@reportesExamenesMedicos',
        ]);

        Route::get("reportes-seguimiento-excel", [
            'as'   => 'admin.reportes.reportes_seguimiento_excel',
            'uses' => 'ReportesController@reportesSeguimientoExcel',
        ]);

        Route::get("otras-fuentes-excel", [
            'as'   => 'admin.otras_fuentes_excel',
            'uses' => 'ReclutamientoController@excelOtrasFuentes',
        ]);
        
        Route::get("reporte-detalles-excel", [
            'as'   => 'admin.reportes.reportes_detalles_excel',
            'uses' => 'ReportesController@reportesDetallesExcel',
        ]);

        Route::get("reporte-examenes-medicos-excel", [
            'as'   => 'admin.reportes.reportes_examenes_medicos_excel',
            'uses' => 'ReportesController@reportesExamenesMedicosExcel',
        ]);

        //Reporte firma digital
        Route::get("reportes-firma-digital", [
            'as'   => 'admin.reporte_firma_digital',
            'uses' => 'ReporteFirmaController@index',
        ]);

        //Reporte excel firma digital
        Route::get("reporte-firma-digital-excel", [
            'as'   => 'admin.reportes.reportes_fima_digital_excel',
            'uses' => 'ReporteFirmaController@firmaDigitalExcel',
        ]);

        //Reporte firma digital
        Route::get("reporte-candidatos-descartados", [
            'as'   => 'admin.reporte_candidatos_descartados',
            'uses' => 'ReporteCandidatosDescartadosController@lista_descartados',
        ]);

        //Reporte excel firma digital
        Route::get("reporte-candidatos-descartados-excel", [
            'as'   => 'admin.reporte_candidatos_descartados_excel',
            'uses' => 'ReporteCandidatosDescartadosController@lista_descartados_excel',
        ]);

        //Reporte Encuesta Firma Contrato
        Route::get("reporte-encuesta-firma-contrato", [
            'as'   => 'admin.encuesta_firma_contrato',
            'uses' => 'ReporteEncuestaFirmaContratoController@lista_encuesta_firma_contrato',
        ]);

        //Reporte Encuesta Firma Contrato Excel
        Route::get("reporte-encuesta-firma-contrato-excel", [
            'as'   => 'admin.encuesta_firma_contrato_excel',
            'uses' => 'ReporteEncuestaFirmaContratoController@encuesta_firma_contrato_excel',
        ]);

        //Reporte Validacion Documental Documentos Vencidos
        Route::get("reporte-validacion-documental-vencimiento", [
            'as'   => 'admin.validacion_documental_vencimiento',
            'uses' => 'ReporteValidacionDocumentalVencimientoController@documentos_validacion_vencimiento',
        ]);

        //Reporte Validacion Documental Documentos Vencidos
        Route::get("reporte-validacion-documental-vencimiento-excel", [
            'as'   => 'admin.validacion_documental_vencimiento_excel',
            'uses' => 'ReporteValidacionDocumentalVencimientoController@documentos_validacion_vencimiento_excel',
        ]);

        // Inicio Reportes excel PTA
        Route::get("reportes-demanda", [
            'as'   => 'admin.reportes_demanda',
            'uses' => 'ReportesController@reportesDemanda',
        ]);
        Route::get("reportes-oferta", [
            'as'   => 'admin.reportes_oferta',
            'uses' => 'ReportesController@reportesOferta',
        ]);
        Route::get("reportes-carga", [
            'as'   => 'admin.reportes_carga',
            'uses' => 'ReportesController@reportesCarga',
        ]);
        
        Route::get("enviados-pruebas", [
            'as'   => 'admin.reporte_enviados_pruebas',
            'uses' => 'ReportesController@reportesEnviadosPruebas',
        ]);
        
        Route::get("reportes-descarga-contratacion", [
            'as'   => 'admin.reportes_descarga_contratacion',
            'uses' => 'ReportesController@reportesDescargaContratacion',
        ]);

        Route::get("reportes-contratados", [
            'as'   => 'admin.reportes_contratados',
            'uses' => 'ReportesController@reportesContratados',
        ]);
         Route::get("reportes-contratados-excel", [
            'as'   => 'admin.reportes_detalles_reportes_contratados_excel',
            'uses' => 'ReportesController@reportesContratadosExcel',
        ]);

        
        
        Route::get("reporte-demanda-excel", [
            'as'   => 'admin.reportes.reportes_detalles_demanda_excel',
            'uses' => 'ReportesController@reportesDemandaExcel',
        ]);
        
        Route::get("reporte-oferta-excel", [
            'as'   => 'admin.reportes_detalles_oferta_excel',
            'uses' => 'ReportesController@reportesOfertaExcel',
        ]);
        
        Route::get("reporte-descarga-contratacion-excel", [
            'as'   => 'admin.reportes_detalles_descarga_contratacion_excel',
            'uses' => 'ReportesController@reportesdescargaContratacionExcel',
        ]);

        Route::get("reporte-enviados-pruebas-excel", [
            'as'   => 'admin.reportes_detalles_enviados_pruebas_excel',
            'uses' => 'ReportesController@reportesEnviadosPruebasExcel',
        ]);
        
        Route::get("reporte-carga-excel", [
            'as'   => 'admin.reportes_detalles_carga_excel',
            'uses' => 'ReportesController@reportesCargaExcel',
        ]);
        //Fin reportes Excel PTA

        //Reporte diario KOMATSU
        Route::get("reportes-diario", [
            'as'   => 'admin.reportes_diario',
            'uses' => 'ReportesController@reportesDiario',
        ]);
        Route::get("reporte-diario-excel", [
            'as'   => 'admin.reportes.reportes_diario_excel',
            'uses' => 'ReportesController@reportesDiarioExcel',
        ]);

        //Reporte analistas KOMATSU
        Route::get("reportes-analistas", [
            'as'   => 'admin.reportes_analistas',
            'uses' => 'ReportesController@reportesAnalistas',
        ]);
        Route::get("reporte-analistas-excel", [
            'as'   => 'admin.reportes.reportes_analistas_excel',
            'uses' => 'ReportesController@reportesAnalistasExcel',
        ]);

        Route::get("reporte-contratados-cliente-excel", [
            "as"   => "admin.reportes_contratados_cliente_excel",
            "uses" => "ReportesController@reportesDetallesContraExcel",
        ]);

        //Reporte contratos a termino fijo
        Route::get("reportes-contratos-a-termino-fijo", [
            'as'   => 'admin.reporte_contratos_termino_fijo',
            'uses' => 'NotificacionTerminacionContratoController@reporte',
        ]);

        //Reporte contratos a termino fijo
        Route::get("reporte-contratos-a-termino-fijo-excel", [
            'as'   => 'admin.reporte_contratos_termino_fijo_excel',
            'uses' => 'NotificacionTerminacionContratoController@reporteExcel',
        ]);

        //Indicadores
        Route::get("admin-indicadores", ['as' => 'admin.indicadores', 'uses' => 'ReportesController@indicadores']);

        //requerimientos
        Route::get("requerimientos", ["as" => "admin.requerimiento", "uses" => "RequerimientoController@requerimientos"]);

        Route::get("consultar-negocio", ["as" => "admin.consultar_negocio", "uses" => "RequerimientoController@consultar_negocio_admin"]);

        Route::get("nueva-requisicion/{cliente_id}/{negocio_id}", ["as" => "admin.nuevo_requerimiento", "uses" => "RequerimientoController@nuevo_requerimiento_admin"]);

        Route::get("detalle-requisicion/{req_id}", ["as" => "admin.detalle_requerimiento1", "uses" => "RequerimientoController@detalle_requerimiento_admin"]);

        Route::post("guardar-requerimiento", ["as" => "admin.guardar_requerimiento", "uses" => "RequerimientoController@guardar_requerimiento_admin"]);

        //Informe Preliminar de candidatos
        Route::post("informe-preliminar", ["as" => "admin.informe_preliminar", "uses" => "InformePreliminarController@pdf_informe_preliminar"]);
        
        Route::post("informe-preliminar-formulario", ["as" => "admin.informe_preliminar_formulario", "uses" => "InformePreliminarController@get_informe_preliminar"]);

        Route::post("admin.gestion_informe_individual", ["as" => "admin.gestion_informe_individual", "uses" => "InformePreliminarController@gestion_informe_individual"]);
        Route::post("guarda-informe-preliminar", ["as" => "admin.guardar_informe_preliminar", "uses" => "InformePreliminarController@guardar_informe_preliminar"]);
        Route::post("guardar-informe-individual", ["as" => "admin.guardar_informe_individual", "uses" => "InformePreliminarController@guardar_informe_individual"]);
        Route::post("actalizar-informe-preliminar", ["as" => "admin.actualizar_informe_preliminar", "uses" => "InformePreliminarController@actualizar_informe_preliminar"]);

        //LLAMADA VIRTUAL
        // Route::get('llamada_virtual', ['as' => 'llamada_virtual', 'uses' => 'ReclutamientoController@llamada_virtual']);
        // Route::post('llamada_virtual', ['as' => 'post_llamada_virtual', 'uses' => 'ReclutamientoController@post_llamada_virtual']);

        Route::get('asistente-virtual', ['as' => 'llamada_virtual', 'uses' => 'AsistenteVirtualController@asistente']);
        Route::post('asistente-virtual-ejecucion', ['as' => 'post_llamada_virtual', 'uses' => 'AsistenteVirtualController@asistente_post']);

        //ENVIAR SMS
        Route::get('enviar_sms', ['as' => 'enviar_sms', 'uses' => 'ReclutamientoController@enviar_sms']);
        Route::post('enviar_sms', ['as' => 'post_enviar_sms', 'uses' => 'ReclutamientoController@post_enviar_sms']);

        Route::get("mis-requerimientos", ["as" => "admin.mis_requerimiento", "uses" => "RequerimientoController@mis_requerimientos_admin"]);

        Route::get('index', ['as' => 'admin.index', 'uses' => 'AdminController@index']);

        //Modulo de Reportes
        Route::get("reportes", ["as" => "admin.reportes", "uses" => "ReportesController@index"]);
        Route::get("reporte-candidato", ["as" => "admin.reporte_candidato", "uses" => "ReportesController@reporte_candidato"]);
        Route::get("reporte-candidato_excel", ["as" => "admin.reporte_candidato_excel", "uses" => "ReportesController@reporte_candidato_excel"]);

        Route::get("reporte-gestion", ["as" => "admin.reporte_gestion", "uses" => "ReportesController@reporte_gestion"]);
        Route::get("reporte-gestion-excel", ["as" => "admin.reporte_gestion_excel", "uses" => "ReportesController@reporte_gestion_excel"]);

        Route::post("ver_video_perfi", ["as" => "admin.ver_video_perfil", "uses" => "ReclutamientoController@video_perfil_modal"]);

        Route::get("reporte-contratado", ["as" => "admin.reporte_contratado", "uses" => "ReportesController@reporte_contratado"]);
        Route::get("reporte-contratado_excel", ["as" => "admin.reporte_contratado_excel", "uses" => "ReportesController@reporte_contratado_excel"]);

        Route::get("reporte-aplica-oferta", ["as" => "admin.reporte_aplica_oferta", "uses" => "ReportesController@reporte_aplica_oferta"]);
        Route::get("reporte-aplica-oferta-excel", ["as" => "admin.reporte_aplica_oferta_excel", "uses" => "ReportesController@reporte_aplica_oferta_excel"]);

        Route::get("reporte-bd-cargos", ["as" => "admin.reporte_bd_cargos", "uses" => "ReportesController@reporte_bd_cargos"]);
        Route::get("reporte-bd-cargos-excel", ["as" => "admin.reporte_bd_cargos_excel", "uses" => "ReportesController@reporte_bd_cargos_excel"]);

        //Modulo de Citación
        //Menú Citacion
        Route::get("lista_citaciones", ["as" => "admin.citaciones", "uses" => "CitaController@index"]);
		Route::get("lista_candidatos", ["as" => "admin.lista_candidatos", "uses" =>"CitaController@lista_candidatos"]);
        Route::post("crear_cita", ["as" => "admin.crear_cita", "uses" => "CitaController@crear_cita"]);
		Route::post("guardar_cita", ["as" => "admin.guardar_cita", "uses" => "CitaController@guardar_cita"]);
		Route::post("activar_cita", ["as" => "admin.activar_cita", "uses" => "CitaController@activar_cita"]);
		Route::post("inactivar_cita", ["as" => "admin.inactivar_cita", "uses" => "CitaController@inactivar_cita"]);
        Route::post("editar_cita", ["as" => "admin.editar_cita", "uses" => "CitaController@editar_cita"]);
        Route::post("actualizar_cita", ["as" => "admin.actualizar_cita", "uses" => "CitaController@actualizar_cita"]);

    	//Exámenes medicos masivos
        Route::post("enviar_examenes_masivo", ["as" => "admin.enviar_examenes_masivo", "uses" => "ReclutamientoController@enviar_examenes_masivo"]);
        Route::post("confirmar_examenes_masivo", ["as" => "admin.confirmar_examenes_masivo", "uses" => "ReclutamientoController@guardar_examenes_masivo"]);

        //Estudio virtual de seguridad masivos
        Route::post("enviar_evs_masivo", ["as" => "admin.enviar_evs_masivo", "uses" => "EstudioVirtualSeguridadController@enviar_evs_masivo"]);
        Route::post("confirmar_evs_masivo", ["as" => "admin.confirmar_evs_masivo", "uses" => "EstudioVirtualSeguridadController@guardar_evs_masivo"]);
		
		//Final ruta examenes medicos
        Route::get("citacion-gestion-reclutamiento", ["as" => "admin.citacion_reclutamiento", "uses" => "CitacionController@lista_reclutadores"]);
        Route::get("citacion-call-center", ["as" => "admin.call_center", "uses" => "CitacionController@lista_call_center"]);
        Route::get("citacion-carga-archivo-bd", ["as" => "admin.cargar_archivo_bd", "uses" => "CitacionController@citacion_reclutamiento"]);

        //Proceso Citación
        Route::get("citacion", ["as" => "admin.citacion", "uses" => "CitacionController@index"]);

        Route::get("citacion_masiva", ["as" => "admin.citacion_virtual", "uses" => "CitacionController@citacion_masiva"]);

        Route::post("carga_citacion_masiva", ["as" => "admin.carga_citacion_virtual", "uses" => "CitacionController@carga_citacion_masiva"]);
        
        Route::post("carga-reclutamiento-db", ["as" => "admin.reclutamiento_db", "uses" => "CitacionController@cargaMasiva"]);

        Route::post("registra_entrevista_entidad", ["as" => "admin.registra_entrevista_entidad", "uses" => "EntrevistaController@registra_proceso_entidad"]);

        Route::post("registra_entrevista_entidad2", ["as" => "admin.registra_entrevista_entidad2", "uses" => "EntrevistaController@registra_proceso_entidad2"]);

        Route::post("carga-perfil-db", ["as" => "admin.perfil_db", "uses" => "CitacionController@perfil_carga_db"]);

        Route::get("citacion-carga-perfil-archivo-bd", ["as" => "admin.cargar_perfil_bd", "uses" => "CitacionController@citacion_perfil"]);
        
        Route::get("lista-carga-perfil-archivo-bd", ["as" => "admin.lista_perfil_bd", "uses" => "CitacionController@lista_perfil"]);

        Route::get("carga-candidatos-otras-fuentes", ["as" => "admin.candidatos_otras_fuentes", "uses" => "CitacionController@citacion_otras_fuentes"]);
        
        Route::post("carga-candidatos-otras-fuentes", ["as" => "admin.carga_candidatos_fuentes", "uses" => "CitacionController@carga_otras_fuentes"]);

        Route::get("lista-carga-fuentes", ["as" => "admin.lista_carga_otras_fuentes", "uses" => "CitacionController@lista_carga_otras_fuentes"]);

        Route::post("filtrar-carga-fuentes", ["as" => "admin.filtrar_carga_otras_fuentes", "uses" => "CitacionController@ajax_carga_otras_fuentes"]);

        Route::post("enviar_requerimiento", ["as" => "admin.enviar_requerimiento", "uses" => "CitacionController@enviar_requerimiento"]);

        Route::get("gestionar-candidato-reclutamiento", ["as" => "admin.citacion_gestionar", "uses" => "CitacionController@gestionar_candidato_reclutamiento"]);

        Route::post("guardar_proceso_candidato", ["as" => "admin.guardar_proceso_candidato", "uses" => "CitacionController@guardar_proceso_candidato"]);

        Route::get("gestionar-candidato-call-center", ["as" => "admin.citacion_gestionar_call", "uses" => "CitacionController@gestionar_candidato_call_center"]);

        //Citacion desde el modulo de proceso
        Route::post("citar-candidato", ["as" => "admin.proceso_citacion", "uses" => "CitacionController@citar_candidato_proceso"]);

        Route::post("guardar-citacion", ["as" => "admin.guardar_citacion", "uses" => "CitacionController@guardar_citacion"]);
        Route::get("enviar_call_center", ["as" => "admin.enviar_call_center", "uses" => "CitacionController@enviar_call_center"]);
        Route::post("enviar_call_center_nuevo", ["as" => "admin.enviar_call_center_nuevo", "uses" => "CitacionController@enviar_call_center_nuevo"]);

        //Modulo Vinculación
        Route::post("vincular-candidato", ["as" => "admin.vincular", "uses" => "ReclutamientoController@vincular"]);
        Route::post("confirmar_vinculacion", ["as" => "admin.confirmar_vinculacion", "uses" => "ReclutamientoController@confirmar_enviar_validacion"]);
        Route::get("vinculacion", ["as" => "admin.vinculacion_lista", "uses" => "ReclutamientoController@vinculacion_lista"]);
        Route::get("gestionar-vinculacion/{ref_id}", ["as" => "admin.gestionar_vinculacion", "uses" => "ReclutamientoController@gestionar_vinculacion"]);
        Route::post("vadilar-vinculacion", ["as" => "admin.validar_vinculacion", "uses" => "ReclutamientoController@validar_vinculacion"]);

        //Nueva Hoja de Vida
        Route::get("datos-basicos", ["as" => "datos_basicos_admin", "uses" => "NuevaHvAdminController@datos_basicos"]);
        Route::post("datos_basicos", ["as" => "guardar_datos_basicos_admin", "uses" => "NuevaHvAdminController@nuevo_datos_basicos"]);

        //Editar Hoja de Vida
        Route::get("editar-hv-admin/{user_id}", ["as" => "admin.actualizar_hv_admin", "uses" => "NuevaHvAdminController@datos_hv"]);
        
        Route::post("editar_hv_admin/{user_id}", ["as" => "admin.hv_actualizada", "uses" => "NuevaHvAdminController@actualizar"]);

        //
        //Route::post("guardar-video-descripcion-admin", ["as" => "admin.guardar_video_descripcion", "uses" => "DatosBasicosController@guardar_video_descripcion"]);

        Route::post("guardar-video-descripcion-admin", ["as" => "admin.guardar_video_descripcion", "uses" => "DatosBasicosController@guardar_video_descripcion"]);        

        //Ajax Guardar Datos Basicos-------------------------------------------------------------------
        Route::post("actualizar_datos_basico/{user_id}", ["as" => "admin.ajax_actualizar_datos_basicos", "uses" => "NuevaHvAdminController@actualizar_datos_basicos"]);
        Route::post("actualizar_datos_contacto/{user_id}", ["as" => "admin.ajax_actualizar_datos_contacto", "uses" => "NuevaHvAdminController@actualizar_datos_contacto"]);
        Route::post("guardar_estudio", ["as" => "admin.ajax_guardar_estudios", "uses" => "NuevaHvAdminController@guardar_estudios"]);
        Route::post("guardar_experiencia", ["as" => "admin.ajax_guardar_experiencia", "uses" => "NuevaHvAdminController@guardar_experiencia"]);
        Route::post("guardar_referencia", ["as" => "admin.ajax_guardar_referencia", "uses" => "NuevaHvAdminController@guardar_referencia"]);
        Route::post("guardar_familia", ["as" => "admin.ajax_guardar_familia", "uses" => "NuevaHvAdminController@guardar_familia"]);
        Route::post("guardar_perfil", ["as" => "admin.ajax_guardar_perfil", "uses" => "NuevaHvAdminController@guardar_perfil"]);
        Route::post("guardar_idioma", ["as" => "admin.ajax_guardar_idioma", "uses" => "NuevaHvAdminController@guardar_idioma"]);
        //Ajax Editar Datos Basicos-------------------------------------------------------------------
        Route::post("editar_estudio", ["as" => "admin.ajax_editar_estudio", "uses" => "NuevaHvAdminController@editar_estudio"]);
        Route::post("editar_experiencia", ["as" => "admin.ajax_editar_experiencia", "uses" => "NuevaHvAdminController@editar_experiencia"]);
        Route::post("editar_referencia/", ["as" => "admin.ajax_editar_referencia", "uses" => "NuevaHvAdminController@editar_referencia"]);
        Route::post("editar_familiar/", ["as" => "admin.ajax_editar_familiar", "uses" => "NuevaHvAdminController@editar_familiar"]);

        //Ajax Actualizar Datos Basicos-----------------------------------------------------------------
        Route::post("actualizar_estudio", ["as" => "admin.ajax_actualizar_estudio", "uses" => "NuevaHvAdminController@actualizar_estudio"]);
        Route::post("actualizar_experiencia", ["as" => "admin.ajax_actualizar_experiencia", "uses" => "NuevaHvAdminController@actualizar_experiencia"]);
        Route::post("actualizar_referencia", ["as" => "admin.ajax_actualizar_referencia", "uses" => "NuevaHvAdminController@actualizar_referencia"]);
        Route::post("actualizar_familiar", ["as" => "admin.ajax_actualizar_familia", "uses" => "NuevaHvAdminController@actualizar_familiar"]);

        //Ajax Eliminar Datos Basicos-----------------------------------------------------------------
        Route::post("eliminar_estudio", ["as" => "admin.ajax_eliminar_estudio", "uses" => "NuevaHvAdminController@eliminar_estudio"]);
        Route::post("eliminar_experiencia", ["as" => "admin.ajax_eliminar_experiencia", "uses" => "NuevaHvAdminController@eliminar_experiencia"]);
        Route::post("eliminar_referencia", ["as" => "admin.ajax_eliminar_referencia", "uses" => "NuevaHvAdminController@eliminar_referencia"]);
        Route::post("eliminar_familia", ["as" => "admin.ajax_eliminar_familia", "uses" => "NuevaHvAdminController@eliminar_familiar"]);

        Route::get('permiso-negado', ['as' => 'admin.permiso_negado', 'uses' => 'AdminController@permiso_negado']);
        Route::get('cambiar_contrasena', ['as' => 'admin.cambiar_contrasena', 'uses' => 'UsuarioController@cambiar_contrasena']);
        Route::get('logout', ['as' => 'admin.logout', 'uses' => 'AdminController@logout']);
        Route::post('actualizar_contrasena_admin', ['as' => 'admin.actualizar_contrasena_admin', 'uses' => 'UsuarioController@actualizar_contrasena_admin']);

        Route::get('proceso-rrhh', ['as' => 'admin.proceso_rrh', 'uses' => 'AdminController@index']);
        Route::get('proceso-seleccion', ['as' => 'admin.proceso_seleccion', 'uses' => 'ProcesoSeleccionController@turno']);
        Route::get('reclutamiento', ['as' => 'admin.reclutamiento', 'uses' => 'AdminController@lista_reclutamiento']);
        // index tareas administrativas
        Route::get('tareas-admin', ['as' => 'admin.tareas.index', 'uses' => 'AdminController@index']);

        //PROCESO RECLUTAMIENTO
        Route::get('gestion-requerimiento/{req_id}', ['as' => 'admin.gestion_requerimiento', 'uses' => 'ReclutamientoController@gestion_req']);

        Route::post('filtro_preperfilados', ['as' => 'admin.filtro_preperfilados', 'uses' => 'ReclutamientoController@filtro_preperfilados']);

        Route::post('filtro_aplicaron', ['as' => 'admin.filtro_aplicaron', 'uses' => 'ReclutamientoController@filtro_aplicaron']);
        
        Route::post("mostrar_datos_basicos", ["as" => "admin.datos_contacto_mostrar", "uses" => "ReclutamientoController@mostrar_datos"]);
        
        Route::post("no_mostrar_datos_basicos", ["as" => "admin.datos_contacto_no_mostrar", "uses" => "ReclutamientoController@no_mostrar_datos"]);

        Route::post("asignar_psicologo", ["as" => "admin.asignar_psicologo", "uses" => "ReclutamientoController@asignar_psicologo"]);

        Route::post("asignar_psicologo_guardar", ["as" => "admin.asignar_psicologo_guardar", "uses" => "ReclutamientoController@asignar_psicologo_guardar"]);

        //admin.archivo_perfil

        Route::post('quitar-candidato-view', ['as' => 'admin.quitar_candidato_view', 'uses' => 'ReclutamientoController@quitar_candidato_view']);
        Route::post('quitar-candidato', ['as' => 'admin.quitar_candidato', 'uses' => 'ReclutamientoController@quitar_candidato']);

        Route::post('enviar-examentes', ['as' => 'admin.enviar_examenes_view', 'uses' => 'ReclutamientoController@enviar_examenes_view']);
        
        Route::post('enviar-estudio-seg', ['as' => 'admin.enviar_estudio_view', 'uses' => 'ReclutamientoController@enviar_estudio_seg_view']);

        Route::post('guardar-examentes', ['as' => 'admin.enviar_examenes', 'uses' => 'ReclutamientoController@enviar_examenes']);

        //Route::post("transferir-candidato", ["as" => "admin.transferir_dato", "uses" => "ReclutamientoController@transferir_candidato"]);
        Route::post("transferir-candidato", ["as" => "admin.transferir_dato", "uses" => "AsociarTransferirCandidatoController@transferir_candidato"]);

        Route::post('enviar-examenes-again-view', ['as' => 'admin.enviar_examenes_again_view', 'uses' => 'ReclutamientoController@enviar_examenes_again_view']);
        Route::post('guardar-examenes-salud-ocupacional', ['as' => 'admin.enviar_examenes_salud_ocup', 'uses' => 'ReclutamientoController@enviar_examenes_salud_ocup']);

        //--
        Route::post('enviar-estudio-seguridad', ['as' => 'admin.enviar_estudio_seguridad_view', 'uses' => 'ReclutamientoController@enviar_estudio_seguridad_view']);
        Route::post('guardar-estudio-seguridad', ['as' => 'admin.enviar_estudio_seguridad', 'uses' => 'ReclutamientoController@enviar_estudio_seguridad']);

        Route::get('estudios_seguridad', ['as' => 'admin.estudios_seguridad', 'uses' => 'DocumentosController@lista_documentos_estudio_seguridad']);

        Route::get("gestionar_documentos_estudio_seguridad/{ref_id}", ["as" => "admin.gestionar_documentos_estudio_seguridad", "uses" => "DocumentosController@gestionar_documentos_estudio_seguridad"]);
        //--

        //--
        Route::post('pre-contratacion-modal', ['as' => 'admin.pre_contratar_view', 'uses' => 'ContratacionController@pre_contratar_view']);
        Route::post('pre-contratacion-envio', ['as' => 'admin.pre_contratar', 'uses' => 'ContratacionController@pre_contratar']);

        Route::post('pre-contratacion-modal-masivo', ['as' => 'admin.pre_contratar_masivo_view', 'uses' => 'ContratacionController@pre_contratar_masivo_view']);
        Route::post('pre-contratacion-envio-masivo', ['as' => 'admin.confirmar_pre_contratar_masivo', 'uses' => 'ContratacionController@pre_contratar_masivo']);

        Route::post('contratacion-modal-masivo', ['as' => 'admin.contratar_masivo_view', 'uses' => 'ContratacionController@contratar_masivo_view']);
        Route::post('contratacion-envio-masivo', ['as' => 'admin.confirmar_contratar_masivo', 'uses' => 'ContratacionController@contratar_masivo']);
        //--
        Route::post("modal_documento_admin_seleccion", ["as" => "admin.cargarDocumentoAdminSeleccion", "uses" => "ContratacionController@cargar_documento_admin_seleccion"]);
        Route::post("guardar_documento_admin_seleccion", ["as" => "admin.guardar_documento_asistente_seleccion", "uses" => "ContratacionController@guardar_documento_asistente_seleccion"]);
        //--
        Route::post("modal_documento_admin_post", ["as" => "admin.cargarDocumentoAdminPost", "uses" => "ContratacionController@cargar_documento_admin_post"]);
        Route::post("guardar_documento_admin_post", ["as" => "admin.guardar_documento_asistente_post", "uses" => "ContratacionController@guardar_documento_asistente_post"]);

         Route::post("verify-documento-post", ["as" => "admin.contratacion.verify_document", "uses" => "ContratacionController@verifyDocument"]);
        //--
        Route::post("modal_documento_admin_contratacion", ["as" => "admin.cargarDocumentoAdminContratacion", "uses" => "ContratacionController@cargar_documento_admin_contratacion"]);

         Route::post("modal_documento_admin_confidencial", ["as" => "admin.cargarDocumentoAdminConfidencial", "uses" => "ContratacionController@cargar_documento_admin_confidencial"]);

          Route::post("guardar_documento_admin_confidencial", ["as" => "admin.guardar_documento_asistente_confidencial", "uses" => "ContratacionController@guardar_documento_asistente_confidencial"]);

        Route::post("guardar_documento_admin_contratacion", ["as" => "admin.guardar_documento_asistente_contratacion", "uses" => "ContratacionController@guardar_documento_asistente_contratacion"]);

        Route::post("modal_documento_admin_beneficiarios", ["as" => "admin.cargarDocumentoAdminBeneficiario", "uses" => "ContratacionController@cargar_documento_admin_beneficiario"]);

        Route::post("enviar_documentos_contratacion", ["as" => "admin.envio_documentos_contratacion", "uses" => "ContratacionController@envio_documentos_contratacion"]);
        //--

        Route::get('referenciacion', ['as' => 'admin.referenciacion', 'uses' => 'ReclutamientoController@referenciacion']);
        Route::get('referenciacion-academica', ['as' => 'admin.referenciacion_academica', 'uses' => 'ReclutamientoController@referenciacion_academica']);
        Route::get('documentos', ['as' => 'admin.valida_documentos', 'uses' => 'DocumentosController@lista_documentos']);
		Route::get('examenes_medicos', ['as' => 'admin.examenes_medicos', 'uses' => 'DocumentosController@lista_documentos_medicos']);

        //Gestionar citas
        Route::get('gestionar-citas', ['as' => 'admin.gestionar_citas', 'uses' => 'AgendamientoCitasController@lista_citas']);
        Route::get('gestionar-cita-detalle/{cita_id}', ['as' => 'admin.gestionar_citas_detalle', 'uses' => 'AgendamientoCitasController@gestionar_cita']);
        Route::post('gestionar-cita-asistio', ['as' => 'admin.gestionar_citas_asistio', 'uses' => 'AgendamientoCitasController@asistio_cita']);
        Route::post('gestionar-cita-cancelar', ['as' => 'admin.gestionar_citas_cancelar', 'uses' => 'AgendamientoCitasController@cancelar_cita']);

        //Prueba Valores Configuración
        Route::post('configuracion-prueba-ethical-values', ['as' => 'admin.configuracion_prueba_ethical_values', 'uses' => 'PruebaValoresController@configuracionEthicalValuesModal']);

        Route::post('guardar-configuracion-prueba-valores-requerimiento', ['as' => 'admin.guardar_configuracion_prueba_valores', 'uses' => 'PruebaValoresController@guardarConfiguracionPruebaValores']);

        //Agendamiento - Visualizar horarios reservados
        Route::post('horarios-reservados-cita', ['as' => 'admin.horarios_reservados_cita', 'uses' => 'AgendamientoCitasController@horariosReservadosModal']);

        //Configuracion Excel Requerimiento
        Route::post('configuracion-excel-requerimiento', ['as' => 'admin.configuracion_excel_requerimiento', 'uses' => 'PruebaExcelController@configuracionExcelModal']);

        //Configuracion Excel Requerimiento
        Route::post('configuracion-excel-cargo', ['as' => 'admin.configuracion_excel_cargo', 'uses' => 'PruebaExcelController@configuracionExcelModalCargo']);

        Route::post('guardar-configuracion-excel-requerimiento', ['as' => 'admin.guardar_configuracion_excel', 'uses' => 'PruebaExcelController@guardarConfiguracionExcelModal']);

        //BRYG - Visualizar configuración
        Route::post('configuracion-bryg-requerimiento', ['as' => 'admin.configuracion_bryg_requerimiento', 'uses' => 'PruebaBrygConfiguracionController@configuracionBrygModal']);

        Route::post('guardar-configuracion-bryg-requerimiento', ['as' => 'admin.guardar_configuracion_bryg_requerimiento', 'uses' => 'PruebaBrygConfiguracionController@guardarConfiguracionBryg']);

        Route::get('entrevistas', ["as" => "admin.entrevistas", "uses" => "EntrevistaController@index"]);



        /*
         * Prueba digitación - Configuración req
        */
        Route::post('configuracion-digitacion-requerimiento', ['as' => 'admin.configuracion_digitacion_requerimiento', 'uses' => 'PruebaDigitacionController@configuracion_digitacion_req']);

        Route::post('guardar-configuracion-digitacion-requerimiento', ['as' => 'admin.guardar_configuracion_digitacion_requerimiento', 'uses' => 'PruebaDigitacionController@guardar_configuracion_digitacion_req']);

        Route::post('configuracion-digitacion-cargo', ['as' => 'admin.configuracion_digitacion_cargo', 'uses' => 'PruebaDigitacionController@configuracion_cargo']);

        Route::post('guardar-configuracion-digitacion-cargo', ['as' => 'admin.guardar_configuracion_digitacion_cargo', 'uses' => 'PruebaDigitacionController@guardar_configuracion_digitacion_cargo']);

        /*
         * Prueba competencias - Configuración cargo y req
        */
            Route::post('configuracion-competencias-cargo', ['as' => 'admin.configuracion_competencias_cargo', 'uses' => 'PruebaCompetenciasController@configuracion_cargo']);

            Route::post('guardar-configuracion-competencias-cargo', ['as' => 'admin.guardar_configuracion_competencias_cargo', 'uses' => 'PruebaCompetenciasController@guardar_configuracion_cargo']);

            Route::post('actualizar-configuracion-competencias-cargo', ['as' => 'admin.actualizar_configuracion_competencias_cargo', 'uses' => 'PruebaCompetenciasController@actualizar_configuracion_cargo']);

            Route::post('configuracion-competencias-requerimiento', ['as' => 'admin.configuracion_competencias_requerimiento', 'uses' => 'PruebaCompetenciasController@configuracion_requerimiento']);

            Route::post('guardar-configuracion-competencias-requerimiento', ['as' => 'admin.guardar_configuracion_competencias_requerimiento', 'uses' => 'PruebaCompetenciasController@guardar_configuracion_requerimiento']);

            Route::post('cargar-configuracion-competencias', ['as' => 'admin.cargar_configuracion_competencias', 'uses' => 'PruebaCompetenciasController@cargar_configuracion']);
        //

        Route::post("registra_entrevista_entidad2", ["as" => "admin.registra_entrevista_entidad2", "uses" => "EntrevistaController@registra_proceso_entidad2"]);

        Route::get('pruebas', ['as' => 'admin.pruebas', 'uses' => 'ReclutamientoController@lista_pruebas']);

        Route::post('detalle-requerimiento', ['as' => 'admin.detalle_requerimiento', 'uses' => 'ReclutamientoController@detalle_requerimiento']);
        Route::post("agregar-candidato-aplicados", ["as" => "admin.agregar_candidato_aplicados", "uses" => "ReclutamientoController@agregar_candidato"]);

        Route::post("agregar-candidato-aplicados-ee", ["as" => "admin.agregar_candidato_aplicados_ee", "uses" => "ReclutamientoController@agregar_candidato_ee"]);

		Route::post("agregar-candidato-preperfilados", [
			"as" => "admin.agregar_candidato_preperfilados",
			"uses" => "ReclutamientoController@agregar_candidato_preperfilados"
		]);

        //Route::post("agregar-candidato-fuentes", ["as" => "admin.agregar_candidato_fuentes", "uses" => "ReclutamientoController@agregar_candidato_fuentes"]);

        Route::post("agregar-candidato-fuentes-nuevo", ["as" => "admin.agregar_candidato_fuentes", "uses" => "AsociarTransferirCandidatoController@agregar_candidato_fuentes"]);

        Route::post("agregar-candidato-nuevo", ["as" => "admin.agregar_candidato_nuevo", "uses" => "ReclutamientoController@agregar_candidato_nuevo"]);

       	Route::post("buscar-candidato-otras-fuentes", ["as" => "admin.ajaxgetcandidato", "uses" => "ReclutamientoController@buscar_candidato"]);

        Route::post("editar-candidato-fuentes/{id}", ["as" => "admin.editar_candidato_fuentes", "uses" => "ReclutamientoController@editar_candidato_fuentes"]);

        Route::post("actualizar-candidato-fuentes", ["as" => "admin.actualizar_candidato_fuente", "uses" => "ReclutamientoController@actualizar_candidato_fuente"]);
        
        Route::get("eliminar-candidato-fuente/{id}", ["as" => "admin.eliminar_candidato_fuentes", "uses" => "ReclutamientoController@eliminar_candidato_fuente"]);
        
        Route::get("eliminar-candidato-preperfilado/{id}", [
        	"as" => "admin.eliminar_candidato_preperfilado",
        	"uses" => "ReclutamientoController@eliminar_candidato_preperfilado"
        ]);

        Route::get("eliminar-candidato-postulado/{id}", ["as" => "admin.eliminar_candidato_postulado", "uses" => "ReclutamientoController@eliminar_candidato_postulado"]);

        Route::post("eliminar-candidato-gestion-view", ["as" => "admin.eliminar_candidato_gestion_view", "uses" => "ReclutamientoController@eliminar_candidato_gestion_view"]);

        Route::post("confirmar-eliminar-candidato-gestion", ["as" => "admin.confirmar_eliminar_candidato_gestion_modulo", "uses" => "ReclutamientoController@confirmar_eliminar_candidato_gestion"]);

        Route::post("mostrar-observaciones-candidato-hv", ["as" => "admin.mostrar_observaciones_hv", "uses" => "ReclutamientoController@mostrar_observaciones_hv"]);

        Route::post("guardar-candidato-fuente", ["as" => "admin.guardar_candidato_fuente", "uses" => "ReclutamientoController@guardar_candidato_fuente"]);
        
        Route::post("estados_requerimiento", ["as" => "admin.estados_requerimiento", "uses" => "ReclutamientoController@estados_requerimiento"]);
        Route::post("terminar_requerimiento", ["as" => "admin.terminar_requerimiento", "uses" => "ReclutamientoController@terminar_requerimiento"]);

        Route::post("enviar_pruebas_view", ["as" => "admin.enviar_pruebas_view", "uses" => "ReclutamientoController@enviar_pruebas_view"]);

        Route::post("confirmar_prueba", ["as" => "admin.confirmar_prueba", "uses" => "ReclutamientoController@confirmar_prueba"]);

        /*
         * Pruebas técnicas
        */

        Route::post("enviar-pruebas-tecnicas", ["as" => "admin.enviar_pruebas_tecnicas", "uses" => "PruebasTecnicasController@enviar_pruebas_tecnicas"]);
        Route::post("confirmar-pruebas-tecnicas", ["as" => "admin.confirmar_pruebas_tecnicas", "uses" => "PruebasTecnicasController@confirmar_pruebas_tecnicas"]);

        /* Fin */

        //Reusar bryg
        Route::post("reusar-prueba-bryg", ["as" => "admin.bryg.reusar_prueba", "uses" => "ReclutamientoController@reusar_prueba_bryg"]);

        Route::get("retroalimentacion_videos/{req_id?}/{cedula?}", ["as" => "admin.retroalimentacion_videos", "uses" => "RetroalimentacionVideoController@index"]);

        Route::get("gestionar_retroalimentacion_video/{ref_id}", ["as" => "admin.gestionar_retroalimentacion_video", "uses" => "RetroalimentacionVideoController@gestionar_retroalimentacion_video"]);

        Route::post("enviar_retroalimentacion_view", ["as" => "admin.enviar_retroalimentacion_video_view", "uses" => "RetroalimentacionVideoController@enviar_retroalimentacion_view"]);

        Route::post("confirmar_retroalimentacion_video", ["as" => "admin.confirmar_retroalimentacion_video", "uses" => "RetroalimentacionVideoController@confirmar_retroalimentacion_video"]);

        Route::post("guardar-retroalimentacion-video", ["as" => "admin.guardar_retroalimentacion_video", "uses" => "RetroalimentacionVideoController@guardar_retroalimentacion_video"]);

        Route::post("detalle_otras_fuentes", ["as" => "admin.detalle_otras_fuentes", "uses" => "ReclutamientoController@detalle_otras_fuentes"]);

        Route::post("enviar_referenciacion_view", ["as" => "admin.enviar_referenciacion_view", "uses" => "ReclutamientoController@enviar_referenciacion_view"]);

        Route::post("enviar_referencia_estudios_view", ["as" => "admin.enviar_referencia_estudios_view", "uses" => "ReclutamientoController@enviar_referencia_estudios_view"]);
        //visita domiciliaria

        Route::get('lista_visitas', ["as" => "admin.lista_visitas_domiciliarias", "uses" => "VisitasDomiciliariasController@index"]);

        Route::post("nueva-visita-domiciliaria", ["as" => "admin.nueva_visita_domiciliaria", "uses" => "VisitasDomiciliariasController@nuevaVisita"]);

        Route::post("guardar-nueva-visita", ["as" => "admin.visita.guardar_nueva_visita", "uses" => "VisitasDomiciliariasController@store"]);

        

        Route::get("gestionar-visita-domiciliaria/{ref_id}/{tipo?}", ["as" => "admin.gestionar_visita_domiciliaria", "uses" => "VisitasDomiciliariasController@gestionarVisita"]);

        Route::get("realizar-visita-admin/{visita_id}/{edit?}", ["as" => "admin.visita.realizar_visita_admin", "uses" => "VisitasDomiciliariasController@realizarVisitaAdmin"]);

        Route::post("save-visita-admin", ["as" => "admin.visita.save_visita_admin", "uses" => "VisitasDomiciliariasController@saveVisitaAdmin"]);

        Route::get("gestionar-inform-visita/{id_visita}", ["as" => "admin.visita.gestionar_informe", "uses" => "VisitasDomiciliariasController@gestionarInforme"]);
        
        Route::get("gestionar-inform-visita-new/{id_visita}", ["as" => "admin.visita.gestionar_informe_new", "uses" => "VisitasDomiciliariasController@gestionarInforme_new"]);

        Route::post("modal-enlace-visita", ["as" => "admin.modal_enlace_visita", "uses" => "VisitasDomiciliariasController@agregarLink"]);

        Route::post("guardar-enlace-visita", ["as" => "admin.guardar_enlace_visita", "uses" => "VisitasDomiciliariasController@registrarLink"]);

        Route::post("cancelar-visita-domiciliaria", ["as" => "admin.visita.cancelar_visita_domiciliaria", "uses" => "VisitasDomiciliariasController@cancelarVisita"]);

        
        Route::post("guardar-vetting", ["as" => "admin.visita.guardar_vetting", "uses" => "VisitasDomiciliariasController@guardarVetting"]);

        Route::post("modal-soporte-verificacion", ["as" => "admin.visita.agregar_soporte_view", "uses" => "VisitasDomiciliariasController@agregarSoporteView"]);

        Route::post("guardar-soporte-verificacion", ["as" => "admin.visita.guardar_soporte", "uses" => "VisitasDomiciliariasController@guardarSoporte"]);

        //Visita gestion req
        Route::post("enviar-visita-domiciliaria", ["as" => "admin.enviar_visita_domiciliaria_view", "uses" => "ReclutamientoController@enviarVisitaDomiciliariaView"]);

        Route::post("confirmar-visita-domiciliaria", ["as" => "admin.confirma_visita_domiciliaria", "uses" => "ReclutamientoController@confirmarVisitaDomiciliaria"]);
        //fin vista gestion req

        //FIN DE VISITA DOMICILIARIA


        //Estudio Virtual de Seguridad
        Route::get('lista-estudio-virtual-seguridad', ["as" => "admin.lista_estudio_virtual_seguridad", "uses" => "EstudioVirtualSeguridadController@lista_evs"]);

        Route::get("gestionar-estudio-virtual-seguridad/{id_evs}", ["as" => "admin.gestionar_estudio_virtual_seguridad", "uses" => "EstudioVirtualSeguridadController@gestionar_evs"]);

        Route::post("enviar-estudio-virtual-seguridad-view", ["as" => "admin.enviar_estudio_virtual_seguridad_view", "uses" => "EstudioVirtualSeguridadController@enviarEVSView"]);

        Route::post("confirmar-envio-estudio-virtual-seguridad", ["as" => "admin.confirma_estudio_virtual_seguridad", "uses" => "EstudioVirtualSeguridadController@confirmarEVS"]);

        Route::get("pdf-estudio-virtual-seguridad/{id_evs}", ["as" => "admin.pdf_estudio_virtual_seguridad", "uses" => "EstudioVirtualSeguridadController@pdf_estudio_virtual_seguridad"]);

        Route::post("aspectos-relevantes-estudio-virtual-seguridad-view", ["as" => "admin.aspectos_relevantes_evs_view", "uses" => "EstudioVirtualSeguridadController@view_aspectos_relevantes_evs"]);

        Route::post("save-aspectos-relevantes-estudio-virtual-seguridad", ["as" => "admin.guardar_aspectos_relevantes_evs", "uses" => "EstudioVirtualSeguridadController@save_aspectos_relevantes_evs"]);

        Route::post("save-concepto-estudio-virtual-seguridad", ["as" => "admin.guardar_concepto_evs", "uses" => "EstudioVirtualSeguridadController@save_concepto_evs"]);

            //Procesos EVS
        Route::get('procesos-estudio-virtual-seguridad', ["as" => "admin.procesos_evs", "uses" => "ProcesosEvsController@procesos_evs"]);
        Route::get('lista-analisis-financiero-estudio-virtual-seguridad', ["as" => "admin.lista_analisis_financiero_evs", "uses" => "ProcesosEvsController@lista_analisis_financiero_evs"]);
        Route::get('lista-consulta-antecedentes-estudio-virtual-seguridad', ["as" => "admin.lista_consulta_antecedentes_evs", "uses" => "ProcesosEvsController@lista_consulta_antecedentes_evs"]);
        Route::get('lista-referenciacion-academica-estudio-virtual-seguridad', ["as" => "admin.lista_referenciacion_academica_evs", "uses" => "ProcesosEvsController@lista_referenciacion_academica_evs"]);
        Route::get('lista-referenciacion-laboral-estudio-virtual-seguridad', ["as" => "admin.lista_referenciacion_laboral_evs", "uses" => "ProcesosEvsController@lista_referenciacion_laboral_evs"]);
        Route::get('lista-visita-domiciliaria-estudio-virtual-seguridad', ["as" => "admin.lista_visita_domiciliaria_evs", "uses" => "ProcesosEvsController@lista_visita_domiciliaria_evs"]);
        //Fin Estudio Virtual de Seguridad

        Route::post("enviar-consentimientos-permisos-adicionales", [
            "as"    => "admin.enviar_consentimiento_permisos_adicionales",
            "uses"  => "ConsentimientosPermisosAdicionalesController@enviar_consentimiento_permisos_adicionales"
        ]);

        Route::post("confirmar-consentimientos-permisos-adicionales", [
            "as" => "admin.confirmar_envio_consentimiento_permisos_adicionales",
            "uses" => "ConsentimientosPermisosAdicionalesController@confirmar_envio_consentimiento_permisos_adicionales"
        ]);

        Route::post("detalle_dotacion_view", ["as" => "admin.dotacion_view", "uses" => "ReclutamientoController@dotacion_view"]);

        Route::post("confirmar_dotacion", ["as" => "admin.confirmar_dotacion", "uses" => "ReclutamientoController@confirmar_dotacion"]);

        Route::post("detalle_kactus_view", ["as" => "admin.kactus_view", "uses" => "ReclutamientoController@kactus_view"]);

        Route::post("confirmar_kactus", ["as" => "admin.confirmar_kactus", "uses" => "ReclutamientoController@confirmar_kactus"]);

        Route::post("enviar_asistencia_view_masivo", ["as" => "admin.enviar_asistencia_view_masivo", "uses" => "ReclutamientoController@enviar_asistencia_view_masivo"]);

        Route::post("confirmar_asistencia_masivo", ["as" => "admin.confirmar_asistencia_masivo", "uses" => "ReclutamientoController@confirmar_asistencia_masivo"]);

        Route::post("enviar_referenciacion_view_masivo", [
        	"as" => "admin.enviar_referenciacion_view_masivo",
        	"uses" => "ReclutamientoController@enviar_referenciacion_view_masivo"
        ]);

        Route::post("confirmar_referenciacion_masivo", [
        	"as" => "admin.confirmar_referenciacion_masivo",
        	"uses" => "ReclutamientoController@confirmar_referenciacion_masivo"
        ]);

        Route::post("confirmar_referencia_estudios_masivo", [
        	"as" => "admin.confirmar_referencia_estudios_masivo",
        	"uses" => "ReclutamientoController@confirmar_referencia_estudios_masivo"
        ]);

        Route::post("confirmar_referenciacion", ["as" => "admin.confirmar_referenciacion", "uses" => "ReclutamientoController@confirmar_referenciacion"]);

        Route::post("confirmar_referencia_estudios", ["as" => "admin.confirmar_referencia_estudios", "uses" => "ReclutamientoController@confirmar_referencia_estudios"]);

        Route::post("enviar_entrevista_multiple_view", ["as" => "admin.enviar_entrevista_multiple_view", "uses" => "ReclutamientoController@enviar_entrevista_multiple_view"]);

        Route::post("confirmar_entrevista_multiple", ["as" => "admin.confirmar_entrevista_multiple", "uses" => "ReclutamientoController@confirmar_entrevista_multiple"]);

        Route::get("entrevistas_multiples/{requerimiento_id?}", ["as" => "admin.entrevistas_multiples", "uses" => "EntrevistaMultipleController@index"]);

        Route::get("gestionar_entrevista_multiple/{entrevista_id}", ["as" => "admin.gestionar_entrevista_multiple", "uses" => "EntrevistaMultipleController@gestionar_entrevista_multiple"]);

        Route::post("no_asistio_multiple", ["as" => "admin.ajax_no_asistio_multiple", "uses" => "EntrevistaMultipleController@guardar_no_asistio"]);

        Route::post("guardar_detalles_multiple", ["as" => "admin.ajax_guardar_detalles_multiple", "uses" => "EntrevistaMultipleController@guardar_detalles_entre_multiple"]);

        Route::post("guardar_varios_detalles_multiple", ["as" => "admin.ajax_guardar_preventivo_detalles_multiple", "uses" => "EntrevistaMultipleController@guardar_varios_detalles_entre_multiple"]);

        Route::post("guardar_concepto_entrevista_multiple", ["as" => "admin.ajax_guardar_concepto_entrevista_multiple", "uses" => "EntrevistaMultipleController@guardar_concepto_entrevista_multiple"]);

        Route::post("enviar_entrevista_view_masivo", ["as" => "admin.enviar_entrevista_view_masivo", "uses" => "ReclutamientoController@enviar_entrevista_view_masivo"]);

        Route::post("confirmar_entrevista_masivo", ["as" => "admin.confirmar_entrevista_masivo", "uses" => "ReclutamientoController@confirmar_entrevista_masivo"]);

        Route::post("enviar_pruebas_view_masivo", ["as" => "admin.enviar_pruebas_view_masivo", "uses" => "ReclutamientoController@enviar_pruebas_view_masivo"]);

        Route::post("confirmar_pruebas_masivo", ["as" => "admin.confirmar_pruebas_masivo", "uses" => "ReclutamientoController@confirmar_pruebas_masivo"]);

        Route::get("hv_pdf_tabla/{user_id}",["as" => "hv_pdf_tabla", "uses" => "ReclutamientoController@pdf_hoja_vida"]);
        // formatos gpc para long list
        Route::get("hv_longlist",["as" => "admin.hv_long_list","uses" => "ReclutamientoController@hv_longlist"]);

         Route::get("longlist_excel",["as" => "admin.excel_long_list","uses" => "ReclutamientoController@longlist_excel"]);

        Route::get("informe-seleccion-tabla/{user_id}", ["as" => "admin.informe_seleccion-tabla", "uses" => "ReclutamientoController@pdf_informe_seleccion_gpc"]);

        Route::get("informe-individual-pdf/{user_id}/{req_id}", ["as" => "admin.informe_individual_pdf", "uses" => "ReclutamientoController@pdf_informe_individual"]);
        //ficha de humannet
        Route::get("ficha_candidato/{user_id}", ["as" => "admin.ficha_candidato", "uses" => "ReclutamientoController@ficha_candidato_pdf"]);

        Route::post("enviar_entrevista_view", ["as" => "admin.enviar_entrevista_view", "uses" => "ReclutamientoController@enviar_entrevista_view"]);

        Route::post("confirmar_entrevista", ["as" => "admin.confirmar_entrevista", "uses" => "ReclutamientoController@confirmar_entrevista"]);

        Route::post("asistencia_entrevista", ["as" => "admin.enviar_entrevista_asistencia", "uses" => "ReclutamientoController@enviar_entrevista_asistencia"]);

        Route::post("confirmar_asistencia", ["as" => "admin.confirmar_asistencia", "uses" => "ReclutamientoController@confirmar_asistencia"]);

        Route::post("confirmar_documento", ["as" => "admin.confirmar_documento", "uses" => "DocumentosController@confirmar_documento"]);

        Route::post("enviar_documento_view", ["as" => "admin.enviar_documento_view", "uses" => "DocumentosController@enviar_documento_view"]);

        Route::post("enviar_entrevista_virtual_view_masivo", ["as" => "admin.enviar_entrevista_virtual_view_masivo", "uses" => "ReclutamientoController@enviar_entrevista_virtual_view_masivo"]);

        Route::post("confirmar_entrevista_virtual_masivo", ["as" => "admin.confirmar_entrevista_virtual_masivo", "uses" => "ReclutamientoController@confirmar_entrevista_virtual_masivo"]);

        //ruta para cambiar empresa que contrata
        Route::post("cambiar_empresa", ["as" => "admin.cambio_empresa", "uses" => "RequerimientoController@cambio_empresa"]);

       	Route::post("enviar_aprobar_cliente_view_masivo", ["as" => "admin.enviar_aprobar_cliente_view_masivo", "uses" => "ReclutamientoController@enviar_aprobar_cliente_view_masivo"]);

       	Route::post("confirmar_aprobar_cliente_masivo", ["as" => "admin.confirmar_aprobar_cliente_masivo", "uses" => "ReclutamientoController@confirmar_aprobar_cliente_masivo"]);

        Route::post("aprobar-candidatos-view-masivo", ["as" => "admin.aprobar_candidatos_admin_view_masivo", "uses" => "ReclutamientoController@aprobar_candidatos_admin_view_masivo"]);

        Route::post("confirmar-aprobar-candidato-masivo", ["as" => "admin.confirmar_aprobar_candidato_masivo", "uses" => "ReclutamientoController@confirmar_aprobar_candidato_masivo"]);

        Route::get("excel-candidatos-aprobar-req-masivo", [
            'as'   => 'admin.aprobar_candidatos_req_masivo_excel',
            'uses' => 'ReclutamientoController@excelCandidatosAprobarClienteMasivo',
        ]);

        Route::post("enviar_documento_view_masivo", ["as" => "admin.enviar_documento_view_masivo", "uses" => "ReclutamientoController@enviar_documento_view_masivo"]);

        Route::post("confirmar_documento_masivo", ["as" => "admin.confirmar_documento_masivo", "uses" => "ReclutamientoController@confirmar_documento_masivo"]);

        Route::get("autocomplete_cuidades", ["as" => "autocomplete_cuidades2", "uses" => "DatosBasicosController@autocomplete_cuidades"]);

        Route::post("enviar_aprobar_cliente_view", ["as" => "admin.enviar_aprobar_cliente_view", "uses" => "ReclutamientoController@enviar_aprobar_cliente_view"]);

        Route::post("confirmar_aprobar_cliente", ["as" => "admin.confirmar_aprobar_cliente", "uses" => "ReclutamientoController@confirmar_aprobar_cliente"]);

        Route::get("aprobar_cliente_admin", ["as" => "admin.aprobar_cliente_admin", "uses" => "ReclutamientoController@aprobar_cliente_admin"]);

        Route::get("gestionar_aprobar_cliente_admin/{ref_id}", ["as" => "admin.gestionar_aprobar_cliente_admin", "uses" => "ReclutamientoController@gestionar_aprobar_cliente_admin"]);

        Route::post("nuevo-soporte-aprobacion/{ref_id}", ["as" => "admin.nuevo_soporte_aprobacion", "uses" => "ReclutamientoController@nuevo_soporte_aprobacion"]);

        Route::post("guardar-soporte-aprobacion/{ref_id}", ["as" => "admin.guardar_soporte_aprobacion", "uses" => "ReclutamientoController@guardar_soporte_aprobacion"]);

        Route::post("enviar_contratar", ["as" => "admin.enviar_contratar", "uses" => "ReclutamientoController@enviar_contratar2"]);

        Route::post("enviar_contratar2", ["as" => "admin.enviar_contratar2", "uses" => "ReclutamientoController@enviar_contratar2"]);

        Route::post("enviar_a_contratar", ["as" => "admin.enviar_a_contratar", "uses" => "ReclutamientoController@enviar_a_contratar"]);
        
        Route::post("enviar_a_contratar_cliente", ["as" => "admin.enviar_a_contratar_cliente", "uses" => "ReclutamientoController@enviar_a_contratar_cliente"]);

        Route::post("observacion_gestion", ["as" => "admin.observaciones", "uses" => "ReclutamientoController@observaciones_gestion"]);

        Route::post("guardar_observacion_gestion", ["as" => "admin.guardar_observaciones_gestion", "uses" => "ReclutamientoController@guardar_observaciones_gestion"]);
         
        Route::post("rechazar_candidato_cliente", ["as" => "admin.rechazar_candidato_cliente", "uses" => "ReclutamientoController@rechazar_candidato_cliente"]);

        Route::post("rechazar_candidato_view", ["as" => "admin.rechazar_candidato_view", "uses" => "ReclutamientoController@rechazar_candidato_view"]);

        Route::post("rechazar_candidato", ["as" => "admin.rechazar_candidato", "uses" => "ReclutamientoController@rechazar_candidato"]);

        Route::post("seguimiento_candidato", ["as" => "admin.seguimiento_candidato", "uses" => "ReclutamientoController@seguimiento_candidato"]);

        //Reenvío de correo contratación
        Route::post("reenvio-correo-contratacion", ["as" => "admin.reenviar_correo_contratacion", "uses" => "ReclutamientoController@reenviar_correo"]);

        //Reenvío de correo para completar videos
        Route::post("reenvio-correo-video-confirmacion", ["as" => "admin.reenviar_correo_video_confirmacion", "uses" => "ReclutamientoController@reenviar_correo_video_confirmacion"]);

        //Reenvío de correo para completar videos
        Route::post("pausar-firma-virtual", ["as" => "admin.pausar_firma_virtual", "uses" => "ReclutamientoController@pausar_firma"]);
        
        Route::post("editar-informacion-contrato", ["as" => "admin.editar_informacion_contrato", "uses" => "ReclutamientoController@editar_informacion_contratacion"]);
        Route::post("guardar-informacion-contratatacion", ["as" => "admin.guardar_informacion_contratacion", "uses" => "ReclutamientoController@guardar_informacion_contratacion"]);

        //Anular contratación candidato
        Route::post("anular-contratacion-candidato", ["as" => "admin.anular_contratacion_candidato", "uses" => "ContratacionVirtualController@anular_contratacion_candidato"]);

        //Reenviar a contratar anulación
        Route::post("reenviar_a_contratar", ["as" => "admin.reenviar_a_contratar", "uses" => "ReclutamientoController@reenviar_a_contratar"]);
        Route::post("reenviar_a_contratar_proceso", ["as" => "admin.reenviar_a_contratar_proceso", "uses" => "ReclutamientoController@reenviar_a_contratar_proceso"]);

        //Generate check Truora
        Route::post("truora-check", ["as" => "admin.generate_check_truora", "uses" => "Integrations\TruoraIntegrationController@generate_check_truora"]);

        //PDF Truora
        //Route::get("truora-pdf", ["as" => "admin.ver_pdf_truora", "uses" => "Integrations\TruoraIntegrationController@ver_pdf_truora"]);

        //TusDatos.co
        Route::post("tusdatos-launch", ["as" => "admin.tusdatos_launch", "uses" => "Integrations\TusDatosIntegrationController@consultarPersona"]);
        Route::post("tusdatos-enviar", ["as" => "admin.tusdatos_enviar", "uses" => "Integrations\TusDatosIntegrationController@enviarConsulta"]);

        Route::post("tusdatos-launch-evs", ["as" => "admin.tusdatos_launch_evs", "uses" => "Integrations\TusDatosEvsIntegrationController@consultarPersonaEVS"]);
        Route::post("tusdatos-enviar-evs", ["as" => "admin.tusdatos_enviar_evs", "uses" => "Integrations\TusDatosEvsIntegrationController@enviarConsultaEvs"]);
        
        Route::post("guardar_notas", ["as" => "admin.guardar_notas", "uses" => "ReclutamientoController@guardar_notas"]);

        Route::get("paquete_contratacion_pdf/{id}", ["as" => "admin.paquete_contratacion_pdf", "uses" => "ReclutamientoController@pdf_paquete_contratacion"]);

        Route::get("hv_pdf/{user_id}", ["as" => "admin.hv_pdf", "uses" => "ReclutamientoController@pdf_hv"]);
        
        //Route::get("hv_pdf/{user_id}", ["as" => "admin.hv_pdf", "uses" => "ReclutamientoController@pdf_hv"]);

        Route::get("habeas-pdf/{req_can_id}", ["as" => "admin.habeas", "uses" => "ReclutamientoController@pdf_habeas"]);

        Route::get("informe-seleccion/{user_id}", ["as" => "admin.informe_seleccion", "uses" => "ReclutamientoController@pdf_informe_seleccion"]);
        //-----
        Route::post("verifica_cita_cliente", ["as" => "admin.verifica_cita_cliente", "uses" => "ReclutamientoController@verifica_cita_cliente"]);

        Route::post("modifica_cita_cliente", ["as" => "admin.modifica_cita_cliente", "uses" => "ReclutamientoController@modifica_cita_cliente"]);
        //---

        //Consulta de seguridad
            Route::post("consulta_seguridad_verifica", ["as" => "admin.consulta_seguridad_verifica", "uses" => "ConsultaSeguridadController@ConsultaVerifica"]);

            Route::get("consulta_seguridad", ["as" => "admin.consulta_seguridad", "uses" => "ConsultaSeguridadController@QueryPerson"]);

        // Consulta Core
            Route::post("verificacion-core", ["as" => "admin.verificacion_documento_core", "uses" => "ConsultaValidacionDocumentoCore@validar_limite"]);
            Route::post("consulta-documento", ["as" => "admin.consulta_documento_core", "uses" => "ConsultaValidacionDocumentoCore@validar_documento"]);

        //Consulta de seguridad sin proceso
            Route::get("consulta-seguridad-candidato", ["as" => "admin.consulta_seguridad_candidato", "uses" => "ConsultaSeguridadController@ConsultaSeguridadVista"]);

            Route::post("consulta_seguridad_verifica_view", ["as" => "admin.consulta_seguridad_verifica_view", "uses" => "ConsultaSeguridadController@ConsultaVerificaView"]);

            Route::get("consulta_seguridad_consulta", ["as" => "admin.consulta_seguridad_consulta", "uses" => "ConsultaSeguridadController@QueryPersonView"]);

        //Buscar cc candidato
        Route::get("search_candidato_vinculado", ["as" => "search_candidato_vinculado", "uses" => "ReclutamientoController@search_cand_vinculado"]);

        Route::get("editar_pdf/{user_id}", ["as" => "admin.editar_hv", "uses" => "ReclutamientoController@editar_hv"]);
        Route::get("orden_envio/{user_id}/{valida}", ["as" => "admin.reporte_orden_envio", "uses" => "ReclutamientoController@orden_envio_pdf"]);

        Route::get("admin_datos_basicos", ["as" => "admin.editar_datos_basicos", "uses" => "HojaDeVidaController@datos_basicos_view"]);
        Route::post("actualizar_datos_basicos", ["as" => "admin.actualizar_datos_basicos", "uses" => "HojaDeVidaController@actualizar_datos_basicos"]);
        Route::get("admin_estudios", ["as" => "admin.editar_estudios", "uses" => "HojaDeVidaController@edit_estudios"]);
        Route::get("admin_experiencia", ["as" => "admin.editar_experiencias", "uses" => "HojaDeVidaController@edit_experiencias"]);
        Route::get("admin_grupo_familiar", ["as" => "admin.editar_grupo_familiar", "uses" => "HojaDeVidaController@edit_grupo_familiar"]);
        Route::get("admin_ref_personales", ["as" => "admin.editar_ref_personal", "uses" => "HojaDeVidaController@edit_ref_personales"]);
        Route::get("admin_perfilamiento", ["as" => "admin.editar_perfilamiento", "uses" => "HojaDeVidaController@edit_perfilamiento"]);
        Route::post("admin_guardar_estudios", ["as" => ""]);

        //Boton Documentos
        Route::get("documentos-hv-admin/{user_id}", ["as" => "admin.subir_documentos", "uses" => "NuevaHvAdminController@ver_documentos"]);
        Route::post("guardar-documento", ["as" => "guardar_documento_candidato", "uses" => "NuevaHvAdminController@guardar_documento_candidato"]);
        Route::post("editar-documento", ["as" => "editar_documento_candidato", "uses" => "NuevaHvAdminController@editar_documento_candidato"]);
        Route::post("actualizar-documento", ["as" => "actualizar_documento_candidato", "uses" => "NuevaHvAdminController@actualizar_documento"]);

        Route::get("gestionar_referencia/{ref_id}/{id_evs?}", ["as" => "admin.gestionar_referencia", "uses" => "ReclutamientoController@gestionar_referencia"]);
        Route::get("gestionar_referencia_estudios/{ref_id}/{id_evs?}", ["as" => "admin.gestionar_referencia_estudios", "uses" => "ReclutamientoController@gestionar_referencia_estudios"]);
        Route::get("gestionar_prueba/{ref_id}", ["as" => "admin.gestionar_prueba", "uses" => "PruebasController@gestionar_prueba"]);
        Route::get("gestionar_documentos/{ref_id}", ["as" => "admin.gestionar_documentos", "uses" => "DocumentosController@gestionar_documentos"]);
        Route::get("gestionar_documentos_medicos/{ref_id}", ["as" => "admin.gestionar_documentos_medicos", "uses" => "DocumentosController@gestionar_documentos_medicos"]);
        Route::get("gestionar_entrevista/{ref_id}", ["as" => "admin.gestionar_entrevista", "uses" => "EntrevistaController@gestionar_entrevista"]);

        Route::post("nuevo-documento/{ref_id}", ["as" => "admin.nuevo_documento", "uses" => "DocumentosController@nuevo_documento_verificado"]);
        
        Route::post("nuevo-documento-medico/{ref_id}", ["as" => "admin.nuevo_documento.medico", "uses" => "DocumentosController@nuevo_documento_medico_verificado"]);

        Route::post("guardar_documento_verificado", ["as" => "admin.guardar_documento_verificado", "uses" => "DocumentosController@guardar_documento_verificado"]);
        Route::post("guardar_examen_medico", ["as" => "admin.guardar_examen_medico", "uses" => "DocumentosController@guardar_examen_medico"]);
        //--
        Route::post("nuevo-documento-estudio-seguridad/{ref_id}", ["as" => "admin.nuevo_documento_estudio_seguridad", "uses" => "DocumentosController@nuevo_documento_estudio_seguridad_verificado"]);

        Route::post("guardar_estudio_seguridad", ["as" => "admin.guardar_estudio_seguridad", "uses" => "DocumentosController@guardar_estudio_seguridad"]);
        //--
        Route::post("nueva_entrevista", ["as" => "admin.nueva_entrevista", "uses" => "EntrevistaController@nueva_entrevista"]);
        Route::post("actualizar_entrevista", ["as" => "admin.actualizar_entrevista", "uses" => "EntrevistaController@actualizar_entrevista"]);
        Route::post("detalle_entrevista_modal", ["as" => "admin.detalle_entrevista_modal", "uses" => "EntrevistaController@detalle_entrevista_modal"]);
        Route::post("guardar_entrevista", ["as" => "admin.guardar_entrevista", "uses" => "EntrevistaController@guardar_entrevista"]);

        Route::get("lista_carga_scanner", ["as" => "admin.lista_carga_scanner", "uses" => "ReclutamientoController@lista_carga_scanner"]);

        Route::post("guardar_carga_scanner", ["as" => "admin.guardar_carga_scanner", "uses" => "ReclutamientoController@guardar_carga_scanner"]);

        Route::post("enviar_requerimiento_scanner", ["as" => "admin.enviar_requerimiento_scanner", "uses" => "ReclutamientoController@enviar_requerimiento_scanner"]);

        //Fuente Reclutamiento
        Route::get("lista_carga_scanner_fuente", ["as" => "admin.lista_carga_scanner_fr", "uses" => "ReclutamientoController@lista_carga_scanner_fr"]);

        Route::post("guardar_carga_scanner_fuente", ["as" => "admin.guardar_carga_scanner_fr", "uses" => "ReclutamientoController@guardar_carga_scanner_fr"]);
        //---------------------------------------------

        Route::get("lista_usuarios_escaneados", ["as" => "admin.lista_carga_scanner_l", "uses" => "ReclutamientoController@lista_carga_scanner_l"]);

        Route::post("nueva_entrevista_semi", ["as" => "admin.nueva_entrevista_semi", "uses" => "EntrevistaSemiController@nueva_entrevista"]);
        Route::post("guardar_entrevista_semi", ["as" => "admin.guardar_entrevista_semi", "uses" => "EntrevistaSemiController@guardar_entrevista"]);
        Route::post("detalle_entrevista_modal_semi", ["as" => "admin.detalle_entrevista_modal_semi", "uses" => "EntrevistaSemiController@detalle_entrevista_modal_semi"]);
        Route::post("actualizar_entrevista_semi", ["as" => "admin.actualizar_entrevista_semi", "uses" => "EntrevistaSemiController@actualizar_entrevista_semi"]);

		/* Entrevista virtual*/
        Route::post("nueva_entrevista_virtual", ["as" => "admin.nueva_entrevista_virtual", "uses" => "EntrevistaVirtualController@nueva_entrevista"]);
        Route::post("guardar_entrevista_virtual", ["as" => "admin.guardar_entrevista_virtual", "uses" => "EntrevistaVirtualController@guardar_entrevista"]);
        Route::post("detalle_entrevista_modal_virtual", [
        	"as" => "admin.detalle_entrevista_modal_virtual",
        	"uses" => "EntrevistaVirtualController@detalle_entrevista_modal_virtual"
        ]);

        Route::post("actualizar_entrevista_virtual", ["as" => "admin.actualizar_entrevista_virtual", "uses" => "EntrevistaVirtualController@actualizar_entrevista"]);
        Route::get('lista_entrevistas_virtuales', ["as" => "admin.entrevistas_virtuales", "uses" => "EntrevistaVirtualController@index"]);

    	Route::get("gestionar_entrevista_virtual/{req_id}", ["as" => "admin.gestionar_entrevista_virtual", "uses" => "EntrevistaVirtualController@gestionar_entrevista"]);

        Route::post("pregunta_activa_entrevista", ["as" => "admin.pregunta_activa", "uses" => "EntrevistaVirtualController@pregunta_activa"]);

        Route::post("pregunta_inactiva_entrevista", ["as" => "admin.pregunta_inactiva", "uses" => "EntrevistaVirtualController@pregunta_inactiva"]);

        Route::post("editar_pregunta_entrevista", ["as" => "admin.editar_pregunta_entre", "uses" => "EntrevistaVirtualController@editar_pregunta"]);

        Route::get("gestionar__respuestas/{req_id}/{pregu_id}", ["as" => "admin.gestionar_respuesta_entre", "uses" => "EntrevistaVirtualController@gestionar_respuesta"]);

        Route::post("crear_pregunta_entrevista", ["as" => "admin.crear_pregunta_entre", "uses" => "EntrevistaVirtualController@crear_pregunta"]);

        Route::post("video_respuesta_candidato", ["as" => "admin.video_respuesta_candidato", "uses" => "EntrevistaVirtualController@video_respuesta_candidato"]);

        Route::post("eliminar_video_respuesta_candidato", ["as" => "admin.eliminar_video_respuesta_candidato", "uses" => "EntrevistaVirtualController@eliminar_video_respuesta_candidato"]);

        //Prueba Idiomas -----------------------------------------
        Route::post("nueva_prueba_idioma", ["as" => "admin.nueva_prueba_idioma", "uses" => "PruebasIdiomasController@nueva_prueba"]);

        Route::post("guardar_prueba_idioma", ["as" => "admin.guardar_prueba_idioma", "uses" => "PruebasIdiomasController@guardar_prueba"]);

        Route::get('lista_pruebas_idiomas', ["as" => "admin.pruebas_idiomas", "uses" => "PruebasIdiomasController@index"]);

        Route::get("gestionar_prueba_idioma/{req_id}", ["as" => "admin.gestionar_prueba_idioma", "uses" => "PruebasIdiomasController@gestionar_prueba"]);

        Route::post("editar_pregunta_prueba_idioma", ["as" => "admin.editar_pregunta_prueba_idioma", "uses" => "PruebasIdiomasController@editar_pregunta"]);

        Route::get("gestionar_respuestas_idioma/{req_id}/{pregu_id}", [
        	"as" => "admin.gestionar_respuesta_idioma",
        	"uses" => "PruebasIdiomasController@gestionar_respuesta"
        ]);

        Route::post("actualizar_pregunta_prueba", ["as" => "admin.actualizar_pregunta_prueba", "uses" => "PruebasIdiomasController@actualizar_pregunta"]);

        Route::post("pregunta_activa_prueba_idioma", ["as" => "admin.pregunta_activa_prueba_idioma", "uses" => "PruebasIdiomasController@pregunta_activa"]);

        Route::post("pregunta_inactiva_prueba_idioma", ["as" => "admin.pregunta_inactiva_prueba_idioma", "uses" => "PruebasIdiomasController@pregunta_inactiva"]);

        #----
        Route::post("crear_pregunta_prueba", ["as" => "admin.crear_pregunta_prueba", "uses" => "PruebasIdiomasController@crear_pregunta"]);

        Route::post("guardar_pregunta_prueba", ["as" => "admin.guardar_pregunta_prueba", "uses" => "PruebasIdiomasController@guardar_pregunta"]);
        
        Route::post("video_respuesta_candidato_idioma", ["as" => "admin.video_respuesta_candidato_idioma", "uses" => "PruebasIdiomasController@video_respuesta_candidato"]);
        #-----

        Route::post("enviar-prueba-idioma", ["as"=>"admin.enviar_prueba_idioma", "uses"=>"ReclutamientoController@enviar_prueba_idioma"]);

        //------------ Prueba idioma estado
        Route::post("cambiar_estado_view_prueba_idioma", ["as" => "admin.cambiar_estado_view_prueba_idioma", "uses" => "ReclutamientoController@cambiar_estado_view_prueba_idioma"]);

        Route::post("guardar_cambio_estado_prueba_idioma", ["as" => "admin.guardar_cambio_estado_prueba_idioma", "uses" => "ReclutamientoController@guardar_cambio_estado_prueba_idioma"]);
        //--------

        Route::post("enviar_prueba_idioma_view_masivo", ["as" => "admin.enviar_prueba_idioma_view_masivo", "uses" => "ReclutamientoController@enviar_prueba_idioma_view_masivo"]);

        Route::post("confirmar_prueba_idioma_masivo", ["as" => "admin.confirmar_prueba_idioma_masivo", "uses" => "ReclutamientoController@confirmar_prueba_idioma_masivo"]);

        //--------------------------------------------------------
        Route::post("crear_pregunta_entrevista", ["as" => "admin.crear_pregunta_entre", "uses" => "EntrevistaVirtualController@crear_pregunta"]);

        Route::post("guardar_pregunta_entrevista", ["as" => "admin.guardar_pregunta_entre", "uses" => "EntrevistaVirtualController@guardar_pregunta"]);

        Route::post("actualizar_pregunta_entrevista", ["as" => "admin.actualizar_pregunta", "uses" => "EntrevistaVirtualController@actualizar_pregunta"]);
		/*----------------------------------------------------------------------------------*/

        Route::post("registra_entrevista_semi_entidad", ["as" => "admin.registra_entrevista_semi_entidad", "uses" => "EntrevistaSemiController@registra_proceso_entidad"]);

        Route::post("registra_entrevista_semi_entidad2", ["as" => "admin.registra_entrevista_semi_entidad2", "uses" => "EntrevistaSemiController@registra_proceso_entidad2"]);

        Route::post("gestionar_referencia_candidato", ["as" => "admin.gestionar_referencia_candidato", "uses" => "ReclutamientoController@gestionar_referencia_candidato"]);
        Route::post("gestionar_referencia_estudio", ["as" => "admin.gestionar_referencia_estudio", "uses" => "ReclutamientoController@gestionar_referencia_estudio"]);
        Route::post("gestionar_estudio_candidato", ["as" => "admin.gestionar_estudio_candidato", "uses" => "ReclutamientoController@gestionar_estudio_candidato"]);
        //ruta para editar la referenciacion
        Route::post("editar_referencia_candidato", ["as" => "admin.editar_referencia_candidato", "uses" => "ReclutamientoController@editar_referencia_candidato"]);
        
        Route::post("gestionar_referencia_personal_candidato", ["as" => "admin.gestionar_referencia_personal_candidato", "uses" => "ReclutamientoController@gestionar_referencia_personal_candidato"]);
        //ruta para editar referencia personal gestionada
        Route::post("editar_referencia_personal_candidato", ["as" => "admin.editar_referencia_personal_candidato", "uses" => "ReclutamientoController@editar_referencia_personal_candidato"]);

        Route::post("guardar_referencia_verificada", ["as" => "admin.guardar_referencia_verificada", "uses" => "ReclutamientoController@guardar_referencia_verificada"]);
        Route::post("guardar_referencia_estudio_verificada", ["as" => "admin.guardar_referencia_estudio_verificada", "uses" => "ReclutamientoController@guardar_referencia_estudio_verificada"]);
        Route::post("editar_referencia_estudio_verificada", ["as" => "admin.editar_referencia_estudio", "uses" => "ReclutamientoController@editar_referencia_estudio"]);
        
        Route::post("guardar_estudio_verificada", ["as" => "admin.guardar_estudio_verificado", "uses" => "ReclutamientoController@guardar_estudio_verificado"]);
        Route::post("guardar_referencia_personal_verificada", ["as" => "admin.guardar_referencia_personal_verificada", "uses" => "ReclutamientoController@guardar_referencia_personal_verificada"]);
        Route::post("verificar_referencia_candidato", ["as" => "admin.verificar_referencia_candidato", "uses" => "ReclutamientoController@verificar_referencia_candidato"]);
        Route::post("verificar_referencia_personal_candidato", ["as" => "admin.verificar_referencia_personal_candidato", "uses" => "ReclutamientoController@verificar_referencia_personal_candidato"]);

        Route::post("cambiar_estado_view", ["as" => "admin.cambiar_estado_view", "uses" => "ReclutamientoController@cambiar_estado_view"]);
        Route::post("guardar_apto_referenciacion", ["as" => "admin.guardar_apto_referenciacion", "uses" => "ReclutamientoController@guardar_apto_referenciacion"]);
        Route::post("guardar_cambio_estado", ["as" => "admin.guardar_cambio_estado", "uses" => "ReclutamientoController@guardar_cambio_estado"]);
        Route::post("nueva_gestion_pruebas", ["as" => "admin.nueva_gestion_pruebas", "uses" => "PruebasController@nueva_gestion_pruebas"]);
        Route::post("guardar_prueba", ["as" => "admin.guardar_prueba", "uses" => "PruebasController@guardar_prueba"]);

        Route::post("registra_proceso_entidad", ["as" => "admin.registra_proceso_entidad", "uses" => "PruebasController@registra_proceso_entidad"]);

        Route::post("registra_proceso_entidad2", ["as" => "admin.registra_proceso_entidad2", "uses" => "PruebasController@registra_proceso_entidad2"]);
        Route::post("registra_documento_entidad", ["as" => "admin.registra_documento_entidad", "uses" => "DocumentosController@registra_proceso_entidad"]);
        Route::post("agrega_doc_gestion", ["as" => "admin.agrega_doc_gestion", "uses" => "DocumentosController@agrega_doc_gestion"]);

        //END PROCESO RECLUTAMIENTO
        //CLIENTE
        Route::get("nuevo-cliente", ["as" => "admin.crear_cliente", "uses" => "ClientesController@crear_cliente"]);
        Route::post("guardar-cliente", ["as" => "admin.guardar_cliente", "uses" => "ClientesController@guardar_cliente"]);

        Route::post("actualizar_datos_cliente", ["as" => "admin.actualizar_datos_cliente", "uses" => "ClientesController@actualizar_datos_cliente"]);
        Route::post("actualizar_negocio", ["as" => "admin.actualizar_negocio", "uses" => "NegocioController@actualizar_negocio"]);
        Route::post("guardar_negocio", ["as" => "admin.guardar_negocio", "uses" => "NegocioController@guardar_negocio"]);
        Route::get("lista-clientes", ["as" => "admin.lista_clientes", "uses" => "ClientesController@lista_cliente"]);
        Route::get("negocio-clientes", ["as" => "admin.negocio_cliente", "uses" => "NegocioController@negocio_clientes"]);
        Route::get("editar-negocio/{negocio_id}", ["as" => "admin.editar_negocio", "uses" => "NegocioController@editar_negocio"]);
        Route::get("nuevo-negocio", ["as" => "admin.nuevo_negocio", "uses" => "NegocioController@nuevo_negocio"]);

        //
        Route::get("nuevo-centro-costo/{negocio_id}", ["as" => "admin.nuevo_centro_costo", "uses" => "NegocioController@nuevo_centro_costo"]);
        Route::post("guardar-centro-costo", ["as" => "admin.guardar_centro_costo", "uses" => "NegocioController@guardar_centro_costo"]);
        //Route::post("actualizar-centro-costo", ["as" => "admin.actualizar_centro_costo", "uses" => "NegocioController@actualizar_centro_costo"]);

        Route::post("cargar-negocio-select", ["as" => "admin.cargar_negocio_select", "uses" => "NegocioController@cargar_negocio_selec"]);
        // ----

        Route::get("editar-clientes/{cliente_id}", ["as" => "admin.editar_cliente", "uses" => "ClientesController@editar_cliente_admin"]);
		
		//Eliminar clientes
        Route::get("eliminar-cliente/{id}", ["as" => "admin.eliminar_cliente", "uses" => "ClientesController@eliminar_cliente"]);
        Route::get("editar-user/{user_id}", ["as" => "admin.editar_user", "uses" => "ClientesController@editar_user_cliente_admin"]);
        Route::get("usuarios-clientes", ["as" => "admin.usuarios_clientes", "uses" => "ClientesController@lista_user_cliente"]);
        Route::post("eliminar", ["as" => "admin.eliminar_ans", "uses" => "NegocioController@eliminar_ans"]);
        Route::post("actualizar_usuario_cliente", ["as" => "admin.actualizar_usuario_cliente", "uses" => "ClientesController@actualizar_usuario_cliente"]);

        //END CLIENTES
        //OFERTAS
        Route::get("ofertas", ["as" => "admin.ofertas", "uses" => "OfertaController@ofertas"]);
        Route::get("editar-oferta/{req_id}/{cargo_id}", ["as" => "admin.editar_oferta", "uses" => "OfertaController@editar_oferta"]);

        Route::post("add-img-oferta-view", ["as" => "admin.oferta.add_img", "uses" => "OfertaController@addImgView"]);

        Route::post("add-img-oferta-save", ["as" => "admin.oferta.add_img_save", "uses" => "OfertaController@addImgSave"]);
        Route::post("actualizar_oferta", ["as" => "admin.actualizar_oferta", "uses" => "OfertaController@actualizar_oferta"]);

        Route::get("usuarios-agencias", ["as" => "admin.usuarios_agencias", "uses" => "ClientesController@lista_user_agencia"]);

        Route::get("lista_agencias/{user_id}", ["as" => "admin.editar_user_agencia", "uses" => "ClientesController@editar_user_agencia"]);

        Route::post("actualizar_usuario_agencia", ["as" => "admin.actualizar_usuario_agencia", "uses" => "ClientesController@actualizar_usuario_cliente"]);
        
        //---
        Route::post("crear_pregunta_prueba_idioma", ["as" => "admin.crear_pregunta_prueba_idio", "uses" => "PreguntaController@crearPregPruebaIdioma"]);
        Route::post("guardar_pregunta_prueba_idioma", ["as" => "admin.guardar_pregunta_prueba_idioma", "uses" => "PreguntaController@guardarPregPruebaIdioma"]);
        //---

        //PREGUNTAS
        Route::post("crear_pregunta_cargo", ["as" => "admin.crear_pregunta_req", "uses" => "PreguntaController@crearPreg"]);

        Route::post("editar_pregunta_req", ["as" => "admin.editar_pregunta_req", "uses" => "PreguntaController@editarPreg"]);

        Route::post("agregar_pregunta_req", ["as" => "admin.agregar_pregunta_req", "uses" => "PreguntaController@agregarPreg"]);

        Route::post("eliminar_resp_preg", ["as" => "admin.eliminar_resp_preg", "uses" => "PreguntaController@eliminarRespuestaPreg"]);

        Route::post("actualizar_pregunta_req", ["as" => "admin.actualizar_pregunta_req", "uses" => "PreguntaController@actualizarPreg"]);

        Route::post("definir-cantidad-preguntas", ["as" => "admin.definir_cantidad_preguntas", "uses" => "PreguntaController@definir_cantidad_preguntas"]);

        Route::post("guardar-cantidad-preguntas", [
            "as" => "admin.guardar_cantidad_preguntas",
            "uses" => "OfertaController@guardar_cantidad_preguntas"
        ]);

        Route::post("guardar-porcentaje-preguntas", [
            "as" => "admin.guardar_porcentaje_preguntas",
            "uses" => "OfertaController@guardar_porcentaje_preguntas"
        ]);

        Route::post("ver_ranking", ["as" => "admin.ver_ranking", "uses" => "PreguntaController@verRanking"]);
        Route::post("ver_respuestas", ["as" => "admin.ver_respuestas", "uses" => "PreguntaController@verRespuestas"]);

        Route::post("resultados-x-candidato", ["as" => "admin.ver_resultados_x_candidato", "uses" => "PreguntaController@resultados_x_candidato"]);
        
        Route::post("guardar_pregunta", ["as" => "admin.guardar_pregunta_req", "uses" => "PreguntaController@guardar_pregunta"]);
        
		//
        Route::post("guardar_pregunta_cargo", ["as" => "admin.guardar_pregunta_cargo", "uses" => "PreguntaController@guardar_pregunta_cargo"]);

        Route::post("activar_pregunta", ["as" => "admin.activar_pregunta", "uses" => "PreguntaController@activar_pregunta"]);
        
        Route::post("inactivar_pregunta", ["as" => "admin.inactivar_pregunta", "uses" => "PreguntaController@inactivar_pregunta"]);
       
        Route::get("editar_pregunta/{id}", ["as" => "admin.editar_pregunta", "uses" => "PreguntaController@editar_pregunta"]);
        
        //END OFERTAS
        
        //SEGURIDAD
        Route::get("usuarios-sistema", ["as" => "admin.usuarios_sistema", "uses" => "UsuarioController@lista_usuario"]);
        Route::get("editar-usuario/{id_user}", ["as" => "admin.editar_user_sistema", "uses" => "UsuarioController@editar_user_sistema"]);
        Route::post("actualizar_usuario_sistema", ["as" => "admin.actualizar_usuario_sistema", "uses" => "UsuarioController@actualizar_usuario_sistema"]);
        Route::get("nuevo-usuario", ["as" => "admin.nuevo_usuario_sistema", "uses" => "UsuarioController@nuevo_usuario_sistema"]);
        Route::post("guardar_usuario_sistema", ["as" => "admin.guardar_usuario_sistema", "uses" => "UsuarioController@guardar_usuario_sistema"]);
        Route::get("nuevo_rol", ["as" => "admin.nuevo_rol", "uses" => "RolesController@nuevo_rol"]);
        Route::get("editar_rol/{rol_id}", ["as" => "admin.editar_rol", "uses" => "RolesController@editar_rol"]);
        Route::post("guardar_rol", ["as" => "admin.guardar_rol", "uses" => "RolesController@guardar_rol"]);
        Route::post("actualizar_rol", ["as" => "admin.actualizar_rol", "uses" => "RolesController@actualizar_rol"]);
        Route::get("lista_roles", ["as" => "admin.lista_roles", "uses" => "RolesController@lista_roles"]);
        Route::post("detalle_rol", ["as" => "admin.detalle_rol", "uses" => "RolesController@detalle_rol"]);

        Route::get("cambio-clave-hv", ["as" => "admin.usuarios.modificar_clave", "uses" => "UsuarioController@modificar_clave_candidato"]);
        Route::post("buscar-datos-candidato", ["as" => "admin.usuarios.buscar_datos", "uses" => "UsuarioController@buscar_datos_usuario"]);
        Route::post("guardar-clave-candidato", ["as" => "admin.usuarios.guardar_nueva_clave", "uses" => "UsuarioController@guardar_nueva_clave_usuario"]);
        //END SEGURIDAD
        //ASIGNACION SALARIAL
        // RUTAS TABLA Aspiracion Salarial
        Route::get("lista_aspiracion_salarial", ["as" => "admin.aspiracion_salarial.index", "uses" => "AspiracionSalarialController@index"]);
        Route::get("editar_aspiracion_salarial/{id}", ["as" => "admin.aspiracion_salarial.editar", "uses" => "AspiracionSalarialController@editar"]);
        Route::get("nuevo_aspiracion_salarial", ["as" => "admin.aspiracion_salarial.nuevo", "uses" => "AspiracionSalarialController@nuevo"]);
        Route::post("actualizar_aspiracion_salarial", ["as" => "admin.aspiracion_salarial.actualizar", "uses" => "AspiracionSalarialController@actualizar"]);
        Route::post("guardar_aspiracion_salarial", ["as" => "admin.aspiracion_salarial.guardar", "uses" => "AspiracionSalarialController@guardar"]);
        // RUTAS TABLA Cargos Especificos
        Route::get("lista-cargos-especificos", ["as" => "admin.cargos_especificos.index", "uses" => "CargosEspecificosController@index"]);
        Route::post("ajax-lista-cargos", ["as" => "admin.cargos_especificos.getCargosAjax", "uses" => "CargosEspecificosController@getCargosAjax"]);
        Route::post("editar_cargos_especificos", ["as" => "admin.cargos_especificos.editar", "uses" => "CargosEspecificosController@editar"]);
        Route::get("nuevo-cargo-especifico", ["as" => "admin.cargos_especificos.nuevo", "uses" => "CargosEspecificosController@nuevo"]);
        Route::post("actualizar_cargos_especificos", ["as" => "admin.cargos_especificos.actualizar", "uses" => "CargosEspecificosController@actualizar"]);
        Route::post("guardar_cargos_especificos", ["as" => "admin.cargos_especificos.guardar", "uses" => "CargosEspecificosController@guardar"]);

        Route::post("nuevo_cargo_especifico_modal", ["as" => "admin.crear_cargo_cliente", "uses" => "CargosEspecificosController@crear_cargo_cliente"]);

        // RUTAS TABLA Cargos Genericos
        Route::get("lista-cargos-genericos", ["as" => "admin.cargos_genericos.index", "uses" => "CargosGenericosController@index"]);
        //Route::get("editar_cargos_genericos/{id}", ["as" => "admin.cargos_genericos.editar", "uses" => "CargosGenericosController@editar"]);
        Route::post("editar_cargos_genericos", ["as" => "admin.cargos_genericos.editar", "uses" => "CargosGenericosController@editar"]);
        Route::get("nuevo_cargos_genericos", ["as" => "admin.cargos_genericos.nuevo", "uses" => "CargosGenericosController@nuevo"]);
        Route::post("actualizar-cargos-genericos", ["as" => "admin.cargos_genericos.actualizar", "uses" => "CargosGenericosController@actualizar"]);
        Route::post("guardar_cargos_genericos", ["as" => "admin.cargos_genericos.guardar", "uses" => "CargosGenericosController@guardar"]);
        // RUTAS TABLA Categorias Licencias
        Route::get("lista_categorias_licencias", ["as" => "admin.categorias_licencias.index", "uses" => "CategoriasLicenciasController@index"]);
        Route::get("editar_categorias_licencias/{id}", ["as" => "admin.categorias_licencias.editar", "uses" => "CategoriasLicenciasController@editar"]);
        Route::get("nuevo_categorias_licencias", ["as" => "admin.categorias_licencias.nuevo", "uses" => "CategoriasLicenciasController@nuevo"]);
        Route::post("actualizar_categorias_licencias", ["as" => "admin.categorias_licencias.actualizar", "uses" => "CategoriasLicenciasController@actualizar"]);
        Route::post("guardar_categorias_licencias", ["as" => "admin.categorias_licencias.guardar", "uses" => "CategoriasLicenciasController@guardar"]);
        // RUTAS TABLA Ciudad
        Route::get("lista_ciudad", ["as" => "admin.ciudad.index", "uses" => "CiudadController@index"]);
        Route::get("editar_ciudad/{id}", ["as" => "admin.ciudad.editar", "uses" => "CiudadController@editar"]);
        Route::get("nuevo_ciudad", ["as" => "admin.ciudad.nuevo", "uses" => "CiudadController@nuevo"]);
        Route::post("actualizar_ciudad", ["as" => "admin.ciudad.actualizar", "uses" => "CiudadController@actualizar"]);
        Route::post("guardar_ciudad", ["as" => "admin.ciudad.guardar", "uses" => "CiudadController@guardar"]);
        // RUTAS TABLA Clases Libretas
        Route::get("lista_clases_libretas", ["as" => "admin.clases_libretas.index", "uses" => "ClasesLibretasController@index"]);
        Route::get("editar_clases_libretas/{id}", ["as" => "admin.clases_libretas.editar", "uses" => "ClasesLibretasController@editar"]);
        Route::get("nuevo_clases_libretas", ["as" => "admin.clases_libretas.nuevo", "uses" => "ClasesLibretasController@nuevo"]);
        Route::post("actualizar_clases_libretas", ["as" => "admin.clases_libretas.actualizar", "uses" => "ClasesLibretasController@actualizar"]);
        Route::post("guardar_clases_libretas", ["as" => "admin.clases_libretas.guardar", "uses" => "ClasesLibretasController@guardar"]);
        // RUTAS TABLA Competencias Entrevistas
        Route::get("lista_competencias_entrevistas", ["as" => "admin.competencias_entrevistas.index", "uses" => "CompetenciasEntrevistasController@index"]);
        Route::get("editar_competencias_entrevistas/{id}", ["as" => "admin.competencias_entrevistas.editar", "uses" => "CompetenciasEntrevistasController@editar"]);
        Route::get("nuevo_competencias_entrevistas", ["as" => "admin.competencias_entrevistas.nuevo", "uses" => "CompetenciasEntrevistasController@nuevo"]);
        Route::post("actualizar_competencias_entrevistas", ["as" => "admin.competencias_entrevistas.actualizar", "uses" => "CompetenciasEntrevistasController@actualizar"]);
        Route::post("guardar_competencias_entrevistas", ["as" => "admin.competencias_entrevistas.guardar", "uses" => "CompetenciasEntrevistasController@guardar"]);
        // RUTAS TABLA Departamentos
        Route::get("lista_departamentos", ["as" => "admin.departamentos.index", "uses" => "DepartamentosController@index"]);
        Route::get("editar_departamentos/{id}", ["as" => "admin.departamentos.editar", "uses" => "DepartamentosController@editar"]);
        Route::get("nuevo_departamentos", ["as" => "admin.departamentos.nuevo", "uses" => "DepartamentosController@nuevo"]);
        Route::post("actualizar_departamentos", ["as" => "admin.departamentos.actualizar", "uses" => "DepartamentosController@actualizar"]);
        Route::post("guardar_departamentos", ["as" => "admin.departamentos.guardar", "uses" => "DepartamentosController@guardar"]);
        // RUTAS TABLA Entidades Afp
        Route::get("lista_entidades_afp", ["as" => "admin.entidades_afp.index", "uses" => "EntidadesAfpController@index"]);
        Route::get("editar_entidades_afp/{id}", ["as" => "admin.entidades_afp.editar", "uses" => "EntidadesAfpController@editar"]);
        Route::get("nuevo_entidades_afp", ["as" => "admin.entidades_afp.nuevo", "uses" => "EntidadesAfpController@nuevo"]);
        Route::post("actualizar_entidades_afp", ["as" => "admin.entidades_afp.actualizar", "uses" => "EntidadesAfpController@actualizar"]);
        Route::post("guardar_entidades_afp", ["as" => "admin.entidades_afp.guardar", "uses" => "EntidadesAfpController@guardar"]);
        // RUTAS TABLA Entidades Eps
        Route::get("lista_entidades_eps", ["as" => "admin.entidades_eps.index", "uses" => "EntidadesEpsController@index"]);
        Route::get("editar_entidades_eps/{id}", ["as" => "admin.entidades_eps.editar", "uses" => "EntidadesEpsController@editar"]);
        Route::get("nuevo_entidades_eps", ["as" => "admin.entidades_eps.nuevo", "uses" => "EntidadesEpsController@nuevo"]);
        Route::post("actualizar_entidades_eps", ["as" => "admin.entidades_eps.actualizar", "uses" => "EntidadesEpsController@actualizar"]);
        Route::post("guardar_entidades_eps", ["as" => "admin.entidades_eps.guardar", "uses" => "EntidadesEpsController@guardar"]);
        // RUTAS TABLA Escolaridades
        Route::get("lista_escolaridades", ["as" => "admin.escolaridades.index", "uses" => "EscolaridadesController@index"]);
        Route::get("editar_escolaridades/{id}", ["as" => "admin.escolaridades.editar", "uses" => "EscolaridadesController@editar"]);
        Route::get("nuevo_escolaridades", ["as" => "admin.escolaridades.nuevo", "uses" => "EscolaridadesController@nuevo"]);
        Route::post("actualizar_escolaridades", ["as" => "admin.escolaridades.actualizar", "uses" => "EscolaridadesController@actualizar"]);
        Route::post("guardar_escolaridades", ["as" => "admin.escolaridades.guardar", "uses" => "EscolaridadesController@guardar"]);
        // RUTAS TABLA Estados
        Route::get("lista_estados", ["as" => "admin.estados.index", "uses" => "EstadosController@index"]);
        Route::get("editar_estados/{id}", ["as" => "admin.estados.editar", "uses" => "EstadosController@editar"]);
        Route::get("nuevo_estados", ["as" => "admin.estados.nuevo", "uses" => "EstadosController@nuevo"]);
        Route::post("actualizar_estados", ["as" => "admin.estados.actualizar", "uses" => "EstadosController@actualizar"]);
        Route::post("guardar_estados", ["as" => "admin.estados.guardar", "uses" => "EstadosController@guardar"]);
        // RUTAS TABLA Estados Civiles
        Route::get("lista_estados_civiles", ["as" => "admin.estados_civiles.index", "uses" => "EstadosCivilesController@index"]);
        Route::get("editar_estados_civiles/{id}", ["as" => "admin.estados_civiles.editar", "uses" => "EstadosCivilesController@editar"]);
        Route::get("nuevo_estados_civiles", ["as" => "admin.estados_civiles.nuevo", "uses" => "EstadosCivilesController@nuevo"]);
        Route::post("actualizar_estados_civiles", ["as" => "admin.estados_civiles.actualizar", "uses" => "EstadosCivilesController@actualizar"]);
        Route::post("guardar_estados_civiles", ["as" => "admin.estados_civiles.guardar", "uses" => "EstadosCivilesController@guardar"]);
        // RUTAS TABLA Fuentes Publicidad
        Route::get("lista_fuentes_publicidad", ["as" => "admin.fuentes_publicidad.index", "uses" => "FuentesPublicidadController@index"]);
        Route::get("editar_fuentes_publicidad/{id}", ["as" => "admin.fuentes_publicidad.editar", "uses" => "FuentesPublicidadController@editar"]);
        Route::get("nuevo_fuentes_publicidad", ["as" => "admin.fuentes_publicidad.nuevo", "uses" => "FuentesPublicidadController@nuevo"]);
        Route::post("actualizar_fuentes_publicidad", ["as" => "admin.fuentes_publicidad.actualizar", "uses" => "FuentesPublicidadController@actualizar"]);
        Route::post("guardar_fuentes_publicidad", ["as" => "admin.fuentes_publicidad.guardar", "uses" => "FuentesPublicidadController@guardar"]);
        // RUTAS TABLA Generos
        Route::get("lista_generos", ["as" => "admin.generos.index", "uses" => "GenerosController@index"]);
        Route::get("editar_generos/{id}", ["as" => "admin.generos.editar", "uses" => "GenerosController@editar"]);
        Route::get("nuevo_generos", ["as" => "admin.generos.nuevo", "uses" => "GenerosController@nuevo"]);
        Route::post("actualizar_generos", ["as" => "admin.generos.actualizar", "uses" => "GenerosController@actualizar"]);
        Route::post("guardar_generos", ["as" => "admin.generos.guardar", "uses" => "GenerosController@guardar"]);
        // RUTAS TABLA Motivo Requerimiento
        Route::get("lista_motivo_requerimiento", ["as" => "admin.motivo_requerimiento.index", "uses" => "MotivoRequerimientoController@index"]);
        Route::get("editar_motivo_requerimiento/{id}", ["as" => "admin.motivo_requerimiento.editar", "uses" => "MotivoRequerimientoController@editar"]);
        Route::get("nuevo_motivo_requerimiento", ["as" => "admin.motivo_requerimiento.nuevo", "uses" => "MotivoRequerimientoController@nuevo"]);
        Route::post("actualizar_motivo_requerimiento", ["as" => "admin.motivo_requerimiento.actualizar", "uses" => "MotivoRequerimientoController@actualizar"]);
        Route::post("guardar_motivo_requerimiento", ["as" => "admin.motivo_requerimiento.guardar", "uses" => "MotivoRequerimientoController@guardar"]);
        // RUTAS TABLA Motivos Rechazos
        Route::get("lista_motivos_rechazos", ["as" => "admin.motivos_rechazos.index", "uses" => "MotivosRechazosController@index"]);
        Route::get("editar_motivos_rechazos/{id}", ["as" => "admin.motivos_rechazos.editar", "uses" => "MotivosRechazosController@editar"]);
        Route::get("nuevo_motivos_rechazos", ["as" => "admin.motivos_rechazos.nuevo", "uses" => "MotivosRechazosController@nuevo"]);
        Route::post("actualizar_motivos_rechazos", ["as" => "admin.motivos_rechazos.actualizar", "uses" => "MotivosRechazosController@actualizar"]);
        Route::post("guardar_motivos_rechazos", ["as" => "admin.motivos_rechazos.guardar", "uses" => "MotivosRechazosController@guardar"]);
        // RUTAS TABLA Motivos Retiros
        Route::get("lista_motivos_retiros", ["as" => "admin.motivos_retiros.index", "uses" => "MotivosRetirosController@index"]);
        Route::get("editar_motivos_retiros/{id}", ["as" => "admin.motivos_retiros.editar", "uses" => "MotivosRetirosController@editar"]);
        Route::get("nuevo_motivos_retiros", ["as" => "admin.motivos_retiros.nuevo", "uses" => "MotivosRetirosController@nuevo"]);
        Route::post("actualizar_motivos_retiros", ["as" => "admin.motivos_retiros.actualizar", "uses" => "MotivosRetirosController@actualizar"]);
        Route::post("guardar_motivos_retiros", ["as" => "admin.motivos_retiros.guardar", "uses" => "MotivosRetirosController@guardar"]);
        // RUTAS TABLA Niveles Estudios
        Route::get("lista_niveles_estudios", ["as" => "admin.niveles_estudios.index", "uses" => "NivelesEstudiosController@index"]);
        Route::get("editar_niveles_estudios/{id}", ["as" => "admin.niveles_estudios.editar", "uses" => "NivelesEstudiosController@editar"]);
        Route::get("nuevo_niveles_estudios", ["as" => "admin.niveles_estudios.nuevo", "uses" => "NivelesEstudiosController@nuevo"]);
        Route::post("actualizar_niveles_estudios", ["as" => "admin.niveles_estudios.actualizar", "uses" => "NivelesEstudiosController@actualizar"]);
        Route::post("guardar_niveles_estudios", ["as" => "admin.niveles_estudios.guardar", "uses" => "NivelesEstudiosController@guardar"]);
        // RUTAS TABLA Paises
        Route::get("lista_paises", ["as" => "admin.paises.index", "uses" => "PaisesController@index"]);
        Route::get("editar_paises/{id}", ["as" => "admin.paises.editar", "uses" => "PaisesController@editar"]);
        Route::get("nuevo_paises", ["as" => "admin.paises.nuevo", "uses" => "PaisesController@nuevo"]);
        Route::post("actualizar_paises", ["as" => "admin.paises.actualizar", "uses" => "PaisesController@actualizar"]);
        Route::post("guardar_paises", ["as" => "admin.paises.guardar", "uses" => "PaisesController@guardar"]);
        // RUTAS TABLA Parentescos
        Route::get("lista_parentescos", ["as" => "admin.parentescos.index", "uses" => "ParentescosController@index"]);
        Route::get("editar_parentescos/{id}", ["as" => "admin.parentescos.editar", "uses" => "ParentescosController@editar"]);
        Route::get("nuevo_parentescos", ["as" => "admin.parentescos.nuevo", "uses" => "ParentescosController@nuevo"]);
        Route::post("actualizar_parentescos", ["as" => "admin.parentescos.actualizar", "uses" => "ParentescosController@actualizar"]);
        Route::post("guardar_parentescos", ["as" => "admin.parentescos.guardar", "uses" => "ParentescosController@guardar"]);
        // RUTAS TABLA Profesiones
        Route::get("lista_profesiones", ["as" => "admin.profesiones.index", "uses" => "ProfesionesController@index"]);
        Route::get("editar_profesiones/{id}", ["as" => "admin.profesiones.editar", "uses" => "ProfesionesController@editar"]);
        Route::get("nuevo_profesiones", ["as" => "admin.profesiones.nuevo", "uses" => "ProfesionesController@nuevo"]);
        Route::post("actualizar_profesiones", ["as" => "admin.profesiones.actualizar", "uses" => "ProfesionesController@actualizar"]);
        Route::post("guardar_profesiones", ["as" => "admin.profesiones.guardar", "uses" => "ProfesionesController@guardar"]);
        // RUTAS TABLA Tipo Fuente
        Route::get("lista_tipo_fuente", ["as" => "admin.tipo_fuente.index", "uses" => "TipoFuenteController@index"]);
        Route::get("editar_tipo_fuente/{id}", ["as" => "admin.tipo_fuente.editar", "uses" => "TipoFuenteController@editar"]);
        Route::get("nuevo_tipo_fuente", ["as" => "admin.tipo_fuente.nuevo", "uses" => "TipoFuenteController@nuevo"]);
        Route::post("actualizar_tipo_fuente", ["as" => "admin.tipo_fuente.actualizar", "uses" => "TipoFuenteController@actualizar"]);
        Route::post("guardar_tipo_fuente", ["as" => "admin.tipo_fuente.guardar", "uses" => "TipoFuenteController@guardar"]);
        // RUTAS TABLA Tipo Identificacion
        Route::get("lista_tipo_identificacion", ["as" => "admin.tipo_identificacion.index", "uses" => "TipoIdentificacionController@index"]);
        Route::get("editar_tipo_identificacion/{id}", ["as" => "admin.tipo_identificacion.editar", "uses" => "TipoIdentificacionController@editar"]);
        Route::get("nuevo_tipo_identificacion", ["as" => "admin.tipo_identificacion.nuevo", "uses" => "TipoIdentificacionController@nuevo"]);
        Route::post("actualizar_tipo_identificacion", ["as" => "admin.tipo_identificacion.actualizar", "uses" => "TipoIdentificacionController@actualizar"]);
        Route::post("guardar_tipo_identificacion", ["as" => "admin.tipo_identificacion.guardar", "uses" => "TipoIdentificacionController@guardar"]);
        // RUTAS TABLA Tipo Proceso
        Route::get("lista_tipo_proceso", ["as" => "admin.tipo_proceso.index", "uses" => "TipoProcesoController@index"]);
        Route::get("editar_tipo_proceso/{id}", ["as" => "admin.tipo_proceso.editar", "uses" => "TipoProcesoController@editar"]);
        Route::get("nuevo_tipo_proceso", ["as" => "admin.tipo_proceso.nuevo", "uses" => "TipoProcesoController@nuevo"]);
        Route::post("actualizar_tipo_proceso", ["as" => "admin.tipo_proceso.actualizar", "uses" => "TipoProcesoController@actualizar"]);
        Route::post("guardar_tipo_proceso", ["as" => "admin.tipo_proceso.guardar", "uses" => "TipoProcesoController@guardar"]);
        // RUTAS TABLA Tipo Relaciones
        Route::get("lista_tipo_relaciones", ["as" => "admin.tipo_relaciones.index", "uses" => "TipoRelacionesController@index"]);
        Route::get("editar_tipo_relaciones/{id}", ["as" => "admin.tipo_relaciones.editar", "uses" => "TipoRelacionesController@editar"]);
        Route::get("nuevo_tipo_relaciones", ["as" => "admin.tipo_relaciones.nuevo", "uses" => "TipoRelacionesController@nuevo"]);
        Route::post("actualizar_tipo_relaciones", ["as" => "admin.tipo_relaciones.actualizar", "uses" => "TipoRelacionesController@actualizar"]);
        Route::post("guardar_tipo_relaciones", ["as" => "admin.tipo_relaciones.guardar", "uses" => "TipoRelacionesController@guardar"]);
        // RUTAS TABLA Tipos Cargos
        Route::get("lista_tipos_cargos", ["as" => "admin.tipos_cargos.index", "uses" => "TiposCargosController@index"]);
        Route::get("editar_tipos_cargos/{id}", ["as" => "admin.tipos_cargos.editar", "uses" => "TiposCargosController@editar"]);
        Route::get("nuevo_tipos_cargos", ["as" => "admin.tipos_cargos.nuevo", "uses" => "TiposCargosController@nuevo"]);
        Route::post("actualizar_tipos_cargos", ["as" => "admin.tipos_cargos.actualizar", "uses" => "TiposCargosController@actualizar"]);
        Route::post("guardar_tipos_cargos", ["as" => "admin.tipos_cargos.guardar", "uses" => "TiposCargosController@guardar"]);
        // RUTAS TABLA Tipos Contratos
        Route::get("lista_tipos_contratos", ["as" => "admin.tipos_contratos.index", "uses" => "TiposContratosController@index"]);
        Route::get("editar_tipos_contratos/{id}", ["as" => "admin.tipos_contratos.editar", "uses" => "TiposContratosController@editar"]);
        Route::get("nuevo_tipos_contratos", ["as" => "admin.tipos_contratos.nuevo", "uses" => "TiposContratosController@nuevo"]);
        Route::post("actualizar_tipos_contratos", ["as" => "admin.tipos_contratos.actualizar", "uses" => "TiposContratosController@actualizar"]);
        Route::post("guardar_tipos_contratos", ["as" => "admin.tipos_contratos.guardar", "uses" => "TiposContratosController@guardar"]);
        // RUTAS TABLA Tipos Documentos
        Route::get("lista-tipos-documentos", ["as" => "admin.tipos_documentos.index", "uses" => "TiposDocumentosController@index"]);
        Route::get("editar-tipos-documentos/{id}", ["as" => "admin.tipos_documentos.editar", "uses" => "TiposDocumentosController@editar"]);
        Route::get("nuevo-tipos-documentos", ["as" => "admin.tipos_documentos.nuevo", "uses" => "TiposDocumentosController@nuevo"]);
        Route::post("actualizar_tipos_documentos", ["as" => "admin.tipos_documentos.actualizar", "uses" => "TiposDocumentosController@actualizar"]);
        Route::post("guardar_tipos_documentos", ["as" => "admin.tipos_documentos.guardar", "uses" => "TiposDocumentosController@guardar"]);
        Route::get("asociar-cargos-tipos-documentos/{tipo_documento_id}", ["as" => "admin.tipos_documentos.asociar_cargos", "uses" => "TiposDocumentosController@asociar_cargos_tipos_documentos_view"]);
        Route::post("asociar-cargos-tipos-documentos-guardar", ["as" => "admin.tipos_documentos.asociar_cargos_guardar", "uses" => "TiposDocumentosController@asociar_cargos_guardar"]);
        Route::post("eliminar-cargos-tipos-documentos", ["as" => "admin.tipos_documentos.eliminar", "uses" => "TiposDocumentosController@eliminar_cargo_documento"]);
        // RUTAS TABLA Tipos Experiencias
        Route::get("lista_tipos_experiencias", ["as" => "admin.tipos_experiencias.index", "uses" => "TiposExperienciasController@index"]);
        Route::get("editar_tipos_experiencias/{id}", ["as" => "admin.tipos_experiencias.editar", "uses" => "TiposExperienciasController@editar"]);
        Route::get("nuevo_tipos_experiencias", ["as" => "admin.tipos_experiencias.nuevo", "uses" => "TiposExperienciasController@nuevo"]);
        Route::post("actualizar_tipos_experiencias", ["as" => "admin.tipos_experiencias.actualizar", "uses" => "TiposExperienciasController@actualizar"]);
        Route::post("guardar_tipos_experiencias", ["as" => "admin.tipos_experiencias.guardar", "uses" => "TiposExperienciasController@guardar"]);
        // RUTAS TABLA Tipos Identificacion
        Route::get("lista_tipos_identificacion", ["as" => "admin.tipos_identificacion.index", "uses" => "TiposIdentificacionController@index"]);
        Route::get("editar_tipos_identificacion/{id}", ["as" => "admin.tipos_identificacion.editar", "uses" => "TiposIdentificacionController@editar"]);
        Route::get("nuevo_tipos_identificacion", ["as" => "admin.tipos_identificacion.nuevo", "uses" => "TiposIdentificacionController@nuevo"]);
        Route::post("actualizar_tipos_identificacion", ["as" => "admin.tipos_identificacion.actualizar", "uses" => "TiposIdentificacionController@actualizar"]);
        Route::post("guardar_tipos_identificacion", ["as" => "admin.tipos_identificacion.guardar", "uses" => "TiposIdentificacionController@guardar"]);
        // RUTAS TABLA Tipos Jornadas
        Route::get("lista_tipos_jornadas", ["as" => "admin.tipos_jornadas.index", "uses" => "TiposJornadasController@index"]);
        Route::get("editar_tipos_jornadas/{id}", ["as" => "admin.tipos_jornadas.editar", "uses" => "TiposJornadasController@editar"]);
        Route::get("nuevo_tipos_jornadas", ["as" => "admin.tipos_jornadas.nuevo", "uses" => "TiposJornadasController@nuevo"]);
        Route::post("actualipostzar_tipos_jornadas", ["as" => "admin.tipos_jornadas.actualizar", "uses" => "TiposJornadasController@actualizar"]);
        Route::post("guardar_tipos_jornadas", ["as" => "admin.tipos_jornadas.guardar", "uses" => "TiposJornadasController@guardar"]);
        // RUTAS TABLA Tipos Notificaciones
        Route::get("lista_tipos_notificaciones", ["as" => "admin.tipos_notificaciones.index", "uses" => "TiposNotificacionesController@index"]);
        Route::get("editar_tipos_notificaciones/{id}", ["as" => "admin.tipos_notificaciones.editar", "uses" => "TiposNotificacionesController@editar"]);
        Route::get("nuevo_tipos_notificaciones", ["as" => "admin.tipos_notificaciones.nuevo", "uses" => "TiposNotificacionesController@nuevo"]);
        Route::post("actualizar_tipos_notificaciones", ["as" => "admin.tipos_notificaciones.actualizar", "uses" => "TiposNotificacionesController@actualizar"]);
        Route::post("guardar_tipos_notificaciones", ["as" => "admin.tipos_notificaciones.guardar", "uses" => "TiposNotificacionesController@guardar"]);
        // RUTAS TABLA Tipos Pruebas
        Route::get("lista_tipos_pruebas", ["as" => "admin.tipos_pruebas.index", "uses" => "TiposPruebasController@index"]);
        Route::get("editar_tipos_pruebas/{id}", ["as" => "admin.tipos_pruebas.editar", "uses" => "TiposPruebasController@editar"]);
        Route::get("nuevo_tipos_pruebas", ["as" => "admin.tipos_pruebas.nuevo", "uses" => "TiposPruebasController@nuevo"]);
        Route::post("actualizar_tipos_pruebas", ["as" => "admin.tipos_pruebas.actualizar", "uses" => "TiposPruebasController@actualizar"]);
        Route::post("guardar_tipos_pruebas", ["as" => "admin.tipos_pruebas.guardar", "uses" => "TiposPruebasController@guardar"]);
        // RUTAS TABLA Tipos Vehiculos
        Route::get("lista_tipos_vehiculos", ["as" => "admin.tipos_vehiculos.index", "uses" => "TiposVehiculosController@index"]);
        Route::get("editar_tipos_vehiculos/{id}", ["as" => "admin.tipos_vehiculos.editar", "uses" => "TiposVehiculosController@editar"]);
        Route::get("nuevo_tipos_vehiculos", ["as" => "admin.tipos_vehiculos.nuevo", "uses" => "TiposVehiculosController@nuevo"]);
        Route::post("actualizar_tipos_vehiculos", ["as" => "admin.tipos_vehiculos.actualizar", "uses" => "TiposVehiculosController@actualizar"]);
        Route::post("guardar_tipos_vehiculos", ["as" => "admin.tipos_vehiculos.guardar", "uses" => "TiposVehiculosController@guardar"]);

        //Creditos funcionalidades
        Route::get("lista_creditos_funcionalidades", ["as" => "admin.lista_creditos_funcionalidades", "uses" => "CreditosFuncionalidadesController@index"]);

        Route::get("ver_creditos_funcionalidades/{tipo_id}/{control_id}/{limite}", [
        	"as" => "admin.ver_creditos_funcionalidades",
        	"uses" => "CreditosFuncionalidadesController@show"
        ]);

        Route::get("prueba-tendencia", ["as" => "admin.pruebas_tendencia", "uses" => "PruebasController@lista_prueba_tendencia"]);
        Route::post("realizar-prueba-tendencia", ["as" => "admin.realizar_prueba", "uses" => "PruebasController@modal_prueba"]);
        Route::post("guardar_prueba-tendencia", ["as" => "admin.guardar_prueba_tendencia", "uses" => "PruebasController@guardar_prueba_tendencia"]);

        Route::get("hojas-vida", ["as" => "admin.lista_hv_admin", "uses" => "CvController@lista_hv_admin"]);
        Route::post("trazabilidad_candidato", ["as" => "admin.trazabilidad_candidato", "uses" => "CvController@modal_trazabilidad"]);
        
        //Cambiar estado en Lista_hv_admin
        Route::post("cambiar_estado", ["as" => "admin.cambiar_estado", "uses" => "CvController@cambiar_estado"]);
        Route::post("guardar_estado", ["as" => "admin.guardar_estado", "uses" => "CvController@guardar_estado"]);
        Route::post("view_estado_candidato", ["as" => "admin.view_estado_candidato", "uses" => "CvController@view_estado_candidato"]);
        Route::post("activar_candidato", ["as" => "admin.activar_candidato", "uses" => "CvController@activar_candidato"]);

        Route::get("lista_requerimientos", ["as" => "admin.lista_requerimientos", "uses" => "RequerimientoController@lista_requerimientos"]);

         //Ajax, cuando se sleccione l area de trabajo traer subarea relacionado
        Route::post("admin-cargo-relaciondo-cliente",["as" => "admin.selectCargoCliente", "uses" => "ClientesController@cargo_cliente"]);

        Route::get("editar_requerimiento/{req_id}", ["as" => "admin.editar_requerimiento", "uses" => "RequerimientoController@editar_requerimiento"]);
        Route::post("guardar_requerimiento", ["as" => "admin.actualizar_requerimiento", "uses" => "RequerimientoController@actualizar_requerimiento"]);

        //REPORTES
        Route::get("reportes-admin", ['as' => 'admin.reportes_indicadores', 'uses' => 'ReportesController@reporte']);
        Route::get("reporte-excel-indicadores", ['as' => 'admin.reportes.reporte-excel-indicadores', 'uses' => "ReportesController@reporteExcelIndicadores"]);

        //RECEPCIÓN
        Route::get("recepcion", ["as" => "admin.recepcion", "uses" => "RecepcionController@index"]);
        Route::post("iniciar-proceso-recepcion", ["as" => "admin.iniciar_proceso_recepcion", "uses" => "RecepcionController@iniciar_proceso_recepcion"]);
        Route::post("salida-proceso-recepcion", ["as" => "admin.salida_proceso_recepcion", "uses" => "RecepcionController@salida_proceso_recepcion"]);
        Route::post("recepcion-registro-control", ["as" => "admin.guardar_ingreso", "uses" => "RecepcionController@registro_ingreso"]);
        Route::get("perfilamiento", ["as" => "admin.perfilamiento", "uses" => "PerfilamientoController@perfilar_candidato"]);
        Route::post("guardar_perfilamiento", ["as" => "admin.guardar_perfilamiento", "uses" => "PerfilamientoController@guardar_perfilamiento_reclutamiento"]);
        Route::get("proceso_reclutadores", ["as" => "admin.proceso_reclutadores", "uses" => "ReclutamientoController@reclutadores"]);
        Route::post("cargar_requerimientos_perfil", ["as" => "admin.cargar_requerimientos_perfil", "uses" => "PerfilamientoController@cargar_requerimientos_perfil"]);
        Route::post("guardar_proceso_reclutadores", ["as" => "admin.guardar_proceso_reclutadores", "uses" => "ReclutamientoController@guardar_proceso_reclutadores"]);
        Route::post("cargar_bd", ["as" => "admin.cargar_bd", "uses" => "ReclutamientoController@cargar_bd"]);
        Route::post("reclutamiento_elimina_cargo", ["as" => "admin.reclutamiento_elimina_cargo", "uses" => "ReclutamientoController@reclutamiento_elimina_cargo"]);
        Route::post("reclutamiento_elimina_req", ["as" => "admin.reclutamiento_elimina_req", "uses" => "ReclutamientoController@reclutamiento_elimina_req"]);
        Route::get('ficha-pdf/{id?}', ['as' => 'admin.ficha_pdf', 'uses' => 'FichasController@exportarFichaPdf']);

        // Ficha tecnica
        Route::get('ficha-tecnica', [
            'as'   => 'admin.fichas_tecnicas',
            'uses' => 'FichasController@index',
        ]);
        Route::get('ficha-nueva', [
            'as'   => 'admin.nueva_ficha',
            'uses' => 'FichasController@nuevaFicha',
        ]);
        Route::get('ficha-editar/{id}', [
            'as'   => 'admin.editar_ficha',
            'uses' => 'FichasController@editarFicha',
        ]);
        Route::post('guardar-ficha-editar', [
            'as'   => 'admin.guardar_ficha_editar',
            'uses' => 'FichasController@guardarFichaEditar',
        ]);
        Route::get('fichas-listar', [
            'as'   => 'admin.listar_fichas',
            'uses' => 'FichasController@index',
        ]);
        Route::get('exportar-ficha-pdf/{id}', [
            'as'   => 'admin.ficha_export_pdf',
            'uses' => 'FichasController@exportarFichaPdfp',
        ]);
        Route::post('guardar-ficha', [
            'as'   => 'admin.guardar_ficha',
            'uses' => 'FichasController@guardarFicha',
        ]);
        Route::get('traer-info-cliente', [
            'as'   => 'admin.fichas_tecnicas.traer_info_cliente',
            'uses' => 'FichasController@getInfoCliente',
        ]);
        Route::get('traer-info-cargo-generico', [
            'as'   => 'admin.fichas_tecnicas.traer_cargo_generico',
            'uses' => 'FichasController@getInfoCargoGenerico',
        ]);

        /**
         * Anexo de Facturación
         */
        Route::get("anexo_facturacion", ["as" => "admin.anexo_facturacion", "uses" => "FacturacionController@index"]);
        Route::get("reporte-anexo", ["as" => "admin.anexo_facturacion_excel", "uses" => "FacturacionController@reporteAnexo"]);
        Route::get("facturacion-anexo", ["as" => "admin.facturacion_anexo", "uses" => "FacturacionController@facturacionAnexo"]);
        Route::post("facturar_requerimiento", ["as" => "admin.facturar_requerimiento", "uses" => "FacturacionController@facturaRequerimiento"]);
        Route::post("Guardar-facturacion-requerimiento", ["as" => "admin.ajax_guardar_facturacion_requerimiento", "uses" => "FacturacionController@guardarFacturacionRequerimiento"]);
        Route::post("Actualizar-facturacion-requerimiento", ["as" => "admin.ajax_actualizar_facturacion_requerimiento", "uses" => "FacturacionController@actualizar_factura_requerimiento"]);

        Route::get("proceso_seleccion_gestion/{turno_id?}", ["as" => "admin.proceso_seleccion_gestion", "uses" => "ProcesoSeleccionController@gestionar_turno"]);
        Route::post("refrescar_turno", ["as" => "admin.refrescar_turno", "uses" => "ProcesoSeleccionController@refrescar_turno"]);
        Route::get("requerimientos_prioritarios", ["as" => "admin.requerimientos_prioritarios", "uses" => "RequerimientoController@requerimientos_prioritarios"]);
        Route::post("guardar_entrevista_seleccion", ["as" => "admin.guardar_entrevista_seleccion", "uses" => "ProcesoSeleccionController@guardar_entrevista_seleccion"]);
        Route::post("lista_req_proceso_seleccion", ["as" => "admin.lista_req_proceso_seleccion", "uses" => "ProcesoSeleccionController@lista_req_proceso_seleccion"]);
        Route::post("detalle_prueba", ["as" => "admin.detalle_prueba_seleccion", "uses" => "ProcesoSeleccionController@detalle_pruebas"]);
    });

    //Pruebas BRYG gestión
    Route::group(['middleware' => ['valida_admin','sesion_admin']], function () {
        Route::get("pruebas-bryg", ["as" => "admin.pruebas_bryg", "uses" => "PruebaPerfilController@lista_pruebas_bryg"]);
        Route::get("prueba-bryg-gestion/{bryg_id}", ["as" => "admin.pruebas_bryg_gestion", "uses" => "PruebaPerfilController@gestion_prueba_bryg"]);
        Route::post("prueba-bryg-concepto-final", ["as" => "admin.prueba_bryg_concepto_final", "uses" => "PruebaPerfilController@concepto_prueba_bryg"]);

        /*
         * Prueba digitación ADMIN
        */
        Route::get("pruebas-digitacion", ["as" => "admin.pruebas_digitacion", "uses" => "PruebaDigitacionController@lista_pruebas_digitacion"]);
        Route::get("prueba-digitacion-gestion/{digitacion_id}", ["as" => "admin.pruebas_digitacion_gestion", "uses" => "PruebaDigitacionController@gestion_prueba_digitacion"]);    
        Route::post("prueba-digitacion-concepto-final", ["as" => "admin.prueba_digitacion_concepto_final", "uses" => "PruebaDigitacionController@concepto_prueba_digitacion"]);
    });

    //Informe de pruebas selección
    Route::get("prueba-bryg-informe/{bryg_id}", ["as" => "admin.prueba_bryg_informe", "uses" => "PruebaPerfilController@informe_prueba_bryg"]);
    Route::get("prueba-digitacion-informe/{digitacion_id}", ["as" => "admin.prueba_digitacion_informe", "uses" => "PruebaDigitacionController@informe_prueba_digitacion"]);
    Route::get("pdf-prueba-ethical-values/{id_respuesta_user}", ["as" => "admin.pdf_prueba_valores", "uses" => "PruebaValoresController@pdf_prueba_valores"]);
    Route::get("prueba-competencias-informe/{prueba_id}", ["as" => "admin.prueba_competencias_informe", "uses" => "PruebaCompetenciasController@informe_prueba_competencias"]);
    Route::get("pdf_prueba/{id_respuesta_user}", ["as" => "admin.pdf_prueba_excel", "uses" => "PruebaExcelController@pdf_prueba_excel"]);

    //Pruebas Excel gestión
    Route::group(['middleware' => ['valida_admin','sesion_admin']], function () {
        Route::get("pruebas-excel-basico", ["as" => "admin.pruebas_excel_basico", "uses" => "PruebaExcelController@lista_excel_basico"]);

        Route::get("prueba-excel-basico-gestion/{proc_can_req_id}", ["as" => "admin.gestionar_excel_basico", "uses" => "PruebaExcelController@gestion_prueba_excel_basico"]);

        Route::get("pruebas-excel-intermedio", ["as" => "admin.pruebas_excel_intermedio", "uses" => "PruebaExcelController@lista_excel_intermedio"]);

        Route::get("prueba-excel-intermedio-gestion/{proc_can_req_id}", ["as" => "admin.gestionar_excel_intermedio", "uses" => "PruebaExcelController@gestion_prueba_excel_intermedio"]);
    });


    //Pruebas Excel gestión
    Route::group(['middleware' => ['valida_admin','sesion_admin']], function () {
        Route::get("pruebas-ethical-values", ["as" => "admin.pruebas_valores_1", "uses" => "PruebaValoresController@lista_valores_1"]);

        Route::get("prueba-ethical-values-gestion/{proc_can_req_id}", ["as" => "admin.gestionar_valores_1", "uses" => "PruebaValoresController@gestion_prueba_ethical_values"]);

        Route::post("prueba-ethical-values-concepto-final", ["as" => "admin.prueba_valores_concepto_final", "uses" => "PruebaValoresController@ethical_values_concepto_final"]);

    });



    //Prueba Competencias gestión
    Route::group(['middleware' => ['valida_admin','sesion_admin']], function () {
        Route::get("pruebas-competencias", ["as" => "admin.pruebas_competencias", "uses" => "PruebaCompetenciasController@lista_pruebas_competencias"]);
        Route::get("prueba-competencias-gestion/{prueba_id}", ["as" => "admin.pruebas_competencias_gestion", "uses" => "PruebaCompetenciasController@gestion_prueba_competencias"]);
        Route::post("prueba-competencias-concepto-final", ["as" => "admin.prueba_competencias_concepto_final", "uses" => "PruebaCompetenciasController@concepto_prueba_competencias"]);
    });


    Route::post("prueba_excel_concepto_final", ["as" => "admin.prueba_excel_concepto_final", "uses" => "PruebaExcelController@prueba_excel_concepto_final"]);

    Route::get("digiturno_eject", ["as" => "digiturno_eject", "uses" => "ReclutamientoController@digiturnoDemonio"]);
    Route::get("liberar_turnos", ["as" => "liberar_turnos", "uses" => "ReclutamientoController@liberar_turnos"]);
    Route::get("enviar_nuevas_ofertas_candidatos", ["as" => "admin.enviar_nuevas_ofertas_candidatos", "uses" => "OfertaController@enviar_nuevas_ofertas_candidatos"]);
    Route::get("get_views", ["as" => "sdfgddd", "uses" => "AdminController@getView"]);
    Route::get("crear_user_clientes_masivo", ["as" => "crear_user_clientes_masivo", "uses" => "AdminController@crear_user_clientes_masivo"]);

    //Modal clonar req
    Route::post("clonar_requerimiento_view", ["as" => "admin.clonar_requerimiento_view", "uses" => "RequerimientoController@clonar_requerimiento_view"]);
    Route::post("guardar_requerimiento_copia", ["as" => "admin.guardar_requerimiento_copia", "uses" => "RequerimientoController@guardar_requerimiento_copia"]);
});

// RESTful API
Route::group(['prefix'=>'api'], function(){
    Route::get('inicio', ["as" => "inicio", "uses" => "Api\ApiController@index"]);
    Route::post('login_api', ["as" => "login_api", "uses" => "Api\ApiController@login"]);

    Route::group(['middleware'=>['api.token']], function(){
        Route::get('requerimientos', ["as" => "requerimientos", "uses" => "Api\ApiController@requerimientos"]);

        Route::post('set_req_procesados', ["as" => "set_req_procesados", "uses" => "Api\ApiController@set_req_procesados"]);

        Route::get('cvs', ["as" => "cvs", "uses" => "Api\ApiController@cvs"]);

        Route::post('set_procesados', ["as" => "set_procesados", "uses" => "Api\ApiController@set_procesados"]);

        //Candidatos enviados a contratar en los diferentes requerimientos
        Route::get('candidatos_enviados_contratar', [
            "as" => "candidatos_enviados_contratar",
            "uses" => "Api\ApiController@candidatos_enviados_contratar"
        ]);
        
        Route::post("candidatos_contratados", [
            "as" => "candidatos_contratados",
            "uses" => "Api\ApiController@candidatos_contratados"
        ]);
        
        Route::post("crear_cliente", [
            "as" => "crear_cliente",
            "uses" => "Api\ApiController@crear_cliente"
        ]);

        // Aplicar a las ofertas desde TCN
        Route::post("aplicar_oferta", [
            "as" => "aplicar_oferta",
            "uses" => "Api\ApiController@aplicar_oferta"
        ]);
    }); 
});

//Rutas de modulo Reclutamiento externo
Route::group(['prefix'=>'reclutamiento'], function () {
    require __DIR__ . '/includes/reclutamiento_externo.php';
});

// Rutas para módulo de gestion documental

Route::group(['middleware' => ['valida_god']], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    //Configuración de correos
    Route::get("configuracion-correos", ["as" => "configuracion_correos", "uses" => "GestionCorreosController@configuracionCorreos"]);
    Route::get("configuracion-correos-gestionar/{configuracion_id}", ["as" => "configuracion_correos_gestionar", "uses" => "GestionCorreosController@configuracionCorreosGestionar"]);
    Route::get("configuracion-correos-crear", ["as" => "configuracion_correos_crear", "uses" => "GestionCorreosController@configuracionCorreosCrear"]);

    Route::post("configuracion-correos-guardar", ["as" => "configuracion_correos_guardar", "uses" => "GestionCorreosController@configuracionCorreosGuardar"]);
    Route::post("configuracion-correos-modificar", ["as" => "configuracion_correos_modificar", "uses" => "GestionCorreosController@configuracionCorreosModificar"]);

    //Previsualizar correos
    Route::post("configuracion-correos-previsualizar-modal", ["as" => "configuracion_correos_previsualizar_modal", "uses" => "GestionCorreosController@previsualizarCorreoModal"]);

    Route::get("configuracion-correos-previsualizar/{mailTemplate}/{mailConfiguration}", ["as" => "configuracion_correos_previsualizar", "uses" => "GestionCorreosController@previsualizarCorreo"]);
    Route::get("usuarios-masivos", ["as" => "usuarios_masivos", "uses" => "UsuarioController@cargaMasivaUsuariosView"]);
    Route::post("usuarios-masivos-cargar", ["as" => "usuarios_masivos_cargar", "uses" => "UsuarioController@cargaMasivaUsuarios"]);
    Route::post("mensajes-masivos-whatsapp", ["as" => "mensajes_masivos_whatsapp", "uses" => "UsuarioController@enviarMensajeMasivoWhatsapp"]);
});
