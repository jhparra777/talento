<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\PruebaBrigFactor;
use App\Models\PruebaBrigResultado;
use App\Models\PruebaBrigConcepto;

class PruebaPerfilBrygController extends Controller
{
    //Validar el perfil aumented
    public static function aumentedPerfil(string $aumented)
    {
        $url = null;

        switch ($aumented) {
            case 'analizador':
                $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/a-analizador/bryg-aumented-analizador.jpg";
                break;
            case 'prospectivo':
                $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/a-prospectivo/bryg-aumented-prospectivo.jpg";
                break;
            case 'defensivo':
                $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/a-defensivo/bryg-aumented-defensivo.jpg";
                break;
            case 'reactivo':
                $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/a-reactivo/bryg-aumented-reactivo.jpg";
                break;

            default:
                // code...
                break;
        }

        return $url;
    }

    //Validar el perfil bryg
    public static function brygPerfil(string $bryg_first, string $bryg_second)
    {
        $url = null;

        if ($bryg_first == 'basico' && $bryg_second == 'radical') {
            //Capitán
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/capitan/bryg-capitan.jpg";

        }else if ($bryg_first == 'radical' && $bryg_second == 'basico') {
            //Capitán
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/capitan/bryg-capitan.jpg";

        }else if($bryg_first == 'basico' && $bryg_second == 'garante') {
            //Científico
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/cientifico/bryg-cientifico.jpg";

        }else if($bryg_first == 'garante' && $bryg_second == 'basico') {
            //Científico
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/cientifico/bryg-cientifico.jpg";

        }else if($bryg_first == 'radical' && $bryg_second == 'garante') {
            //Cocreador
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/cocreador/bryg-cocreador.jpg";

        }else if($bryg_first == 'garante' && $bryg_second == 'radical') {
            //Cocreador
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/cocreador/bryg-cocreador.jpg";

        }else if($bryg_first == 'basico' && $bryg_second == 'genuino') {
            //Director
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/director/bryg-director.jpg";

        }else if($bryg_first == 'genuino' && $bryg_second == 'basico') {
            //Director
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/director/bryg-director.jpg";

        }else if($bryg_first == 'genuino' && $bryg_second == 'radical') {
            //Populista
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/populista/bryg-populista.jpg";

        }else if($bryg_first == 'radical' && $bryg_second == 'genuino') {
            //Populista
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/populista/bryg-populista.jpg";

        }else if($bryg_first == 'genuino' && $bryg_second == 'garante') {
            //Protector
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/protector/bryg-protector.jpg";

        }else if($bryg_first == 'garante' && $bryg_second == 'genuino') {
            //Protector
            $url = "https://desarrollo.t3rsc.co/assets/admin/tests/bryg/protector/bryg-protector.jpg";
        }

        return $url;
    }

    //Validar el tipo de perfil bryg, tipo
    public static function brygPerfilTipo(string $bryg_first, string $bryg_second)
    {
        $perfil = "undefined";

        if ($bryg_first == 'basico' && $bryg_second == 'radical') {
            //Capitán
            $perfil = "Capitán";

        }else if ($bryg_first == 'radical' && $bryg_second == 'basico') {
            //Capitán
            $perfil = "Capitán";

        }else if($bryg_first == 'basico' && $bryg_second == 'garante') {
            //Científico
            $perfil = "Científico";

        }else if($bryg_first == 'garante' && $bryg_second == 'basico') {
            //Científico
            $perfil = "Científico";

        }else if($bryg_first == 'radical' && $bryg_second == 'garante') {
            //Cocreador
            $perfil = "Cocreador";

        }else if($bryg_first == 'garante' && $bryg_second == 'radical') {
            //Cocreador
            $perfil = "Cocreador";

        }else if($bryg_first == 'basico' && $bryg_second == 'genuino') {
            //Director
            $perfil = "Director";

        }else if($bryg_first == 'genuino' && $bryg_second == 'basico') {
            //Director
            $perfil = "Director";

        }else if($bryg_first == 'genuino' && $bryg_second == 'radical') {
            //Populista
            $perfil = "Populista";

        }else if($bryg_first == 'radical' && $bryg_second == 'genuino') {
            //Populista
            $perfil = "Populista";

        }else if($bryg_first == 'genuino' && $bryg_second == 'garante') {
            //Protector
            $perfil = "Protector";

        }else if($bryg_first == 'garante' && $bryg_second == 'genuino') {
            //Protector
            $perfil = "Protector";
        }

        return $perfil;
    }

    //Buscar factores de acuerdo a los cuadrantes
    public static function brygPrimerCuadranteFactor(string $bryg_first)
    {
        $bryg_factores_first = PruebaBrigFactor::where('cuadrante', $bryg_first)->get();

        return $bryg_factores_first;
    }

    //Buscar factores de acuerdo a los cuadrantes
    public static function brygSegundoCuadranteFactor(string $bryg_second)
    {
        $bryg_factores_second = PruebaBrigFactor::where('cuadrante', $bryg_second)->get();

        return $bryg_factores_second;
    }

    //Buscar si el candidato tiene prueba bryg contestada
    public static function brygCandidato(int $user_id, int $req_id)
    {
        $candidato_bryg = PruebaBrigResultado::where('prueba_brig_candidato_resultado.user_id', $user_id)
        ->where('prueba_brig_candidato_resultado.req_id', $req_id)
        ->where('estado', 1)
        ->orderBy('created_at', 'DESC')
        ->first();

        if (!empty($candidato_bryg)) {
            return $candidato_bryg;
        }

        return null;
    }

    //Buscar si el candidato tiene prueba bryg contestada
    public static function brygCandidatoConcepto(int $bryg_id)
    {
        $candidato_bryg_concepto = PruebaBrigConcepto::where('bryg_id', $bryg_id)->first();

        if (!empty($candidato_bryg_concepto)) {
            return $candidato_bryg_concepto;
        }

        return null;
    }

}
