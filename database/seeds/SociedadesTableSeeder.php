<?php

use Illuminate\Database\Seeder;

class SociedadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sociedades')->insert([

            "id"                      => "1",
            "division_empresa_codigo" => "1",
            "division_geren_codigo"   => "2",
            "division_codigo"         => "1",
            "division_nombre"         => "Soluciones",
            "created_at"              => "0000-00-00 00:00:00",
            "updated_at"              => "0000-00-00 00:00:00",

        ]);
    }
}
