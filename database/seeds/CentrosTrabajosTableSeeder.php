<?php

use Illuminate\Database\Seeder;

class CentrosTrabajosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('centros_trabajo')->insert([
            "id"          => "1",
            "nombre_ctra" => "CLASE DE RIESGO I (0.522)",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('centros_trabajo')->insert([
            "id"          => "2",
            "nombre_ctra" => "CLASE DE RIESGO II (1.044)",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('centros_trabajo')->insert([
            "id"          => "3",
            "nombre_ctra" => "CLASE DE RIESGO III (2.436)",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('centros_trabajo')->insert([
            "id"          => "4",
            "nombre_ctra" => "CLASE DE RIESGO IV  (4.350)",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('centros_trabajo')->insert([
            "id"          => "5",
            "nombre_ctra" => "CLASE DE RIESGO V (6.960)",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

    }
}
