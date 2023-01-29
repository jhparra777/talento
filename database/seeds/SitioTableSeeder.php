<?php

use Illuminate\Database\Seeder;

class SitioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sitio')->insert([
            "id"          => "0",
            "nombre" => "T3RS",
            "celular"      => "3124571671",
            "telefono"      => "706",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);
    }
}
