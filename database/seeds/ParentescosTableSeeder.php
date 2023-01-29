<?php

use Illuminate\Database\Seeder;

class ParentescosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('parentescos')->insert([
            "id"          => "1",
            "descripcion" => "MADRE",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('parentescos')->insert([
            "id"          => "2",
            "descripcion" => "PADRE",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('parentescos')->insert([
            "id"          => "3",
            "descripcion" => "HERMANO(A)",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('parentescos')->insert([
            "id"          => "4",
            "descripcion" => "TIO(A)",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('parentescos')->insert([
            "id"          => "5",
            "descripcion" => "ABUELO(A)",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('parentescos')->insert([
            "id"          => "6",
            "descripcion" => "PRIMO(A)",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('parentescos')->insert([
            "id"          => "7",
            "descripcion" => "SOBRINO(A)",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('parentescos')->insert([
            "id"          => "8",
            "descripcion" => "OTRO",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('parentescos')->insert([
            "id"          => "9",
            "descripcion" => "CU\u00d1ADO",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('parentescos')->insert([
            "id"          => "10",
            "descripcion" => "HIJO(A)",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

        DB::table('parentescos')->insert([
            "id"          => "11",
            "descripcion" => "ESPOSO (A)",
            "active"      => "1",
            "created_at"  => "0000-00-00 00:00:00",
            "updated_at"  => "0000-00-00 00:00:00",
        ]);

    }
}
