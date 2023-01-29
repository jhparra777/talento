<?php

use Illuminate\Database\Seeder;

class TiposContratosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipos_contratos')->insert([
            "id"          => "1",
            "descripcion" => "TERMINO INDEFINIDO",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_contratos')->insert([
            "id"          => "2",
            "descripcion" => "TERMINO FIJO",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_contratos')->insert([
            "id"          => "3",
            "descripcion" => "CONTRATO POR OBRA O LABOR",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_contratos')->insert([
            "id"          => "4",
            "descripcion" => "CONTRATO DE APRENDIZAJE",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_contratos')->insert([
            "id"          => "5",
            "descripcion" => "CONTRATO POR PRESTACION DE SERVICIOS",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_contratos')->insert([
            "id"          => "6",
            "descripcion" => "CONTRATO DE AGENCIA COMERCIAL",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
    }
}
