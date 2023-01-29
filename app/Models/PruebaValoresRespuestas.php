<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PruebaValoresRespuestas extends Model
{
    protected $table    = 'prueba_valores_1_respuestas';
    protected $fillable = [
    	'user_id',
        'req_id',
        'config_req_id',
        'fecha_respuesta',
        'concepto_final',
        'gestiono_concepto',
        'valor_amor',
        'valor_no_violencia',
        'valor_paz',
        'valor_rectitud',
        'valor_verdad',
        'item_amor',
        'item_no_violencia',
        'item_paz',
        'item_rectitud',
        'item_verdad',
        'respuestas',
        'fotos'
    ];

    public function datosBasicosUsuarioGestionoConcepto() {
        return $this->belongsTo('App\Models\DatosBasicos', 'gestiono_concepto', 'user_id');
    }

    public function formatoFecha($fecha) {
        setlocale(LC_TIME, 'Spanish');

        $data         = new Carbon($fecha);
        $convertFecha = $data->formatLocalized('%d de %B de %Y');

        return $convertFecha;
    }

    public function getFotosArray() {
        if ($this->fotos != '') {
            return explode(',', $this->fotos);
        }
        return [];
    }

    public function graficaRadial($valor, $titulo = '') {
        $grafico_radial = [
            'type' => 'radialGauge',
            'data' => [
                'datasets' => [
                    [
                        'data' => [$valor],
                        'backgroundColor' => [
                            'rgb(114, 46, 135)'
                        ]
                    ]
                ]
            ],
            'options' => [
                'responsive' => true,
                'legend' => ['display' => false],
                'title' => [
                    'display' => false,
                    'text' => $titulo
                ],
                'showValue' => true,
                'centerArea' => [
                    'text' => urlencode("$valor %"),
                    'size' => ['80'],
                    'fontColor' => 'rgb(255,255,255)',
                    'backgroundColor' => [
                        'rgba(114,46,135,0.6)'
                    ]
                ]
            ]
        ];
        return $grafico_radial;
    }

    public function graficaBarras($valor_ideal, $valor_obtenido) {
        $ideal_total = 100 - $valor_ideal;
        $obtenido_total = 100 - $valor_obtenido;

        if ($valor_obtenido > 75) {
            $background = "57,169,53";//verde;
        } else if ($valor_obtenido > 50) {
            $background = "247,208,49";//amarillo
        } else if ($valor_obtenido > 25) {
            $background = "226,6,19";//rojo
        } else {
            $background = "198,198,198";//gris
        }

        $grafico_barras = [
            'type' => 'bar',
            'data' => [
                'labels' => ['Ideal', 'Candidato'],
                'datasets' => [
                    [
                        'label' => urlencode("Ideal $valor_ideal%"),
                        'data' => [$valor_ideal, 0],
                        'backgroundColor' => 'rgb(114,46,135)',
                        'barPercentage' => 0.3,
                        'stack' => 'Stack 0'
                    ],
                    [
                        'label' => urlencode("Candidato $valor_obtenido%"),
                        'data' => [0, $valor_obtenido],
                        'backgroundColor' => "rgb($background)",
                        'barPercentage' => 0.3,
                        'stack' => 'Stack 0'
                    ],
                    [
                        'label' => '',
                        'data' => [$ideal_total, $obtenido_total],
                        'backgroundColor' => 'rgba(128,128,128,0.3)',
                        'barPercentage' => 0.3,
                        'stack' => 'Stack 0'
                    ]
                ]
            ],
            'options' => [
                'legend' => ['display' => true],
                'title' => [
                    'display' => false
                ],
                'scales' => [
                    'xAxes' => [
                        "stacked" => true,
                        "display" => true
                    ],
                    'yAxes' => [
                        "stacked" => true,
                        "display" => false
                    ],
                ]
            ]
        ];
        return $grafico_barras;
    }
}
