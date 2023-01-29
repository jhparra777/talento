<?php

use Illuminate\Database\Seeder;

class PreliminarTransversalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('preliminar_transversales')->insert([
            "id"          => "1",
            "descripcion" => "LIDERAZGO",
            "puntuacion"  => "20",
            "estado"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('preliminar_transversales')->insert([
            "id"          => "2",
            "descripcion" => "INNOVACIÓN",
            "puntuacion"  => "20",
            "estado"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('preliminar_transversales')->insert([
            "id"          => "3",
            "descripcion" => "CARISMA",
            "puntuacion"  => "20",
            "estado"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('preliminar_transversales')->insert([
            "id"          => "4",
            "descripcion" => "TENDENCIA A APRENDIZAJE",
            "puntuacion"  => "10",
            "estado"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('preliminar_transversales')->insert([
            "id"          => "5",
            "descripcion" => "TOMA DE DECISIONES",
            "puntuacion"  => "10",
            "estado"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

    }
}
