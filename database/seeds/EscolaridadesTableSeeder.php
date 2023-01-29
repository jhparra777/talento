<?php

use Illuminate\Database\Seeder;

class EscolaridadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('escolaridades')->insert([
            "id"          => "1",
            "descripcion" => "PRIMARIA",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('escolaridades')->insert([
            "id"          => "2",
            "descripcion" => "BACHILLERATO",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('escolaridades')->insert([
            "id"          => "3",
            "descripcion" => "TÉCNICO",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('escolaridades')->insert([
            "id"          => "4",
            "descripcion" => "TECNÓLOGICO",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('escolaridades')->insert([
            "id"          => "5",
            "descripcion" => "UNIVERSITARIA",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('escolaridades')->insert([
            "id"          => "6",
            "descripcion" => "ESPECIALIZACIÓN",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('escolaridades')->insert([
            "id"          => "7",
            "descripcion" => "MAGÍSTER",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('escolaridades')->insert([
            "id"          => "8",
            "descripcion" => "PHD",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('escolaridades')->insert([
            "id"          => "9",
            "descripcion" => "DOCTORADO",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('escolaridades')->insert([
            "id"          => "10",
            "descripcion" => "DIPLOMADO",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('escolaridades')->insert([
            "id"          => "11",
            "descripcion" => "OTRO",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);
    }
}
