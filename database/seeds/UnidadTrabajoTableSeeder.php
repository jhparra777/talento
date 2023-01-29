<?php

use Illuminate\Database\Seeder;

class UnidadTrabajoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidad_trabajo')->insert([
            "id"          => "1",
            "descripcion" => "ADMINISTRATIVO",
            "estado"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('unidad_trabajo')->insert([
            "id"          => "2",
            "descripcion" => "MERCADEO",
            "estado"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);
        DB::table('unidad_trabajo')->insert([
            "id"          => "3",
            "descripcion" => "FINANCIERO",
            "estado"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);
        DB::table('unidad_trabajo')->insert([
            "id"          => "4",
            "descripcion" => "INDUSTRIA",
            "estado"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);
        DB::table('unidad_trabajo')->insert([
            "id"          => "5",
            "descripcion" => "GENERAL",
            "estado"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);
    }
}
