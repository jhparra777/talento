<?php

use Illuminate\Database\Seeder;

class EstadosCivilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estados_civiles')->insert([
            "descripcion" => "SOLTERO",
            "codigo"      => "SOL",
            "active"      => 1,
        ]);
        DB::table('estados_civiles')->insert([
            "descripcion" => "CASADO",
            "codigo"      => "CAS",
            "active"      => 1,
        ]);
        DB::table('estados_civiles')->insert([
            "descripcion" => "UNIÓN LIBRE",
            "codigo"      => "UNL",
            "active"      => 1,
        ]);
        DB::table('estados_civiles')->insert([
            "descripcion" => "SEPARADO",
            "codigo"      => "SEP",
            "active"      => 1,
        ]);
        DB::table('estados_civiles')->insert([
            "descripcion" => "DIVORCIADO",
            "codigo"      => "DIV",
            "active"      => 1,
        ]);
        DB::table('estados_civiles')->insert([
            "descripcion" => "RELIGIOSO",
            "codigo"      => "REL",
            "active"      => 1,
        ]);
        DB::table('estados_civiles')->insert([
            "descripcion" => "INDIFERENTE",
            "codigo"      => "AMB",
            "active"      => 1,
        ]);
        DB::table('estados_civiles')->insert([
            "descripcion" => "SOLTERO",
            "codigo"      => "VIUDO",
            "active"      => 1,
        ]);
    }
}
