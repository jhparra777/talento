<?php

use Illuminate\Database\Seeder;

class CentrosCostosProduccionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('centros_costos_produccion')->insert([
            "id"                => "1",
            "cod_division"      => "1",
            "cod_depto_negocio" => "1",
            "codigo"            => "1011251111",
            "descripcion"       => "FABRICACION SABORIZADO LIQUIDA",
            "estado"            => "ACT",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);

        DB::table('centros_costos_produccion')->insert([
            "id"                => "2",
            "cod_division"      => "33",
            "cod_depto_negocio" => "1",
            "codigo"            => "1234",
            "descripcion"       => "0",
            "estado"            => "ACT",
            "created_at"        => "0000-00-00 00:00:00",
            "updated_at"        => "0000-00-00 00:00:00",
        ]);

    }
}
