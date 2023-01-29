<?php

use Illuminate\Database\Seeder;

class TiposDocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipos_documentos')->insert([
            "id"          => "1",
            "descripcion" => "CEDULA DE CIUDADANIA",
            "codigo"      => "1",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_documentos')->insert([
            "id"          => "2",
            "descripcion" => "LIBRETA MILITAR",
            "codigo"      => "1",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_documentos')->insert([
            "id"          => "3",
            "descripcion" => "CERTIFICADO LABORAL",
            "codigo"      => "1",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_documentos')->insert([
            "id"          => "4",
            "descripcion" => "CERTIFICADO DE ESTUDIO",
            "codigo"      => "1",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_documentos')->insert([
            "id"          => "5",
            "descripcion" => "OTRO CERTIFICADO",
            "codigo"      => "1",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_documentos')->insert([
            "id"          => "6",
            "descripcion" => "LICENCIA DE CONDUCCI\u00d3N",
            "codigo"      => "1",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_documentos')->insert([
            "id"          => "7",
            "descripcion" => "OTRA LICENCIA",
            "codigo"      => "1",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

    }
}
