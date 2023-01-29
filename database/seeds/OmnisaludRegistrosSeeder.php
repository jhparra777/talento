<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OmnisaludRegistrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=OmnisaludRegistrosSeeder

        $path = dirname(__DIR__, 1).'/data/omnisalud/omnisalud_registros.sql';

        $h = fopen($path, 'r');

        $content = fread($h, filesize($path));

        DB::unprepared($content);

        fclose($h);
    }
}
