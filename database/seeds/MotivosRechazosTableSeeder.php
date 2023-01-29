<?php

use Illuminate\Database\Seeder;

class MotivosRechazosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('motivos_rechazos')->insert([
            "id"          => "1",
            "descripcion" => "CONCILIACIONES Y/O TRANSACCIONES CONCERTADAS CON TRABAJADORES EN MISION Y AL SERVICIO.",
            "created_at"  => "2017-12-19 19:36:12",
            "updated_at"  => "2017-12-19 19:36:12",
        ]);

        DB::table('motivos_rechazos')->insert([
            "id"          => "2",
            "descripcion" => "DOCUMENTOS FALSOS/ALTERADOS.",
            "created_at"  => "2017-12-19 19:36:41",
            "updated_at"  => "2017-12-19 19:36:41",
        ]);

        DB::table('motivos_rechazos')->insert([
            "id"          => "3",
            "descripcion" => "POLITICAS EMPRESA.",
            "created_at"  => "2017-12-19 19:36:56",
            "updated_at"  => "2017-12-19 19:36:56",
        ]);

        DB::table('motivos_rechazos')->insert([
            "id"          => "4",
            "descripcion" => "REFERENCIA NEGATIVA.",
            "created_at"  => "2017-12-19 19:37:10",
            "updated_at"  => "2017-12-19 19:37:10",
        ]);

        DB::table('motivos_rechazos')->insert([
            "id"          => "5",
            "descripcion" => "REPORTE NEGATIVO DEL CLIENTE.",
            "created_at"  => "2017-12-19 19:37:26",
            "updated_at"  => "2017-12-19 19:37:26",
        ]);

        DB::table('motivos_rechazos')->insert([
            "id"          => "6",
            "descripcion" => "SALDO PENDIENTE DE RECUPERACION.",
            "created_at"  => "2017-12-19 19:37:43",
            "updated_at"  => "2017-12-19 19:37:43",
        ]);

        DB::table('motivos_rechazos')->insert([
            "id"          => "7",
            "descripcion" => "REPORTE CONCEPTO ACTITUD.",
            "created_at"  => "2017-12-19 19:37:57",
            "updated_at"  => "2017-12-19 19:37:57",
        ]);

    }
}
