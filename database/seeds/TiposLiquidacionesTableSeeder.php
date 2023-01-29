<?php

use Illuminate\Database\Seeder;

class TiposLiquidacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "1",
            "descripcion"          => "A-MENSUAL DEL 1 AL 30 (PDN)",
            "cod_tipo_liquidacion" => "A",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "2",
            "descripcion"          => "B-QUIN.  11 AL 25 Y 26 AL 10",
            "cod_tipo_liquidacion" => "B",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "3",
            "descripcion"          => "C-CATORCENAL NORMAL (C)",
            "cod_tipo_liquidacion" => "C",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "4",
            "descripcion"          => "D-QUINCENAL ATRASADO",
            "cod_tipo_liquidacion" => "D",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "5",
            "descripcion"          => "E-MENSUAL 1-30 PAGO 25",
            "cod_tipo_liquidacion" => "E",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "6",
            "descripcion"          => "F-FACT. MENS. DE LIQ. B",
            "cod_tipo_liquidacion" => "F",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "7",
            "descripcion"          => "G-QUINCENAL 1 AL 15 Y 16 AL 30 (PARA CIERRE DE FIN DE A\u00d1O)",
            "cod_tipo_liquidacion" => "G",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "8",
            "descripcion"          => "H-CATORCENAL FAMILIA (H)",
            "cod_tipo_liquidacion" => "H",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "9",
            "descripcion"          => "I-CATORCENAL",
            "cod_tipo_liquidacion" => "I",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "10",
            "descripcion"          => "J-CATORCENAL JOHNSON",
            "cod_tipo_liquidacion" => "J",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "11",
            "descripcion"          => "K-QUINCENA (ADMINISTRATIVOS)",
            "cod_tipo_liquidacion" => "K",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "12",
            "descripcion"          => "L-QUINCENA (ARREGLO FACTURAS)",
            "cod_tipo_liquidacion" => "L",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "13",
            "descripcion"          => "M-MENSUAL ADMINISTRATIVO",
            "cod_tipo_liquidacion" => "M",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "14",
            "descripcion"          => "N-SUPERNUMERARIO",
            "cod_tipo_liquidacion" => "N",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "15",
            "descripcion"          => "O-QUINCENAL 1 AL 15 Y 16 AL 30 2008",
            "cod_tipo_liquidacion" => "O",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "16",
            "descripcion"          => "P-PRESTACIONES SOCIALES",
            "cod_tipo_liquidacion" => "P",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "17",
            "descripcion"          => "Q-QUINCENAL 1 AL 15 Y 16 AL 30",
            "cod_tipo_liquidacion" => "q",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "18",
            "descripcion"          => "R-QUINCENAL CADBURY AUTOLIQUIDACION",
            "cod_tipo_liquidacion" => "R",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "19",
            "descripcion"          => "S-SEMANAL",
            "cod_tipo_liquidacion" => "S",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "20",
            "descripcion"          => "T-SEMANAL ALCATEC",
            "cod_tipo_liquidacion" => "T",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "21",
            "descripcion"          => "U-QUINCENAL PAGO  10\/25",
            "cod_tipo_liquidacion" => "U",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "22",
            "descripcion"          => "W-DECANAL 1-10 11-20 Y 21-30.",
            "cod_tipo_liquidacion" => "W",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "23",
            "descripcion"          => "TODOS LOS TIPOS DE NOMINA",
            "cod_tipo_liquidacion" => "X",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_liquidaciones')->insert([
            "id"                   => "24",
            "descripcion"          => "RETIRADO HISTORICO",
            "cod_tipo_liquidacion" => "Z",
            "created_at"           => "0000-00-00 00:00:00",
            "updated_at"           => "0000-00-00 00:00:00",
        ]);

    }
}
