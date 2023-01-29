<?php

namespace App\Models;

use App\Models\AspiracionSalarial;
use App\Models\Escolaridad;
use App\Models\Genero;
use App\Models\TipoExperiencia;
use App\Models\TipoJornada;
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    public $timestamps  = true;
    protected $table    = 'ficha';
    protected $fillable = [
        'id',
        'sociedad_id',
        'cliente_id',
        'req_informe_seleccion',
        'req_visita_domiciliaria',
        'req_estudio_seguridad',
        'cargo_generico',
        'cargo_cliente',
        'cantidad_candidatos_vac',
        'criticidad_cargo',
        'genero',
        'edad_minima',
        'edad_maxima',
        'escolaridad',
        'otro_estudio',
        'experiencia',
        'area_desempeno',
        'conocimientos_especificos',
        'competencias_requeridas',
        'horario',
        'observaciones_horario',
        'variable',
        'valor_variable',
        'comision',
        'valor_comision',
        'rodamiento',
        'valor_rodamiento',
        'rango_salarial',
        'tipo_contrato',
        'personal_cargo',
        'canal_pertenece',
        'funciones_realizar',
        'estatura_minima',
        'estatura_maxima',
        'talla_camisa',
        'talla_pantalon',
        'calzado',
        'otros_fisicas',
        'restricciones',
        'observaciones_generales',
        'user_id',
        'active',
    ];

    public function getEstadoDescr()
    {
        $estado = "";
        if ($this->active == 1) {
            $estado = 'Activo';
        }
        if ($this->active == 0) {
            $estado = 'Inactivo';
        }
        return $estado;
    }
    public function getGeneroDescr()
    {
        $genero = Genero::where("id", $this->genero)
            ->select("descripcion as genero")
            ->first();
        if ($genero != null) {
            return $genero;
        }
        $genero         = new \stdClass();
        $genero->genero = '';
    }
    public function getEscolaridadDescr()
    {
        $escolaridad = Escolaridad::where("id", $this->escolaridad)
            ->select("descripcion as escolaridad")
            ->first();
        if ($escolaridad != null) {
            return $escolaridad;
        }
        $escolaridad              = new \stdClass();
        $escolaridad->escolaridad = '';
    }
    public function getExperienciaDescr()
    {
        $experiencia = TipoExperiencia::where("id", $this->experiencia)
            ->select("descripcion as experiencia")
            ->first();
        if ($experiencia != null) {
            return $experiencia;
        }
        $experiencia              = new \stdClass();
        $experiencia->experiencia = '';
    }
    public function getHorarioDescr()
    {
        $horario = TipoJornada::where("id", $this->horario)
            ->select("descripcion as horario")
            ->first();
        if ($horario != null) {
            return $horario;
        }
        $horario          = new \stdClass();
        $horario->horario = '';
    }
    public function getAspiracionDescr()
    {
        $rango_salarial = AspiracionSalarial::where("id", $this->rango_salarial)
            ->select("descripcion as rango_salarial")
            ->first();
        if ($rango_salarial != null) {
            return $rango_salarial;
        }
        $rango_salarial                 = new \stdClass();
        $rango_salarial->rango_salarial = '';
    }
    public function getContratoDescr()
    {
        $tipo_contrato = TipoContrato::where("id", $this->tipo_contrato)
            ->select("descripcion as tipo_contrato")
            ->first();
        if ($tipo_contrato != null) {
            return $tipo_contrato;
        }
        $tipo_contrato                = new \stdClass();
        $tipo_contrato->tipo_contrato = '';
    }

    public function getTipoJornada()
    {
        $dato_ficha = TipoJornada::where("id", $this->id)
            ->select("descripcion")
            ->first();
        return $datos_basicos;
    }
}
