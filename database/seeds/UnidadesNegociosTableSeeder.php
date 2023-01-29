<?php

use Illuminate\Database\Seeder;

class UnidadesNegociosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidades_negocios')->insert([
            "id"         => "10",
            "codigo"     => "1",
            "nombre"     => "ASEO Y MANTENIMIENTO",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('unidades_negocios')->insert([
            "id"         => "11",
            "codigo"     => "2",
            "nombre"     => "BPO",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('unidades_negocios')->insert([
            "id"         => "12",
            "codigo"     => "3",
            "nombre"     => "HEAD HUNTER",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('unidades_negocios')->insert([
            "id"         => "13",
            "codigo"     => "4",
            "nombre"     => "SUMINISTRO DE PERSONAL",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

        DB::table('unidades_negocios')->insert([
            "id"         => "14",
            "codigo"     => "5",
            "nombre"     => "TRADE MARKETING",
            "created_at" => "0000-00-00 00:00:00",
            "updated_at" => "0000-00-00 00:00:00",
        ]);

    }
}
