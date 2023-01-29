<?php

use Illuminate\Database\Seeder;

class MotivoRequerimientoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('motivo_requerimiento')->insert([
            "id"          => "1",
            "descripcion" => "REEMPLAZO DE PERSONAL",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-02-27 20:43:13",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "2",
            "descripcion" => "LABORES OCASIONALES ACCIDENTALES O TRANSITORIAS",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "3",
            "descripcion" => "REEMPLAZO",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "4",
            "descripcion" => "REEMPLAZAR PERSONAL",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "5",
            "descripcion" => "NO APLICA",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "6",
            "descripcion" => "NUEVO CONTRATO",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "7",
            "descripcion" => "EVENTO DE MERCHANDISING",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "8",
            "descripcion" => "CONTRATACION MASIVA",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "9",
            "descripcion" => "CARGUE TRAYECTORIA",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "10",
            "descripcion" => "CARGUE DESPUES CIERRE 2002",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "11",
            "descripcion" => "CARGUE INICIAL",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

        DB::table('motivo_requerimiento')->insert([
            "id"          => "12",
            "descripcion" => "CARGO NUEVO",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:20",
            "updated_at"  => "2018-03-04 04:13:20",
        ]);

    }
}
