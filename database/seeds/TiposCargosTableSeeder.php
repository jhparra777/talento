<?php

use Illuminate\Database\Seeder;

class TiposCargosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipos_cargos')->insert([
            "id"              => "1",
            "descripcion"     => "AGRICOLA O DE VETERINARIA",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades AGRICOLA O DE VETERINARIA junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-02-11 07:59:40",
            "updated_at"      => "2018-02-11 07:59:43",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "2",
            "descripcion"     => "ALTOS MANDOS",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de ALTOS MANDOS junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "3",
            "descripcion"     => "DOCENCIA",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de DOCENCIA junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "4",
            "descripcion"     => "MINERÍA E HIDOCARBUROS",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de MINERÍA E HIDOCARBUROS junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "5",
            "descripcion"     => "OPERARIOS",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de OPERARIOS junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "6",
            "descripcion"     => "PROFESIONALES",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de PROFESIONALES junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "7",
            "descripcion"     => "PROFESIONALES DE LA SALUD",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de PROFESIONALES DE LA SALUD junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "8",
            "descripcion"     => "PROFESIONALES ESPECIALIZADOS",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de PROFESIONALES ESPECIALIZADOS junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "9",
            "descripcion"     => "T\u00c9CNICOS",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de T\u00c9CNICOS junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "10",
            "descripcion"     => "TECNOLOGÍA Y WEB",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de PROFESIONALES ESPECIALIZADOS junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "11",
            "descripcion"     => "TECNOLÓGICOS",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de TECNOLÓGICOS junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_cargos')->insert([
            "id"              => "12",
            "descripcion"     => "VENTAS",
            "active"          => "1",
            "texto_categoria" => "Labores concernientes a actividades de VENTAS junto con todas las subdivisiones que pudieran derivarse de esta.",
            "created_at"      => "2018-03-04 04:13:25",
            "updated_at"      => "2018-03-04 04:13:25",

        ]);

    }
}
