<?php

use Illuminate\Database\Seeder;

class TiposJornadasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipos_jornadas')->insert([
            "id"               => "1",

            "descripcion"      => "TIEMPO COMPLETO 8H DIA 48H SEM",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "8",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);

        DB::table('tipos_jornadas')->insert([
            "id"               => "2",

            "descripcion"      => "MEDIO TIEMPO 4H DIA 24H SEM",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "4",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);

        DB::table('tipos_jornadas')->insert([
            "id"               => "4",

            "descripcion"      => "JOR. 2 HRS DIA 12 HRS SEMANA",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "2",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);

        DB::table('tipos_jornadas')->insert([
            "id"               => "5",

            "descripcion"      => "JOR. 6 HRS DIA 36 HRS SEM",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "6",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);

        DB::table('tipos_jornadas')->insert([
            "id"               => "6",

            "descripcion"      => "JOR. 3 HRS DIA 18 HRS SEM",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "3",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);

        DB::table('tipos_jornadas')->insert([
            "id"               => "7",

            "descripcion"      => "JOR. 5 HRS DIA 30 HRS SEM",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "5",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);

        DB::table('tipos_jornadas')->insert([
            "id"               => "8",

            "descripcion"      => "JOR. 6.67 HRS DIA 40.0 HRS SEM",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "7",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);

        DB::table('tipos_jornadas')->insert([
            "id"               => "9",

            "descripcion"      => "JORNADA ESPECIAL",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "1",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);

        DB::table('tipos_jornadas')->insert([
            "id"               => "10",

            "descripcion"      => "JORNADA 6.5 HORAS",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "7",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);
        DB::table('tipos_jornadas')->insert([
            "id"               => "11",

            "descripcion"      => "JORNADA TC 6.4 HORAS",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "6",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);

        DB::table('tipos_jornadas')->insert([
            "id"               => "12",

            "descripcion"      => "JORNADA TC 3.2 HORAS",

            "active"           => "1",

            "hora_inicio"      => "00:00:00",

            "hora_fin"         => "00:00:00",

            "procentaje_horas" => "3",

            "created_at"       => "2018-03-04 04:13:25",

            "updated_at"       => "2018-03-04 04:13:25",

        ]);

    }
}
