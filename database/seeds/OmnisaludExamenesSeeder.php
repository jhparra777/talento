<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OmnisaludExamenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=OmnisaludExamenesSeeder

        $path = dirname(__DIR__, 1).'/data/omnisalud/omnisalud_examenes_medicos.sql';

        $h = fopen($path, 'r');

        $content = fread($h, filesize($path));

        DB::unprepared($content);

        fclose($h);
    }
}
