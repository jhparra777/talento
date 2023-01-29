<?php

use Illuminate\Database\Seeder;

class EntidadesAfpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entidades_afp')->insert([
            "id"          => "1",
            "descripcion" => "BBVA HORIZONTE PENSIONES Y CES",
            "active"      => "1",
            "codigo"      => null,
        ]);

        DB::table('entidades_afp')->insert([
            "id"          => "2",
            "descripcion" => "COLFONDOS S.A.",
            "active"      => "1",
            "codigo"      => null,
        ]);

        DB::table('entidades_afp')->insert([
            "id"          => "3",
            "descripcion" => "COLPENSIONES",
            "active"      => "1",
            "codigo"      => null,
        ]);

        DB::table('entidades_afp')->insert([
            "id"          => "4",
            "descripcion" => "COLPENSIONES - CAJANAL",
            "active"      => "1",
            "codigo"      => null,
        ]);

        DB::table('entidades_afp')->insert([
            "id"          => "5",
            "descripcion" => "PORVENIR S.A.",
            "active"      => "1",
            "codigo"      => null,
        ]);

        DB::table('entidades_afp')->insert([
            "id"          => "6",
            "descripcion" => "PROTECCION S.A.",
            "active"      => "1",
            "codigo"      => null,
        ]);

        DB::table('entidades_afp')->insert([
            "id"          => "7",
            "descripcion" => "SKANDIA",
            "active"      => "1",
            "codigo"      => null,
        ]);

    }
}
