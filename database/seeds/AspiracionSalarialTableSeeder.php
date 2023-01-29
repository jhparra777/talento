<?php

use Illuminate\Database\Seeder;

class AspiracionSalarialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "1 A 2 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "2 A 3 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "3 A 4 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "4 A 5 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "5 A 6 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "6 A 7 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "7 A 8 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "8 A 9 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "9 A 10 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "10 A 11 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "11 A 12 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "12 A 13 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "13 A 14 SALARIOS MINIMOS MENSUALES",
            "active"      => 1,

        ]);
        DB::table('aspiracion_salarial')->insert([
            "descripcion" => "14 O MÁS SALARIOS MÍNIMOS MENSUALES",
            "active"      => 1,

        ]);
    }
}
