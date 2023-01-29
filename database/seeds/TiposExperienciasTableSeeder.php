<?php

use Illuminate\Database\Seeder;

class TiposExperienciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_experiencias')->insert([
            "id"          => "1",
            "descripcion" => "SIN EXPERIENCIA",
            "active"      => "1",
            "created_at"  => "2018-02-23 05:00:00",
            "updated_at"  => "2018-02-16 05:00:00",
        ]);

        DB::table('tipos_experiencias')->insert([
            "id"          => "2",
            "descripcion" => "0 MESES A 6 MESES",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_experiencias')->insert([
            "id"          => "3",
            "descripcion" => "DE 6 MESES A 1 AÑO",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_experiencias')->insert([
            "id"          => "4",
            "descripcion" => "DE 1 AÑO A 2 AÑOS",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

        DB::table('tipos_experiencias')->insert([
            "id"          => "5",
            "descripcion" => "MAS DE 2 AÑOS",
            "active"      => "1",
            "created_at"  => "2018-03-04 04:13:25",
            "updated_at"  => "2018-03-04 04:13:25",
        ]);

    }
}
