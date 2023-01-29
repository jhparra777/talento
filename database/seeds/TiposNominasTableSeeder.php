<?php

use Illuminate\Database\Seeder;

class TiposNominasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipos_nominas')->insert([
            "id"                => "1",
            "descripcion"       => "NORMAL PACTADO",
            "cod_concepto_pago" => "1",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "2",
            "descripcion"       => "INTEGRAL",
            "cod_concepto_pago" => "5",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "3",
            "descripcion"       => "REGIMEN ANTERIOR CESANTIA",
            "cod_concepto_pago" => "48",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "4",
            "descripcion"       => "APRENDIZ SENA ADM",
            "cod_concepto_pago" => "1",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "5",
            "descripcion"       => "PENSIONADOS",
            "cod_concepto_pago" => "1",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "6",
            "descripcion"       => "PRODUCCION X REPORTE",
            "cod_concepto_pago" => "1",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "7",
            "descripcion"       => "DESTAJO",
            "cod_concepto_pago" => "5",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "8",
            "descripcion"       => "REPORTE (EVENTO)",
            "cod_concepto_pago" => "1",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "9",
            "descripcion"       => "PRESTACIÓN DE SERVICIOS",
            "cod_concepto_pago" => "1",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "10",
            "descripcion"       => "APRENDIZ SENA MISION",
            "cod_concepto_pago" => "87",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "11",
            "descripcion"       => "SENA ESTUDIANTES",
            "cod_concepto_pago" => "1",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);
        DB::table('tipos_nominas')->insert([
            "id"                => "12",
            "descripcion"       => "SIN DATOS",
            "cod_concepto_pago" => "0",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);

    }
}
