<?php

use Illuminate\Database\Seeder;

class TiposSalariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_salarios')->insert([
            "id"          => "1",

            "descripcion" => "MENSUAL",

            "created_at"  => "0000-00-00 00:00:00",

            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_salarios')->insert([
            "id"          => "2",

            "descripcion" => "QUINCENAL",

            "created_at"  => "0000-00-00 00:00:00",

            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_salarios')->insert([
            "id"          => "3",

            "descripcion" => "DIARIO\/JORNAL",

            "created_at"  => "0000-00-00 00:00:00",

            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_salarios')->insert([
            "id"          => "4",

            "descripcion" => "HORAS",

            "created_at"  => "0000-00-00 00:00:00",

            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('tipos_salarios')->insert([
            "id"          => "5",

            "descripcion" => "DESTAJO",

            "created_at"  => "0000-00-00 00:00:00",

            "updated_at"  => "0000-00-00 00:00:00",
        ]);

    }
}
