<?php

use Illuminate\Database\Seeder;

class TipoPreguntaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('tipo_pregunta')->insert([
            "id"          => "1",
            "descripcion" => "Seleccion multiple con multiple respuesta",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
          DB::table('tipo_pregunta')->insert([
            "id"          => "2",
            "descripcion" => "Seleccion multiple con unica respuesta",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
           DB::table('tipo_pregunta')->insert([
            "id"          => "3",
            "descripcion" => "Abierta",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
    }
}
