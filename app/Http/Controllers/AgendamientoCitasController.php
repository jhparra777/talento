<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AsistenteCita;
use App\Models\AsistenteCitaAgendamientoCandidato;
use App\Models\Requerimiento;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AgendamientoCitasController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->meses = [
            1  => "Enero",
            2  => "Febrero",
            3  => "Marzo",
            4  => "Abril",
            5  => "Mayo",
            6  => "Junio",
            7  => "Julio",
            8  => "Agosto",
            9  => "Septiembte",
            10 => "Octubre",
            11 => "Noviembre",
            12 => "Diciembre"
        ];
    }

    //ADMIN
    public function lista_citas(Request $request)
    {
        $lista_citas = AsistenteCita::join('requerimientos', 'requerimientos.id', '=', 'asistente_citas.req_id')
        ->join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->where(function ($sql) use ($request) {
            if($request->num_req != ""){
                $sql->where("asistente_citas.req_id", $request->num_req);
            }
        })
        ->select(
            'asistente_citas.*',
            'cargos_especificos.descripcion as cargo'
        )
        ->paginate(10);

        return view('admin.gestion_citas.index', compact('lista_citas'));
    }

    public function gestionar_cita($cita_id)
    {
        $cita = AsistenteCita::find($cita_id);

        $lista_cita_candidatos = AsistenteCita::join('asistente_citas_agendamiento_candidato', 'asistente_citas_agendamiento_candidato.cita_id', '=', 'asistente_citas.id')
        ->join('datos_basicos', 'datos_basicos.user_id', '=', 'asistente_citas_agendamiento_candidato.user_id')
        ->where('asistente_citas.id', $cita_id)
        ->where('asistente_citas.req_id', $cita->req_id)
        ->select(
            'asistente_citas.fecha_cita',
            'asistente_citas_agendamiento_candidato.id as agendamiento_id',
            'asistente_citas_agendamiento_candidato.*',
            \DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo")
        )
        ->orderBy('nombre_completo', 'DESC')
        ->get();

        $requerimiento_detalle = Requerimiento::where('requerimientos.id', $cita->req_id)->first();

        return view('admin.gestion_citas.gestion', compact('cita', 'lista_cita_candidatos', 'requerimiento_detalle'));
    }

    public function cancelar_cita(Request $request)
    {
        $cita = AsistenteCita::find($request->cita_id);
        $cita->estado_cita = 0;
        $cita->save();

        /**
         *
         * @todo Se debe notificar a los candidato a tráves de correo electrónico que la cita fue cancelada
         *
        */

        return response()->json([
            'success' => true
        ]);
    }

    public function asistio_cita(Request $request)
    {
        $cita_candidato = AsistenteCitaAgendamientoCandidato::find($request->agendamiento_id)->first();

        if (!$request->has('no_asistio')) {
            $cita_candidato->asistio = 1;
        }else {
            $cita_candidato->asistio = 0;
        }

        $cita_candidato->save();

        return response()->json([
            'success' => true
        ]);
    }

    //CV
    public function reserva_cita_candidato_modal(Request $request)
    {
        $cita = AsistenteCita::find($request->cita_id);

        //Mostrar fecha en letras
        $fecha_cita = explode("-", $cita->fecha_cita);
        $dia_cita = $fecha_cita[2];
        $mes_cita = (int)$fecha_cita[1];
        $año_cita = $fecha_cita[0];

        $fecha_cita = mb_strtolower("$dia_cita de ".$this->meses[$mes_cita]." de $año_cita");

        $duracion_cita = $cita->duracion_cita;

        //Sumar a la hora inicial el tiempo de duración de cada cita
        $convert_hora = strtotime($cita->hora_inicio);
        $convert_a_segundos = $cita->duracion_cita * 60;
        $nueva_hora = date("H:i", $convert_hora + $convert_a_segundos);

        //Buscar registro de la cita del candidato
        $cita_reservada_candidato = AsistenteCitaAgendamientoCandidato::where('cita_id', $request->cita_id)
        ->where('req_id', $request->req_id)
        ->where('user_id', $this->user->id)
        ->where('agendada', 1)
        ->first();

        //Intervalos de hora
        $intervalos = $this->intervalos($cita->hora_inicio, $cita->hora_fin, $cita->duracion_cita);

        return view("cv.modal.modal_reservar_horario_cita_candidato", compact(
            'req_id',
            'user_id',
            'cita',
            'fecha_cita',
            'duracion_cita',
            'nueva_hora',
            'cita_reservada_candidato',
            'intervalos'
        ));
    }

    public function guardar_reserva_cita_candidato(Request $request)
    {
        $cita_reservada = AsistenteCitaAgendamientoCandidato::where('cita_id', $request->cita_id)
        ->where('req_id', $request->req_id)
        ->where('user_id', $this->user->id)
        ->first();

        $cita_reservada->hora_inicio_cita = $request->hora_inicio_cita;
        $cita_reservada->hora_fin_cita = $request->hora_fin_cita;
        $cita_reservada->agendada = 1;
        $cita_reservada->save();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     *
     * Modales
     *
    */

    //Visualizar horarios reservados
    public function horariosReservadosModal(Request $request)
    {
        $req_id = $request->req_id;

        //Buscar cita
        $citas = AsistenteCita::where('req_id', $req_id)->get();

        return view('includes.modals.modal-horarios-reservados-cita', compact('citas'));
    }

    /**
     *
     * Funciones helper
     *
    */

    //Arreglo de intervalo de horas
    private function intervalos($hora_inicio, $hora_fin, $intervalo)
    {
        $hora_inicio = new \DateTime($hora_inicio);
        $hora_fin    = new \DateTime($hora_fin);
        $hora_fin->modify('+1 second'); // Añadimos 1 segundo para que muestre $hora_fin

        // Si la hora de inicio es superior a la hora fin
        // añadimos un día más a la hora fin
        if ($hora_inicio > $hora_fin) {
            $hora_fin->modify('+1 day');
        }

        // Establecemos el intervalo en minutos
        $intervalo = new \DateInterval('PT'.$intervalo.'M');

        // Sacamos los periodos entre las horas
        $periodo = new \DatePeriod($hora_inicio, $intervalo, $hora_fin);

        foreach($periodo as $hora) {
            // Guardamos las horas intervalos 
            $horas[] = $hora->format('H:i');
        }

        array_pop($horas); //Quitar ultimo elemento del arreglo

        return $horas;
    }

    //
    public static function validarHorarios(int $cita_id, int $req_id, array $horas)
    {
        $citas_reservadas = AsistenteCitaAgendamientoCandidato::where('cita_id', $cita_id)
        ->where('req_id', $req_id)
        ->where('hora_inicio_cita', $horas['hora_inicio_cita'])
        ->where('hora_fin_cita', $horas['hora_fin_cita'])
        ->where('agendada', 1)
        ->first();

        if(empty($citas_reservadas)) {
            return true;
        }

        return false;
    }

    //
    public static function fechaLetras(string $fecha_cita)
    {
        $meses = [
            1  => "Enero",
            2  => "Febrero",
            3  => "Marzo",
            4  => "Abril",
            5  => "Mayo",
            6  => "Junio",
            7  => "Julio",
            8  => "Agosto",
            9  => "Septiembte",
            10 => "Octubre",
            11 => "Noviembre",
            12 => "Diciembre"
        ];

        //Mostrar fecha en letras
        $fecha_cita = explode("-", $fecha_cita);
        $dia_cita = $fecha_cita[2];
        $mes_cita = (int)$fecha_cita[1];
        $año_cita = $fecha_cita[0];

        $fecha_cita = mb_strtolower("$dia_cita de ".$meses[$mes_cita]." de $año_cita");

        return $fecha_cita;
    }
}