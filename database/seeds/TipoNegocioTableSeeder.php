<?php

use Illuminate\Database\Seeder;

class TipoNegocioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_negocios')->insert([
            "id"         => "1",
            "codigo"     => "1",
            "nombre"     => "TIPO DE NEGOCIO NO 1",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "2",
            "codigo"     => "2",
            "nombre"     => "TIPO DE NEGOCIO NO 2",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "3",
            "codigo"     => "1111",
            "nombre"     => "COMERCIO TARIFA HORA NORMAL  C-0A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "4",
            "codigo"     => "1112",
            "nombre"     => "COMERCIO TARIFA HORA MODIFICADA  C-0B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "5",
            "codigo"     => "1211",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 1A  C-1A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "6",
            "codigo"     => "1212",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 1B  C-1B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "7",
            "codigo"     => "1213",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 1C  C-1C",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "8",
            "codigo"     => "1221",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 2A  C-2A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "9",
            "codigo"     => "1222",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 2B  C-2B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "10",
            "codigo"     => "1223",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 2C  C-2C",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "11",
            "codigo"     => "1231",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 3A  C-3A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "12",
            "codigo"     => "1232",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 3B  C-3B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "13",
            "codigo"     => "1233",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 3C  C-3C",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "14",
            "codigo"     => "1251",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 5A  C-5A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "15",
            "codigo"     => "1252",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 5B  C-5B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "16",
            "codigo"     => "1253",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 5C  C-5C",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "17",
            "codigo"     => "1261",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 6A  C-6A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "18",
            "codigo"     => "1262",
            "nombre"     => "COMERCIO ADMON NOMINA TIPO 6B   C-6B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "19",
            "codigo"     => "2111",
            "nombre"     => "MANUFACTURA TARIFA HORA NORMAL  I-0A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "20",
            "codigo"     => "2112",
            "nombre"     => "MANUFACTURA TARIFA HORA MODIFICADA  I-0B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "21",
            "codigo"     => "2211",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 1A  I-1A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "22",
            "codigo"     => "2212",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 1B   I-1B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "23",
            "codigo"     => "2213",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 1C  I-1C",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "24",
            "codigo"     => "2221",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 2A  I-2A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "25",
            "codigo"     => "2222",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 2B  I-2B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "26",
            "codigo"     => "2223",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 2C  I-2C",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "27",
            "codigo"     => "2231",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 3A  I-3A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "28",
            "codigo"     => "2232",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 3B  I-3B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "29",
            "codigo"     => "2251",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 5A  I-5A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "30",
            "codigo"     => "2252",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 5B  I-5B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "31",
            "codigo"     => "2253",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 5C  I-5C",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "32",
            "codigo"     => "2261",
            "nombre"     => "MANUFACTURA ADMON NOMINA TIPO 6A  I-6A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "33",
            "codigo"     => "3111",
            "nombre"     => "MERCADEO TARIFA HORA NORMAL  M-0A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "34",
            "codigo"     => "3112",
            "nombre"     => "MERCADEO TARIFA HORA MODIFICADA  M-0B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "35",
            "codigo"     => "3211",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 1A   M-1A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "36",
            "codigo"     => "3212",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 1B   M-1B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "37",
            "codigo"     => "3221",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 2A   M-2A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "38",
            "codigo"     => "3222",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 2B   M-2B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "39",
            "codigo"     => "3223",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 2C   M-2C",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "40",
            "codigo"     => "3231",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 3A   M-3A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "41",
            "codigo"     => "3232",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 3B   M-3B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "42",
            "codigo"     => "3251",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 5A   M-5A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "43",
            "codigo"     => "3252",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 5B   M-5B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "44",
            "codigo"     => "3261",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 6A   M-6A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "45",
            "codigo"     => "3262",
            "nombre"     => "MERCADEO ADMON NOMINA TIPO 6B   M-6B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "46",
            "codigo"     => "5111",
            "nombre"     => "ASEO TARIFA HORA NORMAL   A-0A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "47",
            "codigo"     => "5112",
            "nombre"     => "ASEO TARIFA HORA MODIFICADA   A-0B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "48",
            "codigo"     => "5211",
            "nombre"     => "ASEO ADMON NOMINA TIPO 1A   A-1A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "49",
            "codigo"     => "5212",
            "nombre"     => "ASEO ADMON NOMINA TIPO 1B    A-1B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "50",
            "codigo"     => "5221",
            "nombre"     => "ASEO ADMON NOMINA TIPO 2A    A-2A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "51",
            "codigo"     => "5222",
            "nombre"     => "ASEO ADMON NOMINA TIPO 2B    A-2B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "52",
            "codigo"     => "5231",
            "nombre"     => "ASEO ADMON NOMINA TIPO 3A    A-3A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "53",
            "codigo"     => "5232",
            "nombre"     => "ASEO ADMON NOMINA TIPO 3B    A-3B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "54",
            "codigo"     => "5251",
            "nombre"     => "ASEO ADMON NOMINA TIPO 5A   A-5A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "55",
            "codigo"     => "5252",
            "nombre"     => "ASEO ADMON NOMINA TIPO 5B   A-5B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "56",
            "codigo"     => "5261",
            "nombre"     => "ASEO ADMON NOMINA TIPO 6A   A-6A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "57",
            "codigo"     => "5262",
            "nombre"     => "ASEO ADMON NOMINA TIPO 6B   A-6B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "58",
            "codigo"     => "6111",
            "nombre"     => "PUBLICIDAD TARIFA HORA NORMAL P-0A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "59",
            "codigo"     => "6112",
            "nombre"     => "PUBLICIDAD TARIFA HORA MODIFICADA P-0B",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "60",
            "codigo"     => "6301",
            "nombre"     => "SELECCION DE CARGOS FIJOS TIPO S-1A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "61",
            "codigo"     => "6302",
            "nombre"     => "VISITAS DOMICILIARIAS V-0A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "62",
            "codigo"     => "6303",
            "nombre"     => "SERVICIOS DE OUTSOURSING O-1A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "63",
            "codigo"     => "6304",
            "nombre"     => "ARRENDAMIENTOS TIPO X-1A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "64",
            "codigo"     => "6305",
            "nombre"     => "SERVICIOS DE INFORMACION INFO",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "65",
            "codigo"     => "6306",
            "nombre"     => "SERV. INFORMACION (NO BAVARIA) INF2",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "66",
            "codigo"     => "6307",
            "nombre"     => "VENTA DE BODEGAJE B-0A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "67",
            "codigo"     => "6308",
            "nombre"     => "SERVICIOS DE SALUD",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "68",
            "codigo"     => "6309",
            "nombre"     => "APRENDICES SEN",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "69",
            "codigo"     => "6310",
            "nombre"     => "SERVICIOS DE OUTSOURSING O-1A",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('tipo_negocios')->insert([
            "id"         => "70",
            "codigo"     => "6311",
            "nombre"     => "MANTENIMIENTO",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

    }
}
