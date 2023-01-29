<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Estudios;
use App\Models\Experiencias;
use App\Models\Documentos;
use App\Models\TipoDocumento;
use App\Models\Certificado;
use DB;
use Storage;

class MigrationCertificationsStudiesAndExperiences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrar:certificados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra los certificados de estudios y experiencias de donde se guardaban antes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        try {

            DB::transaction(function () {

                //comenzamos migrando los certificados de experiencias
                $experiencias = Experiencias::join('certificados_experiencias', 'certificados_experiencias.experiencias_id', '=', 'experiencias.id')
                ->where('certificados_experiencias.active', 1)
                ->select(
                    'experiencias.*', 
                    'certificados_experiencias.nombre_archivo',
                    'certificados_experiencias.id as certificado_id',
                    'certificados_experiencias.created_at as fecha_creado',
                    'certificados_experiencias.updated_at as fecha_actualizado')
                ->get();

                //buscamos el tipo de documento CERTIFICADO LABORAL
                $tipo_documento_experiencia = TipoDocumento::where('cod_tipo_doc', 'CL')->first();

                foreach ($experiencias as $experiencia) {

                    //validamos si existe el archivo en la carpeta
                    $exists = Storage::disk('public')->exists('recursos_datosbasicos/'.$experiencia->nombre_archivo);

                    if ( $exists ) {
                        
                        //creamos primero el registro en la tabla documentos
                        $documento_experiencia = new Documentos();

                        $documento_experiencia->fill([
                            "user_id" => $experiencia->user_id,
                            "numero_id" => $experiencia->numero_id,
                            "tipo_documento_id" => $tipo_documento_experiencia->id,
                            "descripcion_archivo" => $experiencia->nombre_empresa
                        ]);

                        $documento_experiencia->save();

                        //movemos el archivo a la nueva carpeta
                        $nombre_certificado_experiencia_old = $experiencia->nombre_archivo;

                        $extension = end(explode('.', $experiencia->nombre_archivo));

                        $nombre_certificado_experiencia_new = "documento_" . $documento_experiencia->id . "." . $extension;

                        Storage::disk('public')->move("recursos_datosbasicos/{$nombre_certificado_experiencia_old}", "recursos_documentos/{$nombre_certificado_experiencia_new}");

                        $documento_experiencia->nombre_archivo = $nombre_certificado_experiencia_new;
                        //guardamos tambien las fechas para que queden con las fechas originales de creacion
                        //y de actualizacion
                        $documento_experiencia->created_at = $experiencia->fecha_creado;
                        $documento_experiencia->updated_at = $experiencia->fecha_actualizado;
                        $documento_experiencia->save();

                        //guardamos el certificado con su relacion
                        $certificado_exp = new Certificado([
                            "documento_id" => $documento_experiencia->id,
                            "created_at"   => $experiencia->fecha_creado,
                            "updated_at"   => $experiencia->fecha_actualizado
                        ]);

                        $experiencia->certificados()->save($certificado_exp);

                        //actualizamos los registros a active 0
                        //esto para en caso de volver a ejecutar el comando no lo vuelva a migrar
                        DB::table('certificados_experiencias')
                            ->where('id', $experiencia->certificado_id)
                            ->update(['active' => 0]);
                    }
                    
                }

                //continuamos migrando datos de certificados de estudios
                $estudios = Estudios::join("certificados_estudios", "certificados_estudios.estudios_id", "=", "estudios.id")
                ->leftjoin("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->where('certificados_estudios.active', 1)
                ->select(
                    'estudios.*', 
                    'certificados_estudios.nombre_archivo',
                    'certificados_estudios.id as certificado_id',
                    'certificados_estudios.created_at as fecha_creado',
                    'certificados_estudios.updated_at as fecha_actualizado',
                    'niveles_estudios.descripcion as nivel_estudio')
                ->get();

                //buscamos el tipo de documento CERTIFICADO DE ESTUDIOS
                $tipo_documento_estudio = TipoDocumento::where('cod_tipo_doc', 'CE')->first();

                foreach ($estudios as $estudio) {

                    //validamos si existe el archivo en la carpeta
                    $exists = Storage::disk('public')->exists('recursos_datosbasicos/'.$estudio->nombre_archivo);

                    if ( $exists ) {

                        //creamos primero el registro en la tabla documentos
                        $documento_estudio = new Documentos();

                        $documento_estudio->fill([
                            "user_id" => $estudio->user_id,
                            "numero_id" => $estudio->numero_id,
                            "tipo_documento_id" => $tipo_documento_estudio->id,
                            "descripcion_archivo" => ($estudio->nivel_estudio != null ? $estudio->nivel_estudio : $tipo_documento_estudio->descripcion)
                        ]);

                        $documento_estudio->save();

                        //movemos el archivo a la nueva carpeta
                        $nombre_certificado_estudio_old = $estudio->nombre_archivo;

                        $extension = end(explode('.', $estudio->nombre_archivo));

                        $nombre_certificado_estudio_new = "documento_" . $documento_estudio->id . "." . $extension;

                        Storage::disk('public')->move("recursos_datosbasicos/{$nombre_certificado_estudio_old}", "recursos_documentos/{$nombre_certificado_estudio_new}");

                        $documento_estudio->nombre_archivo = $nombre_certificado_estudio_new;
                        //guardamos tambien las fechas para que queden con las fechas originales de creacion
                        //y de actualizacion
                        $documento_estudio->created_at = $estudio->fecha_creado;
                        $documento_estudio->updated_at = $estudio->fecha_actualizado;
                        $documento_estudio->save();

                        //guardamos el certificado con su relacion
                        $certificado_est = new Certificado([
                            "documento_id" => $documento_estudio->id,
                            "created_at"   => $estudio->fecha_creado,
                            "updated_at"   => $estudio->fecha_actualizado
                        ]);

                        $estudio->certificados()->save($certificado_est);

                        //actualizamos los registros a active 0
                        //esto para en caso de volver a ejecutar el comando no lo vuelva a migrar
                        DB::table('certificados_estudios')
                            ->where('id', $estudio->certificado_id)
                            ->update(['active' => 0]);
                    }
                    
                }

                $this->info('datos de certificados migrados correctamente.');
            });
        
        } catch (\Exception $e) {
            $this->error('ocurrio un error: '.$e->getMessage());
        }

    }
}
