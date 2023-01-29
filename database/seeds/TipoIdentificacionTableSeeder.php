<?php

use Illuminate\Database\Seeder;

class TipoIdentificacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_identificacion')->insert([
            "descripcion" => "CEDULA DE CIUDADANIA",
            "active"      => 1,

        ]);
        DB::table('tipo_identificacion')->insert([
            "descripcion" => "NUIP",
            "active"      => 1,

        ]);
        DB::table('tipo_identificacion')->insert([
            "descripcion" => "CEDULA DE EXTRANJERIA",
            "active"      => 1,

        ]);
        DB::table('tipo_identificacion')->insert([
            "descripcion" => "TARJETA DE IDENTIDAD",
            "active"      => 1,

        ]);
        DB::table('tipo_identificacion')->insert([
            "descripcion" => "PERMISO ESPECIAL",
            "active"      => 1,

        ]);
        DB::table('tipo_identificacion')->insert([
            "descripcion" => "PASAPORTE",
            "active"      => 1,

        ]);
    }
}
