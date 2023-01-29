<?php

Route::get('login', ['as' => 'reclutamiento_externo.login', 'uses' => 'AuthController@loginReclutamientoExterno']);
Route::post('login_post', ['as' => 'reclutamiento_externo.login_post', 'uses' => 'AuthController@loginReclutamientoExternoPost']);
Route::get('logout_reclutamiento', ['as' => 'logout_reclutamiento', 'uses' => 'LoginController@logout']);
Route::get('permiso-negado', ['as' => 'reclutamiento_externo.permiso_negado', 'uses' => 'ReclutamientoExternoController@permiso_negado']);

Route::group(['middleware'=>['valida_reclutamiento_externo','sesion_reclutamiento_externo']], function () {
    Route::get('index', ['as' => 'reclutamiento_externo.index', 'uses' => 'ReclutamientoExternoController@index']);
    Route::get('mi-reclutamiento', ['as' => 'reclutamiento_externo.mi_reclutamiento', 'uses' => 'ReclutamientoExternoController@miReclutamiento']);
    Route::post('asociar-candidato', ['as' => 'reclutamiento_externo.asociar_candidato', 'uses' => 'ReclutamientoExternoController@agregarCandidatoNuevo']);
    Route::post("buscar-candidato-reclutamiento", ["as" => "reclutamiento_externo.ajaxgetcandidato", "uses" => "ReclutamientoExternoController@buscarCandidato"]);
    Route::post("guardar-candidato-asociado", ["as" => "reclutamiento_externo.guardar_candidato_asociado", "uses" => "ReclutamientoExternoController@asociarCandidato"]);
    Route::post("detalle_oferta_modal-reclutamiento", ["as" => "detalle_oferta_modal_reclutamiento", "uses" => "ReclutamientoExternoController@detalleOfertaModal"]);
});
