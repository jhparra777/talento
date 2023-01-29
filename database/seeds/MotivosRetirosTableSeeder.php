<?php

use Illuminate\Database\Seeder;

class MotivosRetirosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('motivos_retiros')->insert([
            "id"          => "1",
            "descripcion" => "TERMINACIÓN DE CONTRATO",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('motivos_retiros')->insert([
            "id"          => "2",
            "descripcion" => "RENUNCIA VOLUNTARIA",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('motivos_retiros')->insert([
            "id"          => "3",
            "descripcion" => "TERMINACIÓN DE CONTRATO CON JUSTA CAUSA",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('motivos_retiros')->insert([
            "id"          => "4",
            "descripcion" => "TERMINACIÓN DE CONTRATO SIN JUSTA CAUSA",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('motivos_retiros')->insert([
            "id"          => "5",
            "descripcion" => "RETIRO NO NEGATIVO",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

    }
}
