<?php

use Illuminate\Database\Seeder;

class GerenciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gerencia')->insert([
            "id"                  => "1",
            "descripcion"         => "PRODUCCION",
            "gerencia_emp_codigo" => "1",
            "created_at"          => "0000-00-00 00:00:00",
            "updated_at"          => "0000-00-00 00:00:00",
        ]);

        DB::table('gerencia')->insert([
            "id"                  => "2",
            "descripcion"         => "ADMINISTRATIVOS",
            "gerencia_emp_codigo" => "1",
            "created_at"          => "0000-00-00 00:00:00",
            "updated_at"          => "0000-00-00 00:00:00",
        ]);

    }
}
