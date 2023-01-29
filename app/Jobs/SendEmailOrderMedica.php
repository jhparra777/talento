<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\ExamenesMedicos;
use App\Models\OrdenMedica;
use App\Models\ReqCandidato;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class SendEmailOrderMedica extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $requerimientos_cand_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requerimientos_cand_id)
    {
        $this->requerimientos_cand_id = $requerimientos_cand_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $empresa = '';

        foreach ($this->requerimientos_cand_id as $key => $req_cand_id) {
            //Datos para correo
            $DataOrder = OrdenMedica::join('proveedor', 'proveedor.id', '=', 'orden_medica.proveedor_id')
                ->join("requerimiento_cantidato","requerimiento_cantidato.id","=","orden_medica.req_can_id")
                ->where('orden_medica.req_can_id', $req_cand_id)
                ->select(
                    'orden_medica.*',
                    'orden_medica.observacion as otros',
                    'proveedor.nombre as centro_medico',
                    'proveedor.email as email',
                    'requerimiento_cantidato.requerimiento_id as req'
                )
                ->orderBy('orden_medica.id', 'desc')
                ->first();

            $DataExamenes = ExamenesMedicos::join('examen_medico', 'examen_medico.id', '=', 'examenes_medicos.examen')
                ->where('orden_id', $DataOrder->id)
                ->select('examen_medico.nombre as examen_medico')
                ->get();

            $emails = $DataOrder->email;

            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                    ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->where("requerimiento_cantidato.id", $req_cand_id)
                ->select(
                    "datos_basicos.*",
                    "requerimiento_cantidato.id as req_candidato",
                    "requerimientos.*",
                    "requerimientos.id as id_req",
                    "clientes.nombre as cliente",
                    "cargos_especificos.descripcion as cargo",
                    "ciudad.nombre as ciudad"
                )
                ->first();

            $asunto = "Orden exámenes médicos $candidato->cliente # $orden->id";

            if($candidato->empresa_contrata != null && $empresa != '') {
                $empresa = DB::table("empresa_logos")->where('id', $candidato->empresa_contrata)->first();
            }

            logger(json_encode($DataExamenes));

            $env = Mail::send('admin.email_orden_examen_medico', [
                "DataExamenes" => $DataExamenes,
                "candidato" => $candidato,
                "DataOrder" => $DataOrder,
                "empresa" => $empresa
            ],function($message) use ($emails, $asunto) {
                $message->to([$emails])->subject($asunto)
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
            logger(json_encode($env));
        }
    }
}
