<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Crypt;

use App\Models\DatosBasicos;
use App\Models\Sitio;
use App\Models\PlantillaCorreo;
use App\Models\PlantillaCorreoConfiguracion;
use App\Models\UserCorreoSuscripcion;

use Storage;
use File;
use triMailGenerator;

class GestionCorreosController extends Controller
{
    //Cancelar suscripcion a los correos
    public function cancelarSuscripcion($user_id, Request $request)
    {
        $sitio_informacion = Sitio::first();
        $user_id_decrypt = Crypt::decrypt($user_id);

        $usuario_informacion = DatosBasicos::where('user_id', $user_id_decrypt)->select('email')->first();

        return view('external_process.mail_subscription.cancel_subscription', compact('sitio_informacion', 'user_id', 'usuario_informacion'));
    }

    //Cancelar suscripcion a los correos, procesar información
    public function cancelarSuscripcionProceso(Request $request)
    {
        $user_id_decrypt = Crypt::decrypt($request->email_data);
        $user_suscripcion = UserCorreoSuscripcion::where('user_id', $user_id_decrypt)->first();

        if(!empty($user_suscripcion)) {
            //Cambia estado de suscripción
            $user_suscripcion->suscripcion = 0;
            $user_suscripcion->save();
        }else {
            //Si no existe el registro, se crea
            $user_suscripcion = new UserCorreoSuscripcion();
            $user_suscripcion->fill([
                'user_id' => $request->email_data,
                'suscripcion' => 0
            ]);
            $user_suscripcion->save();
        }

        return redirect()->back()->with(['suscripcion_cancelada' => true]);
    }

    //Configuraciones para correos
    public function configuracionCorreos(Request $request)
    {
        $sitio_informacion = Sitio::first();
        $lista_configuraciones = PlantillaCorreoConfiguracion::orderBy('nombre_configuracion', 'ASC')->get();

        return view('external_process.mail_configuration.mail_configuration_list', compact('sitio_informacion', 'lista_configuraciones'));
    }

    //Crear configuración
    public function configuracionCorreosCrear()
    {
        $sitio_informacion = Sitio::first();

        return view('external_process.mail_configuration.mail_configuration_create', compact('sitio_informacion'));
    }

    //Guardar configuración
    public function configuracionCorreosGuardar(Request $request)
    {
        $configuracion_correo = new PlantillaCorreoConfiguracion();

        $configuracion_correo->fill([
            'nombre_configuracion' => $request->nombre_configuracion,
            'color_principal' => $request->color_principal,
            'color_secundario' => $request->color_secundario,
            'social_facebook' => ($request->social_facebook == "true") ? 1 : 0,
            'social_twitter' => ($request->social_twitter == "true") ? 1 : 0,
            'social_linkedin' => ($request->social_linkedin == "true") ? 1 : 0,
            'social_instagram' => ($request->social_instagram == "true") ? 1 : 0,
            'social_whatsapp' => ($request->social_whatsapp == "true") ? 1 : 0
        ]);
        $configuracion_correo->save();

        //Guardar imagen header
        $imagen_header = $request->file('imagen_header');
        $imagen_header_extension = $imagen_header->getClientOriginalExtension();
        $imagen_header_nombre = "imagen-header-plantilla-$configuracion_correo->id.$imagen_header_extension";

        Storage::disk('public')->put("templates_src/conf_$configuracion_correo->id/$imagen_header_nombre", File::get($imagen_header));

        //Guardar imagen fondo header
        $imagen_fondo_header = $request->file('imagen_fondo_header');
        $imagen_fondo_header_extension = $imagen_fondo_header->getClientOriginalExtension();
        $imagen_fondo_header_nombre = "imagen-fondo-header-plantilla-$configuracion_correo->id.$imagen_fondo_header_extension";

        Storage::disk('public')->put("templates_src/conf_$configuracion_correo->id/$imagen_fondo_header_nombre", File::get($imagen_fondo_header));

        //Guardar imagen footer
        $imagen_footer = $request->file('imagen_footer');
        $imagen_footer_extension = $imagen_footer->getClientOriginalExtension();
        $imagen_footer_nombre = "imagen-footer-plantilla-$configuracion_correo->id.$imagen_footer_extension";

        Storage::disk('public')->put("templates_src/conf_$configuracion_correo->id/$imagen_footer_nombre", File::get($imagen_footer));

        //Guardar imagen sub footer
        $imagen_sub_footer = $request->file('imagen_sub_footer');
        $imagen_sub_footer_extension = $imagen_sub_footer->getClientOriginalExtension();
        $imagen_sub_footer_nombre = "imagen-sub-footer-plantilla-$configuracion_correo->id.$imagen_sub_footer_extension";

        Storage::disk('public')->put("templates_src/conf_$configuracion_correo->id/$imagen_sub_footer_nombre", File::get($imagen_sub_footer));

        //
        $configuracion_correo->fill([
            'imagen_header' => $imagen_header_nombre,
            'imagen_fondo_header' => $imagen_fondo_header_nombre,
            'imagen_footer' => $imagen_footer_nombre,
            'imagen_sub_footer' => $imagen_sub_footer_nombre
        ]);
        $configuracion_correo->save();

        return response()->json(['success' => true]);
    }

