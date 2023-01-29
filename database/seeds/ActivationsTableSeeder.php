<?php

use Illuminate\Database\Seeder;

class ActivationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activations')->insert([
            "user_id"   => 1,
            "code"      => "1WTAppqIawInimiUsMzHZ6elv3uXYE41",
            "completed" => 1,
        ]);

        DB::table('activations')->insert([
            "user_id"   => 2,
            "code"      => "1WTAppqIawInimiUsMzHZ6elv3uXYW41",
            "completed" => 1,
        ]);

        DB::table('activations')->insert([
            "user_id"   => 3,
            "code"      => "1WTAppqIawInimiUsMzHZ6Tlv3uXYE41",
            "completed" => 1,
        ]);
    }
}
