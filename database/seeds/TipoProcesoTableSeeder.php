<?php

use Illuminate\Database\Seeder;

class TipoProcesoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_proceso')->insert([
            "id"          => "1",
            "descripcion" => "SELECCION DE PERSONAL",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
        DB::table('tipo_proceso')->insert([
            "id"          => "2",
            "descripcion" => "RECLUTAMIENTO, SELECCION Y CONTRATACION",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
        DB::table('tipo_proceso')->insert([
            "id"          => "3",
            "descripcion" => "HOJAS DE VIDA",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
        DB::table('tipo_proceso')->insert([
            "id"          => "4",
            "descripcion" => "EVALUACION DE PERSONAL",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
        DB::table('tipo_proceso')->insert([
            "id"          => "5",
            "descripcion" => "EXAMENES MEDICOS",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
        DB::table('tipo_proceso')->insert([
            "id"          => "6",
            "descripcion" => "CONTRATACION",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
        DB::table('tipo_proceso')->insert([
            "id"          => "7",
            "descripcion" => "PROCESO BACKUP",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
        DB::table('tipo_proceso')->insert([
            "id"          => "8",
            "descripcion" => "SELECCION Y CONTRATACION",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);
        DB::table('tipo_proceso')->insert([
            "id"          => "9",
            "descripcion" => "MIGRACION",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

    }
}
