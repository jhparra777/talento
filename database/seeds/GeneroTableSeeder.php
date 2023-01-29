<?php

use Illuminate\Database\Seeder;

class GeneroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('generos')->insert([
            "descripcion" => "MASCULINO",
            "codigo"      => "MAS",
            "active"      => 1,
        ]);
        DB::table('generos')->insert([
            "descripcion" => "FEMENINO",
            "codigo"      => "FEM",
            "active"      => 1,
        ]);
        DB::table('generos')->insert([
            "descripcion" => "INDIFERENTE",
            "codigo"      => "AMB",
            "active"      => 2,
        ]);
    }
}