    //Gestionar configuración
    public function configuracionCorreosGestionar(int $configuracion_id)
    {
        $sitio_informacion = Sitio::first();
        $configuracion_correo = PlantillaCorreoConfiguracion::find($configuracion_id);

        return view('external_process.mail_configuration.mail_configuration_manage', compact('sitio_informacion', 'configuracion_correo'));
    }

    //Modificar configuración
    public function configuracionCorreosModificar(Request $request)
    {
        $configuracion_id = $request->configuracion_id;
        $configuracion_correo = PlantillaCorreoConfiguracion::find($configuracion_id);

        //Guardar imagen header
        if ($request->hasFile('imagen_header')) {
            $imagen_header = $request->file('imagen_header');
            $imagen_header_extension = $imagen_header->getClientOriginalExtension();
            $imagen_header_nombre = "imagen-header-plantilla-$configuracion_id.$imagen_header_extension";

            Storage::disk('public')->put("templates_src/conf_$configuracion_id/$imagen_header_nombre", File::get($imagen_header));

            $configuracion_correo->fill([
                'imagen_header' => $imagen_header_nombre,
            ]);
        }

        //Guardar imagen fondo header
        if ($request->hasFile('imagen_fondo_header')) {
            $imagen_fondo_header = $request->file('imagen_fondo_header');
            $imagen_fondo_header_extension = $imagen_fondo_header->getClientOriginalExtension();
            $imagen_fondo_header_nombre = "imagen-fondo-header-plantilla-$configuracion_id.$imagen_fondo_header_extension";

            Storage::disk('public')->put("templates_src/conf_$configuracion_id/$imagen_fondo_header_nombre", File::get($imagen_fondo_header));

            $configuracion_correo->fill([
                'imagen_fondo_header' => $imagen_fondo_header_nombre,
            ]);
        }

        //Guardar imagen footer
        if ($request->hasFile('imagen_footer')) {
            $imagen_footer = $request->file('imagen_footer');
            $imagen_footer_extension = $imagen_footer->getClientOriginalExtension();
            $imagen_footer_nombre = "imagen-footer-plantilla-$configuracion_id.$imagen_footer_extension";

            Storage::disk('public')->put("templates_src/conf_$configuracion_id/$imagen_footer_nombre", File::get($imagen_footer));

            $configuracion_correo->fill([
                'imagen_footer' => $imagen_footer_nombre,
            ]);
        }

        //Guardar imagen sub footer
        if ($request->hasFile('imagen_sub_footer')) {
            $imagen_sub_footer = $request->file('imagen_sub_footer');
            $imagen_sub_footer_extension = $imagen_sub_footer->getClientOriginalExtension();
            $imagen_sub_footer_nombre = "imagen-sub-footer-plantilla-$configuracion_id.$imagen_sub_footer_extension";

            Storage::disk('public')->put("templates_src/conf_$configuracion_id/$imagen_sub_footer_nombre", File::get($imagen_sub_footer));

            $configuracion_correo->fill([
                'imagen_sub_footer' => $imagen_sub_footer_nombre,
            ]);
        }

        //
        $configuracion_correo->fill([
            'nombre_configuracion' => $request->nombre_configuracion,
            'color_principal' => $request->color_principal,
            'color_secundario' => $request->color_secundario,
            'social_facebook' => ($request->social_facebook == "true") ? 1 : 0,
            'social_twitter' => ($request->social_twitter == "true") ? 1 : 0,
            'social_linkedin' => ($request->social_linkedin == "true") ? 1 : 0,
            'social_instagram' => ($request->social_instagram == "true") ? 1 : 0,
            'social_whatsapp' => ($request->social_whatsapp == "true") ? 1 : 0
        ]);
        $configuracion_correo->save();

        return response()->json(['success' => true]);
    }

    //Previsualizar correo modal
    public function previsualizarCorreoModal()
    {
        $configuracion_correo_lista = ["" => "Seleccionar"] + PlantillaCorreoConfiguracion::orderBy("nombre_configuracion", "ASC")
        ->pluck("nombre_configuracion", "id")
        ->toArray();

        return view('external_process.mail_configuration.includes.mail_configuration_modal_preview', compact('configuracion_correo_lista'));
    }

    //Previsualizar correo
    public function previsualizarCorreo($mailTemplate, $mailConfiguration)
    {
        $mailTitle = "Previsualizando ...";
        $mailBody = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

        $mailButton = [
            'buttonText' => 'Botón ejemplo',
            'buttonRoute' => route('home')
        ];

        $mailTemplate = $mailTemplate;
        $mailConfiguration = $mailConfiguration;

        $triMailGenerator = triMailGenerator::generateMail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton);

        return view($triMailGenerator->view, ['data' => $triMailGenerator->data]);

        /*try {
            Mail::send($triMailGenerator->view, ['data' => $triMailGenerator->data], function($message) {
                $message->to(['sebastianb.t3rs@gmail.com', 'jessicat3rs@gmail.com'], 'T3RS Developer')->subject('Test generator');
            });

            dd('ok');
        } catch (Exception $e) {
            dd($e);
        }*/
    }
}
